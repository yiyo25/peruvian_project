<?php include "header_view.php";?>
<div class="preloader" id="preloader"></div>
<div class="content-wrapper">	
	<section class="content-header" style="padding:5px;">		
		<h1>Edición de Registro</h1>		
	</section>
	<section name="contenedor" class="content" style="padding:1px;">		
		<div class='box box-danger'>			
			<form id="form" name="form">
		  	<div class="box-header" style="padding:5px;">
				<div class="col-xs-12">					
					<label class="col-md-2 control-label" for="label_num_doc">Número de Registro:</label>
					<div class="col-md-4">
						<select name="select_num_doc" id="select_num_doc" class="form-control input-sm" style="width: 100% !important;">
                			<option value="" selected>SELECCIONE DOCUMENTOS</option>
                    		<?php foreach ($this->objTramU as $listaTram) {?>
								<option value="<?php echo $listaTram["tramseg_id"];?>"><?php echo utf8_encode($listaTram["tram_nro_doc"]);?></option>
							<?php } ?>
						</select>
						<input type="hidden" name="nro_tramite" id="nro_tramite" />
					</div>											
				</div>
		  	</div>
			<div class="box-body">
				<div id="MainContent_Div1" class="panel panel-info">
					<div class="panel-heading" style="padding:1px;">
						<h2 class="panel-title">Datos del Documento:</h2>											
					</div>	
					<div style='padding: 3px;'> 
						<div class="row">							
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_tip_doc_reg">Tipo de Documento:<span style="color: #FF0000"><strong>*</strong></span></label>
								<div class="col-md-4">
									<select name="td_id" id="td_id" class="form-control input-sm" style="width: 100% !important;" onchange="activar_campo()" requerid>
		                    			<option value="init" selected>SELECCIONE DOCUMENTOS</option>
			                    		<?php foreach ($this->objDoc as $listaDoc) {?>
											<option value="<?php echo $listaDoc["td_id"];?>"><?php echo utf8_encode($listaDoc["td_descripcion"]);?></option>
										<?php } ?>
									</select>
								</div>
								<label class="col-md-2 control-label" for="label_nro_documento_reg">Número del Documento:<span style="color: #FF0000"><strong>*</strong></span></label>
								<div class="col-md-4">                            
									<input type="text" name="text_nro_documento_reg" id ="text_nro_documento_reg" maxlength="50" class="form-control input-sm" style="text-transform: uppercase;width: 100% !important;" required>
									<input type="hidden" name="hidden_documento" id ="hidden_documento" class="form-control input-sm">
									<input type="hidden" name="hidden_bloqueo" id ="hidden_bloqueo" class="form-control input-sm">
									<input type="hidden" name="hidden_identificador" id ="hidden_identificador" class="form-control input-sm">
								</div>								
							</div>
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_fecha_doc">Fecha del Documento:</label>
								<div class="col-md-4" >												
									<div class="input-group">
		                                <input class="form-control datepicker" type="text" name="text_fecha_doc" id="text_fecha_doc" data-date-format="dd/mm/yyyy" onchange="Fecha_Documento()">
		                                <div class="input-group-addon">
		                                    <span class="glyphicon glyphicon-calendar"></span>
		                                </div>
		                            </div>
	                            </div>	
								<label class="col-md-2 control-label" for="label_fecha_tramite">Fecha de Recepción:</label>
								<div class="col-md-4" >												
									<div class="input-group">									
		                                <input type="text" name="text_fecha_tramm" readonly="readonly" id="text_fecha_tramm" class="form-control datepicker" data-date-format="dd/mm/yyyy" disabled>
		                                <input type="hidden" name="text_fecha_tram" id="text_fecha_tram" class="form-control datepicker" data-date-format="dd/mm/yyyy">
		                                <div class="input-group-addon">
		                                    <span class="glyphicon glyphicon-calendar"></span>
		                                </div>
		                            </div>
	                            </div>										
				            </div>
				            <div class="col-md-12" style="margin-bottom: 4px;">    	              
			                	<label class="col-md-2 control-label" for="label_asunto_reg">Doc.Referencia:</label>
								<div class="col-md-3" >	
									<input type = 'text' name = "doc_referencia" id = "doc_referencia"  class="form-control input-sm" disabled>
									<input type = 'hidden' name = "hidden_doc_referencia" id = "hidden_doc_referencia">
									<input type = 'hidden' name = "hidden_tipo_referencia" id = "hidden_tipo_referencia">
								</div>
	                            <div class= "col-md-1"> 
			          				<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalBuscarReferencia" type="button" name="buscar_referencia" id="buscar_referencia" title="Documento Referencia"><i class="glyphicon glyphicon-search"></i></button>
			          				<button class="btn btn-default btn-sm" type="button" name="limpiar_referencia" id="limpiar_referencia" title="Limpiar"><i class="glyphicon glyphicon-erase"></i></button>
								</div>			                   			                   	
				        	</div>
					        <!-- Inicio Modal Documento Referencia-->
							<div id="myModalBuscarReferencia" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document" style = "width:1200px;">
							    	<div class="modal-content">
							    		<div class="modal-header" style = "height: 70px;">												        
									        <table class="col-xs-12">
												<tr>
													<td style="text-align:left;"><h4>Buscar Documento:</h4></td>
													<td>
														<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
												        	<span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
									     			   	</button>
													</td>
												</tr>
											</table>
									    </div>
							      		<div class="modal-body" style="padding: 20px;">
							      			<div class="row">												      				
							      				<div class="col-xs-12" style="margin-bottom: 5px;">
													<label class="col-md-2 control-label" for="label_nro_doc">Número Documento:</label>
													<div class="col-md-2">                            
														<input type="text" name="text_nro_doc" id="text_nro_doc" maxlength="50" class="form-control input-sm" value="<?php if(isset($_SESSION['text_nro_doc_bus'])){ echo $_SESSION['text_nro_doc_bus'];} ?>"/>
													</div>
													<label class="col-md-2 control-label" for="label_tip_doc">Tipo de Documento:</label>
													<div class="col-md-2">  
														<select name="tip_doc" id="tip_doc" class="form-control input-sm" style="width: 100%;"> 
															<option value="" selected><?php if(isset($_SESSION['tip_doc_bus']) ){ echo $_SESSION['tip_doc_bus'];}?></option>
								                    		<?php foreach ($this->objDoc as $listaDoc) {?>
																<option value="<?php echo $listaDoc["td_descripcion"];?>"><?php echo utf8_encode($listaDoc["td_descripcion"]);?></option>													
															<?php } ?>	
														</select>
													</div>	
													<label for="label_nro_doc" class="col-md-2 control-label">Estado:</label>     
													<div class="col-md-2">   											                    
														<select name="tram_estado" id="tram_estado" class="form-control input-sm" style="width: 100%;">
							                    			<option value="" selected><?php if(isset($_SESSION['estado_bus'])){ echo $_SESSION['estado_bus'];}?></option>
								                    		<option value="Recibido">RECIBIDO</option>
															<option value="Derivado">DERIVADO</option>
															<option value="Transito">TRANSITO</option>
															<option value="Concluido">CONCLUIDO</option>
															<option value="Concluido Automatico">CONCLUIDO AUTOMATICO</option>
														</select>  
													</div>								
												</div>	
												<div class="col-xs-12" style="margin-bottom: 5px;">
												<label class="col-md-2 control-label" for="label_fec_ini">Fecha Inicial:</label>
												<div class="col-md-2" >												
													<div class="input-group">
						                                <input type="text" name="text_fec_ini" id="text_fec_ini" class="form-control datepicker" data-date-format="dd/mm/yyyy" value="<?php if(isset($_SESSION['text_fec_ini_bus'])){ echo $_SESSION['text_fec_ini_bus'];}?>"/>
						                                <div class="input-group-addon">
						                                    <span class="glyphicon glyphicon-calendar"></span>
						                                </div>
						                            </div>
					                            </div>	
												<label for="label_fec_fin" class="col-md-2 control-label">Fecha Fin:</label>
												<div class="col-md-2">												
													<div class="input-group">
						                                	<input type="text" name="text_fec_fin" id="text_fec_fin" class="form-control datepicker" data-date-format="dd/mm/yyyy" value="<?php if(isset($_SESSION['text_fec_fin_bus'])){ echo $_SESSION['text_fec_fin_bus'];}?>"/>
						                               	<div class="input-group-addon">
						                                    <span class="glyphicon glyphicon-calendar"></span>
						                                </div>
						                            </div>
					                            </div>
					                            <div class="col-md-4" style="text-align:right;">
						                            <div class="btn-group">
						                            	<button type="button" name="referencia_limpiar" id="referencia_limpiar" value="Limpiar" class="btn btn-default btn-sm pull-right">Limpiar <i class="glyphicon glyphicon-eraser"></i></button>			                            
						                            </div>
						                            <div class="btn-group">
						                            	<button type="button" name="referencia_buscar" id="referencia_buscar" value="Buscar" class="btn btn-default btn-sm pull-right">Buscar <i class="glyphicon glyphicon-search"></i></button>
													</div>	
												</div>								
											</div>
							     		 </div>							     		 
							     		 <div class="panel panel-info">	
												<div class="panel-heading" style = "height: 35px;width: 1158px;padding:5px;">	
													<h5><strong>Listado de Documentos</strong></span></h5>
												</div>
								        		<div id="panel_body_referencia" style = "width: 1158px">
								        			<table class="table table-hover">
								        				<thead>
									        				<tr>
									        					<th bgcolor="#BAF5C1" style="text-align:center;width: 10%";>Fecha de Registro</th>
																<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Número Documento</th>
																<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Tipo de Documento</th>																			  	
															  	<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Descripción Documento</th>
															  	<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Remitente</th>
															  	<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Estado Actual</th>		  																				  	
															</tr>	
														</thead>																									
														<tbody id="linea_seg"></tbody>	
													</table>													
												</div>																
											</div>	
							     		 
									     <div class="modal-footer">
									     	<button name ="cerrar_referencia" id ="cerrar_referencia" type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>										        
									     </div>
									</div>
								</div>
				   			</div>
				   			<!-- Fin Modal Documento-->
		        		</div>
				            <div class="col-xs-12" style="margin-bottom: 4px;">
		                   		<label class="col-md-6 control-label" for="label_asunto_reg">Asunto:<span style="color: #FF0000"><strong>*</strong></span></label>
		                   		<div class="col-md-3">
	                   			<div class="btn btn-default btn-sm btn-file">
		                   			<i class="glyphicon glyphicon-folder-open"></i>&nbsp;
		                   				<span class="hidden-xs">Browse …</span>
		                   				<input id="file" name="file" class="file" multiple="" type="file">
		                   		</div>
	                   		</div>			                   		
		               		</div>
		                	<div class="col-md-12" style="margin-bottom: 4px;">    	              
			                	<div class="col-md-6">
									<textarea name="text_asunto_reg" id="text_asunto_reg" maxlength="450" rows="4" cols="30" class="form-control input-sm" style="text-transform: uppercase;height:45px;resize:none" required></textarea>
								</div>
							<div class="col-md-6">
								<textarea name="textarea_file" maxlength="450" rows="2" cols="30" class="form-control input-sm" style="text-transform: uppercase;height:45px;resize:none" disabled></textarea>
								<input type="hidden" name="filecomplete" id="filecomplete"/>
		                   	</div>		                   			                   	
				        </div>         
			        	</div> 
		        	</div>
		        </div>
	        	<div id="MainContent_Div2" class="panel panel-info"> 
			     	<div class="panel-heading" style="padding:1px;">
						<h2 class="panel-title">Datos del Remitente:</h2>											
					</div>
					<div style="padding:3px;"> 
						<div class="row">
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label"for="label_tip_ent_reg">Origen de Entidad:<span style="color: #FF0000"><strong>*</strong></span></label>
								<div class="col-md-2">                            
									<input   type= "radio" name= "tip_entidad" value= "E" checked> Externo
									<input   type= "radio" name= "tip_entidad" value="I"> Interno	
									<input type="hidden" name="tip_entidadd" id="tip_entidadd"/>								
								</div>									
							</div>
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_nom_entidad">Nombre de Entidad:<span style="color: #FF0000"><strong>*</strong></span></label>
								<div class="col-md-4">                            
									<select name="emp_idd" id="emp_idd" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100%;" required>
		                    			<option value="init" selected>SELECCIONE ENTIDAD</option>
			                    		<?php foreach ($this->objEnt as $listaEntidad) {?>
											<option value="<?php echo $listaEntidad["emp_id"];?>"><?php echo utf8_encode($listaEntidad["emp_razonsocial"]);?></option>
										<?php } ?>
									</select>	
									<input type="hidden" name="emp_id" id="emp_id" class="form-control input-sm"/>							
								</div>
								<label class="col-md-2 control-label" for="label_nom_contacto">Nombre Contacto:</label>              
			                   	<div class="col-md-4">                            
									<select name="contac_id" id="contac_id" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;" method="POST">
		                    			<option value="init" selected>SELECCIONE CONTACTO</option>
									</select>		
									<input type = 'hidden' name = "usu_nombre" id = "usu_nombre">
									<input type = 'hidden' name = "usu_correo" id = "usu_correo">
									<input type = 'hidden' name = "usu_numdoc" id = "usu_numdoc">										
								</div>
				            </div>
				            <div class="col-xs-12" style="margin-bottom: 4px;">
					        	<label class="col-md-2 control-label" for="label_area_contacto">Área Contacto:</label>
								<div class="col-md-4" >                            
									<input type = 'text' name = "area_descripcion" id = "area_descripcion" class="form-control input-sm" style="text-transform: uppercase;width:100%;" disabled>
									<input type = 'hidden' name = "area_descripcion1" id = "area_descripcion1">
									<input type = 'hidden' name = "area_id" id = "area_id">	
								</div>	
								<label class="col-md-2 control-label" for="label_cargo_contacto">Cargo del Contacto:</label>
								<div class="col-md-4">                            
									<input type = 'text' name = "cargo_descripcion" id = "cargo_descripcion" class="form-control input-sm" style="text-transform: uppercase;width:100%;" disabled>
									<input type = 'hidden' name = "cargo_descripcion1" id = "cargo_descripcion1">
									<input type = 'hidden' name = "cargo_id" id = "cargo_id">
								</div> 			        	
					        </div>					        
			        	</div>	
		        	</div>			  				
				</div>	
				<div id="MainContent_Div3" class="panel panel-info"> 
				<div style="padding:3px;"> 
					<div class="row">
					<!-- Datos que no son de remitente -->
						<div class="col-xs-12" style="margin-bottom: 4px;">				        	
							<label class="col-md-1 control-label" for="label_prioridad">Prioridad:<span style="color: #FF0000"><strong>*</strong></span></label>
							<div class="col-md-2">                            
								<select name="estado" id="estado" class="form-control input-sm" style="width: 100% !important;" onchange="Activar_Fecha()">
										<option value="" selected>ELIJA PRIORIDAD</option>
										<option value="N">Normal</option>
										<option value="U">Urgente</option>
								</select>
							</div>	
							<label class="col-md-2 control-label" for="label_fecha_resp">Fecha de Respuesta:</label>
							<div class="col-md-2">												
								<div class="input-group">
									
				                    <input type="text" name="text_fecha_resp" id="text_fecha_resp" class="form-control datepicker" data-date-format="dd/mm/yyyy" onchange="Fecha_Respuesta()" disabled/>
				                    <div class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </div>
				                </div>
				            </div>
				            <label class="col-md-1 control-label" for="label_copia">Con Copia:</label><input type="checkbox" name="checkCopia" id="checkCopia">
							<div class="col-md-3" > 					
								<input class="form-control input-sm" type = 'text' name = "copia" id = "copia" disabled>
								<input type = 'hidden' name = "copia_hidden" id = "copia_hidden">
							</div>
						</div>
					</div>
				</div>
			</div>
            <?php if($this->permisos[0]["Agregar"]){ ?>
			<div class="col-xs-12">
				<button type="button" name="reg_editar" id="reg_editar" class="btn btn-default pull-right">Grabar</button>
			</div>
            <?php } ?>
				</form>
			</div>
		</div>	
	</section>
