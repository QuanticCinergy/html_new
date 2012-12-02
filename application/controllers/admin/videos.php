<?php

class Videos extends Admin_Controller {

	public $menu = array(
		'consists_of' => array('files'),
		'show' => TRUE,
		'as' => 'Media'
	);

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$video = new Video;
		$base_url = '/admin/videos/index/';
		$category_id = param('category_id');
		if($category_id) {
			$base_url .= 'category_id/'.$category_id.'/';
			$video->where('category_id', $category_id);
		}
		$user_id = param('user_id');
		if($user_id) {
			$base_url .= 'user_id/'.$user_id.'/';
			$video->where('user_id', $user_id);
		}
		$total_rows = $video->count();
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
		
		$videos = $video->limit(10)->offset((int) param('page'))->order_by('created_at', 'desc')->get();
		
		$this->load->view('videos/index', array(
			'videos' => $videos,
			'pagination' => $this->pagination->create_links()
		));
	}
	
	public function add() {
		$category = new Video_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		$this->layout->js = array('jquery-1.5.1.min', 'jquery.tokeninput.min', 'init-games-tokeninputs', 'tiny_mce/jquery.tinymce', 'init-tinymce');
		$this->layout->css = array('jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('videos/add', array(
			'categories' => $categories
		));
	}
	
	public function create() {
		$video = new Video;
		$video->user_id = current_user()->id;
		$video->category_id = $this->input->post('category_id');
		$video_url = $this->input->post('video_url');
		$url = parse_url($video_url);
		parse_str($url['query']);
		$video->embed_code = '<iframe title="YouTube video player" width="630" height="390" src="http://www.youtube.com/embed/'.$v.'" frameborder="0" allowfullscreen></iframe>';
		$video->title = $this->input->post('title');
		if($video->save() == FALSE) {
			flash('errors', $video->errors);
			redirect('admin/videos/add');
			return;
		}
		
		// Save attached games
		$games = explode(',', $this->input->post('games'));
		
		foreach($games as $game) {
			if($game) {
				$this->db->insert('video_games', array(
					'video_id' => $video->id,
					'game_id' => (int) $game
				));
			}
		}
		
		// Set a success message
		$this->session->set_flashdata('success', 'true');
		redirect('admin/videos/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$video = new Video($id);
		if(! $video->exists()) {
			show_404();
		}
		$category = new Video_Category;
		$categories = array();
		foreach($category->get() as $item) {
			$categories[$item->id] = $item->name;
		}
		preg_match_all("/(\S+)=[\"']?((?:.(?![\"']?\s+(?:\S+)=|[>\"']))+.)[\"']?/", $video->embed_code, $match);
		$src_index = NULL;
		foreach($match[1] as $index=>$attr) {
			if($attr == 'src') {
				$src_index = $index;
				break;
			}
		}
		$video_url = '';
		if($src_index) {
			$src = $match[2][$src_index];
			preg_match('/embed\/(.+)/', $src, $match);
			$video_url = 'http://youtube.com/watch?v='.$match[1];
		}
		
		$games = $video->video_games;
		$_games = array();
		foreach($games as $game) {
			$game = new Game($game->game_id);
			$_games[] = array('id' => $game->id, 'title' => $game->title);
		}
		
		$this->layout->js = array('jquery-1.5.1.min', 'tiny_mce/jquery.tinymce', 'init-tinymce', 'jquery-ui-1.8.min', 'jquery-ui-timepicker.min', 'init-datepickers', 'jquery.tokeninput.min', 'init-games-tokeninputs', 'gallery.edit', 'gallery.progress');
		$this->layout->css = array('jquery-ui/ui-lightness/jquery-ui-1.8', 'jquery-tokeninput/token-input', 'jquery-tokeninput/token-input-facebook');
		$this->load->view('videos/edit', array(
			'categories' => $categories,
			'video' => $video,
			'video_url' => $video_url,
			'games' => $games,
			'games_json' => json_encode($_games)
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Undefined Video ID');
		}
		$video = new Video($id);
		if(! $video->exists()) {
			show_404();
		}
		$video->category_id = $this->input->post('category_id');
		$video_url = $this->input->post('video_url');
		$url = parse_url($video_url);
		parse_str($url['query']);
		$video->embed_code = '<iframe title="YouTube video player" width="630" height="390" src="http://www.youtube.com/embed/'.$v.'" frameborder="0" allowfullscreen></iframe>';
		$video->title = $this->input->post('title');
		if($video->save() == FALSE) {
			flash('errors', $video->errors);
		}
		
		$this->db->where('video_id', $video->id)->delete('video_games');
		$games = explode(',', $this->input->post('games'));
		
		foreach($games as $game) {
			if($game) {
				$this->db->insert('video_games', array(
					'video_id' => $video->id,
					'game_id' => (int) $game
				));
			}
		}
		
		// Set a success message
		$this->session->set_flashdata('success', 'true');
		redirect('admin/videos/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$video = new Video($id);
		if(! $video->exists()) {
			show_404();
		}
		$video->remove();
		redirect('admin/videos/index');
	}

}
