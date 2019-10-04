	<?php include "header_view.php";?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Nombre de Pagina
				<small>Descripcion</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-thumb-tack"></i> Nivel 1</a></li>
				<li class="active">Nivel Actual</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class='box box-danger'>
				<div class="box-header with-border">
					<h3 class="box-title">Titulo tabla</h3>
				</div>
				<div class="box-body">
					<br />
		            <div class="panel-heading  alert-wizard"> <h5> <?php echo ERROR_MENSAJE;?></h5> </div>
		            <div class="alert alert-error"><?php echo $this->msg_catch;?></div>
					<div class="panel-heading  alert-wizard"> <h5> <?php echo PRINT_PANTALLA;?></h5> </div>
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
  <?php include "footer_view.php";?>