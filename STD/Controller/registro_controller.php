<?php

class registro extends Controller {
    private $permisos;
	function __construct(){
		parent::__construct();
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            if (!$this->isAccessProgram("STD_REG_DOC", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->permisos = $this->PermisosporPaginas("STD_REG_DOC", 1);
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
	
	private function instance_Empresa(){
		try{

			$Empresa = new registro_model();
			
			return $Empresa->listarEmpresas();
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function combo_empresa_listar(){
		
		try{
			$empresa = $_POST['tipo'];			
			
			$Empresa = new registro_model();
			
			$result =  $Empresa->listarEmpresasXEntidad($empresa);
			
			print_r(json_encode($result));	
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function index(){		
		try{
				//echo "#sdf";Exit;
			$this->view->objDoc = $this->instance_Documento();
			$this->view->objArea = $this->instance_Area();
			$this->view->objCargo = $this->instance_Cargo();
			$this->view->objCon = $this->instance_Contacto();				
			$this->view->objEnt = $this->instance_Empresa();
			
			$this->view->render('registro');
			
		} catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}
	
	public function grabarRegistro($accion='',$id=''){
		
		try{
			$Reg = new registro_model();	
			
			$td_id = $_POST["td_id"];
			$tram_nro_doc = trim (mb_strtoupper($_POST["hidden_documento"]));
			$identificador = trim (mb_strtoupper($_POST["hidden_identificador"]));
			$bloqueo = trim (mb_strtoupper($_POST["hidden_bloqueo"]));
			//Fecha de Documento
			$date_doc = $_POST["text_fecha_doc"];	
			$date_doc = str_replace('/', '-', $date_doc);
			$tram_fec_doc = date("Y-m-d", strtotime($date_doc));			
			$tram_asunto = trim (mb_strtoupper($_POST["text_asunto_reg"],'UTF-8'));
			$tram_tip_ent = trim (mb_strtoupper($_POST["tip_entidad"],'UTF-8'));
			$emptram_id = $_POST["emp_id"];
			
			$contactram_id = $_POST["contac_id"];
			$contactram_id = is_numeric($contactram_id)?$contactram_id:-1;	
					
			$tram_prioridad = trim (mb_strtoupper($_POST["estado"],'UTF-8'));
			//Fecha de Respuesta
			$date_resp = $_POST["text_fecha_resp"];	
			$date_resp = str_replace('/', '-', $date_resp);
			$tram_fec_resp = date("Y-m-d", strtotime($date_resp));					
			//Fecha de Tramite
			$date_reg = $_POST["text_fecha_tram"];				
			$date_reg = str_replace('/', '-', $date_reg);
			$tram_fec_reg = date("Y-m-d", strtotime($date_reg));
						
			$seg_hora_reg = date("H:i:s");
			
			$tram_ruta_doc = $this->validarCaracteres($_POST["filecomplete"]);
			
			$tram_usu_reg = $_SESSION['usuario'];
			$usu_numdoc = $_SESSION['dni'];
			$usu_area = $_SESSION['area_id'];
			$usu_cargo = $_SESSION['cargo_id'];
			$usu_nomb = trim (mb_strtoupper($_SESSION['nombre']));
			$usu_ape = trim (mb_strtoupper($_SESSION['apellidos']));	
			$email = $_SESSION['correo'];			
				
			$area_descripcion = trim (mb_strtoupper($_POST["area_descripcion1"],'UTF-8'));
			$cargo_descripcion = trim (mb_strtoupper($_POST["cargo_descripcion1"],'UTF-8'));
			$usu_correo = $_POST["usu_correo"];
			$usu_numdocI = $_POST["usu_numdoc"];
			$usu_nombre = trim (mb_strtoupper($_POST["usu_nombre"],'UTF-8'));
			
			$nro_referencia = trim (mb_strtoupper($_POST["hidden_doc_referencia"]));
			$tipo_referencia = trim (mb_strtoupper($_POST["hidden_tipo_referencia"]));
			$tipo_referencia_id = $_POST["hidden_tipo_referencia_id"];			
			$correo_copia = $_POST['copia_hidden'];
			
			$name_file = $this->validarCaracteres($_FILES['file']['name']);
														
			if($accion =='insert'){			
			
			$id_reg = $Reg->insertarRegistro(	$td_id,$tram_nro_doc,$tram_fec_doc,$tram_asunto,$tram_tip_ent,$emptram_id,$contactram_id,
							  					$tram_prioridad,$tram_fec_resp,$tram_usu_reg,$tram_fec_reg,$seg_hora_reg,$usu_numdoc,
							  					$usu_nomb,$usu_ape,$tram_ruta_doc,$email,$name_file,$area_descripcion,$cargo_descripcion,
												$usu_correo,$usu_numdocI,$usu_nombre,$usu_area,$usu_cargo,$identificador,$bloqueo,$nro_referencia,
												$tipo_referencia,$tipo_referencia_id,$correo_copia);
									
			
			$tmp_name = $_FILES['file']['tmp_name'];
			$extension = array_pop(explode(".", $_FILES['file']['name']));
			$name = $id_reg.'.'.$extension;	
			
			$vv = file_get_contents($tmp_name);
	        $binary = base64_encode($vv);
	        
			// Web Service
			$nas = new nas_model();
			$result = $nas->saveFileNas($name, $binary);
						
			header('Location: '.URLLOGICA.'seguimiento/listar_seguimiento/open/0/'.$id_reg);
			
			}	
			
		}	catch(Exception $e){			
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
	}		
	
	//Inicio Modal Entidad
	public function modal_grabar_entidad(){
		$emp_ruc = $_POST["ruc"];			
		$emp_razonsocial = trim(mb_strtoupper($_POST["entidad"]));
		$emp_tipo = "E";
		$emp_estado = "1";
		$emp_usu_reg = $_SESSION['usuario'];
		$emp_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));
		
		$empresa_grb = new empresa_model();
		return $empresa_grb->GrabarEmpresa($emp_ruc,$emp_razonsocial,$emp_tipo,$emp_estado,$emp_usu_reg,$emp_fec_reg);
		
	}
	
	//Fin Modal Contacto	
	public function modal_grabar_contacto(){
		$contac_nombre = trim(mb_strtoupper($_POST["contacto"]));
		$contact_correo = $_POST["correo"];
		$areatrab_id = $_POST["area"];
		$cargocontac_id = $_POST["cargo"];
		$empcontac_id = $_POST["empresa"];
		$contac_tipo = trim(mb_strtoupper($_POST["tipo"]));
		$contac_estado = "1";
		$contac_usu_reg = $_SESSION['usuario'];
		$contac_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));	
		
			
		$contacto_grb = new contacto_model();				
		return $contacto_grb->GrabarContacto($contac_nombre,$areatrab_id,$cargocontac_id,$empcontac_id,$contac_tipo,$contac_estado,$contac_usu_reg,$contac_fec_reg,$contact_correo);
	}
	
	public function lista_contacto_pull(){
		$empresa_id = $_POST['empresa'];		

		$listar_contacto = new registro_model();
		$result = $listar_contacto->filtrar_contacto($empresa_id);
				
		$array_result = array();
		
		foreach ($result as $value ) {
			$array = array('id' => $value['contac_id'],
							'text' => utf8_encode($value['contac_nombre'])
			);
			array_push($array_result, $array);
		}
		
		$array_result = array('items' => $array_result);
		
		print_r(json_encode($array_result));		
	}
	
	public function lista_area_contacto() {
		$contacto_id = $_POST['contacto'];
		$empresa_id = $_POST['empresa'];
		
		$listar_area_contacto = new registro_model();
		$result = $listar_area_contacto->filtrar_area_cargo($contacto_id,$empresa_id);
		$result = $this->array_utf8_encode($result);
		
		
		header("Content-Type: application/json; charset=UTF-8");
        
		echo json_encode($result);	
	}

	public static function array_utf8_encode($dat)
	{
	    if (is_string($dat))
	        return utf8_encode($dat);
	    if (!is_array($dat))
	        return $dat;
	    $ret = array();
	    foreach ($dat as $i => $d)
	        $ret[$i] = self::array_utf8_encode($d);
	    return $ret;
	}
	
	public function listar_entidad_combo() {
		
		$listar_empresa = new registro_model();
		$result = $listar_empresa->listarEmpresasTotal();
		
		print_r(json_encode($result));		
	}
	
	public function listar_contacto_combo() {
		
		$listar_contacto = new registro_model();
		$result = $listar_contacto->listarContactosTotal();
		
		print_r(json_encode($result));		
	}
	
	public function listar_area_combo() {
		
		$listar_area = new registro_model();
		$result = $listar_area->listarAreaTotal();
		
		print_r(json_encode($result));		
	}
		
	public function grabar_area_modal(){
		$area_descripcion = trim(mb_strtoupper($_POST['area']));
		$area_estado = "1";
		$area_usu_reg = $_SESSION['usuario'];
		$area_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));	
			
		$area_grb = new area_model();				
		return $area_grb->GrabarArea($area_descripcion,$area_estado,$area_usu_reg,$area_fec_reg);
	}	
	
	public function listar_cargo_combo() {
		
		$listar_cargo = new registro_model();
		$result = $listar_cargo->listarCargoTotal();
		
		print_r(json_encode($result));		
	}
	
	public function grabar_cargo_modal(){
		$cargo_descripcion = trim(mb_strtoupper($_POST['cargo']));
		$cargo_estado = "1";
		$cargo_usu_reg = $_SESSION['usuario'];
		$cargo_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));	
			
		$cargo_grb = new cargo_model();						
		return $cargo_grb->GrabarCargo($cargo_descripcion,$cargo_estado,$cargo_usu_reg,$cargo_fec_reg);
	}
	
