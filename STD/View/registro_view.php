<?php include "header_view.php";setlocale(LC_ALL,"es_ES");?>
<div class="preloader" id="preloader"></div>
<div class="content-wrapper">
	<section class="content-header" style="padding:5px;">
		<h1>Registro de Documento</h1>
	</section>
	<section name="contenedor" class="content" style="padding:1px;">
		<div class='box box-danger'>
			<form id="form_grabar" enctype="multipart/form-data" method="post" action="<?php echo URLLOGICA?>registro/grabarRegistro/insert/" name="insert">
		  	<div class="box-body" style="padding: 5px;">
			<div id="MainContent_Div1" class="panel panel-info">
				<div class="panel-heading" style="padding:1px;">
					<h2 class="panel-title">Datos del Documento:</h2>											
				</div>	
				<div style='padding: 5px;'> 
					<div class="row">
						<div class="col-xs-12" style="margin-bottom: 4px;">							
							<label class="col-md-2 control-label" for="label_tip_doc_reg">Tipo de Documento:<span style="color: #FF0000"><strong>*</strong></span></label>
							<div class="col-md-3">
								<select name="td_id" id="td_id" class="form-control input-sm" style="width: 100%;"  onchange="correlativo();" !important;>
	                    			<option value="init" selected> SELECCIONE DOCUMENTO </option>
		                    		<?php foreach ($this->objDoc as $listaDoc) {?>
										<option value="<?php echo $listaDoc["td_id"];?>"><?php echo utf8_encode($listaDoc["td_descripcion"]);?></option>
									<?php } ?>
								</select>
							</div>
							<div class= "col-md-1"> 
		          				<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalNuevoDocumento" type="button" name="nueva_documento" id="nueva_documento" title="Nuevo Documento"><i class="glyphicon glyphicon-file"></i></button>
							</div>
							<!-- Inicio Modal Documento-->
							<div id="myModalNuevoDocumento" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
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
							      		<div class="modal-body" style="padding: 20px;">
							      			<div class="row">												      				
							      				<div class="col-xs-12" style="padding-bottom: 10px;">
													<label for="label_modelD_nombre" class="col-md-3 control-label">Nombre Doc.:<span style="color: #FF0000"><strong>*</strong></span></label>
													<div class="col-md-9">                            
														<input type="text" name="text_modelD_nombre" id="text_modelD_nombre" onkeypress="return validarL(event)" id="text_modelD_nombre" maxlength="150" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
													</div>									
												</div> 							
											</div>
							     		 </div>
									     <div class="modal-footer">
									     	<button name = 'grabar_documento_modal' id = 'grabar_documento_modal' type="button" class="btn btn-primary btn-sm">Grabar</button>
									        <button name ="cerrar_documento" id ="cerrar_documento" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_documento()">Cancelar</button>										        
									     </div>
									</div>
								</div>
				   			</div>
				   			<!-- Fin Modal Documento-->
							<label class="col-md-2 control-label" for="label_nro_documento_reg">Número del Documento:<span style="color: #FF0000"><strong>*</strong></span></label>
							<div class="col-md-4">                            
								<input type="text" name="text_nro_documento_reg" id="text_nro_documento_reg" maxlength="50" class="form-control input-sm" style="text-transform: uppercase;width:100%; !important" required/>
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
									<input type="text" name="text_fecha_tramm" readonly="readonly" id="text_fecha_tramm" class="form-control datepicker" value="<?php echo date("d")."/".date("m")."/".date("Y");?>" disabled>
	                                <input type="hidden" name="text_fecha_tram" id="text_fecha_tram" value="<?php echo date("d")."/".date("m")."/".date("Y");?>">								
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
								<input type = 'hidden' name = "hidden_tipo_referencia_id" id = "hidden_tipo_referencia_id">
							</div>
                            <div class= "col-md-1"> 
		          				<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalBuscarReferencia" type="button" name="buscar_referencia" id="buscar_referencia" title="Documento Referencia"><i class="glyphicon glyphicon-search"></i></button>
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
													<input type="text" name="text_nro_doc" id="text_nro_doc" maxlength="50" class="form-control input-sm" value="<?php if(isset($_SESSION['text_nro_doc_bus'])){ echo $_SESSION['text_nro_doc_bus'];}?>"/>
												</div>
												<label class="col-md-2 control-label" for="label_tip_doc">Tipo de Documento:</label>
												<div class="col-md-2">  
													<select name="tip_doc" id="tip_doc" class="form-control input-sm" style="width: 100%;"> 
														<option value="" selected><?php if(isset($_SESSION['tip_doc_bus'])) {echo $_SESSION['tip_doc_bus'];} ?></option>
							                    		<?php foreach ($this->objDoc as $listaDoc) {?>
															<option value="<?php echo $listaDoc["td_descripcion"];?>"><?php echo utf8_encode($listaDoc["td_descripcion"]);?></option>													
														<?php } ?>	
													</select>
												</div>	
												<label for="label_nro_doc" class="col-md-2 control-label">Estado:</label>     
												<div class="col-md-2">   											                    
													<select name="tram_estado" id="tram_estado" class="form-control input-sm" style="width: 100%;">
						                    			<option value="" selected><?php if(isset($_SESSION['estado_bus'])){ echo $_SESSION['estado_bus'];}?></option>
							                    		<option value="Concluido">CONCLUIDO</option>
														<option value="Derivado">DERIVADO</option>
							                    		<option value="Recibido">RECIBIDO</option>														
														<option value="Transito">TRANSITO</option>														
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
					                                	<input type="text" name="text_fec_fin" id="text_fec_fin" class="form-control datepicker" data-date-format="dd/mm/yyyy" value="<?php if(isset($_SESSION['text_fec_fin_bus'])){ echo $_SESSION['text_fec_fin_bus'];} ?>"/>
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
							<textarea id="text_asunto_reg" name="text_asunto_reg" maxlength="450" rows="4" cols="30" class="form-control input-sm" style="text-transform: uppercase;height:45px;resize:none" required></textarea>
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
				<div style="padding:5px;"> 
					<div class="row">
						<div class="col-xs-12" style="margin-bottom: 4px;">
							<label class="col-md-2 control-label"for="label_tip_ent_reg">Origen de Entidad:<span style="color: #FF0000"><strong>*</strong></span></label>
							<div class="col-md-2">                            
								<input   type= "radio" name= "tip_entidad" value= "E" checked> Externo
								<input   type= "radio" name= "tip_entidad" value="I"> Interno									
							</div>									
							<input   type= "hidden" id= "tip_entidad_hidden" name= "tip_entidad_hidden" value="E">	
						</div>
						<div class="col-xs-12" style="margin-bottom: 4px;">
							<label class="col-md-2 control-label" for="label_nom_entidad">Nombre de Entidad:<span style="color: #FF0000"><strong>*</strong></span></label>
							<div class="col-md-3">                            
								<select name="emp_idd" id="emp_idd" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100%;" onchange="blanquear_campos_entidad()">
	                    			<option value="init" selected>SELECCIONE ENTIDAD</option>
		                    		<?php foreach ($this->objEnt as $listaEntidad) {?>
										<option value="<?php echo $listaEntidad["emp_id"];?>"><?php echo utf8_encode($listaEntidad["emp_razonsocial"]);?></option>
									<?php } ?>
								</select>	
								<input type="hidden" name="emp_id" id="emp_id" class="form-control input-sm"/>							
							</div>	 
							<div class= "col-md-1"> 
		          				<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalNuevaEmpresa" type="button" name="nueva_entidad" id="nueva_entidad" title="Nueva Empresa"><i class="glyphicon glyphicon-briefcase"></i></button>
							</div>
							<label class="col-md-2 control-label" for="label_nom_contacto">Nombre Contacto:</label>              
		                   	<div class="col-md-3">                            
								<select name="contac_id" id="contac_id" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;" method="POST">
	                    			<option value="" selected>SELECCIONE CONTACTO</option>
		                    		<?php foreach ($this->objCon as $listaContacto) {?>
										<option value="<?php echo $listaContacto["contac_id"];?>"><?php echo utf8_encode($listaContacto["contac_nombre"]);?></option>
									<?php } ?>
								</select>	
								<input type = 'hidden' name = "usu_nombre" id = "usu_nombre">
								<input type = 'hidden' name = "usu_correo" id = "usu_correo">
								<input type = 'hidden' name = "usu_numdoc" id = "usu_numdoc">											
							</div>
							<div class="col-md-1">
		          				<button data-toggle="modal" data-target="#myModalNuevoContacto" type="button" name="nueva_contacto" id="nueva_contacto" title="Nuevo Contacto" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-user"></i></button>
							</div>	
			            </div>
			            <div class="col-xs-12" style="margin-bottom: 4px;">
				        	<label class="col-md-2 control-label" for="label_area_contacto">Área Contacto:</label>
							<div class="col-md-4" >                            
								<input class="form-control input-sm" style="text-transform: uppercase;width:100%;" type = 'text' name = "area_descripcion" id = "area_descripcion" disabled>
								<input type = 'hidden' name = "area_descripcion1" id = "area_descripcion1">
								<input type = 'hidden' name = "area_id" id = "area_id">	
							</div>	
							<label class="col-md-2 control-label" for="label_cargo_contacto">Cargo del Contacto:</label>
							<div class="col-md-4">                            
								<input class="form-control input-sm" style="text-transform: uppercase;width:100%;" type = 'text' name = "cargo_descripcion" id = "cargo_descripcion" disabled>
								<input type = 'hidden' name = "cargo_descripcion1" id = "cargo_descripcion1">
								<input type = 'hidden' name = "cargo_id" id = "cargo_id">
							</div> 			        	
				        </div>     
		        	</div>			        	
	        	</div>			        		  				
			</div>
			<div id="MainContent_Div3" class="panel panel-info"> 
				<div style="padding:5px;"> 
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
                <?php if($this->permisos[0]["Agregar"] == 1){ ?>
			<div class="col-xs-12">
				<button type="button" name="reg_grabar" id="reg_grabar" class="btn btn-default pull-right">Grabar</button>
			</div>
                <?php }?>
			</form>				
			</div>				
		</div>
