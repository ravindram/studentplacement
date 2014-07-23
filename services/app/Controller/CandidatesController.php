<?php
class CandidatesController extends AppController{
	var $uses = array('User','College','Candidate');
	public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('add','index', 'login', 'logout');
	}
	public function login() {
		if ($this->request->is('post')) {
		$this->Auth->login();
		}
	}
	public function logout() {
		$this->Auth->logout();
	}   
	public function index(){
		$candidates = $this->Candidate->find('all');
		$this->set(array('candidates' => $candidates, '_serialize' => array('candidates')));
	}
	public function view($id) {
		$candidate = $this->Candidate->findById($id);
		$this->set(array('candidate' =>$candidate, '_serialize' => array('candidate')));
	}
	public function add() {
		$data=$this->request->input('json_decode',true);
		$candidate=$data["Candidate"];
		$user=$data['User'];
		$this->User->create();
		if($this->User->save($user)) {
			$id=$this->User->getLastInsertId(); 
			$this->Candidate->create();
			$candidate['user_id']=$id;
			$this->Candidate->save($candidate);
			$id_candidate=$this->Candidate->getLastInsertId(); 
			$message = $this->Candidate->findById($id_candidate);
		}
		else  {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function edit($id) {
		$this->Candidate->id = $id;
		if ($this->Candidate->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		}
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function delete($id) {
		if ($this->Candidate->delete($id)) {
			$message = array('text' => _('Deleted'), 'type' =>'success');
		}
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' =>array('message')));
	}
	}
	?>