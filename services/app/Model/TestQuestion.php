<?php

class TestQuestion extends AppModel{
	public $belongsTo = array('Question','Test');

}
?>