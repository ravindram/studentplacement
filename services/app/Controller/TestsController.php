<?php
class TestsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add','index');
    }

    public function index() {
        $tests = $this->Test->find('all',array('fields'=>array('id','test','test_time','test_duration')));
        $Tests=array();
        foreach ($tests as $test) {
            array_push($Tests,$test['Test']);
        }
        unset($tests['TestQuestion']);
        $this->set(array(
            'tests' => $Tests,
            '_serialize' => array('tests')
        ));
        unset($Tests);
    }
    public function view($id) {
        $test = $this->Test->findById($id);
        $this->set(array(
            'test' => $test,
            '_serialize' => array('Test')
        ));
    }
    public function add() {
        $this->Test->create();
        if ($this->Test->save($this->request->data)) {
            $id=$this->Test->getLastInsertId(); 
            $message = $this->Test->findById($id);
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
        $this->Test->id = $id;
        if ($this->Test->save($this->request->data)) {
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
        if ($this->Test->delete($id)) {
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