<?php

class College extends AppModel{
	public $belongsTo = array('User');
<<<<<<< HEAD
	public $hasMany = array('MyCandidate' => array('className' => 'Candidate'));
=======
	public $hasMany = array('Candidate');
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
	public $validate = array('COLLEGE_NAME' => array('rule' => 'notEmpty'));

}
?>