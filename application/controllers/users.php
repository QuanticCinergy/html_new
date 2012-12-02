<?php

class Users extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
			// Set some global variables
		$this->current_category = FALSE;
		$this->current_brand = FALSE;
		$this->current_section = FALSE;
		$this->categories = $this->db->get('shop_categories')->result_object();
		$this->brands = $this->db->get('shop_brands')->result_object();
		$this->countries = $this->db->get('shop_countries')->result_object();
		$this->cart = $this->session->userdata('cart');
	}
	
	public function show() {
		$username = param('username');
		if($username) {
			$user = new User;
			$_user = $user->find_by_username($username);
			$user = $_user ? $_user : current_user();
		} else {
			$user = current_user();
		}
		if(! $user) {
			show_404();
		}
		$_meta = $this->db->where('user_id', $user->id)->limit(1)->get('meta')->result_object();
		$meta = array();
		foreach($_meta[0] as $key=>$value) {
			if(! in_array($key, array('id', 'user_id', 'twt_id', 'fb_id', 'first_name', 'last_name'))) {
				$meta[$key] = $value;
			}
		}
		
		// FOR COMMENT WALL
		$comment = new Comment();
		$total_rows = $comment->where('resource_id', $user->id)->count();
		$offset = (int) param('page');
		$per_page = setting('comments.posts_per_page', FALSE, 20);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => profile_url(param('username')),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$comment->limit($per_page)->offset($offset)->order_by('created_at', 'desc');
		$comments = $comment->get();
		
		$friends = $user->get_all_friends();
		$this->load->view('users/show', array(
			'user' => $user,
			'meta' => $meta,
			'friends' => $friends,
			'comments' => $comments,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function edit() {
		$user = current_user();
		$_meta = $this->db->where('user_id', $user->id)->limit(1)->get('meta')->result_object();
		$meta = array();
		foreach($_meta[0] as $key=>$value) {
			if(! in_array($key, array('id', 'user_id', 'twt_id', 'fb_id', 'first_name', 'last_name'))) {
				$meta[$key] = $value;
			}
		}
		$this->load->view('users/edit', array(
			'user' => $user,
			'meta' => $meta
		));
	}
	
	public function update() {
		$user = current_user();
		$data = $this->input->post('user');
		if($data['password']) {
			$data['password'] = $this->ion_auth_model->hash_password($data['password'], $user->salt);
			$data['remember_code'] = '';
		} else {
			unset($data['password']);
		}
		if($user->username !== $data['username'] && username_check($data['username'])) {
			flash('errors', array($data['username'].' is already taken'));
			redirect(edit_profile_url());
			return;
		}
		$user->data($data);
		if(! $user->save()) {
			flash('errors', $user->errors);
			redirect(edit_profile_url());
			return;
		}
		$meta = $this->input->post('meta');
		
		if($meta && count($meta) > 0) {
		
			// Filter meta data, strip out html tags
			$filtered_meta = array();
			
			foreach($meta as $key => $value)
			{
				$filtered_meta[$key] = strip_tags($value);
			}
		
			$this->db->where('user_id', $user->id)->update('meta', $meta);
		}
		redirect(profile_url());
	}
	
}
