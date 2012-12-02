<?php

class Recent_Model extends CI_Model {
	
	// Number of results to limit by
	public $num_records = 120;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_count()
	{
		$this->db->select('id');
		$this->db->from('games g');
		$this->db->where('g.release <=', time());
		$this->db->order_by('g.release', 'desc');
		$this->db->order_by('g.title', 'asc');
		
		$this->db->limit(120);
		
		// Get count
		return $this->db->get()->num_rows();
	}
	
	public function get($page)
	{
		$this->db->select('g.title, g.release, g.unsure_of_date, g.url_title AS game_url, ge.url_name AS genre_url');
		$this->db->from('games g');
		$this->db->join('game_genres ge', 'g.genre_id = ge.id');
		$this->db->where('g.release <=', time());
		$this->db->order_by('g.release', 'desc');
		$this->db->order_by('g.title', 'asc');
		
		$this->db->limit($this->num_records, $page);
		
		return $this->db->get()->result();
	}
}

?>