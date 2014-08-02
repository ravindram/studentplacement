<?php

class Question extends AppModel{
	public $belongsTo = array('Category');
	public $hasMany = array('TestQuestion','CandidateTestResponse');
}