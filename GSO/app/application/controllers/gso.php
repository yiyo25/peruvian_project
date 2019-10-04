<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gso extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('gso_model');
	}
	/*
	** Perfil Administrador
	*/
	/*
	** Vista Grilla
	*/
	public function index(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_Reportes');
		$this->load->view('plantilla/footer');
	}
	/*
	** Eliminar
	*/
	public function eliminarReporte(){
		$arrayReporte	=	array(
								'Rep_Estado'	=>	0
							);
		$this->gso_model->editarReporte($_POST['id'],$arrayReporte);
	}
	
	
		public function pasaraIOSA(){
	
		error_log("ARRIBA PERU55");
		$listax = $this->gso_model->datoReporte($_POST['id']);
		error_log(print_r($listax,TRUE));
	
		//$listax=json_encode($listax);
		
		//foreach($listax as $dPx){
		 $Rep_FechaEnvio=date('Y-m-d H:i:s');
         $dPx=$listax;
		
		$arrayDatax	=	array(
						'Rep_Codigo' => $dPx->Rep_Codigo, 	  
						'Rep_Fecha' => $dPx->Rep_Fecha,   
						'Rep_Nombre' => $dPx->Rep_Nombre,   
						'Pro_ID' => $dPx->Pro_ID,    
						'SubPro_ID' => $dPx->SubPro_ID,    
						'Rep_Aspecto' => $dPx->Rep_Aspecto,   
						'Rep_TipoReporte' => $dPx->Rep_TipoReporte,    
						'Rep_FuenteInformacion' => $dPx->Rep_FuenteInformacion,    
						'Rep_Especificar' => $dPx->Rep_Especificar,    
						'Rep_Descripcion' => $dPx->Rep_Descripcion,  
						'Rep_FechaRegistro' => $dPx->Rep_FechaRegistro,    
						'Rep_IpUsuario' => $dPx->Rep_IpUsuario,    
						'Rep_Adjunto' => $dPx->Rep_Adjunto,    
						'Rep_Estado' => $dPx->Rep_Estado,
						'Rep_FechaEnvio' => $Rep_FechaEnvio	
															
									);
						//	}
							   // json_encode($arrayData);
							   error_log("ARRIBA PERU66");
							   error_log(print_r($arrayDatax,TRUE));
								$this->gso_model->grabarReporte2($arrayDatax);
		
			$arrayReporte	=	array(
								'Rep_Estado' =>	8
							);
		    $this->gso_model->editarReporte($_POST['id'],$arrayReporte);
		
	}
	
	
	
	function save(){
		session_start();
		$config['upload_path'] 			= 	'upload/archivosReportesGSO/';
		$config['allowed_types'] 		= 	'gif|jpg|png|bitmap|tif|raw|svg|exif|webp|pdf|xls|xml|xlt|xla|xlsx|xlsb|xlsm|xltx|xltm|xlam|pps|doc|docx|ppt|pot|pps|pptx|mp4|avi|dvd|wmv|mkv|mov|zip|rap';
		$config['encrypt_name']			=	TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('txtAdjuntar')){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$data = array('upload_data' => $this->upload->data());
			$_SESSION['arrayFileNameGSO'][]	=	$data['upload_data']['file_name'];
		}
	}
	function delete(){
		/*$ruta_csv = '../reportes/fotosReportesGSO/'.$this->input->post('txtAdjuntar');
		echo $ruta_csv;
		unlink($ruta_csv);*/
	}
	public function portada(){
		$this->load->view('gso/reportes/portada');
	}

/*BENITES*/


	public function index2(){
		$data['descripcion']		=	$this->gso_model->secciones(1)->Sec_descripcion;
		$data['tituloSeccion1']		=	$this->gso_model->secciones(2)->Sec_Titulo;
		$data['descripcionSeccion1']=	$this->gso_model->secciones(2)->Sec_descripcion;
		$this->load->view('gso/reportes/Man_reportesIndex2',$data);
	}



