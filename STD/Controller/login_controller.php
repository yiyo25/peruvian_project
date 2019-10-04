<?php

class Login extends Controller {

	public $usuario;
	
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre	
	}
	
	public function index(){
		try{
			$this->usuario = $_POST["usuario"];
			$password = $_POST["password"];
			
			$login = new Login_model();
			$login->verificarAcceso($this->usuario,$password);
			
			if ($login->acceso) {
				$_SESSION['usuario'] = $login->acceso[0]["usu_usuario"];
				$_SESSION['nombre'] = $login->acceso[0]["usu_nombres"];
				$_SESSION['apellidos'] = $login->acceso[0]["usu_apellidos"];
				$_SESSION['dni'] = $login->acceso[0]["usu_numdoc"];
				$_SESSION['area_id'] = $login->acceso[0]["area_id"];
				$_SESSION['cargo_id'] = $login->acceso[0]["cargo_id"];
				//$_SESSION['area'] = $login->acceso[0]["area_nombre"];
				//$_SESSION['iosa'] = $login->acceso[0]["area_cod_IOSA"];
				$_SESSION['correo'] = $login->acceso[0]["usu_correo"];
				
				$this->view->render('home');
			} else {
				$this->view->Mensaje = "Ingrese correctamente sus credenciales...";
				$this->view->render('login');
				// $this->model->Redirect(URLLOGICA);
			}
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function salir(){
		try{
			session_destroy();
			$this->model->Redirect(URLLOGICA);
		} catch(Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }		
	}
}
?>