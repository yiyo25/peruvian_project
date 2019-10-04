<?php  
class EnviarTuaCORPAC extends Model{
	private $database = DB_NAME;

	public function __construct() {
		parent::__construct($this->database);
	}
	function ReprocesarCORPAC($idTuuaFile){
	//echo $idTuuaFile;return;
	
		//$da=new modeloTuua_application();
		$sql="SELECT * FROM tuuaCabeceraFile WHERE idFileTuua=:idFileTuua";
		$rsXML = $this->executeQuery( $sql,array("idFileTuua"=>$idTuuaFile) );
		//$rsXML=$da->ListarDatos2($sql);
		
		if(count($rsXML)>0)
		{

			for($i=0;$i<count($rsXML);$i=$i+1)
			{	

				$idFile = $rsXML[$i]["idFileTuua"];
				
				
				$fechavuelo					=		$rsXML[$i]["fecVueloTip"];
				$nroVuelo					=		$rsXML[$i]["nroVuelo"];
				
				$vueloOrigen				=		$rsXML[$i]["aeroEmbarque"];
				$nroPasajeros				=		$rsXML[$i]["cantLineasDetalle"];
				$horaVuelo					=		$rsXML[$i]["horaCierreDespegue"];
				$horaDespegue				=		substr($horaVuelo,0,2) . ":" . substr($horaVuelo,2,4);
				$horaCierreDespegue			=		$rsXML[$i]["horaCierreDespegue"];
				$idXMLFile					=		$rsXML[$i]["IdManifiesto"];
			
		$arrayFechaVuelo=explode("/",$fechavuelo);
		$nombreArchivoTuuaCORPAC= $arrayFechaVuelo[0].$arrayFechaVuelo[1] . substr($arrayFechaVuelo[2],-2) . "PE" .substr($nroVuelo, 2, 4) . $origen . ".xml";
		
		
				$sql="select * from tuuaPasajerosFile where idFileTuua=:idFileTuua and estado=:estado";
				$rsPasajero = $this->executeQuery( $sql,array("idFileTuua"=>$idFile,"estado"=>1) );
				//$rsPasajero=$da->ListarDatos2($sql);
				$countPasajeros=count($rsPasajero);
						   
				$xmlCuerpo="";
				$nroPasajeros=0;
				
				for($j=0;$j<count($rsPasajero);$j=$j+1)
				{
			
					$apellidoPax			=	$rsPasajero[$j]["apellidoPax"];
					$nombrePax				=	$rsPasajero[$j]["nombrePax"];
					$tipoPax				=	$rsPasajero[$j]["tipoPax"];
					$foidPax				=	$rsPasajero[$j]["foidPax"];
					$nroPaxFFrecuente		=	$rsPasajero[$j]["nroFrecPax"];
					$destinoPax				=	$rsPasajero[$j]["destinoPax"];
					$clasePax				=	$rsPasajero[$j]["clasePax"];
					$nroTicketPax			=	$rsPasajero[$j]["nroTicketPax"];					
					$nroCuponPax			=	$rsPasajero[$j]["nroCuponPax"];		
					$nroReferenciaPax		=	$rsPasajero[$j]["nroReferencia"];		
					$nroAsientoPax			=	$rsPasajero[$j]["nroAsientoPax"];	
					$destinoPax				=	$rsPasajero[$j]["destinoPax"];	
					
					$categoriaPax			=	$rsPasajero[$j]["categoria_Pax"];	
			
					$foidPaxXML=$this->buscaFoidCORPAC($foidPax);	
					$valorInfante="False";
					if($nroAsientoPax == "") $nroAsientoPax = "0";
					
			// ----------------------------VERIFICAR DIGITOS DE PASAV_BOARDING----------------------------
					//if(strlen($nroReferenciaPax)==3) $nroReferenciaPax = substr($nroReferenciaPax,0,3);		
					
					$pasab_nombre=$apellidoPax."/".$nombrePax;
			
			// -------------VERIFICAR SI SON PASAJEROS DE OTRA LINEA AERIA-------------
				if(strlen(trim(str_replace(" ","",$nroTicketPax)))==0) $nroTicketPax = $rsPasajero[$j]["idItensPax"];		
			
				if($categoriaPax!="T"){
			
					$xmlCuerpo=$xmlCuerpo."
					  <Pax>
						 <PASAV_TICKET>".$nroTicketPax."</PASAV_TICKET>
						 <PASAV_NOMBRE>". substr($apellidoPax."/".$nombrePax,0,19) . "</PASAV_NOMBRE>
						 <PASAV_BOARDING>".$nroReferenciaPax."</PASAV_BOARDING>
						 <PASAV_SITE_NUMBER>".$nroAsientoPax."</PASAV_SITE_NUMBER>
						 <PASAV_FOID>".$foidPaxXML."</PASAV_FOID>
						 <PASAB_ESINFANTE>".$tipoPax."</PASAB_ESINFANTE>
						 <PASAB_DESTINO>".$destinoPax."</PASAB_DESTINO>					  
					  </Pax>";
			 
					  $nroPasajeros++;
				  }
				}
				
				  
				$xmlCabecera = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
						<Manifiesto>
						<IdManifiesto>".$idXMLFile."</IdManifiesto>
						<Usuario>user04peruv</Usuario>						
						<Vuelo>".$nroVuelo."</Vuelo>						
						<Fecha>".$fechavuelo." 00:00</Fecha>
						<Origen>".$vueloOrigen."</Origen>						
						<Es_nacional>1</Es_nacional>						
						<Pasajeros_Salida>".$nroPasajeros."</Pasajeros_Salida>
						<ListaPax>";
				
			
				$xmlPie = "</ListaPax></Manifiesto>";
		
				$xmlFile=$xmlCabecera.$xmlCuerpo.$xmlPie;
				
	
	
				if($_SERVER['REMOTE_ADDR']=="172.16.1.54"){
				//echo "<pre>";	
				//echo $xmlFile;
				//echo "</pre>";
				//die();
				
				}
				
				 
				$this->enviaXMLCORPAC($xmlFile,$idFile,$nombreArchivoTuuaCORPAC);
				return;
			
			}

		}	
	
	}
	function insertarCabecera($fecha_vuelo,$nro_vuelo,$origen,$hora_despegue,$hora_cierra_despegue,$hora_llegada_destino,$matricula_avion){
			//$da=new Datos();
			
			if(strlen($nro_vuelo)==3){
				$nro_vuelo="P90".$nro_vuelo;
			}
			else{
				$nro_vuelo="P9".$nro_vuelo;
			}
			
			//mktime(hora,minuto,segundoi,mes,dia,anio);
			$mes1=explode("-",$fecha_vuelo);
			$mes=$mes1[1];
			
			$date_fly=$mes1[2].$this->verMesPago($mes);
			$fecha_vuelo=date("d/m/Y",strtotime($fecha_vuelo));
			
			
				
			$id_manifiesto=$this->ObtenerIDManifiesto();
			$sql="INSERT INTO tuuaCabeceraFile (nroVuelo,fecVueloTip,fechaVuelo,aeroEmbarque,horaCierrePuerta,horaCierreDespegue,horaLlegadaDestino,matriculaAvion,Estado,IdManifiesto) VALUES 
			('$nro_vuelo','$fecha_vuelo','$date_fly','$origen','$hora_despegue','$hora_cierra_despegue','$hora_llegada_destino','$matricula_avion',2,$id_manifiesto)";
			
			$id_manifiesto=$id_manifiesto+1;
			$this->Ejecutar($sql);
			$this->ActualizarIDManifiesto($id_manifiesto);
			return $sql;
			
	}
	function verMesPago($mes) {
	
		$month = array( '01'=> 'JAN','02'=>"FEB",'03'=>"MAR",'04'=>"APR",'05'=>"MAY",'06'=>"JUN",'07'=>"JUL",'08'=>"AUG",'09'=>"SEP",'10'=>"OCT",'11'=>"NOV",'12'=>"DEC");	
		$valorMes=$month[$mes];
		return $valorMes;
	
	}
	function ActualizarIDManifiesto($id_manifiesto){
	
		$da=new Datos();
		$sql="UPDATE  tuuaAutogen set valor=$id_manifiesto WHERE tabla='ManiProduc'";
			
		$da->EjecutarDatos($sql);	
		return;
		
	}
	
	
	function ObtenerIDManifiesto(){
	
		$da=new Datos();
		$sql="SELECT * FROM `tuuaAutogen` WHERE tabla='ManiProduc'";
		$listado=$da->ListarDatos2($sql);
		$id_manifiesto_temp=$listado[0]["valor"];	
		return $id_manifiesto_temp;
		
	}
	
	
	function buscaFoidCORPAC($foid_pasa){
	
				$foid_pasa=trim($foid_pasa);
		
		if(strlen($foid_pasa)==2){

			if($foid_pasa=="PP"){
				$foid="PP00000000";			
			}
			else{
				$foid="DN00000000";
			}
		
		
			
		}
		else if($foid_pasa==""){
		
			$foid="DN00000000";
		
		}
		else{
		
			$longitud=strlen($foid_pasa);
			$tipo_foid=substr($foid_pasa,0,2);
			
			if($tipo_foid=="NI"){
			
				$numero_foid=substr($foid_pasa,2,$longitud);
				$foid="NI".$numero_foid;
			
			}
			else if($tipo_foid=="PP"){
			
				$numero_foid=substr($foid_pasa,2,$longitud);
				$foid="PP".$numero_foid;
				
			}
			else{
				$numero_foid=substr($foid_pasa,2,$longitud);
				$foid="DN".$numero_foid;
			}
					
		}
		
		
		return $foid;
	}
	
