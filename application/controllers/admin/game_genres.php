<?php

class Game_Genres extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$genre = new Game_Genre;
		$this->load->view('game_genres/index', array(
			'genres' => $genre->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->load->view('game_genres/add');
	}
	
	public function create() {
		$genre = new Game_Genre;
		$genre->name = $this->input->post('name');
		if($genre->save() == FALSE) {
			collect('errors', $genre->errors);
			$this->add();
			return;
		}
		redirect('admin/game_genres/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$genre = new Game_Genre($id);
		if(! $genre->exists()) {
			show_404();
		}
		$this->load->view('game_genres/edit', array(
			'genre' => $genre
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Game Genre ID');
		}
		$genre = new Game_Genre($id);
		if(! $genre->exists()) {
			show_404();
		}
		$genre->name = $this->input->post('name');
		if($genre->save() == FALSE) {
			flash('errors', $genre->errors);
		}
		redirect('admin/game_genres/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$genre = new Game_Genre($id);
		if(! $genre->exists()) {
			show_404();
		}
		$genre->remove();
		redirect('admin/game_genres/index');
	}

}
