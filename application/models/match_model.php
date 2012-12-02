<?php

class Match extends TinyMapper {

	protected
		$table = 'matches',
		$has_one = array('squad'),
		$validation = array(
			array(
				'field' => 'squad_id',
				'label' => 'Squad ID',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'starts_at',
				'label' => 'Starting Date',
				'rules' => 'required'
			),
			array(
				'field' => 'tournament',
				'label' => 'Tournament',
				'rules' => 'required'
			)
		);

	public function __construct($data = NULL) {
		parent::__construct($data);
	}
	
	public function won() {
		if(! isset($this->score) || ! isset($this->opponent_score)) {
			return FALSE;
		}
		return $this->score > $this->opponent_score ? TRUE : FALSE;
	}
	
	public function vs() {
		return setting('teams.team_name').' vs '.$this->opponent;
	}

}
