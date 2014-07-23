<?php
  class UsersController extends AppController {

    var $uses = array('User','College','Candidate');
    
    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('login', 'logout');
    }
    
public function register(){
    if(!empty($this->request->data)){
    $this->request->data['User']['password'] = Security::hash(Configure::read('Security.salt').$this->data['User']['password']);
    if($this->User->save($this->request->data)){
    $message = "success";
    }else{
    $this->output = array_merge($this->User->invalidFields());
    throw new DataValidationException($this->output);
    }
    }else{
    throw new DataValidationException('Post data required to create user');
    }
    $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

}

public function login() {

        $valid_login = false;
        $user = $this->Auth->user();
        if ($user) {
            $this->Auth->logout();
        }
        $this->data = $this->request->input('json_decode', true);
        if (!empty($this->data) && is_array($this->data)) {
            if (empty($this->data['User'])) {
                $data = array();
                $data['User'] = $this->data;
                $this->data = $data;
            }
            if (!empty($this->data['User']['email']) && !empty($this->data['User']['password'])) {
                $email = $this->data['User']['email'];
                $password = Security::hash(Configure::read('Security.salt') . $this->data['User']['password']);
                $user_details = $this->User->find('first', array('conditions' => array('User.email' => $email, 'User.password' => $password), 'recursive' => -1));
                if ($user_details) {
                    if (empty($user_details['is_active'])) {
                        $message="error";
                    }
                }
            }
            if ($this->Auth->login()) {
                $message = "sucess";
                $valid_login = true;
            }
            else {
            $message="Invalid login";
        }
        }
        /**if ($valid_login == true) {
            //$this->get_details();
            
        }*/ 
        $this->set(array(
            'response' => $message,
            '_serialize' => array('response')
        ));
    }
    public function logout() {
        $this->Auth->logout();

    }   

    public function index() {

        $users = $this->User->find('all');
        $this->set(array(
            'users' => $users,
            '_serialize' => array('users')
        ));
    }
    public function view($id) {
        $user = $this->User->findById($id);
        $this->set(array(
            'user' => $user,
            '_serialize' => array('User')
        ));
    }
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $id=$this->User->getLastInsertId(); 
                $message = $this->User->findById($id);
            }
            else {
            $message = 'Error';
        }
        $this->set(array(
            'response' => $message,
            '_serialize' => array('response')
        ));
            
        }
    
    }

    public function edit($id) {
        $this->User->id = $id;
        if ($this->User->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(

            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function delete($id) {
        if ($this->User->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}
?>