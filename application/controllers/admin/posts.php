<?php

class Posts extends Admin_Controller {

	public $menu = array(
		'consists_of' => array('post_categories'),
		'show' => FALSE
	);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$post = new Post;
		$base_url = '/admin/posts/';
		$category_id = param('category_id');
		if($category_id) {
			$base_url .= 'category_id/'.$category_id.'/';
			$post->where('category_id', $category_id);
		}
		$user_id = param('user_id');
		if($user_id) {
			$base_url .= 'user_id/'.$user_id.'/';
			$post->where('user_id', $user_id);
		}
		
		$is_approved = param('is_approved');
		if($is_approved) {
			$base_url .= 'is_approved/'.$is_approved.'/';
			$post->where('is_approved', $is_approved);
		}
		
		$total_rows = $post->count();
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
		
		$posts = $post->limit(10)->offset((int) param('page'))->order_by('created_at', 'desc')->get();
		
		$users = array();
		$categories = array();
		foreach($posts as $post) {
			$users[$post->user->id] = $post->user->full_name();
		}

		$category = new Post_Category;
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'articles.index');
		$this->load->view('posts/index', array(
			'posts' => $posts,
			'users' => $users,
			'categories' => $categories,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$post = new Post($id);
		if(! $post->exists()) {
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
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Post ID');
		}
		$post = new Post($id);
		if(! $post->exists()) {
			show_404();
		}
		$post->category_id = $this->input->post('category_id');
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
		
		redirect('admin/posts/index');
	}
	
	public function approve() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$post = new Post($id);
		if(! $post->exists()) {
			show_404();
		}
		
		$post->where('id', $post->id)->set(array('is_approved' => 1))->update('posts');
		
		redirect('admin/posts/index');
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
		redirect('admin/articles/index');
	}

}
