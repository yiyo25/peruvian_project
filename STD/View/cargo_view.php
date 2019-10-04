<?php include "header_view.php";?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Mantenimiento<small>Cargo</small></h1>
			<ol class="breadcrumb">
				<li><a><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li>
				<li class="active">Cargo</li>
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
							<form method="post" action="<?php echo URLLOGICA?>mantenimiento/cargo_listar/" onsubmit="document.forms['buscar']['cargo_buscar'].disabled=true;" name="buscar">
								<div class="row">									
									<div class="col-xs-10" style="margin-bottom:5px;">
										<label for="label_nombre_cargo" class="col-md-1 control-label">Nombre:</label>
										<div class="col-md-9" >
											<input type="text" name="text_nombre_cargo" id="text_nombre_cargo" value="<?php echo $_SESSION['text_nombre_cargo_bus'];?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase;">
										</div>
						        	</div>  
						        	<div class="col-md-2" style="text-align:right;">
			                            <div class="btn-group">
			                            	<button type="button" name="cargo_limpiar" id="cargo_limpiar" class="btn btn-default btn-sm pull-right">Limpiar <i class="glyphicon glyphicon-eraser"></i></button>			                            
			                            </div>
			                            <div class="btn-group">
			                            	<button type="submit" name="cargo_buscar" id="cargo_buscar" value ="Buscar"  class="btn btn-default btn-sm pull-right">Buscar <i class="glyphicon glyphicon-search"></i></button>
										</div>	
									</div>	 
					        	</div> 
				        	</form>
						</div>
			     	</div>	
			     	<div id="MainContent_listaPro" class="panel panel-info">
			  			<div class="panel-heading clearfix">
			      			<span id="MainContent_tituloPro"><strong>Listar Cargos</strong></span>
                            <?php if($this->permisos[0]["Agregar"] == 1) {?>
			      			<button data-toggle="modal" data-target="#myModalNuevoCargo" type="button" name="cargo_nuevo" id="cargo_nuevo" class="btn btn-default btn-sm pull-right">Nuevo <i class="glyphicon glyphicon-file"></i></button>
			              	<!-- Inicio Modal Nuevo -->
		              		<div class="modal fade" id="myModalNuevoCargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							    	<div class="modal-header" style = "height: 70px;">												        
								        <table class="col-xs-12">
											<tr>
												<td style="text-align:left;"><h4>Ingresar Nuevo Cargo:</h4></td>
												<td>
													<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
											        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
								     			   	</button>
												</td>
											</tr>
										</table>
								    </div>	
							      <form name="formularioModalNuevo" method="post" action="<?php echo URLLOGICA?>mantenimiento/cargo_grabar/">
							      <div class="modal-body">
							      	 <div class="row">
							      		<div class="col-xs-12" style="padding-bottom: 5px;">
											<label for="label_modelCg_nombre" class="col-md-3 control-label">Nombre Cargo:<span style="color: #FF0000"><strong>*</strong></span></label>
											<div class="col-md-9">                            
												<input type="text" name="text_modelCg_nombre" onpaste="return false" oncut="return false" oncopy="return false" onkeypress="return validarL(event)" id="text_modelCg_nombre" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
											</div>									
										</div> 									
									</div>
							      </div>
							      <div class="modal-footer">
							        <button type="submit" class="btn btn-primary">Grabar</button>
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>										        
							      </div>
							      </form>
							    </div>
							  </div>
							</div>
							<!-- Fin Modal Nuevo-->
                            <?php } ?>
			  			</div>
			       		<div class="area_resultado table-responsive">	       				
							<table class="table" cellspacing="0" cellpadding="2" id="MainContent_datResPro" style="font-size: 11px;padding: 5px;border-color:Silver;border-width:1px;border-style:solid;border-collapse:collapse;margin: 0 auto;">
								<tr style="color:White;background-color:DimGray;font-weight:bold;">
									<th scope="col">Código</th>
									<th scope="col">Cargo</th>
									<th scope="col">Estado</th>
									<th scope="col">Editar</th>
									<th scope="col">Eliminar</th>
								</tr>
								<?php if (count($this->objCargo) > 0) {
										$item = 1;
										foreach ($this->objCargo as $lista) { ?>
										<tr>
											<td style="width:25%;"><?php echo $lista["cargo_id"];?></td>
											<td style="width:35%;"><?php echo utf8_encode($lista["cargo_descripcion"]);?></td>
											<td style="width:20%;"><?php if ($lista["cargo_estado"] == 1) { echo "ACTIVO"; } elseif ($lista["cargo_estado"] == 0) { echo INACTIVO; } ?></td>
											<td>
                                                <?php if($this->permisos[0]["Modificar"] == 1) {?>
												<button data-toggle="modal" data-target="#myModalUpdCargo_<?php echo $lista["cargo_id"];?>" type="button" name="cargo_edit" id="cargo_edit" class="btn btn-default btn-xs" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
												<!-- Inicio Modal Editar Area -->												
							              		<div class="modal fade" id="myModalUpdCargo_<?php echo $lista["cargo_id"];?>" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog" role="document">
												    <div class="modal-content">
												      <div class="modal-header" style = "height: 70px;">												        
													        <table class="col-xs-12">
																<tr>
																	<td style="text-align:left;"><h4>Editar Cargo</h4></td>
																	<td>
																		<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
																        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
													     			   	</button>
																	</td>
																</tr>
															</table>
													    </div>
														<form method="post" action="<?php echo URLLOGICA?>mantenimiento/cargo_update/<?php echo $lista["cargo_id"];?>">					      	
												      	<div class="modal-body">	
												      		<div class="row">							      	 					      	 	
												      			<div class="col-xs-12" style="padding-bottom: 10px;">
																	<label for="label_modelC_nombre" class="col-md-3 control-label">Nombre Cargo:<span style="color: #FF0000"><strong>*</strong></span></label>
																	<div class="col-md-9">                            
																		<input type="text" name="text_modelC_nombre" id="text_modelC_nombre" value= "<?php echo utf8_encode($lista["cargo_descripcion"]);?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
																	</div>									
																</div> 
																<div class="col-xs-12" style="margin-bottom: 10px;">
																	<label for="label_modelC_estado" class="col-md-3 control-label">Estado:</label>
																	<div class="col-md-3">                            
																		<select name="modelC_cargo_estado" id="modelC_cargo_estado" class="form-control input-sm" style="width: 100% !important;">
																			<?php if ($lista["cargo_estado"] == 1) {?>
																				<option value="1" selected><?php echo "ACTIVO";?></option>
																				<option value="0"><?php echo "INACTIVO";?></option>
																			<?php } elseif ($lista["cargo_estado"] == 0){?>
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
                                                <?php } ?>
											</td>
											<td>
                                                <?php if($this->permisos[0]["Eliminar"] == 1) {?>
												<a href="<?php echo URLLOGICA?>mantenimiento/cargo_eliminar/<?php echo $lista["cargo_id"];?>">
													<button type="submit" name="cargo_eli" id="cargo_eli" class="btn btn-default btn-xs" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></button>
												</a>
                                                <?php } ?>
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
					<nav>
						<ul class="pagination pagination-sm">
							<li><a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/0" aria-label="Previous"><span>&lsaquo;&lsaquo; Primero</a></span></li>
							<?php 
								if($this->pageactual == 0){ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/0" aria-label="Previous"><span>&lsaquo; Anterior</a></span></li>	
							<?php 
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/<?php echo $this->pageactual-1;?>" aria-label="Previous"><span>&lsaquo; Anterior</a></span></li>
							<?php
								}
							?>
							<li>									
								<?php 	
											if(count($this->objCargo) > 0){
												$pagemax = 5;
												$TotalReg= count($this->objCargoT);	
												$paginas =ceil($TotalReg/5);
												if ($paginas<$pagemax){
													for($item = 0;$item<$paginas;$item++){
								?>							
									<a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
								<?php	
													}
												}else{
													
													for($item = 0;$item<$pagemax-1;$item++){?>
														
														<a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
														
													<?php
													}
													
													if($this->pageactual >= $pagemax){?>
														<a href="#">...</a>
														<a href="#"><?php echo $this->pageactual+1;?></a>
													<?php
													}
													if($this->pageactual < $paginas-1){?>
														<a href="#">...</a>
														<a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/<?php echo $paginas-1;?>"><?php echo $paginas;?></a>																
												<?php	}
												}
											} ?>		
							</li>
							<?php	 
								if($this->pageactual == $paginas-1){ ?>	
									<li><a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/<?php echo $paginas-1;?>" aria-label="Next"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/<?php echo $this->pageactual+1;?>" aria-label="Next"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}		
							?>	
							<li><a href="<?php echo URLLOGICA?>mantenimiento/cargo_listar/listar/<?php echo $paginas-1;?>" aria-label="Previous"><span>Ultimo &rsaquo;&rsaquo;</a></span></li>	
						</ul>
					</nav>												
				</div>
			</div>
		</section>					
	</div>	
<script>
$('select').select2();
$(document).keyup(function(event){
	if(event.which==27)
	{
		$('.modal').modal('hide');
    }
});

  	
$(document).keypress(function(e) {
    if(e.which == 13) {
        $('#cargo_buscar').click();
    }
});

$("#cargo_limpiar").on("click",function() {			
	$("#text_nombre_cargo").val('');
	location.href ="http://intranet.peruvian.pe/STD/ES/mantenimiento/cargo_listar/";	
});	
</script>
<?php include "footer_view.php";?>