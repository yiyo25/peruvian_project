<?php
session_start();
class error extends Controller {
	function __construct(){
			parent::__construct();  //Llama al constructor de su padre
	}
	public function index(){
		try{
			$this->view->msg="<font color=red>ERROR 404 - ALL</font>";
			$this->view->render('error');
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
		}
	}
}
?>