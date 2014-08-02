<?php
class CandidateTestResponsesController extends AppController{
<<<<<<< HEAD
    var $uses = array('Question','TestQuestion', 'Test','CandidateTestResponse');
=======
    var $uses = array('Question','TestQuestion', 'Test','CandidateTestResponse', 'CandidateTest');
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','index');
    }

    public function index() {
<<<<<<< HEAD
        $data=$this->Auth->user();
        print_r($data['email']); die;
        $candidatetestresponse = $this->CandidateTestResponse->find('all');
=======
        $candidatetestresponse = $this->CandidateTestResponse->find('all',array('fields'=>array('id','candidate_id','test_id','question_id','response')));
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
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
<<<<<<< HEAD
        $data=$this->request->input('json_decode',true);
        print_r($data[0]['test_id']); 
        $id=$data[0]['test_id'];
        $response=array();
        $questions_id=array();
        $answer=array();
        foreach ($data as $key => $value) {
            array_push($response,$value['RESPONSE']);
        }
        print_r($response);
        $con=mysqli_connect("localhost","root","","placementapp_db");
        $result = mysqli_query($con,"SELECT * FROM test_questions
        WHERE test_id=$id");
        while($row = mysqli_fetch_array($result)) {
            array_push($questions_id,$row['question_id']);
        }
        print_r($questions_id);
        for ($i=0; $i <count($questions_id) ; $i++) {
            $con=mysqli_connect("localhost","root","","placementapp_db"); 
            $results = mysqli_query($con,"SELECT * FROM questions
            WHERE id=$questions_id[$i]");
            while($row = mysqli_fetch_array($results)) {
                array_push($answer,$row['answer']);
            }
        }
        print_r($answer);
        $r=0;
        for ($j=0; $j <count($answer) ; $j++) { 
            if($response[$j]==$answer[$j]){
                $r++;
            }
        }
        print_r($r); die;
        $this->set(array(
        'testQuestion' => $testQuestion,
        '_serialize' => array('TestQuestion')
=======
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
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
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
?>