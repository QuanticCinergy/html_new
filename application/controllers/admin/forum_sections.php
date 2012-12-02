<?php

class Forum_Sections extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$section = new Forum_Section;
		$this->load->view('forum_sections/index', array(
			'sections' => $section->order_by('position', 'desc')->get()
		));
	}
	
	public function add() {
		$section = new Forum_Section;
		$sections = array();
		foreach($section->get() as $item) {
			$sections[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('forum_sections/add', array(
			'sections' => $sections
		));
	}
	
	public function create() {
		$section = new Forum_Section;
		$section->name = $this->input->post('name');
		$section->description = $this->input->post('description');
		if($section->save() == FALSE) {
			flash('errors', $section->errors);
			redirect('admin/forum_sections/add');
			return;
		}
		redirect('admin/forum_sections/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$section = new Forum_Section($id);
		if(! $section->exists()) {
			show_404();
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('forum_sections/edit', array(
			'section' => $section,
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Forum_Section Section ID');
		}
		$section = new Forum_Section($id);
		if(! $section->exists()) {
			show_404();
		}
		$section->name = $this->input->post('name');
		$section->description = $this->input->post('description');
		if($section->save() == FALSE) {
			flash('errors', $section->errors);
		}
		redirect('admin/forum_sections/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$section = new Forum_Section($id);
		if(! $section->exists()) {
			show_404();
		}
		$section->remove();
		redirect('admin/forum_sections/index');
	}

}
