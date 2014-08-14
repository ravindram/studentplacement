<?php
class CandidatesController extends AppController{
	var $uses = array('User','College','Candidate','ExcelReader');
	public $components = array('ExcelReader','RequestHandler');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'add', 'sendmail');
	}
	public function sendmail(){
		$email['to'] = $this->request->data['Candidate']['email'];
		$email['template'] =  'default';
		$email['subject'] = 'Sign up Confirmation';
		$email['content'] = array('user_name'=>$this->request->data['Candidate']['name']);
		$this->output = "success";
		if(!$this->_sendEmail($email)){
			$this->Candidate->id = $user_id;
			$this->Candidate->saveField('sent_mail_status', 0);
		}
	}
	public function index(){
		$candidates = $this->Candidate->find('all',array('fields'=>array('id','user_id','college_id','roll_number','batch','department')));
	    $Candidates=array();
	    foreach ($candidates as $candidate) {
	    	array_push($Candidates,$candidate['Candidate']);
	    }
	    $this->set(array('candidates' => $Candidates, '_serialize' => 'candidates'));
	}
	
	public function view($id) {
		$candidate = $this->Candidate->findById($id);
		$this->set(array('candidate' =>$candidate, '_serialize' => array('candidate')));
	}

	public function add() {
		$file = WWW_ROOT. $filename;  
	    $this->set('filename', $file);  
	    try {  
	       $data_array = $this->ExcelReader->loadExcelFile($file);  
	    } catch (Exception $e) {  
	       echo 'Exception occured while loading the project list file';  
	       exit;  
	    } 
	    for($i=0;$i<count($data_array);$i++){
	    	for($j=1;$j<count($data_array[$i]);$j++){
		    	$candidate=$data_array[$i][$j];
		    	for($k=0;$k<count($candidate);$k++){
		    		print_r($candidate[$k]); die;
		    	}
		    }
		}
	    $this->set(array('candidates' => $data_array, '_serialize' => 'candidates'));die;
		$data=$this->request->input('json_decode',true);
		$candidate=$data["Candidate"];
		$user=$data['User'];
		$this->User->create();
		if($this->User->save($user)) {
			$id=$this->User->getLastInsertId(); 
			$this->Candidate->create();
			$candidate['user_id']=$id;
			$candidate['candidate']=1;
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