<?php

class User extends AppModel{
	public $hasOne = array('College','Candidate');
	
	public $validate = array(
		'username' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Username should be unique.'
				),
			'notEmpty' => array(
				'rule' => 'notEmpty', 
				'message' => 'Username should be filled.'
				)
			), 
		'password' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Password should not be empty.'
				)
		)
		);

	/**public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
        	$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    	}
    	return true;
	}
*/
}
?>