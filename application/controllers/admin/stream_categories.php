<?php

class Stream_Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$category = new Stream_Category;
		$this->load->view('stream_categories/index', array(
			'categories' => $category->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->load->view('stream_categories/add');
	}
	
	public function create() {
		$category = new Stream_Category;
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
			redirect('admin/stream_categories/add');
			return;
		}
		redirect('admin/stream_categories/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Stream_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$this->load->view('stream_categories/edit', array(
			'category' => $category
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Stream Category ID');
		}
		$category = new Stream_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
		}
		redirect('admin/stream_categories/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Stream_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->remove();
		redirect('admin/stream_categories/index');
	}

}
