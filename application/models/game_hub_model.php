<?php

class Game_Hub extends TinyMapper {

	protected
		$table = 'game_hubs',
		$has_one = array('game'),
		$belongs_to = array('game'),
		$primary_key = 'hub_id',
		$foreign_keys = array(
			'hub' => 'hub_id'
		),
		$validation = array(
			array(
				'field' => 'game_id',
				'label' => 'Game ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'hub_id',
				'label' => 'Hub ID',
				'rules' => 'required|integer'
			)
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
}
