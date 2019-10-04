<?php 

require_once("app_session.php");


?>
<html>
<head>
	<link href="tuua/admin/style/estilos.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
		
		function enviarCambio()
		{
			var passw,newpassw,newpassw2;
			
			passw=document.frm.txtpass.value;
			newpassw=document.frm.txtnewpass.value;
			newpassw2=document.frm.txtnewpassw.value;
			
			var previousInnerHTML = new String();                      
			previousInnerHTML = previousInnerHTML.concat("");                
			document.getElementById('div_error').innerHTML = previousInnerHTML;				

			if(newpassw==newpassw2)
			{
				frm.submit();
			}
			else
			{
				var previousInnerHTML = new String();                      
				previousInnerHTML = previousInnerHTML.concat("Datos ingresados incorrectamente");                
				document.getElementById('div_error').innerHTML = previousInnerHTML;								
			}
			  
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
            <p><div id="div_error" style="border-color:#F00"></div></p>
            <p>&nbsp;</p>
            <form name="frm" id="frm" method="post" action="app_cambio_pass.php">
                <table width="283" height="145" border="0" cellpadding="0" cellspacing="0" class="tabla_borde">
                    <tr>
                        <td height="20" colspan="3" align="center" class="negrita" style="border:0px; borde:#F60; background-color:#F60; color: #FFF; font-size: 14px;">Cambiar Contraseña</td>
                    </tr>
                    <tr bordercolor="#FFFFFF">
                        <td width="10" height="29" class="normal">&nbsp;</td>
                        <td width="119" class="normal">Contraseña actual</td>
                        <td width="154" class="normal"><label>
                          <input name="txtpass" type="password" class="normal" id="txtpass" >
                      </label></td>
                  </tr>
                    <tr bordercolor="#FFFFFF">
                      <td height="27" class="normal">&nbsp;</td>
                      <td height="27" class="normal">Nueva contraseña</td>
                      <td class="normal"><label>
                        <input name="txtnewpass" type="password" class="normal" id="txtnewpass">
                      </label></td>
                    </tr>
                    <tr bordercolor="#FFFFFF">
                        <td height="27" class="normal">&nbsp;</td>
                        <td height="27" class="normal">Repita contraseña</td>
                <td class="normal"><label>
                  <input name="txtnewpassw" type="password" class="normal" id="txtnewpassw">
                </label></td>
                  </tr>
                    <tr bordercolor="#FFFFFF">
                        <td height="32" colspan="3" class="normal"><label> </label>
                                <div align="center">
                                    <input name="button" type="button" class="button" id="button" onClick="enviarCambio();" value="Cambiar Password">
                      </div></td>
                    </tr>
</table>
          </form>
            <p class="resultado3"><?php 
			if ($_GET['app']=='error')
			{
				echo "<strong>Usuario o Clave incorrecta....<strong>";
			}
			
			?>	</p>
            <p>&nbsp;</p>
        </div></td>
    </tr>
    <tr>
        <td><?php include "app_pie.php"; ?></td>
    </tr>
</table>
</body>
</html>
