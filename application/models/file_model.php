<?php

class File extends TinyMapper {

	protected
		$belongs_to = array('user', 'file_category'),
		$as = array(
			'category' => 'file_category'
		),
		$created_field = 'created_at',
		$counter_field = 'downloaded_counter',
		$has_attached = array(
			'upload_path' => './uploads/files',
			'allowed_types' => '*',
			'max_size' => 10737418240,
			'driver' => 'files',
			'field_name' => 'file',
			'required' => TRUE
		),
		$validation = array(
			array(
				'field' => 'user_id',
				'label' => 'User ID',
				'rules' => 'required|integer'
			),
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
