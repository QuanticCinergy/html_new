<?php

class Articles extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
			// Set some global variables
		$this->current_category = FALSE;
		$this->current_brand = FALSE;
		$this->current_section = FALSE;
		$this->categories = $this->db->get('shop_categories')->result_object();
		$this->brands = $this->db->get('shop_brands')->result_object();
		$this->countries = $this->db->get('shop_countries')->result_object();
		$this->cart = $this->session->userdata('cart');
	}
	
	public function index() {
		
		if(strpos($_SERVER['REQUEST_URI'], 'feed') !== FALSE)
		{
			$section_name = trim(str_replace('/articles/feed/', '', $_SERVER['REQUEST_URI']));
		
			return $this->feed($section_name);
		}
	
		$article = new Article();
		$base_url = articles_url();
		$section = param('section');
		$this->current_section = $section;
		if($section) {
			$base_url .= $section.'/';
			$_section = new Article_Section;
			$section = $_section->find_by_url_name($section);
			if(! $section) {
				show_404();
			}
			$article->where('section_id', $section->id);
		}
		$category = param('category');
		if($category) {
			$base_url .= $category.'/';
			$_category = new Article_Category;
			$category = $_category->find_by_url_name($category);
			if(! $category) {
				show_404();
			}
			$article->where('category_id', $category->id);
		}
		$article->where('status', 'published');
		$total_rows = $article->count();
		$per_page = setting('articles.per_page', FALSE, 10);
		$article->offset((int) param('page'))->limit($per_page);
		$articles = $article->get();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		
		// Get category for each article now weve moved this to a new table
		foreach($articles as $article)
		{
			$article_id = $article->id;
			
			$this->db->select('ac.url_name');
			$this->db->from('article_categories ac');
			$this->db->join('article_categories_map acm', 'acm.category_id = ac.id');
			$this->db->where('acm.article_id', $article_id);
			$this->db->limit(1);
			
			$query = $this->db->get();
			
			$article->category = new stdClass;
			
			if($query->num_rows() == 1)
			{
				$article->category->url_name = $query->row()->url_name;
			}
			else
			{
				$article->category->url_name = 'Unknown';
			}

			

			if(isset($article->section->url_name) && $article->section->url_name == 'news'){

				//get article_sync post count
				$sync_post = $this->db->where('article_sync', $article->id)->get('forum_posts')->result_array();

				if(count($sync_post) > 0){

					$thread = $this->db->where('id', $sync_post[0]['thread_id'])->get('forum_threads')->result_array();

					if(count($thread) > 0){

						$article->post_count = $thread[0]['forum_posts_number'];
						$article->thread_url = $thread[0]['id'] . '/' . $thread[0]['url_title'];

					}
				}

				//$item->post_count = $item->id;
				
				
			}
		}
		
		$this->load->view('articles/index', array(
			'articles' => $articles,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show()
	{
		$id = param('id');
		if(! $id) {
			show_404();
		}
		
		$article = new Article($id);
		if(! $article->exists()) {
			show_404();
		}
		$this->layout->title = $article->title;
		
		$section = param('section');
		$this->current_section = $section;
		
		// Related Games
		$this->db->select('a.id, a.url_title, a.title, a.genre_id');
		$this->db->from('article_games am');
		$this->db->join('games a', 'am.game_id = a.id');
		$this->db->where('am.article_id = '.$article->id);
		
		$query = $this->db->get();
		$games = array();
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$url = sprintf("games/%s/%s", $row->genre_id, $row->url_title);
				
				$games[] = array(
					'title' => $row->title,
					'url'   => site_url($url)
				);
			}
		}
		
		// Articles from those related games
		
		
		$comment = new Comment();
		$total_rows = $comment->where('resource_id', $article->id)->count();
		$offset = (int) param('page');
		$per_page = setting('comments.posts_per_page', FALSE, 20);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => article_url(param('section'), param('category'), $id, param('title'), ''),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$comment->limit($per_page)->offset($offset)->order_by('created_at', 'desc');
		$comments = $comment->get();
		
		// Get category for each article now weve moved this to a new table
		$this->db->select('ac.name');
		$this->db->from('article_categories ac');
		$this->db->join('article_categories_map acm', 'acm.category_id = ac.id');
		$this->db->where('acm.article_id', $id);
		
		$query = $this->db->get();
		
		$categories = array();
		
		if($query->num_rows() > 0)
		{
			$first = TRUE;
			
			foreach($query->result() as $row)
			{
				if($first)
				{
					$article->category = new stdClass;
					$article->category->name = $row->name;
					
					$first = FALSE;
				}
				
				$categories[] = $row->name;
			}
		}
		else
		{
			$article->category = new stdClass;
			$article->category->name = 'Unknown';
		}
		
		// Related articles
		$related_articles = array();
		
		// Get those categories this article is in
		$this->db->select('category_id');
		$this->db->from('article_categories_map');
		$this->db->where('article_id', $id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$related_categories = array();
			
			foreach($query->result() as $row)
			{
				$related_categories[] = $row->category_id;
			}
			
			$this->db->select('ac.url_name AS category_url_name, a.*, asec.url_name AS section_url_name, u.username');
			$this->db->from('article_categories_map acm');
			$this->db->join('article_categories ac', 'acm.category_id = ac.id');
			$this->db->join('articles a', 'acm.article_id = a.id');
			$this->db->join('article_sections asec', 'asec.id = a.section_id');
			$this->db->join('users u', 'a.user_id = u.id');
			$this->db->where('a.id != ',$id);
			$this->db->where_in('acm.category_id', $related_categories);
			$this->db->order_by('a.created_at', 'desc');
			$this->db->group_by('a.id');
			$this->db->limit(3);
			
			foreach($this->db->get()->result() as $row)
			{
				// We need this crappyness to keep view working without any changes
				
				// section->url_name
				$row->section = new stdClass;
				$row->section->url_name = $row->section_url_name;
				
				// category->url_name
				$row->category = new stdClass;
				$row->category->url_name = $row->category_url_name;
				
				// user->username
				$row->user = new stdClass;
				$row->user->username = $row->username;
				
				
				$related_articles[] = $row;
			}
			
		}
		
		
		$this->load->view('articles/show', array(
			'article'          => $article,
			'games'            => $games,
			'comments'         => $comments,
			'pagination'       => $this->pagination->create_links(),
			'categories'       => $categories,
			'related_articles' => $related_articles,
			'user'             => current_user()
		));
		
	}
	
	public function feed($section = FALSE)
	{
		$this->load->helper('xml');
		$this->load->helper('text');
	
		// Set params
		$section = ($section) ? $section : param('section');
		
		// Get section from the database by URL name
		$section = $this->db->from('article_sections')->where('url_name', $section)->get()->row();
		
		if( ! $section)
		{
			// No such section, go home
			redirect('/', 'refresh');
		}
		
		// Get articles that belongs to this section
		$article = new Article();
		$article->where('section_id', $section->id);
		$articles = $article->get();
		
		// Output the feed
		$this->output->set_header("Content-Type: application/rss+xml; charset=UTF-8");		
		$this->load->view('articles/feed', array
		(
			'feed_name'			=> 'Too Pixel RSS',
			'page_description'	=> 'Team Dignitas - ' . $section->name,
			'charset'			=> 'utf-8',
			'feed_url'			=> base_url(),
			'page_language'		=> 'en',
			'creator_email'		=> 'info@team-dignitas.net',
			'articles'			=> $articles
		));
	}
	
	// If signed in, get list of your articles
	public function manage() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$article = new Article();
		$base_url = manage_articles_url();
		$article->where('status', 'published');
		$article->where('user_id', current_user()->id);
		$total_rows = $article->count();
		$per_page = setting('articles.per_page', FALSE, 10);
		$article->offset((int) param('page'))->limit($per_page);
		$articles = $article->get();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		$this->load->view('articles/manage', array(
			'articles' => $articles,
			'pagination' => $this->pagination->create_links()
		));
		
	}
	
	// Create a new item
	public function add() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$category = new Article_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		$section = new Article_Section;
		$sections = array();
		foreach($section->get() as $item) {
			$sections[$item->id] = $item->name;
		}
		$spotlight = new Spotlight;
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->load->view('articles/add', array(
			'categories' => $categories,
			'sections' => $sections,
			'spotlights' => $spotlight->get()
		));
	}
	
	// Create a new item
	public function create() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$article = new Article;
		$article->user_id = current_user()->id;
		$article->category_id = $this->input->post('category_id');
		$article->section_id = 5;
		$article->short_content = character_limiter($this->input->post('short_content'), 140);
		$article->content = $this->input->post('content', FALSE);
		$article->title = $this->input->post('title');
		$article->status = $this->input->post('status');
		$article->is_approved = 0;
		if($article->save() == FALSE) {
			flash('errors', $article->errors);
			redirect('profile/posts/add');
			return;
		}
		$id = $this->input->post('spotlight_id');
		if($id) {
			$spotlight = new Spotlight($id);
			$spotlight->push('spotlight_items', array(
				'headline' => $article->title,
				'description' => $article->short_content,
				'url' => 'articles/'.$article->section->url_name.'/'.$article->category->url_name.'/'.$article->url_title,
				'image_thumb_url' => $article->image_thumb_url,
				'image_url' => $article->image_url
			), FALSE);
		}
		redirect('profile/posts');
	}
	
	// Edit existing items
	public function edit() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$id = param('id');
		if(! $id) {
			show_404();
		}
		
		$article = new Article($id);
		if(! $article->exists() || $article->user_id !== current_user()->id) {
			show_404();
		}
		$category = new Article_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		$section = new Article_Section;
		$sections = array();
		foreach($section->get() as $item) {
			$sections[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8');
		$this->load->view('articles/edit', array(
			'categories' => $categories,
			'sections' => $sections,
			'article' => $article
		));
	}
	
	// Update existing items
	public function update() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Article ID');
		}
		$article = new Article($id);
		if(! $article->exists() || $article->user_id !== current_user()->id) {
			show_404();
		}
		$article->category_id = $this->input->post('category_id');
		$article->section_id = 5;
		$article->is_approved = 0;
		$article->short_content = character_limiter($this->input->post('short_content'), 140);
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
			redirect('profile/posts/'.$article->id.'edit');
		}
		redirect('profile/posts');
	}
	
	// Remove unwanted items
	public function remove() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$article = new Article($id);
		if(! $article->exists() || $article->user_id !== current_user()->id) {
			show_404();
		}
		$article->remove();
		redirect('profile/posts');
	}
	
	// Manage unpublished items
	public function unpublished() { 
	
	if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$article = new Article();
		$base_url = articles_url();
		$article->where('status', 'draft');
		$article->where('user_id', current_user()->id);
		$total_rows = $article->count();
		$per_page = setting('articles.per_page', FALSE, 10);
		$article->offset((int) param('page'))->limit($per_page);
		$articles = $article->get();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		$this->load->view('articles/manage', array(
			'articles' => $articles,
			'pagination' => $this->pagination->create_links()
		));
	
	}
	
	// Publish a draft item
	public function submit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$article = new Article($id);
		if(! $article->exists() || $article->user_id !== current_user()->id) {
			show_404();
		}
		$article->where('id', $article->id)->set(array('status' => 'submitted'))->update('articles');
		
		redirect('profile/posts');
	}
	
}