</section>
</div>
<!-- Inicio Modal Entidad-->
<div id="myModalNuevaEmpresa" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
    		<div class="modal-header" style = "height: 70px;">												        
		        <table class="col-xs-12">
					<tr>
						<td style="text-align:left;"><h4>Ingresar Nueva Entidad:</h4></td>
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
      				<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_modelE_empresa" class="col-md-3 control-label">Nombre Entidad:<span style="color: #FF0000"><strong>*</strong></span></label>
						<div class="col-md-9">                            
							<input type="text" name="text_modelE_empresa" id="text_modelE_empresa" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
						</div>									
					</div> 												      				
      				<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_modelE_ruc" class="col-md-3 control-label">R.U.C.:</label>
						<div class="col-md-9">                            
							<input type="text" name="text_modelE_ruc" id="text_modelE_ruc" maxlength="11" oninput="validarInput(this)" class="form-control input-sm number" style="width: 150px !important;"/>
						</div>									
					</div> 																
				</div>
     		 </div>
		     <div class="modal-footer">
		     	<button name = 'grabar_entidad_modal' id = 'grabar_entidad_modal' type="button" class="btn btn-primary btn-sm">Grabar</button>
		        <button id ="cerrar_entidad" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_empresa()">Cancelar</button>										        
		     </div>
		</div>
	</div>
