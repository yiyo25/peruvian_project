<style>
table{
	border:1px solid #000000;
	border-collapse:collapse;
	font-size:14px;
}
table th, table td {
  border: 1px solid #000000;
}
</style>
<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<div id="ventana"></div>
<table width="800" align="center">
	<form id="frm_ManReporte">
        <tr>
            <td width="200">
                <a href="http://www.peruvian.pe/">
                    <img src="<?php echo base_url();?>img/logo.jpg"/>
                </a>
            </td>
            <td style="background:#E11923; color:#FFFFFF; font-weight:bold; font-size:20px" colspan="2" align="center">SISTEMA DE REPORTES</td>
        </tr>
        <tr>
            <td colspan="3" style="padding:10px; color:#333;" align="justify">
                <?php echo $descripcion;?>
            </td>
        </tr> 
        <tr>
            <td style="padding-left:10px; font-weight:bold">NOMBRE:</td>
            <td colspan="2">
                <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" required data-required-msg=" " style="width:100%;">
                <span class="k-invalid-msg" data-for="txtNombre"></span>
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px; font-weight:bold">PROCESO:</td>
            <td colspan="2">
                <input type="text" name="cboProceso" id="cboProceso" required data-required-msg=" " style="width:100%;">
                <span class="k-invalid-msg" data-for="cboProceso"></span>
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px; font-weight:bold">SUB PROCESO:</td>
            <td colspan="2">
                <input type="text" name="cboSubProceso" id="cboSubProceso" required data-required-msg=" " style="width:100%;">
                <span class="k-invalid-msg" data-for="cboSubProceso"></span>
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px; font-weight:bold">ASPECTO:</td>
            <td colspan="2">
                <input type="text" name="cboAspecto" id="cboAspecto" required data-required-msg=" " style="width:100%;">
                <span class="k-invalid-msg" data-for="cboAspecto"></span>
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px; font-weight:bold">TIPO DE REPORTE:</td>
            <td colspan="2">
                <input type="text" name="cboTipoReporte" id="cboTipoReporte" required data-required-msg=" " style="width:100%;">
                <span class="k-invalid-msg" data-for="cboTipoReporte"></span>
            </td>
        </tr> 
        <tr>
            <td style="padding-left:10px; font-weight:bold">FUENTE DE INFORMACIÓN:</td>
            <td colspan="2">
                <input type="text" name="cboFuenteInformacion" id="cboFuenteInformacion" required data-required-msg=" " style="width:100%;">
                <span class="k-invalid-msg" data-for="cboFuenteInformacion"></span>
            </td>
        </tr>
        <tr id="trEspecificar">
            <td width="200" style="padding-left:10px; font-weight:bold; border-top:0; border-bottom:0; display:none">ESPECIFICAR:</td>
            <td colspan="2" style="border-top:0; border-bottom:0; display:none">
                <textarea style="width:100%; height:50px" class="k-input k-textbox" id="txtareaEspecificar" ></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding:10px; color:#333;" align="justify">
                <span style="font-weight:bold;"><?php echo $tituloSeccion1.'<br>';?></span>
                <p><?php echo $descripcionSeccion1;?></p>
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px; font-weight:bold">DESCRIPCIÓN:</td>
            <td colspan="2">
                <textarea style="width:100%;height:50px;" class="k-input k-textbox" id="txtareaDescripcion" ></textarea>
            </td>
            
        </tr>
        <tr>
            <td style="padding-left:10px; font-weight:bold">ADJUNTAR:</td>
            <td>
                <input name="txtAdjuntar" id="txtAdjuntar" type="file"/>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <button class="k-button k-primary" type="submit">Grabar</button>
            </td>
        </tr> 
	</form>
</table>
<script>
$(document).ready(function(e) {
	combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>gso/listaProcesos','');
	combobox('#cboSubProceso','Seleccione el Sub Proceso','id','descripcion','<?php echo base_url()?>gso/listaSubProcesos','');
	multiselect('#cboAspecto','Seleccione el Aspecto','Escoja el aspecto','SubCat_Descripcion','SubCat_ID','<?php echo base_url()?>gso/listaSubCategoria/1','');
	combobox('#cboTipoReporte','Seleccione el Tipo de Reporte','SubCat_ID','SubCat_Descripcion','<?php echo base_url()?>gso/listaSubCategoria/2','');
	combobox('#cboFuenteInformacion','Seleccione la Fuente de Información','SubCat_ID','SubCat_Descripcion','<?php echo base_url()?>gso/listaSubCategoria/3',especificacion);
	var cboProceso				=	$('#cboProceso').data('kendoComboBox');
	var cboSubProceso			=	$('#cboSubProceso').data('kendoComboBox');
	var cboAspecto				=	$('#cboAspecto').data('kendoMultiSelect');
	var cboTipoReporte			=	$('#cboTipoReporte').data('kendoComboBox');
	var cboFuenteInformacion	=	$('#cboFuenteInformacion').data('kendoComboBox');	
	$("#txtAdjuntar").kendoUpload({
		localization: {
            select: "Subir Archivos"
        }
	});
	function especificacion(){
		if(cboFuenteInformacion.value()==11){
			$('#trEspecificar td').css('display','block');
			$('#txtareaEspecificar').attr('required',true);
			$('#txtareaEspecificar').val('');
		}else{
			$('#trEspecificar td').css('display','none');
			$('#txtareaEspecificar').attr('required',false);
			$('#txtareaEspecificar').val('');
		}
	}
	var validator 				= 	$("#frm_ManReporte").kendoValidator().data("kendoValidator");

	$("form").submit(function(event) {
		
		event.preventDefault();
		if(validator.validate()){
			var cadena	=	'txtNombre='+$('#txtNombre').val()+'&cboProceso='+cboProceso.value()+'&cboSubProceso='+cboSubProceso.value()+'&cboAspecto='+cboAspecto.value()+'&cboTipoReporte='+cboTipoReporte.value()+'&cboFuenteInformacion='+cboFuenteInformacion.value()+'&txtareaEspecificar='+$('#txtareaEspecificar').val()+'&txtareaDescripcion='+$('#txtareaDescripcion').val();
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/grabarReporte',
				data 		: 	cadena,
				beforeSend	:	function(){
									
								},
				success		:	function(data){
									if(data!==0){
										$.ajax({
											type	:	'POST',
											url		:	'<?php echo base_url()?>gso/vistaCodigoReporte',
											data 	: 	'codigo='+data,
											success	: 	function(data2){
															ventana('Código Generado','',data2);
														}
										});
										
									}
									
									
									
									//alert(data);
									/*if(data===1){
										alert('Se grabo Correctamente');
									}*/
								},
				complete	:	function(){																												
									
								}
											 
			});	
		}else{
			status.text("Oops! There is invalid data in the form.")
				.removeClass("valid")
				.addClass("invalid");
		}
	});
});
</script>