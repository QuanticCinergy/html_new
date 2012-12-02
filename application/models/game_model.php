<?php

class Game extends TinyMapper {

	protected
		$table = 'games',
		$belongs_to = array('game_genre', 'game_hubs'),
		$has_many = array('game_trackers', 'articles', 'game_hubs'),
		$as = array(
			'genre' => 'game_genre',
			'hub' => 'game_hub',
			'members' => 'game_trackers'
		),
		$validation = array(
			array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required'
			)
		);
		
	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function __pre_save() {
		$this->_properties['object']->url_title = url_title($this->_properties['object']->title);

	}
	
	public function friend_exists(User $user) {
		return (bool) $this->CI->db->where('status', 'accepted')->where('user_id', $user->id)->where('friend_id', $this->id)->or_where('user_id', $this->id)->where('friend_id', $user->id)->where('status', 'accepted')->limit(1)->count_all_results('friends');
	}
	
	public function is_friend_requested(User $user) {
		return (bool) $this->CI->db->where('status', 'pending')->where('user_id', $user->id)->where('friend_id', $this->id)->or_where('user_id', $this->id)->where('friend_id', $user->id)->where('status', 'pending')->limit(1)->count_all_results('friends');
	}
	
	public function add_friend(User $user, $accepted = FALSE) {
		if($this->friend_exists($user)) {
			return FALSE;
		}
		$this->CI->db->insert('friends', array(
			'user_id' => $this->id,
			'friend_id' => $user->id,
			'sender_id' => $this->id,
			'status' => ($accepted == TRUE ? 'accepted' : 'pending')
		));
		return TRUE;
	}
	
	public function delete_friend(User $user) {
		$this->CI->db->where('friend_id', $this->id)->where('user_id', $user->id)->or_where('user_id', $this->id)->where('friend_id', $user->id)->limit(1)->delete('friends');
	}
	
	public function accept_friend(User $user) {
		$this->CI->db->where('friend_id', $this->id)->where('sender_id', $user->id)->set(array('status' => 'accepted'))->update('friends');
		$this->push('activities', array(
			'content' => 'is now friends with '.link_to($user->username, dynamic_url('users', $user->id))
		));
	}
	
	public function deny_friend(User $user) {
		$this->CI->db->where('friend_id', $this->id)->where('sender_id', $user->id)->set(array('status' => 'denied'))->update('friends');
	}
	
	public function get_friends($page = 0, $limit = 20) {
		$users = array();
		$result = $this->CI->db->where('status', 'accepted')->where('friend_id', $this->id)->or_where('user_id', $this->id)->where('status', 'accepted')->limit($limit)->offset($page)->get('friends');
		if(! $result) {
			return array();
		}
		$result = $result->result_object();
		foreach($result as $user) {
			$users[] = new User($user->friend_id == $this->id ? $user->user_id : $user->friend_id);
		}
		return $users;
	}
	
	public function get_pending_friends() {
		$result = $this->CI->db->where('friend_id', $this->id)->where('status', 'pending')->where('sender_id !=', $this->id)->get('friends');
		if(! $result) {
			return array();
		}
		$result = $result->result_object();
		$users = array();
		foreach($result as $user) {
			$users[] = new User($user->sender_id);
		}
		return $users;
	}
	
	public function get_all_friends() {
		return $this->get_friends(FALSE, FALSE);
	}
	
	public function total_friends($status = 'accepted') {
		return $this->CI->db->where('user_id', $this->id)->where('status', $status)->count_all_results('friends');
	}
	
}
