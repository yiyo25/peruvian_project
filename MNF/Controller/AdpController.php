<?
require_once("../clases/EnviarTuaDAO.php");
require_once("../clases/EnviarTuaCORPAC.php");
require_once("../clases/EnviarTuaAAP.php");

if(strcmp($_REQUEST["flag"],"Reprocesar")==0){
		$etd=new EnviarTuaDAO();
	    $etc=new EnviarTuaCORPAC();
		$eta=new EnviarTuaAAP();
		switch ($_REQUEST["embarque"]) {
					case "CUZ": $etc->ReprocesarCORPAC($_REQUEST["id_file"]); break;
					case "PIU": $etd->Reprocesar($_REQUEST["id_file"]); break;
					case "IQT": $etd->Reprocesar($_REQUEST["id_file"]); break;
					case "PCL": $etd->Reprocesar($_REQUEST["id_file"]); break;
					case "TPP": $etd->Reprocesar($_REQUEST["id_file"]); break;
					case "AQP": $eta->ReprocesarAAP($_REQUEST["id_file"]); break;
					case "TCQ": $eta->ReprocesarAAP($_REQUEST["id_file"]); break;
					default: echo "No se puede Reprocesar este Manifiesto";       			 
					} 
		
		return;
}

if(strcmp($_REQUEST["flag"],"CrearManifiesto")==0){
		
		$etd=new EnviarTuaDAO();	
		
		$fecha_vuelo=$_REQUEST["fecha_vuelo"];
		$nro_vuelo=$_REQUEST["nro_vuelo"];
		$origen=$_REQUEST["origen"];
		$hora_despegue=$_REQUEST["hora_despegue"];
		$hora_cierra_despegue=$_REQUEST["hora_cierra_despegue"];
		$hora_llegada_destino=$_REQUEST["hora_llegada_destino"];
		$matricula_avion=$_REQUEST["matricula_avion"];
		$etd->insertarCabecera($fecha_vuelo,$nro_vuelo,$origen,$hora_despegue,$hora_cierra_despegue,$hora_llegada_destino,$matricula_avion);			
		return;
		
}

 
if(strcmp($_REQUEST["flag"],"ImportarPax")==0){
	
 	$etd=new EnviarTuaDAO();	
	
	$idFileTuua=$_REQUEST["idFileTuua"];
	$FechaUso=$_REQUEST["Fecha"];
	$LocOrigen=$_REQUEST["aeroEmbarque"];
	$LocDestino=$_REQUEST["LocDestino"];
	$NroVuelo=substr($_REQUEST["nroVuelo"], -4);
 
	$etd->importarPax($idFileTuua,$FechaUso,$LocOrigen,$LocDestino,(int)$NroVuelo);		
}

if(strcmp($_REQUEST["flag"],"EliminarManifiesto")==0){
	
	$etd=new EnviarTuaDAO();	
   $idFileTuua=$_REQUEST["idFileTuua"];
   $etd->EliminarManifiesto($idFileTuua);
}
if(strcmp($_REQUEST["flag"],"ConsultarManifiesto")==0){
	
	$etd=new EnviarTuaDAO();	
   $idFileTuua=$_REQUEST["idFileTuua"];
   echo $etd->ConsultarManifiesto($idFileTuua);
}
if(strcmp($_REQUEST["flag"],"ActualizarManifiesto")==0){
	
	$etd=new EnviarTuaDAO();	
	$idFileTuua=$_REQUEST["idFileTuua"];
	$hora_despegue=$_REQUEST["hora_despegue"];
	$hora_cierra_despegue=$_REQUEST["hora_cierra_despegue"];
	$hora_llegada_destino=$_REQUEST["hora_llegada_destino"];
	$matricula_avion=$_REQUEST["matricula_avion"];
	$params = array("hora_despegue"=>$hora_despegue,"hora_cierra_despegue"=>$hora_cierra_despegue,"hora_llegada_destino"=>$hora_llegada_destino,"matricula_avion"=>$matricula_avion);
	$etd->ActualizarManifiesto($idFileTuua,$params);
}
?>