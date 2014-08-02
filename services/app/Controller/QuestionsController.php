<?php
class QuestionsController extends AppController {
<<<<<<< HEAD
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
=======
var $uses = array('TestQuestion','Question','Category');
public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add','index','edit');
}

    public function index() {
        $questions = $this->Question->find('all', array('fields'=>array('id','question','option1','option2','option3','option4')));
        $Questions=array();
        foreach ($questions as $question) {
            array_push($Questions,$question['Question']);
        }
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
        $this->set(array(
            'questions' => $questions,
            '_serialize' => array('questions')
        ));
<<<<<<< HEAD
    }

    public function list_for_test($id){
        $questions = $this->Question->find('all', array(
                                                    'conditions'=>array('test_id'=>$id), 
                                                    'fields'=>array('id', 'QUESTION', 'OPTION1', 'OPTION2', 'OPTION3', 'OPTION4')
                                                    )
        );
    }
=======
        unset($questions);
        unset($Questions);
    }

    /**public function list_for_test($id){
        $questions = $this->Question->find('all', array(
                                                    'conditions'=>array('test_id'=>$id), 
                                                    'fields'=>array('id', 'question', 'option1', 'option2', 'option3', 'option4')
                                                    )
        );
        $this->set(array(
            'questions' => $questions,
            '_serialize' => array('questions')
        ));
    }*/

>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
    public function view($id) {
        $question = $this->Question->findById($id);
        $this->set(array(
            'question' => $question,
            '_serialize' => array('Question')
        ));
    }
    public function add() {
<<<<<<< HEAD
            $this->Question->create();
            if ($this->Question->save($this->request->data)) {
=======
        $data=$this->request->input('json_decode',true);
            $this->Question->create();
            if ($this->Question->save($data)) {
>>>>>>> 4c2649b073355a9ed3289f416176bca4d813ad11
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