<?php

class Shop_Brands extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$brand = new Shop_Brand;
		$this->load->view('shop_brands/index', array(
			'brands' => $brand->order_by('created_at', 'desc')->get()
		));
	}
	
	public function add() {
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('shop_brands/add');
	}
	
	public function create() {
		$brand = new Shop_Brand;
		$brand->name = $this->input->post('name');
		$brand->description = $this->input->post('description');
		$brand->editor_intro = $this->input->post('editor_intro');
		$brand->subscription_info = $this->input->post('subscription_info');
        $brand->side_content = $this->input->post('side_content');
		if($brand->save() == FALSE) {
			flash('errors', $brand->errors);
			redirect('admin/shop_brands/add');
			return;
		}
		
		if($this->db->insert_id() > 0)
		{
			//Successfully saveed to the database
			//Get insert id
			$insert_id = $this->db->insert_id();
			
			$brand = new Shop_Brand($insert_id);
			$brand->name = $this->input->post('name'); //TinyMapper needs some data other wise it dies FFS.
			$brand->has_attached = array(
				'upload_path' => './uploads/shop_brands',
				'allowed_types' => 'png|gif|jpeg|jpg',
				'max_size' => 10737418240,
				'driver' => 'files',
				'field_name' => 'image2',
				'img' => array(
					'create_thumb' => TRUE,
					'width' => 150,
					'height' => 150,
					'maintain_ratio' => FALSE,
					'method' => 'resize'
				),
				'required' => TRUE
			);
			
			if($brand->save() == FALSE) {
				flash('errors', $brand->errors);
				redirect('admin/shop_brands/add');
				return;
			}
		}
		
		redirect('admin/shop_brands/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$brand = new Shop_Brand($id);
		if(! $brand->exists()) {
			show_404();
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('shop_brands/edit', array(
			'brand' => $brand
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Brand ID');
		}
		$brand = new Shop_Brand($id);
		if(! $brand->exists()) {
			show_404();
		}
			
		$brand->name = $this->input->post('name');
		$brand->description = $this->input->post('description');
		$brand->editor_intro = $this->input->post('editor_intro');
		$brand->subscription_info = $this->input->post('subscription_info');
        $brand->side_content = $this->input->post('side_content');
		if($brand->save() == FALSE) {
			flash('errors', $brand->errors);
		}
		
		$brand = new Shop_Brand($id);
		$brand->name = $this->input->post('name'); //TinyMapper needs some data other wise it dies
		$brand->has_attached = array(
				'upload_path' => './uploads/shop_brands',
				'allowed_types' => 'png|gif|jpeg|jpg',
				'max_size' => 10737418240,
				'driver' => 'files',
				'field_name' => 'image2',
				'img' => array(
					'create_thumb' => TRUE,
					'width' => 150,
					'height' => 150,
					'maintain_ratio' => FALSE,
					'method' => 'resize'
				),
				'required' => TRUE
			);
			
		if($brand->save() == FALSE) {
			flash('errors', $brand->errors);
		}

		redirect('admin/shop_brands/index');
		
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$brand = new Shop_Brand($id);
		if(! $brand->exists()) {
			show_404();
		}
		$brand->remove();
		redirect('admin/shop_brands/index');
	}

}
