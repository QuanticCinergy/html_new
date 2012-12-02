<?php

class Hot_Article extends TinyMapper {
	
	public
		$has_many = array('articles'),
		$table = 'hot_articles',
		$validation = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required'
			)
		);
		
	public function __construct($id = NULL) {
		parent::__construct($id);
	}
	
}