	function func_destinosEmail(){
		$dap=new DatosPasarela();
		$sql="SELECT * FROM parametro WHERE parametro='email_tuua_cuz'";
		$rs=$dap->ListarDatos2Pasarela($sql);
		$emailEnvio=$rs[0]["valor"];
		return $emailEnvio;
	}
	
	function func_destinosEmail_Embarque($embarque)
	{
		switch ($embarque) {
    		case "CUZ": $emailEmbarque="email_tuua_cuz"; break;
    		default: $emailEmbarque="email_rep_ventas_pais";
			}
	 		
		$dap=new DatosPasarela();
		$sql="SELECT * FROM parametro WHERE parametro='".$emailEmbarque."'";
		$rs=$dap->ListarDatos2Pasarela($sql);
		$rs=func_select($sql);
		$emailEnvio=$rs[0]["valor"];

		return $emailEnvio;
	}
	
	function func_Graba_Log($nomArchivo,$estProceso,$vuelo,$fecha,$totalPax,$obs,$id_file) { // update insert delete
		//$da=new Datos();
		//$sql="INSERT INTO tuuaLogFile (nombreArchivo,estadoProceso,nroVuelo,fechaVuelo,totalPax,obs,id_file) VALUES( '".$nomArchivo."','".$estProceso."','".$vuelo."','".$fecha."','".$totalPax."','".$obs."','".$id_file."')";
		$values = array("nombreArchivo"=>$nomArchivo,"estadoProceso"=>$estProceso,"nroVuelo"=>$vuelo,"fechaVuelo"=>$fecha,"totalPax"=>$totalPax,"obs"=>$obs,"id_file"=>$id_file);
		$sql = $this->insertData("tuuaLogFile",$values);
		//$da->EjecutarDatos($sql);
		return;
	}
				
