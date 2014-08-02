<?php
class CollegesController extends AppController{
	var $uses = array('User','College','Candidate');
	
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
		$data=$this->request->input('json_decode',true);
        $college=$data["College"];
        $user=$data['User'];
        $this->User->create();
        if($this->User->save($user)){
	        $id=$this->User->getLastInsertId(); 
	        $this->College->create();
	        $college['user_id']=$id;
	        $college['college']=1;
	        $this->College->save($college);
	        $message = $this->User->findById($id);
    	}
    	else  {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function admin_edit($id) {
		$this->College->id = $id;
		if ($this->College->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function admin_delete($id) {
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