<?php

class Shop_Price_Group extends TinyMapper {

	protected
		$table = 'shop_variation_groups',
		$has_many = array('shop_variations'),
		$as = array(
			'variations' => 'shop_variations'
		),
		$created_field = 'created_at',
		$validation = array(
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
