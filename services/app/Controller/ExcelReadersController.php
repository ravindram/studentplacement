<?php
class ExcelReadersController extends AppController {
	public $components = array('ExcelReader','RequestHandler');
	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('index');
	}
	public function index() {
		$filename = "wordfrequency.xls";
		//print_r(WWW_ROOT ); die;
		
		$file = WWW_ROOT. $filename;  
	    $this->set('filename', $file);  
	    try {  
	       $data_array = $this->ExcelReader->loadExcelFile($file);  
	    } catch (Exception $e) {  
	       echo 'Exception occured while loading the project list file';  
	       exit;  
	    }   
	    //print_r($data_array); die;
	    $this->set(array('candidates' => $data_array, '_serialize' => 'candidates'));
	}
}