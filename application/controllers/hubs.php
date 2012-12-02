<?php

class Hubs extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->current_section = FALSE;
	}
	
	public function index() {
	}
	
	public function show() {
		
		$title = param('title');
		$hub = new Hub;
		$hub = $hub->find_by_url_title($title);
		
		// Fetch all articles for related hub's games
		$this->db->select('a.id, a.url_title, a.title, a.created_at, a.image_article_thumb_url, a.short_content, c.name as section, d.name as category, e.username');
		$this->db->from('article_games ag');
		$this->db->join('game_hubs hg', 'hg.game_id = ag.game_id');
		$this->db->join('articles a', 'a.id = ag.article_id');
		$this->db->join('article_sections c', 'c.id = a.section_id');
		$this->db->join('article_categories_map acm', 'a.id = acm.article_id', 'left');
		$this->db->join('article_categories d', 'd.id = acm.category_id');
		$this->db->join('users e', 'e.id = a.user_id');
		$this->db->where('hg.hub_id', $hub->id);
		
		$query = $this->db->get();
		$articles = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$url = sprintf("articles/%s/%s/%s/%s", $row->section, $row->category, $row->id, $row->url_title);
				
				$articles[] = array(
					'title' => $row->title,
					'url'   => site_url($url),
					'image_thumb_url' => $row->image_article_thumb_url,
					'created_at' => date('D jS M Y - h:iA', $row->created_at),
					'short_content' => $row->short_content,
					'section' => $row->section,
					'username' => $row->username
				);
			}
		}
		
		// Fetch all videos for related hub's games
		$this->db->select('a.*, d.username, b.name as category');
		$this->db->from('video_games ag');
		$this->db->join('game_hubs hg', 'hg.game_id = ag.game_id');
		$this->db->join('videos a', 'a.id = ag.video_id');
		$this->db->join('video_categories b', 'a.category_id = b.id');
		$this->db->join('users d', 'd.id = a.user_id');
		$this->db->where('hg.hub_id', $hub->id);
		
		$query = $this->db->get();
		$videos = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$url = sprintf("videos/%s/%s", $row->id, $row->url_title);
				
				preg_match_all('/embed\/([A-Za-z0-9-_]+)/', $row->embed_code, $video_id);
				
				$thumb = $video_id[1]; 
				
				$videos[] = array(
					'title' => $row->title,
					'id' => $row->id,
					'url_title' => $row->url_title,
					'url'   => site_url($url),
					'created_at' => date('D jS M Y - h:iA', $row->created_at),
					'username' => $row->username,
					'video_id' => $thumb,
					'category' => $row->category
				);
			}
		}
		
		$this->layout->title = $hub->title;
		$this->load->view('hubs/show', array(
			'hub' => $hub,
			'articles' => $articles,
			'videos' => $videos,
			'hub_css' => file_get_contents('./uploads/hubs/'.$hub->file_filename)
		));
		
	}

}
