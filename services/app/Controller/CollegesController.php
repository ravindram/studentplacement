<?php
class CollegesController extends AppController{
	var $uses = array('User','College','Candidate');
<<<<<<< HEAD
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
=======
	
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('add','index','edit');
	}
	public function index(){
		$colleges = $this->College->find('all',array('fields'=>array('id','college_name')));
		$Colleges=array();
		foreach ($colleges as $college) {
			array_push($Colleges,$college['College']);
		}
		$this->set(array('Colleges' => $Colleges, '_serialize' => array('Colleges')));
		unset($Colleges);
	}

	public function admin_view($id) {
		$college = $this->College->findById($id);
		$this->set(array('college' =>$college, '_serialize' => array('college')));
	}
	public function admin_add() {
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
		$data=$this->request->input('json_decode',true);
        $college=$data["College"];
        $user=$data['User'];
        $this->User->create();
        if($this->User->save($user)){
	        $id=$this->User->getLastInsertId(); 
	        $this->College->create();
	        $college['user_id']=$id;
<<<<<<< HEAD
=======
	        $college['college']=1;
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
	        $this->College->save($college);
	        $message = $this->User->findById($id);
    	}
    	else  {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

<<<<<<< HEAD
	public function edit($id) {
=======
	public function admin_edit($id) {
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
		$this->College->id = $id;
		if ($this->College->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

<<<<<<< HEAD
	public function delete($id) {
=======
	public function admin_delete($id) {
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
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