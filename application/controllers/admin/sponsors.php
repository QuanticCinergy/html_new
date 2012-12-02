<?php

class Sponsors extends Admin_Controller {

	public $menu = array(
		'consists_of' => array('sponsor_categories'),
		'show' => FALSE
	);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$sponsor = new Sponsor;
		$this->load->view('sponsors/index', array(
			'sponsors' => $sponsor->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$category = new Sponsor_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('sponsors/add', array(
			'categories' => $categories
		));
	}
	
	public function create() {
		$sponsor = new Sponsor;
		$sponsor->name = $this->input->post('name');
		$sponsor->category_id = $this->input->post('category_id');
		$sponsor->description = $this->input->post('description');
		if($sponsor->save() == FALSE) {
			flash('errors', $sponsor->errors);
			redirect('admin/sponsors/add');
			return;
		}
		redirect('admin/sponsors/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$sponsor = new Sponsor($id);
		if(! $sponsor->exists()) {
			show_404();
		}
		$category = new Sponsor_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('sponsors/edit', array(
			'sponsor' => $sponsor,
			'categories' => $categories
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Sponsor ID');
		}
		$sponsor = new Sponsor($id);
		if(! $sponsor->exists()) {
			show_404();
		}
		$sponsor->name = $this->input->post('name');
		$sponsor->category_id = $this->input->post('category_id');
		$sponsor->description = $this->input->post('description');
		if($sponsor->save() == FALSE) {
			flash('errors', $sponsor->errors);
		}
		redirect('admin/sponsors/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$sponsor = new Sponsor($id);
		if(! $sponsor->exists()) {
			show_404();
		}
		$sponsor->remove();
		redirect('admin/sponsors/index');
	}

}
