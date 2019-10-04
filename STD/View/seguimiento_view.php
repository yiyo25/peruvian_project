<?php include "header_view.php";?>
	<div class="content-wrapper">
		<section class="content-header" style="padding:5px;">
			<h1>Seguimiento Documentario</h1>
			<ol class="breadcrumb">
				<li><a><i class="fa fa-thumb-tack"></i>Seguimiento Documentario</a></li>
			</ol>
		</section>
		<section class="content" style="padding:5px;">
			<div class='box box-danger'>
				<div class="box-header with-border">
					<h3 class="box-title">Búsqueda</h3>
				</div>
				<div class="box-body" style = "height:400px;">
					<div id="MainContent_Div1" class="panel panel-default">
						<div style="padding: 10px;">

							<form method="post" action="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/0/" onsubmit="document.forms['buscar']['seguimiento_buscar'].disabled=true;" name="buscar">
								<div class="row">
									<div class="col-xs-12" style="margin-bottom: 5px;">
										<label class="col-md-2 control-label" for="label_nro_doc_seg">Número Documento:</label>
										<div class="col-md-2">                            
											<input type="text" name="text_nro_doc_seg" id="text_nro_doc_seg" maxlength="30" class="form-control input-sm" value="<?php  if(isset($_SESSION['text_nro_doc_seg_bus'])){ $_SESSION['text_nro_doc_seg_bus']; } ?>"/>
										</div>
										<label class="col-md-2 control-label" for="label_tip_doc_seg">Tipo de Documento:</label>
										<div class="col-md-3">  
											<select name="tip_doc_seg" id="tip_doc_seg" class="form-control input-sm" style="text-transform: uppercase !important;"> 
												<option value="" selected>SELECCIONE OPCIÓN</option>
					                    		<?php foreach ($this->objDoc as $listaDoc) {?>
													<option value="<?php echo $listaDoc["td_descripcion"];?>"><?php echo utf8_encode($listaDoc["td_descripcion"]);?></option>													
												<?php } ?>	
											</select>
											<script>
												var v1 = "<?php if(isset($_SESSION['tip_doc_seg_bus'])) { echo $_SESSION['tip_doc_seg_bus']; } ?>";
												$('#tip_doc_seg').val(v1);
											</script>
										</div>	
										<label for="label_nro_doc_seg" class="col-md-1 control-label">Estado:</label>     
										<div class="col-md-2">   											                    
											<select name="estado_seg" id="estado_seg" class="form-control input-sm"/>
				                    			<option value="" selected>SELECCIONE OPCIÓN</option>
					                    		<option value="Concluido">CONCLUIDO</option>
					                    		<option value="Derivado">DERIVADO</option>
					                    		<option value="Recibido">RECIBIDO</option>												
												<option value="Transito">TRANSITO</option>
											</select>
											<script>
												var v2 = "<?php if(isset($_SESSION['estado_seg_bus'])){ echo $_SESSION['estado_seg_bus'];}?>";
												$('#estado_seg').val(v2);
											</script>  
										</div>								
									</div>
									<div class="col-xs-12" style="margin-bottom: 5px;">
										<label class="col-md-2 control-label" for="label_fec_ini_seg">Fecha Inicial:</label>
										<div class="col-md-2" >												
											<div class="input-group">
				                                <input type="text" name="text_fec_ini_seg" id="text_fec_ini_seg" class="form-control datepicker" data-date-format="dd/mm/yyyy" value="<?php if(isset($_SESSION['text_fec_ini_seg_bus'])){ echo $_SESSION['text_fec_ini_seg_bus'];}?>"/>
				                                <div class="input-group-addon">
				                                    <span class="glyphicon glyphicon-calendar"></span>
				                                </div>
				                            </div>
			                            </div>	
										<label for="label_fec_fin_seg" class="col-md-2 control-label">Fecha Fin:</label>
										<div class="col-md-2">												
											<div class="input-group">
				                                	<input type="text" name="text_fec_fin_seg" id="text_fec_fin_seg" class="form-control datepicker" data-date-format="dd/mm/yyyy" value="<?php if(isset($_SESSION['text_fec_fin_seg_bus'])){ echo $_SESSION['text_fec_fin_seg_bus'];}?>"/>
				                               	<div class="input-group-addon">
				                                    <span class="glyphicon glyphicon-calendar"></span>
				                                </div>
				                            </div>
			                            </div>
			                            <label class="col-md-2 control-label" for="label_nro_referencia">Número Referencia:</label>
										<div class="col-md-2">                            
											<input type="text" name="text_nro_referencia" id="text_nro_referencia" maxlength="30" class="form-control input-sm" value="<?php if(isset($_SESSION['text_nro_referencia_bus'])){ echo $_SESSION['text_nro_referencia_bus'];}?>"/>
										</div>
									</div>
									<div class="col-xs-12" style="margin-bottom: 5px;">
										<label for="label_nro_doc_seg" class="col-md-2 control-label">Prioridad:</label>   
										<div class="col-md-2">   											                    
											<select name="prioridad_seg" id="prioridad_seg" class="form-control input-sm"/>
				                    			<option value="" selected>SELECCIONES OPCIÓN</option>
					                    		<option value="N">NORMAL</option>
					                    		<option value="U">URGENTE</option>
											</select>					
											<script>
												var v3 = "<?php if(isset($_SESSION['prioridad_seg_bus'])){ echo $_SESSION['prioridad_seg_bus'] ;}?>";
												$('#prioridad_seg').val(v3);
											</script>						  
										</div>
										<label for="label_emp_remit_seg" class="col-md-2 control-label">Empresa Remitente:</label>   
										<div class="col-md-3">   											                    
											<select name="emp_remit_seg" id="emp_remit_seg" class="form-control input-sm" style="text-transform: uppercase !important;"> 
												<option value="" selected>SELECCIONES OPCIÓN</option>
					                    		<?php foreach ($this->objEnt as $listaEmpRemit) {?>
													<option value="<?php echo $listaEmpRemit["emp_razonsocial"];?>"><?php echo utf8_encode($listaEmpRemit["emp_razonsocial"]);?></option>													
												<?php } ?>	
											</select> 
											<script>
												var v4 = "<?php if(isset($_SESSION['emp_remit_seg_bus'])) {echo $_SESSION['emp_remit_seg_bus'];}?>";
												$('#emp_remit_seg').val(v3);
											</script> 
										</div>
										<div class="col-md-3" style="text-align:right;"> 	
				                            <div class="btn-group" >
				                            	<button type="reset" name="seguimiento_limpiar" id="seguimiento_limpiar" value="Limpiar" class="btn btn-default btn-sm pull-right">Limpiar <i class="glyphicon glyphicon-eraser"></i></button>			                            
				                            </div>
				                            <div class="btn-group">
				                            	<button type="submit" name="seguimiento_buscar" id="seguimiento_buscar" value="Buscar" class="btn btn-default btn-sm pull-right">Buscar <i class="glyphicon glyphicon-search"></i></button>
											</div>	
										</div>	
									</div>	
					        	</div> 
				        	</form>
						</div>
			     	</div>	
			     	<div id="MainContent_listaPro" class="panel panel-info"> 
			  			<div class="panel-heading clearfix">
			      			<span id="MainContent_tituloPro"><strong>Documentos Registrados</strong></span>
			  			</div>
			       		<div class="area_resultado table-responsive">
							<table  class="table table-condensed" cellspacing="0" cellpadding="2" id="MainContent_datResPro" style="font-size: 10px;padding: 5px;border-color:Silver;border-width:1px;border-style:solid;border-collapse:collapse;margin: 0 auto;">
								<tr style="color:White;background-color:DimGray;font-weight:bold;">
									<th scope="col" style="text-align:center;">Fecha Registro</th>
									<th scope="col" style="text-align:center;">Número Documento</th>
									<th scope="col" style="text-align:center;">Tipo Documento</th>
									<th scope="col" style="text-align:center;">Descripcion Documento</th>
									<th scope="col" style="text-align:center;">Remitente</th>
									<th scope="col" style="text-align:center;">Estado Actual</th>
									<th scope="col" style="text-align:center;">Destinatario Actual</th>
									<th scope="col" style="text-align:center;">Número Referencia</th>
									<th scope="col" style="text-align:center;">Prioridad</th>
									<th scope="col" style="text-align:center;">R</th>
									<th scope="col" style="text-align:center;">D</th>
									<th scope="col" style="text-align:center;">C</th>
									<th scope="col" style="text-align:center;">F</th>
								</tr>
								<?php if (count($this->objSeg) > 0) {
									$item = 1;
									foreach ($this->objSeg as $lista) { ?>
								<tr>
									<td style="width:9%;text-align:center;"><?php echo utf8_encode($lista["Fecha"]);?> <?php echo $lista["Hora"];?></td>
									<td style="width:10%;text-align:center;"><?php echo $lista["tram_nro_doc"];?></td>
									<td style="width:4%;text-align:center;"><?php echo $lista["tram_tipo_doc"];?></td>
									<td style="width:12%;text-align:center;"><?php echo utf8_encode($lista["td_descripcion"]);?></td>
									<td style="width:30%;"><?php echo utf8_encode($lista["contac_nombre"]);?></td>									
									<td style="width:5%;text-align:center;"><?php echo utf8_encode($lista["tram_estado"]);?></td>
									<td style="width:30%;"><?php echo utf8_encode($lista["tram_remitenteactual"]);?></td>
									<td style="width:15%;"><?php echo utf8_encode($lista["tram_nro_referencia"]);?></td>
									<td style="width:15%;"><?php echo utf8_encode($lista["tram_prioridad"]);?></td>
									<td>
										<?php
										$longitud_usuario = strlen($_SESSION['usuario']);
										$longitud_usuarios = strlen($lista['tram_usuarios']);
										$posicion_contar = $longitud_usuarios-$longitud_usuario;
										$campo_comparar = substr($lista['tram_usuarios'],$posicion_contar,$longitud_usuario);
										$campo_copia = $lista['tram_usu_cop_bk'];
										$copia = strpos($campo_copia, $_SESSION['usuario']);
										$tip_doc = 	$lista['tram_tipo_doc'];	
										$estado = $lista["tram_estado"];						
										
										if ($tip_doc == 'ORIGINAL') {
											if ($campo_comparar == $_SESSION['usuario']) {
												if($estado =='TRANSITO'){?>
													<center>
														<a href="<?php echo URLLOGICA?>seguimiento/recibir_seguimiento/<?php echo $lista["tram_id"];?>">
															<button type="submit" name="seg_recibir" id="seg_recibir" class="btn btn-default btn-xs" title="Recibir" enabled><i class="glyphicon glyphicon-download-alt"></i></button>
														</a>
													</center>	
											<?php
												}else{ ?>
												<center>
													<button type="button" name="seg_recibir" id="seg_recibir" class="btn btn-default btn-xs" title="Recibir" disabled><i class="glyphicon glyphicon-download-alt"></i></button>
												</center>	
											<?php
												}
											}else{?>
												<center>
													<button type="button" name="seg_recibir" id="seg_recibir" class="btn btn-default btn-xs" title="Recibir" disabled><i class="glyphicon glyphicon-download-alt"></i></button>
												</center>
											<?php
											}
										}else{
											if ($campo_comparar == $_SESSION['usuario']) {
												if(utf8_encode($lista["tram_estado"])=='TRANSITO'){?>
													<center>
														<a href="<?php echo URLLOGICA?>seguimiento/recibir_seguimiento/<?php echo $lista["tram_id"];?>">
															<button type="submit" name="seg_recibir" id="seg_recibir" class="btn btn-default btn-xs" title="Recibir" disabled><i class="glyphicon glyphicon-download-alt"></i></button>
														</a>
													</center>	
											<?php
												}else{ ?>
												<center>
													<button type="button" name="seg_recibir" id="seg_recibir" class="btn btn-default btn-xs" title="Recibir" disabled><i class="glyphicon glyphicon-download-alt"></i></button>
												</center>	
											<?php
												}
											}else{?>
												<center>
													<button type="button" name="seg_recibir" id="seg_recibir" class="btn btn-default btn-xs" title="Recibir" disabled><i class="glyphicon glyphicon-download-alt"></i></button>
												</center>
											<?php
											}
										}?>	
									</td>
									<td>
										<?php
										$longitud_usuario = strlen($_SESSION['usuario']);
										$longitud_usuarios = strlen($lista['tram_usuarios']);
										$posicion_contar = $longitud_usuarios-$longitud_usuario;
										$campo_comparar = substr($lista['tram_usuarios'],$posicion_contar,$longitud_usuario);
										$tip_doc = 	$lista['tram_tipo_doc'];	
										
										if ($tip_doc == 'ORIGINAL') {
											if (utf8_encode($lista["tram_estado"])=='RECIBIDO') {	
												if($campo_comparar == $_SESSION['usuario']){?>
													<center>													
														<button data-toggle="modal" data-target="#myModalDerivarSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_derivar" id="seg_derivar" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)" class="btn btn-default btn-xs" title="Derivar" enabled><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
													</center>	
											<?php
												}else{ ?>
												<center>
													<button data-toggle="modal" data-target="#myModalDerivarSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_derivar" id="seg_derivar" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)" class="btn btn-default btn-xs" title="Derivar" disabled><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
												</center>	
											<?php
												}
											}else{?>
												<center>
														<button data-toggle="modal" data-target="#myModalDerivarSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_derivar" id="seg_derivar" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)" class="btn btn-default btn-xs" title="Derivar" disabled><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
													</center>	
											<?php
											}
										}else{
											if (utf8_encode($lista["tram_estado"])=='RECIBIDO') {	
												if($campo_comparar == $_SESSION['usuario']){?>
													<center>													
														<button data-toggle="modal" data-target="#myModalDerivarSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_derivar" id="seg_derivar" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)" class="btn btn-default btn-xs" title="Derivar" disabled><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
													</center>	
											<?php
												}else{ ?>
												<center>
													<button data-toggle="modal" data-target="#myModalDerivarSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_derivar" id="seg_derivar" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)" class="btn btn-default btn-xs" title="Derivar" disabled><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
												</center>	
											<?php
												}
											}else{?>
												<center>
														<button data-toggle="modal" data-target="#myModalDerivarSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_derivar" id="seg_derivar" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)" class="btn btn-default btn-xs" title="Derivar" disabled><i class="glyphicon glyphicon-circle-arrow-right"></i></button>
													</center>	
											<?php
											}
										}?>	
										<!-- Inicio Modal Derivado -->
										<div id="myModalDerivarSeg_<?php echo $lista["tram_id"];?>" class="modal fade" role="dialog" aria-labelledby="myModalLabel" style="z-index: 1051 !important;">
											<div class="modal-dialog" role="document">
										    	<div class="modal-content" style = "width:600px;height:600px;">
										     		<div class="modal-header" style = "height: 70px;">												        
												        <table class="col-xs-12">
															<tr>
																<td style="text-align:left;width:50%;"><h4 class="text-info" id="myModalLabel">Derivar Documento:</h4></td>
																<td style="text-align:right;width:50%;"><h4 class="text-info" id="myModalLabel">N° Trámite: <?php echo $lista["tram_id"];?></h4></td>
																<td>
																	<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
															        	<span aria-hidden="true">&times;</span>
															        	<span class="sr-only">Cerrar</span>
												     			   	</button>
																</td>
															</tr>
														</table>
												    </div>
												    <form name="formularioModalDerivarSeg" method="post" action="<?php echo URLLOGICA?>seguimiento/derivar_tramite/<?php echo $lista["tram_id"];?>">
										     		<div class="modal-body"  style = "height:470px;">
										     			 <div class="panel-group">
											        		<div class="panel panel-info" style = "height: 88px;">
											        			<div class="panel-heading">	
											        				<table>
											        					<tr>
											        						<td id="celda_sub"><strong>Documento:</strong></td>
											        						<td id='celda'><?php echo utf8_encode($lista["tram_nro_doc"]);?> - <?php echo utf8_encode($lista["tram_tipo_doc"]);?></td>
											        						<td>  </td>
											        						<td id="celda_sub"><strong>Asunto:</strong></td>												        						
											        					</tr>
											        					<tr>
											        						<td id="celda_sub"><strong>Contacto:</strong></td>
											        						<td id='celda'><?php echo utf8_encode($lista["contac_nombre"]);?></td>
											        						<td>   </td>
											        						<td id='celda'><?php echo utf8_encode($lista["tram_asunto"]);?></td>
											        					</tr>
											        					<tr>
											        						<td id="celda_sub"><strong>Tipo Contacto:</strong></td>
											        						<td id='celda'><?php echo utf8_encode($lista["tip_ent_desc"]);?></td>											        						
											        					</tr>
											        					<tr>
											        						<td id="celda_sub"><strong>Nro.Referencia:</strong></td>
											        						<td id='celda'><?php echo utf8_encode($lista["tram_nro_referencia"]);?></td>
											        					</tr>
											        				</table>
										        				</div>	
										        			</div>
										        				<div class="panel panel-info">	
											        				<div class="panel-heading" style = "height: 50px;">	
											        					<h5><strong>Derivar a:</strong></span></h5>
											        				</div>	
												        			<div class="panel-body">
													        			<div class="col-xs-12" style="margin-bottom:5px;">
																			<label for="label_tip_ent_reg" class="col-md-3 control-label">Tipo Contacto:<span style="color: #FF0000"><strong>*</strong></span></label>
																			<div class="col-md-9">                            
																				<input type="radio" name="radio_tip_contac" value="I" checked onclick="mostrarTram(<?php echo $lista["tram_id"];?>)"> Interno
																				<input type="radio" name="radio_tip_contac" value="E" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)"> Externo	
																				<input type="hidden" name="radio_tip_contacd" id="radio_tip_contacd"/>
																				<input type="hidden" name="tramseg_id" id = 'tramseg_id' value="<?php echo $lista["tram_id"];?>"/>																
																			</div>									
																		</div>
																		<div class="col-xs-12" style="margin-bottom: 5px;">
																			<label for="label_nom_entidad" class="col-md-3 control-label">Nombre Entidad:<span style="color: #FF0000"><strong>*</strong></span></label>
																			<div class="col-md-9">                            
																				<select name = "modal_empresa" id = "modal_empresa" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase !important; width: 100% !important;" required>
													                    			<option value="init" selected>SELECCIONE ENTIDAD</option>
														                    		<?php foreach ($this->objEnt as $listaEntidad) {?>
																						<option value="<?php echo $listaEntidad["emp_id"];?>"><?php echo utf8_encode($listaEntidad["emp_razonsocial"]);?></option>
																					<?php } ?>
																				</select>																		
																			</div>	
																			<input type="hidden" name="txt_empresa_id" id="txt_empresa_id"/>	           	
																        </div>
																        <div class="col-xs-12" style="margin-bottom: 5px;">
																			<label for="label_nom_entidad" class="col-md-3 control-label">Nomb. Contacto:<span style="color: #FF0000"><strong>*</strong></span></label>
																			<div class="col-md-9">  
																				<select name="modal_contacto" id="modal_contacto" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;" method="" required>
													                    			<option value="" selected>SELECCIONE CONTACTO</option>														                    		
																				</select>
																				<input type = 'hidden' name = "usu_nombre_<?php echo $lista["tram_id"];?>" id = "usu_nombre_<?php echo $lista["tram_id"];?>">
																				<input type = 'hidden' name = "usu_correo_<?php echo $lista["tram_id"];?>" id = "usu_correo_<?php echo $lista["tram_id"];?>">
																				<input type = 'hidden' name = "usu_numdoc_<?php echo $lista["tram_id"];?>" id = "usu_numdoc_<?php echo $lista["tram_id"];?>">
																			</div>	
																			<input type="hidden" name="txt_contacto_id" id="txt_contacto_id"/>
																		</div>
																		<div class="col-xs-12" style="margin-bottom: 5px;">
																			<label for="modal_area_contacto" class="col-md-3 control-label">Área Contacto:</label>
																			<div class="col-md-8">
																				<input type = 'text' name = "modal_area_<?php echo $lista["tram_id"];?>" id = "modal_area_<?php echo $lista["tram_id"];?>" class="form-control input-sm" style="text-transform: uppercase;width:100%;" disabled>
																				<input type = 'hidden' name = "area_descripcion_<?php echo $lista["tram_id"];?>" id = "area_descripcion_<?php echo $lista["tram_id"];?>">
																			</div>
																		</div>
																		<div class="col-xs-12" style="margin-bottom: 5px;">
																			<label for="label_modal_cargo_contacto" class="col-md-3 control-label">Cargo Contacto:</label>
																			<div class="col-md-8">                            
																				<input type = 'text' name = "modal_cargo_<?php echo $lista["tram_id"];?>" id = "modal_cargo_<?php echo $lista["tram_id"];?>" class="form-control input-sm" style="text-transform: uppercase;width:100%;"  disabled>
																				<input type = 'hidden' name = "cargo_descripcion_<?php echo $lista["tram_id"];?>" id = "cargo_descripcion_<?php echo $lista["tram_id"];?>">
																			</div>
																		</div>
																		<div class="col-md-12" style="margin-bottom: 5px;">
														                   	<label for="label_asunto_reg" class="col-md-2 control-label">Observacion:</label>
														               </div>
														               <div class="col-md-12" style="margin-bottom: 5px;">    	              
														                	<div class="col-md-10">
																				<textarea name="text_observacion" maxlength="500" rows="2" cols="40" style="text-transform: uppercase; width: 480px; height: 50px;resize:none"></textarea>
														                   	</div>
																       </div>   
																	</div>
																</div>
											      			
										      			</div>
										      		</div>
										     		<div class="modal-footer" style = "height:70px;">
												        <button type="submit" class="btn btn-primary" >Derivar</button>
												        <button name = "button_cancelar" id = "button_cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
												    </div>
										    	</div>
										  	</div>
										</div> 				
										</form>
										<!-- Fin Modal Nuevo-->
									</td>
									<td>
										<?php
										$longitud_usuario = strlen($_SESSION['usuario']);
										$longitud_usuarios = strlen($lista['tram_usuarios']);
										$posicion_contar = $longitud_usuarios-$longitud_usuario;
										$campo_comparar = substr($lista['tram_usuarios'],$posicion_contar,$longitud_usuario);
										$tip_doc = 	$lista['tram_tipo_doc'];	
										if ($tip_doc == 'ORIGINAL'){
											if (utf8_encode($lista["tram_estado"])=='RECIBIDO') {	
												if($campo_comparar == $_SESSION['usuario']){?>
													<center>
														<a href="<?php echo URLLOGICA?>seguimiento/concluir_seguimiento/<?php echo $lista["tram_id"];?>">
															<button dtype="button" name="seg_concluir" id="seg_concluir" class="btn btn-default btn-xs" title="Concluir" enabled><i class="glyphicon glyphicon-ok"></i></button>
														</a>
													</center>	
											<?php
												}else{ ?>
												<center>
													<button dtype="button" name="seg_concluir" id="seg_concluir" class="btn btn-default btn-xs" title="Concluir" disabled><i class="glyphicon glyphicon-ok"></i></button>
												</center>		
											<?php
												}
											}else{?>
												<center>
													<button dtype="button" name="seg_concluir" id="seg_concluir" class="btn btn-default btn-xs" title="Concluir" disabled><i class="glyphicon glyphicon-ok"></i></button>
												</center>
											<?php
											}
										}else{
											if (utf8_encode($lista["tram_estado"])=='TRANSITO') {	
												if($campo_comparar == $_SESSION['usuario']){?>
													<center>
														<a href="<?php echo URLLOGICA?>seguimiento/concluir_seguimiento/<?php echo $lista["tram_id"];?>">
															<button dtype="button" name="seg_concluir" id="seg_concluir" class="btn btn-default btn-xs" title="Concluir" enabled><i class="glyphicon glyphicon-ok"></i></button>
														</a>
													</center>	
											<?php
												}else{ ?>
												<center>
													<button dtype="button" name="seg_concluir" id="seg_concluir" class="btn btn-default btn-xs" title="Concluir" disabled><i class="glyphicon glyphicon-ok"></i></button>
												</center>		
											<?php
												}
											}else{?>
												<center>
													<button dtype="button" name="seg_concluir" id="seg_concluir" class="btn btn-default btn-xs" title="Concluir" disabled><i class="glyphicon glyphicon-ok"></i></button>
												</center>
											<?php
											}
										}
										?>
									</td>
									<td>
										<center><button data-toggle="modal" data-target="#myModalObserSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_observacion" id="<?php echo $lista["tram_id"];?>" class="btn btn-default btn-xs" title="Flujo" 
										onclick="Seguimiento('open',<?php echo $lista["tram_id"];?>,0)"><i class=" glyphicon glyphicon-list-alt"></i></button></center>																		
										<input type="hidden" name="tram_id" value="<?php echo $lista["tram_id"];?>" id="tram_id"/>										
										<div id="myModalObserSeg_<?php echo $lista["tram_id"];?>" class="modal fade" name = 'modalDerivado' role="dialog" aria-labelledby="myModalLabel" style="z-index: 1050 !important;">
											<div class="modal-dialog" style = "width:1100px;">
										    	<div class="modal-content">	
										    		<div class="modal-header" style = "height: 70px;">
												        <table class="col-xs-12">
															<tr>
																<td style="text-align:left;width:50%;"><h3 class="text-info" id="myModalLabel">Seguimiento de Flujo Documentario:</h3></td>
																<td style="text-align:right;width:50%;"><h3 class="text-info" id="myModalLabel">N° Trámite: <?php echo $lista["tram_id"];?></h3></td>
																<td>
																	<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:10px; padding: 2px 8px 6px 8px;text-align:right;">
															        	<span aria-hidden="true">&times;</span>
															        	<span class="sr-only">Cerrar</span>
												     			   	</button>
																</td>
															</tr>
														</table>	
												    </div>											     		
										     		 <div class="modal-body" style = "height:420px;">
											     		 <div class="panel-group">
															<div class="panel panel-info">
																<div class="panel-heading">																	
													     		 	<table>
																		<tr>
																		  <td id="celda_sub" style="text-align:left"><strong>Documento: </strong></td>
																		  <td id="celda_flujo" style="text-align:left;"><?php echo utf8_encode($lista["tram_nro_doc"]);?> - <?php echo utf8_encode($lista["tram_tipo_doc"]);?></td>	
																		  <td id="celda_sub" style="text-align:left"><strong>Asunto:</strong></td>																			  
																		</tr>																			 
																		<tr>
																		  <td id="celda_sub" style="text-align:left"><strong>Contacto: </strong></td>
																		  <td id="celda_flujo"  style="text-align:left;"><?php echo utf8_encode($lista["contac_nombre"]);?></td>
																		  <td id="celda_flujo"  style="text-align:left;"><?php echo utf8_encode($lista["tram_asunto"]);?></td>
																		</tr>																		 
																		<tr>
																		  <td id="celda_sub" style="text-align:left"><strong>Tipo Contacto:</strong></td>
																		  <td id="celda_flujo"  style="text-align:left;"><?php echo utf8_encode($lista["tip_ent_desc"]);?></td>																			  
																		</tr>
																		<tr>
																		  <td id="celda_sub" style="text-align:left"><strong>Nro.Referencia:</strong></td>
																		  <td id="celda_flujo"  style="text-align:left;"><?php echo utf8_encode($lista["tram_nro_referencia"]);?></td>																			  
																		</tr>
																	</table>
																</div>	
															</div>															
															<div class="panel panel-info">	
																<div class="panel-heading" style = "height: 50px;">	
																	<h5><strong>Flujo del Documento</strong></span></h5>
																</div>
												        		<div id="panel_body">
												        			<table class="table table-hover">
												        				<thead>
													        				<tr>
													        					<th bgcolor="#E6E6E6" style="text-align:center;width:5%";>N°</th>
																				<th bgcolor="#F5E8BA" style="text-align:center;width: 10%;">Remitente</th>
																				<th bgcolor="#F5E8BA" style="text-align:center;width: 10%;">Área Remitente</th>																			  	
																			  	<th bgcolor="#F5E8BA" style="text-align:center;width: 10%;">Cargo Remitente</th>
																			  	<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Destinatario</th>
																			  	<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Área Destinatario</th>																			  	
																			  	<th bgcolor="#BAF5C1" style="text-align:center;width: 10%;">Cargo Destinatario</th>
																			  	<th bgcolor= "#E6E6E6" style="text-align:center;width: 5%;">Tránsito</th>
																			  	<th bgcolor= "#E6E6E6" style="text-align:center;width: 5%;">Derivado</th>
																			  	<th bgcolor= "#E6E6E6" style="text-align:center;width: 5%;">Recibido</th>
																			  	<th bgcolor= "#E6E6E6" style="text-align:center;width: 5%;">Concluido</th>	
																			  	<th bgcolor= "#e6b0aa" style="text-align:center;width: 5%;">Obs</th>
																			  	<th bgcolor= "#E6E6E6" style="text-align:center;width: 5%;">Historial</th>											  																				  	
																			</tr>	
																		</thead>																									
																		<tbody id="linea_seg<?php echo $lista["tram_id"];?>"></tbody>	
																	</table>													
																</div>																
															</div>																																											
														</div>																					
										      		</div>
										      		<div class="container-fluid text-center" style = "height:60px;">
														<nav>
															<ul class="pagination pagination-sm" id="pagination<?php echo $lista["tram_id"];?>"></ul>
														</nav>											
													</div>
										     		<div class="modal-footer" style = "height:50px;padding:5px;">											     			
														<button data-toggle="modal" data-target="#myModalDerivarSeg_<?php echo $lista["tram_id"];?>" type="button" name="seg_derivarModal" id="seg_derivarModal" class="btn btn-default btn-sm" onclick="mostrarTram(<?php echo $lista["tram_id"];?>)">Derivar</button>
														<a href="<?php echo URLLOGICA?>seguimiento/recibir_seguimiento/<?php echo $lista["tram_id"];?>">
															<button type="submit" name="seg_recibido" id="seg_recibido" class="btn btn-default btn-sm">Recibir</button>
														</a>
														<a href="<?php echo URLLOGICA?>seguimiento/concluir_seguimiento/<?php echo $lista["tram_id"];?>">
															<button type="submit" name="seg_concluido" id="seg_concluido" class="btn btn-default btn-sm">Concluir</button>
														</a>
												        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>												         													       
												    </div>
										    	</div>
										  	</div>													  											  	
										</div>														
										<!-- Fin Modal Nuevo-->															
									</td>
								</tr>
									<?php
										$item++;
										} 
									} ?>											
							</table>							
			           	</div>
					</div>
				</div>
				<div class="container-fluid text-center">
					<nav>
						<ul class="pagination pagination-sm">
							<li><a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/0/0/" aria-label="Primero"><span>&lsaquo;&lsaquo; Primero</a></span></li>
							<?php 
								if($this->pageactual == 0){ ?>
									<li><a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/0/0/" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>	
							<?php 
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/<?php echo $this->pageactual-1;?>/0/" aria-label="Anterior"><span>&lsaquo; Anterior</a></span></li>
							<?php
								}
							?>	
							<li>									
								<?php
                                $paginas=0;
											if(count($this->objSeg) > 0){
												$pagemax = 5;
												$TotalReg= count($this->objSegT);	
												$paginas =ceil($TotalReg/5);												
												if ($paginas<$pagemax){
													for($item = 0;$item<$paginas;$item++){
								?>							
									<a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/<?php echo $item;?>/0/"><?php echo $item+1;?></a>
								<?php	
													}
												}else{
													
													for($item = 0;$item<$pagemax-1;$item++){?>
														
														<a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/<?php echo $item;?>/0/"><?php echo $item+1;?></a>
														
													<?php
													}
													
													if($this->pageactual >= $pagemax){?>
														<a href="#">...</a>
														<a href="#"><?php echo $this->pageactual;?></a>
													<?php
													}
													if($this->pageactual < $paginas-1){?>
														<a href="#">...</a>
														<a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/<?php echo $paginas-1;?>/0/"><?php echo $paginas;?></a>																
												<?php	}
												}
											} ?>		
							</li>
							<?php	 
								if($this->pageactual == $paginas-1){ ?>
								<li><a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/<?php echo $paginas-1;?>/0/" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}else{ ?>
									<li><a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/<?php echo $this->pageactual+1;?>/0/" aria-label="Siguiente"><span aria-hidden="true">Siguiente &rsaquo;</span></a></li>
							<?php
								}		
							?>	
							<li><a href="<?php echo URLLOGICA?>seguimiento/listar_seguimiento/listar/<?php echo $paginas-1;?>/0/" aria-label="Ultimo"><span>Ultimo &rsaquo;&rsaquo;</a></span></li>
						</ul>
					</nav>											
				</div>	
			</div>
		</section>					
	</div>
