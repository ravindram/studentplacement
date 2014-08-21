<?php
class CandidatesController extends AppController{
	var $uses = array('User','College','Candidate','ExcelReader','CandidateList');
	public $components = array('ExcelReader','RequestHandler','Security');
	public $layout = 'homepage';            
    function blackhole() {       
        if($this->action=='design' && !isset($_SERVER['HTTPS'])) {                     
            $this->redirect('https://' . env('SERVER_NAME') . $this->here);           
        }     
    }

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'add', 'sendmail');
		$this->Security->blackHoleCallback = 'blackhole';       
        $this->Security->requireSecure();
	}
	public function sendmail(){
		$data=$this->request->input('json_decode',true);
		$email['to'] = $data['email'];
		$email['template'] =  'default';
		$email['subject'] = 'Sign up Confirmation';
		$email['content'] = array('user'=>array('user_name'=>"ravi","password"=>"hfjdf"));
		if(!$this->_sendEmail($email)){
			$message = "sending mail was failed.";
		}else{
			$message = "success.";
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
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
		if ($_FILES["file"]["error"] > 0) {
		  echo "Error: " . $_FILES["file"]["error"] . "<br>";
		} 
		elseif (file_exists("/var/www/html/studentplacement/services/app/webroot/" . $_FILES["file"]["name"])) {
		      echo $_FILES["file"]["name"] . " already exists. ";
		    } 
		else {
		      move_uploaded_file($_FILES["file"]["tmp_name"],"/var/www/html/studentplacement/services/app/webroot/" . $_FILES["file"]["name"]);
		    }
		set_time_limit(0);
		$college_id=$this->request->data['college_id'];
		$filename=$_FILES["file"]["name"];
		$file = WWW_ROOT.$filename ;  
	    $this->set('filename', $file);  
	    try {  
	       $data_array = $this->ExcelReader->loadExcelFile($file);  
	    } catch (Exception $e) {  
	       echo 'Exception occured while loading the project list file';  
	       exit;  
	    } 
	    $this->CandidateList->create();
	    $candidatelist['list_name']=$filename;
		$this->CandidateList->save($candidatelist);
		$list_id=$this->CandidateList->getLastInsertId();
	    for($i=0;$i<count($data_array);$i++){
	    	for($j=1;$j<count($data_array[$i]);$j++){
		    	$details=$data_array[$i][$j];
	    		$user['name']=$details['0'];
	    		$user['email']=$details['1'];
	    		$user['candidate']=1;
	    		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
				$count = mb_strlen($chars);

			    for ($l = 0, $result = ''; $l < 8; $l++) {
			        $index = rand(0, $count - 1);
			        $result .= mb_substr($chars, $index, 1);
			    }
			    $user['password']=$result;
			    $this->User->create();
			    if($this->User->save($user)) {
		    		$id=$this->User->getLastInsertId();
		    		$candidate['user_id']=$id;
					$candidate['college_id']=$college_id;
					$candidate['candidate_list_id']=$list_id;
					$candidate['roll_number']=$details['2'];
					$candidate['batch']=$details['3'];
					$candidate['department']=$details['4'];
					$this->Candidate->create();
					if($this->Candidate->save($candidate)){
						$email['to'] = $details['1'];
						$email['template'] =  'default';
						$email['subject'] = 'Sign up Confirmation';
						$email['content'] = array('user'=>array('user_name'=>$details['0'],"password"=>$result));
						$this->_sendEmail($email);
					}
					$message="sucess";
		    	}
			    else  {
				$message = array('text' => _('Error'), 'type' => 'error');
				}
			}
	}
		/*$data=$this->request->input('json_decode',true);
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
		}*/
		
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