</div>
<!-- Fin Modal Entidad-->
<!-- Inicio Modal Contacto-->
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
     		<div class="modal-body" style= "padding: 20px;">
        		<div class="row">
        			<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_model_nom_contacto" class="col-md-3 control-label">Nom.Contacto:<span style="color: #FF0000"><strong>*</strong></span></label>
						<div class="col-md-9">                            
							<input type = "text" name = "text_modal_nom_contacto" id = 'text_modal_nom_contacto' onkeypress = "return validarL(event)" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" required>
						</div>									
					</div> 
					<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_model_email" class="col-md-3 control-label">Email:</label>
						<div class="col-md-8">                            
							<input type = "email" name = "text_modal_correo_contacto" id = 'text_modal_correo_contacto' maxlength = "100" class="form-control input-sm" style="width: 100% !important;" >
						</div>									
					</div>
        			<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_tip_ent_reg" class="col-md-3 control-label">Tipo Contacto:</label>
						<div class="col-md-9">   																	                      
							<input type="radio" name="radio_tip_contacE" id="radio_tip_contacE" value="E" disabled> Externo
							<input type="radio" name="radio_tip_contacI" id="radio_tip_contacI" value="I" disabled> Interno										
							<input type="hidden" name="radio_tip_contac" id="radio_tip_contac">
						</div>									
					</div>
					<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_nom_entidad" class="col-md-3 control-label">Nombre Entidad:</label>
						<div class="col-md-9">                            
							<select name="modal_empresaa" id="modal_empresaa" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;" disabled>
                    			<option value="init" selected>SELECCIONE ENTIDAD</option>
	                    		<?php foreach ($this->objEnt as $listaEntidad) {?>
									<option value="<?php echo $listaEntidad["emp_id"];?>"><?php echo utf8_encode($listaEntidad["emp_razonsocial"]);?></option>
								<?php } ?>
							</select>
							<input type="hidden" name="modal_empresa" id="modal_empresa">
						</div>						           	
			        </div>								
					<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="modal_area_contacto" class="col-md-3 control-label">Área Contacto:</label>
						<div class="col-md-5">                            
							<select name="modal_area" id="modal_area" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 230px !important;">
                    			<option value="" selected>SELECCIONE AREA</option>
	                    		<?php foreach ($this->objArea as $listaArea) {?>
									<option value="<?php echo $listaArea["area_id"];?>"><?php echo utf8_encode($listaArea["area_descripcion"]);?></option>
								<?php } ?>
							</select>
						</div>
						<div class= "col-md-3"> 
      						<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalNuevaArea" type="button" name="nueva_entidad" id="nueva_entidad"><i class="glyphicon glyphicon-user"></i></button>
						</div>
					</div>
					<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_modal_cargo_contacto" class="col-md-3 control-label">Cargo Contacto:</label>
						<div class="col-md-5">                            
							<select name="modal_cargo" id="modal_cargo" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 230px !important;">
                    			<option value="" selected>SELECCIONE CARGO</option>
	                    		<?php foreach ($this->objCargo as $listaCargo) {?>
									<option value="<?php echo $listaCargo["cargo_id"];?>"><?php echo utf8_encode($listaCargo["cargo_descripcion"]);?></option>
								<?php } ?>
							</select>
						</div>
						<div class= "col-md-3"> 
      						<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalNuevaCargo" type="button" name="nueva_entidad" id="nueva_entidad"><i class="glyphicon glyphicon-user"></i></button>
						</div>
					</div>
				</div>
      		</div>
     		<div class="modal-footer">
		        <button name= "grabar_contacto_modal" type="button" class="btn btn-primary btn-sm">Grabar</button>
		        <button id ="cerrar_contacto" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_contacto()">Cancelar</button>
		    </div>
    	</div>
  	</div>
