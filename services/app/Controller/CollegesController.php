<?php
class CollegesController extends AppController{
	var $uses = array('User','College','Candidate');
	
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('add','index');
	}
	public function index(){
		$colleges = $this->College->find('all',array('fields'=>array('id','college_name','college_address','college_city','college_contactno')));
		$Colleges=array();
		foreach ($colleges as $college) {
			array_push($Colleges,$college['College']);
		}
		$this->set(array('Colleges' => $Colleges, '_serialize' => array('Colleges')));
		unset($Colleges);
	}

	public function view($id) {
		$college = $this->College->findById($id);
		$this->set(array('college' =>$college, '_serialize' => array('college')));
	}
	public function add() {
		$data=$this->request->input('json_decode',true);
        $college=$data["College"];
        $user=$data['User'];
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

	    for ($l = 0, $result = ''; $l < 8; $l++) {
	        $index = rand(0, $count - 1);
	        $result .= mb_substr($chars, $index, 1);
	    }
	    $user['password']=$result;
        $this->User->create();
        if($this->User->save($user)){
	        $id=$this->User->getLastInsertId(); 
	        $this->College->create();
	        $college['user_id']=$id;
	        $college['college']=1;
	        if($this->College->save($college)){
	        	$email['to'] = $user['email'];
				$email['template'] =  'default';
				$email['subject'] = 'Sign up Confirmation';
				$email['content'] = array('user'=>array('user_name'=>$user['name'],"password"=>$result));
				$this->_sendEmail($email);
	        }
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