	public function listar_documento_combo() {
		
		$listar_documento = new registro_model();
		$result = $listar_documento->listarDocumentoTotal();
				
		print_r(json_encode($result));		
	}
	
	public function grabar_documento_modal(){
		$td_descripcion = trim(mb_strtoupper($_POST['documento']));
		$td_estado = "1";
		$td_usu_reg = $_SESSION['usuario'];
		$td_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));
			
		$documento_grb = new tipo_documento_model();						
		return $documento_grb->GrabarDocumento($td_descripcion,$td_estado,$td_usu_reg,$td_fec_reg);
	}
	
	public function validaNombre(){
		$entidad = $_POST['entidad'];
		try{
			$empresa_grb = new empresa_model();
			
			$nomb_entidad = $empresa_grb->ValidaNombre($entidad);
			if(count($nomb_entidad)>0){
				$valida = 'TRUE';
			}else{
				$valida = 'FALSE';
			}			
			echo $valida;
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function validaNombreDoc(){
		$documento = $_POST['documento'];
		try{
			$registro_validar = new registro_model();
			
			$nomb_documento = $registro_validar->validaNombreDoc($documento);
			if(count($nomb_documento)>0){
				$valida = 'TRUE';
			}else{
				$valida = 'FALSE';
			}			
			echo $valida;
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function consulta_documento(){
		$id = $_POST['id'];
		try{	
			$documento = new registro_model();						
			$bloqueo = $documento->consultar_documento($id);
			
			print_r(json_encode($bloqueo));
		}catch(Exception $e){
				$this->view->msg_catch = $e->getMessage();
				$this->view->render('error');			
		}
	}
	
	public function buscar_tramite(){
		$num_documento = $_POST['num_documento'];
    	$tip_documento = $_POST['tip_documento'];
    	$estado = $_POST['estado'];
    	$fec_inicial = $_POST['fec_inicial'];
    	$fec_final = $_POST['fec_final'];
		try{	
			$documento = new registro_model();						
			$bloqueo = $documento->BuscarTramite($num_documento,$tip_documento,$estado,$fec_inicial,$fec_final);
			header('Content-Type: application/json');
			print_r(json_encode($bloqueo));
		}catch(Exception $e){
				$this->view->msg_catch = $e->getMessage();
				$this->view->render('error');			
		}
	}
}
?>