</div>
<!-- ModalAlerta1Inicio -->
<div id="myModalAlerta1" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
    		<div class="modal-header" padding:"5px;">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h3>Alerta</h3>
	     	</div>
      		<div class="modal-body">
	            La Fecha Ingresada es mayor que la fecha de trámite, favor de ingresar otra fecha.
     		</div>
     		<div class="modal-footer">
		        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
		    </div>
		</div>
	</div>
</div>
<!-- ModalAlerta1Fin -->
<!-- ModalAlerta2Inicio -->
<div id="myModalAlerta2" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
    		<div class="modal-header" padding:"5px;">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h3>Alerta</h3>
	     	</div>
      		<div class="modal-body">
	            La Fecha de Respuesta ingresada tiene que ser mayor o igual que la fecha de Tramite.
     		</div>
     		<div class="modal-footer">
		        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
		    </div>
		</div>
	</div>
</div>
<!-- ModalAlerta2Fin -->
<!-- ModalAlerta3Inicio -->
<div id="myModalAlerta3" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
    		<div class="modal-header" padding:"5px;">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h3>Actualización</h3>
	     	</div>
      		<div class="modal-body">
	            Se realizó la actualización del registro
     		</div>
     		<div class="modal-footer">
		        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
		    </div>
		</div>
	</div>
