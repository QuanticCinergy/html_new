<?php

class Video_Game extends TinyMapper {

	protected
		$table = 'video_games',
		$has_one = array('game'),
		$belongs_to = array('video'),
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
				'field' => 'video_id',
				'label' => 'Video ID',
				'rules' => 'required|integer'
			)
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
}
