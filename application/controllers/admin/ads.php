<?php

class Ads extends Admin_Controller {


	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$ad = new Ad;
		$this->load->view('ads/index', array(
			'ads' => $ad->get()
		));
	}
	
	public function add() {
		$slot = new Ad_Slot;
		$slots = array();
		foreach($slot->get() as $item) {
			$slots[$item->id] = humanize($item->name);
		}
		$this->load->view('ads/add', array(
			'slots' => $slots
		));
	}
	
	public function create() {
		$ad = new Ad;
		$ad->name = $this->input->post('name');
		$ad->embed_code = $this->input->post('embed_code', FALSE);
		$ad->views_limit = $this->input->post('views_limit');
		$ad->slot_id = $this->input->post('slot_id');
		$ad->url = $this->input->post('url');
		if($ad->save() == FALSE) {
			flash('errors', $ad->errors);
			redirect('admin/ads/add');
			return;
		}
		redirect('admin/ads/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$ad = new Ad($id);
		if(! $ad->exists()) {
			show_404();
		}
		$slot = new Ad_Slot;
		$slots = array();
		foreach($slot->get() as $item) {
			$slots[$item->id] = humanize($item->name);
		}
		$this->load->view('ads/edit', array(
			'ad' => $ad,
			'slots' => $slots
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Ad ID');
		}
		$ad = new Ad($id);
		if(! $ad->exists()) {
			show_404();
		}
		$ad->name = $this->input->post('name');
		$ad->embed_code = $this->input->post('embed_code', FALSE);
		$ad->views_limit = $this->input->post('views_limit');
		$ad->slot_id = $this->input->post('slot_id');
		$ad->url = $this->input->post('url');
		if($ad->save() == FALSE) {
			flash('errors', $ad->errors);
			redirect('admin/ads/edit/id/'.$ad->id);
			return;
		}
		redirect('admin/ads/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$ad = new Ad($id);
		if(! $ad->exists()) {
			show_404();
		}
		$ad->remove();
		redirect('admin/ads/index');
	}

}