</div>
<!-- ModalAlerta3Fin -->
<!-- ModalAlerta4Inicio -->
<div id="myModalAlerta4" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
    		<div class="modal-header" padding:"5px;">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h3>Alerta</h3>
	     	</div>
      		<div class="modal-body">
	            Documento Urgente, ingresar una fecha de respuesta,e indicar si se le va a enviar un correo de copia (de ser necesario).
     		</div>
     		<div class="modal-footer">
		        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
		    </div>
		</div>
	</div>
</div>
<!-- ModalAlerta4Fin -->
<!-- ModalAlerta5Inicio -->
<div id="myModalAlerta5" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
    		<div class="modal-header" padding:"5px;">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h3>Alerta</h3>
	     	</div>
      		<div class="modal-body">
	            Tiene que ingresar un contacto para registrar el documento.
     		</div>
     		<div class="modal-footer">
		        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
		    </div>
		</div>
	</div>
</div>
<!-- ModalAlerta5Fin -->
<script>	
$('select').select2();

$(function(){	
	var nro_tramite = $('#nro_tramite').val();
	if 	(nro_tramite == '') {
		$('#limpiar_referencia').prop('disabled',true);
		$('#buscar_referencia').prop('disabled',true);
	}else{
		$('#limpiar_referencia').prop('disabled',false);
		$('#buscar_referencia').prop('disabled',false);
	}	
});	

