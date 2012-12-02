<?php

class Private_Message extends TinyMapper {

	protected
		$belongs_to = array('user'),
		$created_field = 'created_at',
		$table = 'private_messages',
		$primary_key = 'id',
		$as = array(
			'sender' => 'user',
			'receiver' => 'user'
		),
		$validation = array(
			array(
				'field' => 'sender_id',
				'label' => 'Sender ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'receiver_id',
				'label' => 'Receiver ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'content',
				'label' => 'Content',
				'rules' => 'required'
			)
		);

	public function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	public function __post_load($object) {
		if(! $object->subject) {
			$this->_properties['object']->subject = 'No subject';
		}
	}
	
	public function incoming($user_id, $page = 0, $limit = 10) {
		$this->CI->db->where('receiver_id', $user_id)->where('folder', 'incoming')->offset($page)->limit($limit);
		return $this->get();
	}
	
	public function total_incoming($user_id) {
		return $this->CI->db->where('receiver_id', $user_id)->where('folder', 'incoming')->count_all_results('private_messages');
	}
	
	public function outgoing($user_id, $page = 0, $limit = 10) {
		$this->CI->db->where('sender_id', $user_id)->where('folder', 'outgoing')->offset($page)->limit($limit);
		return $this->get();
	}
	
	public function total_outgoing($user_id) {
		return $this->CI->db->where('sender_id', $user_id)->where('folder', 'outgoing')->count_all_results('private_messages');
	}
	
	public function send_to(User $user) {
		$this->sender_id = current_user()->id;
		$this->receiver_id = $user->id;
		$this->save();
		$message = new Private_Message;
		$message->sender_id = $this->sender_id;
		$message->receiver_id = $this->receiver_id;
		$message->subject = $this->subject;
		$message->content = $this->content;
		$message->folder = 'outgoing';
		$message->save();
	}
	
	public function reply_to(Private_Message $_message) {
		$message = new Private_Message();
		$message->sender_id = $_message->receiver_id;
		$message->receiver_id = $_message->sender_id;
		$message->subject = $this->subject;
		$message->content = $this->content;
		$message->save();
		$this->sender_id = $_message->receiver_id;
		$this->receiver_id = $_message->sender_id;
		$this->folder = 'outgoing';
		$this->save();
	}
	
	public function read() {
		$this->CI->db->set(array(
			'is_read' => '1'
		))->where('receiver_id', $this->receiver_id)->where('sender_id', $this->sender_id)->where('folder', 'outgoing')->update('private_messages');
		$this->is_read = '1';
		$this->save();
	}

}
