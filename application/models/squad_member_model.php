<?php

class Squad_Member extends TinyMapper {

	protected
		$table = 'squad_members',
		$has_one = array('user'),
		$belongs_to = array('squad'),
		$primary_key = 'user_id',
		$foreign_keys = array(
			'user' => 'user_id'
		),
		$validation = array(
			array(
				'field' => 'user_id',
				'label' => 'User ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'squad_id',
				'label' => 'Squad ID',
				'rules' => 'required|integer'
			)
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
}
