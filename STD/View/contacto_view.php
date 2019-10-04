<?php include "header_view.php";;?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				Mantenimiento
				<small>Contacto</small>
			</h1>
			<ol class="breadcrumb">
				<!-- <li><a href="<?php echo URLLOGICA;?>"><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li> -->
				<li><a><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li>
				<li class="active">Contacto</li>
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
							<form method="post" action="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/0" onsubmit="document.forms['buscar']['contacto_buscar'].disabled=true;" name="buscar">
								<div class="row">
									<div class="col-xs-12" style="margin-bottom: 5px;">
										<label for="label_prioridad" class="col-md-2 control-label">Tipo Contacto:</label>
										<div class="col-md-3">                            
											<select name="tipo_contacto" id="tipo_contacto" class="form-control input-sm" style="width: 100% !important;">
													<option value="" selected><?php echo $_SESSION['tipo_contacto_bus'];?></option>
													<option value="I">INTERNO</option>
													<option value="E">EXTERNO</option>
											</select>
										</div>	
										<label for="label_nombre_contacto" class="col-md-2 control-label">Nombre Contacto:</label>
										<div class="col-md-5">                            
											<input type="text" name="text_nombre_contacto" id="text_nombre_contacto" value="<?php echo $_SESSION['text_nombre_contacto_bus'];?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 300 px !important;"/>
										</div>																		
									</div>
									<div class="col-xs-12" style="margin-bottom: 5px;">
										<label for="label_area_contacto" class="col-md-2 control-label">Área Contacto:</label>
										<div class="col-md-3">                            
											<select name="area_contacto" id="area_contacto" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;">
				                    			<option value="" selected><?php echo $_SESSION['area_contacto_bus'];?></option>
					                    		<?php foreach ($this->objArea as $listaArea) {?>
													<option value="<?php echo $listaArea["area_descripcion"];?>"><?php echo utf8_encode($listaArea["area_descripcion"]);?></option>
												<?php } ?>
											</select> 
										</div>
										<label for="label_cargo_contacto" class="col-md-2 control-label">Cargo Contacto:</label>
										<div class="col-md-3">                            
											<select name="cargo_contacto" id="cargo_contacto" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100%!important;">
				                    			<option value="" selected><?php echo $_SESSION['cargo_contacto_bus'];?></option>
					                    		<?php foreach ($this->objCargo as $listaCargo) {?>
													<option value="<?php echo $listaCargo["cargo_descripcion"];?>"><?php echo utf8_encode($listaCargo["cargo_descripcion"]);?></option>
												<?php } ?>
											</select> 
										</div>										
										<div class="col-md-2" style="text-align:right;">
				                            <div class="btn-group">
				                            	<button type="button" name="contacto_limpiar" id="contacto_limpiar" value="Limpiar" class="btn btn-default btn-sm pull-right">Limpiar <i class="glyphicon glyphicon-eraser"></i></button>			                            
				                            </div>
				                            <div class="btn-group">
				                            	<button type="submit" name="contacto_buscar" id="contacto_buscar" value= "Buscar" class="btn btn-default btn-sm pull-right">Buscar <i class="glyphicon glyphicon-search"></i></button>
											</div>	
										</div>
									 </div> 									 
					        	</div> 
				        	</form>
						</div>
			     	</div>	
			     	<div id="MainContent_listaPro" class="panel panel-info">
			  			<div class="panel-heading clearfix" >
			      			<span id="MainContent_tituloPro"><strong>Listar Contactos</strong></span>
                            <?php if($this->permisos[0]["Agregar"] == 1) {?>
			      			<button data-toggle="modal" data-target="#myModalNuevoContacto" type="button" name="contacto_nuevo" id="contacto_nuevo" class="btn btn-default btn-sm pull-right">Nuevo <i class="glyphicon glyphicon-file"></i></button>
			              	<!-- Modal Nuevo Contato-->
		              		<div id="myModalNuevoContacto" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							    	<div class="modal-header" style = "height: 70px;">												        
								        <table class="col-xs-12">
											<tr>
												<td style="text-align:left;"><h4>Ingresar Nuevo Contacto:</h4></td>
												<td>
													<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
											        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
								     			   	</button>
												</td>
											</tr>
										</table>
								    </div>	
							      <form name="formularioModalNuevo" method="post" action="<?php echo URLLOGICA?>mantenimiento/contacto_grabar/">
							      <div class="modal-body">
							      	 <div class="row">
							      	 	<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelC_nom_contacto" class="col-md-3 control-label">Contacto:<span style="color: #FF0000"><strong>*</strong></span></label>
											<div class="col-md-8">                            
												<input type="text" name="text_modelC_nom_contacto" onkeypress="return validarL(event)" id = 'text_modelC_nom_contacto' maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" required>
											</div>									
										</div>
										<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelC_email" class="col-md-3 control-label">Email:</label>
											<div class="col-md-8">                            
												<input type="email" name="text_modelC_correo" id = 'text_modelC_correo' maxlength="100" class="form-control input-sm" style="width: 100% !important;" required>
											</div>									
										</div>
										<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_tip_ent_reg" class="col-md-3 control-label">Entidad Origen:</label>
											<div class="col-md-8">                            
												<input type="radio" name="radio_tip_contacto" value="E" checked> EXTERNO
												<input type="radio" name="radio_tip_contacto" value="I"> INTERNO
											</div>									
										</div>							      	 	
										<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelC_empresa" class="col-md-3 control-label">Empresa:</label>
											<div class="col-md-8">                            
												<select name="modal_empresa" id="modal_empresa" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;">
					                    			<option value="" selected>SELECCIONE ENTIDAD</option>
						                    		<?php foreach ($this->objEnt as $listaEntidad) {?>
														<option value="<?php echo $listaEntidad["emp_id"];?>"><?php echo utf8_encode($listaEntidad["emp_razonsocial"]);?></option>
													<?php } ?>
												</select>
											</div>									
										</div> 										
										<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelC_area_contacto" class="col-md-3 control-label">Área Contacto:</label>
											<div class="col-md-8">                            
												<select name="modal_area" id="modal_area" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 265px !important;">
					                    			<option value="" selected>SELECCIONE AREA</option>
						                    		<?php foreach ($this->objArea as $listaArea) {?>
														<option value="<?php echo $listaArea["area_id"];?>"><?php echo utf8_encode($listaArea["area_descripcion"]);?></option>
													<?php } ?>
												</select> 
											</div>
										</div>
										<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelC_cargo_contacto" class="col-md-3 control-label">Cargo Contacto:</label>
											<div class="col-md-8">                            
												<select name="modal_cargo" id="modal_cargo" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 265px !important;">
					                    			<option value="" selected>SELECCIONE CARGO</option>
						                    		<?php foreach ($this->objCargo as $listaCargo) {?>
														<option value="<?php echo $listaCargo["cargo_id"];?>"><?php echo utf8_encode($listaCargo["cargo_descripcion"]);?></option>
													<?php } ?>
												</select> 
											</div>
										</div>
									</div>
							      </div>
							      <div class="modal-footer">
							        <button type="submit" class="btn btn-primary btn-sm">Grabar</button>
							        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>										        
							      </div>
							     </form>
							    </div>
							  </div>
							</div>
							<!-- Fin Modal -->
                            <?php } ?>
			  			</div>
			       		<div class="area_resultado table-responsive">
							<table class="table" cellspacing="0" cellpadding="2" id="MainContent_datResPro" style="font-size: 11px;border-color:Silver;border-width:1px;border-style:solid;border-collapse:collapse;">
								<tr style="color:White;background-color:DimGray;font-weight:bold;">
									<th scope="col">Código</th>
									<th scope="col">Nombre</th>
									<th scope="col">Área</th>
									<th scope="col">Cargo</th>
									<th scope="col">Estado</th>
									<th scope="col">Editar</th>
									<th scope="col">Eliminar</th>
								</tr>
								<?php if (count($this->objContacto) > 0) {
										$item = 1;
										foreach ($this->objContacto as $lista) { ?>
										<tr>
											<td style="width:10%;"><?php echo $lista["contac_id"];?></td>
											<td style="width:30%;"><?php echo utf8_encode($lista["contac_nombre"]);?></td>
											<td style="width:35%;"><?php echo utf8_encode($lista["area_descripcion"]);?></td>
											<td style="width:35%;"><?php echo utf8_encode($lista["cargo_descripcion"]);?></td>
											<td style="width:35%;"><?php if ($lista["contac_estado"] == 1) { echo "ACTIVO"; } elseif ($lista["contac_estado"] == 0) { echo "INACTIVO"; } ?></td>
											<td>
                                                <?php if($this->permisos[0]["Modificar"] == 1) {?>
												<button data-toggle="modal" data-target="#myModalUpdContacto_<?php echo $lista["contac_id"];?>" type="button" name="contac_edit" id="contac_edit" class="btn btn-default btn-xs" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
												<!-- Modal Editar Contato-->
							              		<div class="modal fade" id="myModalUpdContacto_<?php echo $lista["contac_id"];?>" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog" role="document">
												    <div class="modal-content">
												    	<div class="modal-header" style = "height: 70px;">												        
													        <table class="col-xs-12">
																<tr>
																	<td style="text-align:left;"><h4>Editar Contacto</h4></td>
																	<td>
																		<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
																        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
													     			   	</button>
																	</td>
																</tr>
															</table>
													    </div>
												      <form method="post" action="<?php echo URLLOGICA?>mantenimiento/contacto_update/<?php echo $lista["contac_id"];?>">	
												      <div class="modal-body">
												      	 <div class="row">
												      	 	<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_modelC_nom_contacto" class="col-md-3 control-label">Contacto:<span style="color: #FF0000"><strong>*</strong></span></label>
																<div class="col-md-8">                            
																	<input type="text" name="model_contacto_edit" id = 'model_contacto_edit' value= "<?php echo utf8_encode($lista["contac_nombre"]);?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
																</div>									
															</div>
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_modelC_nom_contacto" class="col-md-3 control-label">D.N.I.:<span style="color: #FF0000"><strong>*</strong></span></label>
																<div class="col-md-4">                            
																	<input type="text" name="model_dni_edit" id = 'model_dni_edit' value= "<?php echo utf8_encode($lista["contac_dni"]);?>" maxlength="100" class="form-control input-sm number" style="width: 100% !important;"/>
																</div>									
															</div>
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_modelC_correo" class="col-md-3 control-label">Email:</label>
																<div class="col-md-8">                            
																	<input type="email" name="model_correo_edit" id = 'model_correo_edit' value= "<?php echo utf8_encode($lista["contact_correo"]);?>"maxlength="100" class="form-control input-sm" style="width: 100% !important;"/>
																</div>									
															</div>
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_tip_ent_reg" class="col-md-3 control-label">Entidad Origen:<span style="color: #FF0000"><strong>*</strong></span></label>
																<div class="col-md-8">    
																	<?php if ($lista["contac_tipo"] == "I") {?>
																		<input type="radio" name="modal_radio_edit" value="I" checked> Interno
																		<input type="radio" name="modal_radio_edit" value="E"> Externo
																	<?php } elseif ($lista["contac_tipo"] == "E"){?>
																		<input type="radio" name="modal_radio_edit" value="I"> Interno
																		<input type="radio" name="modal_radio_edit" value="E" checked> Externo
																	<?php }?>
																</div>									
															</div>							      	 	
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_modelC_empresa" class="col-md-3 control-label">Empresa:<span style="color: #FF0000"><strong>*</strong></span></label>
																<div class="col-md-8">                            
																	<select name="modal_empresa_edit" id="modal_empresa_edit" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;" disabled>
										                    			<option value="<?php echo $lista["empcontac_id"];?>" selected><?php echo utf8_encode($lista["emp_razonsocial"]);?></option>
											                    	</select>
																</div>									
															</div> 										
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_modelC_area_contacto" class="col-md-3 control-label">Área Contacto:<span style="color: #FF0000"><strong>*</strong></span></label>
																<div class="col-md-8">                            
																	<select name="modal_area_edit" id="modal_area_edit" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 265px !important;" disabled>
										                    			<option value="<?php echo $lista["areatrab_id"];?>" selected><?php echo utf8_encode($lista["area_descripcion"]);?></option>
												                    </select> 
																</div>
															</div>
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_modelC_cargo_contacto" class="col-md-3 control-label">Cargo Contacto:<span style="color: #FF0000"><strong>*</strong></span></label>
																<div class="col-md-8">                            
																	<select name="modal_cargo_edit" id="modal_cargo_edit" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 265px !important;" disabled>
										                    			<option value="<?php echo $lista["cargocontac_id"];?>" selected><?php echo utf8_encode($lista["cargo_descripcion"]);?></option>
												                    	<?php foreach ($this->objCargo as $listaCargo) {?>
																		<option value="<?php echo $listaCargo["cargo_id"];?>"><?php echo utf8_encode($listaCargo["cargo_descripcion"]);?></option>
																		<?php } ?>
																	</select> 
																</div>
															</div>
															<div class="col-xs-12" style="margin-bottom: 10px;">
																<label for="label_estado" class="col-md-3 control-label">Estado:</label>
																<div class="col-md-3">                            
																	<select name="modal_estado_edit" id="modal_estado_edit" class="form-control input-sm" style="width: 100% !important;">
																			<?php if ($lista["contac_estado"] == 1) {?>
																				<option value="1" selected><?php echo "ACTIVO";?></option>
																				<option value="0"><?php echo "INACTIVO";?></option>
																			<?php } elseif ($lista["contac_estado"] == 0){?>
																				<option value="1"><?php echo "ACTIVO";?></option>
																				<option value="0" selected><?php echo "INACTIVO";?></option>
																			<?php }?>
																	</select>
																</div>								
															</div>	
														</div>
												      </div>
												      <div class="modal-footer">
												        <button type="submit" class="btn btn-primary btn-sm">Modificar</button>
												        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>										        
												      </div>
												     </form>
												    </div>
												  </div>
												</div>
												<!-- Fin Modal -->
                                                <?php } ?>
											</td>
											<td>
                                                <?php if($this->permisos[0]["Eliminar"] == 1) {?>
												<a href="<?php echo URLLOGICA?>mantenimiento/contacto_eliminar/<?php echo $lista["contac_id"];?>">
													<button type="submit" name="contac_eli" id="contac_eli" class="btn btn-default btn-xs" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></button>
												</a>
                                                <?php } ?>
											</td>
										</tr>
										<?php
											$item++;
										} 
									} 
									else { ?>
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
							<li><a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/0" aria-label="Primero"><span>&lsaquo;&lsaquo; Primero</a></span></li>
							<?php 
								if($this->pageactual == 0){ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/0" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>	
							<?php 
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/<?php echo $this->pageactual-1;?>" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>
							<?php
								}
							?>
							<li>									
								<?php 	
											if(count($this->objContacto) > 0){
												$pagemax = 5;
												$TotalReg= count($this->objContactoT);	
												$paginas =ceil($TotalReg/5);
												if ($paginas<$pagemax){
													for($item = 0;$item<$paginas;$item++){
								?>							
									<a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
								<?php	
													}
												}else{
													
													for($item = 0;$item<$pagemax-1;$item++){?>
														
														<a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
														
													<?php
													}
													
													if($this->pageactual >= $pagemax){?>
														<a href="#">...</a>
														<a href="#"><?php echo $this->pageactual;?></a>
													<?php
													}
													if($this->pageactual < $paginas-1){?>
														<a href="#">...</a>
														<a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/<?php echo $paginas-1;?>"><?php echo $paginas;?></a>																
												<?php	}
												}
											} ?>		
							</li>
							<?php	 
								if($this->pageactual == $paginas-1){ ?>	
									<li><a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/<?php echo $paginas-1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/<?php echo $this->pageactual+1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}		
							?>	
							<li><a href="<?php echo URLLOGICA?>mantenimiento/contacto_listar/listar/<?php echo $paginas-1;?>" aria-label="Ultimo"><span>Ultimo &rsaquo;&rsaquo;</a></span></li>	
						</ul>
					</nav>												
				</div>	
			</div>
		</section>					
	</div>
<script >
$('select').select2();
$(document).keyup(function(event){
if(event.which==27)
	{
		$('.modal').modal('hide');
    }
});

$(document).keypress(function(event) {
    if(event.which == 13) {
        $('#contacto_buscar').click();
    }
});

$("#contacto_limpiar").on("click",function() {			
	$('#tipo_contacto').val('');
	$('#text_nombre_contacto').val('');
	$('#area_contacto').val('');
	$('#cargo_contacto').val('');
	location.href ="http://intranet.peruvian.pe/STD/ES/mantenimiento/contacto_listar/";	
});	
</script>
  <?php include "footer_view.php";?>