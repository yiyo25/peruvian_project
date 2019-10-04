<?php
if( !isset($_SESSION)){
	session_start();
}

class index extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	public function index(){
		try{
            if (isset($_SESSION['usuario'])) {
				header('Location: '.URL.'ES/login/');
			} else {
				$this->view->render('login');
			}
		} catch(Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
}
?>