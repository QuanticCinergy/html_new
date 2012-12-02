<?php

class Forums extends Admin_Controller {

	public $menu = array(
		'consists_of' => array('forum_sections'),
		'show' => TRUE
	);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$section = new Forum_Section;
		$this->load->view('forums/index', array(
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
		$this->load->view('forums/add', array(
			'sections' => $sections
		));
	}
	
	public function create() {
		$forum = new Forum;
		$forum->name = $this->input->post('name');
		$forum->description = $this->input->post('description');
		$forum->section_id = $this->input->post('section_id');
		if($forum->save() == FALSE) {
			flash('errors', $forum->errors);
			redirect('admin/forums/add');
			return;
		}
		redirect('admin/forums/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$forum = new Forum($id);
		if(! $forum->exists()) {
			show_404();
		}
		$section = new Forum_Section;
		$sections = array();
		foreach($section->get() as $item) {
			$sections[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('forums/edit', array(
			'forum' => $forum,
			'sections' => $sections
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Forum ID');
		}
		$forum = new Forum($id);
		if(! $forum->exists()) {
			show_404();
		}
		$forum->name = $this->input->post('name');
		$forum->description = $this->input->post('description');
		$forum->section_id = $this->input->post('section_id');
		if($forum->save() == FALSE) {
			flash('errors', $forum->errors);
			redirect('admin/forums/edit/id/'.$forum->id);
			return;
		}
		redirect('admin/forums/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$forum = new Forum($id);
		if(! $forum->exists()) {
			show_404();
		}
		$forum->remove();
		redirect('admin/forums/index');
	}

}
