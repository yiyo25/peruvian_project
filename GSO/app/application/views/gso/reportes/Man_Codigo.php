<style>
#frm_ManCodigo{
	width: 520px;
    height: 180px;
	font-size:12px;
}
#frm_ManCodigo ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
#frm_ManCodigo li{
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
<div class="demo-section">	
	<form class="k-content" id="frm_ManCodigo">
    	<ul>
        	<li>
            	<label for="txtCodigo" class="required">Código:</label>
                <input type="text" name="txtCodigo" class="k-input k-textbox" id="txtCodigo" required data-required-msg=" " style="width:300px;" value="<?php echo $dataCodigo->Cod_Abreviatura;?>" autocomplete="off" />
                <span class="k-invalid-msg" data-for="txtCodigo"></span>
            </li>
            <li>
            	<label for="txtAreaDescripcion" class="required">Descripción:</label>
                <textarea class="k-input k-textbox" style="width:300px;" id="txtAreaDescripcion" required data-required-msg=" "><?php echo $dataCodigo->Cod_Descripcion;?></textarea>
                <span class="k-invalid-msg" data-for="txtAreaDescripcion"></span>
            </li>
         	<li>
            	<label for="cboProceso" class="required">Proceso:</label>
                <input type="text" name="cboProceso" id="cboProceso" required data-required-msg=" " style="width:300px;">
                <span class="k-invalid-msg" data-for="cboProceso"></span>
            </li>
            <li style="display:none;" id="divsubproceso">
            	<label for="cboSubProceso" class="required">Sub Proceso:</label>
                <input type="text" name="cboSubProceso" id="cboSubProceso" required data-required-msg=" " style="width:300px;">
                <span class="k-invalid-msg" data-for="cboSubProceso"></span>
            </li>        
            <li class="confirm">
            	<?php 	if($mantenimiento=='Editar'){?>
                			<button class="k-button k-primary" type="button" id="btnEditar">Editar</button>
                            <input type="hidden" id="id" value="<?php echo $dataCodigo->Cod_ID;?>"/>
                <?php 	}else{?>
            				<button class="k-button k-primary" type="button" id="btnGrabar">Grabar</button>
                 <?php 	}?>
            </li>
        </ul>
    </form>
</div>
<script>
combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>gso/listaProcesos',proceso);
combobox('#cboSubProceso','Seleccione el Sub Proceso','id','descripcion','<?php echo base_url()?>gso/listaSubProcesos/','');
var cboProceso		=	$('#cboProceso').data('kendoComboBox');
var cboSubProceso	=	$('#cboSubProceso').data('kendoComboBox');
function proceso(){
	$.ajax({
		type	:	'POST',
		url		:	'<?php echo base_url()?>gso/haySubproceso',
		data	:	'id='+cboProceso.value(),
		success	:	function(data){
						if(data>0){
							$('#cboSubProceso').attr('required','true');
							$('#divsubproceso').css('display','block');
							combobox('#cboSubProceso','Seleccione el Sub Proceso','id','descripcion','<?php echo base_url()?>gso/listaSubProcesos/'+cboProceso.value(),'');
							$("input[name='cboSubProceso_input']").val('');							
						}else{
							$('#divsubproceso').css('display','none');
							$("input[name='cboSubProceso_input']").val('');
							$('#cboSubProceso').removeAttr('required');
						}
					}
	});
}

$(document).ready(function(e) {
    var validator = $("#frm_ManCodigo").kendoValidator().data("kendoValidator");
	$("#btnGrabar").click(function(event){
		event.preventDefault();
		if(validator.validate()){	
			var cadena	=	'codigo='+$('#txtCodigo').val()+'&descripcion='+$('#txtAreaDescripcion').val()+'&cboProceso='+cboProceso.value()+'&cboSubProceso='+cboSubProceso.value();				
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/grabarCodigo',
				data 		: 	cadena,
				success		:	function(data){
									if(data!==0){
										var grid = $("#grid").data("kendoGrid");
										grid.dataSource.read();
										ventanaCerrar();
									}
								}											 
			});	
		}else{
			
		}
	});
	$("#btnEditar").click(function(event) {
		event.preventDefault();
		if(validator.validate()){
			var cadena	=	'codigo='+$('#txtCodigo').val()+'&descripcion='+$('#txtAreaDescripcion').val()+'&cboProceso='+cboProceso.value()+'&cboSubProceso='+cboSubProceso.value()+'&id='+$('#id').val();
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/editarCodigo',
				data 		: 	cadena,
				success		:	function(data){
									if(data==='1'){
										alert('El Código se ha modificado.');
										var grid = $('#grid').data('kendoGrid');
										grid.dataSource.read();
										ventanaCerrar();
									}else{
										ventanaCerrar();
									}
								}
											 
			});	
		}else{
			
		}
	});
});
</script>
<?php 	if($mantenimiento=='Editar'){?>
	<script>
		var Proceso		=	<?php echo $dataCodigo->Pro_ID;?>;	
		cboProceso.value('<?php echo $dataCodigo->Pro_ID;?>');
		var SubProceso	=	<?php echo $dataCodigo->SubPro_ID;?>;
		if(SubProceso!=''){
			$('#cboSubProceso').attr('required','true');
			$('#divsubproceso').css('display','block');
			combobox('#cboSubProceso','Seleccione el Sub Proceso','id','descripcion','<?php echo base_url()?>gso/listaSubProcesos/<?php echo $dataCodigo->Pro_ID;?>','');
			var cboSubProceso	=	$('#cboSubProceso').data('kendoComboBox');			
			cboSubProceso.value('<?php echo $dataCodigo->SubPro_ID;?>');
		}else{
			$('#cboSubProceso').removeAttr('required');
		}
	</script>
<?php	} ?>