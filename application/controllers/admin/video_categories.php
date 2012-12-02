<?php

class Video_Categories extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$category = new Video_Category;
		$this->load->view('video_categories/index', array(
			'categories' => $category->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->load->view('video_categories/add');
	}
	
	public function create() {
		$category = new Video_Category;
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
			redirect('admin/video_categories/add');
			return;
		}
		redirect('admin/video_categories/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Video_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$this->load->view('video_categories/edit', array(
			'category' => $category
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Video Category ID');
		}
		$category = new Video_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->name = $this->input->post('name');
		if($category->save() == FALSE) {
			flash('errors', $category->errors);
		}
		redirect('admin/video_categories/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$category = new Video_Category($id);
		if(! $category->exists()) {
			show_404();
		}
		$category->remove();
		redirect('admin/video_categories/index');
	}

}