</div> 				
<!-- Fin Modal Contacto-->	
<!-- Inicio Modal Area-->
<div id="myModalNuevaArea" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;">
		        	<span aria-hidden="true">&times;</span>
		        	<span class="sr-only">Cerrar</span>
		        </button>
		        <h3 class="text-info" id="myModalLabel">Nueva Área</h3>
			</div>
      		<div class="modal-body" style="padding: 20px;">
      			<div class="row">
					<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_modelE_empresa" class="col-md-3 control-label">Nombre de Área:<span style="color: #FF0000"><strong>*</strong></span></label>
						<div class="col-md-8">   
							<input type="text" name="text_model_areaC" id="text_model_areaC" onkeypress="return validarL(event)" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
						</div>									
					</div>									
				</div>
     		 </div>
		     <div class="modal-footer">
		     	<button name = "grabar_area_modal" type="button" class="btn btn-primary btn-sm">Grabar</button>
		        <button id ="cerrar_area" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_area()">Cancelar</button>										        
		     </div>
		</div>
	</div>
</div>
<!-- Fin Modal Area-->
<!-- Inicio Modal Cargo-->
<div id="myModalNuevaCargo" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;">
		        	<span aria-hidden="true">&times;</span>
		        	<span class="sr-only">Cerrar</span>
		        </button>
		        <h3 class="text-info" id="myModalLabel">Nueva Cargo</h3>
			</div>
      		<div class="modal-body" style="padding: 20px;">
      			<div class="row">
					<div class="col-xs-12" style="margin-bottom: 10px;">
						<label for="label_modelC_cargo" class="col-md-4 control-label">Nombre de Cargo:<span style="color: #FF0000"><strong>*</strong></span></label>
						<div class="col-md-8">                            
							<input type="text" name="text_model_cargoC" id="text_model_cargoC" onkeypress="return validarL(event)" maxlength="100" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
						</div>									
					</div>									
				</div>
     		 </div>
		     <div class="modal-footer">
		     	<button name = 'grabar_cargo_modal' type="button" class="btn btn-primary btn-sm">Grabar</button>
		        <button id ="cerrar_cargo" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="blanquear_campos_cargo()">Cancelar</button>										        
		     </div>
		</div>
	</div>
</div>
<!-- Fin Modal Area-->	
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
<script>	
$('select').select2();
$('#td_id').select2();
$('#estado').select2();


$("input[id='file']").on("change",function(){
	var ruta = $(this).val();	
	var archivo = ruta.substring(12,ruta.length);	
	
	$("#filecomplete").val(archivo).trigger("change");	
	$("textarea[name='textarea_file']").val(archivo).trigger("change");
});


$(window).keypress(function(e) {
    if(e.keyCode == 13) {
        $('#referencia_buscar').click();
    }
});

$(document).keyup(function(event){
        if(event.which==27)
        {
        	$('.modal').modal('hide');
        	$('#text_modal_nom_contacto').val('');
			$('#text_modal_correo_contacto').val('');	
			$('#modal_area').val('').trigger("change");
			$('#modal_cargo').val('').trigger("change");
			$('#text_modelE_ruc').val('');
			$('#text_modelE_empresa').val('');
			$('#text_model_areaC').val('');
			$('#text_model_cargoC').val('');
			$('#text_modelD_nombre').val('');
        }
}); 
			
