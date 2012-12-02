<?php

class Videos extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		// Set some global variables
		$this->current_section = FALSE;
		
	}
	
	public function index() {
		$video = new Video();
		$category = param('category');
		$base_url = '/videos/';
		if($category) {
			$base_url .= $category.'/';
			$_category = new Video_Category;
			$category = $_category->find_by_url_name($category);
			if(! $category) {
				show_404();
			}
			$video->where('category_id', $category->id);
		}
		$total_rows = $video->count();
		$offset = (int) param('page');
		$per_page = setting('videos.per_page', FALSE, 10);
		$video->limit($per_page)->offset($offset);
		$videos = $video->get();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		$this->load->view('videos/index', array(
			'videos' => $videos,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$video = new Video($id);
		if(! $video->exists()) {
			show_404();
		}
		
		// Related Games
		$this->db->select('a.id, a.url_title, a.title, a.genre_id');
		$this->db->from('video_games am');
		$this->db->join('games a', 'am.game_id = a.id');
		$this->db->where('am.video_id = '.$video->id);
		
		$query = $this->db->get();
		$games = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$url = sprintf("games/%s/%s", $row->genre_id, $row->url_title);
				
				$games[] = array(
					'title' => $row->title,
					'url'   => site_url($url)
				);
			}
		}
		
		// FOR COMMENTS
		$comment = new Comment();
		$total_rows = $comment->where('resource_id', $video->id)->count();
		$offset = (int) param('page');
		$per_page = setting('comments.posts_per_page', FALSE, 20);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => video_url(param('category'), $id, param('title'), ''),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$comment->limit($per_page)->offset($offset)->order_by('created_at', 'desc');
		$comments = $comment->get();
		
		$this->load->view('videos/show', array(
			'video' => $video,
			'comments' => $comments,
			'games' => $games,
			'pagination' => $this->pagination->create_links()
		));
	}

}
