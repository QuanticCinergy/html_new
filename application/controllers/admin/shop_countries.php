<?php

class Shop_Countries extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$country = new Shop_Country;
		$this->load->view('shop_countries/index', array(
			'countries' => $country->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->load->view('shop_countries/add');
	}
	
	public function create() {
		$country = new Shop_Country;
		$country->name = $this->input->post('name');
		$country->postage = (float) $this->input->post('postage');
		if($country->save() == FALSE) {
			flash('errors', $country->errors);
			redirect('admin/shop_countries/add');
			return;
		}
		redirect('admin/shop_countries/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$country = new Shop_Country($id);
		if(! $country->exists()) {
			show_404();
		}
		$this->load->view('shop_countries/edit', array(
			'country' => $country
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Shop Country ID');
		}
		$country = new Shop_Country($id);
		if(! $country->exists()) {
			show_404();
		}
		$country->name = $this->input->post('name');
		$country->postage = (float) $this->input->post('postage');
		if($country->save() == FALSE) {
			flash('errors', $country->errors);
		}
		redirect('admin/shop_countries/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$country = new Shop_Country($id);
		if(! $country->exists()) {
			show_404();
		}
		$country->remove();
		redirect('admin/shop_countries/index');
	}

}
