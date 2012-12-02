<?php

class Posts extends MY_Controller {

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
	
		$post = new Post();
		$base_url = posts_url();

		$category = param('category');
		if($category) {
			$base_url .= $category.'/';
			$_category = new Post_Category;
			$category = $_category->find_by_url_name($category);
			if(! $category) {
				show_404();
			}
			$post->where('category_id', $category->id);
		}
		$post->where('is_approved', 1);
		$total_rows = $post->count();
		$per_page = setting('articles.per_page', FALSE, 10);
		$post->offset((int) param('page'))->limit($per_page);
		$posts = $post->get();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		$this->load->view('posts/index', array(
			'posts' => $posts,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$post = new Post($id);
		if(! $post->exists()) {
			show_404();
		}
		
		if($post->is_approved == 0) {
			redirect('/posts', 'refresh');
		}
		
		$this->layout->title = $post->title;
		
		$comment = new Comment();
		$total_rows = $comment->where('resource_id', $post->id)->count();
		$offset = (int) param('page');
		$per_page = setting('comments.posts_per_page', FALSE, 20);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => post_url(param('category'), $id, param('title'), ''),
			'per_page' => $per_page,
			'uri_segment' => 'page',
			'total_rows' => $total_rows
		));
		$comment->limit($per_page)->offset($offset)->order_by('created_at', 'desc');
		$comments = $comment->get();
		
		$this->load->view('posts/show', array(
			'post' => $post,
			'comments' => $comments,
			'pagination' => $this->pagination->create_links()
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
	
	// If signed in, get list of your articles / posts
	public function manage() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$post = new Post();
		$base_url = manage_posts_url();
		$post->where('user_id', current_user()->id);
		$total_rows = $post->count();
		$per_page = setting('articles.per_page', FALSE, 10);
		$post->offset((int) param('page'))->limit($per_page);
		$posts = $post->get();
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => $base_url.'page/',
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'uri_segment' => 'page'
		));
		$this->load->view('posts/manage', array(
			'posts' => $posts,
			'pagination' => $this->pagination->create_links()
		));
		
	}
	
	// Create a new item
	public function add() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$category = new Post_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}

		$spotlight = new Spotlight;
		$this->layout->js = array('jquery-1.5.1.min');
		$this->layout->css = array('jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('posts/add', array(
			'categories' => $categories,
			'spotlights' => $spotlight->get()
		));
	}
	
	// Create a new item
	public function create() {
		
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$post = new Post;
		$post->user_id = current_user()->id;
		$post->category_id = $this->input->post('category_id');
		$post->short_content = character_limiter($this->input->post('short_content'), 140);
		$post->content = $this->input->post('content', FALSE);
		$post->title = $this->input->post('title');
		$post->is_approved = 0;
		if($post->save() == FALSE) {
			flash('errors', $post->errors);
			redirect('profile/posts/add');
			return;
		}
		
		$games = explode(',', $this->input->post('games'));
		
		foreach($games as $game) {
			if($game) {
				$this->db->insert('post_games', array(
					'post_id' => $post->id,
					'game_id' => (int) $game
				));
			}
		}
		
		redirect('profile/posts');
	}
	
	public function edit() {
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$id = param('id');
		if(! $id) {
			show_404();
		}
		
		$post = new Post($id);
		if(! $post->exists() || $post->user_id !== current_user()->id) {
			show_404();
		}
		
		$category = new Post_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		
		$games = $post->post_games;
		$_games = array();
		foreach($games as $game) {
			$game = new Game($game->game_id);
			$_games[] = array('id' => $game->id, 'title' => $game->title);
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers', 'jquery.tokeninput.min', 'init-games-tokeninputs', 'gallery.edit', 'gallery.progress');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8', 'jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('posts/edit', array(
			'categories' => $categories,
			'post' => $post,
			'games' => $games,
			'games_json' => json_encode($_games)
		));
	}
	
	public function update() {
	
	if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
		
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Post ID');
		}
		$post = new Post($id);
		if(! $post->exists() || $post->user_id !== current_user()->id) {
			show_404();
		}
		
		$post->category_id = $this->input->post('category_id');
		$post->is_approved = 0;
		$post->short_content = $this->input->post('short_content');
		$post->content = $this->input->post('content');
		$post->title = $this->input->post('title');
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
			$post->created_at = strtotime($created_at);
			$post->updated_at = strtotime($created_at);
		}
		if($post->save() == FALSE) {
			flash('errors', $post->errors);
			redirect('admin/posts/edit/id/'.$post->id);
		}
		
		$this->db->where('post_id', $post->id)->delete('post_games');
		$games = explode(',', $this->input->post('games'));
		
		foreach($games as $game) {
			if($game) {
				$this->db->insert('post_games', array(
					'post_id' => $post->id,
					'game_id' => (int) $game
				));
			}
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
		$post = new Post($id);
		if(! $post->exists() || $post->user_id !== current_user()->id) {
			show_404();
		}
		$post->remove();
		redirect('profile/posts');
	}
	
}
