<?php

class Shop extends MY_Controller {

	public function __construct() 
	{
		parent::__construct();
		
		// Set some global variables
		$this->current_category = FALSE;
		$this->current_brand = FALSE;
		$this->categories = $this->db->get('shop_categories')->result_object();
		$this->brands = $this->db->get('shop_brands')->result_object();
		$this->countries = $this->db->get('shop_countries')->result_object();
		$this->cart = $this->session->userdata('cart');
	}
	
	public function index() {
		
		$item = new Shop_Item;
		$base_url = shop_url();
		
		$brand = param('brand');
		$this->current_brand = $brand;
		
		if($brand) {
			$base_url .= $brand.'/';
			$_brand = new Shop_Brand;
			$brand = $_brand->find_by_url_name($brand);
			if(! $brand) {
				show_404();
			}
			$item->where('brand_id', $brand->id);
		}
		
		$category = param('category');
		$this->current_category = $category;
		
		if($category) {
			$base_url .= $category.'/';
			$_category = new Shop_Category;
			$category = $_category->find_by_url_name($category);
			if(! $category) {
				show_404();
			}
			$item->where('category_id', $category->id);
		}
		
		$total_rows = $item->count();
		$per_page = setting('shop.per_page', FALSE, 10);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		
		$page = param('page');
		
		if($page == 1)
		{
			$page = 0;
		}
		
		$items = $item->limit($per_page)->order_by('created_at', 'desc')->offset($page)->get();
			
		//Product variations
		foreach($items as $item)
		{
			$query = $this->db->select('id, name, price')
							  ->from('shop_variations')
							  ->where('item_id', $item->id)
							  ->order_by('price', 'asc')
							  ->limit(1)
							  ->get();
							
			if($query->num_rows() != 0)
			{
				$item->from = $query->result();
				$item->from = $item->from[0];
			}
		}
		
		$this->load->view('shop/index', array(
			'items' => $items,
			'brand' => $brand,
			'pagination' => $this->pagination->create_links()
		));
	}
	
