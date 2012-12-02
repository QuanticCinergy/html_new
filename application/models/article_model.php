<?php

class Article extends TinyMapper {
	
	public
		$belongs_to = array('article_section', 'user', 'article_category'),
		$has_many = array('comments', 'article_games', 'photos'),
		$dependent = TRUE,
		$as = array(
			'category' => 'article_category',
			'section' => 'article_section',
			'game' => 'article_game'
		),
		$foreign_keys = array(
			'comments' => 'resource_id'
		),
		$where = array(
			'comments' => array(
				'resource' => 'articles'
			)
		),
		$validation = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required'
			),
			array(
				'field' => 'user_id',
				'label' => 'User ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'content',
				'label' => 'Content',
				'rules' => 'required'
			)
		),
		$created_field = 'created_at',
		$updated_field = 'updated_at',
		$has_attached = array(
			'upload_path' => './uploads/article_images',
			'allowed_types' => 'png|gif|jpeg|jpg',
			'max_size' => 10737418240,
			'driver' => 'files',
			'field_name' => 'image_article',
			'img' => array(
				'create_thumb' => TRUE,
				'width' => 191,
				'height' => 120,
				'maintain_ratio' => TRUE,
				'method' => 'resize'
			),
			'required' => FALSE
		);
	
	public function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	public function __pre_save() {
		$this->has_attached['img']['width'] = setting('articles.image_width', FALSE, 191);
		$this->has_attached['img']['height'] = setting('articles.image_height', FALSE, 120);
		$this->_properties['object']->url_title = url_title($this->_properties['object']->title);
	}
	
	public function __post_create() {
        current_user()->push('activities', array(
            'content' => 'just wrote a new blog '.link_to($this->title, dynamic_url('articles', $this->id))
        ));
    }
	
	public function __post_load($object) {
		$this->_properties['object']->content = str_replace(array('&lt;', '&gt;'), array('<', '>'), $object->content);
	}
	
	public function approve() {
		$this->is_approved = TRUE;
		$this->save();
	}
	
	public function decline() {
		$this->remove();
	}
	
	public function resource_url() {
		
		// We are now using multiple categories per article
		// Here we will look up the first category we find
		
		if(!is_numeric($this->id) OR $this->id < 0) return;
		
		$sql  = "SELECT ac.url_name FROM article_categories ac ";
		$sql .= "JOIN article_categories_map acm ON (acm.category_id = ac.id) ";
		$sql .= "WHERE acm.article_id = ".$this->id." LIMIT 1";
		
		// die($sql);
		
		$query        = $this->CI->db->query($sql);
		$category_url = 'Unknown';
		
		if($query->num_rows() > 0)
		{
			$row          = $query->row();
			$category_url = $row->url_name;
		}
		
		return article_url($this->section->url_name, $category_url, $this->id, $this->url_title);
	}
	
}