<div id="myModalAlerta1" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
    		<div class="modal-header" padding:"1px;">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h4>Observacion:</h4>
	     	</div>
      		<div class="modal-body" id="alert">	            
     		</div>
     		<div class="modal-footer">
		        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
		    </div>
		</div>
	</div>
</div>	
<div id="myModalHistorial" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" style="width:260px">
    	<div class="modal-content">
    		<div class="modal-header" style = "height: 70px;padding:5px;">												        
		        <table class="col-xs-12">
					<tr>
						<td style="text-align:left;width:50%;"><h4 class="text-info" id="myModalLabel">Historial:</h4></td>						
						<td>
							<button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:15px; padding: 2px 8px 6px 8px;text-align:right;">
					        	<span aria-hidden="true">&times;</span>
					        	<span class="sr-only">Cerrar</span>
		     			   	</button>
						</td>						
					</tr>
				</table>
		    </div>
		    <div class="modal-body" style = "height:220px;padding:5px;">
			 <div class="panel-group">											
				<div class="panel panel-info">	
					<div class="panel-heading" style = "height: 50px;">	
						<h5><strong>Historial del Flujo:</strong></span></h5>
					</div>
					<div style = "font-size: 11px;">
						<table class="table table-hover" id="linea_seg">							
						</table>													
					</div>																
				</div>																																											
			</div>																					
		</div>
     		<div class="modal-footer" style = "height:50px;padding:5px;">
		        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
		    </div>
		</div>
	</div>
