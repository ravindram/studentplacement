<?php
class CandidateTestResponsesController extends AppController{
    var $uses = array('Question','TestQuestion', 'Test','CandidateTestResponse', 'CandidateTest');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','index');
    }

    public function index() {
        $candidatetestresponse = $this->CandidateTestResponse->find('all',array('fields'=>array('id','candidate_id','test_id','question_id','response')));
        $this->set(array(
            'candidatetestresponse' => $candidatetestresponse,
            '_serialize' => array('candidatetestresponse')
        ));   
    }

    public function view($id) {
        $candidatetestresponse = $this->CandidateTestResponse->findById($id);
        $this->set(array(
            'candidatetestresponse' => $candidatetestresponse,
            '_serialize' => array('CandidateTestResponseCandidateTestResponse')
        ));
    }

    public function add() {
       $data=$this->Auth->user();
        $user_id=$data['id'];
        $data=$this->request->input('json_decode',true);
        $test_id=$data['test_id']; 
        $testresponses=$data['testresponse'];
        $TestResponse=array();
        $questions=array();
        foreach ($testresponses as $testresponse) {
            array_push($TestResponse,$testresponse['response']);
            array_push($questions,$testresponse['question_id']);
        }
        
        $score=0;
        for ($i=0; $i < count($questions); $i++) {
            $que_id= $questions[$i];
            $question=$this->Question->findById($que_id);
            
            if($TestResponse[$i]==$question['Question']['answer']){
                $score++;
           }
        }
        for ($j=0; $j <count($TestResponse) ; $j++) { 

            $this->CandidateTestResponse->create();
            $candidatetestresponse['candidate_id']=$user_id;
            $candidatetestresponse['test_id']=$test_id;
            $candidatetestresponse['question_id']=$questions[$j];
            $candidatetestresponse['response']=$TestResponse[$j];
            $this->CandidateTestResponse->save($candidatetestresponse);
        }
        $candidatetest=$this->CandidateTest->find('first',array('conditions'=>array('CandidateTest.test_id'=>$test_id,'CandidateTest.candidate_id'=>$user_id),'fields'=>array('id')));
        $this->CandidateTest->id =$candidatetest['CandidateTest']['id'];
        $this->CandidateTest->saveField("score",$score);

        $candidatetestresponse=$this->CandidateTestResponse->find('all',array('conditions'=>array('CandidateTestResponse.test_id'=>$test_id,'CandidateTestResponse.candidate_id'=>$user_id),'fields'=>array('question_id','response')));
        
        /**if ($this->request->is('post')) {
            $this->CandidateTestResponse->create();
            if ($this->CandidateTestResponse->save($this->request->data)) {
                $message="saved";
            }
        }*/
        $this->set(array(
        'candidatetestresponse' => $candidatetestresponse,
        '_serialize' => array('candidatetestresponse')
        ));
    }

    public function edit($id) {
        $this->CandidateTestResponse->id = $id;
        if ($this->CandidateTestResponse->save($this->request->data)) {
            $message = 'Saved';
        } 
        else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function delete($id) {
        if ($this->CandidateTestResponse->delete($id)) {
            $message = 'Deleted';
        } 
        else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}