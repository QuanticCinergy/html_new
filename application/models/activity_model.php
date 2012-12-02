<?php

class Activity extends TinyMapper {
	
	protected
		$table = 'activities',
		$belongs_to = array('user'),
		$created_field = 'created_at',
		$validation = array(
			array(
				'field' => 'user_id',
				'label' => 'User ID',
				'rules' => 'required'
			),
			array(
				'field' => 'content',
				'label' => 'Content',
				'rules' => 'required'
			)
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
}
