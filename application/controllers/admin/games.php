<?php

class Games extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$game = new Game;
		$base_url = '/admin/games/index/';
	
		$genre_id = param('genre_id');
		if($genre_id) {
			$base_url .= 'genre_id/'.$genre_id.'/';
			$game->where('genre_id', $genre_id);
		}
		$total_rows = $game->count();
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
		
		$games = $game->limit(10)->offset((int) param('page'))->order_by('title', 'asc')->get();
		
		$genres = array();
		$genre = new Game_Genre;
		foreach($genre->get() as $item) {
			$genres[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'games.index');
		$this->load->view('games/index', array(
			'games' => $games,
			'genres' => $genres,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function add() {
	
		$genre = new Game_Genre;
		$genres = array();
		foreach($genre->get() as $item) {
			$genres[$item->id] = $item->name;
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'jquery.tokeninput.min', 'init-hubs-tokeninputs', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('games/add', array(
			'genres' => $genres
		));
	}
	
	public function create() {
		$game = new Game;
		$game->title = $this->input->post('title');
		$game->genre_id = $this->input->post('genre_id');
		$game->description = $this->input->post('description');
		$game->developer = $this->input->post('developer');
		$game->publisher = $this->input->post('publisher');
		if($game->save() == FALSE) {
			flash('errors', $game->errors);
			redirect('admin/games/add');
			return;
		}
		
		$hubs = explode(',', $this->input->post('hubs'));
		
		foreach($hubs as $hub) {
			if($hub) {
				$this->db->insert('hubs_games', array(
					'game_id' => $game->id,
					'hub_id' => (int) $hub
				));
			}
		}
		
		redirect('admin/games/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		
		$genre = new Game_Genre;
		$genres = array();
		foreach($genre->get() as $item) {
			$genres[$item->id] = $item->name;
		}
		
		$game = new Game($id);
		if(! $game->exists()) {
			show_404();
		}
		
		$hubs = $game->game_hubs;
		$_hubs = array();
		foreach($hubs as $hub) {
			$hub = new Hub($hub->hub_id);
			$_hubs[] = array('id' => $hub->id, 'title' => $hub->title);
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'jquery.tokeninput.min', 'init-hubs-tokeninputs', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('games/edit', array(
			'game' => $game,
			'genres' => $genres,
			'hubs' => $hubs,
			'hubs_json' => json_encode($_hubs)
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Game ID');
		}
		$game = new Game($id);
		if(! $game->exists()) {
			show_404();
		}
		$game->title = $this->input->post('title');
		$game->genre_id = $this->input->post('genre_id');
		$game->description = $this->input->post('description');
		$game->developer = $this->input->post('developer');
		$game->publisher = $this->input->post('publisher');
		if($game->save() == FALSE) {
			flash('errors', $game->errors);
			redirect('admin/games/edit/id/'.$game->id);
			return;
		}
		
		$this->db->where('game_id', $game->id)->delete('game_hubs');
		$hubs = explode(',', $this->input->post('hubs'));
		
		foreach($hubs as $hub) {
			if($hub) {
				$this->db->insert('game_hubs', array(
					'game_id' => $game->id,
					'hub_id' => (int) $hub
				));
			}
		}
		
		// Redirect back to game
		redirect('admin/games/edit/id/'.$id);
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$game = new Game($id);
		if(! $game->exists()) {
			show_404();
		}
		$game->remove();
		redirect('admin/games/index');
	}
	
	public function autocomplete() {
		
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

	public function search() {
	
		// Genre Filter
		$base_url = '/admin/games/index/';
	
		$genre_id = param('genre_id');
		if($genre_id) {
			$base_url .= 'genre_id/'.$genre_id.'/';
			$game->where('genre_id', $genre_id);
		}
		
		$genres = array();
		$genre = new Game_Genre;
		foreach($genre->get() as $item) {
			$genres[$item->id] = $item->name;
		}
	
		$q = $this->input->post('q');

		$this->db->select('a.id, a.title, a.genre_id, b.name');
		$this->db->from('games a');
		$this->db->join('game_genres b', 'a.genre_id = b.id');
		$this->db->like('title', $q);
		
		$query = $this->db->get();
		
		$result = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result[] = array(
					'title' => $row->title,
					'id' => $row->id,
					'name' => $row->name,
					'genre_id' => $row->genre_id
				);
			}
		}
		
		$this->load->view('games/search', array(
			'result' => $result,
			'genres' => $genres
		));
	}

}