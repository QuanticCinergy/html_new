<?php

class Sponsor extends TinyMapper {

	protected
		$table = 'sponsors',
		$belongs_to = array('sponsor_category'),
		$as = array(
			'category' => 'sponsor_category'
		),
		$created_field = 'created_at',
		$updated_field = 'updated_at',
		$validation = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
			),
			array(
				'field' => 'category_id',
				'label' => 'Category ID',
				'rules' => 'required|integer'
			)
		),
		$has_attached = array(
			'upload_path' => './uploads/sponsor_logos',
			'allowed_types' => 'png|gif|jpeg|jpg',
			'max_size' => 10737418240,
			'driver' => 'files',
			'field_name' => 'logo',
			'required' => TRUE
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}

}
