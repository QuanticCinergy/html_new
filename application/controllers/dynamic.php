<?php

class Dynamic extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function go() {
		$resource = param('resource');
		$id = param('id');
		if(! $resource || ! $id) {
			show_404();
		}
		$model_name = str_replace(' ', '_', humanize(singular($resource)));
		$model = new $model_name($id);
		if(! $model->exists()) {
			show_404();
		}
		redirect($model->resource_url());
	}
	
}
