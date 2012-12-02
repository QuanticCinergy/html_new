<?php

class Team extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function show() {
		$this->load->view('team/show');
	}

}