</div>	
<script >

$('select').select2();
$('#tip_doc_seg').select2();
$('#estado_seg').select2();	

 $(document).keyup(function(event){
    if(event.which==27){
        $('.modal').modal('hide');
    }
}); 

$(document).keypress(function(event) {	
    if(event.which == 13) {
        $('#seguimiento_buscar').click();
    }
});

 $('.modal').on('hidden.bs.modal', function(){
 	$('#modal_empresa').select2('val','init');
 	$('#modal_empresa').prop("disabled", false);
 	$('#modal_contacto').select2('val','init');
 	$('#modal_contacto').prop("disabled", false);
 	$('textarea').val("");
 });

function mostrarTram(id){
	var tipo_contacto = $("input[name='radio_tip_contac']").val();
	if(tipo_contacto == "I") {
		$("select[name='modal_empresa']").val("1").trigger("change");
		$("select[name='modal_empresa']").prop("disabled", true);
		$("select[name='modal_contacto']").val("init").trigger("change");	
		$("#tramseg_id").val(id);
		var tramseg_id = $("#tramseg_id").val();
		$('#modal_area_'+tramseg_id).prop("disabled", false);
		$('#modal_cargo_'+tramseg_id).prop("disabled",false);
		$('#modal_area_'+tramseg_id).val('');
		$('#modal_cargo_'+tramseg_id).val('');
		$('#modal_area_'+tramseg_id).prop("disabled", true);
		$('#modal_cargo_'+tramseg_id).prop("disabled",true);
	}
}

