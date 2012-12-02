<?php

class User_Groups extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$group = new User_Group;
		$this->load->view('user_groups/index', array(
			'groups' => $group->get()
		));
	}
	
	public function add() {
		$rights = $this->acl->rights_list();
		$this->load->view('user_groups/add', array(
			'rights' => $rights
		));
	}
	
	public function create() {
		$group = new User_Group;
		$group->name = strtolower($this->input->post('name'));
		$group->description = $this->input->post('description');
		if($group->save() == FALSE) {
			flash('errors', $group->errors);
			redirect('admin/user_groups/add');
			return;
		}
		$rights = $this->input->post('rights');
		if(is_array($rights)) {
			foreach($rights as $key=>$value) {
				$this->acl->add_right($key, $value, $group);
			}
		}
		redirect('admin/user_groups/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$group = new User_Group($id);
		if(! $group->exists()) {
			show_404();
		}
		$rights = $this->acl->rights_list($group);
		$this->load->view('user_groups/edit', array(
			'group' => $group,
			'rights' => $rights
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Group ID');
		}
		$group = new User_Group($id);
		if(! $group->exists()) {
			show_404();
		}
		$group->name = $this->input->post('name');
		$group->description = $this->input->post('description');
		if($group->save() == FALSE) {
			flash('errors', $group->errors);
		}
		$rights = $this->input->post('rights');
		if(is_array($rights)) {
			foreach($rights as $key=>$value) {
				var_dump($value);
				if($value == '1') {
					$this->acl->allow($key, $group);
				} else {
					$this->acl->disallow($key, $group);
				}
			}
		} else {
			foreach($this->acl->rights_list() as $key) {
				$this->acl->disallow($key, $group);
			}
		}
		redirect('admin/user_groups/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$group = new User_Group($id);
		if(! $group->exists()) {
			show_404();
		}
		$group->remove();
		redirect('admin/user_groups/index');
	}

}
