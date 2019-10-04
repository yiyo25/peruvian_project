<?php 
session_start();
require ("lib/db_consultas.php");

$oUsr = new cUsuarios();
$Id = $oUsr->get_session($_GET["idSession"]);
$oUsr->get_user($Id);


//if ($_SERVER["REMOTE_ADDR"] == "172.16.1.50") 


if($Id > 0)
{
	$_SESSION['usuario_ini'] = strtoupper($oUsr->valores->usuario);
	$_SESSION['ck_usuario_nom'] = $oUsr->valores->nombre . " " . $oUsr->valores->apellido;
	$_SESSION['ck_usuario_per'] = $oUsr->valores->nombre_perfil;
	$_SESSION['ck_usuario_perc'] = $oUsr->valores->id_perfil;
	$_SESSION['ck_id_usuario_ini'] = $oUsr->valores->idusuario;
	$_SESSION['ck_id_usuario'] = $oUsr->valores->idusuario;
	$_SESSION['ck_usuario_ini'] = $oUsr->valores->usuario;
	$_SESSION['ck_usuario_mob'] = $oUsr->mobile;
	
	if ($oUsr->mobile)
		header("location:m/main.php");
	else
		header("location:app_main.php?app=menu");
}
else
{
	header("location:http://intranet.peruvian.pe/");
}





?>