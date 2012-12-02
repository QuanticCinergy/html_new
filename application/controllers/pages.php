<?php

class Pages extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function show() {
	    
	    // Array of information to be passed to views
	    $data = array('errors' => FALSE);
	    
	    if($this->input->post('submitted') && $this->uri->segment(1) == 'contact-us')
	    {
	        $data = $this->contact_us();
	    }
	    
		$title = param('title');
		if(! $title) {
			show_404();
		}
		$page = new Page;
		$page = $page->find_by_url_title($title);
		if(! $page) {
			show_404();
		}
		
		$data['page'] = $page;
		
		$this->load->view('../page_templates/'.$page->template_name, $data);
	}

    private function contact_us()
    {
        $this->load->helper('email');
        
        // Hold to submitted form
        $data = array(
            'errors'  => FALSE,
            'name'    => $this->input->post('name'),
            'email'   => $this->input->post('email'),
            'company' => $this->input->post('company'),
            'message' => $this->input->post('message')
        );
        
        // Validate input
        // Could use CI form validation here
        if(strlen(trim($data['name'])) == 0)
        {
            $data['errors'][] = 'Please enter your name';
        }
        
        if(!valid_email($data['email']))
        {
            $data['errors'][] = 'Please enter a valid email address';
        }
        
        if(strlen(trim($data['phone'])) == 0)
        {
            $data['errors'][] = 'Please enter your phone number';
        }
        
        // TinyMCE puts a <br> tag
        // even though it looks blank
        $message = $data['message'];
        $message = strip_tags($message);
        
        if(strlen(trim($message)) == 0)
        {
            $data['errors'][] = 'Please enter your message';
        }
        
        
        if(!$data['errors'])
        {
            // Send the email
            $this->load->library('email');

            $this->email->from($data['email'], 'Quantic Gaming');
            $this->email->to('info@quanticgaming.com');

            $this->email->subject($data['company']);
            $this->email->message($data['message']);	

            $this->email->send();
        }
        
        return $data;
    }
}
