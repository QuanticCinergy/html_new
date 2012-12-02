<?php

class Files extends Admin_Controller {


	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$file = new File;
		$base_url = '/admin/files/index/';
		$category_id = param('category_id');
		if($category_id) {
			$base_url .= 'category_id/'.$category_id.'/';
			$file->where('category_id', $category_id);
		}
		$user_id = param('user_id');
		if($user_id) {
			$base_url .= 'user_id/'.$user_id.'/';
			$file->where('user_id', $user_id);
		}
		$total_rows = $file->count();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'total_rows' => $total_rows,
			'base_url' => $base_url.'page/',
			'per_page' => 10,
			'uri_segment' => 'page',
			'full_tag_open' => '<ul>',
			'full_tag_close' => '</ul>',
			'first_link' => '',
			'last_link' => '',
			'previous_link' => '',
			'next_link' => '',
			'cur_tag_open' => '<li class="active">',
			'cur_tag_close' => '</li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>'
		));
		$files = $file->limit(10)->offset((int) param('page'))->order_by('created_at', 'desc')->get();
		$this->load->view('files/index', array(
			'files' => $files,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$file = new File($id);
		if(! $file->exists()) {
			show_404();
		}
		$this->load->view('files/show', array(
			'file' => $file
		));
	}
	
	public function add() {
		$category = new File_Category;
		$categories = array();
		foreach($category->get() as $model) {
			$categories[$model->id] = $model->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('files/add', array(
			'categories' => $categories
		));	
	}
	
	public function create() {
		$file = new File();
		$file->name = $this->input->post('name');
		$file->description = $this->input->post('description');
		$file->user_id = current_user()->id;
		$file->category_id = $this->input->post('category_id');
		if($file->save() == FALSE) {
			flash('errors', $file->errors);
			redirect('admin/files/add');
			return;
		}
		redirect('admin/files/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$file = new File($id);
		if(! $file->exists()) {
			show_404();
		}
		$category = new File_Category;
		$categories = array();
		foreach($category->get() as $model) {
			$categories[$model->id] = $model->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('files/edit', array(
			'file' => $file,
			'categories' => $categories
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('No File ID found');
		}
		$file = new File($id);
		$file->name = $this->input->post('name');
		$file->description = $this->input->post('description');
		$file->user_id = current_user()->id;
		$file->category_id = $this->input->post('category_id');
		if($file->save() == FALSE) {
			flash('errors', $file->errors);
			redirect('admin/files/edit/id/'.$file->id);
			return;
		}
		redirect('admin/files/index');
	}
	
	/*public function download() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$file = new File($id);
		if(! $file->exists()) {
			show_404();
		}
		$this->load->helper('download');
		force_download($file->file_filename, file_get_contents($file->file_path));
	}*/
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$file = new File($id);
		if(! $file->exists()) {
			show_404();
		}
		$file->remove();
		redirect('admin/files/index');
	}

}
