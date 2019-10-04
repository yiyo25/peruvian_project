<?php include "header_view.php";?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo HOME;?>
				<small></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo URLLOGICA;?>"><i class="fa fa-thumb-tack"></i> Home </a></li>
				<li class="active"></li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class='box box-danger'>
				<div class="box-body">
					<div class="page">
						<div class="main">
							<form method="post" action="" id="">
							    <div class="row" style="margin: 2% 0px;">
							        <div class="col-md-4 col-md-offset-4 welcome">
							            <div class="row" style="padding: 13px 0px 0px; box-sizing: border-box;">
							                <div class="col-md-4">
							                    <img src="<?php echo URLPUBLIC;?>/img/user_img.png" />
							                </div>
							                <div class="col-md-8 bienvenida">
							                    Hola
							                    <span id="MainContent_nomintranet" class="mayus"><?php echo $this->objUsu;?></span> 
							                    <div class="mesage">Bienvenido al Sistema de Programación de Vuelo.</div>
							                </div>
							            </div>
							        </div>
							    </div>
							</form>
						</div>
					</div>
				</div>
				<div class="box-footer clearfix">
				</div>
			</div>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	
<?php include "footer_view.php";?>