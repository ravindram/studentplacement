<?php

class CandidateTestResponse extends AppModel{
	public $belongsTo = array('Candidate','Test','Question');
}
?>