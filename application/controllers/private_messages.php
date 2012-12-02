<?php

class Private_Messages extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if(! user_logged_in()) {
			redirect(login_url());
			return;
		}
	}
	
	public function index() {
		$this->incoming(); // alias
	}
	
	public function incoming() {
		$message = new Private_Message;
		$page = (int) param('page');
		$user_id = current_user()->id;
		$per_page = param('private_messages.per_page', FALSE, 10);
		$messages = $message->incoming($user_id, $page, $per_page);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'uri_segment' => 'page',
			'total_rows' => $message->total_incoming($user_id),
			'per_page' => $per_page,
			'base_url' => incoming_messages_url('')
		));
		$this->load->view('private_messages/index', array(
			'messages' => $messages,
			'pagination' => $this->pagination->create_links(),
			'folder' => 'Incoming'
		));
	}
	
	public function outgoing() {
		$message = new Private_Message;
		$page = (int) param('page');
		$user_id = current_user()->id;
		$per_page = setting('private_messages.per_page', FALSE, 10);
		$messages = $message->outgoing($user_id, $page, $per_page);
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'uri_segment' => 'page',
			'total_rows' => $message->total_outgoing($user_id),
			'per_page' => $per_page,
			'base_url' => outgoing_messages_url('')
		));
		$this->load->view('private_messages/index', array(
			'messages' => $messages,
			'pagination' => $this->pagination->create_links(),
			'folder' => 'Outgoing'
		));
	}
	
	public function show() {
		$id = param('id');
		if(! $id) {
			show_404();
		}
		$message = new Private_Message($id);
		if(! $message->exists() || ! in_array(current_user()->id, array($message->sender_id, $message->receiver_id))) {
			show_404();
		}
		$message->where('sender_id', $message->sender_id)->where('receiver_id', $message->receiver_id);
		$message->read();
		$this->load->view('private_messages/show', array(
			'message' => $message
		));
	}
	
	public function compose() {
		$id = param('id');
		if($id) {
			$receiver = new User($id);
			if(! $receiver->exists()) {
				$receiver = array();
				foreach(current_user()->get_all_friends() as $friend) {
					$receiver[$friend->id] = $friend->full_name();
				}
			}
		} else {
			$receiver = array();
			foreach(current_user()->get_all_friends() as $friend) {
				$receiver[$friend->id] = $friend->full_name();
			}
		}
		$reply = param('reply');
		if($reply) {
			$message = new Private_Message($reply);
			if($message->exists()) {
				$subject = $message->subject;
				unset($message, $reply);
			}
		}	
		$this->load->view('private_messages/new', array(
			'receiver' => $receiver,
			'subject' => isset($subject) ? $subject : ''
		));
	}
	
	public function create() {
		$message = new Private_Message;
		$message->subject = $this->input->post('subject');
		$message->content = $this->input->post('content');
		$reply_id = $this->input->post('reply_to');
		if($reply_id) {
			$reply = new Private_Message($reply_id);
			$message->reply_to($reply);
		} else {
			$receiver_id = $this->input->post('receiver_id');
			$receiver = new User($receiver_id);
			$message->send_to($receiver);
		}
		redirect('profile/messages/incoming');
	}

}
