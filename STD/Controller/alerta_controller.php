<?php
require(dirname(dirname(__FILE__)) . "/Libs/htmlMimeMail5.php");
class alerta extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre	
	}
	
	public function Procesos(){
		try{
			//$this->transito();//-1 diario
			$this->fecha_respuesta();//0-30 (fehca de actual - fecha de respuesta)<=tiempo dia
			$this->concluido_automatico();//0-60 -- ultima fecha de registro del usuario q lo tenga en poder y estado RECIBIDO
			$this->recibido_automatico();
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->Trace = $e->getTrace();
			$this->view->render('error');
		}
	}
	
	public function transito(){
		try{
						
			$Seguimiento = new seguimiento_model();
			$resultado = $Seguimiento->listarTransitoCorreo();
			
			$concluido = $Seguimiento->ConcluidoTable('1');
			$alerta_estado = $concluido[0]['alerta_estado'];
			$alerta_asunto = $concluido[0]['alerta_asunto'];
			$alerta_mensaje = $concluido[0]['alerta_mensaje'];
		
			$alerta_correo_origen = $concluido[0]['alerta_correo_origen'];
			$alerta_correo_copia = $concluido[0]['alerta_correo_copia'];
			$alerta_tiempo_dia = $concluido[0]['alerta_tiempo_dia'];
			if($alerta_estado == '1'){
				foreach ($resultado as $key => $value) {
					$seg_fecha_transito = $value['tram_estado_fecha'];
					$num_doc = $value['tram_nro_doc'];
					$fecha_registro = date("d-m-Y", strtotime($value['tram_fec_reg']));	
					$fecha_doc = date("d-m-Y", strtotime($value['tram_fec_doc']));	
					$remitente = $value['NombreRemitente'];
					$destinatario = $value['NombreDestinatario'];
					$asunto = $value['tram_asunto'];
					$estado = $value['tram_estado'];
					$correo = utf8_encode($value['seg_correo']);
					$Dias = $value['Dias'];
					$correo_copia =utf8_encode($value['seg_correo_copia']);
					
					$alerta_mensaje = str_replace("%1", $Dias,$concluido[0]['alerta_mensaje']);
					date("d-m-Y", strtotime($value['tram_fec_reg']));	
					
					$fecha_transitoria = date("Y-m-d", strtotime($value['tram_estado_fecha']));
					$fecha_hoy = date("Y-m-d");
					
					$Fecha_correo = strtotime("+".$alerta_tiempo_dia."day", strtotime($fecha_transitoria));
					$Fecha_correo = date("Y-m-d" , $Fecha_correo );
					
					if($Fecha_correo <= $fecha_hoy) {
						
						$log_descripcion = 'Transito';
						$log_mensaje = 'Se procede con el envio';
						$log_fecha = date("Y-m-d H:i:s");
						$log_estado = '0';
						$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);
										
						$my_De = $alerta_correo_origen;
						$my_Para = split(',',$correo);
						
						if($correo_copia == '' AND $alerta_correo_copia <> '' ){
							$my_Bcc = $alerta_correo_copia;
						}else{
							if($correo_copia <> '' AND $alerta_correo_copia <> '' ){
								$my_Bcc = $alerta_correo_copia.','.$correo_copia;
							}else{
								if($correo_copia <> '' AND $alerta_correo_copia == '' ){
									$my_Bcc = $correo_copia;
								}
							}						
						}
						// $my_Bcc = $alerta_correo_copia;
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
									          <p><font face='Arial' size='3' color='#555555'>Datos del documento:</font>.</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Nro Documento:</strong> ".$num_doc."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Fecha Registro:</strong>  ".$fecha_registro."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Fecha Documento:</strong> ".$fecha_doc."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Remitente:</strong> ".$remitente."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Destinatario:</strong> ".$destinatario."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Asunto:</strong> ".$asunto."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Estado:</strong> ".$estado."</p>
									          <p></p>
									          <p><font face='Arial' size='3' color='#555555'>Saludos.</p></td>
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
						$mail->setSMTPParams('mail01.peruvian.pe', 25, 'mail01.peruvian.pe', false, 'hugo.salcedo@peruvian.pe', 'peruvian2825');	
						$mail->setBcc($my_Bcc);				
						$mail->setSubject($my_Asunto);
						$mail->setPriority('high');				
						$mail->setHTML($my_Msg);
						$result  = $mail->send($my_Para,'smtp');						
						$log_descripcion = 'Transito';
						$log_mensaje = 'Se envio el Correo correctamente';
						$log_fecha = date("Y-m-d H:i:s");
						$log_estado = '1';
						$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);					
					}				
				}
			}			
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}
	
	public function fecha_respuesta(){
		
		try{
			$Seguimiento = new seguimiento_model();
					
			$resultado = $Seguimiento->listarFechaRespuesta();			
			
			$concluido = $Seguimiento->ConcluidoTable('2');
			$alerta_estado = $concluido[0]['alerta_estado'];
			$alerta_asunto = $concluido[0]['alerta_asunto'];
			$alerta_mensaje = $concluido[0]['alerta_mensaje'];
			$alerta_correo_origen = $concluido[0]['alerta_correo_origen'];
			$alerta_correo_copia = $concluido[0]['alerta_correo_copia'];
			$alerta_tiempo_dia = $concluido[0]['alerta_tiempo_dia'];
			$alerta_mensaje = str_replace("%1", $alerta_tiempo_dia,$concluido[0]['alerta_mensaje']);
			if($alerta_estado == '1'){
						
				foreach ($resultado as $key => $value) {
					
					$tram_fec_resp = $value['tram_fec_resp'];
					$td_descripcion = $value['td_descripcion'];
					$num_doc = $value['tram_nro_doc'];
					$fecha_registro = date("d-m-Y", strtotime($value['tram_fec_reg']));	
					$fecha_doc = date("d-m-Y", strtotime($value['tram_fec_doc']));	
					$fecha_resp = date("d-m-Y", strtotime($value['tram_fec_resp']));	
					$remitente = $value['NombreRemitente'];
					$destinatario = $value['NombreDestinatario'];
					$asunto = $value['tram_asunto'];
					$estado = $value['tram_estado'];
					$correo = utf8_encode($value['seg_correo']);
					$correo_copia = utf8_encode($value['seg_correo_copia']);
					
					$fecha_respuesta = date("Y-m-d", strtotime($tram_fec_resp));								
					$fecha_hoy = date("Y-m-d");
										
					$dias_diferencia = (strtotime($value['tram_fec_resp'])-strtotime($fecha_hoy))/86400; 
											
					if($dias_diferencia <= $alerta_tiempo_dia && $dias_diferencia >=0 ) {
						
						$log_descripcion = 'Urgente';
						$log_mensaje = 'Se procede con el envio';
						$log_fecha = date("Y-m-d H:i:s");
						$log_estado = '0';
						$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);
						
						$my_De = $alerta_correo_origen;
						$my_Para = $correo;
						
						if($correo_copia == '' AND $alerta_correo_copia <> '' ){							
							$my_Bcc = $alerta_correo_copia;
						}else{							
							if($correo_copia <> '' AND $alerta_correo_copia <> '' ){
								$my_Bcc = $alerta_correo_copia.','.$correo_copia;
							}else{								
								if($correo_copia <> '' AND $alerta_correo_copia == '' ){
									$my_Bcc = $correo_copia;
								}
							}						
						}
						
						// $my_Bcc = $alerta_correo_copia;
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
									          <p><font face='Arial' size='3' color='#555555'><strong>Documento:</strong>".$td_descripcion." - ".$num_doc."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Fecha Registro:</strong>  ".$fecha_registro."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Fecha límite de respuesta:</strong> ".$fecha_resp."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Remitente:</strong> ".$remitente."</p>
									          <p><font face='Arial' size='3' color='#555555'><strong>Asunto:</strong> ".$asunto."</p>									          
									          <p></p>
									          <p><font face='Arial' size='3' color='#555555'>Saludos.</p></td>
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
						$mail->setSMTPParams('mail01.peruvian.pe', 25, 'mail01.peruvian.pe', false, 'hugo.salcedo@peruvian.pe', 'peruvian2825');	
						$mail->setBcc($my_Bcc);
						$mail->setSubject($my_Asunto);
						$mail->setPriority('high');				
						$mail->setHTML($my_Msg);
						$result  = $mail->send(array($my_Para), 'smtp');							
						$log_descripcion = 'Urgente';
						$log_mensaje = 'Se envió el Correo correctamente';
						$log_fecha = date("Y-m-d H:i:s");
						$log_estado = '1';
						$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);			
					}				
				}
			}	
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}

	public function recibido_automatico(){
		try{
						
			$Seguimiento = new seguimiento_model();
											
			$resultado = $Seguimiento->RecibidoAutomatico();				
			
			$recibido = $Seguimiento->ConcluidoTable('5');
			$alerta_estado = $recibido[0]['alerta_estado'];			
			$alerta_tiempo_dia = $recibido[0]['alerta_tiempo_dia'];
			if($alerta_estado == '1'){			
				foreach ($resultado as $key => $value) {
					$id = $value['tramseg_id'];
					
					$fecha_registro = date("d-m-Y", strtotime($value['tram_estado_fecha']));
					$fecha_registro = date("d-m-Y", strtotime("+1 day", strtotime($fecha_registro)));	
					
					$fecha_resp = date("d-m-Y", strtotime($value['tram_fec_resp']));
					
					$fecha_hoy = date("Y-m-d");
					$hora_recibido = date("H:i:s");
					$usu_recibido = 'rb';				
					// **** Inicio Conteo dia sin SABADO ni DOMINGO ****
					$datestart= strtotime($fecha_registro);
					
					$datesuma = 15 * 86400;
					$diasemana = date('N',$datestart);
					
					$totaldias = $diasemana+$alerta_tiempo_dia;
 					
					$findesemana = intval( $totaldias/5) *2 ;
 					
					$diasabado = $totaldias % 5 ;
					
					if ($diasabado==6){
						$findesemana++;
					} 
					 if ($diasabado==0){					 						
						$findesemana=$findesemana-2;											
					} 
 					
					$total = (($alerta_tiempo_dia+$findesemana) * 86400)+$datestart ;					
					$fecha_recibidoAut = date('Y-m-d', $total);
					// **** Fin Conteo dia sin SABADO ni DOMINGO ****
									
					if 	($fecha_recibidoAut == $fecha_hoy) {
							$log_descripcion = 'Recibido';
							$log_mensaje = 'Recibido Automatico';
							$log_fecha = date("Y-m-d H:i:s");
							$log_estado = '1';
							
							$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);														
					
							$SeguimientoConcluido = $Seguimiento->SeguimientoRecibido($id,$fecha_hoy,$hora_recibido,$usu_recibido);							
					}															
				}
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}	
	
	public function concluido_automatico(){
		try{
						
			$Seguimiento = new seguimiento_model();
											
			$resultado = $Seguimiento->ConcluidoAutomatico();				
			
			$concluido = $Seguimiento->ConcluidoTable('3');
			$alerta_estado = $concluido[0]['alerta_estado'];			
			$alerta_tiempo_dia = $concluido[0]['alerta_tiempo_dia'];
			if($alerta_estado == '1'){			
				foreach ($resultado as $key => $value) {
					$id = $value['tramseg_id'];
					$fecha_registro = date("d-m-Y", strtotime($value['tram_estado_fecha']));	
					$fecha_registro = date("d-m-Y", strtotime("+1 day", strtotime($fecha_registro)));	
					$fecha_resp = date("d-m-Y", strtotime($value['tram_fec_resp']));
						
					$prioridad = $value['tram_prioridad'];		
					$fecha_hoy = date("Y-m-d");
					$hora_concluido = date("H:i:s");
					$usu_concluido = 'rb';				
					
					// **** Inicio Conteo dia sin SABADO ni DOMINGO ****
					$datestart= strtotime($fecha_registro);
					
					$datesuma = 15 * 86400;
					$diasemana = date('N',$datestart);
					
					$totaldias = $diasemana+$alerta_tiempo_dia;
 					
					$findesemana = intval( $totaldias/5) *2 ;
 					
					$diasabado = $totaldias % 5 ;
					
					if ($diasabado==6){
						$findesemana++;
					} 
					 if ($diasabado==0){					 						
						$findesemana=$findesemana-2;							 									
					} 
 					
					$total = (($alerta_tiempo_dia+$findesemana) * 86400)+$datestart ;
					$fecha_concluidoAut = date('Y-m-d', $total);					
					// **** Fin Conteo dia sin SABADO ni DOMINGO ****
					
					if($prioridad == 'U'){							
						if 	($fecha_resp < $fecha_hoy && $fecha_concluidoAut == $fecha_hoy) {
							
							$log_descripcion = 'Concluido';
							$log_mensaje = 'Se procede con el envio, prioridad urgente';
							$log_fecha = date("Y-m-d H:i:s");
							$log_estado = '0';
							
							$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);														
					
							$SeguimientoConcluido = $Seguimiento->SeguimientoConcluido($id,$fecha_hoy,$hora_concluido,$usu_concluido);
							
							$log_descripcion = 'Concluido';
							$log_mensaje = 'Se envió el Correo correctamente, prioridad urgente';
							$log_fecha = date("Y-m-d H:i:s");
							$log_estado = '1';
							$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);	
						
						}
					}else{
						if 	($fecha_concluidoAut == $fecha_hoy) {
								
							$log_descripcion = 'Concluido Automatico';
							$log_mensaje = 'Se procede con el envio, prioridad normal';
							$log_fecha = date("Y-m-d H:i:s");
							$log_estado = '0';
							
							$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);	
							
							$SeguimientoConcluido = $Seguimiento->SeguimientoConcluido($id,$fecha_hoy,$hora_concluido,$usu_concluido);									
							
							$log_descripcion = 'Concluido Automatico';
							$log_mensaje = 'Se envió el Correo correctamente, prioridad normal';
							$log_fecha = date("Y-m-d H:i:s");
							$log_estado = '1';
							$Seguimiento->InsertLog($log_descripcion,$log_mensaje,$log_fecha,$log_estado);	
						}	
					}
															
				}
			}
		}catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');			
		}	
	}		
}