<?php

class Home extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		
		// Set some global variables
		$this->current_category = FALSE;
		$this->current_brand = FALSE;
		$this->categories = $this->db->get('shop_categories')->result_object();
		$this->brands = $this->db->get('shop_brands')->result_object();
		$this->countries = $this->db->get('shop_countries')->result_object();
		$this->cart = $this->session->userdata('cart');
		$this->current_section = FALSE;
		$this->sections = $this->db->get('article_sections')->result_object();
	}
	
	public function index() {
	
		$this->load->helper('inflector');
		view('home/index');
	}
	
}
