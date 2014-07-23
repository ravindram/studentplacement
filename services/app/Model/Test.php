<?php

class Test extends AppModel{
	public $hasMany = array('MyTestQuestion' => array('className' => 'TestQuestion'));
}
?>