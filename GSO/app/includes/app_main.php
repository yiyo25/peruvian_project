<?php 
//session_start();
include "app_session.php";
?>

<html>
<head>
<title>Peruvian - Intranet</title>
<link href="style/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="885" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla_principal">
<tr><td></td></tr>
<tr>
    <td height="339" align="center" class="subtitulo_rojo"><?php echo $_SESSION['ck_usuario_nom']; ?>, 1Bienvenido(a) al <br>
    Intranet de Peruvian Airlines</td></tr>
<tr><td><?php include "app_pie.php"; ?></td></tr></table>
</body>
</html>
