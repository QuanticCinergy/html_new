<?php

class Games extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->current_section = FALSE;
	}
	
	public function recent()
	{
		// Load recent games model
		$this->load->model('game/recent_model', 'recent_db');
		
		$per_page   = $this->recent_db->num_records = setting('games.per_page', FALSE, 30);
		$total_rows = $this->recent_db->get_count();
		
		// Get those games
		$games = $this->recent_db->get((int)param('page'));
		
		// Paging
		$this->load->library('pagination');
		
		$this->pagination->initialize(array(
			// 'base_url'    => 'http://m2g.dev/games/recent/page/',
			'base_url'    => site_url('games/recent/page'),
			'total_rows'  => $total_rows,
			'per_page'    => $per_page,
			'uri_segment' => 'page'
		));
		
		// Load view
		$this->load->view('games/recent', array(
			'games'      => $games,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function coming_soon()
	{
		// Load recent games model
		$this->load->model('game/coming_soon_model', 'coming_db');
		
		$per_page   = $this->coming_db->num_records = setting('games.per_page', FALSE, 30);
		$total_rows = $this->coming_db->get_count();
		
		// Get those games
		$games = $this->coming_db->get((int)param('page'));
		
		// Paging
		$this->load->library('pagination');
		
		$this->pagination->initialize(array(
			// 'base_url'    => 'http://m2g.dev/games/coming_soon/page/',
			'base_url'    => site_url('games/coming_soon/page'),
			'total_rows'  => $total_rows,
			'per_page'    => $per_page,
			'uri_segment' => 'page'
		));
		
		// Load view
		$this->load->view('games/coming_soon', array(
			'games'      => $games,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function genre()
	{
		// Do we want to only display list of genre types
		if(count($this->uri->segment_array()) == 2)
		{
			// Load recent games model
			$this->load->model('game/genre_model', 'genre_db');

			// Get those genres
			$genres = $this->genre_db->get();

			// Load view
			$this->load->view('games/genres', array(
				'genres'      => $genres
			));
			
			return;
		}
		else
		{
			$game     = new Game();
			$base_url = games_url();
			$genre    = $this->uri->segment(3);

			$base_url .= $genre.'/';
			$_genre    = new Game_Genre;
			$genre     = $_genre->find_by_url_name($genre);

			if(! $genre) {
				show_404();
			}

			$game->where('genre_id', $genre->id);
			$game->order_by('title', 'asc');

			$total_rows = $game->count();

			$per_page   = setting('games.per_page', FALSE, 30);
			$page       = (int)param('page');

			$game->offset($page)->limit($per_page);

			$games = $game->get();

			$this->load->library('pagination');

			$this->pagination->initialize(array(
				'base_url'    => $base_url.'page/',
				'total_rows'  => $total_rows,
				'per_page'    => $per_page,
				'uri_segment' => 'page'
			));

			$this->load->view('games/genre', array(
				'games'      => $games,
				'pagination' => $this->pagination->create_links(),
				'genre' => $this->uri->segment(3)
			));
		}
	}
	
	public function index() {
		
		$game     = new Game();
		$base_url = games_url();
		$genre    = param('genre');
		
		// Recent, Upcoming, All
		$display_type            = 'Recent';
		$supported_display_types = array('Recent', 'Upcoming', 'All');
		
		$game->order_by('title', 'asc');
		
		if($display_type == 'Recent')
		{
			$game->limit(120);
		}
		
		$total_rows = $game->count();
		
		$per_page   = setting('games.per_page', FALSE, 30);
		$page       = (int)param('page');
		
		$game->offset($page)->limit($per_page);
		
		$games = $game->get();
		
		$this->load->library('pagination');
		
		$this->pagination->initialize(array(
			'base_url'    => $base_url.'page/',
			'total_rows'  => $total_rows,
			'per_page'    => $per_page,
			'uri_segment' => 'page'
		));
		
		$this->load->view('games/index', array(
			'games'      => $games,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$title = param('title');
		$game = new Game;
		$game = $game->find_by_url_title($title);
		
		// Games articles
		$this->db->select('a.id, a.url_title, a.title, a.created_at, a.image_article_thumb_url, a.short_content, c.name as section, d.name as category, e.username');
		$this->db->from('article_games b');
		$this->db->join('articles a', 'b.article_id = a.id');
		$this->db->join('article_sections c', 'c.id = a.section_id');
		$this->db->join('article_categories_map acm', 'a.id = acm.article_id', 'left');
		$this->db->join('article_categories d', 'd.id = acm.category_id');
		$this->db->join('users e', 'e.id = a.user_id');
		$this->db->where('b.game_id = '.$game->id);
		
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
					'image_url' => $row->image_article_thumb_url,
					'created_at' => date('D jS M Y - h:iA', $row->created_at),
					'short_content' => $row->short_content,
					'section' => $row->section,
					'username' => $row->username
				);
			}
		}
		
		$this->layout->title = $game->title;
		$this->load->view('games/show', array(
			'game' => $game,
			'articles' => $articles
		));
	}
	
	public function autocomplete()
	{	
		$q = $this->input->get('q');
		
		if(!$q OR strlen(trim($q)) == 0) {
			echo json_encode(array());
			return;
		}
		
		// Search for game in the database
		$this->db->select('id, title');
		$this->db->from('games');
		$this->db->like('title', $q);

		$query = $this->db->get();
		
		$result = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result[] = array(
					'id'   => $row->id,
					'name' => $row->title
				);
			}
		}
		
		echo json_encode($result);
	}

}
