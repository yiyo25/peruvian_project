<?php

class registroEdit extends Controller {
    private $permisos;
	function __construct(){
		parent::__construct();
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            if (!$this->isAccessProgram("STD_EDIT_REG", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->permisos = $this->PermisosporPaginas("STD_EDIT_REG", 1);
                $this->view->permisos = $this->permisos;
            }
        }
	}
	
	private function instance_Documento(){
		try{
			$Doc = new tipo_documento_model();
			
			return $Doc->listarDocumentoTotal();
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_Area(){
		try{
			$Area = new area_model();
			
			return $Area->listarAreasTotal();
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_Cargo(){
		try{
			$Cargo = new cargo_model();	
			
			return $Cargo->listarCargoTotal();
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_Contacto(){
		try{
			$Contacto = new contacto_model();
			
			return $Contacto->listarContactoTotal();
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
			
	private function instance_TramitexUsuario($seg_usuario){
		try{
			$TramiteUsuario = new registroEdit_model();			
			
			return $TramiteUsuario->listarTramitexUsuario($seg_usuario);
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_Empresa(){
		try{
			$Empresa = new registroEdit_model();			
			
			return $Empresa->listarEmpresas();
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}	
	
	public function index($id = ''){		
		try{				
			$seg_usuario = $_SESSION['usuario'];			
			
			$this->view->objDoc = $this->instance_Documento();			
			$this->view->objArea = $this->instance_Area();
			$this->view->objCargo = $this->instance_Cargo();
			$this->view->objCon = $this->instance_Contacto();			
			$this->view->objEnt = $this->instance_Empresa();			
			$this->view->objTramU = $this->instance_TramitexUsuario($seg_usuario);
			
			$this->view->render('registroEdit');
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}	
		
	private function instance_Tramite($tram_nro_doc){
		try{
			$Tramite = new registroEdit_model();			
			
			return $Tramite->listarTramites($tram_nro_doc);
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	public function tramites(){		
		try{
			$tram_nro_doc = $_POST['num_tram'];
			
			$data = $this->instance_Tramite($tram_nro_doc);
			header('Content-Type: application/json');
			echo json_encode($data);
						
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function editar_registro(){
		$registro = $_POST['registro'];
		$tram_nro_doc = $_POST['nro_documento'];
		
		$date_doc = $_POST["fecha_doc"];						
		$date_doc = str_replace('/', '-', $date_doc);
		$tram_fec_doc = date("Y-m-d", strtotime($date_doc));		
		
		$td_id = trim(mb_strtoupper($_POST['tipo_doc']));
		
		$tram_asunto = trim(mb_strtoupper($_POST['asunto']));
		$tram_tip_ent = trim(mb_strtoupper($_POST['tip_entidad']));
		$emptram_id = $_POST['empresa'];
		
		$contactram_id = $_POST['contacto'];
		$contactram_id = is_numeric($contactram_id)?$contactram_id:-1;
		
		$tram_prioridad = trim(mb_strtoupper($_POST['prioridad']));
		
		$date_resp = $_POST["fecha_resp"];	
		$date_resp = str_replace('/', '-', $date_resp);
		$tram_fec_resp = date("Y-m-d", strtotime($date_resp));
		
		$ruta_documento = 	$this->validarCaracteres($_POST['ruta_documento']);	
		
		$usu_numdoc = $_SESSION['dni'];	
		
		$area_descripcion = trim(mb_strtoupper($_POST['area_descripcion']));
		$cargo_descripcion = trim(mb_strtoupper($_POST['cargo_descripcion']));
		$usu_correo = $_POST['usu_correo'];
		$usu_numdocI = $_POST['usu_numdocI'];
		$usu_nombre = trim(mb_strtoupper($_POST['usu_nombre']));
		$tram_usu_reg = $_SESSION['usuario'];
		$fecha_reg = $_SESSION['fecha_reg'];
		
		$doc_referencia = $_POST['doc_referencia'];	
		$tipo_referencia = $_POST['tipo_referencia'];	
		$correo_copia = $_POST['correo_copia'];	
		
		$name_file = $this->validarCaracteres($_FILES['file']['name']);
		
		$edit_reg = new registroEdit_model();
		return $edit_reg->editarRegistro($registro,$td_id,$tram_nro_doc,$tram_fec_doc,$tram_asunto,$tram_tip_ent,$emptram_id,
										 $contactram_id,$tram_prioridad,$tram_fec_resp,$usu_numdoc,$ruta_documento,$name_file,
										 $area_descripcion,$cargo_descripcion,$usu_correo,$usu_numdocI,$usu_nombre,$tram_usu_reg,
										 $fecha_reg,$doc_referencia,$tipo_referencia,$correo_copia);
	}

function validarCaracteres($string)
    {
    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    //Se elmino aqui el espacio en blanco, punto y guion
        $string = str_replace(
        array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "•", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":"),
        '',
        $string
    );
    return $string;
	}

	public function combo_empresa_listar(){
		
		try{
			$empresa = $_POST['tipo'];			
			
			$Empresa = new registroEdit_model();
			
			$result =  $Empresa->listarEmpresasXEntidad($empresa);
			
			print_r(json_encode($result));	
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function combo_contacto_listar(){
		
		try{
			$empresa = $_POST['tipo'];			
			
			$Empresa = new registroEdit_model();
			
			$result =  $Empresa->listarContactosXEntidad($empresa);
			
			header('Content-Type: application/json');
			print_r(json_encode($result));	
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}	
	
	public function buscar_tramite(){
		$nro_tramite = $_POST['nro_tramite'];
		$num_documento = $_POST['num_documento'];
    	$tip_documento = $_POST['tip_documento'];
    	$estado = $_POST['estado'];
    	$fec_inicial = $_POST['fec_inicial'];
    	$fec_final = $_POST['fec_final'];
		try{	
			$documento = new registroEdit_model();						
			$bloqueo = $documento->BuscarTramite($nro_tramite,$num_documento,$tip_documento,$estado,$fec_inicial,$fec_final);
			header('Content-Type: application/json');
			print_r(json_encode($bloqueo));
		}catch(Exception $e){
				$this->view->msg_catch = $e->getMessage();
				$this->view->render('error');			
		}
	}
	
	public function lista_area_contacto() {
		$contacto_id = $_POST['contacto'];
		$empresa_id = $_POST['empresa'];
		
		$listar_area_contacto = new registroEdit_model();
		$result = $listar_area_contacto->filtrar_area_cargo($contacto_id,$empresa_id);
		$result = $this->array_utf8_encode($result);
		
		
		header("Content-Type: application/json; charset=UTF-8");
        
		echo json_encode($result);	
	}		
}
?>