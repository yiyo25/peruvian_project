<?php

class agregarCopia extends Controller {
    private $permisos;
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            if (!$this->isAccessProgram("STD_GENERA_COP", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->permisos = $this->PermisosporPaginas("STD_GENERA_COP", 1);
                $this->view->permisos = $this->permisos;
            }
        }
	}	
	
	private function instance_TramitexUsuario($seg_usuario){
		try{
			$TramiteUsuario = new agregarCopia_model();			
			
			return $TramiteUsuario->listarTramitexUsuario($seg_usuario);
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_Contacto(){
		try{
			$Contacto = new agregarCopia_model();
			
			return $Contacto->listarContacto();
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function index($id = ''){		
		try{				
			$seg_usuario = $_SESSION['usuario'];				
						
			$this->view->objTramU = $this->instance_TramitexUsuario($seg_usuario);
			$this->view->objCon = $this->instance_Contacto();
			
			$this->view->render('agregarCopia');
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function lista_area_contacto() {
		$contacto_id = $_POST['contacto'];
		
		$listar_area_contacto = new registro_model();
		$result = $listar_area_contacto->filtrar_area_cargo($contacto_id);
		
		print_r(json_encode($result));		
	}
	
	public function insert_contacto() {
		$nro_spinner = $_POST['spinner_1'];
		$tram_id = $_POST['tram_id'];
		$seg_fecha_transito = str_replace("/","",date("Y-m-d"));
		$seg_hora_transito = date("H:i:s");
		$seg_usu_transito= $_SESSION['usuario'];
		$usu_numdoc = $_SESSION['dni'];
		
		for ($i=1; $i <= $nro_spinner ; $i++) {
			$contac_id = $_POST['contac_id_'.$i];
			$usu_nombre = $_POST['usu_nombre_'.$i];
			$usu_correo = $_POST['usu_correo_'.$i];
			$usu_numdoc = $_POST['usu_numdoc_'.$i];
			$area_descripcion = $_POST['area_descripcion1_'.$i];	
			$cargo_descripcion = $_POST['cargo_descripcion1_'.$i];		
			
			$insert_contacto = new agregarCopia_model();
			$result = $insert_contacto->insert_contacto($tram_id,$seg_fecha_transito,$seg_hora_transito,$seg_usu_transito,$usu_nombre,
														$usu_correo,$usu_numdoc,$area_descripcion,$cargo_descripcion,$usu_numdoc);			
		}
		
		$this->view->render('agregarCopia');
	}
}
?>