<?php

class Squad extends TinyMapper {

	protected
		$table = 'squads',
		$has_many = array('squad_members'),
		$as = array(
			'members' => 'squad_members'
		),
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
