<?php

class Ad extends TinyMapper {
	
	protected
		$table = 'ads',
		$belongs_to = array('ad_slot'),
		$validation = array(
			array(
				'field' => 'slot_id',
				'label' => 'Slot ID',
				'rules' => 'required|integer'
			)
		),
		$has_attached = array(
			'upload_path' => './uploads/ads',
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
			'required' => FALSE
		);
	
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$slot = new Ad_Slot($this->_properties['object']->slot_id);
		$this->has_attached['img']['width'] = $slot->image_width;
		$this->has_attached['img']['height'] = $slot->image_height;
		if($this->_properties['object']->embed_code !== '') {
			$this->_properties['object']->embed_code = str_replace(array('<script', '<object', '<param', '</script>', '</object>'), array('[scrpt', '[obj', '[prm', '[/scrpt]', '[/obj]'), $this->_properties['object']->embed_code);
		}
	}
	
	public function __post_load() {
		if($this->_properties['object']->embed_code !== '') {
			$this->_properties['object']->embed_code = str_replace(array('[scrpt', '[obj', '[prm', '[/scrpt]', '[/obj]'), array('<script', '<object', '<param', '</script>', '</object>'), $this->_properties['object']->embed_code);
		}
	}
	
	public function check() {
		if($this->embed_code == '' && (int) $this->views_count >= (int) $this->views_limit) {
			$this->remove();
			return FALSE;
		}
		return TRUE;
	}
	
	public function view() {
		if($this->embed_code == '') {
			$this->views_count = (string) $this->views_count + 1;
			$this->save(FALSE);
		}
	}
	
}
