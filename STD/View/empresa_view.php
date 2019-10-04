<?php include "header_view.php";?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Mantenimiento<small>Empresa</small></h1>
			<ol class="breadcrumb">
				<li><a><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li>
				<li class="active">Empresa</li>
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
							<form method="post" action="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/0" onsubmit="document.forms['buscar']['empresa_buscar'].disabled=true;" name="buscar">							
								<div class="row">
									<div class="col-xs-10" style="margin-bottom: 5px;">
										<label for="label_ruc" class="col-md-1 control-label">R.U.C.:</label>
										<div class="col-md-3">                            
											<input type="text" name="text_ruc" id="text_ruc" value="<?php echo $_SESSION['text_ruc_bus'];?>" maxlength="11" class="form-control input-sm">
										</div>	
										<label for="label_razon_social" class="col-md-2 control-label">Razón Social:</label>
										<div class="col-md-6" >
											<input type="text" name="text_razon_social" id="text_razon_social" value="<?php echo $_SESSION['text_razon_social_bus'];?>" maxlength="200" class="form-control input-sm" style="text-transform: uppercase;">
										</div>
					        		</div>
					        		<div class="col-md-2" style="text-align:right;">
			                            <div class="btn-group">
			                            	<button type="button" name="empresa_limpiar" id="empresa_limpiar" class="btn btn-default btn-sm pull-right">Limpiar <i class="glyphicon glyphicon-eraser"></i></button>			                            
			                            </div>
			                            <div class="btn-group">
			                            	<button type="submit" name="empresa_buscar" id="empresa_buscar" value="Buscar" class="btn btn-default btn-sm pull-right">Buscar <i class="glyphicon glyphicon-search"></i></button>
										</div>	
									</div>	
					        	</div> 
				        	</form>
						</div>
			     	</div>
			     	<div id="MainContent_listaPro" class="panel panel-info">
			  			<div class="panel-heading clearfix">
			      			<span id="MainContent_tituloPro"><strong>Listar Empresas</strong></span>
                            <?php if($this->permisos[0]["Agregar"] == 1){?>
			      			<button data-toggle="modal" data-target="#myModalNuevoEntidad" type="button" name="emp_nuevo" id="emp_nuevo" class="btn btn-default btn-sm pull-right">Nuevo <i class="glyphicon glyphicon-file"></i></button>
                            <?php }?>
                            <!-- Modal -->
		              		<div class="modal fade" id="myModalNuevoEntidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							    	<div class="modal-header" style = "height: 70px;">												        
								        <table class="col-xs-12">
											<tr>
												<td style="text-align:left;"><h4>Ingresar Nueva Empresa</h4></td>
												<td>
													<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
											        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
								     			   	</button>
												</td>
											</tr>
										</table>
								    </div>
							      <!-- <form name="formularioModalEmpresa" method="post" action="<?php echo URLLOGICA?>mantenimiento/empresa_grabar/"> -->
							      <div class="modal-body">
							      	 <div class="row">
							      	 	<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelE_razon_social" class="col-md-3 control-label">Razón Social:<span style="color: #FF0000"><strong>*</strong></span></label>
											<div class="col-md-9">                            
												<input type="text" id = 'text_modelE_razon_social' name="text_modelE_razon_social"maxlength="200" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" required/>
											</div>									
										</div> 
							      	 	<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelE_ruc" class="col-md-3 control-label">R.U.C.:</label>
											<div class="col-md-4">                            
												<input type="text" id ='text_modelE_ruc' name="text_modelE_ruc" maxlength="11" class="form-control input-sm number" oninput="validarInput(this)" style="text-transform: uppercase; width: 100% !important;"/>
											</div>									
										</div>							      												 
										<div class="col-xs-12" style="margin-bottom: 10px;">
											<label for="label_modelE_tipo" class="col-md-3 control-label">Tipo:<span style="color: #FF0000"><strong>*</strong></span></label>
											<div class="col-md-4">                            
												<select name="option_modalE_tipo" id="option_modalE_tipo" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;" required>
					                    			<option value="E">Externo</option>						                    		
												</select> 
											</div>								
										</div> 
									</div>
							      </div>
							      <div class="modal-footer">
							        <!-- <button id = 'grabar_empresa_modal' name = 'grabar_empresa_modal' type="submit" class="btn btn-primary btn-sm">Grabar</button> -->
							        <button id = 'grabar_empresa_modal' name = 'grabar_empresa_modal' type="button" class="btn btn-primary btn-sm">Grabar</button>
							        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_empresa()">Cancelar</button>										        
							      </div>
							      <script>
							      	$('#grabar_empresa_modal').click(function(){
							      		var text_modelE_razon_social = $('#text_modelE_razon_social').val();
							      		var text_modelE_ruc = $('#text_modelE_ruc').val();
							      		var option_modalE_tipo = $('#option_modalE_tipo').val();
							      		$.post("<?php echo URLLOGICA?>mantenimiento/empresa_grabar/", {text_modelE_razon_social: text_modelE_razon_social,text_modelE_ruc:text_modelE_ruc,option_modalE_tipo:option_modalE_tipo}, function(data, status){
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
			       		<div class="area_resultado table-responsive">
							<table class="table" cellspacing="0" cellpadding="1" id="MainContent_datResPro" style="font-size: 11px;border-color:Silver;border-width:1px;border-style:solid;border-collapse:collapse;">
								<tr style="color:White;background-color:DimGray;font-weight:bold;">
									<th scope="col">Código</th>
									<th scope="col">R.U.C.</th>
									<th scope="col">Razón Social</th>
									<th scope="col">Estado</th>
									<th scope="col">Editar</th>
									<th scope="col">Eliminar</th>
								</tr>	
								<?php if (count($this->objEmpresa) > 0) {
										$item = 1;
										foreach ($this->objEmpresa as $lista) { ?>
										<tr>
											<td style="width:25%;"><?php echo $lista["emp_id"];?></td>
											<td style="width:35%;"><?php echo utf8_encode($lista["emp_ruc"]);?></td>
											<td style="width:35%;"><?php echo utf8_encode($lista["emp_razonsocial"]);?></td>
											<td style="width:20%;"><?php if ($lista["emp_estado"] == 1) { echo "ACTIVO"; } elseif ($lista["emp_estado"] == 0) { echo INACTIVO; } ?></td>
											<td>
                                                <?php if($this->permisos[0]["Modificar"] == 1){?>
												<button data-toggle="modal" data-target="#myModalEditEmp_<?php echo $lista["emp_id"];?>" type="submit" name="emp_edit" id="emp_edit" class="btn btn-default btn-xs" title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
												<?php }?>
                                                <!-- Inicio Modal Editar Empresa -->
							              		<div class="modal fade" id="myModalEditEmp_<?php echo $lista["emp_id"];?>" role="dialog" aria-labelledby="myModalLabel">
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
													  		<form method="post" action="<?php echo URLLOGICA?>mantenimiento/emp_update/<?php echo $lista["emp_id"];?>">					      	
											      			<div class="modal-body">	
												      	 		<div class="row">	
												      	 			<div class="col-xs-12" style="margin-bottom: 10px;">
																		<label for="label_modelE_razon_social" class="col-md-3 control-label">Razón Social:<span style="color: #FF0000"><strong>*</strong></span></label>
																		<div class="col-md-9">                            
																			<input type="text" name="text_modelE_razon_social" id = 'text_modelE_razon_social' value= "<?php echo utf8_encode($lista["emp_razonsocial"]);?>" maxlength="200" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" required/>
																		</div>									
																	</div> 
														      	 	<div class="col-xs-12" style="margin-bottom: 10px;">
																		<label for="label_modelE_ruc" class="col-md-3 control-label">R.U.C.:</label>
																		<div class="col-md-4">                            
																			<input type="text" name="text_modelE_ruc" id ='text_modelE_ruc' value= "<?php echo utf8_encode($lista["emp_ruc"]);?>" maxlength="11" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
																		</div>									
																	</div>	
																	<div class="col-xs-12" style="margin-bottom: 10px;">
																		<label for="label_prioridad" class="col-md-3 control-label">Tipo:<span style="color: #FF0000"><strong>*</strong></span></label>
																		<div class="col-md-3">                            
																			<select name="modelE_emp_tipo" id="modelE_emp_tipo" class="form-control input-sm" style="width: 100% !important;">
																					<?php if ($lista["emp_tipo"] == "I") {?>
																						<option value="I" selected><?php echo "INTERNO";?></option>
																						<option value="E"><?php echo "EXTERNO";?></option>
																					<?php } elseif ($lista["emp_tipo"] == "E"){?>
																						<option value="I"><?php echo "INTERNO";?></option>
																						<option value="E" selected><?php echo "EXTERNO";?></option>
																					<?php }?>
																			</select>
																		</div>								
																	</div>							      												 
																	<div class="col-xs-12" style="margin-bottom: 10px;">
																		<label for="label_prioridad" class="col-md-3 control-label">Estado:</label>
																		<div class="col-md-3">                            
																			<select name="modelE_emp_estado" id="modelE_emp_estado" class="form-control input-sm" style="width: 100% !important;">
																					<?php if ($lista["emp_estado"] == 1) {?>
																						<option value="1" selected><?php echo "ACTIVO";?></option>
																						<option value="0"><?php echo "INACTIVO";?></option>
																					<?php } elseif ($lista["emp_estado"] == 0){?>
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
														        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_empresa()">Cancelar</button>										        
												      		</div>
												      		</form>						     
												   		</div>
												  	</div>
												</div>
												<!-- Fin Modal Editar Area-->
											</td>
											<td>
                                                <?php if($this->permisos[0]["Eliminar"] == 1){?>
												<a href="<?php echo URLLOGICA?>mantenimiento/empresa_eliminar/<?php echo $lista["emp_id"];?>">
													<button type="submit" name="emp_eli" class="btn btn-default btn-xs" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></button>
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
					<nav>
						<ul class="pagination pagination-sm">
							<li><a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/0" aria-label="Primero"><span>&lsaquo;&lsaquo; Primero</a></span></li>
							<?php 
								if($this->pageactual == 0){ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/0" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>	
							<?php 
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/<?php echo $this->pageactual-1;?>" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>
							<?php
								}
							?>
							<li>									
								<?php 	
										if(count($this->objEmpresa) > 0){
											$pagemax = 5;
											$TotalReg= count($this->objEmpresaT);	
											$paginas =ceil($TotalReg/5);
											if ($paginas<$pagemax){
												for($item = 0;$item<$paginas;$item++){
								?>							
									<a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
								<?php	
													}
												}else{
													
													for($item = 0;$item<$pagemax-1;$item++){?>
														
														<a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/<?php echo $item;?>"><?php echo $item+1;?></a>
														
													<?php
													}
													
													if($this->pageactual >= $pagemax){?>
														<a href="#">...</a>
														<a href="#"><?php echo $this->pageactual;?></a>
													<?php
													}
													if($this->pageactual < $paginas-1){?>
														<a href="#">...</a>
														<a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/<?php echo $paginas-1;?>"><?php echo $paginas;?></a>																
												<?php	}
												}
											} ?>		
							</li>
							<?php	 
								if($this->pageactual == $paginas-1){ ?>	
									<li><a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/<?php echo $paginas-1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/<?php echo $this->pageactual+1;?>" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}		
							?>
							<li><a href="<?php echo URLLOGICA?>mantenimiento/empresa_listar/listar/<?php echo $paginas-1;?>" aria-label="Ultimo"><span>Ultimo &rsaquo;&rsaquo;</a></span></li>	
						</ul>
					</nav>												
				</div>
			</div>
		</section>					
	</div>
<script >
$('select').select2();

$(document).keyup(function(event){
	if(event.which==27){
		$('.modal').modal('hide');
    }
});

$(document).keypress(function(event) {	
    if(event.which == 13) {
        $('#empresa_buscar').click();
    }
});

$("#empresa_limpiar").on("click",function() {	
	$("#text_ruc").val('');
	$("#text_razon_social").val('');
	location.href ="http://intranet.peruvian.pe/STD/ES/mantenimiento/empresa_listar/";	
});

$("button[name='grabar_empresa_modal']").on("click",function(){
	var ruc = $("input[name='text_modelE_ruc']").val();
	var entidad = $("input[name='text_modelE_razon_social']").val();
	var tipo = $("input[name='option_modalE_tipo']").val();
	if($("input[name='text_modelE_razon_social']").val() == ''){
		alert("Favor de ingresar el nombre de la Entidad");
	}
});	

function blanquear_campos_empresa() {
	$('#text_modelE_ruc').val('');
	$('#grabar_empresa_modal').prop('disabled',false);
	$('#text_modelE_razon_social').val('');
}

function validarInput(input) {
    var ruc = input.value.replace(/[-.,[\]()\s]+/g,""),valido;
        
    //Es entero?    
    if ((ruc = Number(ruc))) { // ⬅️ ⬅️ ⬅️ ⬅️ Acá se comprueba
    	$('#grabar_entidad_modal').prop('disabled',false);
    	valido = "Válido";
          
    } else {
    	$('#grabar_entidad_modal').prop('disabled','disabled');
        valido = "No válido";    	
    }
}
</script>
<?php include "footer_view.php";?>