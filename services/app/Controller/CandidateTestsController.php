<?php
class CandidateTestsController extends AppController{
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('add','index', 'edit', 'view');
	}
	public function index(){
		$candidateTests = $this->CandidateTest->find('all',array('fields'=>array('id','candidate_id','test_id','test_time','score')));
		$this->set(array('candidateTests' => $candidateTests, '_serialize' => array('candidateTests')));
	}

	public function view($id) {
		$candidateTest = $this->CandidateTest->find('all',array('fields'=>array('id','candidate_id','test_id','test_time','score'),'conditions'=>array('CandidateTest.candidate_id'=>$id)));
		$this->set(array('candidateTest' =>$candidateTest, '_serialize' => array('candidateTest')));
	}
	
	public function add() {
		$data=$this->request->input('json_decode',true);
		$CandidateTest=$data['CandidateTest']; 
		$candidatetest=array();
		$candidatetest['test_id']=$data['test_id'];
		$candidatetest['test_time']=$data['test_time'];
		
		for ($i=0; $i <count($CandidateTest) ; $i++) { 
			$candidatetest['candidate_id']=$CandidateTest[$i]['candidate_id'];
			$this->CandidateTest->create();
			if($this->CandidateTest->save($candidatetest)){
				$message='sucess';
			}
		else  {
			$message = 'failed to add.';
		}
	}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function edit($id) {
		$this->CandidateTest->id = $id;
		if ($this->CandidateTest->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function delete($id) {
		if ($this->CandidateTest->delete($id)) {
			$message = array('text' => _('Deleted'), 'type' =>'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' =>array('message')));
	}
}
?>