<?php
if( !isset($_SESSION)){
	session_start();
}

class Index extends Controller {
    
	function __construct(){
		parent::__construct(); 
		if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }///Llama al constructor de su padre	
	}
	public function index(){
		try{
            if (isset($_SESSION[NAME_SESS_USER]["id_usuario"])) {
                /*$this->view->objUsu = $_SESSION["objUsu"];
                $this->view->objMenu = $_SESSION["objMenu"];
                $this->view->objBotton = $_SESSION["objBotton"];
                $this->view->objTab = $_SESSION["objTab"];*/
				$this->view->render('home');
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