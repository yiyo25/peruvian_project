

<style>
.k-window .k-window-titlebar{
	background-color:#FF6633;
	height:20px;
}
.k-window .k-window-titlebar .k-window-title{
	line-height:20px;
	font-size:12px;
	font-weight:bold;	
	color:#FFFFFF;
}
#cboAspecto_taglist li.k-button{
	margin:1.5px;
}
#frm_ManReporte{
	width: 520px;
    height: 350px;
	font-size:12px;
}
#frm_ManReporte ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
#frm_ManReporte li{
	margin: 5px 0 0 0;
}
label {
	display: inline-block;
	width: 150px;
	text-align: right;
}
.required {
	font-weight: bold;
}
.k-invalid-msg{
	margin-left: 5px;
}
.k-widget.k-tooltip-validation{
	border: none;
}
span.k-tooltip {
	margin-right:0px;
}
span.k-widget{
	border:none;
	box-shadow:none;
}
</style>
<div id="ventana"></div>
<div class="demo-section">	
    <form class="k-content" id="frm_ManReporte" style="padding-bottom:5px; height:auto;">   	
        <p style="color:#666; text-align:justify; margin-bottom:10px">
            <?php echo $descripcion;?>
        </p>
    	<ul>
            	<input type="hidden" id="id" value="<?php echo $dataReporte->Rep_ID;?>"/>        	
            <li>
            	<label for="txtNombre" class="required">Nombre:</label>
                <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" style="width:300px;" value="<?php echo $dataReporte->Rep_Nombre;?>">
            </li>            
            <li>
            	<label for="txtAreaDescripcion" class="required">Sección 1 - Descripción:</label>
                <textarea class="k-input k-textbox" style="width:300px; max-width:300px; min-width:300px;" id="txtAreaDescripcion" data-required-msg=" "><?php echo $dataReporte->Rep_Descripcion;?></textarea>
                <span class="k-invalid-msg" data-for="txtAreaDescripcion"></span>
            </li>
            <li> 
            	<label for="txtDias" class="required" >Due Date:</label>
				<input type="date" class="k-input k-textbox" style="width:150px;" id="txtDias" name="txtDias">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               
                <span class="k-invalid-msg" data-for="txtDias"></span>
                	
            </li>
            <li>
                <label for="cboCodigo" class="required">Código:</label>
                <input type="text" name="cboCodigo" id="cboCodigo" style="width:300px;">
            </li>
            <li id="liCboProceso" style="display:none">
                <label for="cboProceso" class="required">Proceso:</label>
                <input type="text" name="cboProceso" id="cboProceso" required data-required-msg=" " style="width:300px;">                    
                <span class="k-invalid-msg" data-for="cboProceso"></span>
            </li>
            <li id="liCboSubProceso" style="display:none">
                <label for="cboSubProceso" class="required">Sub Proceso:</label>
                <input type="text" name="cboSubProceso" id="cboSubProceso" required data-required-msg=" " style="width:300px;">                    
                <span class="k-invalid-msg" data-for="cboSubProceso"></span>
            </li>
            <li class="input" style="height:25px; margin-bottom:8px;">
                <label for="cboAspecto" class="required" style="float:left; width:182px;">Aspecto:</label>
                <div style="width:298px; float:left; margin-left:4px;">
                    <input type="text" name="cboAspecto" id="cboAspecto" style="width:298px;padding:-5px">
                </div>
                <span class="k-invalid-msg" data-for="cboAspecto"></span>
            </li>
            <li>
            	<label for="cboTipoReporte" class="required">Tipo de Reporte:</label>
                <input type="text" name="cboTipoReporte" id="cboTipoReporte" required data-required-msg=" " style="width:300px;">
                <span class="k-invalid-msg" data-for="cboTipoReporte"></span>
            </li>
            <?php if(str_replace(' ','',$dataReporte->Rep_Adjunto)!==''){?>
                <li style="margin-bottom:10px; height:auto;">
                    <label for="adjunto" class="required">Adjunto:</label>
                    <div class="k-input k-textbox" style="width:300px; max-width:300px; min-width:300px; height:auto; background:#FFFFFF; text-align:left;">
                        <?php
                            $arrayAdjunto	=	explode(',',$dataReporte->Rep_Adjunto);
                            for($aA=0;$aA<count($arrayAdjunto);$aA++){
                                $a	=	$aA+1;
                                echo '<a href="'.$url.'/'.$arrayAdjunto[$aA].'" target="new" style="text-decoration:none; color: #000000;">Adjunto N° '.$a.'</a><br>';
                            }
                        ?> 
                    </div>          
                </li>
            <?php }?>      
            <li class="confirm">
            	<button class="k-button k-primary" type="button" id="btnEnviar">Enviar al Dueño del proceso</button>
            </li>
        </ul>
    </form>
