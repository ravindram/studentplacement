<?php

class Question extends AppModel{
<<<<<<< HEAD
	public $hasMany = array('TestQuestion');
=======
	public $belongsTo = array('Category');
	public $hasMany = array('TestQuestion','CandidateTestResponse');
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
}
?>