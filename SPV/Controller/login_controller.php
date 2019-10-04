<?php
//session_start();
class Login extends Controller {
    
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre	
	}
	
	public function index(){
		try{
            if(isset($_SESSION["usuario"])){
                $Usuario = $_SESSION["usuario"];
            } else {
                $Usuario = $_POST["usuario"];
            }
            if(isset($_SESSION["password"])){
                $Password = $_SESSION["password"];
             } else{
                $Password = $_POST["password"];
            }

            $ClassLogueo = new Login_model();
            $logueo = $ClassLogueo->Logueo(DatosConstantes::IDAPLICACION,$Usuario,$Password);
            
            if($logueo){
                $_SESSION["usuario"] = $Usuario;
                $_SESSION["password"] = $Password;
                
                $ClassUsuario = new Usuario_model();
                $this->view->objUsu = $ClassUsuario->ListarUsuario(DatosConstantes::IDAPLICACION,$Usuario,$Password);
                $UsuarioId = $this->view->objUsu["UsuarioId"];
                $_SESSION["objUsu"] = $this->view->objUsu;
                
                $ClassComponente = new Componente_model();
                $this->view->objMenu = $ClassComponente->ListarComponenteMenu(DatosConstantes::IDAPLICACION,$UsuarioId,'menu');
                $_SESSION["objMenu"] = $this->view->objMenu;
                $this->view->objBotton = $ClassComponente->ListarComponenteMenu(DatosConstantes::IDAPLICACION,$UsuarioId,'botton');
                $_SESSION["objBotton"] = $this->view->objBotton;
                $this->view->objTab = $ClassComponente->ListarComponenteMenu(DatosConstantes::IDAPLICACION,$UsuarioId,'tabulador');
                $_SESSION["objTab"] = $this->view->objTab;
                
                $this->view->render('home');
            } else {
                $this->model->Redirect(URLLOGICA);
            }
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function salir(){
		try{
            $motor = new Motor_model();
            $FLAG_estado = 0;
            $FLAG_descripion = 'OBSERVAR';            
            $motor->insertEstadoFlag($FLAG_estado,$FLAG_descripion);
            
			session_destroy();
			header('location:https://dev.peruvian.pe/loginPeruvian/ES/');
            exit();
		} catch(Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
}
?>