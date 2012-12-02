<?php

class Galleries extends Admin_Controller {

	public $menu = array(
		'as' => 'Media',
		'consists_of' => array('photos', 'videos'),
		'show' => TRUE
	);

	public function __construct() {
		parent::__construct(); 
	}
	
	public function index() {
		$gallery = new Gallery;
		$base_url = '/admin/galleries/index/';
		$user_id = param('user_id');
		if($user_id) {
			$base_url .= 'user_id/'.$user_id.'/';
			$gallery->where('user_id', $user_id);
		}
		$total_rows = $gallery->count();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'total_rows' => $total_rows,
			'base_url' => $base_url.'page/',
			'per_page' => 10,
			'uri_segment' => 'page',
			'full_tag_open' => '<ul>',
			'full_tag_close' => '</ul>',
			'first_link' => '',
			'last_link' => '',
			'previous_link' => '',
			'next_link' => '',
			'cur_tag_open' => '<li class="active">',
			'cur_tag_close' => '</li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>'
		));
		
		$galleries = $gallery->limit(10)->offset((int) param('page'))->order_by('created_at', 'desc')->get();

		$this->load->view('galleries/index', array(
			'galleries' => $galleries,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function add() {
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce', 'gallery.progress');
		$this->load->view('galleries/add');
	}
	
	public function create() {
		$gallery = new Gallery;
		$user_id = current_user()->id;
		$gallery->user_id = $user_id;
		$gallery->short_description = substr($this->input->post('short_description'), 0, 140);
		$gallery->description = $this->input->post('description');
		$gallery->title = $this->input->post('title');
		if($gallery->save() == FALSE) {
			flash('errors', $gallery->errors);
			redirect('admin/galleries/add');
			return;
		}
		$_photos = isset($_FILES['photos']) ? $_FILES['photos'] : FALSE;
		if($_photos) {
			$photos = array();
			foreach($_photos as $key=>$value) {
				foreach($value as $index=>$val) {
					$photos[$index][$key] = $val;
				}
			}
			foreach($photos as $photo) {
				$_FILES['photo'] = $photo;
				$model = new Photo;
				$model->user_id = $user_id;
				$model->gallery_id = $gallery->id;
				if($model->save() == FALSE) {
					flash('errors', $model->errors);
					redirect('admin/galleries/add');
					return;
				}
			}
		}
		redirect('admin/galleries/edit/id/' . $gallery->id);
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$gallery = new Gallery($id);
		if(! $gallery->exists()) {
			show_404();
		}
		$this->layout->js = array('jquery-1.5.1.min', 'gallery.edit', 'tiny_mce/jquery.tinymce', 'init-tinymce', 'gallery.progress');
		$this->load->view('galleries/edit', array(
			'gallery' => $gallery
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Gallery ID');
		}
		$gallery = new Gallery($id);
		if(! $gallery->exists()) {
			show_404();
		}
		$gallery->short_description = substr($this->input->post('short_description'), 0, 140);
		$gallery->description = $this->input->post('description');
		$gallery->title = $this->input->post('title');
		if($gallery->save() == FALSE) {
			flash('errors', $gallery->errors);
		}
		
		/*
		
		$_photos = isset($_FILES['photos']) ? $_FILES['photos'] : FALSE;
		
		if($_photos) {
			$photos = array();
			foreach($_photos as $key=>$value) {
				foreach($value as $index=>$val) {
					$photos[$index][$key] = $val;
				}
			}
			foreach($photos as $photo) {
				$_FILES['photo'] = $photo;
				$model = new Photo;
				$model->user_id = $gallery->user_id;
				$model->gallery_id = $gallery->id;
				if($model->save() == FALSE) {
					flash('errors', $model->errors);
					redirect('admin/galleries/edit/id/'.$gallery->id);
					return;
				}
			}
		}
		
		*/
		
		redirect('admin/galleries/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$gallery = new Gallery($id);
		if(! $gallery->exists()) {
			show_404();
		}
		$gallery->remove();
		
		$this->db->where('resource_id', $gallery->id);
		$this->db->where('resource', 'galleries');
		$this->db->delete('comments');
		
		redirect('admin/galleries/index');
	}
	
	public function upload() 
	{
		// Set variables
		$file_name = trim($this->input->post('filename'));
		$user_id = (int) $this->input->post('user_id');
		$gallery_id = (int) $this->input->post('gallery_id');
	
		if($file_name)
		{
			$source_image = FCPATH . 'uploads/photos/' . $file_name;
			$image_info = getimagesize($source_image);
			
			// Create a thumbnail
			$config['image_library'] = 'gd2';
			$config['source_image'] = $source_image;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = FALSE;
			$config['width'] = 150;
			$config['height'] = 150;

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			
			// Prepare thumbnail name
			if(strpos($file_name, '.jpg') !== FALSE) { $thumb_name = str_replace('.jpg', '_thumb.jpg', $file_name); }
			if(strpos($file_name, '.JPG') !== FALSE) { $thumb_name = str_replace('.JPG', '_thumb.JPG', $file_name); }
			if(strpos($file_name, '.jpeg') !== FALSE) { $thumb_name = str_replace('.jpeg', '_thumb.jpeg', $file_name); }
			if(strpos($file_name, '.gif') !== FALSE) { $thumb_name = str_replace('.gif', '_thumb.gif', $file_name); }
			if(strpos($file_name, '.GIF') !== FALSE) { $thumb_name = str_replace('.GIF', '_thumb.GIF', $file_name); }
			if(strpos($file_name, '.png') !== FALSE) { $thumb_name = str_replace('.png', '_thumb.png', $file_name); }
			if(strpos($file_name, '.PNG') !== FALSE) { $thumb_name = str_replace('.PNG', '_thumb.PNG', $file_name); }
			
			// Insert data to the database
			$result = $this->db->insert('photos', array
			(
				'user_id'			=> $user_id,
				'photo_url'			=> '/uploads/photos/' . $file_name,
				'photo_thumb_url'	=> '/uploads/photos/' . $thumb_name,
				'photo_thumb_path'	=> FCPATH . 'uploads/photos/' . $thumb_name,
				'photo_filename'	=> $file_name,
				'photo_mime'		=> image_type_to_mime_type($image_info[2]),
				'photo_size'		=> 0,
				'photo_path'		=> $source_image,
				'created_at'		=> time(),
				'gallery_id'		=> $gallery_id
			));
			
			//var_dump($result);
			//echo $this->db->last_query();
			//var_dump($this->db->insert_id());				

			echo '1';
			exit();
		}
		
		echo '0';
		exit();
	}

}