$(function(){	
	$('#reg_grabar').on("click",function(){
		if($("input[name='text_nro_documento_reg']").val() == '' || $("#td_id").val() == 'init' || $("#text_asunto_reg").val() == '' || $("#emp_idd").val() == 'init' || $("#estado").val() == '' || ($("#estado").val() == 'U' && $("#text_fecha_resp").val() == '') || ($("#emp_idd").val() =='I' && $("#contac_id").val() =='')){
			alert("Favor de ingresar todos los datos obligatorios");
		}else{
			activar_campo();
		}		
	});
});

$( "input[name='tip_entidad']").on("change",function() {	
	var tipoEnt = $(this).val()
	$('#tip_entidad_hidden').val(tipoEnt);
	var tipo = $('#tip_entidad_hidden').val();
		combo_empresa_listar(tipo);
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
        		for(var init = 0; init<=data.length;init++){
	        		console.log(data[0].emp_razonsocial);	
	        		$('#emp_idd').val(data[0].emp_id).trigger("change");        			     		
				    $('#emp_idd').append('<option value="'+data[init]["emp_id"]+'">'+data[init]["emp_razonsocial"]+'</option>');
		  		} 
        	}else{
        		console.log(data[0].emp_razonsocial);        		
 				$('#emp_idd').append('<option value="'+data[0]["emp_id"]+'">'+data[0]["emp_razonsocial"]+'</option>');
 				$('#emp_idd').val(data[0].emp_id).trigger("change");
 				$("#myModalAlerta3").modal("show");	
        	}          	       	
	});
}
			  
$(function(){	
	var tipoEnt = $( "input[name='tip_entidad']").val();
	if(tipoEnt == "E") {
		$("input[name='radio_tip_contacE']").val('E').trigger("change");
		$("input[name='radio_tip_contacE']").prop("checked", true);
		$("input[name='radio_tip_contacI']").prop("checked", false);
		$("input[name='radio_tip_contac']").val("E").trigger("change");		
	}
	$( "input[name='tip_entidad']").on("change",function() {		
		var tipoEnt = $(this).val();
		if(tipoEnt == "I") {		
			$("input[name='radio_tip_contacI']").val('I').trigger("change");
			$("input[name='radio_tip_contacE']").prop("checked", false);
			$("input[name='radio_tip_contacI']").prop("checked", true);	
			$("input[name='radio_tip_contac']").val("I").trigger("change");
		}else{
			$("input[name='radio_tip_contacE']").val('E').trigger("change");	
			$("input[name='radio_tip_contacE']").prop("checked", true);	
			$("input[name='radio_tip_contacI']").prop("checked", false);
			$("input[name='radio_tip_contac']").val("E").trigger("change");
		}			
	});		
});
	
$( "input[name='tip_entidad']").on("change",function() {
	var tipo_contacto = $(this).val();
	if(tipo_contacto == "I") {
		$('#emp_idd').val("1").trigger("change");
		$('#emp_idd').prop("disabled", true);
		$('#contac_id').val("init").trigger("change");		
		$('#nueva_entidad').prop("disabled", true);	
		$('#nueva_contacto').prop("disabled", true);	
		$("input[name='radio_tip_contac']").val("I").trigger("change");
	}else {
		$('#emp_idd').val("init").trigger("change");
		$('#emp_id').val("").trigger("change");
		$('#emp_idd').prop("disabled", false);
		$('#contac_id').val("init").trigger("change");		
		$('#nueva_entidad').prop("disabled", false);
		$('#nueva_contacto').prop("disabled", false);
		$("input[name='radio_tip_contac']").val("E").trigger("change");
	}			
});

