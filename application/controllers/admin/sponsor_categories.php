<?php

class Sponsor_Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$category = new Sponsor_Category;
		$this->load->view('sponsor_categories/index', array(
			'categories' => $category->get()
		));
	}
	
	public function add() {
		$this->load->view('sponsor_categories/add');
	}
	
	public function create() {
		$category = new Sponsor_Category;
		$category->name = $this->input->post('name');
		$category->logo_width = (int) $this->input->post('logo_width');
		$category->logo_height = (int) $this->input->post('logo_height');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
			redirect('admin/sponsor_categories/add');
			return;
		}
		redirect('admin/sponsor_categories/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Sponsor_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$this->load->view('sponsor_categories/edit', array(
			'category' => $category
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Sponsor Category ID');
		}
		$category = new Sponsor_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->name = $this->input->post('name');
		$category->logo_width = (int) $this->input->post('logo_width');
		$category->logo_height = (int) $this->input->post('logo_height');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
		}
		redirect('admin/sponsor_categories/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Sponsor_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->remove();
		redirect('admin/sponsor_categories/index');
	}

}
