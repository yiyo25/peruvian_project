
<style>
table{
	font-size:12px;
}
</style>
<?php
	$valfecini	=	explode("-",$detalle->ItiCab_FechaInicio);
	$fechainicio=	$valfecini[2]."/".$valfecini[1]."/".$valfecini[0];
	$valfecfin	=	explode("-",$detalle->ItiCab_FechaFin);
	$fechafin	=	$valfecfin[2]."/".$valfecfin[1]."/".$valfecfin[0];
?>
<input type="hidden" id="id" value="<?php echo $detalle->ItiCab_Id?>"/>
<table width="100%" border="0">
    <tr>
        <td align="left">N°. Vuelo:</td>
        <td>
            <input type="text" class="k-textbox" id="txt_numvuelo" name="txt_numvuelo" required="required" disabled="disabled" style="width:180px;" value="<?php echo $detalle->ItiCab_NumeroVuelo;?>">
        </td>
        <td align="left">&nbsp;Matricula:</td>
        <td>
            <select id="cbo_matricula" placeholder="Selectione Matr&iacute;cula..." style="width:180px;">
				<?php
                    foreach($matricula as $mat){?>
                        <option value="<?php echo $mat->idMatricula?>" <?php if($mat->idMatricula == $detalle->idMatricula) echo "selected"?>><?php echo $mat->Nombre?></option>	
                <?php		
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="left">Tipo Vuelo:</td>
        <td>
            <select id="cbo_tipvuelo" placeholder="Selectione tipo de vuelo..." disabled="disabled" style="width:180px;">
            <?php
                foreach($tipovuelo as $tv){?>
                    <option value="<?php echo $tv->TipVue_Id?>" <?php if($tv->TipVue_Id == $detalle->TipVue_Id) echo "selected"?>><?php echo $tv->TipVue_Abreviatura?></option>	
            <?php		
                }
            ?>
            </select>
        </td>
        <td align="left">&nbsp;Ruta:</td>
        <td>
            <input type="text" class="k-textbox" id="txt_ruta" name="txt_ruta" required="required" disabled="disabled" style="width:180px;" value="<?php echo $detalle->ItiCab_Ruta;?>">
        </td>
    </tr>
    <tr>
        <td align="left">F. Inicio:</td>
        <td>
            <input type="text" id="txt_fecinicio" name="txt_fecinicio" required="required" style="width:180px;" disabled="disabled" value="<?php echo $fechainicio;?>">
        </td>
        <td align="left">&nbsp;F. Fin:</td>
        <td>
            <input type="text" id="txt_fecfin" name="txt_fecfin" required="required" style="width:180px;" value="<?php echo $fechafin;?>">
        </td>
    </tr>
    <tr>
        <td align="left">Hora Inicio:</td>
        <td>
            <input type="text" id="txt_horinicio" name="txt_horinicio" required="required" disabled="disabled" style="width:180px;" value="<?php echo $detalle->ItiHor_Inicio;?>">
        </td>
        <td align="left">&nbsp;Frecuencia:</td>
        <td>
        	<select name="cbofrecuencia" id="cbofrecuencia" multiple="multiple" style="width:180px; margin-left:8px;"></select>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <a href="#" class="k-button k-button-icontext k-grid-cancel" onclick="editarItinerario()">
                Editar
            </a>
            <a href="#" class="k-button k-button-icontext k-grid-cancel" onclick="cerrarfrm()">
                Cerrar
            </a>
        </td>
    </tr>
</table>
<script type="text/javascript">
	$(document).ready(function(e) {
		multiselect('#cbofrecuencia','Seleccione la Frecuencia','Días de Semana','dias','dias','<?php echo base_url()?>itinerario/listaDias',['L','M','X','J','V','S','D']);
		
		/*
		** Combo kendo
		*/
		$("#cbo_matricula").kendoComboBox();
		$("#cbo_tipvuelo").kendoComboBox();
		/*
		** Hora de Inicio
		*/
		$("#txt_horinicio").kendoTimePicker({
			interval:	5,
			format	: 	"HH:mm"
		});
    });
	/*
	** Variables de los Combos en Kendo
	*/
	var tipovuelo	=	$("#cbo_tipvuelo").data("kendoComboBox");
	var matricula	=	$("#cbo_matricula").data("kendoComboBox");
	var hinicio		=	$("#txthinicio").data("kendoTimePicker");
	var frecuencia	=	$("#cbofrecuencia").data("kendoMultiSelect");
	/*
	**
	*/
	var fecinicio	=	$("#txt_fecinicio").kendoDatePicker({
							culture: "es-PE",
							format: "dd/MM/yyyy"
						}).data("kendoDatePicker");;
	var fecfin		= 	$("#txt_fecfin").kendoDatePicker({
							culture: "es-PE",
							format: "dd/MM/yyyy"
						}).data("kendoDatePicker");;	
	fecfin.min('<?php echo $fechainicio;?>');
	
	//fecfin.min('10/10/2014');
	/*
	** Manteniminetos
	*/
	function editarItinerario(){
		if(matricula.value() == ''){
			alertify.error('Por favor ingrese su matrícula.');	
			matricula.focus();
			return false;
		}
		if($("#txt_fecfin").val() == ''){
			alertify.error('Por favor ingrese la fecha final.');	
			$("#txt_fecfin").focus();
			return false;
		} 
		if(frecuencia.value() == ''){
			alertify.error('Por favor ingrese la frecuencia.');	
			frecuencia.focus();
			return false;
		}		var cadena	=	"id="+$("#id").val()+"&numvuelo="+$("#txt_numvuelo").val()+"&matricula="+matricula.value()+"&tipovuelo="+tipovuelo.value()+"&ruta="+$("#txt_ruta").val()+"&fechainicio="+$("#txt_fecinicio").val()+"&fechafin="+$("#txt_fecfin").val()+"&horinicio="+$("#txt_horinicio").val()+"&frecuencia="+frecuencia.value();
		$.ajax({
			url 	:	"<?php echo base_url();?>itinerario/editarItinerario",
			type	: 	"POST",
			data	: 	cadena,
			success	: 	function(data){
							if(data==""){
								var grid = $("#grid").data("kendoGrid");
								grid.dataSource.read();
								ventanaCerrar();	
							}
			}
		});
	}
	/*
	** Acciones
	*/	
	function cerrarfrm(){
		ventanaCerrar();
	}
</script>