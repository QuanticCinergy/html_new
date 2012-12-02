<?php

class Sponsor_Category extends TinyMapper {

	protected
		$table = 'sponsor_categories',
		$has_many = array('sponsors'),
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

}
