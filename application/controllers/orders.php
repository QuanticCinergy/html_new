<?php

class Orders extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		// Set some global variables
		$this->current_category = FALSE;
		$this->current_brand = FALSE;
		$this->categories = $this->db->get('shop_categories')->result_object();
		$this->brands = $this->db->get('shop_brands')->result_object();
		$this->countries = $this->db->get('shop_countries')->result_object();
		$this->cart = $this->session->userdata('cart');
	}
	
	/**
	* Instant payment notification
	*
	* @access	public
	* @return	mixed
	*/
	public function ipn() 
	{
		$payment_method = (string) trim(param('method'));
	
		// Switch IPN actions by payment method
		switch($payment_method)
		{
			case 'paypal':
			
				// Paypal
				$this->load->library('Paypal');
				
				if($this->paypal->validate_ipn())
				{
					$order_id = (int) $this->input->post('item_number');
					$user_id = (int) $this->input->post('user_id');
					
					// Set order as paid
					$this->db->update('orders', array('orders.paid' => 1), 'orders.id = "' . $order_id . '" AND orders.user_id = "' . $user_id . '"');
				
					// Decrease stock levels
					$this->decrease_stock($order_id);
				}
			
			break;
			
			case 'sagepay':
			
				// Sagepay
				$this->load->library('sagepay_form');
				
				$crypt = $_GET["crypt"];
				$decoded_response = $this->sagepay_form->decode_crypt($crypt);
				$response_array = $this->sagepay_form->getToken($decoded_response);
				
				// @TODO: to finish this one later!
			
			break;
			
			default:
			
				// Unknown payment method, redirect
				redirect('/', 'refresh');
		}
		
		exit();
	}
	
	/**
	* Decrease stock levels
	*
	* @access	public
	* @return	void
	*/
	public function decrease_stock($order_id)
	{
		$order_cart = $this->from('order_cart')->where('order_cart.order_id', $order_id)->get()->result_object();
		
		foreach($order_cart as $item)
		{
			// Get shop product
			$product = $this->db->from('shop_items')->where('shop_items.id', $item->item_id)->get()->row();
			
			if($product->stock > 0)
			{
				// Decrease stock levels
				$stock = (int) ($product->stock - 1);
				
				$this->db->update('shop_items', array('shop_items.stock' => 1), 'shop_items.id = "' . $item->item_id . '"');
			}
		}
		
		return TRUE;
	}
	
	/**
	* Successful payment
	*
	* @access	public
	* @return	parsed view
	*/
	public function success() 
	{
		$this->load->view('orders/success');	
	}
	
	/**
	* Cancelled payment
	*
	* @access	public
	* @return 	parsed view
	*/
	public function cancel() 
	{
		$this->load->view('orders/cancel');	
	}
	
	/**
	* My orders
	*
	* @access	public
	* @return	parsed view
	*/
	public function my_orders()
	{
		// Kick-off validation for non-logged in users
		if(current_user() == NULL)
		{
			redirect('/', 'refresh');
		}
		
		// Check if this user has some orders and 
		// if not, then redirect him
		$total_orders = current_user()->total_orders();
		
		if($total_orders == 0)
		{
			redirect('/', 'refresh');
		}
		
		// Load my orders view
		$this->load->view('orders/my_orders', array
		(
			'total_orders'	=> $total_orders,
			'my_orders'		=> current_user()->my_orders()
		));
	}
	
	/**
	* Cancel order
	*
	* @access	public
	* @return	parsed view
	*/
	public function cancel_order()
	{
		$order_id = (int) param('order_id');
		
		// Kick-off validation for non-logged in users
		if(current_user() == NULL)
		{
			redirect('/', 'refresh');
		}
		
		// Get order data and check if it's still on 
		// processing - possible to cancel
		$order = new Order($order_id);
		$user_id = $order->user_id;
		
		if($user_id !== current_user()->user_id OR $order->status !== 'processing')
		{
			// It's not your order, so it's not you 
			// who can to cancel it or the order is 
			// packing or already delivered
			redirect('/my_orders', 'refresh');
		}
		
		if($order->paid == 1)
		{
			// Not possible to cancel because you 
			// have already paid for it
			redirect('/shop', 'refresh');
		}
		
		// All the validation passed, we can cancel it now
		$order->remove();
		
		// Delete related cart items too
		$this->db->delete('order_cart', array('order_id' => $order_id));
		
		// Go back to my orders
		redirect('/my_orders', 'refresh');
	}

}
