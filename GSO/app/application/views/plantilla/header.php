<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<title>Peruvian - Intranet</title>
	<!--<link href="<?php echo base_url(); ?>css/estilos.css" rel="stylesheet" type="text/css" />-->
    <link href="<?php echo base_url(); ?>css/cabecera.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url(); ?>yuimenu/reset-fonts-grids.css" rel="stylesheet" type="text/css"/>	
	<link href="<?php echo base_url(); ?>yuimenu/menu.css" rel="stylesheet" type="text/css">
	<script src="<?php echo base_url(); ?>yuimenu/yahoo-dom-event.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>yuimenu/container_core.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>yuimenu/menu.js" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<header> </header>

    <?php //if(!isset($_SESSION["usuario"]) && $_SESSION["usuario"]==""){ header('location:https://dev.peruvian.pe/loginPeruvian/ES');} ?>
	