$(window).keypress(function(e) {
    if(e.keyCode == 13) {
        $('#referencia_buscar').click();
    }
});

$("input[id='file']").on("change",function(){
	var ruta = $(this).val();	
	var archivo = ruta.substring(12,ruta.length);	
	
	$("#filecomplete").val(archivo).trigger("change");	
	$("textarea[name='textarea_file']").val(archivo).trigger("change");
});


$(function(){	
	var tipoEnt = $( "input[name='tip_entidad']").val();
	if(tipoEnt == "E") {
		$("input[name='radio_tip_contacE']").val('E').trigger("change");
		$("input[name='radio_tip_contacE']").prop("checked", true);
		$("input[name='radio_tip_contacI']").prop("checked", false);
		$('#modal_empresaa').val("init").trigger("change");
		$('#modal_empresaa').prop("disabled", false);
	}
	$( "input[name='tip_entidad']").on("change",function() {		
		var tipoEnt = $(this).val();
		if(tipoEnt == "I") {		
			$("input[name='radio_tip_contacI']").val('I').trigger("change");
			$("input[name='radio_tip_contacE']").prop("checked", false);
			$("input[name='radio_tip_contacI']").prop("checked", true);	
			$('#modal_empresaa').val("1").trigger("change");
			$('#modal_empresaa').prop("disabled", true);			
		}else{
			$("input[name='radio_tip_contacE']").val('E').trigger("change");	
			$("input[name='radio_tip_contacE']").prop("checked", true);	
			$("input[name='radio_tip_contacI']").prop("checked", false);
			$('#modal_empresaa').val("init").trigger("change");
			$('#modal_empresaa').prop("disabled", false);
		}			
	});	
		
});	
$( "input[name='tip_entidad']").on("change",function() {
	var tipo_contacto = $(this).val();	
	if(tipo_contacto == "I") {
		$('#tip_entidadd').val(tipo_contacto).trigger("change");
		$('#emp_idd').val("1").trigger("change");
		$('#emp_idd').prop("disabled", true);
		$('#contac_id').val("init").trigger("change");		
		$('#nueva_entidad').prop("disabled", true);	
	}else {
		$('#tip_entidadd').val(tipo_contacto).trigger("change");
		$('#emp_idd').val("init").trigger("change");
		$('#emp_id').val("").trigger("change");
		$('#emp_idd').prop("disabled", false);
		$('#contac_id').val("init").trigger("change");
		$('#nueva_entidad').prop("disabled", false);
	}			
});


