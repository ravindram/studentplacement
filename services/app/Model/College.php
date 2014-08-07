<?php

class College extends AppModel{
	public $belongsTo = array('User');
	public $hasMany = array('Candidate');
	

}