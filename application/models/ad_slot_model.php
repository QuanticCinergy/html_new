<?php

class Ad_Slot extends TinyMapper {

	protected
		$table = 'ad_slots',
		$has_many = array('ads'),
		$foreign_keys = array(
			'ads' => 'slot_id'
		),
		$validation = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required'
			),
			array(
				'field' => 'image_width',
				'label' => 'Image Width',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'image_height',
				'label' => 'Image Height',
				'rules' => 'required|integer'
			)
		);

	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function ads() {
		$this->CI->db->cache_off();
		$this->CI->db->where('`views_count` <= `views_limit`', NULL, FALSE);
		$this->CI->db->order_by('RAND()', 'DESC');
		$this->CI->db->limit(1);
		$ads = $this->ads;
		$this->CI->db->cache_on();
		
		foreach($ads as $ad)
		{
			// Increase views count
			$this->CI->db->update('ads', array('ads.views_count' => ($ad->views_count + 1)), 'id = "' . $ad->id . '"');
			
			break;
		}

		return $ads;
	}

}