	function func_ErrorEmailDetalle($nomArchivo,$estProceso,$vuelo,$fecha,$totalPax,$obs){
		require_once(APP . DS . 'libreria' . DS . 'class.phpmailer.php');
		$ws_Aeropuerto="";			
		if( strpos($nomArchivo, "CUZ")>0  )
			$ws_Aeropuerto="Corpac ";

         /* EMAIL SETTING */
     $mail = new PHPMailer();
     $mail->IsSMTP(); // send via SMTP
     //$mail->SMTPDebug = 3; //se descomenta en caso quieren ver el mensaje detallado de phpmailer al enviar correo
     $mail->Host = 'mail.peruvian.pe';
     $mail->Port = 25;
     $mail->SMTPSecure = 'tls';
     $mail->SMTPAuth = true; // turn on SMTP authentication
     $mail->Username = "ventasweb@peruvian.pe"; // SMTP username
     $mail->Password = 'ven8065x';
     $mail->IsHTML(true);
     $de = "ventasweb@peruvian.pe";
     $mail->From = $de;
     $mail->FromName = "<tuua@peruvian.pe>";
 
     $mail->Subject = ($ws_Aeropuerto . 'ERROR - EXTRACCION DE PASAJEROS');
     $path_error_file = SERVER_PUBLIC.'img/msn_error_file.html';
		//$body = file_get_contents(APP.DS.'modulo/tuua_application/clases/msn_error_file.html');
	 $body = file_get_contents($path_error_file);

	 $body = str_replace('--Titulo--', "Error Procesando Archivo", $body);
	 $body = str_replace('--Mensaje--', "Archivo :" . $nomArchivo . "<br>Estado :" . $estProceso. "<br>Vuelo" .$vuelo. "<br>Fecha :" .$fecha. "<br>Total :" .$totalPax . "<br><b><font color='#0000CC'> Observacion :" .$obs ."</font></b>", $body);
	

     $mail->Body = $body;
     $path_fondo_web = SERVER_PUBLIC.'img/fondo_web.jpg';
		//$mail->addEmbeddedImage(APP.DS.'modulo/tuua_application/clases/fondo_web.jpg',"fondo_web.jpg");
	 $mail->addEmbeddedImage($path_fondo_web,"fondo_web.jpg");
 
     $email_destinos = explode(",", $this -> func_destinosEmail()); 
     //print_r($email_destinos);
     foreach ($email_destinos as $key => $to) {
         $mail->addAddress($to);
     }
     if(!$mail->send()) 
     {
     echo "Mailer Error: " . $mail->ErrorInfo;
     }
	/*	require_once('mail/htmlMimeMail5.php');
		$mail = new htmlMimeMail5();

		$ws_Aeropuerto="";			
		if( strpos($nomArchivo, "CUZ")>0  )
			$ws_Aeropuerto="Corpac ";
		
		$mail->setFrom('<tuua@peruvian.pe>');
		$mail->setSMTPParams('mail.peruvian.pe', 25, 'mail.peruvian.pe', false, 'ventasweb@peruvian.pe', 'ven8065x');
		$mail->setSubject($ws_Aeropuerto . 'ERROR - EXTRACCION DE PASAJEROS');
		$mail->setPriority('high');
		
		$body = file_get_contents('../clases/msn_error_file.html');
		$body = str_replace('--Titulo--', "Error Procesando Archivo", $body);
		$body = str_replace('--Mensaje--', "Archivo :" . $nomArchivo . "<br>Estado :" . $estProceso. "<br>Vuelo" .$vuelo. "<br>Fecha :" .$fecha. "<br>Total :" .$totalPax . "<br><b><font color='#0000CC'> Observacion :" .$obs ."</font></b>", $body);
		
		$mail->setHTML($body);
		
		$mail->setReceipt('ventasweb@peruvian.pe');
		$mail->addEmbeddedImage(new fileEmbeddedImage('../clases/fondo_web.jpg'));
		
		$email_destinos=split(",",$this->func_destinosEmail());
		
		$result  = $mail->send($email_destinos,'smtp');
		
		if($result) 
		{
			//guarda BD
		}*/
	} 
	 
			
	function func_EmailXMLCOMPLETC($nomArchivo,$vuelo,$fecha,$rptWS,$horacierrepuerta,$horaCierreDespegue) {
		require_once(APP . DS . 'libreria' . DS . 'class.phpmailer.php');
        /* EMAIL SETTING */
    $mail = new PHPMailer();
    $mail->IsSMTP(); // send via SMTP
    //$mail->SMTPDebug = 3; //se descomenta en caso quieren ver el mensaje detallado de phpmailer al enviar correo
    $mail->Host = 'mail.peruvian.pe';
    $mail->Port = 25;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->Username = "ventasweb@peruvian.pe"; // SMTP username
    $mail->Password = 'ven8065x';
    $mail->IsHTML(true);
    $de = "ventasweb@peruvian.pe";
    $mail->From = $de;
    $mail->FromName = "<tuua@peruvian.pe>";

	$ws_Aeropuerto="Corpac ";

    $mail->Subject = ($ws_Aeropuerto . 'Envio XML Completado Vuelo: '. $vuelo . ' .:::. ' . $fecha);
    $path_error_file = SERVER_PUBLIC.'img/msn_error_file.html';
		//$body = file_get_contents(APP.DS.'modulo/tuua_application/clases/msn_error_file.html');
	$body = file_get_contents($path_error_file);
	$body = str_replace('--Titulo--', 'Envio XML Completado Vuelo : '. $vuelo . ' .:::. ' . $fecha, $body);
		
	$msgHtml="<table width=450 border=0 cellspacing=0 cellpadding=0><tr><td width=160>Nombre Archivo</td><td width=10>:</td><td width=286>" . $nomArchivo . "</td></tr><tr><td>Nro Vuelo</td><td>:</td><td>" .$vuelo. "</td></tr><tr><td>Fecha Vuelo</td><td>:</td><td>" .$fecha. "</td></tr><tr><td>Hora Cierre Puerta</td><td>&nbsp;</td><td>" .$horacierrepuerta. "</td></tr><tr><td>Hora Cierre Despegue</td><td>&nbsp;</td><td>" .$horaCierreDespegue. "</td></tr><tr><td>Respuesta WS</td><td>:</td><td>". $rptWS ."</td></tr></table>";
	$body = str_replace('--Mensaje--', $msgHtml, $body);

    $mail->Body = $body;
    $path_fondo_web = SERVER_PUBLIC.'img/fondo_web.jpg';
		//$mail->addEmbeddedImage(APP.DS.'modulo/tuua_application/clases/fondo_web.jpg',"fondo_web.jpg");
	$mail->addEmbeddedImage($path_fondo_web,"fondo_web.jpg");
    $embarque = substr($nomArchivo, -3);

    $email_destinos = explode(",", $this -> func_destinosEmail()); 
    //print_r($email_destinos);
    foreach ($email_destinos as $key => $to) {
        $mail->addAddress($to);
    }
    if(!$mail->send()) 
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
	}
	