/*CANEVARO*/


	public function index3(){
		$data['descripcion']		=	$this->gso_model->secciones(1)->Sec_descripcion;
		$data['tituloSeccion1']		=	$this->gso_model->secciones(2)->Sec_Titulo;
		$data['descripcionSeccion1']=	$this->gso_model->secciones(2)->Sec_descripcion;
		$this->load->view('gso/reportes/Man_reportesIndex3',$data);
	}

	/*
	** Perfil Usuario
	*/
	public function grabarReporte(){
		session_start();
		$cadenaFileNameGSO	=	implode(',',$_SESSION['arrayFileNameGSO']);
		$this->load->helper('string');
		$cvalidador	=	1; //ContadorValidador
		while($cvalidador===1){
			$codigo		=	random_string('alnum', 6);
			$cvalidador	=	$this->gso_model->validadorCodigoReporte($codigo);
		}
		$dataReporte	=	array(
								'Rep_Fecha'				=>	date('Y-m-d'),
								'Rep_Codigo'			=>	$codigo,
								'Rep_Nombre' 			=>	$_POST['txtNombre'],								
								'Rep_Descripcion'		=>	$_POST['txtareaDescripcion'],
								'Rep_IpUsuario'			=>	$_SERVER['REMOTE_ADDR'],
								'Rep_Adjunto'			=>	$cadenaFileNameGSO	
							);
		$id				=	$this->gso_model->grabarReporte($dataReporte);
		if($id>0){
			$this->enviarCorreoalEncargado();
			echo $codigo;
		}else{
			echo 0;
		}
		//echo $id.'@'.$codigo;
	}
	public function verReporteUsuario(){
		$data['dataReporte']		=	$this->gso_model->datoReporte($_POST['id']);
		$data['tituloSeccion2']		=	$this->gso_model->secciones(3)->Sec_Titulo;
		$data['descripcionSeccion2']=	$this->gso_model->secciones(3)->Sec_descripcion;
		$data['tituloSeccion3']		=	$this->gso_model->secciones(4)->Sec_Titulo;
		$data['descripcionSeccion3']=	$this->gso_model->secciones(4)->Sec_descripcion;
		$data['tituloSeccion4']		=	$this->gso_model->secciones(5)->Sec_Titulo;
		$data['descripcionSeccion4']=	$this->gso_model->secciones(5)->Sec_descripcion;
		$data['tituloSeccion5']		=	$this->gso_model->secciones(6)->Sec_Titulo;
		$data['descripcionSeccion5']=	$this->gso_model->secciones(6)->Sec_descripcion;
		$data['dataRepSec']			=	$this->gso_model->reporteSeccion($_POST['id'],array('ALL'));
		$this->load->view('gso/reportes/VisUser_SeccionesReporte',$data);
	}
	
	
	
	/*
	** Lista Reportes 
	*/
	public function listaReporte($tipo){
		if($tipo==='NoAtendido'){
			$estado=array(2);
		}elseif($tipo==='Bandeja'){
			$estado=array(1);
		}elseif($tipo=='Seguimiento'){
			$estado=array(3,4,5);
		}elseif($tipo=='Terminado'){
			$estado=array(6);
		}		
		//$this->load->view('session');
		$dataListaReporte	=	$this->gso_model->listaReporte($estado);
		foreach($dataListaReporte as $dLR){
			$dataFecha	=	explode('-',$dLR->Rep_Fecha);
			$fecha		=	$dataFecha[2].'-'.$dataFecha[1].'-'.$dataFecha[0];
			
			$dataFechaEnvio	=	explode('-',substr($dLR->Rep_FechaEnvio,0,10));
			$fechaEnvio		=	$dataFechaEnvio[2].'-'.$dataFechaEnvio[1].'-'.$dataFechaEnvio[0];
			
			$arrayData[]	=	array(
									'id'			=>	$dLR->Rep_ID,
									'fecha'			=>	$fecha,
									'codigo'		=>	$dLR->Rep_Codigo,
									'idProceso'		=>	$dLR->Pro_ID,
									'proceso'		=>	$dLR->Pro_Abreviatura,
									'idSubProceso'	=>	$dLR->SubPro_ID,
									'subProceso'	=>	$dLR->SubPro_Abreviatura,
									'nombre'	    =>	$dLR->nombre,
									'descripcion'	=>	$dLR->Rep_Descripcion,									
									'fecha_recepcion'	=> $fechaEnvio
								);
		}
		echo json_encode($arrayData);
	}


  public function filtrarReporteProceso($tipo){
		if($tipo==='NoAtendido'){
			$estado=array(2);
		}elseif($tipo==='Bandeja'){
			$estado=array(1);
		}elseif($tipo=='Seguimiento'){
			$estado=array(3,4,5);
		}elseif($tipo=='Terminado'){
			$estado=array(6);
		}		
		//$this->load->view('session');
		$dataListaReporte	=	$this->gso_model->filtrarReporteProceso($estado);
		foreach($dataListaReporte as $dLR){
			$dataFecha	=	explode('-',$dLR->Rep_Fecha);
			$fecha		=	$dataFecha[2].'-'.$dataFecha[1].'-'.$dataFecha[0];
			
			$dataFechaEnvio	=	explode('-',substr($dLR->Rep_FechaEnvio,0,10));
			$fechaEnvio		=	$dataFechaEnvio[2].'-'.$dataFechaEnvio[1].'-'.$dataFechaEnvio[0];
			
			$arrayData[]	=	array(
									'id'			=>	$dLR->Rep_ID,
									'fecha'			=>	$fecha,
									'codigo'		=>	$dLR->Rep_Codigo,
									'idProceso'		=>	$dLR->Pro_ID,
									'proceso'		=>	$dLR->Pro_Abreviatura,
									'idSubProceso'	=>	$dLR->SubPro_ID,
									'subProceso'	=>	$dLR->SubPro_Abreviatura,
									'descripcion'	=>	$dLR->Rep_Descripcion,
									'fecha_recepcion'	=> $fechaEnvio
								);
		}
		echo json_encode($arrayData);
	}


 public function filtrarReporteSubProceso($tipo){
		if($tipo==='NoAtendido'){
			$estado=array(2);
		}elseif($tipo==='Bandeja'){
			$estado=array(1);
		}elseif($tipo=='Seguimiento'){
			$estado=array(3,4,5);
		}elseif($tipo=='Terminado'){
			$estado=array(6);
		}		
		//$this->load->view('session');
		$dataListaReporte	=	$this->gso_model->filtrarReporteSubProceso($estado);
		foreach($dataListaReporte as $dLR){
			$dataFecha	=	explode('-',$dLR->Rep_Fecha);
			$fecha		=	$dataFecha[2].'-'.$dataFecha[1].'-'.$dataFecha[0];
			
			$dataFechaEnvio	=	explode('-',substr($dLR->Rep_FechaEnvio,0,10));
			$fechaEnvio		=	$dataFechaEnvio[2].'-'.$dataFechaEnvio[1].'-'.$dataFechaEnvio[0];
			
			$arrayData[]	=	array(
									'id'			=>	$dLR->Rep_ID,
									'fecha'			=>	$fecha,
									'codigo'		=>	$dLR->Rep_Codigo,
									'idProceso'		=>	$dLR->Pro_ID,
									'proceso'		=>	$dLR->Pro_Abreviatura,
									'idSubProceso'	=>	$dLR->SubPro_ID,
									'subProceso'	=>	$dLR->SubPro_Abreviatura,
									'descripcion'	=>	$dLR->Rep_Descripcion,
									'fecha_recepcion'	=> $fechaEnvio
								);
		}
		echo json_encode($arrayData);
	}





	public function viewMantenimientoReporte(){
		$data['url']			=	base_url().'/upload/archivosReportesGSO';
		$data['mantenimiento']	=	$_POST['mantenimiento'];
		/*echo '<pre>';
		print_r($data['dataReporte']);
		echo '</pre>';*/
		if($_POST['mantenimiento']==='Nuevo'){
			$this->load->view('gso/reportes/Man_Reporte',$data);
		}elseif($_POST['mantenimiento']==='Editar'){
			$data['dataReporte']	=	$this->gso_model->datoReporte($_POST['id']);
			$this->load->view('gso/reportes/Man_Reporte',$data);
		}
	}	
	/*
	** Lista Proceso y Subproceso por Codigo
	*/
	public function listaCodigo(){
		$dataListaCodigo	=	$this->gso_model->listaCodigo();
		foreach($dataListaCodigo as $dLC){
			$dataCodigo[]	=	array(
									'id'			=>	$dLC->Cod_ID,
									'descripcion'	=>	$dLC->Cod_Abreviatura,
									'proid'			=>	$dLC->Pro_ID,
									'subproid'		=>	$dLC->SubPro_ID
								);
		}
		echo json_encode($dataCodigo);
	}
	/*
	** Buscar Proceso y SubProcesos por Código
	*/
	public function buscarCodigo(){
		$dataCodigo	=	$this->gso_model->buscarCodigo($_POST['id']);
		if(count($dataCodigo)===1){
			echo $dataCodigo->Pro_ID.'@'.$dataCodigo->SubPro_ID;
		}else{
			echo 0;
		}
	}
	/*
	** Enviar al dueño de Proceso y Editar el Proceso
	*/
	public function enviarDuenoProceso(){
		$dataDuenoProceso	=	$this->gso_model->dataCorreoResponsables($_POST['cboProceso'],$_POST['cboSubProceso']);
		foreach($dataDuenoProceso as $dDP){
			$email[]	=	$dDP->Res_Correo;
		}
		if(count($email)===0){
			echo 'Aún no hay dueño del proceso para este reporte';
		}else{
			if($_POST['cboSubProceso']==''){
				$subProceso	=	0;
			}else{
				$subProceso	=	$_POST['cboSubProceso'];
			}
			$arrayReporte	=	array(
								'Pro_ID'				=>	$_POST['cboProceso'],	
								'SubPro_ID'				=>	$subProceso,			
								'Rep_Aspecto'			=>	$_POST['cboAspecto'],
								'Rep_TipoReporte'		=>	$_POST['cboTipoReporte'],
								'Rep_Descripcion'		=>	$_POST['txtAreaDescripcion'],
								'Rep_Estado'			=>	2
							);
			$this->gso_model->editarReporte($_POST['id'],$arrayReporte);
			$this->gso_model->crearSeccionesReporte($_POST['id']);
			$this->enviarCorreoDuenoProceso($email);
		}
	}
	/*
	** Enviar al dueño del proceso
	*/
	function enviarCorreoDuenoProceso($email){
		$this->load->library('email','','correo');
		$config['smtp_host']= 'mail.peruvian.pe';
		$config['smtp_user']= 'reportes.sms@peruvian.pe';
		//$config['smtp_pass']= 'ven8065x';
		$config['smtp_port']= '25';
		$config['priority'] = '1';			
		$this->correo->initialize($config);
		$this->correo->from('reportes.sms@peruvian.pe', 'Reporte SMS - Jefe de Proceso');
		$this->correo->subject('Reporte SMS - Jefe de Proceso');
		$this->correo->to($email);
		$msg = $this->load->view('gso/reportes/MSJ/MSJ_ReporteSMS', $data, true);
		$this->correo->message($msg);
		if($dato===0){			
			echo '0';
		}else{
			if($this->correo->send()){
				echo '1';
			}else{
				show_error($this->correo->print_debugger());
			}
		}		
	}
	/*
	** Cola de Reportes
	*/
	function reportesNoAtendidos(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_ReportesNoAtendidos');
		$this->load->view('plantilla/footer');
	}
	/*
	** Enviar Recordatorio de reporte no atendido
	*/	
	function enviarRecordatorioRNA(){
		$dataDuenoProceso	=	$this->gso_model->dataCorreoResponsables($_POST['idProceso'],$_POST['idSubProceso']);
		foreach($dataDuenoProceso as $dDP){
			$email[]	=	$dDP->Res_Correo;
		}
		$data['codigo']	=	$_POST['codigo'];
		$this->load->library('email','','correo');
		$config['smtp_host']= 'mail.peruvian.pe';
		$config['smtp_user']= 'reportes.sms@peruvian.pe';
		//$config['smtp_pass']= 'ven8065x';
		$config['smtp_port']= '25';
		$config['priority'] = '1';			
		$this->correo->initialize($config);
		$this->correo->from('reportes.sms@peruvian.pe', 'Reporte SMS Recordatorio');
		$this->correo->subject('Reporte SMS Recordatorio');
		$this->correo->to($email);
		//$this->correo->bcc('robert.paredes@peruvian.pe');		
		$msg = $this->load->view('gso/reportes/MSJ/MSJ_RecordatorioReporte', $data, true);
		$this->correo->message($msg);
		if($dato===0){			
			echo '0';
		}else{
			if($this->correo->send()){
				echo '1';
			}else{
				show_error($this->correo->print_debugger());
			}
		}	
	}
	public function reportesSeguimiento(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_ReportesSeguimiento');
		$this->load->view('plantilla/footer');
	}
	/*
	** View Seguimiento Reporte para el Administrador
	*/
	function viewSegumientoReporte(){
		$data['dataReporte']		=	$this->gso_model->datoReporte($_POST['id']);
		$data['tituloSeccion2']		=	$this->gso_model->secciones(3)->Sec_Titulo;
		$data['descripcionSeccion2']=	$this->gso_model->secciones(3)->Sec_descripcion;
		$data['tituloSeccion3']		=	$this->gso_model->secciones(4)->Sec_Titulo;
		$data['descripcionSeccion3']=	$this->gso_model->secciones(4)->Sec_descripcion;
		$data['tituloSeccion4']		=	$this->gso_model->secciones(5)->Sec_Titulo;
		$data['descripcionSeccion4']=	$this->gso_model->secciones(5)->Sec_descripcion;
		$data['tituloSeccion5']		=	$this->gso_model->secciones(6)->Sec_Titulo;
		$data['descripcionSeccion5']=	$this->gso_model->secciones(6)->Sec_descripcion;
		$data['dataRepSec']			=	$this->gso_model->reporteSeccion($_POST['id'],array('ALL','ADM'));
		$data['tipo']				=	$_POST['tipo'];
		$this->load->view('gso/reportes/Vis_SeccionesReporte',$data);
	}
	public function reportesTerminados(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_ReportesTerminados');
		$this->load->view('plantilla/footer');
	}
	
	
	
	
	/*
	** Perfil Dueño del Proceso
	*/
	/*
	**
	** reporte Responsable
	**
	*/
	function reporteResponsables(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_ReporteResponsables');
		$this->load->view('plantilla/footer');
	}
	/*
	** Lista responsable
	*/
	function listaReporteResponsables(){		
		$this->load->view('session');
		$idPersonal		=	$_SESSION["ck_id_usuario"];		
		$dataResponsable=	$this->gso_model->listaResponsablesProceso($idPersonal);
		foreach($dataResponsable as $dR){
			$arrayReportes['ProId'][]		=	$dR->Pro_ID;
			$arrayReportes['SubProID'][]	=	$dR->SubPro_ID;
		}
		$estado			=	array(2,3,4,5);
		$dataListaReporte	=	$this->gso_model->listaReporte($estado,$arrayReportes['ProId'],$arrayReportes['SubProID']);
		foreach($dataListaReporte as $dLR){
			$dataFecha	=	explode('-',$dLR->Rep_Fecha);
			$fecha		=	$dataFecha[2].'-'.$dataFecha[1].'-'.$dataFecha[0];
			
			$dataFechaEnvio	=	explode('-',substr($dLR->Rep_FechaEnvio,0,10));
			$fechaEnvio		=	$dataFechaEnvio[2].'-'.$dataFechaEnvio[1].'-'.$dataFechaEnvio[0];
			
			
			$arrayData[]	=	array(
									'id'			=>	$dLR->Rep_ID,
									'fecha'			=>	$fecha,
									'codigo'		=>	$dLR->Rep_Codigo,									
									'descripcion'	=>	$dLR->Rep_Descripcion,
									'fecha_recepcion'	=> $fechaEnvio
								);
		}
		echo json_encode($arrayData);
	}
	/*
	** View Reporte para el Dueño del Procesoe
	*/
	function viewSeccionesReporteDP(){
		$data['dataReporte']		=	$this->gso_model->datoReporte($_POST['id']);
		$data['tituloSeccion2']		=	$this->gso_model->secciones(3)->Sec_Titulo;
		$data['descripcionSeccion2']=	$this->gso_model->secciones(3)->Sec_descripcion;
		$data['tituloSeccion3']		=	$this->gso_model->secciones(4)->Sec_Titulo;
		$data['descripcionSeccion3']=	$this->gso_model->secciones(4)->Sec_descripcion;
		$data['tituloSeccion4']		=	$this->gso_model->secciones(5)->Sec_Titulo;
		$data['descripcionSeccion4']=	$this->gso_model->secciones(5)->Sec_descripcion;
		$data['tituloSeccion5']		=	$this->gso_model->secciones(6)->Sec_Titulo;
		$data['descripcionSeccion5']=	$this->gso_model->secciones(6)->Sec_descripcion;
		$data['dataRepSec']			=	$this->gso_model->reporteSeccion($_POST['id'],array('ALL'));
		$data['tipo']				=	$_POST['tipo'];
		$this->load->view('gso/reportes/Vis_SeccionesReporte',$data);
	}
	/*
	** Grabar Secciones
	*/
	function CambiarEstadoReporte(){
		$arrayReporte	=	array(
								'Rep_Estado'	=>	"7"
							);
		$this->gso_model->editarReporte($_POST['id'],$arrayReporte);	
		echo "Reporte Desestimado.";						
	}
	function grabarSeccionesReporte(){
		if($_POST['idsec']==4){
			$datafecImp	=	explode('/',$_POST['fecImplementacion']);
			$fecImp		=	$datafecImp[2].'-'.$datafecImp[1].'-'.$datafecImp[0];
			$arraySeccion	=	array(
									'Cat_ID'					=>	$_POST['cboTipoAccion'],									
									'RepSec_Descripcion'		=>	$_POST['txtDescripcion'],
									'RepSec_ResImplementacion'	=>	$_POST['resimplementacion'],
									'RepSec_FechaImplementacion'=>	$fecImp,
									'RepSec_ResVerificacion'	=>	$_POST['resverificacion'],
									'RepSec_FechaVerificacion'	=>	$fecVer,
									'RepSec_Estado'				=>	'1'
								);
		}else{
			$arraySeccion	=	array(
									'RepSec_Descripcion'	=>	$_POST['txtDescripcion'],
									'RepSec_Estado'			=>	'1'
								);
		}
		$arrayReporte	=	array(
								'Rep_Estado'	=>	$_POST['estado']
							);
		$this->gso_model->editarReporte($_POST['idReporte'],$arrayReporte);
		$data	=	$this->gso_model->grabarSeccionesReporte($_POST['id'],$arraySeccion);
		echo $data;
	}
	
	
	
	
	
	
	/*
	** Enviar el correo al Encargado de SMS
	*/
	private function enviarCorreoalEncargado(){	
		$arrayTo	=	array(
							'luis.gonzales@peruvian.pe',
							'joel.sotelo@peruvian.pe'
						);	
		/*$arrayTo	=	array(
							'robert.paredes@peruvian.pe'
						);*/
						
		$this->load->library('email','','correo');
		$config['smtp_host']= 'mail.peruvian.pe';
		$config['smtp_user']= 'reportes.sms@peruvian.pe';
		//$config['smtp_pass']= 'ven8065x';
		$config['smtp_port']= '25';
		$config['priority'] = '1';			
		$this->correo->initialize($config);
		$this->correo->from('reportes.sms@peruvian.pe', 'Reporte SMS - Encargado');
		$this->correo->subject('Reporte SMS - Encargado');
		$this->correo->to($arrayTo);
		$this->correo->bcc('robert.paredes@peruvian.pe');		
		$msg = $this->load->view('gso/reportes/MSJ/MSJ_ReporteSMS', $data, true);
		//$this->correo->attach('reportes/resumen_de_vuelos_'.$fecha.'.xlsx');		
		$this->correo->message($msg);
		if($dato===0){			
			return '0';
		}else{
			if($this->correo->send()){
				return '1';
			}else{
				show_error($this->correo->print_debugger());
			}
		}
	}
	public function enviarCorreoUsuario(){
		$this->load->library('email','','correo');
		$config['smtp_host']= 'mail.peruvian.pe';
		$config['smtp_user']= 'reportes.sms@peruvian.pe';
		//$config['smtp_pass']= 'ven8065x';
		$config['smtp_port']= '25';
		$config['priority'] = '1';			
		$this->correo->initialize($config);
		$this->correo->from('reportes.sms@peruvian.pe', 'Reporte SMS');
		$this->correo->subject('Código de Reporte SMS');
		$this->correo->to($_POST['email']);	
		$data['codigo']		=	$_POST['codigo'];
		$msg = $this->load->view('gso/reportes/MSJ/MSJ_CodigoReporteSMS', $data, true);
		$this->correo->message($msg);
		if($dato===0){			
			echo '0';
		}else{
			if($this->correo->send()){
				echo '1';
			}else{
				show_error($this->correo->print_debugger());
			}
		}		
	}
	public function vistaCodigoReporte(){
		$data['codigo']	=	$_POST['codigo'];
		$this->load->view('gso/reportes/Vis_CodigoReporte',$data);
	}
	
	public function sms(){
		/*$data['descripcion']		=	$this->gso_model->secciones(1)->Sec_descripcion;
		$data['tituloSeccion1']		=	$this->gso_model->secciones(2)->Sec_Titulo;
		$data['descripcionSeccion1']=	$this->gso_model->secciones(2)->Sec_descripcion;
		$this->load->view('gso/reportes/Man_reportesIndex',$data);*/
		$this->load->view('gso/reportes/portada',$data);
	}
	/*
	** Mantenimiento de SMS
	*/
	
	/*
	**
	** Procesos
	**
	*/
	public function procesos(){
        $data =array();
	    if(isset($_GET["id_usuario"]) && $_GET["id_usuario"]!=""){
	        $usuario = $_GET["id_usuario"];
            $permiso_procesos = $this->PermisosporPaginas("GSO_MANT_PROC",1,$usuario);
            $data["permiso_agregar"] = $permiso_procesos[0]["Agregar"];
            $data["permiso_editar"] = $permiso_procesos[0]["Modificar"];
            $data["permiso_eliminar"] = $permiso_procesos[0]["Eliminar"];
        }
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_Procesos',$data);
		$this->load->view('plantilla/footer');
	}
	/*
	** Mantenimiento
	*/
	public function viewMantenimientoProceso(){
		if($_POST['mantenimiento']=='Editar'){
			$data['mantenimiento']	=	'Editar';	
			$data['dataProceso']	=	$this->gso_model->datoProceso($_POST['id']);		
		}else{
			$data['mantenimiento']	=	'Nuevo';
		}
		$this->load->view('gso/reportes/Man_Procesos',$data);		
	}	
	/*
	** Lista Proceso
	*/
	public function listaProcesos(){
		$dataProcesos	=	$this->gso_model->listaProcesos();
		foreach($dataProcesos as $dP){
			$arrayProcesos[]	=	array(
										'id'			=>	$dP->Pro_ID,
										'abreviatura'	=>	$dP->Pro_Abreviatura,
										'descripcion'	=>	$dP->Pro_Descripcion
									);
		}
		echo json_encode($arrayProcesos);
	}
	/*
	** Grabar Proceso
	*/
	public function grabarProceso(){
		$query			=	'SELECT COUNT(*) AS Contador FROM gso_proceso WHERE (Pro_Abreviatura="'.$_POST['txtAbreviatura'].'" OR Pro_Descripcion="'.$_POST['txtDescripcion'].'")';		
		$datosRepetidos	=	$this->gso_model->datosRepetidos($query);
		if($datosRepetidos==='0'){
			$arrayProceso	=	array(
								'Pro_Abreviatura'	=>	$_POST['txtAbreviatura'],
								'Pro_Descripcion'	=>	$_POST['txtDescripcion']
							);
			echo $this->gso_model->grabarProceso($arrayProceso);
		}else{
			echo 'El dato se encuentra ya registrado';
		}
	}
	/*
	** Editar Proceso
	*/	
	public function editarProceso(){
		if($_POST['mantenimiento']==='Eliminar'){
			$arrayProceso	=	array(
										'Pro_Estado'	=>	0
									);
			echo $this->gso_model->editarProceso($_POST['id'],$arrayProceso);
		}else{
			$query			=	'SELECT COUNT(*) AS Contador FROM gso_proceso WHERE Pro_ID NOT IN('.$_POST['id'].') AND (Pro_Abreviatura="'.$_POST['txtAbreviatura'].'" OR Pro_Descripcion="'.$_POST['txtDescripcion'].'")';
			$datosRepetidos	=	$this->gso_model->datosRepetidos($query);
			if($datosRepetidos==='0'){
				$arrayProceso	=	array(
										'Pro_Abreviatura'	=>	$_POST['txtAbreviatura'],
										'Pro_Descripcion'	=>	$_POST['txtDescripcion']
									);
				echo $this->gso_model->editarProceso($_POST['id'],$arrayProceso);
			}else{
				echo 'El dato se encuentra ya registrado';	
			}	
		}		
	}
	/*
	**
	** Sub Procesos
	**
	*/
	public function subProcesos(){
        $data =array();
        if(isset($_GET["id_usuario"]) && $_GET["id_usuario"]!=""){
            $usuario = $_GET["id_usuario"];
            $permiso_procesos = $this->PermisosporPaginas("GSO_MANT_SUBP",1,$usuario);
            $data["permiso_agregar"] = $permiso_procesos[0]["Agregar"];
            $data["permiso_editar"] = $permiso_procesos[0]["Modificar"];
            $data["permiso_eliminar"] = $permiso_procesos[0]["Eliminar"];
        }
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_subProcesos',$data);
		$this->load->view('plantilla/footer');
	}
	/*
	** Lista Sub Proceso
	*/
	public function listaSubProcesos($id=NULL){	
		if(is_null($id)){
			$dataSubProcesos	=	$this->gso_model->listaSubProcesos();
		}else{
			$dataSubProcesos	=	$this->gso_model->listaSubProcesos($id);
		}		
		foreach($dataSubProcesos as $dSP){
			$arrayProcesos[]	=	array(
										'id'			=>	$dSP->SubPro_ID,
										'proceso'		=>	$dSP->Pro_Descripcion,
										'abreviatura'	=>	$dSP->SubPro_Abreviatura,
										'descripcion'	=>	$dSP->SubPro_Descripcion
									);
		}
		echo json_encode($arrayProcesos);
	}
	/*
	** Mantenimiento Sub Proceso
	*/
	public function viewMantenimientoSubProceso(){
		if($_POST['mantenimiento']=='Editar'){
			$data['mantenimiento']	=	'Editar';	
			$data['dataSubProceso']	=	$this->gso_model->datoSubProceso($_POST['id']);		
		}else{
			$data['mantenimiento']	=	'Nuevo';
		}
		$this->load->view('gso/reportes/Man_subProcesos',$data);		
	}	
	/*
	** Grabar Sub Proceso
	*/
	public function grabarSubProceso(){
		$query			=	'SELECT COUNT(*) AS Contador FROM gso_subproceso WHERE Pro_ID='.$_POST['cboProceso'].' AND (SubPro_Abreviatura="'.$_POST['txtAbreviatura'].'" OR SubPro_Descripcion="'.$_POST['txtDescripcion'].'")';	
		$datosRepetidos	=	$this->gso_model->datosRepetidos($query);
		if($datosRepetidos==='0'){
			$arraySubProceso=	array(
									'Pro_ID'				=>	$_POST['cboProceso'],
									'SubPro_Abreviatura'	=>	$_POST['txtAbreviatura'],
									'SubPro_Descripcion'	=>	$_POST['txtDescripcion']
								);
			echo $this->gso_model->grabarSubProceso($arraySubProceso);
		}else{
			echo 'El dato se encuentra ya registrado';
		}
	}
	/*
	** Editar Sub Proceso editarSubProceso
	*/
	public function editarSubProceso(){
		if($_POST['mantenimiento']==='Eliminar'){
			$arraySubProceso	=	array(
										'SubPro_Estado'		=>	0
									);
				echo $this->gso_model->editarSubProceso($_POST['id'],$arraySubProceso);
		}else{
			$query			=	'SELECT COUNT(*) AS Contador FROM gso_subproceso WHERE SubPro_ID NOT IN('.$_POST['id'].') AND  Pro_ID='.$_POST['cboProceso'].' AND (SubPro_Abreviatura="'.$_POST['txtAbreviatura'].'" OR SubPro_Descripcion="'.$_POST['txtDescripcion'].'")';
			$datosRepetidos	=	$this->gso_model->datosRepetidos($query);
			if($datosRepetidos==='0'){
				$arraySubProceso	=	array(
											'Pro_ID'			=>	$_POST['cboProceso'],
											'SubPro_Abreviatura'=>	$_POST['txtAbreviatura'],
											'SubPro_Descripcion'=>	$_POST['txtDescripcion']
										);
				echo $this->gso_model->editarSubProceso($_POST['id'],$arraySubProceso);
			}else{
				echo 'El dato se encuentra ya registrado';	
			}
		}
	}
	/*
	**
	** Responsables
	**
	*/
	public function responsables(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_Responsables');
		$this->load->view('plantilla/footer');
	}
	/*
	** Lista Responsables
	*/
	public function listaResponsables(){
		$dataResponsables	=	$this->gso_model->listaResponsables();
		foreach($dataResponsables as $dR){
			$arrayResponsable[]	=	array(
										'id'			=>	$dR->Res_ID,
										'usuario'		=>	$dR->usuario,
										'responsable'	=>	$dR->apellido.' '.$dR->nombre,
										'proceso'		=>	$dR->Pro_Abreviatura,
										'subproceso'	=>	$dR->SubPro_Abreviatura,
										'nombre'		=>	$dR->Res_Nombre,
										'correo'		=>	$dR->Res_Correo
									);
		}
		echo json_encode($arrayResponsable);
	}
	/*
	** Mantenimiento
	*/
	public function viewMantenimientoResponsables(){
		if($_POST['mantenimiento']=='Editar'){
			$data['mantenimiento']	=	'Editar';
			$data['dataSubProceso']	=	$this->gso_model->datoSubProceso($_POST['id']);		
		}else{
			$data['mantenimiento']	=	'Nuevo';
		}
		$this->load->view('gso/reportes/Man_responsables',$data);		
	}
	/*
	** Mantenimiento
	*/
	public function viewMantenimientoResponsable(){
		if($_POST['mantenimiento']=='Editar'){
			$data['mantenimiento']	=	'Editar';
			$data['dataResponsable']	=	$this->gso_model->datoResponsable($_POST['id']);		
		}else{
			$data['mantenimiento']	=	'Nuevo';
		}
		$this->load->view('gso/reportes/Man_responsables',$data);		
	}	
	/*
	** Grabar Responsable
	*/
	public function grabarResponsable(){
		$arrayResponsable	=	array(
								'idusuario'	=>	$_POST['idUsuario'],
								'Pro_ID'	=>	$_POST['cboProceso'],
								'SubPro_ID'	=>	$_POST['cboSubProceso'],						
								'Res_Correo'=>	$_POST['email']
							);
		echo $this->gso_model->grabarResponsable($arrayResponsable);
	}
	/*
	** Editar Responsable
	*/
	function editarResponsable(){
		if($_POST['mantenimiento']==='Eliminar'){
			$arrayResponsable	=	array(
									'Res_Estado'=>	0
								);
			echo $this->gso_model->editarResponsable($_POST['id'],$arrayResponsable);	
		}else{
			$arrayResponsable	=	array(
									'idusuario'	=>	$_POST['idUsuario'],
									'Pro_ID'	=>	$_POST['cboProceso'],
									'SubPro_ID'	=>	$_POST['cboSubProceso'],						
									'Res_Correo'=>	$_POST['email']
								);
			echo $this->gso_model->editarResponsable($_POST['id'],$arrayResponsable);				
		}		
	}	
	/*
	**
	** Aspectos
	**
	*/
	public function aspectos(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_Aspectos');
		$this->load->view('plantilla/footer');
	}
	public function tipoReporte(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_TipoReporte');
		$this->load->view('plantilla/footer');
	}
	public function listaSubCategoria($id){
		$dataSubCategoria	=	$this->gso_model->listaSubCategoria($id);
		foreach($dataSubCategoria as $dSC){
			$arraySubCategoria[]	=	array(
											'id'			=>	$dSC->SubCat_ID,
											'abreviatura'	=>	$dSC->SubCat_Abreviatura,
											'descripcion'	=>	$dSC->SubCat_Descripcion
										);
		}
		echo json_encode($arraySubCategoria);
	}
	public function viewMantenimientoSubCategoria(){
		if($_POST['mantenimiento']=='Editar'){
			$data['mantenimiento']		=	'Editar';
			$data['dataSubCategoria']	=	$this->gso_model->datoSubCategoria($_POST['id']);		
		}else{
			$data['mantenimiento']		=	'Nuevo';
			$data['catID']				=	$_POST['catID'];
		}
		$this->load->view('gso/reportes/Man_SubCategoria',$data);	
	}
	public function editarSubCategoria(){
		if($_POST['mantenimiento']==='Eliminar'){
			$arraySubCategoria	=	array(
									'SubCat_Estado'	=>	'0'
								);
			echo $this->gso_model->editarSubCategoria($_POST['id'],$arraySubCategoria);	
		}else{
			$arraySubCategoria	=	array(
									'SubCat_Abreviatura'	=>	$_POST['abreviatura'],
									'SubCat_Descripcion'	=>	$_POST['descripcion']
								);
			echo $this->gso_model->editarSubCategoria($_POST['id'],$arraySubCategoria);				
		}	
	}
	public function grabarSubCategoria(){
		$arraySubCategoria	=	array(
									'Cat_ID'				=>	$_POST['catID'],
									'SubCat_Abreviatura'	=>	$_POST['abreviatura'],
									'SubCat_Descripcion'	=>	$_POST['descripcion']
								);
		echo $this->gso_model->grabarSubCategoria($arraySubCategoria);
	}
	/*
	** Grilla Codigo
	*/
	public function codigos(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_Codigos');
		$this->load->view('plantilla/footer');
	}
	/*
	** Lista código
	*/
	public function listaCodigos(){
		$dataCodigos	=	$this->gso_model->listaCodigos();
		foreach($dataCodigos as $dC){
			$arrayCodigos[]	=	array(
									'id'			=>	$dC->Cod_ID,
									'codigo'		=>	$dC->Cod_Abreviatura,
									'descripcion'	=>	$dC->Cod_Descripcion,
									'proceso'		=>	$dC->Pro_Abreviatura,
									'subproceso'	=>	$dC->SubPro_Abreviatura
								);
		}
		echo json_encode($arrayCodigos);
	}
	/*
	** View Mantenimiento Código
	*/
	public function viewMantenimientoCodigo(){
		if($_POST['mantenimiento']=='Editar'){
			$data['mantenimiento']	=	'Editar';
			$data['dataCodigo']	=	$this->gso_model->datoCodigo($_POST['id']);	
		}else{
			$data['mantenimiento']	=	'Nuevo';
		}
		$this->load->view('gso/reportes/Man_Codigo',$data);
	}
	/*
	** Grabar Codigo
	*/
	public function grabarCodigo(){
		$arrayCodigo	=	array(
								'Cod_Abreviatura'	=>	$_POST['codigo'],
								'Cod_Descripcion'	=>	$_POST['descripcion'],
								'Pro_ID'			=>	$_POST['cboProceso'],						
								'SubPro_ID'			=>	$_POST['cboSubProceso']
							);
		echo $this->gso_model->grabarCodigo($arrayCodigo);
	}
	/*
	** Editar Codigo
	*/
	function editarCodigo(){
		if($_POST['mantenimiento']==='Eliminar'){
			$arrayCodigo	=	array(
									'Cod_Estado'=>	0
								);
			echo $this->gso_model->editarCodigo($_POST['id'],$arrayCodigo);
		}else{
			$arrayCodigo	=	array(
									'Cod_Abreviatura'	=>	$_POST['codigo'],
									'Cod_Descripcion'	=>	$_POST['descripcion'],
									'Pro_ID'			=>	$_POST['cboProceso'],						
									'SubPro_ID'			=>	$_POST['cboSubProceso']
								);
			echo $this->gso_model->editarCodigo($_POST['id'],$arrayCodigo);				
		}		
	}
	
	/*
	** Grilla Secciones
	*/
	public function secciones(){
		$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/GRI_Secciones');
		$this->load->view('plantilla/footer');
	}
	/*
	** Lista código
	*/
	public function listaSecciones(){
		$dataSecciones	=	$this->gso_model->listaSecciones();
		foreach($dataSecciones as $dS){
			$arraySecciones[]	=	array(
										'id'			=>	$dS->Sec_ID,
										'nombre'		=>	$dS->Sec_Nombre,
										'titulo'		=>	$dS->Sec_Titulo
									);
		}
		echo json_encode($arraySecciones);		
	}
	/*
	** View Mantenimiento Seccion
	*/
	public function viewMantenimientoSeccion(){
		if($_POST['mantenimiento']=='Editar'){
			$data['mantenimiento']	=	'Editar';
			$data['dataSeccion']		=	$this->gso_model->datoSeccion($_POST['id']);
		}else{
			$data['mantenimiento']	=	'Nuevo';
		}
		$this->load->view('gso/reportes/Man_Seccion',$data);
	}
	/*
	** Editar seccion
	*/
	public function editarSeccion(){
		$arraySeccion	=	array(
								'Sec_Titulo'		=>	$_POST['titulo'],
								'Sec_descripcion'	=>	$_POST['descripcion'],
								'Sec_Nombre'		=>	$_POST['nombre']
							);
		echo $this->gso_model->editarSeccion($_POST['id'],$arraySeccion);	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	** Lista Usuarios
	*/
	function listaUsuario(){
		$dataUsuario	=	$this->gso_model->listaUsuario();
		foreach($dataUsuario as $dU){
			$arrayUsuarios[]	=	array(
										'id'		=>	$dU->idusuario,
										'usuario'	=>	$dU->usuario
									);
		}
		echo json_encode($arrayUsuarios);
	}
	/*
	** Data Usuario
	*/
	function dataUsuario(){
		$dataUsuario	=	$this->gso_model->dataUsuario($_POST['id']);
		echo $dataUsuario->apellido.', '.$dataUsuario->nombre.'#'.$dataUsuario->email;
	}
	/*
	** Verificar Codigo
	*/
	function verificarCodigo(){
		$data	=	$this->gso_model->verificarCodigo($_POST['codigo']);
		echo $data->Rep_Estado.'@'.$data->Rep_ID;
	}
	/*
	** UTILITARIOS
	*/
	public function haySubproceso(){
		$data	=	$this->gso_model->haySubproceso($_POST['id']);
		echo count($data);
	}
	
    public function estadistica(){

	    //$data =	$this->gso_model->listaCodigos();
		//$data['dataesta']=$this->gso_model->listaCodigos();
		$data['dataesta']=$this->gso_model->listaProcesosEst();
		$data['datausa']=$this->gso_model->listaResponsables_EST();

		$data['datasubpro']=$this->gso_model->listarSubProceso($_GET['proceso']);
        echo "#asf";Exit;
		if($_GET['proceso']!=0){
		//$var_subpro_real = $_GET['subproceso'];	
		
		if($_GET['subproceso']!=0)	{
		$data['datapro']=$this->gso_model->listaProcesoporDia_EST_sub($_GET['ano'],$_GET['proceso'],$_GET['subproceso']);
		}else{
		$data['datapro']=$this->gso_model->listaProcesoporDia_EST($_GET['ano'],$_GET['proceso']);	
		}	
			
		}else{
		$data['datapro']=$this->gso_model->listaProcesoporDia_EST_all($_GET['ano']);
		}
		

		
		
		
    	$this->load->view('plantilla/header');
		$this->load->view('gso/reportes/EST_ReporteEstadistico',$data);
		$this->load->view('plantilla/footer');
		
		
	}
	
		
}