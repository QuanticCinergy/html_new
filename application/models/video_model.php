<?php

class Video extends TinyMapper {

	protected
		$belongs_to = array('user', 'video_category'),
		$has_many = array('comments', 'video_games'),
		$dependent = TRUE,
		$as = array(
			'category' => 'video_category'
		),
		
		$has_attached = array(
			'upload_path' => './uploads/videos',
			'allowed_types' => 'flv|mp4|avi',
			'max_size' => 10737418240,
			'driver' => 'files',
			'field_name' => 'video',
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
		$foreign_keys = array(
			'comments' => 'resource_id'
		),
		$where = array(
			'comments' => array(
				'resource' => 'videos'
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
			),
			array(
				'field' => 'embed_code',
				'label' => 'Embed Code',
				'rules' => 'required'
			)
		);
		
	public function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	public function __pre_save() {
		if(isset($this->_properties['object']->video_id)) {
			unset($this->_properties['object']->video_id);
		}
		$this->_properties['object']->url_title = url_title($this->_properties['object']->title);
	}
	
	public function __post_load($object) {
		if(preg_match('/embed\/([A-Za-z0-9-_]+)/', $object->embed_code, $match)) {
			$this->_properties['object']->video_id = $match[1];
		}
	}
	
	public function resource_url() {
		return video_url($this->category->url_name, $this->id, $this->url_title);
	}

}
