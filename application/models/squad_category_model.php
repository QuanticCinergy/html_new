<?php

class Squad_Category extends TinyMapper {
	
	public
		$has_many = array('squads'),
		$table = 'squad_categories',
		$validation = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
			)
		);
		
	public function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	public function __pre_save() {
		$this->_properties['object']->url_name = url_title($this->_properties['object']->name);
	}
	
}