</div>
<script>
combobox('#cboCodigo','Seleccione un Código','id','descripcion','<?php echo base_url()?>iosa/listaCodigo',codigo);//
combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>iosa/listaProcesos',proceso);
combobox('#cboSubProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>iosa/listaSubProcesos','');
multiselect('#cboAspecto','Seleccione el Aspecto','Escoja el aspecto','descripcion','id','<?php echo base_url()?>iosa/listaSubCategoria/1','');
combobox('#cboTipoReporte','Seleccione el Tipo de Reporte','id','descripcion','<?php echo base_url()?>iosa/listaSubCategoria/2','');
var cboCodigo		=	$('#cboCodigo').data('kendoComboBox');
var cboProceso		=	$('#cboProceso').data('kendoComboBox');
var cboSubProceso	=	$('#cboSubProceso').data('kendoComboBox');
var cboAspecto		=	$('#cboAspecto').data('kendoMultiSelect');
var cboTipoReporte	=	$('#cboTipoReporte').data('kendoComboBox');
function codigo(){
	var id	=	cboCodigo.value();
	if(id==1){
		$('#liCboProceso').css('display','block');
		$('#liCboSubProceso').css('display','none');
		cboProceso.value('');
		cboSubProceso.value('');
	}else{
		var cadena	=	'id='+id;
		$.ajax({
			type 		: 	'POST',
			url 		: 	'<?php echo base_url()?>iosa/buscarCodigo',
			data 		: 	cadena,
			success		:	function(data){
								var dataArray	=	data.split('@');
								if(dataArray[0]!=''){
									cboProceso.value(dataArray[0]);
									$('#liCboProceso').css('display','block');
								}else{
									cboProceso.value('');
									$('#liCboProceso').css('display','none');
								}
								if(dataArray[1]!=''){
									cboSubProceso.value(dataArray[1]);										
									$('#liCboSubProceso').css('display','block');											
								}else{
									cboSubProceso.value('');
									$('#liCboSubProceso').css('display','none');
								}
							}
										 
		});	
	}
}
function proceso(){
	var id	=	cboProceso.value();
	var cadena	=	'id='+id;
	$.ajax({
		type 		: 	'POST',
		url 		: 	'<?php echo base_url()?>iosa/haySubproceso',
		data 		: 	cadena,
		success		:	function(data){
							if(data>0){
								$('#cboSubProceso').attr('required','true');
								$('#liCboSubProceso').css('display','block');
								combobox('#cboSubProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>iosa/listaSubProcesos/'+id,'');
							}else{
								$('#cboSubProceso').removeAttr('required');								
								$('#liCboSubProceso').css('display','none');
								cboSubProceso.value('');
							}
						}
									 
	});	
}
$(document).ready(function(e) {
    var validator = $("#frm_ManReporte").kendoValidator().data("kendoValidator"),
	status = $(".status");
	$("#btnEnviar").click(function(event) {
		if (confirm('¿Está conforme con el reporte?')) {
			event.preventDefault();
			if(validator.validate()){
				var cadena	=	'id='+$('#id').val()+'&txtNombre='+$('#txtNombre').val()+'&cboProceso='+cboProceso.value()+'&cboSubProceso='+cboSubProceso.value()+'&cboAspecto='+cboAspecto.value()+'&cboTipoReporte='+cboTipoReporte.value()+'&txtAreaDescripcion='+$('#txtAreaDescripcion').val()+'&txtDias='+$('#txtDias').val();
				/*alert(cadena);
				return 0;*/
				
				$.ajax({
					type 		: 	'POST',
					url 		: 	'<?php echo base_url()?>iosa/enviarDuenoProceso',
					data 		: 	cadena,
					success		:	function(data){
										if(data==='1'){
											alert('Se envío Correctamente');
											var grid = $("#grid").data("kendoGrid");
											grid.dataSource.read();
											ventanaCerrar();
										}else{
											alert(data);
											ventanaCerrar();
										}
									}
												 
				});
			}else{
				status.text("Oops! There is invalid data in the form.")
					.removeClass("valid")
					.addClass("invalid");
			}
		} else {
			return 0;
		}
	});
});
</script>