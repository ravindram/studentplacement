<?php
class CandidateTestResponsesController extends AppController{
    var $uses = array('Question','TestQuestion', 'Test','CandidateTestResponse');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','index');
    }

    public function index() {
        $data=$this->Auth->user();
        print_r($data['email']); die;
        $candidatetestresponse = $this->CandidateTestResponse->find('all');
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