<?php

class Candidate extends AppModel{
	public $belongsTo = array('User');
	public $hasMany = array('CandidateTest','CandidateTestResponse');
}