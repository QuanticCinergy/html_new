<?php

class Hot_Articles extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$article = new Hot_Article;
		$this->load->view('hot_articles/index', array(
			'articles' => $article->order_by('id', 'desc')->get()
		));
	}
	
	public function add() {
		$this->load->view('hot_articles/add');
	}
	
	public function create() {
		$article = new Hot_Article;
		$article->title = $this->input->post('title');
		$article->url = $this->input->post('url');
		if($article->save() == FALSE) {
			collect('errors', $article->errors);
			$this->add();
			return;
		}
		redirect('admin/hot_articles/index');
	}
	
	public function edit() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$article = new Hot_Article($id);
		if(! $article->exists()) {
			show_404();
		}
		$this->load->view('hot_articles/edit', array(
			'article' => $article
		));
	}
	
	public function update() {
		$id = $this->input->post('id');
		if(! $id) {
			show_error('Unknown Hot Article ID');
		}
		$article = new Hot_Article($id);
		if(! $article->exists()) {
			show_404();
		}
		$article->title = $this->input->post('title');
		$article->url = $this->input->post('url');
		if($article->save() == FALSE) {
			flash('errors', $article->errors);
		}
		redirect('admin/hot_articles/index');
	}
	
	public function remove() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$article = new Hot_Article($id);
		if(! $article->exists()) {
			show_404();
		}
		$article->remove();
		redirect('admin/hot_articles/index');
	}

}