    function route(){
        
        $item = param('item');
        if(! $item) {
			show_404();
		}
        
        $page = new Page;
		$page = $page->find_by_url_title($item);
		if($page) {
            $this->load->view('../page_templates/'.$page->template_name, array(
    			'page' => $page
    		));
		}else{
            $this->show_brand($item);
            
		}
    }
    
    
    function show_brand($item_brand){
		
		$item = new Shop_Item;
		$base_url = shop_url();
		
		$brand = $item_brand;
		$this->current_brand = $brand;
		
		if($brand) {
			$base_url .= $brand.'/';
			$_brand = new Shop_Brand;
			$brand = $_brand->find_by_url_name($brand);
			if(! $brand) {
				show_404();
			}
			$item->where('brand_id', $brand->id);
		}
		
		
		
		$total_rows = $item->count();
		$per_page = setting('shop.per_page', FALSE, 10);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		
		$page = 1;
		
		if($page == 1)
		{
			$page = 0;
		}
		
		$items = $item->limit($per_page)->order_by('created_at', 'desc')->offset($page)->get();
			
		//Product variations
		foreach($items as $item)
		{
			$query = $this->db->select('id, name, price')
							  ->from('shop_variations')
							  ->where('item_id', $item->id)
							  ->order_by('price', 'asc')
							  ->limit(1)
							  ->get();
							
			if($query->num_rows() != 0)
			{
				$item->from = $query->result();
				$item->from = $item->from[0];
			}
		}
		
		$this->load->view('shop/index', array(
			'items' => $items,
			'brand' => $brand,
			'pagination' => $this->pagination->create_links()
		));
	}
    
    
    public function show_page() {
		$title = param('title');
		if(! $title) {
			show_404();
		}
		$page = new Page;
		$page = $page->find_by_url_title($title);
		if(! $page) {
			show_404();
		}
		$this->load->view('../page_templates/'.$page->template_name, array(
			'page' => $page
		));
	}
    
    
	public function show() {
		
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$item = new Shop_Item($id);
		if(! $item->exists()) {
			show_404();
		}
	    
	    // Get products from the same category
	    $category_id = (int) $item->category_id;
		$brand_id = (int) $item->brand_id;
	    $related_products = $this->db->select('shop_items.*, (SELECT url_name FROM shop_categories WHERE shop_categories.id = shop_items.category_id) AS category_url_name', FALSE)->from('shop_items')->where('shop_items.category_id', $category_id)->order_by('RAND()', 'DESC')->get()->result_object();

		// Get notification variable
		$notification = FALSE;
		
		if(current_user())
		{
			$notification = (bool) $this->db->from('shop_notifications')->where('user_id', current_user()->id)->where('item_id', $id)->limit(1)->get()->num_rows();
		}
		
		$comment = new Comment();
		$total_rows = $comment->where('resource_id', $item->id)->count();
		$offset = (int) param('page');
		$per_page = setting('comments.posts_per_page', FALSE, 5);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => shop_item_url(param('brand'), param('category'), $id, param('name'), ''),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$comment->limit($per_page)->offset($offset)->order_by('created_at', 'desc');
		$comments = $comment->get();
		
		
		//Multiple prices
		
		//Are there price groups for this item
		// $query = $this->db->get_where('shop_variation_groups', array('item_id' => $item->id), 1, 0);
		
		$groups = false;
		$query  = $this->db->select('group_id')
						  ->from('shop_variations')
						  ->where('item_id', $item->id)
						  ->get();
		
		//If result > 0 then using group
		//best to check if those groups exist
		
		if($query->num_rows() > 0)
		{
			$ids = array();
			
			foreach($query->result() as $row)
			{
				$ids[] = $row->group_id;
			}
			
			$ids = implode(',', $ids);
			
			$query = $this->db->query('SELECT id FROM shop_variation_groups WHERE id IN ('.$ids.')');
			
			$groups = ($query->num_rows() > 0) ? true : false;
		}
		
		
		if($groups)
		{
			$query = $this->db->select('sv.id, sv.name, sv.price, svg.name AS group_name, svg.id AS group_id')
							  ->from('shop_variations sv')
							  ->join('shop_variation_groups svg', 'sv.group_id = svg.id')
							  ->where('sv.item_id', $item->id)
							  ->order_by('sv.price')
							  ->get();
			
			$result = $query->result();
							
			//Get the cheapest product
			$item->price = $result[0]->price;
			
			$groups = array();
			$last_group   = '';
			
			foreach($result as $row)
			{
				$index      = ($last_group == '' || $row->group_name != $last_group) ? $row->group_name : $last_group;
				$last_group = $row->group_name;
				
				$groups[$index][] = $row;
			}
			
			$item->groups = $groups;
		}
		else
		{
			//Check if there are any product variations
			$query = $this->db->select('id, name, price')
							  ->from('shop_variations')
							  ->where('item_id', $item->id)
							  ->order_by('price', 'asc')
							  ->get();

			if($query->num_rows() > 0)
			{
				$item->variations = $query->result();
			}
		}
		
		// Pull meta to shop items
		$query_meta = $this->db->select('id, subscription_info, download_info, additional_info')
							  ->from('shop_meta')
							  ->where('item_id', $item->id)
							  ->get();

		if($query_meta->num_rows() > 0)
			{
				$item->meta = $query_meta->result();
		}
        
        $offers = array();
        $query_offers = $this->db->select('id, item_id, type, custom_type, amount, desc, updated_at', true)
                        ->from('shop_offers')
                        ->where('item_id', $item->id)
                        ->where('type', 'custom')                        
                        ->get();
        $offers = $query_offers->result();
                        
                                                                                
        if($query_offers->num_rows()>0){
            $offer_ids = $query_offers->result();
            foreach($offer_ids as $o_id){
                $query = "select x.id from shop_offer_codes x where x.id_shop_offer=$o_id->id and x.start<=".time()." and x.end>=".time()."";
                                
                                                
                $query_offer_code = $this->db->query($query, true);
                /*select('id')
                                         ->from('shop_offer_codes')
                                         ->where("id_shop_offer",$o_id->id)
                                         ->where('start <=', time())
                                         ->where('end >=', time())                                         
                                         ->get();*/
                if($query_offer_code->num_rows()>0){
                    foreach($query_offer_code->result() as $code){
                        $offers[] = $o_id;
                    }
                    
                }
            }
        }                                            
					

		$this->load->view('shop/show', array(
			'item' => $item,
            'offers' => $offers,            
			'related_products'	=> $related_products,
			'notification'	=> $notification,
			'comments' => $comments,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	/**
	* Save notification request
	*
	* @access	public
	* @return	void
	*/
	public function notify()
	{
		// Redirect non-logged in users
		if( ! current_user())
		{
			redirect('/', 'refresh');
		}
		
		$item_id = (int) param('item_id');
		
		// Get the item data from the DB
		$item = new Shop_Item($item_id);
		
		if( ! $item->exists()) 
		{
			// Item with this ID does not exist
			show_404();
		}
		
		// Redirect if item is in stock
		if($item->stock > 0)
		{
			redirect(shop_item_url($item->brand->url_name, $item->category->url_name, $item->id, $item->url_name));
		}
		
		$notification = (bool) $this->db->from('shop_notifications')->where('user_id', current_user()->id)->where('item_id', $item->id)->limit(1)->get()->num_rows();
		
		if( ! $notification)
		{
			// Insert notification request to the database
			$this->db->insert('shop_notifications', array
			(
				'user_id'		=> current_user()->id,
				'item_id'		=> $item_id,
				'created_at'	=> time()
			));
			
			// Send the private message
					$subject = $item->name . ' is out of stock.';
					$content = 'Hello! You have requested a notification for when ' . $item->name . ' comes back into stock. We have received this request and will get back to you as soon as possible.';
					
					$this->db->insert('private_messages', array
					(
						'sender_id'		=> 1,
						'receiver_id'	=> current_user()->user_id,
						'folder'		=> 'incoming',
						'subject'		=> $subject,
						'content'		=> $content,
						'created_at'	=> time(),
						'is_read'		=> 0
					));
		}
		
		// Redirect back to the same product
		redirect(shop_item_url($item->brand->url_name, $item->category->url_name, $item->id, $item->url_name));
	}
	
	/**
	* Pay processor
	*
	* @access	public
	* @return	void
	*/
	public function init_pay()
	{
		// Check if cart is not empty
		if(count($this->cart) == 0)
		{
			// Empty cart, nothing to do here
			redirect('/shop', 'refresh');
		}
		
		// Redirect anonymous users to login
		if( ! current_user())
		{
			redirect('/login', 'refresh');
		}
		
		// Set common variables
		$payment_method = (string) trim($this->input->post('payment_method'));
	
		// Store shipping details to array if 
		// at least one product is not digital
		$shipping_details = array();
		
		if($this->input->post('shipping_details'))
		{
			$shipping_details['full_name'] = $this->input->post('full_name');
			$shipping_details['house_number'] = $this->input->post('house_number');
			$shipping_details['street'] = $this->input->post('street');
			$shipping_details['address_2nd'] = $this->input->post('address_2nd');
			$shipping_details['city'] = $this->input->post('city');
			$shipping_details['county'] = $this->input->post('county');
			$shipping_details['postal_code'] = $this->input->post('postal_code');
			$shipping_details['country_id'] = (int) $this->input->post('country');
			
			// Kick-off validation for empty fields
			$required_fields = array('full_name', 'house_number', 'street', 'city', 'postal_code');
			
			foreach($required_fields as $field)
			{
				if(empty($shipping_details[$field]))
				{
					redirect('/shop', 'refresh');
				}
			}
		}
		
		// Count total price
		$total_price = 0;
		$total_products_count = 0;
		foreach($this->cart as $product)
		{
			$total_price = $total_price + ($product['quantity'] * $product['price']);
            $total_products_count += $product['quantity'];                        
		}
        
		if($this->input->post('shipping_details'))
		{
			// Add postage cost to total price 
			// if there is non-digital items
			$country = $this->db->from('shop_countries')->where('id', $shipping_details['country_id'])->get()->row();
			$postage = (float) $country->postage;
            
            // add postage cost for each product
			$total_price = $total_price + ($postage*$total_products_count);
            //$total_price = $total_price + $postage;
		}
        
                
		
		// Set some order variables and save to the database
		$this->db->insert('orders', array
		(
			'user_id'			=> current_user()->id,
			'created_at'		=> time(),
			'total_price'		=> $total_price,
			'shipping_details'	=> serialize($shipping_details),
			'payment_method'	=> $payment_method
		));
		$order_id = $this->db->insert_id();
		
		// Insert all the cart content to the database
		foreach($this->cart as $product)
		{
			$this->db->insert('order_cart', array
			(
				'order_id'	=> $order_id,
				'item_id'	=> $product['item_id'],
				'quantity'	=> $product['quantity'],
				'price'		=> $product['price']
			));
		}
		
		// Unset cart session, it is not required anymore
		$this->session->unset_userdata('cart');
		
		// Proceed payment & switch by method
		switch($payment_method)
		{
			case 'paypal':
                // PayPal
				$this->load->library('Paypal');
				
				$this->paypal->add_field('business', setting('orders.paypal_email'));
				$this->paypal->add_field('return', site_url(success_payment_url()));
				$this->paypal->add_field('cancel_return', site_url(cancel_payment_url()));
				$this->paypal->add_field('notify_url', site_url('payments/ipn/paypal'));
				$this->paypal->add_field('currency_code', setting('orders.currency'));
				$this->paypal->add_field('item_name', 'Order #' . $order_id . ' at DigiStore (www.team-dignitas.net)');
				$this->paypal->add_field('item_number', $order_id);  
				$this->paypal->add_field('amount', $total_price);
				$this->paypal->add_field('custom', current_user()->id);
		
				$this->load->view('shop/' . $payment_method, array
				(
					'data' => $this->paypal->data()
				));
				
			break;
			
			case 'sagepay':
			
				// Sagepay
				$this->load->library('sagepay_form');
				
				$vendor_tx_code = $this->sagepay_form->create_vendor_tx_code();
				$this->sagepay_form->set_field('total', $total_price);
				$this->sagepay_form->set_field('description', 'Order #' . $order_id );
				$this->sagepay_form->set_field('success_url', success_payment_url());
				$this->sagepay_form->set_field('failure_url', cancel_payment_url());
				$this->sagepay_form->set_field('currency', setting('orders.currency'));
				
				$this->sagepay_form->set_field('billing_first_names', cancel_payment_url());
				
				
/* 				$shipping_details['country_id'] = (int) $this->input->post('country'); */
				
				$first_name = explode(' ', $this->input->post('full_name'));
				$first_name = $first_name[0];
				$last_name  = $first_name[1];
				
				$address_1  = $this->input->post('house_number').' ';
				$address_1 .= $this->input->post('street');
				$address_1  = trim($address_1);
								
				$this->sagepay_form->set_field('billing_first_names', $first_name);
				$this->sagepay_form->set_field('billing_surname', $last_name);
				$this->sagepay_form->set_field('billing_address1', $address_1);
				$this->sagepay_form->set_field('biling_address2', $this->input->post('address_2nd'));
				$this->sagepay_form->set_field('billing_city', $this->input->post('city'));
				$this->sagepay_form->set_field('billing_postcode', $this->input->post('postal_code'));
				$this->sagepay_form->set_field('billing_country', 'GB');
				
				$this->sagepay_form->set_same_delivery_address();
				
				//$this->sagepay_form->set_field('billing_state', 'Devon');
				//$this->sagepay_form->set_field('billing_phone', '07595739716');
				
				
				$this->load->view('shop/sagepay', array
				(
					$data['sagepay_form'] = $this->sagepay_form->form()
					
				));
			
			break;
			
			default:
			
				// Unknow payment method, redirect
				redirect('/shop', 'refresh');
		}
	}
	
	/**
	* Checkout page
	*
	* @access	public
	* @return	parsed view
	*/
	public function checkout()
	{
		// Check how much items user has in his cart
		if(count($this->cart) == 0)
		{
			// Empty cart, nothing to do here
			redirect('/shop', 'refresh');
		}
		
		// Load view
		$this->load->view('shop/checkout', array
		(
			
		));
	}
	
	/**
	* Add item to shopping cart
	*
	* @access	public
	* @return	void
	*/
	public function cart_add()
	{
		//Check if variation
		if(param('item_id') == 'variation')
		{
			$details = $this->uri->segment(4);
			$details = explode('_', $details);
			
			$var_id   = (int)$details[0];
			
			//Get details of variation
			$query  = $this->db->select('item_id, price')->from('shop_variations')->where('id', $var_id)->get();
			$result = $query->row();
			
			$item_id  = $result->item_id;
			$quantity = (int)$details[1];
			$quantity = ($quantity == 0) ? 1 : $quantity;
			
			//Variation price
			$var_price = $result->price;
		}
		else
		{
			$item_id = (int) param('item_id');
			$quantity = (int) param('quantity');
			$quantity = ($quantity == 0) ? 1 : $quantity;
		}
        
        
        
        // apply offers
        $offer_code = param('offer_code');
        $offer_code = substr($offer_code, 1);
        
        $offer=false;
        $code = false;
        $query_offers = $this->db->select('id, item_id, type, custom_type, amount, desc, updated_at', true)->from('shop_offers')->where('item_id', $item_id)->get();
        if($query_offers->num_rows()>0){
            $offer_ids = $query_offers->result();
            foreach($offer_ids as $o_id){
                //echo $o_id->item_id;
                $query_offer_code = $this->db->select('id, id_shop_offer, code, start, end')->from('shop_offer_codes')->where("id_shop_offer",$o_id->id)->where('code', $offer_code)->get();
                if($query_offer_code->num_rows()>0){
                    foreach($query_offer_code->result() as $code){
                        $offer = $o_id;
                        $the_offer_code = $code;
                    }
                    
                }
            }
        }
        
                                                        
		
		// Get the item data from the DB
		$item = new Shop_Item($item_id);
		
		if( ! $item->exists()) 
		{
			// Item with this ID does not exist
			show_404();
		}
		
		// Redirect if item is out of stock
		if($item->stock == 0)
		{
			redirect(shop_item_url($item->brand->url_name, $item->category->url_name, $item->id, $item->url_name));
		}
		
		// If item is not digital, check if desired 
		// quantity is not bigger than stock levels
		if($item->digital == 1 && $item->stock > $quantity)
		{
			// Set quantity to stock levels
			$quantity = $item->stock;
		}
		
		// Get user cart from session
		$cart = $this->session->userdata('cart');
		
		if( ! $cart)
		{
			// No cart at the moment
			$cart = array();
		}
		
		// Delete if such item already exists
		if(isset($cart[$item_id]))
		{
			unset($cart[$item_id]);
		}
		
		// Add this item to the cart
		$cart[$item_id] = array
		(
			'item_id'	=> $item_id,
			'item_url'	=> shop_item_url($item->brand->url_name, $item->category->url_name, $item->id, $item->url_name),
			'quantity'	=> $quantity,
			'name'		=> $item->name,
			'price'		=> $item->price,
			'digital'	=> $item->digital
		);
		
		//If variation override price
		if(isset($var_price))
		{
			$cart[$item_id]['price'] = $var_price;
		}
        
        
        // calculating new price with offer discount                
        if($offer && $code){
            $precio = $cart[$item_id]['price'];
            $cant = $cart[$item_id]['quantity'];
            
            if($offer->type == 'percent'){                
                $precio = $precio - ($precio * ($offer->amount/100));                                                
             
                                     
            if($offer->type == 'fixed'){                                
                $precio = (int)$precio - $offer->amount;
                //$precio = $precio * $cant;                
            }
            
            
            $cart[$item_id]['price'] = $precio;} 
         
        }
		
		$this->session->unset_userdata('cart');
		$this->session->set_userdata('cart', $cart);
		
		// Redirect back to item
		redirect(shop_item_url($item->brand->url_name, $item->category->url_name, $item->id, $item->url_name));
	}
	
	/**
	* Remove item from the cart
	*
	* @access	public
	* @return	void
	*/
	public function cart_remove()
	{
		$item_id = (int) param('item_id');
		
		// Get the item data from the DB
		$item = new Shop_Item($item_id);
		
		if( ! $item->exists()) 
		{
			// Item with this ID does not exist
			show_404();
		}
		
		// Get cart from the session data
		$cart = $this->session->userdata('cart');
		
		if( ! $cart)
		{
			// No cart, nothing to change
			redirect('/shop');
		}
		
		// Check if item exists in the cart
		if(array_key_exists($item_id, $cart))
		{
			// Change the quantity
			unset($cart[$item_id]);
		}
		
		// Update the data in the session
		$this->session->unset_userdata('cart');
		$this->session->set_userdata('cart', $cart);
		
		// Redirect back to item
		redirect(shop_item_url($item->brand->url_name, $item->category->url_name, $item->id, $item->url_name));
	}
	
	/**
	* Process some cart action, update or buy
	*
	* @access	public
	* @return 	void
	*/
	public function cart_process()
	{
		// Define action
		$action = 'buy';
		
		if($this->input->post('update'))
		{
			$action = 'update';
		}
		
		// Switch process by action
		switch($action)
		{
			case 'update':
			
				// Go throught cart and change quantities
				$cart = $this->cart;
				
				if( ! empty($cart))
				{
					foreach($cart as $product)
					{
						if($this->input->post('quantity_' . $product['item_id']))
						{
							$cart[$product['item_id']]['quantity'] = (int) $this->input->post('quantity_' . $product['item_id']);
						}
					}
				}
				
				// Update the data in the session
				$this->session->unset_userdata('cart');
				$this->session->set_userdata('cart', $cart);
			
			break;
		}
		
		// Redirect back to shop
		redirect('/shop/checkout');
	}
    
    
    /**
	* asdfsdf
	*
	* @access	public
	* @return	void
	*/
    public function shop_test(){
        
    }
		

}
