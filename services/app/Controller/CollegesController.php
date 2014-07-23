<?php
class CollegesController extends AppController{
	var $uses = array('User','College','Candidate');
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('add','index', 'login', 'logout');
	}
	public function login() {
	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	            $this->Auth->logout();
	        }
	    }
	}
    public function logout() {
    $this->Auth->logout();

    }   
	public function index(){
		$colleges = $this->College->find('all');
		$this->set(array('colleges' => $colleges, '_serialize' => array('colleges')));
	}

	public function view($id) {
		$college = $this->College->findById($id);
		$this->set(array('college' =>$college, '_serialize' => array('college')));
	}
	public function add() {
		$data=$this->request->input('json_decode',true);
        $college=$data["College"];
        $user=$data['User'];
        $this->User->create();
        if($this->User->save($user)){
	        $id=$this->User->getLastInsertId(); 
	        $this->College->create();
	        $college['user_id']=$id;
	        $this->College->save($college);
	        $message = $this->User->findById($id);
    	}
    	else  {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function edit($id) {
		$this->College->id = $id;
		if ($this->College->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function delete($id) {
		if ($this->College->delete($id)) {
			$message = array('text' => _('Deleted'), 'type' =>'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' =>array('message')));
	}
}
?>