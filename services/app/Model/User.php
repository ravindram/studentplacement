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

<<<<<<< HEAD
	/**public function beforeSave($options = array()) {
=======
	public function beforeSave($options = array()) {
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
        if (isset($this->data[$this->alias]['password'])) {
        	$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    	}
    	return true;
	}
<<<<<<< HEAD
*/
=======

>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
}
?>