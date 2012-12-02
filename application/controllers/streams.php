<?php

class Streams extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
			// Set some global variables
		$this->current_category = FALSE;
		$this->current_brand = FALSE;
		$this->categories = $this->db->get('shop_categories')->result_object();
		$this->brands = $this->db->get('shop_brands')->result_object();
		$this->countries = $this->db->get('shop_countries')->result_object();
		$this->cart = $this->session->userdata('cart');
	}
	
	public function index() {
		
		if(strpos($_SERVER['REQUEST_URI'], 'feed') !== FALSE)
		{
			$section_name = trim(str_replace('/streams/feed/', '', $_SERVER['REQUEST_URI']));
		
			return $this->feed($section_name);
		}
	
		$stream = new Stream();
		$base_url = streams_url();
		$section = param('section');
		if($section) {
			$base_url .= $section.'/';
			$_section = new Stream_Section;
			$section = $_section->find_by_url_name($section);
			if(! $section) {
				show_404();
			}
			$stream->where('section_id', $section->id);
		}
		$category = param('category');
		if($category) {
			$base_url .= $category.'/';
			$_category = new Stream_Category;
			$category = $_category->find_by_url_name($category);
			if(! $category) {
				show_404();
			}
			$stream->where('category_id', $category->id);
		}
		$stream->where('status', 'published');
		$total_rows = $stream->count();
		$per_page = setting('streams.per_page', FALSE, 50);
		$stream->offset((int) param('page'))->limit($per_page);
		$streams = $stream->get();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		$this->load->view('streams/index', array(
			'streams' => $streams,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$stream = new Stream($id);
		if(! $stream->exists()) {
			show_404();
		}
		$this->layout->title = $stream->title;
		
		$comment = new Comment();
		$total_rows = $comment->where('resource_id', $stream->id)->count();
		$offset = (int) param('page');
		$per_page = setting('comments.posts_per_page', FALSE, 20);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => stream_url(param('section'), param('category'), $id, param('title'), ''),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$comment->limit($per_page)->offset($offset)->order_by('created_at', 'asc');
		$comments = $comment->get();
		
		$this->load->view('streams/show', array(
			'stream' => $stream,
			'comments' => $comments,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function feed($section = FALSE)
	{
		$this->load->helper('xml');
		$this->load->helper('text');
	
		// Set params
		$section = ($section) ? $section : param('section');
		
		// Get section from the database by URL name
		$section = $this->db->from('stream_sections')->where('url_name', $section)->get()->row();
		
		if( ! $section)
		{
			// No such section, go home
			redirect('/', 'refresh');
		}
		
		// Get streams that belongs to this section
		$stream = new Stream();
		$stream->where('section_id', $section->id);
		$streams = $stream->get();
		
		// Output the feed
		$this->output->set_header("Content-Type: application/rss+xml; charset=UTF-8");		
		$this->load->view('streams/feed', array
		(
			'feed_name'			=> 'Too Pixel RSS',
			'page_description'	=> '' . $section->name,
			'charset'			=> 'utf-8',
			'feed_url'			=> base_url(),
			'page_language'		=> 'en',
			'creator_email'		=> 'gavin@tinyrocketship.com',
			'articles'			=> $streams
		));
	}
	
}
