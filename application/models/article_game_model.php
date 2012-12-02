<?php

class Article_Game extends TinyMapper {

	protected
		$table = 'article_games',
		$has_one = array('game'),
		$belongs_to = array('article'),
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
				'field' => 'article_id',
				'label' => 'Article ID',
				'rules' => 'required|integer'
			)
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
}
