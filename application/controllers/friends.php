<?php

class Friends extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
	}
	
	public function index() {
		$username = param('username');
		if($username == FALSE) {
			$base_url = friends_url();
			$user = current_user();
		} else {
			$base_url = friends_url($username);
			$user = new User;
			$user = $user->find_by_username($username);
			if(! $user) {
				show_404();
			}
		}
		$page = (int) param('page');
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'per_page' => 20,
			'uri_segment' => 'page',
			'total_rows' => $user->total_friends()
		));
		$friends = $user->get_friends($page, 20);
		$this->load->view('friends/index', array(
			'user' => $user,
			'friends' => $friends,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function pending() {
		$user = current_user();
		$friends = $user->get_pending_friends();
		$this->load->view('friends/pending', array(
			'user' => $user,
			'friends' => $friends
		));
	}
	
	public function accept() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$friend = new User($id);
		if(! $friend->exists()) {
			show_404();
		}
		current_user()->accept_friend($friend);
		redirect('profile/friends');
	}
	
	public function deny() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$friend = new User($id);
		if(! $friend->exists()) {
			show_404();
		}
		current_user()->deny_friend($friend);
		redirect('profile/friends');
	}
	
	public function add() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$friend = new User($id);
		if(! $friend->exists()) {
			show_404();
		}
		current_user()->add_friend($friend);
		redirect('profile/'.$friend->username);
	}
	
	public function delete() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$friend = new User($id);
		if(! $friend->exists()) {
			show_404();
		}
		current_user()->delete_friend($friend);
		redirect('profile/friends');
	}

}
