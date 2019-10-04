<style>
#frm_ManResponsable{
	width: 520px;
    height: 180px;
	font-size:12px;
}
#frm_ManResponsable ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
#frm_ManResponsable li{
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
	<form class="k-content" id="frm_ManResponsable">
    	<ul>
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
            <li>
            	<label for="cboUsuario" class="required">Usuario:</label>
                <input type="text" name="cboUsuario" id="cboUsuario" required data-required-msg=" " style="width:300px;">
                <span class="k-invalid-msg" data-for="cboUsuario"></span>
            </li>       	
            <li>
            	<label for="txtNombre" class="required">Nombre:</label>
                <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" required data-required-msg=" " style="width:300px;" value="<?php echo $dataResponsable->Res_Nombre;?>" autocomplete="off" disabled="disabled">
                <span class="k-invalid-msg" data-for="txtAbreviatura"></span>
            </li>
            <li>
                <label for="txtEmail" class="required">Correo Electrónico:</label>
                <input type="email" name="Correo Electrónico" class="k-input k-textbox" id="txtEmail" required data-required-msg=" " style="width:300px;" value="<?php echo $dataResponsable->Res_Correo;?>" autocomplete="off">               
                <span class="k-invalid-msg" data-for="txtDescripcion"></span>
            </li>         
            <li class="confirm">
            	<?php 	if($mantenimiento=='Editar'){?>
                			<button class="k-button k-primary" type="button" id="btnEditar">Editar</button>
                            <input type="text" id="id" value="<?php echo $dataResponsable->Res_ID;?>"/>
                <?php 	}else{?>
            				<button class="k-button k-primary" type="button" id="btnGrabar">Grabar</button>
                 <?php 	}?>
            </li>
        </ul>
    </form>
</div>
<script>
combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>gso/listaProcesos',proceso);
combobox('#cboUsuario','Seleccione el Proceso','id','usuario','<?php echo base_url()?>gso/listaUsuario',usuario);
var cboProceso		=	$('#cboProceso').data('kendoComboBox');
var cboUsuario		=	$('#cboUsuario').data('kendoComboBox');
function usuario(){
	$.ajax({
		type	:	'POST',
		url		:	'<?php echo base_url()?>gso/dataUsuario',
		data	:	'id='+cboUsuario.value(),
		success	:	function(data){
						dataUsuario	=	data.split('#');
						$('#txtNombre').val(dataUsuario[0]);
						$('#txtEmail').val(dataUsuario[1]);
					}
	});
}
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
							var cboSubProceso	=	$('#cboSubProceso').data('kendoComboBox');
							$("input[name='cboSubProceso_input']").val('');							
						}else{
							$('#divsubproveso').css('display','none');
							$("input[name='cboSubProceso_input']").val('');
							$('#cboSubProceso').removeAttr('required');
						}
					}
	});
}

$(document).ready(function(e) {
    var validator = $("#frm_ManResponsable").kendoValidator().data("kendoValidator");
	$("#btnGrabar").click(function(event){
		event.preventDefault();
		if(validator.validate()){			
			var cadena	=	'idUsuario='+cboUsuario.value()+'&cboProceso='+cboProceso.value()+'&cboSubProceso='+$('#cboSubProceso').val()+'&email='+$('#txtEmail').val()+'&id='+$('#id').val();		
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/grabarResponsable',
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
			var cadena	=	'idUsuario='+cboUsuario.value()+'&cboProceso='+cboProceso.value()+'&cboSubProceso='+$('#cboSubProceso').val()+'&email='+$('#txtEmail').val()+'&id='+$('#id').val();	
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/editarResponsable',
				data 		: 	cadena,
				success		:	function(data){
									if(data==='1'){
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
		var Proceso		=	<?php echo $dataResponsable->Pro_ID;?>;	
		cboProceso.value('<?php echo $dataResponsable->Pro_ID;?>');
		var SubProceso	=	<?php echo $dataResponsable->SubPro_ID;?>;
		if(SubProceso!=''){
			$('#cboSubProceso').attr('required','true');
			$('#divsubproceso').css('display','block');
			combobox('#cboSubProceso','Seleccione el Sub Proceso','id','descripcion','<?php echo base_url()?>gso/listaSubProcesos/<?php echo $dataResponsable->Pro_ID;?>','');
			var cboSubProceso	=	$('#cboSubProceso').data('kendoComboBox');			
			cboSubProceso.value('<?php echo $dataResponsable->SubPro_ID;?>');
		}else{
			$('#cboSubProceso').removeAttr('required');
		}
		cboUsuario.value('<?php echo str_replace('0','',$dataResponsable->idusuario);?>')
	</script>
<?php	} ?>