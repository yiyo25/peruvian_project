<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>SISTEMA TRAMITE DOCUMENTARIO</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="<?php echo URLPUBLIC;?>/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
		<link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/font-awesome.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/plantilla.css">
		<link rel="stylesheet" href="<?php echo URLPUBLIC;?>/css/peruvian.css">
		<link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/css/jquery-ui.css">
		<!--Estilos a revisar-->
		<link href="<?php echo URLPUBLIC;?>/css/Site_new.css?version=1.2" rel="stylesheet" type="text/css" />
		<link href="<?php echo URLPUBLIC;?>/css/bootstrap.css?version=1.2" rel="stylesheet" type="text/css" />
		<link type="text/css" rel="Stylesheet" href="<?php echo URLPUBLIC;?>/css/meanmenu.css?version=1.2" />
		<link href="<?php echo URLPUBLIC;?>/css/netStyles_new.css?version=1.2" rel="stylesheet" type="text/css" />
		
		<!-- <script src="<?php echo URLPUBLIC; ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>		 -->
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	</head>
	<body>	
		<form method="post" action="<?php echo URLLOGICA;?>login/" id="">
			<div class="backred">
				<div class="userLogin">
					<div class="formLogin">
						<div class="logo_ness_login"></div>
						<div class="row">
							<label for="usuario" class="control-label col-md-3 label_login" >USUARIO:</label>							
						</div>
						<div class="row">
							<input name="usuario" type="text" id="usuario" class="col-md-3 form-control"/>
						</div>
						<div class="row">
							<label for="password"  class="control-label col-md-3 label_login">CONTRASEÑA:</label>
						</div>
						<div class="row">
							<input name="password" type="password" id="password" class="form-control col-md-3" />
							<label class="control-label"><?php echo $this->Mensaje;?></label>
						</div>
						<div class="row">
							<div class="col-md-6">							
							<input type="submit" name="ingresar" value="<?php echo INGRESAR;?>" id="ingresar" class="btn boton_login btn-block" />
							</div>
							<div class="col-md-6">
								<input type="reset"  class="btn boton_login btn-block" value="<?php echo CANCELAR;?>"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>	
	<?php include 'footer_view.php';?>