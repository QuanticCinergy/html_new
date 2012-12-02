<?php

class Articles extends Admin_Controller {

	public $menu = array(
		'consists_of' => array('article_categories', 'article_sections', 'comments', 'ads'),
		'show' => TRUE,
		'as' => 'Editorial'
	);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$article = new Article;
		$base_url = '/admin/articles/index/';
		
		$category_id = param('category_id');
		if($category_id)
		{
			$base_url .= 'category_id/'.$category_id.'/';
			
			// Bit of a hack to get around TinyMapper
			$ids   = array();
			$query = $this->db->query('SELECT article_id FROM article_categories_map WHERE category_id = '.$category_id);
			
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$ids[] = $row->article_id;
				}
			}
			else
			{
				$ids[] = -1;
			}
			
			$ids = implode(',', $ids);
			$sql = 'id IN ('.$ids.')';
			
			$article->where($sql);
		}
		
		$user_id = param('user_id');
		if($user_id) {
			$base_url .= 'user_id/'.$user_id.'/';
			$article->where('user_id', $user_id);
		}
		$section_id = param('section_id');
		if($section_id) {
			$base_url .= 'section_id/'.$section_id.'/';
			$article->where('section_id', $section_id);
		}
		$status = param('status') ? param('status') : 'published';
		$total_rows = $article->count();
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
		
		$articles = $article->limit(10)->offset((int) param('page'))->order_by('created_at', 'desc')->get();
		
		$users      = array('-1' => 'All Users');
		$sections   = array('-1' => 'All Sections');
		$categories = array('-1' => 'All Categories');
		
		foreach($articles as $article) {
			$users[$article->user->id] = $article->user->full_name();
		}
		
		$section = new Article_Section;
		foreach($section->get() as $item) {
			$sections[$item->id] = $item->name;
		}
		
		$category = new Article_Category;
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'articles.index');
		$this->load->view('articles/index', array(
			'articles' => $articles,
			'users' => $users,
			'sections' => $sections,
			'categories' => $categories,
			'pagination' => $this->pagination->create_links(),
			'success'    => $this->session->flashdata('success'),
			'error'      => $this->session->flashdata('error')
		));
	}
	
	public function add() {
		
		// We will create a new article
		// then redirect them to the edit page
		
		$article = new Article;
		
		$article->title       = 'Untitled';
		$article->user_id     = current_user()->id;
		$article->section_id  = 1;
		$article->content     = 'Content goes here';
		$article->is_approved = 0;
		$article->status      = 'draft';		
		
		if($article->save() == FALSE) {
			$this->session->set_flashdata('error', 'Unable to create new article');
			redirect('admin/articles/');
		}
		
		// Remove content forced in to satisfy TinyMapper validation
		$this->db->where('id', $article->id);
		$this->db->update('articles', array(
			'title'   => 'Untitled '.$article->id,
			'content' => 'Content goes here'
		));
		
		// Set success message
		$this->session->set_flashdata('success', 'New article successfully created');
		
		redirect('admin/articles/edit/id/'.$article->id);
	}
	
	private function save_ajax()
	{
		$article_id = $this->input->get('id');
		$title      = url_title($this->input->get('title'));
		$section_id = $this->input->get('section');
		
		$this->db->where('id', $article_id);
		$this->db->update('articles', array(
			'section_id'    => $section_id,
			'title'         => $this->input->get('title'),
			'url_title'     => $title,
			'short_content' => $this->input->get('short'),
			'content'       => $this->input->get('full'),
			'updated_at'    => strtotime($this->input->get('date')),
			'status'        => $this->input->get('status')
		));
		
		// Save categories
		$categories = $this->input->get('categories');
		$categories = substr($categories, 0, -1);
		
		$this->db->query('DELETE FROM article_categories_map WHERE article_id = '.$article_id);
		
		if(strlen($categories) > 0)
		{
			$categories  = explode(',', $categories);
			$category    = $categories[0];
			
			foreach($categories as $cat_id)
			{
				$sql  = 'INSERT INTO article_categories_map ';
				$sql .= 'SET article_id = '.$article_id.', category_id = '.$cat_id;
				$this->db->query($sql);
			}
		}
		else
		{
			$category = 'Unknown';
		}
		
		// Save attached games
		
		// First remove all currently associated games
		$this->db->where('article_id', $article_id)->delete('article_games');
		
		// Now save those selected
		$games = explode(',', $this->input->get('games'));
		
		foreach($games as $game) {
			if($game) {
				$this->db->insert('article_games', array(
					'article_id' => $article_id,
					'game_id' => (int) $game
				));
			}
		}
		
		// URL
		$url = site_url('articles');
		
		// Work out URL to article
		$this->db->select('url_name');
		$this->db->from('article_sections');
		$this->db->where('id', $section_id);
		
		$row = $this->db->get()->row();
		
		$url .= '/'.$row->url_name;
		
		// Get category name
		// if more than one cat id we take the 1st one
		// if none, then set to Unknown
		if(!is_numeric($category))
		{
			$url .= '/Unknown';
		}
		else
		{
			$this->db->select('url_name');
			$this->db->from('article_categories');
			$this->db->where('id', $category);
			
			$row = $this->db->get()->row();
			
			$url .= '/'.$row->url_name;
		}
		
		// Append article ID
		$url .= '/'.$article_id.'/'.$title;
		
		echo $url;
		exit;
	}
	
	public function edit() {
		
		if($this->uri->segment(6) AND $this->uri->segment(6) == 'save' AND 
		   $this->input->is_ajax_request())
		{
			$this->save_ajax();
			exit;
		}
		
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$article = new Article($id);
		if(! $article->exists()) {
			show_404();
		}
		
		// Get article categories
		$this->db->select('id, name');
		$this->db->from('article_categories');
		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get();
		
		$categories = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				if($row->name == 'Unknown') continue;
				$categories[] = $row;
			}
		}
		
		// Get categories article belongs to
		$this->db->select('acm.category_id, ac.url_name');
		$this->db->from('article_categories_map acm');
		$this->db->join('article_categories ac', 'acm.category_id = ac.id');
		$this->db->where('acm.article_id', $id);
		
		$query = $this->db->get();
		
		$selected_categories = array();
		
		if($query->num_rows() > 0)
		{
			$first = TRUE;
			
			foreach($query->result() as $row)
			{
				if($first)
				{
					$article->category = new stdClass;
					$article->category->url_name = $row->url_name;
					
					$first = FALSE;
				}
				
				$selected_categories[] = $row->category_id;
			}
		}
		else
		{
			$article->category = new stdClass;
			$article->category->url_name = 'Unknown';
		}
		
		// Get article section
		$section = new Article_Section;
		$sections = array();
		foreach($section->get() as $item) {
			$sections[$item->id] = $item->name;
		}
		
		$games = $article->article_games;
		$_games = array();
		foreach($games as $game) {
			$game = new Game($game->game_id);
			$_games[] = array('id' => $game->id, 'title' => $game->title);
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers', 'jquery.tokeninput.min', 'init-games-tokeninputs', 'gallery.edit', 'gallery.progress');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8', 'jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('articles/edit', array(
			'success'    => $this->session->flashdata('success'),
			'categories' => $categories,
			'selected_categories' => $selected_categories,
			'sections' => $sections,
			'article' => $article,
			'is_article' => true,
			'games' => $games,
			'games_json' => json_encode($_games)
		));
	}
	
	public function update() {
		
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Article ID');
		}
		$article = new Article($id);
		if(! $article->exists()) {
			show_404();
		}
		// $article->category_id = $this->input->post('category_id');
		$article->section_id = $this->input->post('section_id');
		$article->short_content = $this->input->post('short_content');
		$article->content = $this->input->post('content');
		$article->title = $this->input->post('title');
		$article->status = $this->input->post('status');
		$created_at = $this->input->post('created_at');
		if($created_at) {
			/*preg_match_all('/^([A-Za-z]+)\s+([a-z0-9]+)\s+([A-Za-z]+)\s+([0-9]+)\s+\-\s+(.+)/', $created_at, $matches);
			$hours = date('H', strtotime(str_replace(array('pm', 'am'), array(' pm', ' am'), $matches[5][0])));
			$minutes = date('i', strtotime(str_replace(array('pm', 'am'), array(' pm', 'am'), $matches[5][0])));
			$month = date('n', strtotime($matches[3][0]));
			$date = str_replace(array('th', 'rd', 'nd'), '', $matches[2][0]);
			$year = $matches[4][0];
			$article->created_at = mktime($hours, $minutes, 0, $month, $date, $year);
			*/
			$article->created_at = strtotime($created_at);
			$article->updated_at = strtotime($created_at);
		}
		if($article->save() == FALSE) {
			flash('errors', $article->errors);
			redirect('admin/articles/edit/id/'.$article->id);
		}
		
		
		
		// Update categories that article is in
		$categories_map = (array)$this->input->post('category');
		
		// Remove any blank items in the array
		for($i = 0; $i < count($categories_map); $i++)
		{
			if(!is_numeric($categories_map[$i]) OR $categories_map[$i] <= 0)
			{
				unset($categories_map[$i]);
			}
		}
		
		if(count($categories_map) > 0)
		{
			// First remove existing categories
			$this->db->query('DELETE FROM article_categories_map WHERE article_id = '.$id);

			foreach($categories_map as $category_id)
			{
				$this->db->query('INSERT INTO article_categories_map SET article_id = '.$id.', category_id = '.$category_id);
			}
		}
		
		$this->db->where('article_id', $article->id)->delete('article_games');
		$games = explode(',', $this->input->post('games'));
		
		foreach($games as $game) {
			if($game) {
				$this->db->insert('article_games', array(
					'article_id' => $article->id,
					'game_id' => (int) $game
				));
			}
		}
		
		// Set a success message
		$this->session->set_flashdata('success', 'true');
		
		// Redirect back to article
		redirect('admin/articles/edit/id/'.$id);
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$article = new Article($id);
		if(! $article->exists()) {
			show_404();
		}
		$article->remove();
		
		$this->session->set_flashdata('success', 'Article successfully deleted');
		redirect('admin/articles/index');
	}
	
	public function upload() 
	{
		// Set variables
		$file_name = trim($this->input->post('filename'));
		$user_id = (int) $this->input->post('user_id');
		$article_id = (int) $this->input->post('article_id');
		
		if($file_name)
		{
			$source_image = FCPATH . 'uploads/photos/' . $file_name;
			$image_info = getimagesize($source_image);
			
			// Create a thumbnail
			$config['image_library'] = 'gd2';
			$config['source_image'] = $source_image;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 150;
			$config['height'] = 200;

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
			$this->db->insert('photos', array
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
				'article_id'		=> $article_id
			));
			
			echo '1';
			exit();
		}
		
		echo '0';
		exit();
	}
	
	public function search() {
	
		$q = $this->input->post('q');

		$this->db->select('a.id, a.user_id, a.title, a.created_at, b.username');
		$this->db->from('articles a');
		$this->db->join('users b', 'user_id = b.id');
		$this->db->like('title', $q);
		
		$query = $this->db->get();
		
		$result = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result[] = array(
					'title' => $row->title,
					'id' => $row->id,
					'user_id' => $row->user_id,
					'created_at' => $row->created_at,
					'username' => $row->username
				);
			}
		}
		
		$this->load->view('articles/search', array(
			'result' => $result
		));
	}

}
