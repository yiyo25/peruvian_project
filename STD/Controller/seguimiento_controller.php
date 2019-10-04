<?php
require(dirname(dirname(__FILE__)) . "/Libs/htmlMimeMail5.php");

class seguimiento extends Controller {
    private $permisos;
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            if (!$this->isAccessProgram("STD_SEG_DOC", 1)) {

                $this->view->error_text = "El usuario <b>" . $_SESSION[NAME_SESS_USER]["id_usuario"] . "</b> no tiene permisos para accedar a esta Página.";
                $this->view->render("403");
                exit;
            } else {
                $this->permisos = $this->PermisosporPaginas("STD_SEG_DOC", 1);
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
	
	private function instance_ContactoEntidad($contac_dni){
		try{
			$ContactoE = new seguimiento_model();
			
			return $ContactoE->listarContactosEntidad($contac_dni);
			 
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
			$Empresa = new seguimiento_model();			
			
			return $Empresa->listarEmpresasTotal();
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	private function instance_Empresa_Remitente($tram_emp_remit){
		try{
			$Empresa = new seguimiento_model();			
			
			return $Empresa->listarEmpresasTotalRemitente($tram_emp_remit);
			 
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
		
	private function instance_seguimiento($num_docum="",$tipo_docum="",$fec_inicial="",$fec_final="",$estado="",$seg_usuario="",$PageSize="",$PageNumber="",$num_referencia="",$tram_prioridad="", $tram_emp_remit="")
	{
		try{
			
			$Seguimiento = new seguimiento_model();
			
			if ($num_docum == "" and $tipo_docum == "" and $fec_inicial =="" and $fec_final =="" and $estado=="" and $num_referencia=="" and $tram_prioridad==""){				
				// return $Seguimiento->listarSeguimiento($seg_usuario,$PageSize,$PageNumber,$num_docum,$tram_prioridad);
				return $Seguimiento->listarSeguimiento($seg_usuario,$PageSize,$PageNumber,$num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$num_referencia,$tram_prioridad,$tram_emp_remit);				
			}else{																				
				return $Seguimiento->BuscarTramite($seg_usuario,$PageSize,$PageNumber,$num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$num_referencia,$tram_prioridad,$tram_emp_remit);				
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}
	}	
	
	private function instance_seguimientoTotal($num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$seg_usuario,$usu_numdoc,$num_referencia,$tram_prioridad,$tram_emp_remit)
	{
		try{
			$Seguimiento = new seguimiento_model();
			return $Seguimiento->listarSeguimientoTotal($num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$seg_usuario,$usu_numdoc,$num_referencia,$tram_prioridad,$tram_emp_remit);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}
	}
	
	private function instance_seguimientoEstado($seg_usuario,$num_docum)
	{
		try{
			$Seguimiento = new seguimiento_model();
			return $Seguimiento->listarSeguimientoEstado($seg_usuario,$num_docum);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}
	}	

	public function listar_seguimiento($var='listar',$PageNumber='0',$id_reg='',$num_docum='',$tipo_docum='',$fec_inicial='',$fec_final='',$estado='',$num_referencia='',$tram_emp_remit='',$tram_prioridad=''){
		
		try{

			if($var=='index'){
				$_SESSION['text_nro_doc_seg_bus'] = NULL;
				$_SESSION['tip_doc_seg_bus'] = NULL;
				$_SESSION['text_fec_ini_seg_bus'] = NULL;	
				$_SESSION['text_fec_fin_seg_bus'] = NULL;	
				$_SESSION['estado_seg_bus'] = NULL;
				$_SESSION['text_nro_referencia_bus'] = NULL;				
				$_SESSION['prioridad_seg_bus'] = NULL;
				$_SESSION['emp_remit_seg_bus'] = NULL;
			}
			
			if(isset($_POST)){
				if(isset($_POST["text_nro_doc_seg"]))$_SESSION['text_nro_doc_seg_bus'] = $_POST["text_nro_doc_seg"];
				if(isset($_POST["tip_doc_seg"]))$_SESSION['tip_doc_seg_bus'] = $_POST["tip_doc_seg"];
				if(isset($_POST["text_fec_ini_seg"]))$_SESSION['text_fec_ini_seg_bus'] = $_POST["text_fec_ini_seg"];	
				if(isset($_POST["text_fec_fin_seg"]))$_SESSION['text_fec_fin_seg_bus'] = $_POST["text_fec_fin_seg"];	
				if(isset($_POST["estado_seg"]))$_SESSION['estado_seg_bus'] = trim(mb_strtoupper($_POST["estado_seg"],'UTF-8'));
				if(isset($_POST["text_nro_referencia"]))$_SESSION['text_nro_referencia_bus'] = $_POST["text_nro_referencia"];				
				if(isset($_POST["prioridad_seg"]))$_SESSION['prioridad_seg_bus'] = $_POST["prioridad_seg"];
				if(isset($_POST["emp_remit_seg"]))$_SESSION['emp_remit_seg_bus'] = $_POST['emp_remit_seg'];
			}
			
			$num_docum = $_SESSION['text_nro_doc_seg_bus'];			
			$tipo_docum = $_SESSION['tip_doc_seg_bus'];
			$fec_inicial = $_SESSION['text_fec_ini_seg_bus'];			
			$fec_final = $_SESSION['text_fec_fin_seg_bus'];
			$estado = $_SESSION['estado_seg_bus'] ;
			$num_referencia = $_SESSION['text_nro_referencia_bus'];
			$tram_prioridad = $_SESSION['prioridad_seg_bus'];	
			$tram_emp_remit = $_SESSION['emp_remit_seg_bus'];
						
			$seg_usuario = $_SESSION['usuario'];
			$usu_numdoc = $_SESSION['dni'];	
			$PageSize = '5';			
			
			$this->view->objSegT = $this->instance_seguimientoTotal($num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$seg_usuario,$usu_numdoc,$num_referencia,$tram_prioridad,$tram_emp_remit);
			$TotalReg= count($this->view->objSegT);
			
			$paginas =ceil($TotalReg/5);
			if($var=='open'){				
				$PageNumber=0;
			}			
			
			$this->view->objSeg = $this->instance_seguimiento($num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$seg_usuario,$PageSize,$PageNumber,$num_referencia,$tram_prioridad,$tram_emp_remit);

			$this->view->objSegE = $this->instance_seguimientoEstado($seg_usuario,$num_docum);
			$this->view->objDoc = $this->instance_Documento();	
			
			$this->view->objArea = $this->instance_Area();
			$this->view->objCargo = $this->instance_Cargo();
			$this->view->objCon = $this->instance_Contacto();		
			$this->view->objEnt = $this->instance_Empresa();	
			
					
			$this->view->var = $var;
			$this->view->id_reg = $id_reg;
			$this->view->pageactual = $PageNumber;
			
			$this->view->render('seguimiento');		
			
		}catch(Exception $e){
		}			
	}
	
	public function lista_contacto_pull(){
		$empresa_id = $_POST['empresa'];
		
		$listar_contacto = new seguimiento_model();
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
		
		$listar_area_contacto = new seguimiento_model();
		$result = $listar_area_contacto->filtrar_area_cargo($contacto_id,$empresa_id);
		$result = $this->array_utf8_encode($result);
		
		print_r(json_encode($result));
		
	}
	
	private function instance_derivar_seg($tramseg_id,$seg_tipent,$empseg_id,$contacseg_id,$seg_observacion,
										  $seg_fecha_transito,$seg_hora_transito,$seg_usuario_transito,
										  $seg_estado,$usu_numdoc,$area_descripcion,$cargo_descripcion,
										  $usu_correo,$usu_numdocI,$usu_nombre,$correo_usuario_deriva){
		try{
						
			$Seg_derivar = new seguimiento_model();	
			
			$Seg_derivar->DerivarTramite($tramseg_id,$seg_tipent,$empseg_id,$contacseg_id,utf8_encode($seg_observacion),
												$seg_fecha_transito,$seg_hora_transito,$seg_usuario_transito,$seg_estado,
												$usu_numdoc, utf8_encode($area_descripcion),utf8_encode($cargo_descripcion),
												$usu_correo,$usu_numdocI,$usu_nombre,$correo_usuario_deriva);
			
						
			$resultado = $Seg_derivar->CorreoDerivado($tramseg_id);
			
			$concluido = $Seg_derivar->ConcluidoTable('6');
			
			$alerta_estado = $concluido[0]['alerta_estado'];
			$alerta_asunto = $concluido[0]['alerta_asunto'];
			$alerta_mensaje = $concluido[0]['alerta_mensaje'];
			
			$alerta_correo_origen = $concluido[0]['alerta_correo_origen'];
			$alerta_correo_copia = $concluido[0]['alerta_correo_copia'];
			
			if($alerta_estado == '1'){
				foreach ($resultado as $key => $value) {
					$seg_fecha_transito = $value['tram_estado_fecha'];
					$td_descripcion = $value['td_descripcion'];
					$num_doc = $value['tram_nro_doc'];
					$fecha_registro = date("d-m-Y", strtotime($value['tram_fec_reg']));	
					$remitente = $value['NombreRemitente'];
					$asunto = $value['tram_asunto'];
					$Dias = $value['Dias'];
					$correo_copia =utf8_encode($value['seg_correo_copia']);
																
					$my_De = $alerta_correo_origen;
					$my_Para = utf8_encode($usu_correo);
					$my_Bcc = $alerta_correo_copia;				
 					
					$my_Asunto = utf8_encode($alerta_asunto)." ".$num_doc;	
					$my_Msg = "
					<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
					<html xmlns='http://www.w3.org/1999/xhtml'>									
					<body>
						<table align='left' cellpadding='0' cellspacing='0'>
					  		<tr>
						    <td bordercolor='#ABABAB'>
						    	<center><br />
							      	<table width='700' border='0' align='center' cellpadding='0' cellspacing='0'>
								        <tr>
								          <td><p><font face='Arial' size='3' color='#555555'>".utf8_encode($alerta_mensaje)."</font></p>
								          <p><font face='Arial' size='3' color='#555555'><strong>Documento: </strong>".$td_descripcion." - ".$num_doc."</p>
								          <p><font face='Arial' size='3' color='#555555'><strong>Fecha Registro:</strong>  ".$fecha_registro."</p>
								          <p><font face='Arial' size='3' color='#555555'><strong>Remitente:</strong> ".$remitente."</p>
								          <p><font face='Arial' size='3' color='#555555'><strong>Asunto:</strong> ".$asunto."</p>									          
								          <p></p>
								          <p><font face='Arial' size='3' color='#555555'>Favor, dar como recibido el documento en el sistema STD una vez recepcionado el físico.</p></td>
								        </tr>
							  		</table>
						     	 <p>&nbsp;</p>
						   		</center>
						    </td>
							</tr>
						</table>
					</body>
					</html>";
					
					$mail = new htmlMimeMail5();	
							
					$mail->setFrom($my_De);
					$mail->setSMTPParams('mail01.peruvian.pe', 25, 'mail01.peruvian.pe', false, 'claudia.ruiz@peruvian.pe', 'claudia98x');	
					$mail->setBcc($my_Bcc);				
					$mail->setSubject($my_Asunto);
					$mail->setPriority('high');				
					$mail->setHTML($my_Msg);
					$result  = $mail->send(array($my_Para), 'smtp');
				
				}
			}															
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function derivar_tramite($seg_id=''){
		
		try{
			$tramseg_id = $_POST["tramseg_id"];		
			$seg_tipent = trim (mb_strtoupper($_POST["radio_tip_contac"],'UTF-8')); 
			$empseg_id = $_POST["txt_empresa_id"];
			$contacseg_id = $_POST["modal_contacto"];
			$seg_observacion = trim (mb_strtoupper($_POST["text_observacion"],'UTF-8')); 			
			$seg_fecha_transito = str_replace("/","",date("Y-m-d"));
			$seg_hora_transito = date("H:i:s");
			$seg_usuario_transito = $_SESSION['usuario'];
			$correo_usuario_deriva = $_SESSION['correo'];			
			if ($seg_tipent == 'I') {
				$seg_estado = 'Transito';
			} else {
				$seg_estado = 'Concluido';
			}			
			$usu_numdoc = $_SESSION['dni'];	
					
			$area_descripcion = trim (mb_strtoupper($_POST["area_descripcion_".$seg_id],'UTF-8'));
			$cargo_descripcion = trim (mb_strtoupper($_POST["cargo_descripcion_".$seg_id],'UTF-8'));
			$usu_correo = $_POST["usu_correo_".$seg_id];
			
			$usu_numdocI = $_POST["usu_numdoc_".$seg_id];
			$usu_nombre = trim (mb_strtoupper($_POST["usu_nombre_".$seg_id],'UTF-8'));

			$this->view->objDerSeg = $this->instance_derivar_seg($tramseg_id,$seg_tipent,$empseg_id,$contacseg_id,$seg_observacion,
																 $seg_fecha_transito,$seg_hora_transito,$seg_usuario_transito,
																 $seg_estado,$usu_numdoc,$area_descripcion,$cargo_descripcion,
																 $usu_correo,$usu_numdocI,$usu_nombre,$correo_usuario_deriva);
			
			header('Location: '.URLLOGICA.'seguimiento/listar_seguimiento/');
			$this->view->render('seguimiento');		
			
		}catch(Exception $e){			
		}			
	}
	
	private function instance_observacionTotal($id)
	{
		try{
			$Seguimiento = new seguimiento_model();
			return $Seguimiento->listarObservacionTotal($id);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->Codigo = $e->getCode();
			$this->view->Line = $e->getLine();
			$this->view->Trace = $e->getTrace();
			$this->view->render('error');			
		}
	}	
	
	private function instance_seguimientObs($id = '',$PageSize='',$PageNumber='')
	{
		try{
			$SegObservacion = new seguimiento_model();
		
			if ($id <> '') {				
				return $SegObservacion->listarObservaciones($id,$PageSize,$PageNumber);
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}		
		
	}
	
	public function observacion($var='listar',$id = '',$PageNumber='0'){
		
		try{
			$id = $_POST["tram_id"];
			$PageNumber = $_POST["PageNumber"];				
			$var = $_POST["variable"];		
			$PageSize = '3';				
			
			
			$objSegObsT = $this->instance_observacionTotal($id);
			$TotalReg= count($objSegObsT);
			$paginas =ceil($TotalReg/3);
			
			if($var=='open'){				
				$PageNumber=$paginas-1;
			}
							
			$objSegObs = $this->instance_seguimientObs($id,$PageSize,$PageNumber);
			// $paginas = $paginas;
			$pageactual = $PageNumber;
			header('Content-Type: application/json');
			$size_data = count($objSegObsT);
			$objSegObs = $this->array_utf8_encode($objSegObs);
			$objSegObsT = $this->array_utf8_encode($objSegObsT);
			echo json_encode(array('data'=>$objSegObs,'size_data'=>$size_data,'last_data'=>$objSegObsT[0]));
			
		}catch(Exception $e){			
		}			
	}
	
	private function instance_concluirseg($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id){
		try{
			
			$Seg_concluido = new seguimiento_model();	
			
			return $Seg_concluido->SegConcluirUpdate($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}	
	
	public function concluir_seguimiento($tramseg_id=''){
		
		try{				
			$seg_fec = str_replace("/","",date("Y-m-d"));			
			$seg_hora = date("H:i:s");
			$seg_usu = $_SESSION['usuario'];
			$seg_estado = 'Concluido';			
			
			$this->view->objSegCon = $this->instance_concluirseg($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id);
			header('Location: '.URLLOGICA.'seguimiento/listar_seguimiento/');
			$this->view->render('seguimiento');	
			
		}catch(Exception $e){			
		}			
	}	
	
	
	private function instance_recibirseg($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id){
		try{
			
			$Seg_recibido = new seguimiento_model();	
			
			return $Seg_recibido->SegRecibirUpdate($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id);
			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}	
	
	public function recibir_seguimiento($tramseg_id=''){
		
		try{
						
			$seg_fec = str_replace("/","",date("Y-m-d"));
			$seg_hora = date("H:i:s");
			$seg_usu = $_SESSION['usuario'];
			$seg_estado = 'Recibido';
			
			
			$this->view->objSegRec = $this->instance_recibirseg($seg_fec,$seg_hora,$seg_usu,$seg_estado,$tramseg_id);
			header('Location: '.URLLOGICA.'seguimiento/listar_seguimiento/');
			$this->view->render('seguimiento');	
			
		}catch(Exception $e){			
		}			
	}	

	private function instance_busqueda($num_docum="",$tipo_docum="",$estado="",$fec_inicial="",$fec_final="",$seg_usuario="")
	{
		try{
			$Seguimiento = new seguimiento_model();
			
			if ($num_docum == "" and $tipo_docum == "" and $fec_inicial =="" and $fec_final =="" and $estado=="") {
				return $Seguimiento->BuscarTramite($num_docum,$tipo_docum,$fec_inicial,$fec_final,$estado,$seg_usuario);				
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}
	}
	public function descargar_archivo($nom_doc,$id){
		
		$nas = new nas_model();
		$extension = array_pop(explode(".",$nom_doc));
		$nas->loadFileNas($id.".".$extension,$nom_doc);
		
	}
	
	public function historial_fechas($tram_id,$seg_id){
		
		try{
			$tram_id = $_POST['tram_id'];
			$seg_id = $_POST['seg_id'];
				
			$modelo = new seguimiento_model();						
			$historial = $modelo->historial_fechas($tram_id,$seg_id);
			
			header('Content-Type: application/json');
			print_r(json_encode($historial));
		}catch(Exception $e){
				$this->view->msg_catch = $e->getMessage();
				$this->view->render('error');			
		}			
	}			
}
?>