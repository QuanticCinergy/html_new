<?php

class Shop_Brand extends TinyMapper {

	protected
		$table = 'shop_brands',
		$has_many = array('shop_items'),
		$as = array(
			'items' => 'shop_items'
		),
		$created_field = 'created_at',
		$validation = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
			)
		);

	public $has_attached = array(
		'upload_path' => './uploads/shop_brands',
		'allowed_types' => 'png|gif|jpeg|jpg',
		'max_size' => 10737418240,
		'driver' => 'files',
		'field_name' => 'image',
		'img' => array(
			'create_thumb' => TRUE,
			'width' => 150,
			'height' => 150,
			'maintain_ratio' => FALSE,
			'method' => 'resize'
		),
		'required' => TRUE
	);

	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$this->has_attached['img']['width'] = setting('shop.image_width', FALSE, 150);
		$this->has_attached['img']['height'] = setting('shop.image_height', FALSE, 150);
		$this->_properties['object']->url_name = url_title($this->_properties['object']->name);
	}

}
