<?php
class TestQuestionsController extends AppController{
    var $uses = array('Question','TestQuestion', 'Test');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','index','view');
    }

    public function index($id) {
        $testQuestions = $this->TestQuestion->find('all',array('conditions'=>array('TestQuestion.test_id'=>$id))); 
        $Test=$testQuestions[0]['Test'];
        $questions=array();
        $test=array();
        array_push($test,$Test['id']);
        array_push($test,$Test['test']);
        array_push($test,$Test['test_duration']);
        foreach ($testQuestions as $testQuestion) {
            $question=$testQuestion['Question'];
            array_splice($question, 6, 5);
            array_push($questions,$question);
        }
        $TestQuestions=array("Test"=>$test,"Questions"=>$questions);
        $this->set(array(
        'TestQuestions' => $TestQuestions,
        '_serialize' => array('TestQuestions')
        ));  
        unset($testquestion);
    }
    public function view($id) {
        $testQuestion = $this->TestQuestion->findById($id);
        $this->set(array(
        'testQuestion' => $testQuestion,
        '_serialize' => array('TestQuestion')
        ));
    }
    public function add() {
        $data=$this->request->input('json_decode',true);
        $test=$data['Test'];
        $testquestion=$data['TestQuestion'];
        $no=array();
        $id_category=array(); 
        foreach ($data['TestQuestion'] as $key => $value) {
            array_push($no,$value['no']);
            array_push($id_category,$value['category_id']);
        }
        
        $this->Test->create();
        if($this->Test->save($test)){
            $id=$this->Test->getLastInsertId();
            $questions = $this->Question->find('all');
            for ($i=0; $i <count($no) ; $i++) { 
                for($j=1;$j<=5;$j++){
                    $que=array();
                    foreach ($questions as $question) {
                        if($question['Question']['category_id']==$id_category[$i] && $question['Question']['difficulty_level']==$j){
                            array_push($que,$question['Question']['id']);
                        }
                    } 
                    shuffle($que); 
                    $num=$no[$i]/5;
                    for ($k=0; $k <$num ; $k++) { 
                        $this->TestQuestion->create();
                        $testquestion['test_id']=$id;
                        $testquestion['question_id']=$que[$k];
                        $this->TestQuestion->save($testquestion);
                    }     
                }
            }   
        }
        $id=$this->Test->getLastInsertId();
        $testQuestion=$this->TestQuestion->find('all', array('conditions'=>array('test_id'=>$id)));
        
        $this->set(array(
        'testQuestion' => $testQuestion,
        '_serialize' => array('testQuestion')
        ));
    }

    public function edit($id) {
        $this->TestQuestion->id = $id;
        if ($this->TestQuestion->save($this->request->data)) {
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
        if ($this->TestQuestion->delete($id)) {
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