<?php
class QuestionsController extends AppController {
var $uses = array('TestQuestion','Question','Category');

public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add','index','edit');
}

    public function index() {
        $questions = $this->Question->find('all', array('fields'=>array('id','question','option1','option2','option3','option4','category_id','answer')));
        $Questions=array();
        foreach ($questions as $question) {
            array_push($Questions,$question['Question']);
        }
        $this->set(array(
            'questions' => $Questions,
            '_serialize' => array('questions')
        ));
        unset($questions);
        unset($Questions);
    }

    public function view($id) {
        $question = $this->Question->findById($id);
        $this->set(array(
            'question' => $question,
            '_serialize' => array('Question')
        ));
    }

    public function add() {
        $data=$this->request->input('json_decode',true);
            $this->Question->create();
            if ($this->Question->save($data)) {
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