<?php

class Squads extends Admin_Controller {

	public $menu = array(
		'show' => TRUE,
		'as' => 'Squads'
	);
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		// Handle saving a new order
		if($this->input->is_ajax_request())
		{
			$order     = $this->input->post('order');
			$order     = explode('&', $order);
			$new_order = array();
			
			foreach($order as $item)
			{
				$item        = explode('=', $item);
				$new_order[] = (int)$item[1];
			}
			
			// Now update the forum table
			foreach($new_order as $order => $id)
			{
				$this->db->where('id', $id);
				$this->db->update('squads', array(
					'order' => ($order+1)
				));
			}
			
			// Output JSON
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			echo json_encode(array('success' => true));
			// echo json_encode(array('error' => 'There was a problem saving the order'));
			exit;
		}
		
		$squad = new Squad;
		
		// Load assets
		$this->layout->js = array('jquery-ui-1.8.min');
		
		// Load view
		$this->load->view('squads/index', array(
			'squads' => $squad->get()
		));
	}
	
	public function add() {
	
		$category = new Squad_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
	
		$this->layout->js = array('jquery-1.5.1.min', 'jquery.tokeninput.min', 'init-users-tokeninputs', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('squads/add', array(
			'categories'	=>	$categories
		));
	}
	
	public function create() {
	
		$squad = new Squad;
		
		$squad->name = $this->input->post('name');
		$squad->description = $this->input->post('description');
		$squad->gaming_gear = $this->input->post('gaming_gear');
		$squad->category_id   = $this->input->post('category_id');
		
		if($squad->save() == FALSE) {
			flash('errors', $squad->errors);
			redirect('admin/squads/add');
			return;
		}
		$members = explode(',', $this->input->post('members'));
		
		foreach($members as $member) {
			if($member) {
				$this->db->insert('squad_members', array(
					'squad_id' => $squad->id,
					'user_id' => (int) $member
				));
			}
		}
		
		redirect('admin/squads/index');
	}
	
	public function edit() {
	
		$id = param('id');
		if(! $id) {
			show_404();
		}
		
		$squad = new Squad($id);
		if(! $squad->exists()) {
			show_404();
		}
		
		$category = new Squad_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		
		$members = $squad->squad_members;
		$_members = array();
		foreach($members as $member) {
			$user = new User($member->user_id);
			$_members[] = array('id' => $member->user_id, 'name' => $user->full_name());
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'jquery.tokeninput.min', 'init-users-tokeninputs', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('squads/edit', array(
			'squad' => $squad,
			'members' => $members,
			'categories' => $categories,
			'members_json' => json_encode($_members)
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Squad ID');
		}
		$squad = new Squad($id);
		if(! $squad->exists()) {
			show_404();
		}
		$squad->name = $this->input->post('name');
		$squad->description = $this->input->post('description');
		$squad->gaming_gear = $this->input->post('gaming_gear');
		$squad->category_id = $this->input->post('category_id');
		
		if($squad->save() == FALSE) {
			flash('errors', $squad->errors);
			redirect('admin/squads/edit/id/'.$squad->id);
			return;
		}
		$this->db->where('squad_id', $squad->id)->delete('squad_members');
		$members = explode(',', $this->input->post('members'));
		
		foreach($members as $member) {
			if($member) {
				$this->db->insert('squad_members', array(
					'squad_id' => $squad->id,
					'user_id' => (int) $member
				));
			}
		}
		redirect('admin/squads/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$squad = new Squad($id);
		if(! $squad->exists()) {
			show_404();
		}
		$squad->remove();
		redirect('admin/squads/index');
	}

}
