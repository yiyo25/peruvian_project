<?php

class Index extends Controller {
	function __construct(){
		parent::__construct();
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }
	}
	public function index(){

		try{
			if (isset($_SESSION[NAME_SESS_USER]["id_usuario"])) {
				$this->view->render('home');
			} else {
                header('location:'.URL_LOGIN_APP);
                exit;
			}
		} catch(Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->Trace = $e->getTrace();
			$this->view->render('error');
        }
	}
}
?>