$("select[name=emp_idd]").on("change",function() {
	var empresa_id = $(this).val();
	$('input[name=emp_id]').val(empresa_id);
		filtrar_contacto(empresa_id);	
});


function filtrar_contacto(empresa_id) {
	 var contac_id = $('#contac_id').select2({
	  	ajax: {
		    url: '../registro/lista_contacto_pull',
		    method: "POST",
		    // data: { empresa: empresa_id},
		    data: function(params){
		    	return {
		    		q: params.term,
		    		empresa: empresa_id		    		
		    	};
		    },
		    dataType: 'json',
		    delay: 250,
		    processResults: function (data,params) {
		    	var data_filter_items = new Array();
		    	for(var i=0;i<data.items.length;i++){
		    		if(data.items[i].text.indexOf(params.term.toUpperCase()) !== -1){
		    		
					data_filter_items.push({id:data.items[i].id,text:data.items[i].text});
		    		}
		    	}
		    	console.log(data_filter_items);
		      	return {
		       		results: data_filter_items
			    };
		    }
		 }
	});			
}

function combo_contacto_listar(tipo,contactram_id) {
	$('#contac_id').html('');	
	$.ajax({
		url: "../registroEdit/combo_contacto_listar",
        method: 'POST',
        data: { tipo: tipo},
        dataType: 'json', 
        }).done(function( data ) { 
        	if(tipo == 'E'){
        		for(var i = 0; i<data.length;i++){        			
        			var opt = data[i];
	        	$('#contac_id').append('<option value="'+opt["contac_id"]+'">'+opt["contac_nombre"]+'</option>');
		  		}
				$('#contac_id').val(contactram_id).trigger("change");
		  	}else{
        		for(var i = 0; i<data.length;i++){        			
        			var opt = data[i];
 				$('#contac_id').append('<option value="'+opt["contac_id"]+'">'+opt["contac_nombre"]+'</option>');
 				}
 				$('#contac_id').val(contactram_id).trigger("change"); 
        	}         	       	
	});
}


$("select[name=contac_id]").on("change",function() { 
	var contac_id = $(this).val();
	var empresa_id = $('input[name=emp_id]').val();
	pull_area_cargo(contac_id,empresa_id);				
});		

function pull_area_cargo(id_contacto,empresa_id) {
	$.ajax({
	  method: "POST",
	  url: "../registroEdit/lista_area_contacto",
	  data: { contacto: id_contacto, empresa:empresa_id},
	  //dataType: 'json',
	}).done(function( data ) {
		if(!data || data.length==0){
			return false;
		}
		console.log(id_contacto);
	    console.log(empresa_id);		
	    console.log( data[0].areatrab_id );
	    console.log( data[0].cargocontac_id );	
		
	    $('#usu_nombre').val(data[0].contac_nombre);
	    $('#area_id').val(data[0].areatrab_id);
	    $('#area_descripcion').val(data[0].area_descripcion);
	    $('#area_descripcion1').val(data[0].area_descripcion);
	    $('#area_descripcion').prop("disabled", true);
	    $('#cargo_id').val(data[0].cargocontac_id);
	    $('#cargo_descripcion').val(data[0].cargo_descripcion);
	    $('#cargo_descripcion1').val(data[0].cargo_descripcion);
	    $('#cargo_descripcion').prop("disabled", true);
	    $('#usu_correo').val(data[0].usu_correo);
	    $('#usu_numdoc').val(data[0].usu_numdoc);
	});
} 

$("select[name='select_num_doc']").on("change",function() {
	var num_tram = $(this).val();
	$("input[name='nro_tramite']").val(num_tram);	
	$('#limpiar_referencia').prop('disabled',false);
	$('#buscar_referencia').prop('disabled',false);
	cargar_datos(num_tram);		
});

