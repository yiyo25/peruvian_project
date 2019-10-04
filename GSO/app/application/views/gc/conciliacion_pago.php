<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>css/alertify.core.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css/alertify.default.css" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/alertify.js"></script>
<script>

$(document).ready(function() {
	
	 $("#fi").kendoDatePicker({
	 
		format: "dd/MM/yyyy"
	 
	 });
	 $("#ff").kendoDatePicker({	
	 
		format: "dd/MM/yyyy"
		
	 });
	 
	$("#files").kendoUpload({
		async: {
			saveUrl: "<?php echo base_url();?>gc/subir_csv_pago",
			removeUrl: "<?php echo base_url();?>gc/borrar_csv_pago",
			autoUpload: true
		}
		
	});
	
	$("#procesar").click(function(){
	
		
		/*var fi=$("#fi").val();
		var ff=$("#ff").val();	
		var fp = $("#fp").data("kendoComboBox").value();
		
		if(fi==""){
			alertify.error('Por favor seleccione Fecha Inicio');	
			return false;
		}
		if(ff==""){
			alertify.error('Por favor seleccione Fecha Fin');
			return false;
		}
		if(fp==""){
			alertify.error('Por favor seleccione Forma de Pago');
			return false;
		}*/
		
		$.ajax({
			url :"<?php echo base_url();?>gc/conciliar_pago",
			type: 'POST',
			data:'fi='+fi+"&ff="+ff+"&fp="+fp,
			success: function (data) {
			
					$("#resultado").html(data);
			
			}
		});
		
	})
	
	$("#fp").kendoComboBox({
		dataTextField: "text",
		dataValueField: "value",
		dataSource: [
			{ text: "Visa", value: "VI" },
			{ text: "MasterCard", value: "MC" }
		],
		filter: "contains",
		suggest: true,
		index: 3
	});
	
});
</script>
<div id="contenido">	
	<div class="console"></div>
	<div class="fila">
		<div class="col2">
			<div style="width:100%">
				<div class="demo-section">
					<input name="files" id="files" type="file" />
				</div>
			</div>
		</div>
		<label>Fecha Inicio : </label>
		<div class="col2"><input type="text" id="fi"></div>
		<label>Fecha Fin : </label>
		<div class="col2"><input type="text" id="ff"></div>
		<div class="col2"><input type="button" value="Procesar" class="k-button" style="float:left;"  id="procesar" /></div>
	</div>
	<div class="fila" style="margin-left: -15px;">		
		<input id="fp" placeholder="Formas de Pago..." />		
	</div>
	<div id="resultado" >
		
	</div>
</div>