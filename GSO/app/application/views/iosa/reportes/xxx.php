<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<style>
#frm_ManReporte{
	width: 800px;
    height: 300px;
	font-size:14px;
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
	width: 250px;
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
	<form class="k-content" id="frm_ManReporte">    	
        <p style="color:#666; text-align:justify; margin-bottom:10px">
            <?php echo $descripcion;?>
        </p>
    	<ul>        	
            <li>
            	<label for="txtNombre" class="required">Nombre:</label>
                <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" style="width:300px;">
            </li>
            <li>
                <label for="cboProceso" class="required">Proceso</label>
                <input type="text" name="cboProceso" id="cboProceso" required data-required-msg=" " style="width:300px;">                    
                <span class="k-invalid-msg" data-for="cboProceso"></span>
            </li>
            <li>
                <label for="cboAspecto" class="required">Aspecto</label>
                <input type="text" name="cboAspecto" id="cboAspecto" required data-required-msg=" " style="width:300px;">                    
                <span class="k-invalid-msg" data-for="cboAspecto"></span>
            </li>
            <li>
            	<label for="cboTipoReporte" class="required">Tipo de Reporte:</label>
                <input type="text" name="cboTipoReporte" id="cboTipoReporte" required data-required-msg=" " style="width:300px;">
                <span class="k-invalid-msg" data-for="cboTipoReporte"></span>
            </li>
            <li>
            	<label for="cboFuenteInformacion" class="required">Fuente de Información:</label>
                <input type="text" name="cboFuenteInformacion" id="cboFuenteInformacion" required data-required-msg=" " style="width:300px;">
                <span class="k-invalid-msg" data-for="cboFuenteInformacion"></span>
            </li>
            <li id="liEspecificar" style="display:none">
            	<label for="txtareaEspecificar" class="required">Especificar:</label>
                <textarea class="k-input k-textbox" style="width:300px;" id="txtareaEspecificar" data-required-msg=" "></textarea>
                <span class="k-invalid-msg" data-for="txtareaEspecificar"></span>
            </li>            
            <li class="confirm">
            	<button class="k-button k-primary" type="submit">Grabar</button>
            </li>
            <li class="status">
            </li>
        </ul>
    </form>
</div>
<script>
$(document).ready(function(e) {
	combobox('#cboProceso','Seleccione el Proceso','SubPro_ID','SubPro_Abreviatura','<?php echo base_url()?>gso/listaSubProcesos','');
	multiselect('#cboAspecto','Seleccione el Aspecto','Escoja el aspecto','SubCat_Descripcion','SubCat_ID','<?php echo base_url()?>gso/listaSubCategoria/1','');
	combobox('#cboTipoReporte','Seleccione el Aspecto','SubCat_ID','SubCat_Descripcion','<?php echo base_url()?>gso/listaSubCategoria/2','');
	combobox('#cboFuenteInformacion','Seleccione la Fuente de Información','SubCat_ID','SubCat_Descripcion','<?php echo base_url()?>gso/listaSubCategoria/3',especificacion);
	var cboProceso				=	$('#cboProceso').data('kendoComboBox');
	var cboAspecto				=	$('#cboAspecto').data('kendoMultiSelect');
	var cboTipoReporte			=	$('#cboTipoReporte').data('kendoComboBox');
	var cboFuenteInformacion	=	$('#cboFuenteInformacion').data('kendoComboBox');	
	/*function especificacion(){
		if(cboFuenteInformacion.value()==11){
			$('#liEspecificar').css('display','block');
			$('#txtareaEspecificar').attr('required',true);
			$('#txtareaEspecificar').val('');
		}else{
			$('#liEspecificar').css('display','none');
			$('#txtareaEspecificar').attr('required',false);
			$('#txtareaEspecificar').val('');
		}
	}*/
	var validator 				= 	$("#frm_ManReporte").kendoValidator().data("kendoValidator");

	$("form").submit(function(event) {
		
		event.preventDefault();
		if(validator.validate()){
			var cadena	=	'txtNombre='+$('#txtNombre').val()+'&cboProceso='+cboProceso.value()+'&cboAspecto='+cboAspecto.value()+'&cboTipoReporte='+cboTipoReporte.value()+'&cboFuenteInformacion='+cboFuenteInformacion.value()+'&txtareaEspecificar='+$('#txtareaEspecificar').val();
			alert(cadena);
			return 0;
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/grabarReporte',
				data 		: 	cadena,
				beforeSend	:	function(){
									
								},
				success		:	function(data){
									if(data===1){
										alert('Se grabo Correctamente');
									}
								},
				complete	:	function(){																												
									ventanaCerrar();
								}
											 
			});	
		}else{
			status.text("Oops! There is invalid data in the form.")
				.removeClass("valid")
				.addClass("invalid");
		}
	});
});
function especificacion(){
	
	if(cboFuenteInformacion.value()==11){
		$('#liEspecificar').css('display','block');
		$('#txtareaEspecificar').attr('required',true);
		$('#txtareaEspecificar').val('');
	}else{
		$('#liEspecificar').css('display','none');
		$('#txtareaEspecificar').attr('required',false);
		$('#txtareaEspecificar').val('');
	}
}
</script>