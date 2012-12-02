<?php

class Orders extends Admin_Controller {

	public $menu = array(
		'consists_of' => array('shop_items', 'shop_categories', 'shop_countries'),
		'show' => TRUE,
		'as' => 'Shop'
	);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$order = new Order;
		$this->load->view('orders/index', array(
			'orders' => $order->select('orders.*, (SELECT username FROM users WHERE users.id = orders.user_id) AS username', FALSE)->order_by('created_at', 'desc')->get()
		));
	}
	
	public function view() {
		$order_id = (int) param('id');
		if( ! $order_id) {
			show_404();
		}
		$order = new Order($order_id);
		if( ! $order->exists()) {
			show_404();
		}
		
		// Get user
		$user = $this->db->from('users')->where('id', $order->user_id)->get()->row();
		
		// Get shopping cart
		$cart = $this->db->from('order_cart')->where('order_id', $order->id)->join('shop_items', 'shop_items.id = order_cart.item_id', 'left')->get()->result_object();
		
		// Get country
		$shipping_details = unserialize($order->shipping_details);
		$country_id = $shipping_details['country_id'];
		$country = $this->db->from('shop_countries')->where('id', $country_id)->get()->row();
		
		$this->load->view('orders/view', array(
			'order' => $order,
			'user'	=> $user,
			'cart'	=> $cart,
			'country'	=> $country
		));
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$order = new Order($id);
		if(! $order->exists()) {
			show_404();
		}
		$this->load->view('orders/edit', array(
			'order' => $order
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if( ! $id) {
			show_error('Unknown Order ID');
		}
		$order = new Order($id);
		if( ! $order->exists()) {
			show_404();
		}
		
		$this->db->update('orders', array
		(
			'status'	=> (string) $this->input->post('status'),
			'paid'		=> (int) $this->input->post('paid')
		), 'id = ' . $id);
		
		redirect('admin/orders/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$order = new Order($id);
		if(! $order->exists()) {
			show_404();
		}
		$order->remove();
		
		// Remove cart elements
		$order_id = $id;
		$this->db->delete('order_cart', array('order_cart.order_id' => $order_id));
		
		redirect('admin/orders/index');
	}

}
