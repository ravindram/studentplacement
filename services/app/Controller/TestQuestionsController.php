<?php
class TestQuestionsController extends AppController{
    var $uses = array('Question','TestQuestion', 'Test');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','index');
    }

<<<<<<< HEAD
    public function index() {
        $id=54;

        $testQuestions = $this->TestQuestion->find('all',array('conditions'=>array('test_id'=>$id))); 
        $test=$testQuestions[0]['Test'];
        print_r($test['test']);
        $testquestion=array();
        foreach ($testQuestions as $testQuestion) {
            $question=$testQuestion['Question'];
            //unset($question['answer']);
            array_splice($question, 6, 6);
=======
    public function index($id) {
        $testQuestions = $this->TestQuestion->find('all',array('conditions'=>array('test_id'=>$id))); 
        $test=$testQuestions[0]['Test'];
        $testquestion=array();
        $test=$test['test'];
        array_push($testquestion,$test);
        foreach ($testQuestions as $testQuestion) {
            $question=$testQuestion['Question'];
            //unset($question['answer']);
            array_splice($question, 6, 5);
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
            array_push($testquestion,$question);
        }
        $this->set(array(
        'testquestion' => $testquestion,
        '_serialize' => array('testquestion')
<<<<<<< HEAD
        ));   
=======
        ));  
        unset($testquestion);
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
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
<<<<<<< HEAD
=======
        print_r($no);
        print_r($id_category); 
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
        $this->Test->create();
        if($this->Test->save($test)){
            $id=$this->Test->getLastInsertId();
            $questions = $this->Question->find('all');
            for ($i=0; $i <count($no) ; $i++) { 
                for($j=1;$j<=5;$j++){
                    $que=array();
                    foreach ($questions as $question) {
<<<<<<< HEAD
                        if($question['Question']['category_id']==$id_category[$i] && $question['Question']['DIFFICULTY_LEVEL']==$j){
=======
                        if($question['Question']['category_id']==$id_category[$i] && $question['Question']['difficulty_level']==$j){
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
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
<<<<<<< HEAD
                    }      
                }
            }   
        }
        $id_que=$this->TestQuestion->getLastInsertId();
        $testQuestion = $this->TestQuestion->findById($id_que);
        $this->set(array(
        'testQuestion' => $testQuestion,
        '_serialize' => array('TestQuestion')
=======
                    }     
                }
            }   
        }
        $id=$this->Test->getLastInsertId();
        $testQuestion=$this->TestQuestion->find('all', array('conditions'=>array('test_id'=>$id)));
        
        $this->set(array(
        'testQuestion' => $testQuestion,
        '_serialize' => array('testQuestion')
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
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
?>