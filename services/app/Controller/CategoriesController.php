<?php
class CategoriesController extends AppController{
	var $uses = array('Question','Test','TestQuestion', 'Category');
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('add', 'index');
	}
	public function index(){
		$categories = $this->Category->find('all',array('fields'=>array('id','name')));
		$Categories=array();
		foreach ($categories as $category) {
			array_push($Categories, $category['Category']);
		}
		$this->set(array('categories' => $Categories, '_serialize' => array('categories')));
		unset($Categories);
	}

	public function view($id) {
		$categorie = $this->Category->findById($id);
		$this->set(array('categorie' =>$categorie, '_serialize' => array('categorie')));
	}
	public function add() {
		if ($this->Category->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else  {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function edit($id) {
		$this->Category->id = $id;
		if ($this->Category->save($this->request->data)) {
			$message = array('text' => _('Saved'), 'type' => 'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' => array('message')));
	}

	public function delete($id) {
		if ($this->Category->delete($id)) {
			$message = array('text' => _('Deleted'), 'type' =>'success');
		} 
		else {
			$message = array('text' => _('Error'), 'type' => 'error');
		}
		$this->set(array('message' => $message, '_serialize' =>array('message')));
	}
}
?>