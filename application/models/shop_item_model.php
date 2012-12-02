<?php

class Shop_Item extends TinyMapper {

	protected
		$table = 'shop_items',
		$belongs_to = array('shop_category', 'shop_brand'),
		$has_many = array('comments'),
		$as = array(
			'category' => 'shop_category',
			'brand' => 'shop_brand'
		),
		$foreign_keys = array(
			'comments' => 'resource_id',
			'shop_category' => 'category_id',
			'shop_brand' => 'brand_id'
		),
		$where = array(
			'comments' => array(
				'resource' => 'shop_items'
			)
		),
		$created_field = 'created_at',
		$updated_field = 'updated_at',
		$has_attached = array(
			'upload_path' => './uploads/shop_items',
			'allowed_types' => 'png|gif|jpeg|jpg',
			'max_size' => 10737418240,
			'driver' => 'files',
			'field_name' => 'photo',
			'img' => array(
				'create_thumb' => TRUE,
				'width' => 150,
				'height' => 150,
				'maintain_ratio' => FALSE,
				'method' => 'resize'
			),
			'required' => TRUE
		);
	
	public $validation = array(
		array(
			'field' => 'category_id',
			'label' => 'Category ID',
			'rules' => 'required|integer'
		),
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required'
		),
		array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => 'required|numeric'
		)
	);

	
	private $_loaded_meta = array();
	
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$this->has_attached['img']['width'] = setting('shop.image_width', FALSE, 150);
		$this->has_attached['img']['height'] = setting('shop.image_height', FALSE, 150);
		$this->_properties['object']->url_name = url_title($this->_properties['object']->name);
	}
	
	public function __pre_remove($object) {
		$this->CI->db->where('item_id', $object->id)->delete('shop_meta');
	}
	
	public function resource_url() {
		return shop_item_url($this->category->url_name, $this->id, $this->url_name);
	}

}
