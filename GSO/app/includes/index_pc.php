<?php 
session_start();
global $para_inicio;

if( isset($_SESSION['usuario_ini']) and strlen($_SESSION['usuario_ini'])>0 )
{
	header("location:app_main.php?app=menu");
	exit;
}
?>

<html>
<head>
	<link href="style/estilos.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
		function foco()
		{
			document.all.frame.focus();	
		}
	</script>
</head>
<body onLoad="return foco();">
<table class="tabla_principal" cellpadding="0" cellspacing="0" align="center" width="841">
<tr>
        <td>
        <div align="center"><span><img src="<?php echo $url_printer; ?>img/banner.jpg"></span></div>
        
        </td>
    </tr>
    <tr>
        <th nowrap><div align="center" class="titular">
            <p>&nbsp;</p>
            <p class="subtitulo_rojo">Intranet Peruvian Airlines</p>
          
          <iframe id="frame" src="https://sslpal.peruvianairlines.pe/login_intranet_index.php" width="600" height="150" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" ></iframe>
          
        <p class="resultado3"><?php 
			if ($_GET['app']=='error')
			{
				echo "<strong>Usuario o Clave incorrecta....<strong>";
			}
			
			?>	</p>
            <p>&nbsp;</p>
        </div></th>
  </tr>
    <tr>
        <td><?php include "app_pie.php"; ?></td>
    </tr>
</table>
</body>
</html>
