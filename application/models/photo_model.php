<?php

class Photo extends TinyMapper {

	protected
		$table = 'photos',
		$order_by = array('id', 'asc'),
		$belongs_to = array('user', 'gallery'),
		$has_many = array('comments'),
		$foreign_keys = array(
			'comments' => 'resource_id'
		),
		$where = array(
			'comments' => array(
				'resource' => 'photos'
			)
		),
		$has_attached = array(
			'upload_path' => './uploads/photos',
			'allowed_types' => 'png|gif|jpeg|jpg',
			'max_size' => 10737418240,
			'driver' => 'files',
			'field_name' => 'photo',
			'img' => array(
				'create_thumb' => TRUE,
				'width' => 150,
				'height' => 150,
				'maintain_ratio' => FALSE,
				'method' => 'resize'
			),
			'required' => TRUE
		),
		$created_field = 'created_at',
		$validation = array(
			array(
				'field' => 'user_id',
				'label' => 'User ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'gallery_id',
				'label' => 'Gallery ID',
				'rules' => 'required|integer'
			)
		);

	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$this->has_attached['img']['width'] = setting('photos.photo_width', FALSE, 150);
		$this->has_attached['img']['height'] = setting('photos.photo_height', FALSE, 150);
	}
	
	public function set_as_cover(Gallery $gallery) {
		$gallery->cover_id = $this->id;
		$gallery->save();
	}

}
