<?php

class Post_Game extends TinyMapper {

	protected
		$table = 'post_games',
		$has_one = array('game'),
		$belongs_to = array('post'),
		$primary_key = 'game_id',
		$foreign_keys = array(
			'game' => 'game_id'
		),
		$validation = array(
			array(
				'field' => 'game_id',
				'label' => 'Game ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'post_id',
				'label' => 'Post ID',
				'rules' => 'required|integer'
			)
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
}
