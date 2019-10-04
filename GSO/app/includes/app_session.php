<?php
session_start();
if( !isset($_SESSION["usuario_ini"]) ) 
{
	session_destroy();
	header("location: http://intranet.peruvian.pe/index.php?app=login");		
}
//echo $_COOKIE['ck_usuario_ini']; 
//if( !$_COOKIE['ck_usuario_ini'] ) header("location: http://intranet.peruvianairlines.pe/index.php?app=login");

?>