	/*	require_once('mail/htmlMimeMail5.php');
		$mail = new htmlMimeMail5();
		
		$mail->setFrom('<tuua@peruvian.pe>');
		$mail->setSMTPParams('mail.peruvian.pe', 25, 'mail.peruvian.pe', false, 'ventasweb@peruvian.pe', 'ven8065x');
		
		$ws_Aeropuerto="Corpac ";			
		
	//	if( strpos($nomArchivo, "CUZ")>0  )
	//		$ws_Aeropuerto="Corpac ";	
	
	//	if( strpos($nomArchivo, "AQP")>0 || strpos($nomArchivo, "TCQ")>0   )
	//	$ws_Aeropuerto="AAP ";
		
		$mail->setSubject($ws_Aeropuerto . 'Envio XML Completado Vuelo: '. $vuelo . ' .:::. ' . $fecha );
		$mail->setPriority('high');
		//$mail->setText('Sample text');
		$body = file_get_contents('../clases/msn_error_file.html');
		$body = str_replace('--Titulo--', 'Envio XML Completado Vuelo : '. $vuelo . ' .:::. ' . $fecha, $body);
		
		
		$msgHtml="<table width=450 border=0 cellspacing=0 cellpadding=0><tr><td width=160>Nombre Archivo</td><td width=10>:</td><td width=286>" . $nomArchivo . "</td></tr><tr><td>Nro Vuelo</td><td>:</td><td>" .$vuelo. "</td></tr><tr><td>Fecha Vuelo</td><td>:</td><td>" .$fecha. "</td></tr><tr><td>Hora Cierre Puerta</td><td>&nbsp;</td><td>" .$horacierrepuerta. "</td></tr><tr><td>Hora Cierre Despegue</td><td>&nbsp;</td><td>" .$horaCierreDespegue. "</td></tr><tr><td>Respuesta WS</td><td>:</td><td>". $rptWS ."</td></tr></table>";
		$body = str_replace('--Mensaje--', $msgHtml, $body);
		
		$mail->setHTML($body);
		
		$mail->setReceipt('ventasweb@peruvian.pe');
		$mail->addEmbeddedImage(new fileEmbeddedImage('../clases/fondo_web.jpg'));
	
		$email_destinos=split(",",$this->func_destinosEmail());
	
		$result  = $mail->send($email_destinos,'smtp');
		
		if($result) 
		{
			//guarda BD
		}*/
	}
	

	function enviaXMLCORPAC($xml,$idFileTuuacabecera,$nombreArchivoTuua){
		try {
			//echo $xml;
			//echo "<br><h1>================= SEPARADOR ============</h1>";
			//die("Fin");
			set_time_limit(60);	
			require_once (APP.DS.'libreria/lib/nusoap.php');
			//$da=new Datos();
			$sql="select * from tuuaCabeceraFile where idFileTuua=:idFileTuua";
			//echo $sql . "<br>";
			$rsError = $this->executeQuery( $sql,array("idFileTuua"=>$idFileTuuacabecera) );
			//$rsError=$da->ListarDatos2($sql);
			
						
			$nombreArchivo=$rsError[0]["nombreArchivo"].$rsError[0]["aeroEmbarque"];
			$nroVuelo=$rsError[0]["nroVuelo"];
			$fechavuelo=$rsError[0]["fecVueloTip"];
			$cantidadLineasDetallan=$rsError[0]["cantLineasDetalle"];

			$horacierrepuerta=$rsError[0]["horaCierrePuerta"];
			$horaCierreDespegue=$rsError[0]["horaCierreDespegue"];


			// -----------------------------------------------------------------------------------------------------
			// -----------------------------------------------------------------------------------------------------
			// ************* AMBIENTE DE TEST *************
			
			/*$valorEnvioTestProd="AMBIENTE DE TEST";
			//echo $valorEnvioTestProd . "<br>";
			$oSoapClient = new nusoap_client("http://190.41.107.180/service.asmx?WSDL", "WSDL");*/
			
			// ************* AMBIENTE DE PRODUCCION *************
			$valorEnvioTestProd="AMBIENTE DE PRODUCCION CORPAC";
			
			//$oSoapClient = new nusoap_client('http://190.223.39.233/uptuua.asmx?wsdl', "WSDL"); 	
			
            /* 12/01/2018 */
            /*-------------------------- Web Services que ya no utiliza Corpac -------------------------- */
            //$oSoapClient = new nusoap_client('http://190.102.140.105/uptuua.asmx?wsdl', "WSDL");
            /*-------------------------- Web Services nueva usada por Corpac -------------------------- */
            $oSoapClient = new nusoap_client('http://tuua.corpac.gob.pe/uptuua.asmx?wsdl', "WSDL");
            /* fin 12/01/2018 */
            
			if ($sError = $oSoapClient->getError()) 
			{ 
				echo "No se pudo realizar la operación [" . $sError . "]";  
				//$sql="UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";
				
				$values = array('Estado'=>6);
        		$where = array('idFileTuua'=>$idFileTuuacabecera);
        		$sql = $this->updateData("tuuaCabeceraFile", $values, $where);

				//$da->EjecutarDatos($sql);			
				
				$this->func_Graba_Log($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd."<br>" . $sError,$idFileTuuacabecera);
				$this->func_ErrorEmailDetalle($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd."<br>" . $sError);
				
				return;
			} 
			
			$this->func_Graba_Log($nombreArchivo,"2",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,"Generando XML : <br>".$valorEnvioTestProd."<br>" . $xml ,$idFileTuuacabecera);
			//$respuesta = $oSoapClient->call("EnvioManifiesto",array("binXML" => base64_encode($xml)));	
			//print_r(base64_encode($xml));
			//print_r($nombreArchivoTuua);
			$respuesta = $oSoapClient->call("UploadXML",
					array(
						"xmlParsed" => base64_encode($xml), 
						"nombreArchivo" => $nombreArchivoTuua, 
						"usuario" => "user04peruv", 
						"pass" => "pass4peruv4s"  
					));
					
			$this->func_Graba_Log($nombreArchivo,"3",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,"Enviando a webservices<br>".$valorEnvioTestProd,$idFileTuuacabecera);

			
			if ($oSoapClient->fault) { // Si 
				echo "Error fault : " . $oSoapClient->fault ; 
				//$sql="UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";
				
				$values = array('Estado'=>6);
        		$where = array('idFileTuua'=>$idFileTuuacabecera);
        		$sql = $this->updateData("tuuaCabeceraFile", $values, $where);

//				$da->EjecutarDatos($sql);
				
				$this->func_Graba_Log($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd . "<br><br>" . $sError,$idFileTuuacabecera);
				$this->func_ErrorEmailDetalle($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd . "<br><br>Error oSoapClient->fault" . $oSoapClient->fault);
			
				return;
			} else { // No 
				$sError = $oSoapClient->getError(); 
				 
				if ($sError) { // Si 			
					echo "Error  GetError :" . $oSoapClient->getError() . "<BR>";			
					//$sql="UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";
					//$da->EjecutarDatos($sql);

					$values = array('Estado'=>6);
					$where = array('idFileTuua'=>$idFileTuuacabecera);
					$sql = $this->updateData("tuuaCabeceraFile", $values, $where);
				
					$this->func_Graba_Log($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd . "<br><br>" . $sError,$idFileTuuacabecera);
					$this->func_ErrorEmailDetalle($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd . "<br><br>" .$sError);
							
					return;
				} 
			} 

			if( $respuesta["UploadXMLResult"] == 1 )
			{
				echo "Se insertaron ".$cantidadLineasDetallan. " Pax del Vuelo ".$nroVuelo;
				$valor_rpta=print_r($respuesta,true);
				
				//$sql="UPDATE tuuaCabeceraFile SET Estado=2 WHERE idFileTuua=$idFileTuuacabecera";
				//$da->ListarDatos2($sql);

				$values = array('Estado'=>2);
				$where = array('idFileTuua'=>$idFileTuuacabecera);
				$sql = $this->updateData("tuuaCabeceraFile", $values, $where);

				$this->func_Graba_Log($nombreArchivo,"4",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd . "<br>" .$valor_rpta,$idFileTuuacabecera);
				$this->func_EmailXMLCOMPLETC($nombreArchivo,$nroVuelo,$fechavuelo,$valorEnvioTestProd . "<br>" .$valor_rpta,$horacierrepuerta,$horaCierreDespegue);
				
			}
			else
			{		
					$valor_rpta=print_r($respuesta,true);
					
					echo '<br><font color=#990000>Error No se envio el manifiesto</font><br><br>';
													
					//$sql="UPDATE tuuaCabeceraFile SET Estado=6 WHERE idFileTuua=$idFileTuuacabecera";
					//$da->EjecutarDatos($sql);

					$values = array('Estado'=>6);
					$where = array('idFileTuua'=>$idFileTuuacabecera);
					$sql = $this->updateData("tuuaCabeceraFile", $values, $where);

					$this->func_Graba_Log($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd . "<br><br>" . $valor_rpta,$idFileTuuacabecera);
					$this->func_ErrorEmailDetalle($nombreArchivo,"5",$nroVuelo,$fechavuelo,$cantidadLineasDetallan,$valorEnvioTestProd . "<br><br>" .$valor_rpta);
							
					return;
			}
		}
		catch (Exception $x) {

           echo  $x;

        }

	}
	

}

?>

