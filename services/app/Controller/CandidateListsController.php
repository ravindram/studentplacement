<?php
class CandidateListsController extends AppController{
	var $uses = array('CandidateList','Candidate','Question','Test','TestQuestion', 'Category',);
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('add', 'index');
	}
	public function index(){
		$candidatelists = $this->CandidateList->find('all',array('fields'=>array('id','list_name')));
		$CandidateLists=array();
		foreach ($candidatelists as $candidatelist) {
			array_push($CandidateLists, $candidatelist['CandidateList']['list_name']);
		}
		$this->set(array('CandidateLists' => $CandidateLists, '_serialize' => array('CandidateLists')));
		unset($Lists);
	}

	public function view($id) {
		$candidatelist = $this->CandidateList->findById($id);
		$this->set(array('candidatelist' =>$candidatelist, '_serialize' => array('candidatelist')));
	}
	public function add() {
		if ($this->CandidateList->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else  {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function edit($id) {
		$this->CandidateList->id = $id;
		if ($this->CandidateList->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function delete($id) {
		if ($this->CandidateList->delete($id)) {
			$message = array('text' => _('Deleted'), 'type' =>'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' =>array('message')));
	}
}
?>