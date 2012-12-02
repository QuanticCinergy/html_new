<?php

class Stream_Section extends TinyMapper {

	public
		$has_many = array('streams'),
		$table = 'stream_sections',
		$validation = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
			)
		),
		$created_field = 'created_at';

	public function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	public function __pre_save() {
		$this->_properties['object']->url_name = url_title($this->_properties['object']->name);
	}
	
}