function cargar_datos(num_tram) {
	$.ajax({	
	  method: "POST",
	  url: "../registroEdit/tramites/",	
	  data: { num_tram: num_tram},
	  dataType: 'json',
	}).done(function( data ) {		
	    console.log(data[0].tram_nro_doc);
	    $('#text_nro_documento_reg').val(data[0].tram_nro_doc);
	    $('#hidden_documento').val(data[0].tram_nro_doc);
	    console.log(data[0].FechaDoc);
	    $('#text_fecha_doc').val(data[0].FechaDoc);
	    console.log(data[0].Fecha);
	    $('#text_fecha_tram').val(data[0].Fecha);
	    $('#text_fecha_tramm').val(data[0].Fecha);	    
	    console.log(data[0].td_id);
	    $('#td_id').val(data[0].td_id).trigger("change");
	    console.log(data[0].tram_asunto);
	    $("textarea[name='text_asunto_reg']").val(data[0].tram_asunto);
	    console.log(data[0].tram_tip_ent);
	    $("input[name=tip_entidad][value='"+data[0].tram_tip_ent+"']").prop("checked",true);
	    $('#tip_entidadd').val(data[0].tram_tip_ent);
	    var tipo_contacto = $( "input[name='tip_entidadd']").val();
		if(tipo_contacto == "I") {
			$('#emp_idd').val("1").trigger("change");
			$('#emp_idd').prop("disabled", true);
		}else {
			$('#emp_idd').val("init").trigger("change");
			$('#emp_idd').prop("disabled", false);
		}	
	    console.log(data[0].emptram_id);
	    $('#emp_idd').val(data[0].emptram_id).trigger("change");
	    $('#emp_id').val(data[0].emptram_id);
	    console.log(data[0].contactram_id);
	    combo_contacto_listar(data[0].tram_tip_ent,data[0].contactram_id);
	    $('#contac_id').val(data[0].contactram_id).trigger("change");
	    console.log(data[0].area_id);
	    $('#area_descripcion').val(data[0].area_descripcion);
	    console.log(data[0].cargo_id);
	    $('#cargo_descripcion').val(data[0].cargo_descripcion);
	    console.log(data[0].FechaResp);
	    $('#text_fecha_resp').val(data[0].FechaResp);
	    console.log(data[0].tram_prioridad);
	    $('#estado').val(data[0].tram_prioridad).trigger("change");	   
	    console.log(data[0].tram_ruta_doc);
	    $('#filecomplete').val(data[0].tram_ruta_doc);	
	  	$("textarea[name='textarea_file']").val(data[0].tram_ruta_doc);	
	  	console.log(data[0].tram_nro_referencia);
	  	console.log(data[0].tram_tipo_referencia);
	  	if(data[0].tram_nro_referencia == null){
	  	$('#doc_referencia').val('');
	  	}else{
	  	$('#doc_referencia').val(data[0].tram_nro_referencia+' / '+data[0].tram_tipo_referencia);
	  	}	  	
	  	if(data[0].tram_correo_copia == null){
		  	$('#copia').val('');
		  	$('#copia_hidden').val('');
		  	$('#checkCopia').prop("checked", false);
	  	}else{
		  	$('#copia').val(data[0].tram_correo_copia);
		  	$('#copia_hidden').val(data[0].tram_correo_copia);
		  	$('#checkCopia').prop("checked", true);
	  	}
	  	console.log(data[0].usu_numdoc);
	  	$('#usu_numdoc').val(data[0].usu_numdoc);
	  	console.log(data[0].tram_nro_referencia);
	  	$('#hidden_doc_referencia').val(data[0].tram_nro_referencia);
	  	console.log(data[0].tram_tipo_referencia);
	  	$('#hidden_tipo_referencia').val(data[0].tram_tipo_referencia);
	});
	
	Activar_Fecha();	
} 	

function Activar_Fecha() {
	var estado = $('#estado').val();
	var fechaResp = $('#text_fecha_resp').val(); 
	console.log(estado);
	console.log(document.getElementById('text_fecha_resp'));
	
	if (estado == 'U' && fechaResp == '') {
		$("#myModalAlerta4").modal("show");
	}  	
}

$("button[name='reg_editar']").on("click",function(){
	var registro = $('input[name=nro_tramite]').val();
	var nro_documento = $('#text_nro_documento_reg').val();
	var fecha_doc = $('#text_fecha_doc').val();
	var tipo_doc = $('#td_id').val();
	var asunto = $('textarea[name=text_asunto_reg]').val();
	var tip_entidad = $('#tip_entidadd').val();
	var empresa = $('#emp_id').val();
	var contacto = $('#contac_id').val();
	var area = $('#area_id').val();
	var cargo = $('#cargo_id').val();
	var prioridad = $('#estado').val();
	var fecha_resp = $('#text_fecha_resp').val();
	var ruta_documento = $('#filecomplete').val();
	var nom_doc = ruta_documento.substring(43,ruta_documento.length);
	var file = $('#file')[0].files;	
	
	var area_descripcion = $('#area_descripcion1').val();
	var cargo_descripcion = $('#cargo_descripcion1').val();
	var usu_correo = $('#usu_correo').val();
	var usu_numdocI = $('#usu_numdoc').val();
	var usu_nombre = $('#usu_nombre').val();
	var fecha_reg = $('#text_fecha_tram').val();
	
	var doc_referencia = $('#hidden_doc_referencia').val();
	var tipo_referencia = $('#hidden_tipo_referencia').val();
	var correo_copia = $('#copia_hidden').val();
	
	if($("input[name='text_nro_documento_reg']").val() == '' || $("#td_id").val() == 'init' || $("#text_asunto_reg").val() == '' || $("#estado").val() == '' || $("#emp_idd").val() == 'init'){
			alert("Favor de ingresar todos los datos obligatorios");
		}else{
			$("#preloader").css("display", "block");
			editar_registro(registro,nro_documento,fecha_doc,tipo_doc,asunto,tip_entidad,empresa,contacto,area,cargo,prioridad,fecha_resp,
							ruta_documento,nom_doc,file,area_descripcion,cargo_descripcion,usu_correo,usu_numdocI,usu_nombre,fecha_reg,
							doc_referencia,tipo_referencia,correo_copia);
		$("#myModalAlerta3").modal("show");				
		}	 
});

