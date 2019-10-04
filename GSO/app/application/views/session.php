<?php
session_start();
if($_SESSION["ck_id_usuario"]==null){
	header("location: http://intranet.peruvian.pe/m");		
}
if($action=="out"){	
	session_destroy();
	header("location: http://intranet.peruvian.pe/m");
}
?>