$( "input[name='radio_tip_contac']").on("change",function() {
	var tipo = $(this).val();
	if(tipo == "I") {
		setTimeout(function(){ 		
			$("select[name='modal_empresa']").val("1").trigger("change");
			$("select[name='modal_empresa']").prop("disabled", true);
			$("select[name='modal_contacto']").val("").trigger("change");
		}, 500);	
	}else{
		$("select[name='modal_empresa']").val("init").trigger("change");
		$("select[name='modal_empresa']").prop("disabled", false);	
		$("select[name='modal_contacto']").val("").trigger("change");	
	}							
});	

function combo_empresa_listar(tipo) {
	$('#modal_empresa').html('');	
	$.ajax({
        url: 'combo_empresa_listar',
        method: 'POST',
        data: { tipo: tipo},
        dataType: 'json', 
        }).done(function( data ) { 
        	if(tipo == 'E'){        		
        		for(var init = 0; init<=data.length;init++){
	        		console.log(data[1].emp_razonsocial);	
	        		$('#modal_empresa').val(data[1].emp_id).trigger("change");        			     		
				    $('#modal_empresa').append('<option value="'+data[init]["emp_id"]+'">'+data[init]["emp_razonsocial"]+'</option>');
		  		} 
        	}else{
        		console.log(data[0].emp_razonsocial);        		
 				$('#modal_empresa').append('<option value="'+data[0]["emp_id"]+'">'+data[0]["emp_razonsocial"]+'</option>');
 				$('#modal_empresa').val(data[0].emp_id).trigger("change");
 				$("#myModalAlerta3").modal("show");	
        	}          	       	
	});			
}

