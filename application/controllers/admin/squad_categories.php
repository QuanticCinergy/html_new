<?php

class Squad_Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$category = new Squad_Category;
		$this->load->view('squad_categories/index', array(
			'categories' => $category->order_by('id', 'desc')->get()
		));
	}
	
	public function add() {
		$this->load->view('squad_categories/add');
	}
	
	public function create() {
		$category = new Squad_Category;
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
			redirect('admin/squad_categories/add');
			return;
		}
		redirect('admin/squad_categories/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Squad_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$this->load->view('squad_categories/edit', array(
			'category' => $category
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Squad Category ID');
		}
		$category = new Squad_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
		}
		redirect('admin/squad_categories/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Squad_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->remove();
		redirect('admin/squad_categories/index');
	}

}
