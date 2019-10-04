<?php include "header_view.php";;?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				Mantenimiento
				<small>Tipo de Documento</small>
			</h1>
			<ol class="breadcrumb">
				<li><a><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li>
				<li class="active">Tipo de Documento</li>
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
							<form method="post" action="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/0" onsubmit="document.forms['buscar']['tipo_documento_buscar'].disabled=true;" name="buscar">
								<div class="row">									
									<div class="col-xs-12" style="margin-bottom: 5px;">
										<label for="label_nombre_tipo_documento" class="col-md-2 control-label">Nombre:</label>
										<div class="col-md-8" >
											<input type="text" name = "text_nombre_tipo_documento" id = "text_nombre_tipo_documento" value="<?php echo $_SESSION['text_nombre_tipo_documento_bus'];?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase;">
										</div>
										<div class="col-md-2">
											<div class="btn-group">
			                            		<button type="button" name="doc_limpiar" id="doc_limpiar" class="btn btn-default btn-sm pull-right">Limpiar <i class="glyphicon glyphicon-eraser"></i></button>			                            
			                            	</div>
			                            	<div class="btn-group">
					                			<button type="submit" name="doc_buscar" id="doc_buscar" value="Buscar" class="btn btn-default btn-sm pull-right">Buscar <i class="glyphicon glyphicon-search"></i></button>
					                		</div>
					                	</div>						
					                </div> 					                
					        	</div> 
				        	</form>
						</div>
			     	</div>	
			     	<div id="MainContent_listaPro" class="panel panel-info">
			  			<div class="panel-heading clearfix">
			      			<span id="MainContent_tituloPro"><strong>Listar Documentos</strong></span>
                            <?php if($this->permisos[0]["Agregar"] == 1) {?>
			      			<button onclick = "bloquearModalNuevo()" data-toggle="modal" data-target="#myModalNuevoDocumento" type="button" name="doc_nuevo" id="doc_nuevo" class="btn btn-default btn-sm pull-right">Nuevo <i class="glyphicon glyphicon-file"></i></button>			              	
			  			    <?php } ?>
                        </div>
			       		<div class="area_resultado table-responsive">
							<table class="table" cellspacing="0" cellpadding="2" id="MainContent_datResPro" style="font-size: 11px;border-color:Silver;border-width:1px;border-style:solid;border-collapse:collapse;">
								<tr style="color:White;background-color:DimGray;font-weight:bold;">
									<th scope="col">Código</th>
									<th scope="col">Descripción</th>
									<th scope="col">Estado</th>
									<th scope="col">Editar</th>
									<th scope="col">Eliminar</th>
								</tr>	
								<?php if (count($this->objDoc) > 0) {
										$item = 1;
										foreach ($this->objDoc as $lista) { ?>
										<tr>
											<td style="width:25%;"><?php echo $lista["td_id"];?></td>
											<td style="width:35%;"><?php echo utf8_encode($lista["td_descripcion"]);?></td>
											<td style="width:20%;"><?php if ($lista["td_estado"] == 1) { echo "ACTIVO"; } elseif ($lista["td_estado"] == 0) { echo "INACTIVO"; } ?></td>
											<td>
                                                <?php if($this->permisos[0]["Modificar"] == 1) {?>
												<button onclick="bloquearModalEditar(<?php echo $lista["td_id"];?>)"   data-toggle="modal" data-target="#myModalUpdDoc_<?php echo $lista["td_id"];?>" type="button" name="doc_edit" id="doc_edit" class="btn btn-default btn-xs" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
												<!-- Inicio Modal Editar Documento -->		
												<div class="modal fade" id="myModalUpdDoc_<?php echo $lista["td_id"];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog" role="document">
												    <div class="modal-content">
												    	<div class="modal-header" style = "height: 70px;">												        
													        <table class="col-xs-12">
																<tr>
																	<td style="text-align:left;"><h4>Editar Documento</h4></td>
																	<td>
																		<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
																        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
													     			   	</button>
																	</td>
																</tr>
															</table>
													    </div>
														<form method="post" action="<?php echo URLLOGICA?>mantenimiento/documento_update/<?php echo $lista["td_id"];?>">					      	
												      	<div class="modal-body">	
												      		<div class="row">							      	 					      	 	
												      			<div class="col-xs-12" style="padding-bottom: 10px;">
																	<label for="label_modelC_nombre" class="col-md-3 control-label">Nombre Tipo Doc.:<span style="color: #FF0000"><strong>*</strong></span></label>
																	<div class="col-md-9">                            
																		<input type="text" name="text_modelD_nombre" id="text_modelD_nombre" value= "<?php echo utf8_encode($lista["td_descripcion"]);?>" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
																	</div>									
																</div> 
																<div class="col-xs-12" style="margin-bottom: 10px;">
																	<label for="label_modelD_estado" class="col-md-3 control-label">Estado:</label>
																	<div class="col-md-3">                            
																		<select name="modelD_doc_estado" id="modelD_doc_estado" class="form-control input-sm" style="width: 100% !important;">
																			<?php if ($lista["td_estado"] == 1) {?>
																				<option value="1" selected><?php echo "ACTIVO";?></option>
																				<option value="0"><?php echo "INACTIVO";?></option>
																			<?php } elseif ($lista["td_estado"] == 0){?>
																				<option value="1"><?php echo "ACTIVO";?></option>
																				<option value="0" selected><?php echo "INACTIVO";?></option>
																			<?php }?>
																		</select>
																	</div>								
																</div>	
															</div>
															<div class="panel panel-info">																	
																<div class="modal-header" style="padding-bottom: 1px;">												        
															        <table class="col-xs-12">
																		<tr>
																			<td><h4>Acceso Número de Documento:</h4></td>
																		</tr>
																	</table>
															    </div>
										        				<div class="panel-body">
																	<div class="col-xs-12" style="padding-bottom: 10px;">
																		<label for="label_bloqueo" class="col-md-3 control-label">Bloqueado?</label>     
																		<div class="col-md-3">   											                    
																			<select name="modelE_bloqueo_<?php echo $lista["td_id"];?>" id="modelE_bloqueo_<?php echo $lista["td_id"];?>" class="form-control input-sm" onchange="bloquearModalEditar(<?php echo $lista["td_id"];?>)"/>
																				<?php if ($lista["td_bloqueo"] == 'N') {?>
																				<option value="N" selected><?php echo "NO";?></option>
																				<option value="S"><?php echo "SI";?></option>
																				<?php } elseif ($lista["td_bloqueo"] == 'S'){?>
																					<option value="N"><?php echo "NO";?></option>
																					<option value="S" selected><?php echo "SI";?></option>
																				<?php }?>
																			</select> 
																		</div>									
																	</div> 	
																	<div class="col-xs-12" style="padding-bottom: 10px;">												
																		<label for="label_modelD_abreviacion" class="col-md-3 control-label">Prefijo:</label>
																		<div class="col-md-6">                            
																			<input type="text" name="text_modelE_abreviacion_<?php echo $lista["td_id"];?>" id="text_modelE_abreviacion_<?php echo $lista["td_id"];?>" value= "<?php echo utf8_encode($lista["td_abreviacion"]);?>" maxlength="150" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
																		</div>									
																	</div>
																	<div class="col-xs-12" style="padding-bottom: 10px;">												
																		<label for="label_modelD_correlativo" class="col-md-3 control-label">Correlativo:</label>
																		<div class="col-md-3">                            
																			<input type="text" name="text_modelE_correlativo_<?php echo $lista["td_id"];?>" id="text_modelE_correlativo_<?php echo $lista["td_id"];?>" value= "<?php echo utf8_encode($lista["td_correlativo"]);?>" maxlength="150" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
																		</div>									
																	</div>
																</div>
															</div>	
															<label style="color: #A4A4A4;font-size: 11px;">NOTA: En caso de especificar "SI" en el campo "bloqueado?" el "Número de Documento" 
															del formulario de "Registro Documentario" se bloqueará autogenerando un correlativo con el prefijo señalado 
															en los campos "Correlativo" y "Prefijo" respectivamente.</label>
												      	</div>
													    <div class="modal-footer">
													    	<button type="submit" name = "submit" class="btn btn-primary btn-sm">Modificar</button>	
													        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>										        
													    </div>
												      	</form>			     
												    </div>
												  </div>												 	
												</div>
												<!-- Fin Modal Editar Documento-->
                                                <?php } ?>
											</td>
											<td>
                                                <?php if($this->permisos[0]["Eliminar"] == 1) {?>
												<a href="<?php echo URLLOGICA?>mantenimiento/documento_eliminar/<?php echo $lista["td_id"];?>">
													<button type="submit" name="doc_eli" id="doc_eli" class="btn btn-default btn-xs" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></button>
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
					<!-- Modal -->
		              		<div class="modal fade" id="myModalNuevoDocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							    	<div class="modal-header" style = "height: 70px;">												        
								        <table class="col-xs-12">
											<tr>
												<td style="text-align:left;"><h4>Ingresar Nuevo Documento:</h4></td>
												<td>
													<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
											        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
								     			   	</button>
												</td>
											</tr>
										</table>
								    </div>	
							      <div class="modal-body">
							      	<div class="row">
							      		<div class="col-xs-12" style="padding-bottom: 10px;">
											<label for="label_modelD_nombre" class="col-md-4 control-label">Nombre Tipo Doc.:<span style="color: #FF0000"><strong>*</strong></span></label>
											<div class="col-md-8">                            
												<input type="text" name="text_modelD_nombre" onkeypress="return validarL(event)" id="text_modelD_nombre" maxlength="150" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
											</div>								
										</div> 						
									</div>	
									<div class="panel panel-info">	
										<div class="modal-header" style="padding-bottom: 1px;">												        
								        <table class="col-xs-12">
											<tr>
												<td><h4>Acceso Número de Documento:</h4></td>
											</tr>
										</table>
								    </div>	
				        			<div class="panel-body">
										<div class="col-xs-12" style="padding-bottom: 10px;">
											<label for="label_bloqueo" class="col-md-3 control-label">Bloqueado?</label>     
											<div class="col-md-3">   											                    
												<select name="modelN_bloqueo" id="modelN_bloqueo" class="form-control input-sm" onchange="bloquearModalNuevo()"/>
					                    			<option value="N" selected>NO</option>
													<option value="S">SI</option>
												</select>  
											</div>									
										</div> 	
										<div class="col-xs-12" style="padding-bottom: 10px;">												
											<label for="label_modelD_abreviacion" class="col-md-3 control-label">Prefijo:</label>
											<div class="col-md-6">                            
												<input type="text" name="text_modelN_abreviacion" id="text_modelN_abreviacion" maxlength="150" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
											</div>									
										</div>
										<div class="col-xs-12" style="padding-bottom: 10px;">												
											<label for="label_modelD_correlativo" class="col-md-3 control-label">Correlativo:</label>
											<div class="col-md-3">                            
												<input type="text" name="text_modelN_correlativo" id="text_modelN_correlativo" maxlength="150" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
											</div>									
										</div>
									</div>									
									</div>
									<label style="color: #A4A4A4;font-size: 11px;">NOTA: En caso de especificar "SI" en el campo "bloqueado?" el "Número de Documento" 
									del formulario de "Registro Documentario" se bloqueará autogenerando un correlativo con el prefijo señalado 
									en los campos "Correlativo" y "Prefijo" respectivamente.</label>									
							      </div>							      
							      <div class="modal-footer">
							        <button id = 'grabar_documento_modal' name = 'grabar_documento_modal' type="button" class="btn btn-primary btn-sm">Grabar</button>
							        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_nuevo()">Cancelar</button>										        
							      </div>
							      <script>
							      	$('#grabar_documento_modal').click(function(){
							      		var text_modelD_nombre = $('#text_modelD_nombre').val();
							      		var modelN_bloqueo = $('#modelN_bloqueo').val();
							      		var text_modelN_abreviacion = $('#text_modelN_abreviacion').val();
							      		var text_modelN_correlativo = $('#text_modelN_correlativo').val();
							      		$.post("<?php echo URLLOGICA?>mantenimiento/documento_grabar/", {text_modelD_nombre: text_modelD_nombre,modelN_bloqueo:modelN_bloqueo,text_modelN_abreviacion:text_modelN_abreviacion,text_modelN_correlativo:text_modelN_correlativo}, function(data, status){
									        var Data = JSON.parse(data);
									        console.log(Data);
									        alert(Data.Response);
									        location.reload();
									    });
							      	});
							      </script>
							      <!-- </form> -->
							    </div>
							  </div>
							</div>
							<!-- Fin Modal -->				
				</div>
				<div class="container-fluid text-center">
					<nav>
						<ul class="pagination pagination-sm">
							<li><a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/0" aria-label="Primero"><span>&lsaquo;&lsaquo; Primero</a></span></li>
							<?php 
								if($this->pageactual == 0){ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/0" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>	
							<?php 
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/<?php echo $this->pageactual-1;?>" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>
							<?php
								}
							?>	
							<li>									
								<?php 	
											if(count($this->objDoc) > 0){
												$pagemax = 5;
												$TotalReg= count($this->objDocT);	
												$paginas =ceil($TotalReg/5);
												if ($paginas<$pagemax){
													for($item = 0;$item<$paginas;$item++){
								?>							
									<a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
								<?php	
													}
												}else{
													
													for($item = 0;$item<$pagemax-1;$item++){?>
														
														<a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
														
													<?php
													}
													
													if($this->pageactual >= $pagemax){?>
														<a href="#">...</a>
														<a href="#"><?php echo $this->pageactual;?></a>
													<?php
													}
													if($this->pageactual < $paginas-1){?>
														<a href="#">...</a>
														<a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/<?php echo $paginas-1;?>"><?php echo $paginas;?></a>																
												<?php	}
												}
											} ?>		
							</li>	
							<?php	 
								if($this->pageactual == $paginas-1){ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/<?php echo $paginas-1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/<?php echo $this->pageactual+1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}		
							?>
							<li><a href="<?php echo URLLOGICA?>mantenimiento/tipo_documento_listar/listar/<?php echo $paginas-1;?>" aria-label="Ultimo"><span>Ultimo &rsaquo;&rsaquo;</a></span></li>	
						</ul>
					</nav>												
				</div> 		
			</div>
		</section>					
	</div>
	<script>
	$('select').select2();
		$(document).keyup(function(event){
	    	if(event.which == 27){
	    		$('.modal').modal('hide');
	        }
	  	});
	 
	 $(document).keypress(function(event) {
	    if(event.which == 13) {
	        $('#doc_buscar').click();
	    }
	});
	 
	 $('#doc_limpiar').on("click",function() {			
		$('#text_nombre_tipo_documento').val('');
		location.href ="http://intranet.peruvian.pe/STD/ES/mantenimiento/tipo_documento_listar/";	
	});
	
	function bloquearModalEditar(id) {
		var bloqueo = $('#modelE_bloqueo_'+id).val();
		if (bloqueo == 'N'){
			$('#text_modelE_abreviacion_'+id).prop('disabled','disabled');
			$('#text_modelE_correlativo_'+id).prop('disabled','disabled');			
		}else{			
			$('#text_modelE_abreviacion_'+id).prop('disabled',false);
			$('#text_modelE_correlativo_'+id).prop('disabled',false);
		}
	}
	
	function bloquearModalNuevo() {
		var bloqueo = $('#modelN_bloqueo').val();
		if (bloqueo == 'N'){
			$('#text_modelN_abreviacion').prop('disabled','disabled');
			$('#text_modelN_correlativo').prop('disabled','disabled');			
		}else{
			$('#text_modelN_abreviacion').prop('disabled',false);
			$('#text_modelN_correlativo').prop('disabled',false);
		}
	}
	
	function blanquear_campos_nuevo() {
		$('#text_modelD_nombre').val('');
		$('#text_modelN_abreviacion').val('');	
		$('#text_modelN_correlativo').val('');	
		$('#modelN_bloqueo').val('N').trigger("change");		
	}
  	
	</script>
  <?php include "footer_view.php";?>