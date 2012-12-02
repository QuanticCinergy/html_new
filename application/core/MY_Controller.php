<?php

class MY_Controller extends CI_Controller {

	public $layout;
	
	public function __construct() {
		parent::__construct();
		$this->load->library('TinyMapper');
		foreach(glob(APPPATH.'models/*_model.php') as $model) {
			if(! strpos($model, 'ion_auth')) {
				require FCPATH.$model;
			}
		}
		$this->load->library('facebook');
		$this->load->library('tweet');
		$this->load->library('ion_auth');
		$this->db->cache_off();
		$user = current_user();
		$timezone = $user && $user->timezone ? $user->timezone : 'Europe/London';
		$this->db->cache_on();
		date_default_timezone_set($timezone);
		unset($user, $timezone);
		$this->load->theme = setting('themes.default_theme');
		require(APPPATH.'libraries/Layout.php');
		$this->layout = new Layout();
	}
	
}

class Admin_Controller extends CI_Controller {

	public $layout;

	public function __construct() {
		parent::__construct();
		$this->db->cache_off();
		$this->load->library('TinyMapper');
		foreach(glob(APPPATH.'models/*_model.php') as $model) {
			if(! strpos($model, 'ion_auth')) {
				require FCPATH.$model;
			}
		}
		$this->load->library('facebook');
		$this->load->library('tweet');
		$this->load->library('ion_auth');
		
		if(! in_array($this->router->fetch_class(), array('auth')) && ! user_logged_in()) {
			if(uri_string() === 'admin')  
				{  
					redirect('admin/login');  
				}  
			else  
				{  
					redirect('admin/login?redirect='.uri_string());  
				} 
			return;
		}
		$this->load->library('ACL');
		if(! can('view_admin_panel')) {
			redirect('/');
			return;
		}
		$method = str_replace(array('index', 'create', 'update', 'show'), array('view', 'add', 'edit', 'view'), $this->router->fetch_method());
		$rule = $method.'_'.plural($this->router->fetch_class());
		$allowed = can('edit_galleries') ? array('set_as_cover', 'autocomplete') : array();
		$allowed = can('edit_settings') ? array_merge($allowed, array('multi_update')) : $allowed;
		$allowed = can('edit_users') ? array_merge($allowed, array('columns', 'create_column', 'remove_column')) : $allowed;
		if($this->router->fetch_class() !== 'home' && ! in_array($this->router->fetch_method(), $allowed) && ! can($rule)) {
			redirect('admin');
			return;
		}
		require APPPATH.'libraries/Layout.php';
		$this->load->theme = 'admin';
		$this->layout = new Layout;
		$user = current_user();
		$timezone = $user && $user->timezone ? $user->timezone : 'Europe/London';
		date_default_timezone_set($timezone);
		unset($user, $timezone);
	}
	
	public function is_ajax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }
	
}
