<?php

class Shop_Price_Groups extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$group = new Shop_Price_Group;
		$this->load->view('shop_price_groups/index', array(
			'groups' => $group->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('shop_price_groups/add');
	}
	
	public function create() {
		$group = new Shop_Price_Group;
		$group->name = $this->input->post('name');
		if($group->save() == FALSE) {
			flash('errors', $group->errors);
			redirect('admin/shop_price_groups/add');
			return;
		}
		redirect('admin/shop_price_groups/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$group = new Shop_Price_Group($id);
		if(! $group->exists()) {
			show_404();
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('shop_price_groups/edit', array(
			'group' => $group
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Pricing Group ID');
		}
		$group = new Shop_Price_Group($id);
		if(! $group->exists()) {
			show_404();
		}
		$group->name = $this->input->post('name');
		if($group->save() == FALSE) {
			flash('errors', $group->errors);
		}
		redirect('admin/shop_price_groups/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$group = new Shop_Price_Group($id);
		if(! $group->exists()) {
			show_404();
		}
		$group->remove();
		redirect('admin/shop_price_groups/index');
	}

}
