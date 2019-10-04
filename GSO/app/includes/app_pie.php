<?php 
$nom = "";
$perfil = "";

if (isset($_SESSION["ck_usuario_ini"])) {
	$nom = "Usuario: " . $_SESSION['ck_usuario_nom'] . " [" . $_SERVER["REMOTE_ADDR"] . "]";
	$perfil = "Perfil: " . $_SESSION['ck_usuario_per'];
}1
?>
<table width="1024" border="0" cellpadding="0" cellspacing="0" align="center">
<tr class="resultado" height="22px">
        <td width="32%" bgcolor="#FF6633" class="normal_blanco_12"><?php echo $nom ?></td>
      <td width="49%" align="center" bgcolor="#FF6633" class="normal_blanco_12" >Peruvian Air Line S.A. &copy; Derechos Reservados 2013 </td>
    <td width="19%" bgcolor="#FF6633" class="normal_blanco_12"><?php echo $perfil ?></td>
  </tr>
</table>
