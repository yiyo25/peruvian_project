<?php include "header_view.php";;?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				Mantenimiento
				<small>Área</small>
			</h1>
			<ol class="breadcrumb">
				<!-- <li><a href="<?php echo URLLOGICA;?>"><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li> -->
				<li><a><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li>
				<li class="active">Área</li>
			</ol>
		</section>
		<section class="content" style="padding:1px;">
			<div class='box box-danger'>
				<div class="box-header with-border">
					<h3 class="box-title">Búsqueda</h3>					
				</div>
				<div class="box-body" style = "height:400px;">
					<div id="MainContent_Div1" class="panel panel-default">
						<div style='padding: 10px;'>
							<form method="post" action="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/0" onsubmit="document.forms['buscar']['area_buscar'].disabled=true;" name="buscar">
								<div class="row">									
									<div class="col-xs-10" style="margin-bottom:5px;">
										<label for="label_nombre_area" class="col-md-2 control-label">Nombre:</label>
										<div class="col-md-8" >
											<input type="text" name="text_nombre_area" id="text_nombre_area" value="<?php echo $_SESSION['text_nombre_area_bus'];?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase;">
										</div>																												
					                	<div class="col-md-2" >
											
										</div>
									</div>	
									<div class="col-md-2" style="text-align:right;">
			                            <div class="btn-group">
			                            	<button type="button" name="area_limpiar" id="area_limpiar" class="btn btn-default btn-sm pull-right">Limpiar <i class="glyphicon glyphicon-eraser"></i></button>			                            
			                            </div>
			                            <div class="btn-group">
			                            	<button type="submit" name="area_buscar" id="area_buscar" value="Buscar" class="btn btn-default btn-sm pull-right">Buscar <i class="glyphicon glyphicon-search"></i></button>
										</div>	
									</div>				                
					        	</div> 
				        	</form>
						</div>
			     	</div>	
			     	<div id="MainContent_listaPro" class="panel panel-info">
			  			<div class="panel-heading clearfix">
			      			<span id="MainContent_tituloPro"><strong>Listar Áreas</strong></span>
                            <?php if($this->permisos_area[0]["Agregar"] == 1){ ?>
			      			<button data-toggle="modal" data-target="#myModalNuevArea" type="button" name="area_nuevo" id="area_nuevo" class="btn btn-default btn-sm pull-right">Nuevo <i class="glyphicon glyphicon-file"></i></button>
		              		<!-- Inicio Modal Area -->
		              		<div class="modal fade" id="myModalNuevArea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							    	<div class="modal-header" style = "height: 70px;">												        
								        <table class="col-xs-12">
											<tr>
												<td style="text-align:left;"><h4>Ingresar Nueva Área:</h4></td>
												<td>
													<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
											        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
								     			   	</button>
												</td>
											</tr>
										</table>
								    </div>	
							      <form name="formularioModalNuevo" method="post" action="<?php echo URLLOGICA?>mantenimiento/area_grabar/">
							      <div class="modal-body">
							      	 <div class="row">
							      		<div class="col-xs-12" style="padding:5px;">
											<label class="col-md-3 control-label">Nombre Área:<span style="color: #FF0000"><strong>*</strong></span></label>
											<div class="col-md-9">                            
												<input type="text" name="text_modelA_nombre" onkeypress="return validarL(event)" id="text_modelA_nombre" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
											</div>	
										</div> 	
									</div>
							      </div>
							      <div class="modal-footer">
							      	<button type="submit" name = "submit" class="btn btn-primary btn-sm">Grabar</button>	
							        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>										        
							      </div>
							      </form>
							    </div>
							  </div>
							</div>
							<!-- Fin Modal Area-->
                            <?php }?>
			  			</div>
			       		<div class="area_resultado table-responsive">
							<table class="table" cellspacing="0" cellpadding="2" id="MainContent_datResPro" style="font-size: 11px;border-color:Silver;border-width:1px;border-style:solid;border-collapse:collapse;">
								<tr style="color:White;background-color:DimGray;font-weight:bold;">
									<th scope="col">Código</th>
									<th scope="col">Área</th>
									<th scope="col">Estado</th>
									<th scope="col">Editar</th>
									<th scope="col">Eliminar</th>
								</tr>	
								<?php if (count($this->objArea) > 0) {
										$item = 1;
										foreach ($this->objArea as $lista) { ?>
										<tr>
											<td style="width:25%;"><?php echo $lista["area_id"];?></td>
											<td style="width:35%;"><?php echo utf8_encode($lista["area_descripcion"]);?></td>
											<td style="width:20%;"><?php if ($lista["area_estado"] == 1) { echo "ACTIVO"; } elseif ($lista["area_estado"] == 0) { echo "INACTIVO"; } ?></td>
											<td>
                                                <?php if($this->permisos_area[0]["Modificar"] == 1){ ?>
												<button data-toggle="modal" data-target="#myModalEditArea_<?php echo $lista["area_id"];?>" type="button" name="area_edit" id="area_edit" class="btn btn-default btn-xs" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
												<!-- Inicio Modal Editar Area -->												
							              		<div id="myModalEditArea_<?php echo $lista["area_id"];?>" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog" role="document">
												    <div class="modal-content">
												    	<div class="modal-header" style = "height: 70px;">												        
													        <table class="col-xs-12">
																<tr>
																	<td style="text-align:left;"><h4>Editar Área</h4></td>
																	<td>
																		<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
																        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
													     			   	</button>
																	</td>
																</tr>
															</table>
													    </div>
														<form method="post" action="<?php echo URLLOGICA?>mantenimiento/area_update/<?php echo $lista["area_id"];?>">					      	
												      	<div class="modal-body">	
												      	 <div class="row">							      	 					      	 	
												      		<div class="col-xs-12" style="padding-bottom: 10px;">
																<label for="label_modelA_nombre" class="col-md-3 control-label">Nombre Área:<span style="color: #FF0000"><strong>*</strong></span></label>
																<div class="col-md-9">                            
																	<input type="text" name="text_modelA_nombre" id="text_modelA_nombre" value= "<?php echo utf8_encode($lista["area_descripcion"]);?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
																</div>									
															</div> 
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_prioridad" class="col-md-3 control-label">Estado:</label>
																<div class="col-md-3">                            
																	<select name="modelA_area_estado" id="modelA_area_estado" class="form-control input-sm" style="width: 100% !important;">
																			<?php if ($lista["area_estado"] == 1) {?>
																				<option value="1" selected><?php echo "ACTIVO";?></option>
																				<option value="0"><?php echo "INACTIVO";?></option>
																			<?php } elseif ($lista["area_estado"] == 0){?>
																				<option value="1"><?php echo "ACTIVO";?></option>
																				<option value="0" selected><?php echo "INACTIVO";?></option>
																			<?php }?>
																	</select>
																</div>								
															</div>	
														</div>
												      </div>
												      <div class="modal-footer">
												      	<button type="submit" name = "submit" class="btn btn-primary btn-sm">Modificar</button>	
												        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>										        
												      </div>
												      </form>						     
												    </div>
												  </div>
												</div>
											<!-- Fin Modal Editar Area-->
                                                <?php }?>
											</td>				
											<td>
                                                <?php if($this->permisos_area[0]["Eliminar"] == 1){ ?>
												<a href="<?php echo URLLOGICA?>mantenimiento/area_eliminar/<?php echo $lista["area_id"];?>">
													<button type="submit" name="area_eli" id="area_eli" class="btn btn-default btn-xs" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></button>
												</a>
                                                <?php }?>
											</td>
										</tr>
										<?php
											$item++;
										} 
									} else { ?>
										<tr>
											<td colspan="6"><?php echo $this->texto;?></td>
										</tr>	
									<?php } ?>								
							</table>							
			           	</div>	
					</div>					
				</div>
				<div class="container-fluid text-center">
					<nav  aria-label="Page navigation example">
						<ul class="pagination pagination-sm">
							<li><a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/0" aria-label="Primero"><span>&lsaquo;&lsaquo; Primero</a></span></li>
							<?php 
								if($this->pageactual == 0){ ?>
								<li><a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/0" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>
							<?php 
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/<?php echo $this->pageactual-1;?>" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>
							<?php
								}
							?>
							<li>									
								<?php 	
											if(count($this->objArea) > 0){
												$pagemax = 5;
												$TotalReg= count($this->objAreaT);	
												$paginas =ceil($TotalReg/5);
												if ($paginas<$pagemax){
													for($item = 0;$item<$paginas;$item++){
								?>							
									<a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
								<?php	
													}
												}else{
													
													for($item = 0;$item<$pagemax-1;$item++){?>
														
														<a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
														
													<?php
													}
													
													if($this->pageactual >= $pagemax){?>
														<a href="#">...</a>
														<a href="#"><?php echo $this->pageactual;?></a>
													<?php
													}
													if($this->pageactual < $paginas-1){?>
														<a href="#">...</a>
														<a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/<?php echo $paginas-1;?>"><?php echo $paginas;?></a>																
												<?php	}
												}
											} ?>		
							</li>
							<?php	 
								if($this->pageactual == $paginas-1){ ?>	
								<li><a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/<?php echo $paginas-1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/<?php echo $this->pageactual+1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}		
							?>
							<li><a href="<?php echo URLLOGICA?>mantenimiento/area_listar/listar/<?php echo $paginas-1;?>" aria-label="Ultimo"><span>Ultimo &rsaquo;&rsaquo;</a></span></li>
						</ul>
					</nav>												
				</div>	  		
			</div>
		</section>					
	</div>	
<script>

$('select').select2();

$(document).keyup(function(event){
	if(event.which==27){
		$('.modal').modal('hide');
    }
});

$(document).keypress(function(event) {	
    if(event.which == 13) {
        $('#area_buscar').click();
    }
});
  	
$('#area_limpiar').on("click",function() {			
	$('#text_nombre_area').val('');
	location.href ="http://intranet.peruvian.pe/STD/ES/mantenimiento/area_listar/";	
});	
  	
</script>
  <?php include "footer_view.php";?>