<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->current_section = FALSE;
	}

	public function index()
	{
		if (! user_logged_in())
		{
			redirect(login_url(), 'refresh');
			return;
		}
		redirect('profile/edit', 'refresh');
	}
	
	public function twt_sign_in() {
		if(! $this->tweet->logged_in()) {
			$this->tweet->set_callback(base_url().'auth/twt_sign_in');
			$this->tweet->login();
		} else {
			$twt_user = $this->tweet->call('get', 'account/verify_credentials');
			$result = $this->db->limit(1)->where('twt_id', $twt_user->id_str)->get('meta');
			if($result->num_rows() == 1) {
				redirect(profile_url());
				return;
			}
			$user = new User;
			$user->group_id = 2;
			$user->username = $twt_user->screen_name;
			$user->avatar_thumb_url = $twt_user->profile_image_url;
			$user->avatar_url = $twt_user->profile_image_url;
			$user->save(FALSE);
			list($first_name, $last_name) = explode(' ', $twt_user->name);
			$this->db->insert('meta', array(
				'user_id' => $user->id,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'twt_id' => $twt_user->id_str
			));
			redirect('profile/edit');
		}
	}
	
	public function fb_sign_in() {
		if(! $this->facebook->logged_in()) {
			$this->facebook->set_callback(base_url().'auth/fb_sign_in');
			$this->facebook->login();
		} else {
			$fb_user = $this->facebook->call('get', 'me', array('metadata' => 1))->__resp->data;
			$result = $this->db->limit(1)->where('fb_id', $fb_user->id)->get('meta');
			if($result->num_rows() == 1) {
				redirect(profile_url());
				return;
			}
			$user = new User;
			$user->group_id = 2;
			$user->username = str_replace(' ', '_', strtolower($fb_user->name));
			$user->avatar_thumb_url = 'http://graph.facebook.com/'.$fb_user->id.'/picture?type=large';
			$user->avatar_url = 'http://graph.facebook.com/'.$fb_user->id.'/picture?type=large';
			$user->save(FALSE);
			$this->db->insert('meta', array(
				'user_id' => $user->id,
				'first_name' => $fb_user->first_name,
				'last_name' => $fb_user->last_name,
				'fb_id' => $fb_user->id
			));
			redirect('profile/edit');
		}
	}

	//forgot password
	public function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);
			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->view('auth/forgot_password', $this->data);
		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ //if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("forgotten", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code)
	{
		$reset = $this->ion_auth->forgotten_password_complete($code);

		if ($reset)
		{  //if the reset worked then send them to the login page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("login", 'refresh');
		}
		else
		{ //if the reset didnt work then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("forgotten", 'refresh');
		}
	}

	public function sign_in()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
			{
				redirect('profile/edit', 'refresh');
			} else {
				collect('message', $this->ion_auth->errors());
				$this->load->view('auth/sign_in'); 
			}
		}
		else
		{
			collect('errors',  (validation_errors()) ? explode("\n", validation_errors()) : FALSE);
			$this->load->view('auth/sign_in');
		}
	}
	
	public function logout()
	{
		$this->ion_auth->logout();
		$this->facebook->logout();
		$this->tweet->logout();
		redirect(login_url(), 'refresh');
	}
	
	public function sign_up()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password_confirm]');

		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if ($this->form_validation->run() == true && ! username_check($username))
		{
			if($this->ion_auth->register($username, $password, $email, array()) == TRUE) {
				redirect(activation_url(), 'refresh');
			} else {
				collect('errors', validation_errors() ? explode("\n", validation_errors()) : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			}
		} else {
			collect('errors', explode("\n", validation_errors()));
		}
		$this->load->view('auth/sign_up');
	}
	
	public function activation() {
		$this->load->view('auth/activation');
	}
	
	public function activate() {
		$user_id = $this->uri->segment(3);
		$code = $this->uri->segment(4);
		if($this->ion_auth->activate($user_id, $code)) {
			redirect(login_url());
			return;
		} else {
			// @TODO
		}
	}

	private function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	private function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