function editar_registro(registro,nro_documento,fecha_doc,tipo_doc,asunto,tip_entidad,empresa,contacto,area,cargo,prioridad,fecha_resp,
						 ruta_documento,nom_doc,file,area_descripcion,cargo_descripcion,usu_correo,usu_numdocI,usu_nombre,fecha_reg,
						 doc_referencia,tipo_referencia,correo_copia){
		
	var data = new FormData($('#form')[0]);
	data.append('registro', registro);
	data.append('nro_documento', nro_documento);
	data.append('fecha_doc', fecha_doc);
	data.append('tipo_doc', tipo_doc);
	data.append('asunto', asunto);
	data.append('tip_entidad', tip_entidad);
	data.append('empresa', empresa);
	data.append('contacto', contacto);
	data.append('area', area);
	data.append('cargo', cargo);
	data.append('prioridad', prioridad);
	data.append('fecha_resp', fecha_resp);
	data.append('ruta_documento', ruta_documento);
	data.append('nom_doc', nom_doc);
	data.append('file', file);
	data.append('area_descripcion', area_descripcion);
	data.append('cargo_descripcion', cargo_descripcion);
	data.append('usu_correo', usu_correo);
	data.append('usu_numdocI', usu_numdocI);
	data.append('usu_nombre', usu_nombre);
	data.append('fecha_reg', fecha_reg);
	data.append('doc_referencia', doc_referencia);
	data.append('tipo_referencia', tipo_referencia);
	data.append('correo_copia', correo_copia);

	var opts = {
	    url: 'editar_registro',
	    data: data,
	    async: false,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
	    type: 'POST',
	    success: function(data){
	        console.log(data);
	        location.reload();
	    }	    
	}
	jQuery.ajax(opts);
	 $("#preloader").css("display","none");
}

$("#estado").on("change",function(){
	var estado = $(this).val();
	if(estado == 'N'){
		$('#text_fecha_resp').attr('disabled','disabled');
		$('#text_fecha_resp').val('');
	}else{
		$('#text_fecha_resp').removeAttr('disabled');
	}
});


function Fecha_Documento() {
	var fechaDoc =  $('#text_fecha_doc').val();
	var fechaTram = $('#text_fecha_tram').val(); 
	
	if (fechaDoc>fechaTram) {		
		$("#myModalAlerta1").modal("show");	
		$('#text_fecha_doc').val('');
   	}
}

function Fecha_Respuesta() {
	var fechaTram =  $('#text_fecha_tram').val();
	var fechaResp = $('#text_fecha_resp').val(); 
	var estado = $('#estado').val();
	
	var fechaTram1 = fechaTram.split(/\D/).reverse().join("-");
	var fechaResp1 = fechaResp.split(/\D/).reverse().join("-");
	
	if (estado == 'U' && fechaResp<fechaTram) {
		$("#myModalAlerta2").modal("show");
		$('#text_fecha_resp').val('');				
   	}
}

$( "input[name='tip_entidad']").on("change",function() {	
	var tipoEnt = $(this).val()
	$('#tip_entidad_hidden').val(tipoEnt);
	var tipo = $('#tip_entidad_hidden').val();
	combo_empresa_listar(tipoEnt);
	$('#area_descripcion').val('');
	$('#cargo_descripcion').val('');
});

function combo_empresa_listar(tipo) {
	$('#emp_idd').html('');	
	$.ajax({
        url: 'combo_empresa_listar',
        method: 'POST',
        data: { tipo: tipo},
        dataType: 'json', 
        }).done(function( data ) { 
        	if(tipo == 'E'){
        		$('#emp_idd').append('<option selected value="init">SELECCIONE ENTIDAD</option>');
        		for(var i = 0; i<data.length;i++){        			
        			var opt = data[i];
	        		console.log(data[0].emp_razonsocial);	
	        		$('#emp_idd').val(data[0].emp_id).trigger("change");        			     		
				    $('#emp_idd').append('<option value="'+opt["emp_id"]+'">'+opt["emp_razonsocial"]+'</option>');
		  		} 
		  		$("#emp_idd").select2("val", "init");		  		
        	}else{
        		console.log(data[0].emp_razonsocial);        		
 				$('#emp_idd').append('<option value="'+data[0]["emp_id"]+'">'+data[0]["emp_razonsocial"]+'</option>');
 				$('#emp_idd').val(data[0].emp_id).trigger("change");
 				$("#myModalAlerta5").modal("show");	
        	}          	       	
	});
}

