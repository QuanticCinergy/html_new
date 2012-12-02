<?php

class Hub extends TinyMapper {

	protected
		$table = 'hubs',
		$belongs_to = array('game_hubs'),
		$has_many = array('articles', 'games'),
		$as = array(
			'articles' => 'articles',
			'games'	   => 'games'
		),
		$created_field = 'created_at',
		$validation = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required'
			)
		),
		$has_attached = array(
            'upload_path' => './uploads/hubs',
            'allowed_types' => 'css',
            'max_size' => 10737418240,
            'driver' => 'files',
            'field_name' => 'file',
            'required' => FALSE
        );

	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$this->_properties['object']->url_title = url_title($this->_properties['object']->title);
	}

}
