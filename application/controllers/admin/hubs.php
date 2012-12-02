<?php

class Hubs extends Admin_Controller {

	public $menu = array(
			'consists_of' => array('games'),
			'show' => FALSE
		);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$hub = new Hub;
		$this->load->view('hubs/index', array(
			'hubs' => $hub->order_by('title', 'desc')->get()
		));
	}
	
	public function add() {
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('hubs/add');
	}
	
	public function create() {
		$hub = new Hub;
		$hub->title = $this->input->post('title');
		$hub->description = $this->input->post('description');
		$hub->content = $this->input->post('content');
		if($hub->save() == FALSE) {
			flash('errors', $hub->errors);
			redirect('admin/hubs/add');
			return;
		}
		redirect('admin/hubs/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$hub = new Hub($id);
		if(! $hub->exists()) {
			show_404();
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('hubs/edit', array(
			'hub' => $hub
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Hub ID');
		}
		$hub = new Hub($id);
		if(! $hub->exists()) {
			show_404();
		}
			
		$hub->title = $this->input->post('title');
		$hub->description = $this->input->post('description');
		$hub->content = $this->input->post('content');
		if($hub->save() == FALSE) {
			flash('errors', $hub->errors);
		}

		redirect('admin/hubs/index');
		
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$hub = new Hub($id);
		if(! $hub->exists()) {
			show_404();
		}
		$hub->remove();
		redirect('admin/hubs/index');
	}
	
	public function autocomplete() {
		
		$q = $this->input->get('q');
		
		if(!$q OR strlen(trim($q)) == 0) {
			echo json_encode(array());
			return;
		}
		
		// Search for hubs in the database
		$this->db->select('id, title');
		$this->db->from('hubs');
		$this->db->like('title', $q);

		$query = $this->db->get();
		
		$result = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result[] = array(
					'id'   => $row->id,
					'name' => $row->title
				);
			}
		}
		
		echo json_encode($result);
	}

}
