<?php

class Matches extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$match = new Match;
		$this->load->library('pagination');
		$per_page = setting('matches.per_page', FALSE, 10);
		$this->pagination->initialize(array(
			'base_url' => matches_url(''),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $match->count()
		));
		$matches = $match->limit($per_page)->offset((int) param('page'))->get();
		$this->load->view('matches/index', array(
			'matches' => $matches,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$match = new Match($id);
		if(! $match->exists()) {
			show_404();
		}
		$this->load->view('matches/show', array(
			'team' => $match
		));
	}
	
}
