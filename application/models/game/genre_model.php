<?php

class Genre_Model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get()
	{
		$this->db->select('name, url_name');
		$this->db->from('game_genres');
		$this->db->order_by('name', 'asc');
		
		return $this->db->get()->result();
	}
}

?>