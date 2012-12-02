<?php

class Shop_Items extends Admin_Controller {


	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$item = new Shop_Item;
		$base_url = '/admin/shop_items/index/';
		$category_id = param('category_id');
		if($category_id) {
			$base_url .= 'category_id/'.$category_id.'/';
			$item->where('category_id', $category_id);
		}
		$brand_id = param('brand_id');
		if($brand_id) {
			$base_url .= 'brand_id/'.$brand_id.'/';
			$item->where('brand_id', $brand_id);
		}
		$total_rows = $item->count();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'total_rows' => $total_rows,
			'base_url' => $base_url.'page/',
			'per_page' => 10,
			'uri_segment' => 'page',
			'full_tag_open' => '<ul>',
			'full_tag_close' => '</ul>',
			'first_link' => '',
			'last_link' => '',
			'previous_link' => '',
			'next_link' => '',
			'cur_tag_open' => '<li class="active">',
			'cur_tag_close' => '</li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>'
		));
		
		$items = $item->limit(10)->offset((int) param('page'))->order_by('created_at', 'desc')->get();
		
		//Check for multiple prices
		foreach($items as $item)
		{
			$query = $this->db->select('price')
							  ->from('shop_variations')
							  ->where('item_id', $item->id)
							  ->order_by('price', 'asc')
							  ->limit(1)
							  ->get();
			
			if($query->num_rows() > 0)
			{
				//Product has multiple prices
				//select the cheapest price
				$row = $query->row();
				$item->from = $row->price;
			}
		}
		
		$this->load->view('shop_items/index', array(
			'items' => $items,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function add() {
		
		$category = new Shop_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		$brand = new Shop_Brand;
		$brands = array();
		foreach($brand->get() as $item) {
			$brands[$item->id] = $item->name;
		}
		$group = new Shop_Price_Group;
		$groups = array();
		foreach($group->get() as $item) { 
			$groups[$item->id] = $item->name;
		}
		
		$_meta = $this->db->get('shop_meta')->result_object();
		$meta = array();
		foreach($_meta[0] as $key=>$value) {
			if(! in_array($key, array('id', 'item_id'))) {
				$meta[$key] = $value;
			}
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'jquery.tools.min', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8');
		$this->load->view('shop_items/add', array(
			'categories' => $categories,
			'brands' => $brands,
			'groups' => $groups,
			'meta' => $meta
		));
	}
	
	public function create() {
	   
		
		$item = new Shop_Item;
		
		if($this->input->post('variation'))
		{
			//This is a hack to get multiple prices going
			//@todo Improve how we are doing this
			$item->validation = array(
				array(
					'field' => 'category_id',
					'label' => 'Category ID',
					'rules' => 'required|integer'
				),
				array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'required'
				)
			);
			
			$prices      = $this->input->post('validation');
			$item->price = 0;
			
			//Validate the variation names/prices
			for($i = 0; $i < count($prices); $i++)
			{
				$k = $i+1;
				
				if(strlen(trim($prices[$i]['name'])) == 0) {
					$item->errors[] = 'The Price '.$k.' Name field is required';
				}
				
				if(!is_numeric($prices[$i]['price']) || $prices[$i]['price'] == 0.00) {
					$item->errors[] = 'The Price '.$k.' field is required';
				}
				
				if(strlen(trim($prices[$i]['group_id'])) == 0) {
					$item->errors[] = 'The Price '.$k.' Name field is required';
				}

			}
			
		}
		else
		{
			$item->price = (float) $this->input->post('price');
		}
		
		$item->category_id = $this->input->post('category_id');
		$item->brand_id = $this->input->post('brand_id');
		$item->description = $this->input->post('description');
		$item->specification = $this->input->post('specification');
		$item->name = $this->input->post('name');
		$item->stock = (int) $this->input->post('stock');
		$item->digital = (int) $this->input->post('digital');
		$item->language = (int) $this->input->post('language');
		
		$release_date = $this->input->post('release_date');
		if($release_date) {
			list($date, $time) = explode(' ', $release_date);
			list($hours, $minutes) = explode(':', $time);
			list($date, $month, $year) = explode('-', $date);
			$item->release_date = mktime($hours, $minutes, 0, $month, $date, $year);
		}
		
		if($item->save() == FALSE) {
			flash('errors', $item->errors);
			redirect('admin/shop_items/add');
			return;
		}
		
		//We any variations to the prices entered
		if($this->input->post('variation'))
		{
			foreach($this->input->post('variation') as $variation)
			{
				$data = array(
				   'item_id'     => $item->id,
					'name'       => $variation['name'],
					'price'      => $variation['price'],
					'group_id'   => $variation['group_id'],
					'created_at' => time(),
					'updated_at' => time()
				);

				$this->db->insert('shop_variations', $data);
			}
		}
        
        //Wen any offers entered
		if($this->input->post('offer'))
		{
			foreach($this->input->post('offer') as $offer)
			{
				$data = array(
				   'item_id'     => $item->id,
					'type'       => $offer['type'],
                    'custom_type'=> $offer['custom'],
                    'amount'     => $offer['amount'],
                    'desc'       => $offer['desc'],
					'updated_at' => time()
				);
				$this->db->insert('shop_offers', $data);
                $offer_id = $this->db->insert_id();
                
                foreach($offer['code'] as $offer_code){
                    $start = '';
                    if($offer_code['start']!='') $start = strtotime($offer_code['start']);
                    $end = '';
                    if($offer_code['end']!='') $end = strtotime($offer_code['end']);
                    $data_code = array(
    				    'id_shop_offer' => $offer_id,
    					'code'          => $offer_code['code'],
                        'start'         => $start,
                        'end'           => $end
    				);
    				$this->db->insert('shop_offer_codes', $data_code);
                }
			}
		}
		
		$this->db->set('item_id', $item->id);
		$this->db->insert('shop_meta', $this->input->post('meta'));
		
		redirect('admin/shop_items/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		
		$category = new Shop_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		
		$brand = new Shop_Brand;
		$brands = array();
		foreach($brand->get() as $item) {
			$brands[$item->id] = $item->name;
		}
		
		$item = new Shop_Item($id);
		if(! $item->exists()) {
			show_404();
		}
		
		$_meta = $this->db->where('item_id', $id)->limit(1)->get('shop_meta')->result_object();
		$meta = array();
		foreach($_meta[0] as $key=>$value) {
			if(! in_array($key, array('id', 'item_id'))) {
				$meta[$key] = $value;
			}
		}
		
		// Count how much times this item was sold before
		$this->load->database();
		$products = $this->db->from('order_cart')->where('item_id', $id)->join('orders', 'orders.id = order_cart.order_id AND orders.paid = 1', 'right')->get()->result_array();
		$times_sold = 0;
		
		if(count($products) > 0)
		{
			foreach($products as $product)
			{
				$times_sold = $times_sold + $product['quantity'];
			}
		}
		
		
		 //Check for variations 
		    
			$variations = array(); 
	        $query      = $this->db->select('id, name, price, group_id') 
		                               ->from('shop_variations') 
		                               ->where('item_id', $id) 
		                               ->order_by('price', 'asc') 
		                               ->get(); 
 	         
	        foreach($query->result() as $row) 
 	        { 
	            $variations[] = $row; 
	        }
        
        // check for offers
        $offers = array();
		$query2      = $this->db->select('id, type, custom_type, amount, desc, updated_at')
		                       ->from('shop_offers')
		                       ->where('item_id', $id)->get();
		
		foreach($query2->result() as $row_offer)
		{
			$row_offer->codes = array();
            $query_codes = $this->db->select('id, code, start, end')
		                       ->from('shop_offer_codes')
		                       ->where('id_shop_offer', $row_offer->id)->get();
            foreach($query_codes->result() as $row_code){
                $start = $row_code->start;
                $start = date("d-m-Y h:i", $start);
                $end = $row_code->end;
                $end = date("d-m-Y h:i", $end);
                $row_code->start = $start;
                $row_code->end = $end;
                $row_offer->codes[] = $row_code;
            }
            $offers[] = $row_offer;
		}
        
        
        
		
		$this->layout->js = array('jquery-1.5.1.min', 'jquery.tools.min', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8');
		$this->load->view('shop_items/edit', array(
			'variations' => $variations,
            'offers' => $offers,
			'meta' => $meta,
			'categories' => $categories,
			'brands' => $brands,
			'item' => $item,
			'times_sold' => $times_sold
		));
	}
	
	public function update() {
	
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Shop Item ID');
		}
		$item = new Shop_Item($id);
		if(! $item->exists()) {
			show_404();
		}
		
		if($this->input->post('variation'))
		{
			//This is a hack to get multiple prices going
			//@todo Improve how we are doing this
			$item->validation = array(
				array(
					'field' => 'category_id',
					'label' => 'Category ID',
					'rules' => 'required|integer'
				),
				array(
					'field' => 'name',
					'label' => 'Name',
					'rules' => 'required'
				)
			);
			
			$prices      = $this->input->post('validation');
			$item->price = 0;
			
			//Validate the variation names/prices
			for($i = 0; $i < count($prices); $i++)
			{
				$k = $i+1;
				
				if(strlen(trim($prices[$i]['name'])) == 0) {
					$item->errors[] = 'The Price '.$k.' Name field is required';
				}
				
				if(!is_numeric($prices[$i]['price']) || $prices[$i]['price'] == 0.00) {
					$item->errors[] = 'The Price '.$k.' field is required';
				}
				
				if(strlen(trim($prices[$i]['group_id'])) == 0) {
					$item->errors[] = 'The Price '.$k.' Name field is required';
				}
			}
			
		}
		else
		{
			$item->price = (float) $this->input->post('price');
		}
		
		$item->category_id = $this->input->post('category_id');
		$item->brand_id = $this->input->post('brand_id');
		$item->description = $this->input->post('description');
		$item->specification = $this->input->post('specification');
		$item->name = $this->input->post('name');
		$item->stock = (int) $this->input->post('stock');
		$item->digital = (int) $this->input->post('digital');
		$item->language = (int) $this->input->post('language');
		
		$release_date = $this->input->post('release_date');
		if($release_date) {
			list($date, $time) = explode(' ', $release_date);
			list($hours, $minutes) = explode(':', $time);
			list($date, $month, $year) = explode('-', $date);
			$item->release_date = mktime($hours, $minutes, 0, $month, $date, $year);
		}
		
		if($item->save() == FALSE) {
			flash('errors', $item->errors);
		}
		
		
		//We any variations to the prices entered
		if($this->input->post('variation'))
		{
			//Remove existing variations before entering them again
			$this->db->where('item_id', $id)->delete('shop_variations');
			
			foreach($this->input->post('variation') as $variation)
			{
				$data = array(
				   'item_id'     => $id,
					'name'       => $variation['name'],
					'price'      => $variation['price'],
					'group_id'	 => $variation['group_id'],
					'created_at' => time(),
					'updated_at' => time()
				);

				$this->db->insert('shop_variations', $data);
			}
		}
		
        
        //Wen any offers entered
		if($this->input->post('offer'))
		{
			foreach($this->input->post('offer') as $offer)
			{
                $data = array(
				   'item_id'     => $item->id,
					'type'       => $offer['type'],
                    'custom_type'=> $offer['custom'],
                    'amount'     => $offer['amount'],
                    'desc'       => $offer['desc'],
					'updated_at' => time()
				);
                if(!empty($offer['id'])){
                    $this->db->where("id", $offer['id']);
                    $this->db->update('shop_offers', $data);
                    $offer_id = $offer['id'];
                }else{
                    $this->db->insert('shop_offers', $data);
                    $offer_id = $this->db->insert_id();
                }
                
                foreach($offer['code'] as $offer_code){
                    $start = '';
                    if($offer_code['start']!='') $start = strtotime($offer_code['start']);
                    $end = '';
                    if($offer_code['end']!='') $end = strtotime($offer_code['end']);
                    $data_code = array(
    				    'id_shop_offer' => $offer_id,
    					'code'          => $offer_code['code'],
                        'start'         => $start,
                        'end'           => $end
    				);
                    
                    if(!empty($offer_code['id'])){
                        $this->db->where("id", $offer_code['id']);
                        $this->db->update('shop_offer_codes', $data_code);
                    }else{
                        $this->db->insert('shop_offer_codes', $data_code);
                    }
                }
			}
		}
        
        if($this->input->post('offer_code_del')){
            foreach($this->input->post('offer_code_del') as $del_offer_code){
                $this->db->where("id", $del_offer_code);
                $this->db->delete('shop_offer_codes');
            }
        }
        if($this->input->post('offer_del')){
            foreach($this->input->post('offer_del') as $del_offer){
                $this->db->where("id", $del_offer);
                $this->db->delete('shop_offers');
            }
        }
        
        
         
		
		$this->db->where('item_id', $id)->update('shop_meta', $this->input->post('meta'));
		
		// Send notifications for the users if needed
		$stock_new = (int) $this->input->post('stock');
		$stock_old = (int) $this->input->post('stock_old');
		
		if($stock_old == 0 && $stock_new > 0)
		{
			$notifications = $this->db->from('shop_notifications')->where('item_id', $id)->get()->result_object();
			
			if($notifications)
			{
				// Send notifications via PM
				foreach($notifications as $notification)
				{
					// Get item data
					$item = $this->db->from('shop_items')->where('id', $notification->item_id)->limit(1)->get()->row();
				
					// Send the private message
					$subject = $item->name . ' is again on stock';
					$content = 'Hello! You have requested a notification about the stock levels of ' . $item->name . '. We are happy to tell you that this product is now in stock.';
					
					$this->db->insert('private_messages', array
					(
						'sender_id'		=> 1,
						'receiver_id'	=> $notification->user_id,
						'folder'		=> 'incoming',
						'subject'		=> $subject,
						'content'		=> $content,
						'created_at'	=> time(),
						'is_read'		=> 0
					));
					
					// Delete notification
					$this->db->delete('shop_notifications', 'id = ' . $notification->id);
				}
			}
		}
		
        
        
		redirect('admin/shop_items/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$item = new Shop_Item($id);
		if(! $item->exists()) {
			show_404();
		}
		$item->remove();
		redirect('admin/shop_items/index');
	}
	
	// Additional Product Fields
	public function columns() {
		$result = $this->db->simple_query('DESCRIBE `shop_meta`');
		$columns = array();
		while($data = mysql_fetch_object($result)) {
			if(! in_array($data->Field, array('id', 'item_id'))) {
				if(strpos($data->Type, 'int') === 0) {
					$type = 'integer';
				} elseif($data->Type == 'varchar') {
					$type = 'varchar';
				} elseif($data->Type == 'char') {
					$type = 'char';
				} elseif($data->Type == 'text') {
					$type = 'text';
				} else { $type = 'unknown'; }
				$columns[] = array('column' => $data->Field, 'type' => $type);
			}
		}
		$this->layout->js = array('jquery-1.5.1.min', 'shop_items.columns');
		$this->load->view('shop_items/columns', array(
			'columns' => $columns
		));
	}
	
	public function create_column() {
		$column = underscore($this->input->post('column'));
		$type = $this->input->post('type');
		$this->load->dbforge();
		$data = array(
			'type' => $type
		);
		if(in_array(strtolower($type), array('varchar', 'char'))) {
			$data['constraint'] = 255;
		} 
		$this->dbforge->add_column('shop_meta', array($column => $data));
		redirect('admin/shop_items/columns');
	}
	
	public function remove_column() {
		$column = param('column');
		$this->load->dbforge();
		$this->dbforge->drop_column('shop_meta', $column);
		redirect('admin/shop_items/columns');
	}

}
