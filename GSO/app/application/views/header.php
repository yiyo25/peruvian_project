<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<title>Peruvian - Intranet</title>
	<link href="<?php echo base_url(); ?>css/estilos.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>yuimenu/reset-fonts-grids.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url(); ?>css/cabecera.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url(); ?>yuimenu/menu.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css">
	
	<script src="<?php echo base_url(); ?>js/jquery-1.9.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jqueryui.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>yuimenu/yahoo-dom-event.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>yuimenu/container_core.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>yuimenu/menu.js" type="text/javascript"></script>	
</head>
<body>
	<input id="url_abs" value="<?=base_url();?>" type="hidden"/>
	<header> <?php include("./includes/app_cabecera.php") ?></header>
	
	