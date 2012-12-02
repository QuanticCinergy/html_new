<?php

class Galleries extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$gallery = new Gallery;
		$total_rows = $gallery->count();
		$per_page = setting('galleries.per_page', FALSE, 10);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'base_url' => galleries_url('')
		));
		$galleries = $gallery->limit($per_page)->offset((int) param('page'))->get();
		$this->load->view('galleries/index', array(
			'galleries' => $galleries,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show()
	{
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$gallery = new Gallery($id);
		if(! $gallery->exists()) {
			show_404();
		}

		// FOR COMMENTS
		$comment = new Comment();
		$total_rows = $comment->where('resource_id', $gallery->id)->count();
		$offset = (int) param('page');
		$per_page = setting('comments.posts_per_page', FALSE, 5);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => gallery_url($id, param('title')),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$comment->limit($per_page)->offset($offset)->order_by('created_at', 'asc');
		$comments = $comment->get();
		
		$this->load->view('galleries/show', array(
			'gallery' => $gallery,
			'comments' => $comments,
			'pagination' => $this->pagination->create_links()
		));
	}
	
}
