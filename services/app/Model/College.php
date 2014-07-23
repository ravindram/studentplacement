<?php

class College extends AppModel{
	public $belongsTo = array('User');
	public $hasMany = array('MyCandidate' => array('className' => 'Candidate'));
	public $validate = array('COLLEGE_NAME' => array('rule' => 'notEmpty'));

}
?>