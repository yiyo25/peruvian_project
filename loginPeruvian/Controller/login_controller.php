<?php
class Login extends Controller {
    public $jwt;
	function __construct(){
		parent::__construct(); 
        $this->jwt = new JWTLibs(); //Llama al constructor de su padre	
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
                $Password = md5($_POST["password"]);
            }
            
            $classApiLogin = new ApiLogin();
            $api_UserLogin = $classApiLogin->GetUserLogin($Usuario,$Password);
            if( $api_UserLogin->Result === "1" ){
                $this->view->objloginError = $api_UserLogin->Mensaje;
                $this->view->render('login');
            } else if( $api_UserLogin->Result === "0" ){
                $_SESSION["usuario"] = $Usuario;
                $_SESSION["password"] = $Password;
                $api_ListaAplicaciones = $classApiLogin->GetAccesoListaSistemas(EMPRESA,$Usuario);
                if(isset($api_ListaAplicaciones->result) && $api_ListaAplicaciones->result==true){
                    $this->view->objUsuario = $api_UserLogin->IdUsuario;
                    $this->view->objListaSistemasUsuario = $api_ListaAplicaciones;
                    
                    $this->view->render('home');
                }else{
                    $this->view->msg_catch = $api_ListaAplicaciones->Mensaje;
                    $this->view->render('error');
                }

            }
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}

    public function accesoAplicacion(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try{            
                $classApiLogin = new ApiLogin();
                $api_AccesoSistema = $classApiLogin->GetAccesoSistema($_POST["token"]);            
                if( $api_AccesoSistema->result == false ){
                    $this->view->msg_catch = $api_AccesoSistema->Mensaje;
                    $this->view->render('error');
                } else if( $api_AccesoSistema->result == true ){
                    $datatoken = $this->jwt->GetData($_POST["token"]);
                    $Usuario = $datatoken->Usuario;
                    $IdSistema = $datatoken->IdSistema;
                    //$secretKey = $datatoken->secretKey;
                    //echo $IdSistema;Exit;
                    if(trim($IdSistema)=="SPV" || trim($IdSistema)=="STD" || trim($IdSistema)=="MNF" || trim($IdSistema)=="GSO"){
                        header('Location: '.URLUNICA.$IdSistema.'/ES/security/index?token='.$_POST["token"]);

                    }else{
                        header('Location: '.URLUNICA.$IdSistema.'/security/index?token='.$_POST["token"]);
                    }            
                }
            } catch(Exception $e){
                $this->view->msg_catch = "El Token ha expirado, recarge la pagina para volver a ingresar.";
                $this->view->render('error');
            }
        }else{
            $this->view->msg_catch = "Metodo ".$_SERVER['REQUEST_METHOD']." no valido.";
            $this->view->render('error');
        }
        
    }

	
	/*public function accesoAplicacion($Usuario,$IdSistema){
		try{            
            $classApiLogin = new ApiLogin();
            $api_AccesoSistema = $classApiLogin->GetAccesoSistema($Usuario,$IdSistema);            
            if( $api_AccesoSistema == false ){
                $this->view->objloginError = "No tiene permisos para esta ApliCación";
                $this->view->render('home');
            } else if( $api_AccesoSistema == true ){
                $api_MenuUsuario = $classApiLogin->GetMenuUsuario($Usuario,$IdSistema);
                header('Location: '.URLUNICA.''.$IdSistema.'/ES/'.$Usuario);                
            }
		} catch(Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}*/
    
	public function salir(){
		try{            
			session_destroy();
			$this->model->Redirect(URL_LOGIN_APP);
		} catch(Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
}
?>