$("select[name=emp_idd]").on("change",function() {
	var empresa_id = $(this).val();
	$('input[name=emp_id]').val(empresa_id);
	$('input[name=modal_empresa]').val(empresa_id);
	$("select[name='modal_empresaa']").val(empresa_id).trigger("change");	
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

$("select[name=contac_id]").on("change",function() { 
	var contac_id = $(this).val();
	var empresa_id = $('input[name=emp_id]').val();
	pull_area_cargo(contac_id,empresa_id);							
});		

function pull_area_cargo(id_contacto,empresa_id) {
	$.ajax({
	  method: "POST",
	  url: "../registro/lista_area_contacto",
	  data: { contacto: id_contacto, empresa:empresa_id},
	  dataType: 'json',
	}).done(function( data ) {
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

//*********************** Modal Entidad ************************
function combo_empresa() {
	$.ajax({
        url: 'listar_entidad_combo',
        method: 'GET',
        dataType: 'json', 
        }).done(function( data ) {
	    console.log(data[0].emp_razonsocial);	    
	    $('#emp_idd').append('<option value="'+data[0].emp_id+'">'+data[0].emp_razonsocial+'</option>');
	    $('#modal_empresaa').append('<option value="'+data[0].emp_id+'">'+data[0].emp_razonsocial+'</option>');
	    $('#emp_idd').val(data[0].emp_id).trigger("change");
		$("input[name='emp_id']").val(data[0].emp_id);			
	});
}

$("button[name='grabar_entidad_modal']").on("click",function(){
	var ruc = $("input[name='text_modelE_ruc']").val();
	var entidad = $("input[name='text_modelE_empresa']").val();
	var tipo = $("input[name='radio_tip_emp']").val();
	if($("input[name='text_modelE_empresa']").val() == ''){
			alert("Favor de ingresar el nombre de la Entidad");
	}else{	
		validaNombre(ruc,entidad,tipo);
	}	
	
	if($("input[name='text_modelE_empresa']").val() != '' && ruc != ''){
		validarInput(ruc);
	}				 
});

function validaNombre(ruc,entidad,tipo){	
	$.post('validaNombre',{entidad : entidad})
	.done(function (data) {
	  	console.log(data);
	  	if(data == 'TRUE'){
	  		alert("Empresa Existe");
	  	}else{
	  		grabar_entidad_modal(ruc,entidad,tipo);
	  	} 
	  	
	});
} 

function grabar_entidad_modal(ruc,entidad,tipo){	
	$.post('modal_grabar_entidad',{ruc : ruc, entidad : entidad, tipo : tipo})
	.done(function (data) {
		$('#cerrar_entidad').click();	
		$("input[name='text_modelE_ruc']").val('');
		$("input[name='text_modelE_empresa']").val('');
		combo_empresa();
	  	console.log(data);	  	
	});
} 

//*********************** Modal Contacto ************************
function combo_contacto() {
	$.ajax({
        url: 'listar_contacto_combo',
        method: 'GET',
        dataType: 'json', 
        }).done(function( data ) {
	    console.log(data[0].contac_nombre);	    
	    $('#contac_id').append('<option value="'+data[0].contac_id+'">'+data[0].contac_nombre+'</option>');
	    $('#contac_id').val(data[0].contac_id).trigger("change");	    
	});
}

$("button[name='grabar_contacto_modal']").on("click",function(){
	var contacto = $("input[name='text_modal_nom_contacto']").val();
	// var dni = $("input[name='text_modal_dni_contacto']").val();
	var correo = $("input[name='text_modal_correo_contacto']").val();
	var tipo = $("input[name='radio_tip_contac']").val();
	var empresa = $("input[name='modal_empresa']").val();
	var area = $("select[name='modal_area']").val();
	var cargo = $("select[name='modal_cargo']").val();

	grabar_contacto_modal(contacto,correo,tipo,empresa,area,cargo); 
});

function grabar_contacto_modal(contacto,correo,tipo,empresa,area,cargo){	
	$.post('modal_grabar_contacto',{contacto:contacto,correo:correo,tipo:tipo,empresa:empresa,area:area,cargo:cargo})
	.done(function (data) {
		$('#cerrar_contacto').click();
		$("input[name='text_modal_nom_contacto']").val('');
		// $("input[name='text_modal_dni_contacto']").val('');
		$("input[name='text_modal_correo_contacto']").val('');
		$("select[name='modal_empresaa']").val('');		
		$("select[name='modal_area']").val('');
		$("select[name='modal_cargo']").val('');
		combo_contacto();
	  	console.log(data);
	});
}

//***********************Modal Area************************
function combo_area() {
	$.ajax({
        url: 'listar_area_combo',
        method: 'GET',
        dataType: 'json', 
        }).done(function( data ) {
	    console.log(data[0].area_descripcion);	    
	    $('#modal_area').append('<option value="'+data[0].area_id+'">'+data[0].area_descripcion+'</option>');
	    $('#modal_area').val(data[0].area_id).trigger("change");		    	    
	});
}
$("button[name='grabar_area_modal']").on("click",function(){
	var area = $("input[name='text_model_areaC']").val();	
	grabar_area_modal(area); 
});

function grabar_area_modal(area){	
	$.post('grabar_area_modal',{area:area})
	.done(function (data) {
		$('#cerrar_area').click();
		$("input[name='text_model_areaC']").val('');
		combo_area();
	  	console.log(data);
	});
}

//***********************Modal Cargo************************
function combo_cargo() {
	$.ajax({
        url: 'listar_cargo_combo',
        method: 'GET',
        dataType: 'json', 
        }).done(function( data ) {
	    console.log(data[0].cargo_descripcion);	    
	    $('#modal_cargo').append('<option value="'+data[0].cargo_id+'">'+data[0].cargo_descripcion+'</option>');	 
	    $('#modal_cargo').val(data[0].cargo_id).trigger("change");   
	});
}

$("button[name='grabar_cargo_modal']").on("click",function(){
	var cargo = $("input[name='text_model_cargoC']").val();
	
	grabar_cargo_modal(cargo); 
});

function grabar_cargo_modal(cargo){	
	$.post('grabar_cargo_modal',{cargo:cargo})
	.done(function (data) {
		$('#cerrar_cargo').click();
		$("input[name='text_model_cargoC']").val('');
		combo_cargo();
	  	console.log(data);
	});
}


//***********************Modal Documento************************
function combo_documento() {
	$.ajax({
        url: 'listar_documento_combo',
        method: 'GET',
        dataType: 'json', 
        }).done(function( data ) {
	    console.log(data[0].td_descripcion);	    
	    $('#td_id').append('<option value="'+data[0].td_id+'">'+data[0].td_descripcion+'</option>');
	    $('#td_id').val(data[0].td_id).trigger("change");		    	    
	});
}
$("button[name='grabar_documento_modal']").on("click",function(){
	var documento = $("input[name='text_modelD_nombre']").val();
	validaNombreDoc(documento); 
});

function validaNombreDoc(documento){	
	$.post('validaNombreDoc',{documento : documento})
	.done(function (data) {
	  	console.log(data);
	  	if(data == 'TRUE'){
	  		alert("Documento Existe");
	  	}else{
	  		grabar_documento_modal(documento);
	  	} 
	  	
	});
} 

function grabar_documento_modal(documento){	
	$.post('grabar_documento_modal',{documento:documento})
	.done(function (data) {
		$('#cerrar_documento').click();
		$("input[name='text_modelD_nombre']").val('');
		combo_documento();
	  	console.log(data);
	});
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


function Activar_Fecha() {
	var estado = $('#estado').val();
	var fechaResp = $('#text_fecha_resp').val(); 
	
	if (estado == 'U' && fechaResp =='') {
		$("#myModalAlerta4").modal("show");
	}  	
}

function Fecha_Documento() {
	var fechaDoc =  $('#text_fecha_doc').val();
	var fechaTram = $('#text_fecha_tramm').val(); 
	
	var fechaDoc1 = fechaDoc.split(/\D/).reverse().join("-");
	var fechaTram1 = fechaTram.split(/\D/).reverse().join("-");
	
	if (fechaDoc1>fechaTram1) {		
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
	
	if (estado == 'U' && fechaResp1<fechaTram1) {
		$("#myModalAlerta2").modal("show");	
		$('#text_fecha_resp').val('');		
   	}
}

function blanquear_campos_entidad() {
	$('#contac_id').val('').trigger("change");
	$('#area_descripcion').val('').trigger("change");
	$('#cargo_descripcion').val('').trigger("change");
}

function blanquear_campos_documento() {
	$('#text_modelD_nombre').val('');
}

function blanquear_campos_contacto() {
	$('#text_modal_nom_contacto').val('');
	$('#text_modal_correo_contacto').val('');	
	$('#modal_area').val('').trigger("change");
	$('#modal_cargo').val('').trigger("change");
}

function blanquear_campos_empresa() {
	$('#text_modelE_ruc').val('');
	$('#grabar_entidad_modal').prop('disabled',false);
	$('#text_modelE_empresa').val('');
}

function blanquear_campos_area() {
	$('#text_model_areaC').val('');
}

function blanquear_campos_cargo() {
	$('#text_model_cargoC').val('');
}

function validarInput(input) {
    var ruc       = input.value.replace(/[-.,[\]()\s]+/g,""),
        valido;
        
    //Es entero?    
    if ((ruc = Number(ruc)) && ruc % 1 === 0
    	&& rucValido(ruc)) { // ⬅️ ⬅️ ⬅️ ⬅️ Acá se comprueba
    	$('#grabar_entidad_modal').prop('disabled',false);
    	valido = "Válido";
          
    } else {
    	$('#grabar_entidad_modal').prop('disabled','disabled');
        valido = "No válido";    	
    }
}

// Devuelve un booleano si es un RUC válido
// (deben ser 11 dígitos sin otro caracter en el medio)
function rucValido(ruc) {
    //11 dígitos y empieza en 10,15,16,17 o 20
    if (!(ruc >= 1e10 && ruc < 11e9
       || ruc >= 15e9 && ruc < 18e9
       || ruc >= 2e10 && ruc < 21e9))
        return false;
    
    for (var suma = -(ruc%10<2), i = 0; i<11; i++, ruc = ruc/10|0)
        suma += (ruc % 10) * (i % 7 + (i/7|0) + 1);
    return suma % 11 === 0;
    
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
	  	var bloqueo = data[0].td_bloqueo;
	  	$('#hidden_bloqueo').val(bloqueo);
	  	if(data[0].td_bloqueo == 'S'){	  		
	  		$('#text_nro_documento_reg').prop('disabled','disabled');
	  		$('#nueva_documento').prop('disabled','disabled');
	  		var identificador = data[0].td_abreviacion;
	  		var correlativo = data[0].td_correlativo;
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
	  		var numero_visual = identificador+'/2017-XXXXX';
	  		$('#text_nro_documento_reg').val(numero_visual);
	  		$('#hidden_documento').val(numero_doc);
	  		$('#hidden_identificador').val(identificador);
	  	}else{
	  		var documento_sb = $('#text_nro_documento_reg').val();
	  		$('#hidden_documento').val(documento_sb);
	  		$('#text_nro_documento_reg').prop('disabled',false);
	  		$('#nueva_documento').prop('disabled',false);
	  	}
	  	$('#form_grabar').submit();
	  	$("#preloader").css("display", "block");
	});
}

function correlativo(){
	var id = $('#td_id').val();	
	$.ajax({
		method: "POST",
	  	url: '<?php echo URLLOGICA;?>registro/consulta_documento',
	  	data: { id: id},
	  	dataType: 'json',
	}).done(function( data ) {
	  	console.log(data[0].td_bloqueo);	  	
	  	var bloqueo = data[0].td_bloqueo;
	  	$('#hidden_bloqueo').val(bloqueo);
	  	if(data[0].td_bloqueo == 'S'){	  		
	  		$('#text_nro_documento_reg').prop('disabled','disabled');
	  		$('#nueva_documento').prop('disabled','disabled');
	  		var identificador = data[0].td_abreviacion;
	  		var correlativo = data[0].td_correlativo;
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
	  		var numero_visual = identificador+'/2017-XXXXX';
	  		$('#text_nro_documento_reg').val(numero_visual);
	  		$('#hidden_documento').val(numero_doc);
	  		$('#hidden_identificador').val(identificador);
	  	}else{
	  		$('#text_nro_documento_reg').prop('disabled',false);
	  		$('#nueva_documento').prop('disabled',false);
	  	}
	});
}

$('#td_id').on("change",function() {
	$('#text_nro_documento_reg').val('');
	$('#hidden_documento').val('');
	$('#hidden_identificador').val('');
	$('#hidden_bloqueo').val('');
});


$("button[name=referencia_buscar]").on("click",function() {
	var num_documento = $('#text_nro_doc').val();
	var tip_documento = $('#tip_doc').val();
	var estado = $('#tram_estado').val();
	var fec_inicial = $('#text_fec_ini').val();
	var fec_final = $('#text_fec_fin').val(); 	
  	
  	Referencia(num_documento,tip_documento, estado,fec_inicial,fec_final);
});

function Referencia(num_documento,tip_documento, estado,fec_inicial,fec_final) {
	$.post("<?php echo URLLOGICA?>registro/buscar_tramite/",
    {    	
    	"num_documento" : num_documento ,
    	"tip_documento" : tip_documento ,
    	"estado" : estado,
    	"fec_inicial" : fec_inicial ,
    	"fec_final" : fec_final
    },    
    function(data, status){    	   	
    	$("#linea_seg").html("");		    	
    	for (var newnum = 0; newnum < data.length; newnum++) { 
    		var html = '<tr onclick= "obtenerDatos(' + data[newnum]["tram_id"] + ',\'' + data[newnum]["tram_nro_doc"] + '\',\'' + data[newnum]["td_descripcion"] + '\',\'' + data[newnum]["td_id"] + '\')">'            				
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
	$('#tram_estado').val('').trigger("change");
	$('#text_fec_ini').val('');	
   	$('#text_fec_fin').val(''); 
   	$("#linea_seg").html(""); 
});	

$('#cerrar_referencia').on("click",function() {			
	$('#text_nro_doc').val('');
	$('#tip_doc').val('').trigger("change");
	$('#tram_estado').val('').trigger("change");
	$('#text_fec_ini').val('');	
   	$('#text_fec_fin').val(''); 
   	$("#linea_seg").html(""); 
});	

function obtenerDatos(id, nro_doc,tip_doc,td_id){
	$('#doc_referencia').val(nro_doc+' / '+tip_doc);
	$('#hidden_doc_referencia').val(nro_doc);
	$('#hidden_tipo_referencia').val(tip_doc);
	$('#hidden_tipo_referencia_id').val(td_id);
	$('#cerrar_referencia').click();
	
}

function Sin_copia(){
	$('#copia').val('');
	$('#copia_hidden').val('');
}

function Con_copia(){
	$('#copia').val('<?php echo $_SESSION['correo'];?>');
	$('#copia_hidden').val('<?php echo $_SESSION['correo'];?>')
}

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