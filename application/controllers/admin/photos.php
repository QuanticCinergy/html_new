<?php

class Photos extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$photo = new Photo($id);
		if(! $photo->exists()) {
			show_404();
		}
		$gallery = new Gallery;
		$galleries = array();
		foreach($gallery->where('user_id', current_user()->id)->get() as $item) {
			$galleries[$item->id] = $item->title;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('photos/edit', array(
			'photo' => $photo,
			'galleries' => $galleries
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Photo ID');
		}
		$photo = new Photo($id);
		if(! $photo->exists()) {
			show_404();
		}
		$photo->description = $this->input->post('description');
		$photo->title = $this->input->post('title');
		$photo->gallery_id = $this->input->post('gallery_id');
		if($photo->save() == FALSE) {
			flash('errors', $photo->errors);
		}
		redirect('admin/galleries/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$photo = new Photo($id);
		$gallery_id = $photo->gallery_id;
		if(! $photo->exists()) {
			show_404();
		}
		$photo->remove();
		redirect('admin/galleries/edit/id/'.$gallery_id);
	}
	
	public function set_as_cover() {
		$id = param('id');
		$gallery_id = param('gallery_id');
		if(! $id || ! $gallery_id) {
			show_404();
		}
		$gallery = new Gallery($gallery_id);
		if(! $gallery->exists()) {
			show_404();
		}
		$photo = new Photo($id);
		if(! $photo->exists()) {
			show_404();
		}
		$photo->set_as_cover($gallery);
		redirect('admin/galleries/edit/id/'.$photo->gallery_id);
	}

}
