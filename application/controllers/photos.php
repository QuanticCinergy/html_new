<?php

class Photos extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	// @TODO delete
	
	public function index() {
		$photo = new Photo;
		$total_rows = $photo->count();
		$per_page = setting('photos.per_page', FALSE, 10);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => '/photos/page/',
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$this->load->view('photos/index', array(
			'photos' => $photo->limit($per_page)->offset((int) param('page'))->order_by('created_at', 'desc')->get(),
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$photo = new Photo($id);
		$this->load->view('photos/show', array(
			'photo' => $photo
		));
	}
	
}
