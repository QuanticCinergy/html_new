<?php

class Shop_Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$category = new Shop_Category;
		$this->load->view('shop_categories/index', array(
			'categories' => $category->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('shop_categories/add');
	}
	
	public function create() {
		$category = new Shop_Category;
		$category->name = $this->input->post('name');
		$category->description = $this->input->post('description');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
			redirect('admin/shop_categories/add');
			return;
		}
		redirect('admin/shop_categories/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Shop_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('shop_categories/edit', array(
			'category' => $category
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Shop Category ID');
		}
		$category = new Shop_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->name = $this->input->post('name');
		$category->description = $this->input->post('description');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
		}
		redirect('admin/shop_categories/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Shop_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->remove();
		redirect('admin/shop_categories/index');
	}

}
