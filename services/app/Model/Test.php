<?php

class Test extends AppModel{
	public $hasMany = array('TestQuestion','CandidateTest','CandidateTestResponse');	
}