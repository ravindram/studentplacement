<?php

class Candidate extends AppModel{
	public $belongsTo = array('User','CandidateList');
	public $hasMany = array('CandidateTest','CandidateTestResponse');
}