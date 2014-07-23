<?php
class QuestionsController extends AppController {
var $uses = array('TestQuestion','Question');
public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add','index');
}

    public function index() {
        $questions = $this->Question->find('all', array(
                                                     
                                                    'fields'=>array('id', 'QUESTION', 'OPTION1', 'OPTION2', 'OPTION3', 'OPTION4')
                                                    )
        );
        $this->set(array(
            'questions' => $questions,
            '_serialize' => array('questions')
        ));
    }

    public function list_for_test($id){
        $questions = $this->Question->find('all', array(
                                                    'conditions'=>array('test_id'=>$id), 
                                                    'fields'=>array('id', 'QUESTION', 'OPTION1', 'OPTION2', 'OPTION3', 'OPTION4')
                                                    )
        );
    }
    public function view($id) {
        $question = $this->Question->findById($id);
        $this->set(array(
            'question' => $question,
            '_serialize' => array('Question')
        ));
    }
    public function add() {
            $this->Question->create();
            if ($this->Question->save($this->request->data)) {
                $id=$this->Question->getLastInsertId(); 
                $message = $this->Question->findById($id);
            }
            else {
            $message = 'Error';
        }
        $this->set(array(
            'response' => $message,
            '_serialize' => array('response')
        ));
            
        
    }

    public function edit($id) {
        $this->Question->id = $id;
        if ($this->Question->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function delete($id) {
        if ($this->Question->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}
?>