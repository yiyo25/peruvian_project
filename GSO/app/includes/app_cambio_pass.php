<?php 
require_once("app_session.php");
require_once("lib/db_consultas.php");


$oUsr = new cUsuarios();
$user= $_SESSION['ck_usuario_ini'];
$pass=md5($_REQUEST["txtpass"]);
$newpass1=md5($_REQUEST["txtnewpass"]);
$newpass2=md5($_REQUEST["txtnewpassw"]);
$rp = $oUsr->validauser($user, $pass);

//if ($_SERVER["REMOTE_ADDR"] == "172.16.1.50") echo $_SESSION['ck_usuario_ini'] . ", " . $_REQUEST["txtnewpass"] ;

if ($rp>0) {
	$oUsr->user_cambiapass($user, $newpass1);
	$mensaje = $_SESSION['ck_usuario_ini'] . ", El cambio de su clave se realiz&oacute; con &eacute;xito..";
} else {
	$mensaje = "<br>Error al momento de cambiar clave <br><br> <a href='javascript:history.back();'>Atras</a>";	
}

?>

<html>
<head>
	<link href="style/estilos.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">		

		function enviarCambio()
		{
			var passw,newpassw,newpass2;
			
			passw=document.all.txtpass.value;
			newpassw=document.all.txtnewpass.value;
			newpass2=document.all.txtnewpass2.value;
						
			if(newpassw==newpassw2){ frm.submit();}
			  
		}

	</script>
</head>
<body>


<table class="tabla_principal" cellpadding="0" cellspacing="0" align="center" width="841">
<tr>
        <td><?php include "app_cabecera.php"; ?></td>
    </tr>
    <tr>
        <td><div align="center" class="titular">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="subtitulo_rojo"><?php echo $mensaje; ?> </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div></td>
    </tr>
    <tr>
        <td><?php include "app_pie.php"; ?></td>
    </tr>
</table>
</body>
</html>
