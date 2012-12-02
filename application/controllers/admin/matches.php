<?php

class Matches extends Admin_Controller {

	public $menu = array(
		'show' => FALSE,
		'consists_of' => array('squads'),
		'as' => 'Team'
	);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$match = new Match;
		$this->load->view('matches/index', array(
			'matches' => $match->get()
		));
	}
	
	public function add() {
		$this->layout->js = array('jquery-1.4.4.min', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8');
		$squad = new Squad;
		$squads = array();
		foreach($squad->get() as $item) {
			$squads[$item->id] = $item->name;
		}
		$this->load->view('matches/add', array(
			'squads' => $squads
		));
	}
	
	public function create() {
		$match = new Match;
		$match->squad_id = $this->input->post('squad_id');
		$match->opponent = $this->input->post('opponent');
		$starts_at = $this->input->post('starts_at');
		if($starts_at) {
			list($date, $time) = explode(' ', $starts_at);
			list($hours, $minutes) = explode(':', $time);
			list($date, $month, $year) = explode('-', $date);
			$match->starts_at = mktime($hours, $minutes, 0, $month, $date, $year);
		}
		$match->description = $this->input->post('description');
		$match->tournament = $this->input->post('tournament');
		if($match->save() == FALSE) {
			flash('errors', $match->errors);
			redirect('admin/matches/add');
			return;
		}
		redirect('admin/matches/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$this->layout->js = array('jquery-1.4.4.min', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8');
		$match = new Match($id);
		if(! $match->exists()) {
			show_404();
		}
		$squad = new Squad;
		$squads = array();
		foreach($squad->get() as $item) {
			$squads[$item->id] = $item->name;
		}
		$this->load->view('matches/edit', array(
			'match' => $match,
			'squads' => $squads
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Match ID');
		}
		$match = new Match($id);
		if(! $match->exists()) {
			show_404();
		}
		$match->squad_id = $this->input->post('squad_id');
		$match->opponent = $this->input->post('opponent');
		$starts_at = $this->input->post('starts_at');
		if($starts_at) {
			list($date, $time) = explode(' ', $starts_at);
			list($hours, $minutes) = explode(':', $time);
			list($date, $month, $year) = explode('-', $date);
			$match->starts_at = mktime($hours, $minutes, 0, $month, $date, $year);
		}
		$match->description = $this->input->post('description');
		$match->tournament = $this->input->post('tournament');
		$match->opponent_score = $this->input->post('opponent_score');
		$match->score = $this->input->post('score');
		$match->is_finished = '1';
		if($match->save() == FALSE) {
			flash('errors', $match->errors);
			redirect('admin/matches/edit/id/'.$match->id);
		}
		redirect('admin/matches/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$match = new Match($id);
		if(! $match->exists()) {
			show_404();
		}
		$match->remove();
		redirect('admin/matches/index');
	}

}
