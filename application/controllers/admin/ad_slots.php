<?php

class Ad_Slots extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$slot = new Ad_Slot;
		$this->load->view('ad_slots/index', array(
			'slots' => $slot->get()
		));
	}
	
	public function add() {
		$this->load->view('ad_slots/add');
	}
	
	public function create() {
		$slot = new Ad_Slot;
		$slot->name = underscore(strtolower($this->input->post('name')));
		$slot->image_width = (int) $this->input->post('image_width');
		$slot->image_height = (int) $this->input->post('image_height');
		if($slot->save() == FALSE) {
			flash('errors', $slot->errors);
			redirect('admin/ad_slots/add');
			return;
		}
		redirect('admin/ad_slots/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$slot = new Ad_Slot($id);
		if(! $slot->exists()) {
			show_404();
		}
		$this->load->view('ad_slots/edit', array(
			'slot' => $slot
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Slot ID');
		}
		$slot = new Ad_Slot($id);
		if(! $slot->exists()) {
			show_404();
		}
		$slot->name = underscore(strtolower($this->input->post('name')));
		$slot->image_width = (int) $this->input->post('image_width');
		$slot->image_height = (int) $this->input->post('image_height');
		if($slot->save() == FALSE) {
			flash('errors', $slot->errors);
		}
		redirect('admin/ad_slots/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$slot = new Ad_Slot($id);
		if(! $slot->exists()) {
			show_404();
		}
		$slot->remove();
		redirect('admin/ad_slots/index');
	}

}
