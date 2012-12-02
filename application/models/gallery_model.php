<?php

class Gallery extends TinyMapper {

	protected
		$table = 'galleries',
		$belongs_to = array('user'),
		$has_many = array('photos', 'comments'),
		$dependent = TRUE,
		$foreign_keys = array(
			'comments' => 'resource_id'
		),
		$where = array(
			'comments' => array(
				'resource' => 'galleries'
			)
		),
		$validation = array(
			array(
				'field' => 'user_id',
				'label' => 'User ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required'
			)
		),
		$created_field = 'created_at',
		$updated_field = 'updated_at';

	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$this->_properties['object']->url_title = url_title($this->_properties['object']->title);
	}
	
	public function resource_url() {
		return gallery_url($this->id, $this->url_title);
	}

}
