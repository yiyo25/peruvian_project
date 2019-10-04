<?php
session_start();
class Files extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre	
	}	
	
	public function index($file_name){
		try{
			
			$file = '/var/www/html/STD/Files/'.$file_name;
						
			if (file_exists($file)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="'.basename($file).'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    readfile($file);
			    exit;
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->Trace = $e->getTrace();
			$this->view->render('error');			
		}	
	}	
	
	
}
?>