<?php

class Stream extends TinyMapper {
	
	public
		$belongs_to = array('stream_section', 'user', 'stream_category'),
		$has_many = array('comments'),
		$dependent = TRUE,
		$as = array(
			'category' => 'stream_category',
			'section' => 'stream_section'
		),
		$foreign_keys = array(
			'comments' => 'resource_id'
		),
		$where = array(
			'comments' => array(
				'resource' => 'streams'
			)
		),
		$validation = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required'
			),
			array(
				'field' => 'user_id',
				'label' => 'User ID',
				'rules' => 'required|integer'
			)//,
//			array(
//				'field' => 'content',
//				'label' => 'Content',
//				'rules' => 'required'
//			)
		),
		$created_field = 'created_at',
		$updated_field = 'updated_at',
		$has_attached = array(
			'upload_path' => './uploads/stream_images',
			'allowed_types' => 'png|gif|jpeg|jpg',
			'max_size' => 10737418240,
			'driver' => 'files',
			'field_name' => 'image',
			'img' => array(
				'create_thumb' => TRUE,
				'width' => 150,
				'height' => 150,
				'maintain_ratio' => TRUE,
				'method' => 'resize'
			),
			'required' => FALSE
		);
	
	public function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	public function __pre_save() {
		$this->has_attached['img']['width'] = setting('streams.image_width', FALSE, 150);
		$this->has_attached['img']['height'] = setting('streams.image_height', FALSE, 150);
		$this->_properties['object']->url_title = url_title($this->_properties['object']->title);
	}
	
	public function __post_load($object) {
		$this->_properties['object']->content = str_replace(array('&lt;', '&gt;'), array('<', '>'), $object->content);
	}
	
	public function approve() {
		$this->is_approved = TRUE;
		$this->save();
	}
	
	public function decline() {
		$this->remove();
	}
	
	public function resource_url() {
		return stream_url($this->section->url_name, $this->category->url_name, $this->id, $this->url_title);
	}
	
}
