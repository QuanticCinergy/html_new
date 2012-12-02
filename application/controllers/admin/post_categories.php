<?php

class Post_Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$category = new Post_Category;
		$this->load->view('post_categories/index', array(
			'categories' => $category->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->load->view('post_categories/add');
	}
	
	public function create() {
		$category = new Post_Category;
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
			redirect('admin/post_categories/add');
			return;
		}
		redirect('admin/post_categories/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Post_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$this->load->view('post_categories/edit', array(
			'category' => $category
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Post Category ID');
		}
		$category = new Post_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
		}
		redirect('admin/post_categories/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Post_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->remove();
		redirect('admin/post_categories/index');
	}

}
