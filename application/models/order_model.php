<?php

class Order extends TinyMapper {

	protected
		$table = 'orders',
		$created_field = 'created_at',
		$validation = array();
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __on_status_update($object) {
		
	}

}
