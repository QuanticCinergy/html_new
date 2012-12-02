<?php

class Files extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$file = new File;
		$category = param('category');
		$base_url = '/files/';
		if($category) {
			$base_url .= $category.'/';
			$_category = new File_Category;
			$category = $_category->find_by_url_name($category);
			if(! $category) {
				show_404();
			}
			$file->where('category_id', $category->id);
		}
		$total_rows = $file->count();
		$per_page = setting('files.per_page', FALSE, 10);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'base_url' => $base_url.'page/'
		));
		$files = $file->limit($per_page)->offset((int) param('page'))->get();
		$this->load->view('files/index', array(
			'files' => $files,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$file = new File($id);
		if(! $file->exists()) {
			show_404();
		}
		$this->load->view('files/show', array(
			'file' => $file
		));
	}
	
	public function download() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$file = new File($id);
		if(! $file->exists()) {
			show_404();
		}
		$this->load->helper('download');
		force_download($file->file_filename, file_get_contents($file->file_path));
	}

}
