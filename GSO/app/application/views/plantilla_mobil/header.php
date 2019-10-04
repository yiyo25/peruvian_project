<header>
    <div class="logo">
        <img src="<?php echo base_url(); ?>img/movil/peruvian.png" alt="Peruvian Airlines"/>
    </div> 
    <div class="more"> 
        <a href="#" id="menu-user" class="icono textoff">
            <span class="iconoHeader iuser"></span>
        </a>
    </div>
</header>
<div id="navigation_user" style="display:none;">
    <div class="infoUsuario">
    	<h1><?php echo $nombres;?></h1>
    </div>
    <ul class="menuUsuario">
        <h2>Usuario</h2>
        <li>
            <a href="#" onClick="cambiarContrasena();">Cambiar Contrase&ntilde;a</a>
        </li>
        <li>
            <a href="http://intranet.peruvian.pe/app/inicio/cerrarSesion">Cerrar Sesi&oacute;n</a>
        </li>
    </ul>
</div>
<script>
	$('#menu-user').sidr({
		  name	:	 	'sidr-user',
		  speed		:	300,
		  side		: 	'right',
		  source	: 	'#navigation_user',
		  renaming	:	false,
		  body		:	'body'
	});
	function cambiarContrasena(){		
		$(location).attr('href','http://intranet.peruvian.pe/app/inicio/viewcambiarContrasena');		
	}
</script>