<?php

class alertasEdit extends Controller {
    private $permisos;
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
           // echo "sdf";exit;
            if (!$this->isAccessProgram("STD_MANT_ALERT", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->permisos = $this->PermisosporPaginas("STD_MANT_ALERT", 1);
                $this->view->permisos = $this->permisos;
            }
        }
	}
	
	private function instance_alertas(){
		try{
			$alertas = new alertasEdit_model();			
			
			return $alertas->listarAlertas();
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}	
	
	public function index(){		
		try{
								
			$this->view->objAlerta = $this->instance_alertas();
			
			$this->view->render('alertasEdit');
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	private function instance_cargaAlertas($alerta_id){
		try{
			$cargaAlertas = new alertasEdit_model();			
			
			return $cargaAlertas->cargaAlertas($alerta_id);
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	public function cargaAlertas(){		
		try{
			$alerta_id = $_POST['num_alerta'];
			
			$data = $this->instance_cargaAlertas($alerta_id);
			header('Content-Type: application/json; charset=utf-8');
			
			$data[0]['alerta_asunto'] = utf8_encode($data[0]['alerta_asunto']);
			$data[0]['alerta_mensaje'] = utf8_encode($data[0]['alerta_mensaje']);
			
			echo json_encode($data);
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function editar_registro(){
		$alerta_id = $_POST['id'];
		$alerta_asunto = $_POST['asunto'];
		$alerta_mensaje = $_POST['cuerpo'];
		
		$alerta_correo_origen = $_POST["correo_origen"];	
		$alerta_correo_copia = $_POST["correo_copia"];	
		$alerta_tiempo_dia = $_POST["tiempo"];	
		$alerta_estado = $_POST['estado'];	
				
		$edit_reg = new alertasEdit_model();						
		return $edit_reg->editarRegistro($alerta_asunto,$alerta_mensaje,$alerta_correo_origen,$alerta_correo_copia,$alerta_tiempo_dia,$alerta_estado,$alerta_id);
	}			
}
?>