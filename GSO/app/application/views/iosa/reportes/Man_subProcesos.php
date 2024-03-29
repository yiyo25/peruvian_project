<style>
#frm_ManProceso{
	width: 520px;
    height: 120px;
	font-size:12px;
}
#frm_ManProceso ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
#frm_ManProceso li{
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
	<form class="k-content" id="frm_ManProceso">    	
        <p style="color:#666; text-align:justify; margin-bottom:10px">
            <?php echo $descripcion;?>
        </p>
    	<ul>
         	<li>
            	<label for="cboProceso" class="required">Proceso:</label>
                <input type="text" name="cboProceso" id="cboProceso" required data-required-msg=" " style="width:300px;">
                <span class="k-invalid-msg" data-for="cboProceso"></span>
            </li>        	
            <li>
            	<label for="txtAbreviatura" class="required">Abreviatura:</label>
                <input type="text" name="txtAbreviatura" class="k-input k-textbox" id="txtAbreviatura" required="required" data-required-msg=" " style="width:300px;" value="<?php echo $dataSubProceso->SubPro_Abreviatura;?>" autocomplete="off">
                <span class="k-invalid-msg" data-for="txtAbreviatura"></span>
            </li>
            <li>
                <label for="txtDescripcion" class="required">Descripción:</label>
                <input type="text" name="txtDescripcion" class="k-input k-textbox" id="txtDescripcion" required="required" data-required-msg=" " style="width:300px;" value="<?php echo $dataSubProceso->SubPro_Descripcion;?>" autocomplete="off">               
                <span class="k-invalid-msg" data-for="txtDescripcion"></span>
            </li>         
            <li class="confirm">
            	<?php 	if($mantenimiento=='Editar'){?>
                			<button class="k-button k-primary" type="button" id="btnEditar">Editar</button>
                            <input type="hidden" id="id" value="<?php echo $dataSubProceso->SubPro_ID;?>"/>
                <?php 	}else{?>
            				<button class="k-button k-primary" type="button" id="btnGrabar">Grabar</button>
                 <?php 	}?>
            </li>
        </ul>
    </form>
</div>
<script>
combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>iosa/listaProcesos','');	
var cboProceso	=	$('#cboProceso').data('kendoComboBox');
$(document).ready(function(e) {
    var validator = $("#frm_ManProceso").kendoValidator().data("kendoValidator");
	$("#btnGrabar").click(function(event) {
		event.preventDefault();
		if(validator.validate()){
			var cadena	=	'cboProceso='+cboProceso.value()+'&txtAbreviatura='+$('#txtAbreviatura').val()+'&txtDescripcion='+$('#txtDescripcion').val();
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>iosa/grabarSubProceso',
				data 		: 	cadena,
				beforeSend	:	function(){
									
								},
				success		:	function(data){
									if(data!==0){
										alert('Se ha Registrado Correctamente el Sub Proceso.')
										var grid = $("#grid").data("kendoGrid");
										grid.dataSource.read();
									}
								},
				complete	:	function(){																												
									ventanaCerrar();
								}
											 
			});	
		}else{
			
		}
	});
	$("#btnEditar").click(function(event) {
		event.preventDefault();
		if(validator.validate()){
			var cadena	=	'id='+$('#id').val()+'&cboProceso='+cboProceso.value()+'&txtAbreviatura='+$('#txtAbreviatura').val()+'&txtDescripcion='+$('#txtDescripcion').val();
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>iosa/editarSubProceso',
				data 		: 	cadena,
				success		:	function(data){
									if(data==='1'){
										var grid = $('#grid').data('kendoGrid');
										grid.dataSource.read();
										ventanaCerrar();
									}else{
										alert('El Dato se encuentra registrado');
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
		cboProceso.value('<?php echo $dataSubProceso->Pro_ID;?>');
	</script>
<?php	} ?>