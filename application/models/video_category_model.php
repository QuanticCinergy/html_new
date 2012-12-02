<?php

class Video_Category extends TinyMapper {

	protected
		$table = 'video_categories',
		$has_many = array('videos'),
		$created_field = 'created_at',
		$validation = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
			)
		);

	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$this->_properties['object']->url_name = url_title($this->_properties['object']->name);
	}

}