$("select[name='modal_empresa']").on("change",function() {
	var modal_empresa_id = $(this).val();
	$("input[name='txt_empresa_id']").val(modal_empresa_id);
	filtrar_contacto(modal_empresa_id);	
});

function filtrar_contacto(modal_empresa_id) {
	 var modal_contacto_id = $("select[name='modal_contacto']").select2({
	  	ajax: {
		    url: '<?php echo URLLOGICA;?>seguimiento/lista_contacto_pull',
		    method: "POST",
		    data: function(params){
		    	return {
		    		q: params.term,
		    		empresa: modal_empresa_id		    		
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

$("select[name='modal_contacto']").on("change",function() {
	var id_contacto = $(this).val();
	var empresa_id = $("input[name='txt_empresa_id']").val();
	var tramseg_id = $("#tramseg_id").val();
	pull_area_cargo(id_contacto,empresa_id,tramseg_id);
});	

function pull_area_cargo(id_contacto,empresa_id,tramseg_id) {
	$.ajax({
		method: "POST",
	  	url: '<?php echo URLLOGICA;?>seguimiento/lista_area_contacto',
	  	data: { contacto: id_contacto, empresa:empresa_id},
	  	dataType: 'json',
	}).done(function( data ) {
		if (data.length>0){
			console.log( data[0].area_descripcion);
		    console.log( data[0].cargo_descripcion);
		    $('#modal_area_'+tramseg_id).prop("disabled", false);
		    $('#modal_cargo_'+tramseg_id).prop("disabled",false);	
		    $('#usu_nombre_'+tramseg_id).val(data[0].contac_nombre);		    
		    $('#modal_area_'+tramseg_id).val(data[0].area_descripcion);
		    $('#area_descripcion_'+tramseg_id).val(data[0].area_descripcion);
		    $('#modal_area_'+tramseg_id).prop("disabled", true);
		    $('#modal_cargo_'+tramseg_id).val(data[0].cargo_descripcion);
		    $('#cargo_descripcion_'+tramseg_id).val(data[0].cargo_descripcion);
		    $('#modal_cargo_'+tramseg_id).prop("disabled", true);
		    $('#usu_correo_'+tramseg_id).val(data[0].usu_correo);
		    $('#usu_numdoc_'+tramseg_id).val(data[0].usu_numdoc);
		  }
	});
}     
     
$(function(){	
	if('<?php echo $this->var;?>' == 'open'){	
		$('#myModalDerivarSeg_<?php echo $this->id_reg;?>').modal("show") 
		var tipo_contacto = $("input[name='radio_tip_contac']").val();		
		var tramseg_id = $('#tramseg_id').val(<?php echo $this->id_reg;?>);
		if(tipo_contacto == "I") {
			$("select[name='modal_empresa']").val("1").trigger("change");
			$("select[name='modal_empresa']").prop("disabled", true);
			filtrar_contacto(1);	
		}	
		$( "input[name='radio_tip_contac']").on("change",function() {
			var tipo_contacto = $(this).val();				
			if(tipo_contacto == "I") {		
				$("select[name='modal_empresa']").val("1").trigger("change");
				$("select[name='modal_empresa']").prop("disabled", true);
				$("select[name='modal_contacto']").val("").trigger("change");
			}else{
				$("select[name='modal_empresa']").val("init").trigger("change");
				$("select[name='modal_empresa']").prop("disabled", false);	
				$("select[name='modal_contacto']").val("").trigger("change");
			}			
		});		
		
		$("select[name='modal_empresa']").on("change",function() {		
		var modal_empresa_id = $(this).val();
		$("input[name='txt_empresa_id']").val(modal_empresa_id);
		filtrar_contacto(modal_empresa_id);			
		});			
		
		$("select[name='modal_contacto']").on("change",function() {
			var id_contacto = $(this).val();
			var empresa_id = $("input[name='txt_empresa_id']").val();
			pull_area_cargo(id_contacto,empresa_id,tramseg_id);
		});
	}				
});

function Seguimiento(variable,tram_id, PageNumber) {
	$.post("<?php echo URLLOGICA?>seguimiento/observacion/",
    {    	
    	"variable" : variable ,
    	"tram_id" : tram_id ,
    	"PageNumber":PageNumber
    },
    
    function(data, status){
    	var size_data = data.size_data;
    	var last_data = data.last_data;
    	data = data.data;    	
    	$("#linea_seg" + tram_id).html("");		    	
    	for (var newnum = 1; newnum <= data.length; newnum++) {    	
    		var seg_id = data[newnum - 1]["seg_id"];		
			var result_r = data[newnum - 1]["seg_fec_recepcion"];
			var result_t = data[newnum - 1]["seg_fecha_transito"];
			var result_d = data[newnum - 1]["seg_fec_derivado"];
			var result_c = data[newnum - 1]["seg_fec_concluido"];
			var nom_doc = data[newnum - 1]["tram_nom_doc"];
			var estado = data[newnum - 1]["seg_estado"];
			var observacion = data[newnum - 1]["seg_observacion"];
			var cargo_remitente = data[newnum - 1]["CargoRemitente"];
						
			var r,t,d,c,re,de,co,tr,imag;
			var i= '<?php echo URLPUBLIC; ?>/img/editar.png'
			var historial = '<?php echo URLPUBLIC; ?>/img/ojo.png'
			
			if(observacion == null){
				imag = ''
			}else{
				imag = i	
			}
			
			if(estado == 'Recibido'){
				if 	(result_r.length <= 1){
					r= ''
					re=''
				}else{
					re = data[newnum - 1]["seg_fec_recepcion"]
					r= '<?php echo URLPUBLIC; ?>/img/document.png'
					t= ''
					tr = ''
					d= ''
					de = ''
					c= ''
					co = ''
				}
			}
			
			if(estado == 'Transito'){
				if 	(result_t.length <= 1){
					t= ''
					tr = ''
				}else{
					tr = data[newnum - 1]["seg_fecha_transito"]
					t= '<?php echo URLPUBLIC; ?>/img/document.png'
					re=''
					r=''
					d= ''
					de = ''
					c= ''
					co = ''
				}
			}
			
			if(estado == 'Derivado'){
				if 	(result_d.length <= 1){
					d= ''
					de = ''
				}else{
					de = data[newnum - 1]["seg_fec_derivado"]
					d= '<?php echo URLPUBLIC; ?>/img/document.png'
					re=''
					r=''
					c= ''
					co = ''
					t=''
					tr=''
				}
			}
			
			if(estado == 'Concluido' || estado == 'Concluido  Automatico'){
				if 	(result_c.length <= 1){
					c= ''
					co = ''
				}else{
					co = data[newnum - 1]["seg_fec_concluido"]
					c= '<?php echo URLPUBLIC; ?>/img/document.png'
					re=''
					r=''
					t=''
					tr=''
					de=''
					d=''
				}
			}			
			
    		var html = '<tr>'            				
						+ '<td style="text-align: center;width:5%;">' + data[newnum - 1]["indice"] + '</td>'
						+ '<td class="warning" style="width:10%;">' + data[newnum - 1]["NombreRemitente"] + '</td>'	
						+ '<td class="warning" style="width:10%;">' + data[newnum - 1]["AreaRemitente"] + '</td>'																				
						+ '<td class="warning" style="width:10%;">' + data[newnum - 1]["CargoRemitente"] + '</td>'
						+ '<td class="success" style="width:10%;">' + data[newnum - 1]["NombreDestino"] + '</td>'
						+ '<td class="success" style="width:10%;">' + data[newnum - 1]["AreaDestino"] + '</td>'							
						+ '<td class="success" style="width:10%;">' + data[newnum - 1]["CargoDestino"] + '</td>'						
						+ '<td style="text-align: center;width:5%;"><img style ="text-align: center;" src="'+t+'" onclick="abredoc(\''+nom_doc+'\',\''+tram_id+'\');"/>' +tr+ '</td>'
						+ '<td style="text-align: center;width:5%;"><img style ="text-align: center;" src="'+d+'" onclick="abredoc(\''+nom_doc+'\',\''+tram_id+'\');"/>' +de+ '</td>'
						+ '<td style="text-align: center;width:5%;"><img style ="text-align: center;" src="'+r+'" onclick="abredoc(\''+nom_doc+'\',\''+tram_id+'\');"/>' +re+ '</td>'
						+ '<td style="text-align: center;width:5%;"><img style ="text-align: center;" src="'+c+'" onclick="abredoc(\''+nom_doc+'\',\''+tram_id+'\');"/>' +co+ '</td>'
						+ '<td style="text-align: center;" bgcolor= "#fdedec"><img src="'+imag+'" onclick="Observacion(\''+observacion+'\');"/></td>'
						+ '<td style="text-align: center;"><img src="'+historial+'" onclick="Historial(\''+tram_id+'\',\''+seg_id+'\');"/></td>'							
						+ '</tr>';	
			
			$("#linea_seg" + tram_id).append(html);	
		}
    		
    		var number_pagination = '';  
    			
    		var page = (size_data%3==0) ? (size_data/3) : Math.floor(size_data/3)+1;
    		
    		for (var newnum = 0; newnum < page; newnum++) {    			
    			number_pagination += '<a href="#" onclick="Seguimiento(\'listar\','+tram_id+','+newnum+')">'+(newnum+1)+'</a>';
    		}
    		
    		$("#pagination"+tram_id).html("");	
    		var html_pagination = 	'<li><a href="#" onclick="Seguimiento(\'listar\','+tram_id+',0)" aria-label="Primero"><span>&lsaquo;&lsaquo; Primero</span></a></li>'
									<?php 
										if($this->pageactual == 0){ ?>	
									+'<li><a href="#" onclick="Seguimiento(\'listar\','+tram_id+',0)" aria-label="Anterior"><span>&lsaquo; Anterior</span></a></li>'
									<?php 
										}else{ ?>
									+'<li><a href="#" onclick="Seguimiento(\'listar\','+tram_id+',<?php echo $this->pageactual-1;?>)" aria-label="Anterior"><span>&lsaquo; Anterior</span></a></li>'		
									<?php
										}
									?>																	
									+'<li>'
						            +number_pagination					            						           
									+'</li>'
						          	<?php	 
						          		if($this->pageactual == page-1){?>						          						          					          			
										+'<li><a href="#" onclick="Seguimiento(\'listar\','+tram_id+','+(page-1)+')" aria-label="Siguiente"><span>Siguiente &rsaquo;</span></a></li>'
									<?php
										}else{ ?>
											+'<li><a href="#" onclick="Seguimiento(\'listar\','+tram_id+',<?php echo $this->pageactual+1;?>)" aria-label="Siguiente<?php echo $this->pageactual;?>"><span>Siguiente &rsaquo;</span></a></li>'
									<?php
										}		
									?>	
									+'<li><a href="#" onclick="Seguimiento(\'listar\','+tram_id+','+(page-1)+')" aria-label="Ultimo"><span>Ultimo &rsaquo;&rsaquo;</span></a></li>';															
									console.log(html_pagination);
									$("#pagination"+tram_id).append(html_pagination);	
    	
    	
    	var indice = data.length-1;
    	var estado = data[indice].seg_estado;
    	var tip_doc = data[indice].seg_tip_doc;
    	var usuario = '<?php echo $_SESSION['usuario'];?>';
    	var usuario_recibido = data[indice].seg_usu_recepcion;
    	var usuario_transito = data[indice].seg_usuario_transito;
    	var usuario_concluido = data[indice].seg_usu_concluido;
    	var usuario_derivado = data[indice].seg_usu_derivado;
    	var usuario_actual = last_data.seg_usuarios;
    	
    	
		if(estado =='Recibido'){
    		if(usuario == usuario_actual){
	    		$('button#seg_recibido').attr('disabled','disabled');
	    		$('button#seg_concluido').removeAttr('disabled');
	    		$('button#seg_derivarModal').removeAttr('disabled');
	    	}else{
	    		$('button#seg_recibido').attr('disabled','disabled');
	    		$('button#seg_concluido').attr('disabled','disabled');
	    		$('button#seg_derivarModal').attr('disabled','disabled');
	    	}
	    }    	
		
		if (tip_doc == 'OR'){	    	
	    	if(estado =='Transito'){
	    		if(usuario == usuario_actual){
	    			$('button#seg_recibido').removeAttr('disabled');
	    			$('button#seg_concluido').attr('disabled','disabled');	
	    			$('button#seg_derivarModal').attr('disabled','disabled');
	    		}else{
	    			$('button#seg_recibido').attr('disabled','disabled');
	    			$('button#seg_concluido').attr('disabled','disabled');
	    			$('button#seg_derivarModal').attr('disabled','disabled');
	    		}
	    	}
	    }else{
	    	if(estado =='Transito'){
	    		if(usuario == usuario_actual){
	    			$('button#seg_recibido').attr('disabled','disabled');	
	    			$('button#seg_concluido').removeAttr('disabled');
	    			$('button#seg_derivarModal').attr('disabled','disabled');
	    		}else{
	    			$('button#seg_recibido').attr('disabled','disabled');
	    			$('button#seg_concluido').attr('disabled','disabled');
	    			$('button#seg_derivarModal').attr('disabled','disabled');
	    		}
	    	}
	    }
    	if(estado =='Concluido' || estado == 'Concluido  Automatico'){
    		$('button#seg_recibido').attr('disabled','disabled');
    		$('button#seg_concluido').attr('disabled','disabled');
    		$('button#seg_derivarModal').attr('disabled','disabled');
    	}
	});
}

$("button[name='seguimiento_buscar']").on("click",function() {			
	if ($('#text_fec_ini_seg').val() != '') {
   		$('#text_fec_fin_seg').attr('required','required');   		
   	};	
   	
   	if ($('#text_fec_fin_seg').val() != '') {
   		$('#text_fec_ini_seg').attr('required','required');   		
   	};	
});	

$("#seguimiento_limpiar").on("click",function() {
	location.href ="http://intranet.peruvian.pe/STD/ES/seguimiento/listar_seguimiento/index";
});	

function abredoc(nom_doc,id){
	if (nom_doc == "null"){
		alert("No se cargo ningún documento");
	}else{
		var name = nom_doc.replaceAll(" ","_");
		window.open('<?php echo URLLOGICA;?>seguimiento/descargar_archivo/'+name+'/'+id,'_blank');	
	}	
}

function Observacion(observacion){
	$("#alert").html(observacion);
    $("#myModalAlerta1").modal("show");		
}

function Historial(tram_id,seg_id){
	$.post("<?php echo URLLOGICA?>seguimiento/historial_fechas/",
    {    	
    	"tram_id" : tram_id ,
    	"seg_id":seg_id
    },
    
    function(data, status){
    	   	
    	$("#linea_seg").html("");		    	
    	
		var fecha_recepcion = data[0].seg_fec_recepcion;		
		var fecha_transito = data[0].seg_fecha_transito;
		var fecha_derivado = data[0].seg_fec_derivado;
		var fecha_concluido = data[0].seg_fec_concluido;	
		
			var html = '<thead>'														
							+ '<tr>'			
								+ '<td style="text-align:left;"><strong>FECHA TRÁNSITO:</strong></td>'
								+ '<td style="text-align:left;">' + fecha_transito + '</td>'
							+ '</tr>'
							+ '<tr>'
								+ '<td style="text-align:left;"><strong>FECHA RECIBIDO:</strong></td>'	
								+ '<td style="text-align:left;">' + fecha_recepcion + '</td>'
							+ '</tr>'	
							+ '<tr>'
								+ '<td style="text-align:left;"><strong>FECHA DERIVADO:</strong></td>'
								+ '<td style="text-align:left;">' + fecha_derivado + '</td>'
							+' </tr>'
							+' <tr>'
								+ '<td style="text-align:left;"><strong>FECHA CONCLUIDO:</strong></td>'
								+ '<td style="text-align:left;">' + fecha_concluido + '</td>'
							+ '</tr>'	
						+ '</thead>';	
			
			$("#linea_seg").append(html);	
	});
	$("#myModalHistorial").modal("show");	
}

$("#prioridad_seg").on("change",function() {
	$("#prioridad_buscar").val($(this).val());			
	
});	

</script>
<?php include "footer_view.php";?>