function activar_campo(){
	var id = $('#td_id').val();	
	$.ajax({
		method: "POST",
	  	url: '<?php echo URLLOGICA;?>registro/consulta_documento',
	  	data: { id: id},
	  	dataType: 'json',
	}).done(function( data ) {
	  	console.log(data[0].td_bloqueo);	  	
	  	var identificador = data[0].td_abreviacion;
	  	var correlativo = data[0].td_correlativo;
	  	var bloqueo = data[0].td_bloqueo;
	  	$('#hidden_bloqueo').val(bloqueo);
	  	if(data[0].td_bloqueo == 'S'){	 
	  		$('#text_nro_documento_reg').prop('disabled','disabled');
	  		$('#nueva_documento').prop('disabled','disabled');	  		
	  		if(correlativo.length == 1){
	  			var ceros = '0000'
	  		}else{
	  			if(correlativo.length == 2){
	  				var ceros = '000'
	  			}else{
	  				if(correlativo.length == 3){
	  				var ceros = '00'
	  				}else{
	  					if(correlativo.length == 4){
	  					var ceros = '0'
	  					}else{
	  						var ceros = correlativo;
	  					}	  					
	  				}	  				
	  			}
	  		}
	  		var numero_doc = identificador+'/2017-'+ceros+''+correlativo;
	  		$('#text_nro_documento_reg').val(numero_doc);
	  		$('#hidden_documento').val(numero_doc);
	  		$('#hidden_identificador').val(identificador);	  		
	  	}else{
	  		var documento_sb = $('#text_nro_documento_reg').val();
	  		$('#hidden_documento').val(documento_sb);
	  		$('#hidden_identificador').val(identificador);	
	  		$('#text_nro_documento_reg').prop('disabled',false);
	  		$('#nueva_documento').prop('disabled',false);
	  	}
	});
}

$("button[name=referencia_buscar]").on("click",function() {
	var nro_tramite = $('#nro_tramite').val();
	var num_documento = $('#text_nro_doc').val();
	var tip_documento = $('#tip_doc').val();
	var estado = $('#tram_estado').val();
	var fec_inicial = $('#text_fec_ini').val();
	var fec_final = $('#text_fec_fin').val(); 	
  	
  	Referencia(nro_tramite,num_documento,tip_documento, estado,fec_inicial,fec_final);
});

function Referencia(nro_tramite,num_documento,tip_documento, estado,fec_inicial,fec_final) {
	$.post("<?php echo URLLOGICA?>registroEdit/buscar_tramite/",
    {    	
    	"nro_tramite" : nro_tramite,
    	"num_documento" : num_documento ,
    	"tip_documento" : tip_documento ,
    	"estado" : estado,
    	"fec_inicial" : fec_inicial ,
    	"fec_final" : fec_final
    },    
    function(data, status){    	   	
    	$("#linea_seg").html("");		    	
    	for (var newnum = 0; newnum < data.length; newnum++) { 
    		var html = '<tr onclick= "obtenerDatos(' + data[newnum]["tram_id"] + ',\'' + data[newnum]["tram_nro_doc"] + '\',\'' + data[newnum]["td_descripcion"] + '\')">'            				
						+ '<td class="success" style="text-align:center;width:10%;">' + data[newnum]["Fecha"] + '</td>'
						+ '<td class="success" style="text-align:center;width:10%;">' + data[newnum]["tram_nro_doc"] + '</td>'	
						+ '<td class="success" style="text-align:center;width:10%;">' + data[newnum]["tram_tipo_doc"] + '</td>'																				
						+ '<td class="success" style="text-align:center;width:10%;">' + data[newnum]["td_descripcion"] + '</td>'
						+ '<td class="success" style="text-align:center;width:10%;">' + data[newnum]["tram_remitenteactual"] + '</td>'
						+ '<td class="success" style="text-align:center;width:10%;">' + data[newnum]["tram_estado"] + '</td>'								
						+ '</tr>';				
			$("#linea_seg").append(html);	
		}   		    	
	});
}

$('#referencia_limpiar').on("click",function() {			
	$('#text_nro_doc').val('');
	$('#tip_doc').val('').trigger("change");
	$('#tram_estado').val('').trigger("change");;
	$('#text_fec_ini').val('');	
   	$('#text_fec_fin').val(''); 
   	$("#linea_seg").html(""); 
});	

$('#cerrar_referencia').on("click",function() {			
	$('#text_nro_doc').val('');
	$('#tip_doc').val('').trigger("change");
	$('#tram_estado').val('').trigger("change");;
	$('#text_fec_ini').val('');	
   	$('#text_fec_fin').val(''); 
   	$("#linea_seg").html(""); 
});	

function obtenerDatos(id, nro_doc,tip_doc){
	$('#doc_referencia').val(nro_doc+' / '+tip_doc);
	$('#hidden_doc_referencia').val(nro_doc);
	$('#hidden_tipo_referencia').val(tip_doc);
	$('#cerrar_referencia').click();	
}

$("#emp_idd").on("change",function(){
	$('#contac_id').val('').trigger("change");
	$('#area_descripcion').val('');	
   	$('#cargo_descripcion').val(''); 
});

$("#limpiar_referencia").on("click",function(){
	$('#doc_referencia').val('');	
	$('#hidden_doc_referencia').val('');
	$('#hidden_tipo_referencia').val('');
 });
 
 $( '#checkCopia' ).on( 'click', function() {
    if( $(this).is(':checked') ){
        $('#copia').val('<?php echo $_SESSION['correo'];?>');
		$('#copia_hidden').val('<?php echo $_SESSION['correo'];?>');
    } else {
        $('#copia').val('');
		$('#copia_hidden').val('');
    }
});
</script>
<?php include "footer_view.php";?>