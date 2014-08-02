<?php  
App::uses('Component', 'Controller'); 
App::import('Vendor', 'PHPExcel/PHPExcel');  
class ExcelReaderComponent extends Component {  

 protected $PHPExcelReader;  
 protected $PHPExcelLoaded = false;  
 private $dataArray;  
 public function initialize(Controller $controller) {  
   parent::initialize($controller);  
  
   if (!class_exists('PHPExcel'))  
     throw new CakeException('Vendor class PHPExcel not found!');  
   $dataArray = array();  
 }  

 public function loadExcelFile($filename) {  
   $this->PHPExcelReader = PHPExcel_IOFactory::  
       createReaderForFile($filename);  
   $this->PHPExcelLoaded = true;  
   $this->PHPExcelReader->setReadDataOnly(true);  
   $excel = $this->PHPExcelReader->load($filename);
   $sheet_count = $excel->getSheetCount();
   for($i = 0; $i < $sheet_count; $i++){
      $this->dataArray[$i] = $excel->getSheet($i)->toArray();
   }
   return $this->dataArray;

 }  

}  
 ?>