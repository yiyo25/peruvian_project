<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>SIST_TRAM_DOC</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
		<link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/css/font-awesome.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/css/plantilla.css?v=1">
		<link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/css/peruvian.css">
		<link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/css/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/css/select2.css">
		<!-- <link rel="stylesheet" href="<?php echo URLPUBLIC; ?>/css/simplePagination.css"> -->
		
		<!-- <script src="<?php echo URLPUBLIC; ?>/plugins/jQuery/jquery-2.2.3.min.js"></script> -->
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/plugins/jQuery/jquery-ui.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/js/peruvian.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/js/validacion.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/js/jquery.chained.min.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/js/jquery.numeric.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/js/select2.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo URLPUBLIC; ?>/js/pagination.js"></script>
		<!--[if lt IE 9]>
			<script src="<?php echo URLPUBLIC; ?>/js/html5shiv.js"></script>
		<![endif]-->
		<style>
		.center {
		    text-align: center;
		}
		
		.pagination {
		    display: inline-block;
		}
		
		.pagination a {
		    color: black;
		    float: center;
		    padding: 2px 4px;
		    text-decoration: none;
		    transition: background-color .3s;
		    border: 1px solid #ddd;
		    font-size: 15px;
		    margin: 0px;
		}
		
		.pagination a.active {
		    background-color: #4CAF50;
		    color: white;
		    border: 1px solid #4CAF50;
		}
		  	
		.pagination a:hover:not(.active) {background-color: #ddd;}
		
		#panel_body{
		     height:270px;
		     width:1069px;
		     font-size: 11px;
		}
		
		#panel_body_referencia{
		     overflow:scroll;
		     overflow-x:hidden;  
		     height:270px;
		     width:1069px;
		     font-size: 11px;
		}	
		.table-fixed thead {
		  width: 97%;
		}
		.table-fixed tbody {
		  height: 230px;
		  overflow-y: auto;
		  width: 100%;
		}
		.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
		  display: block;
		}
		.table-fixed tbody td, .table-fixed thead > tr> th {
		  float: left;
		  border-bottom-width: 0;
		}
		
		
		#celda_sub{
		height: auto;
		width: 100px;
		}
		
		#celda{
		height: auto;
		width: 250px;
		}
		
		#celda_flujo{
		height: auto;
		width: 400px;
		}
		
		/*
		#linea_seg{
		     overflow:scroll;
		     overflow-x:hidden;
		     height:50px;
		     width:500px;
		}
		*/
		
		</style>
		
		<script type="text/javascript">		
			$(document).ready(function() {		
			   $(".datepicker").datepicker();
			   
			});	
		</script>
		
		<script type="text/javascript">	
			$('.modal fade').on('shown.bs.modal', function () {
				$('#myInput').focus()
  			}); 
  			
  			function validarNL(e) { // 1
			    tecla = (document.all) ? e.keyCode : e.which; // 2
			    if (tecla==8) return true; // 3
			    patron = /\w/; // 4
			    te = String.fromCharCode(tecla); // 5
			    return patron.test(te); // 6
			}
			
			function validarL(e) { // 1
			    tecla = (document.all) ? e.keyCode : e.which; // 2
			    if (tecla==8) return true; // 3
			    patron = /[A-Za-z\s]/; // 4
			    te = String.fromCharCode(tecla); // 5
			    return patron.test(te); // 6
			}
							
  		</script>
	</head>
	<body class="skin-blue sidebar-mini sidebar-collapse">
		<div class="wrapper">
		<!-- Main Header -->
			<header class="main-header">
				<!-- Logo -->
				
				<a href="<?php echo URLLOGICA; ?>" class="logo">					
				<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini">
						<img src="<?php echo URLPUBLIC; ?>/img/logo-peruvian-small.png" />
					</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg">
						<img src="<?php echo URLPUBLIC; ?>/img/logo-peruvian.png" />
					</span>					
				</a>				
	    		<!-- Header Navbar -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<!-- <a href="" data-toggle="offcanvas" role="button"> -->
					<a class="visible-xs" href="" data-toggle="offcanvas" role="button"> 
					<!--<a>-->
						<i class="visible-xs rayas fa fa-bars" aria-hidden="true"></i>
						<span class="sidebar-toggle">SISTEMA DE TRÁMITE DOCUMENTARIO (STD)</span>
					</a>
					<a class="hidden-xs">
						<span class="sidebar-toggle">SISTEMA DE TRÁMITE DOCUMENTARIO (STD)</span>
					</a>
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="<?php echo URLLOGICA;?>">
									<span class="hidden-xs"><?php echo $_SESSION['usuario'];?></span>
								</a>
							</li>
							<li>
								<a href="<?php echo URLLOGICA; ?>login/salir">
									<i class="fa fa-power-off"></i>
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</header>
				<!-- Left side column. contains the logo and sidebar
			<aside class="main-sidebar">

				<section class="sidebar">

					<ul class="sidebar-menu">
						 Optionally, you can add icons to the links
						<li class="treeview">
							<a href="<?php echo URLLOGICA; ?>registro/">
								<i class="fa fa-link"></i>
								<span>Registro Documentario</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
						</li>
						<li class="treeview">
							<a href="<?php echo URLLOGICA; ?>registroEdit/">
								<i class="fa fa-link"></i>
								<span>Edición de Registros</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
						</li>
						<li class="treeview">
							<a href="<?php echo URLLOGICA; ?>agregarCopia/">
								<i class="fa fa-link"></i>
								<span>Generar Copias</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
						</li>
						<li class="treeview">
							<a href="<?php echo URLLOGICA; ?>seguimiento/listar_seguimiento/">
								<i class="fa fa-link"></i>
								<span>Seguimiento Documentario</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span> 
							</a>
						</li>
						<li class="treeview">
							<a href="#">
								<i class="fa fa-link"></i>
								<span>Mantenimiento</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span> 
							</a>							
							<ul class="treeview-menu">
								<li>
									<li><a href="<?php echo URLLOGICA; ?>mantenimiento/empresa_listar/">Empresa</a></li>
									<li><a href="<?php echo URLLOGICA; ?>mantenimiento/area_listar/">Área</a></li>
									<li><a href="<?php echo URLLOGICA; ?>mantenimiento/cargo_listar/">Cargo</a></li>
									<li><a href="<?php echo URLLOGICA; ?>mantenimiento/contacto_listar/">Contacto</a></li>
									<li><a href="<?php echo URLLOGICA; ?>mantenimiento/tipo_documento_listar/">Documento</a></li>
									<li><a href="<?php echo URLLOGICA; ?>alertasEdit/">Alertas</a></li>									
								</li>																
							</ul>
						</li>
					</ul>
				</section>
			</aside>-->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="header">Sistema de Programación de Vuelo</li>
                        <?php echo $this->objMenu; ?>
                        <!-- Optionally, you can add icons to the links -->

                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>