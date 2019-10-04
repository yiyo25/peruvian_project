<?php

class mantenimiento extends Controller {
	
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }
	}
		
	
	private function instance_area_grabar($area_descripcion='',$area_estado='',$area_usu_reg='',$area_fec_reg='')
	{
		try{
			$area_grb = new area_model();
			
			if ($area_descripcion <> '') {				
				return $area_grb->GrabarArea($area_descripcion,$area_estado,$area_usu_reg,$area_fec_reg);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_area_update($area_descripcion='',$area_estado='',$area_usu_mod='',$area_fec_mod='',$area_id='')
	{
		try{
			$area_upd = new area_model();
			
			if ($area_descripcion <>'' and $area_estado <>'') {				
				return $area_upd->GrabarEdicion($area_descripcion,$area_estado,$area_usu_mod,$area_fec_mod,$area_id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_area_eliminar($id='')
	{
		try{
			$area_eli= new area_model();
				
			if ($id <> '') {				
				return $area_eli->EliminarArea($id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_area_filtro($id = ''){
		try{
			$AreaFiltro = new contacto_model();
			
			return $AreaFiltro->listarAreaFiltro($id);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_empresa_grabar($emp_ruc='',$emp_razonsocial='',$emp_tipo = '',$emp_estado='',$emp_usu_reg='',$emp_fec_reg='')
	{
		try{
			$empresa_grb = new empresa_model();
			
			$nomb_entidad = $empresa_grb->ValidaNombre($emp_razonsocial);
			
			if(count($nomb_entidad)<=0){
				$empresa_grb->GrabarEmpresa($emp_ruc,$emp_razonsocial,$emp_tipo,$emp_estado,$emp_usu_reg,$emp_fec_reg);
				return "1";
			}else{
				return "0";
			}
			return 0;
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
			return 0;			
		}	
	}
	
	private function instance_empresa_eliminar($id='')
	{
		try{
			$empresa_eli= new empresa_model();
				
			if ($id <> '') {
				
			return $empresa_eli->EliminarEmpresa($id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_empresa_update($emp_ruc='',$emp_razonsocial='',$emp_tipo='',$emp_estado='',$emp_usu_mod='',$emp_fec_mod='',$emp_id='')
	{
		try{
			$emp_upd = new empresa_model();
			
			if ($emp_razonsocial <>'' and $emp_tipo <> '' and $emp_estado <> '') {				
				return $emp_upd->UpdateEmpresa($emp_ruc,$emp_razonsocial,$emp_tipo,$emp_estado,$emp_usu_mod,$emp_fec_mod,$emp_id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
		
	private function instance_cargo_grabar($cargo_descripcion='',$cargo_estado='',$cargo_usu_reg='',$cargo_fec_reg='')
	{
		try{
			$cargo_grb = new cargo_model();
			
			if ($cargo_descripcion <> '') {				
				return $cargo_grb->GrabarCargo($cargo_descripcion,$cargo_estado,$cargo_usu_reg,$cargo_fec_reg);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_cargo_eliminar($id='')
	{
		try{
			$cargo_eli= new cargo_model();
				
			if ($id <> '') {				
				return $cargo_eli->EliminarCargo($id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_cargo_update($cargo_descripcion = '',$cargo_estado = '',$cargo_usu_mod = '',$cargo_fec_mod = '',$cargo_id = '')
	{
		try{
			$cargo_upd = new cargo_model();
			if ($cargo_descripcion <>'' and $cargo_estado <>'') {							
				return $cargo_upd->UpdateCargo($cargo_descripcion,$cargo_estado,$cargo_usu_mod,$cargo_fec_mod,$cargo_id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_contacto_eliminar($id='')
	{
		try{
			$contacto_eli= new contacto_model();
				
			if ($id <> '') {
				
				return $contacto_eli->EliminarContacto($id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}	
	
	private function instance_documento_grabar($td_descripcion='',$td_estado='',$td_usu_reg='',$td_fec_reg='',$td_bloqueo='',$td_correlativo='',$td_abreviacion='')
	{
		try{
			$documento_grb = new tipo_documento_model();
			
			$nomb_documento = $documento_grb->validaNombreDoc($td_descripcion);
			
			if(count($nomb_documento)<=0){
				$documento_grb->GrabarDocumento($td_descripcion,$td_estado,$td_usu_reg,$td_fec_reg,$td_bloqueo,$td_correlativo,$td_abreviacion);
				return "1";
			}else{
				return "0";
			}
			return 0;
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_doc_update($td_descripcion = '',$td_estado = '',$td_usu_mod = '',$td_fec_mod = '',$td_bloqueo = '',$td_correlativo = '',$td_abreviacion = '',$td_id = '')
	{
		try{
			$doc_upd = new tipo_documento_model();
			
			if ($td_descripcion <>'' and $td_estado <>'') {
										
				return $doc_upd->UpdateDocumento($td_descripcion,$td_estado,$td_usu_mod,$td_fec_mod,$td_bloqueo,$td_correlativo,$td_abreviacion,$td_id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}	
	
	private function instance_documento_eliminar($id='')
	{
		try{
			$documento_eli= new tipo_documento_model();
				
			if ($id <> '') {
				
				return $documento_eli->EliminarDocumento($id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_empresa($Emp_codigo='',$Emp_descripcion='',$PageSize='',$PageNumber='')
	{
		try{
			
			$Empresa = new empresa_model();
			
			if ($Emp_codigo == '' AND $Emp_descripcion == '') {							
				return $Empresa->listarEmpresas($PageSize,$PageNumber);
			} else{
				return $Empresa -> BuscarEmpresa($Emp_codigo,$Emp_descripcion,$PageSize,$PageNumber);
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
	}
	
	private function instance_empresaTotal($Emp_codigo='',$Emp_descripcion='')
	{
		try{
			
			$Empresa = new empresa_model();
			
			return $Empresa->listarEmpresasTotal($Emp_codigo,$Emp_descripcion);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
	}
	
	public function empresa_listar($id='listar',$PageNumber='0'){
		try{
            if (!$this->isAccessProgram("STD_MANT_EMP", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                //$this->permisos = $this->PermisosporPaginas("STD_MANT_EMP", 1);
                $this->view->permisos = $this->PermisosporPaginas("STD_MANT_EMP", 1);
                $Emp_codigo = trim (mb_strtoupper($_POST["text_ruc"],'UTF-8'));
                $Emp_descripcion = trim (mb_strtoupper($_POST["text_razon_social"],'UTF-8'));
                $PageSize = '5';

                $_SESSION['text_ruc_bus'] = $_POST["text_ruc"];
                $_SESSION['text_razon_social_bus'] = $_POST["text_razon_social"];

                $this->view->objEmpresa = $this->instance_empresa($Emp_codigo,$Emp_descripcion,$PageSize,$PageNumber);
                $this->view->objEmpresaT = $this->instance_empresaTotal($Emp_codigo,$Emp_descripcion);
                $this->view->pageactual = $PageNumber;
                $this->view->render('empresa');
            }

			
		}catch(Exception $e){			
		}			
	}
	
	public function empresa_grabar(){
		try{
			$emp_ruc = trim(mb_strtoupper($_POST["text_modelE_ruc"],'UTF-8'));			
			$emp_razonsocial = trim(mb_strtoupper($_POST["text_modelE_razon_social"],'UTF-8'));
			$emp_tipo = trim(mb_strtoupper($_POST["option_modalE_tipo"],'UTF-8'));
			$emp_estado = "1";
			$emp_usu_reg = $_SESSION['usuario'];
			$emp_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));
				
			$result =  $this->instance_empresa_grabar($emp_ruc,$emp_razonsocial,$emp_tipo,$emp_estado,$emp_usu_reg,$emp_fec_reg);
			
			if($result == "0"){
				$arrayResponse = '{"Response":"Empresa Existente"}';
			}else{
				$arrayResponse = '{"Response":"Se registro la empresa correctamente"}';
			}			
			echo $arrayResponse;
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}			
	}
	
	public function emp_update($id=''){
		try{
			$emp_razonsocial = trim (mb_strtoupper($_POST["text_modelE_razon_social"],'UTF-8'));
			$emp_ruc = trim (mb_strtoupper($_POST["text_modelE_ruc"],'UTF-8'));
			$emp_tipo = trim (mb_strtoupper($_POST["modelE_emp_tipo"],'UTF-8'));
			$emp_estado = $_POST["modelE_emp_estado"];
			$emp_usu_mod = $_SESSION['usuario'];
			$emp_fec_mod = str_replace("/","",date("Y-m-d H:i:s"));
			
			$this->view->objUpdEmpr = $this->instance_empresa_update($emp_ruc,$emp_razonsocial,$emp_tipo,$emp_estado,$emp_usu_mod,$emp_fec_mod,$id);
			header('Location: '.URLLOGICA.'mantenimiento/empresa_listar/');
			$this->view->render('empresa');		
			
		}catch(Exception $e){			
		}			
	}
	
	public function empresa_eliminar($id=''){
		try{				
			$this->view->objEmpresae = $this->instance_empresa_eliminar($id);
			header('Location: '.URLLOGICA.'mantenimiento/empresa_listar/');
			$this->view->render('empresa');		
			
		}catch(Exception $e){			
		}			
	}
	
	private function instance_area($Area_descripcion='',$PageSize='',$PageNumber=''){
		try{
			$Area = new area_model();
			if ($Area_descripcion == '') {
				return $Area->listarAreas($PageSize,$PageNumber);
			} else {
				return $Area->BuscarArea($Area_descripcion,$PageSize,$PageNumber);
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}

	private function instance_areaTotal($Area_descripcion)
	{
		try{
			$Area = new area_model();
			
			return $Area->listarAreasTotal($Area_descripcion);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
	}	
	
	public function area_listar($id='listar',$PageNumber='0'){
		try{
            if (!$this->isAccessProgram("STD_MANT_AREA", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->view->permisos_area = $this->PermisosporPaginas("STD_MANT_AREA", 1);
                $Area_descripcion = trim(mb_strtoupper($_POST["text_nombre_area"], 'UTF-8'));
                $PageSize = '5';

                $_SESSION['text_nombre_area_bus'] = $_POST["text_nombre_area"];

                $this->view->objArea = $this->instance_area($Area_descripcion, $PageSize, $PageNumber);
                $this->view->objAreaT = $this->instance_areaTotal($Area_descripcion);
                $this->view->pageactual = $PageNumber;
                $this->view->render('area');
            }
		}catch(Exception $e){			
		}			
	}

	public function area_grabar($id=''){
		try{
			$area_descripcion = trim(mb_strtoupper($_POST["text_modelA_nombre"],'UTF-8'));
			$area_estado = "1";
			$area_usu_reg = $_SESSION['usuario'];
			$area_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));
			
			$this->view->objGrabArea = $this->instance_area_grabar($area_descripcion,$area_estado,$area_usu_reg,$area_fec_reg);
			header('Location: '.URLLOGICA.'mantenimiento/area_listar/');
			$this->view->render('area');		
			
		}catch(Exception $e){			
		}			
	}
	
	public function area_update($id=''){
		try{
			$area_descripcion = trim(mb_strtoupper($_POST["text_modelA_nombre"],'UTF-8'));
			$area_estado = $_POST["modelA_area_estado"];
			$area_usu_mod = $_SESSION['usuario'];
			$area_fec_mod = str_replace("/","",date("Y-m-d H:i:s"));
			
			$this->view->objUpdArea = $this->instance_area_update($area_descripcion,$area_estado,$area_usu_mod,$area_fec_mod,$id);
			header('Location: '.URLLOGICA.'mantenimiento/area_listar/');
			$this->view->render('area');		
			
		}catch(Exception $e){			
		}			
	}
	
	public function area_eliminar($id=''){
		try{							
			$this->view->objArea = $this->instance_area_eliminar($id);
			header('Location: '.URLLOGICA.'mantenimiento/area_listar/');
			$this->view->render('area');		
			
		}catch(Exception $e){			
		}			
	}
	
	private function instance_cargo($Cargo_descripcion='',$PageSize='',$PageNumber=''){
		try{
			$Cargo = new cargo_model();
			
			if ($Cargo_descripcion == '') {
				return $Cargo->listarCargos($PageSize,$PageNumber);
			} else {				
				return $Cargo->BuscarCargo($Cargo_descripcion,$PageSize,$PageNumber);
			} 			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_cargoTotal($Cargo_descripcion)
	{
		try{
			$Cargo = new cargo_model();
			
			return $Cargo->listarCargoTotal($Cargo_descripcion);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
	}
	
	public function cargo_listar($id='listar',$PageNumber='0'){
		try{
            if (!$this->isAccessProgram("STD_MANT_CARGO", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->view->permisos = $this->PermisosporPaginas("STD_MANT_CARGO", 1);
                $Cargo_descripcion = trim(mb_strtoupper($_POST["text_nombre_cargo"], 'UTF-8'));
                $PageSize = '5';
                $_SESSION['text_nombre_cargo_bus'] = $_POST["text_nombre_cargo"];

                $this->view->objCargo = $this->instance_cargo($Cargo_descripcion, $PageSize, $PageNumber);
                $this->view->objCargoT = $this->instance_cargoTotal($Cargo_descripcion);
                $this->view->pageactual = $PageNumber;
                $this->view->render('cargo');
            }
		
		}catch(Exception $e){			
		}	
	}
	
	public function cargo_grabar($id=''){
		try{
			$cargo_descripcion = trim(mb_strtoupper($_POST["text_modelCg_nombre"],'UTF-8'));
			$cargo_estado = "1";
			$cargo_usu_reg = $_SESSION['usuario'];
			$cargo_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));
			
			$this->view->objGrabCargo = $this->instance_cargo_grabar($cargo_descripcion,$cargo_estado,$cargo_usu_reg,$cargo_fec_reg);
			header('Location: '.URLLOGICA.'mantenimiento/cargo_listar/');
			$this->view->render('cargo');		
			
		}catch(Exception $e){			
		}			
	}
	
	public function cargo_update($id=''){
		try{
			$cargo_descripcion = trim (mb_strtoupper($_POST["text_modelC_nombre"],'UTF-8'));
			$cargo_estado = $_POST["modelC_cargo_estado"];
			$cargo_usu_mod = $_SESSION['usuario'];
			$cargo_fec_mod = str_replace("/","",date("Y-m-d H:i:s"));
			
			$this->view->objUpdCargo = $this->instance_cargo_update($cargo_descripcion,$cargo_estado,$cargo_usu_mod,$cargo_fec_mod,$id);
			header('Location: '.URLLOGICA.'mantenimiento/cargo_listar/');
			$this->view->render('cargo');		
			
		}catch(Exception $e){			
		}			
	}
	
	public function cargo_eliminar($id=''){
		try{				
			$this->view->objEliCargo = $this->instance_cargo_eliminar($id);
			header('Location: '.URLLOGICA.'mantenimiento/cargo_listar/');
			$this->view->render('cargo');		
			
		}catch(Exception $e){			
		}			
	}
	
	private function instance_contacto($Con_tipo='',$Con_descripcion='',$Con_area='', $Con_cargo='',$PageSize='',$PageNumber=''){
		try{
			$Contacto = new contacto_model();
			
			if ($Con_tipo == '' and $Con_descripcion == '' and $Con_area == '' and $Con_cargo == '') {
				return $Contacto->listarContactos($PageSize,$PageNumber);
			} 			
			else {
				return $Contacto->BuscarContactos($Con_tipo,$Con_descripcion,$Con_area,$Con_cargo,$PageSize,$PageNumber);
			}
			
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_ContactoTotal($Con_tipo,$Con_descripcion,$Con_area,$Con_cargo){
		try{
			$Contacto = new contacto_model();
			
			return $Contacto->listarContactoTotal($Con_tipo,$Con_descripcion,$Con_area,$Con_cargo);						
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function Empresas_listado()
	{
		try{
			$ListEmpresa = new contacto_model();
			
			return $ListEmpresa->EmpresasTotal();
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
	}
	
	private function Areas_listado()
	{
		try{
			$ListArea = new contacto_model();
			
			return $ListArea->AreasTotal();
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
	}
	
	private function Cargos_listado()
	{
		try{
			$ListCargo = new contacto_model();
			
			return $ListCargo->CargosTotal();
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
	}
	public function contacto_listar($id = 'listar',$PageNumber='0'){
		try{
            if (!$this->isAccessProgram("STD_MANT_CONT", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->view->permisos = $this->PermisosporPaginas("STD_MANT_CONT", 1);
                $Con_tipo = trim(mb_strtoupper($_POST["tipo_contacto"], 'UTF-8'));
                $Con_descripcion = trim(mb_strtoupper($_POST["text_nombre_contacto"], 'UTF-8'));
                $Con_area = $_POST["area_contacto"];
                $Con_cargo = $_POST["cargo_contacto"];
                $PageSize = '5';

                $this->view->objArea = $this->Areas_listado();
                $this->view->objCargo = $this->Cargos_listado();
                $this->view->objEnt = $this->Empresas_listado();

                $_SESSION['tipo_contacto_bus'] = $_POST["tipo_contacto"];

                if ($_POST["tipo_contacto"] == '') {
                    $_SESSION['tipo_contacto_bus'] = '';
                } else {
                    if ($_POST["tipo_contacto"] == 'I') {
                        $_SESSION['tipo_contacto_bus'] = 'INTERNO';
                    } else {
                        $_SESSION['tipo_contacto_bus'] = 'EXTERNO';
                    }
                }

                $_SESSION['text_nombre_contacto_bus'] = trim(mb_strtoupper($_POST["text_nombre_contacto"], 'UTF-8'));
                $_SESSION['area_contacto_bus'] = $_POST["area_contacto"];
                $_SESSION['cargo_contacto_bus'] = $_POST["cargo_contacto"];

                $this->view->objContacto = $this->instance_Contacto($Con_tipo, $Con_descripcion, $Con_area, $Con_cargo, $PageSize, $PageNumber);
                $this->view->objContactoT = $this->instance_ContactoTotal($Con_tipo, $Con_descripcion, $Con_area, $Con_cargo);
                $this->view->pageactual = $PageNumber;
                $this->view->render('contacto');
            }
						
		}catch(Exception $e){			
		}			
	}	
		
	private function instance_contacto_grabar($contac_nombre,$areatrab_id,$cargocontac_id,$empcontac_id,$contac_tipo,$contac_estado,$contac_usu_reg,$contac_fec_reg,$contact_correo)
	{
		try{

			$contacto_grb = new contacto_model();			
			
			if ($contac_nombre <> '' and $contact_correo <> '') {
								
				return $contacto_grb->GrabarContacto($contac_nombre,$areatrab_id,$cargocontac_id,$empcontac_id,$contac_tipo,$contac_estado,$contac_usu_reg,$contac_fec_reg,$contact_correo);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function contacto_grabar($id=''){
		try{
			$contac_nombre = trim(mb_strtoupper($_POST["text_modelC_nom_contacto"],'UTF-8'));	
			// $contac_dni = $_POST["text_modelC_dni_contacto"];	
			$contact_correo = $_POST["text_modelC_correo"];				
			$areatrab_id = trim(mb_strtoupper($_POST["modal_area"],'UTF-8'));
			$cargocontac_id = trim(mb_strtoupper($_POST["modal_cargo"],'UTF-8'));
			$empcontac_id = trim(mb_strtoupper($_POST["modal_empresa"],'UTF-8'));
			$contac_tipo = trim(mb_strtoupper($_POST["radio_tip_contacto"],'UTF-8'));
			$contac_estado = "1";
			$contac_usu_reg = $_SESSION['usuario'];
			$contac_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));
			
			$this->view->objGrabContacto = $this->instance_contacto_grabar($contac_nombre,$areatrab_id,$cargocontac_id,$empcontac_id,$contac_tipo,$contac_estado,$contac_usu_reg,$contac_fec_reg,$contact_correo);
			header('Location: '.URLLOGICA.'mantenimiento/contacto_listar/');
			$this->view->render('contacto');		
			
		}catch(Exception $e){			
		}			
	}
	
	private function instance_contacto_update($contac_nombre,$contac_correo,$contac_tipo,$empcontac_id,$areatrab_id,$cargocontac_id,$contac_estado,$contac_usu_mod,$contac_fec_mod,$contac_id){
		try{
			
			$contacto_upd = new contacto_model();
			
			if ($contac_nombre <> '' and $contac_correo <> '' and $contac_tipo <> '' and $cargocontac_id <> '' and $contac_tipo <>'') {							
				return $contacto_upd->ContactoUpdate($contac_nombre,$contac_correo,$contac_tipo,$empcontac_id,$areatrab_id,$cargocontac_id,$contac_estado,$contac_usu_mod,$contac_fec_mod,$contac_id);
			} 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}
	}
		
	public function contacto_update($contac_id=''){
		try{
			$contac_nombre = trim (mb_strtoupper($_POST["model_contacto_edit"],'UTF-8'));	
			// $contac_dni = $_POST["model_dni_edit"];	
			$contac_correo = $_POST["model_correo_edit"];		
			$contac_tipo = trim (mb_strtoupper($_POST["modal_radio_edit"],'UTF-8'));
			$cargocontac_id = $_POST["modal_cargo_edit"];			
			$contac_estado = $_POST["modal_estado_edit"];
			$contac_usu_mod = $_SESSION['usuario'];
			$contac_fec_mod = str_replace("/","",date("Y-m-d H:i:s"));
			
			$this->view->objUpdContacto = $this->instance_contacto_update($contac_nombre,$contac_correo,$contac_tipo,$cargocontac_id,$contac_estado,$contac_usu_mod,$contac_fec_mod,$contac_id);
			header('Location: '.URLLOGICA.'mantenimiento/contacto_listar/');
			$this->view->render('contacto');		
			
		}catch(Exception $e){			
		}			
	}
	
	public function contacto_eliminar($id=''){
		try{				
			$this->view->objContactoe = $this->instance_contacto_eliminar($id);
			header('Location: '.URLLOGICA.'mantenimiento/contacto_listar/');
			$this->view->render('contacto');		
			
		}catch(Exception $e){			
		}			
	}
	
	private function instance_documento($Doc_descripcion='',$PageSize='',$PageNumber=''){
		try{
			$Doc = new tipo_documento_model();
			
			if ($Doc_descripcion == '') {
				return $Doc->listarDocumentos($PageSize,$PageNumber);
			} else {
				return $Doc->BuscarDocumentos($Doc_descripcion,$PageSize,$PageNumber);
			}			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_documentoTotal($Doc_descripcion){
		try{
			$Doc = new tipo_documento_model();
			
			return $Doc->listarDocumentoTotal($Doc_descripcion);
		
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function tipo_documento_listar($id = '',$PageNumber='0'){
		try{
            if (!$this->isAccessProgram("STD_MANT_DOC", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->view->permisos = $this->PermisosporPaginas("STD_MANT_DOC", 1);

                $Doc_descripcion = trim(mb_strtoupper($_POST["text_nombre_tipo_documento"], 'UTF-8'));
                $PageSize = '5';

                $_SESSION['text_nombre_tipo_documento_bus'] = $_POST["text_nombre_tipo_documento"];

                $this->view->objDoc = $this->instance_documento($Doc_descripcion, $PageSize, $PageNumber);
                $this->view->objDocT = $this->instance_documentoTotal($Doc_descripcion);
                $this->view->pageactual = $PageNumber;
                $this->view->render('tipo_documento');
            }
        }catch(Exception $e){
        }
	}
	
	public function documento_grabar($id=''){
		try{
			$td_descripcion = trim(mb_strtoupper($_POST["text_modelD_nombre"],'UTF-8'));
			$td_estado = "1";
			$td_usu_reg = $_SESSION['usuario'];
			$td_fec_reg = str_replace("/","",date("Y-m-d H:i:s"));
			$td_bloqueo = trim(mb_strtoupper($_POST["modelN_bloqueo"],'UTF-8'));
			$td_abreviacion = trim(mb_strtoupper($_POST["text_modelN_abreviacion"],'UTF-8'));
			$td_correlativo = $_POST["text_modelN_correlativo"];
			
			$result =  $this->instance_documento_grabar($td_descripcion,$td_estado,$td_usu_reg,$td_fec_reg,$td_bloqueo,$td_correlativo,$td_abreviacion);
			
			if($result == "0"){
				$arrayResponse = '{"Response":"Empresa Existente"}';
			}else{
				$arrayResponse = '{"Response":"Se registro la empresa correctamente"}';
			}			
			echo $arrayResponse;
		}catch(Exception $e){			
		}			
	}
	
	public function documento_update($id=''){
		try{
			$td_descripcion = trim (mb_strtoupper($_POST["text_modelD_nombre"],'UTF-8'));
			$td_estado = $_POST["modelD_doc_estado"];
			$td_usu_mod = $_SESSION['usuario'];
			$td_fec_mod = str_replace("/","",date("Y-m-d H:i:s"));
			$td_bloqueo = trim(mb_strtoupper($_POST["modelE_bloqueo_".$id],'UTF-8'));
			$td_abreviacion = trim(mb_strtoupper($_POST["text_modelE_abreviacion_".$id],'UTF-8'));
			$td_correlativo = $_POST["text_modelE_correlativo_".$id];
			
			$this->view->objUpdDoc = $this->instance_doc_update($td_descripcion,$td_estado,$td_usu_mod,$td_fec_mod,$td_bloqueo,$td_correlativo,$td_abreviacion,$id);
			header('Location: '.URLLOGICA.'mantenimiento/tipo_documento_listar/');
			$this->view->render('tipo_documento');		
			
		}catch(Exception $e){			
		}			
	}
	
	public function documento_eliminar($id=''){
		try{				
			$this->view->objEliDoc = $this->instance_documento_eliminar($id);
			header('Location: '.URLLOGICA.'mantenimiento/tipo_documento_listar/');
			$this->view->render('tipo_documento');		
			
		}catch(Exception $e){			
		}			
	}
}
?>