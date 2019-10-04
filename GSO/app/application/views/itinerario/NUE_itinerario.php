<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<style>
input,
.k-header{
	margin-bottom:5px;
}
</style>
<div id="ventana"></div>
<div id="notificacion"></div>
<script type="text/x-kendo-template" id="ventanaExito">
	<strong>Se Ingreso el Itinerario</strong>
	<center>
		<button class="k-button" id="okButton">Ok</button>
	</center>
</script>
<div style="width: 1019px;margin: 20px auto 0; font-size:12px">
    <table width="100%" border="0">
        <caption style="text-align:center;margin-bottom:5px; font-weight:bold; font-size:20px;">ITINERARIO</caption>
        <tr>
            <td width="10%">Nro. Vuelo:</td>
            <td width="20%"><input type="text" id="txtnrovuelo" class="k-input k-textbox" style="width:180px;"></td>
            <td width="20%">Matr&iacute;cula:</td>
            <td width="20%">
            	<input type="text" id="cbomatricula" style="width:180px;">
            </td>
            <td width="20%">Tipo de Vuelo:</td>
        	<td width="20%">
            	<input type="text" id="cbotipovuelo" style="width:180px;">
            </td>
        </tr>
        <tr>
            <td width="20%">Ruta:</td>
            <td width="20%">
         		<select name="cboruta" id="cboruta" multiple="multiple" style="width:180px; margin-left:8px;"></select>
            </td>
            <td width="20%">Fecha Inicio:</td>
            <td width="20%"><input type="text" id="txtfechainicio" style="width:180px;"></td>
            <td width="20%">Fecha Fin:</td>
            <td width="20%"><input type="text" id="txtfechafinal" style="width:180px;"></td>
        </tr>
        <tr>
            <td width="20%">Hora Inicio:</td>
            <td width="20%"><input type="text" id="txthinicio" style="width:180px;"></td>
            <td width="20%">Frecuencia:</td>
            <td width="20%">
            	<select name="cbofrecuencia" id="cbofrecuencia" multiple="multiple" style="width:180px; margin-left:8px;"></select>
            </td>
            <td width="20%">RUTA 2:</td>
            <td width="20%" align="center"><input type="text" id="txtruta2" style="width:180px;"></td>
        </tr>
        <tr id="trgenerar">
        	<td colspan="6">
            	<input type="button" id="btnitisiguiente" value="Generar" style="margin:5px;"/>
            </td>
        </tr>
    </table>
    <table>
        <div id="tabla_valores"></div>
	</table>
</div>
<script>
$(document).ready(function(e){
	var dataSource = new kendo.data.DataSource({
		transport: {
			read: {
				url: '<?php echo base_url()?>itinerario/listaciudad',
				dataType: "json"
			}
		}
	});
	$("#txtruta2").kendoAutoComplete({
		dataSource		:	dataSource,
		template		: 	"#= cod_ciudad # | #= nombre_ciudad #",
		dataTextField	:	"cod_ciudad",
		filter			:	"startswith",
		placeholder		:	"Seleccione Rutas...",
		headerTemplate	: 	"<div><h6>Ciudades</h6></div>",
		separator		: 	"-"
	});
	masked('#txthinicio','00:00','');
	combo('#cbomatricula','Seleccione Matrícula','idMatricula','Nombre','<?php echo base_url()?>itinerario/listamatricula');
	combo('#cbotipovuelo','Seleccione Tipo Vuelo','TipVue_Id','TipVue_Abreviatura','<?php echo base_url()?>itinerario/listatipovuelo');
	multiselect('#cboruta','Seleccione la Ruta','Ciudades','cod_ciudad','cod_ciudad','<?php echo base_url()?>itinerario/listaciudad',['LIM']);
	multiselect('#cbofrecuencia','Seleccione la Frecuencia','Días de Semana','dias','dias','<?php echo base_url()?>itinerario/listaDias',['L','M','X','J','V','S','D']);
	var cbomatricula	=	$('#cbomatricula').data('kendoComboBox');
	var cbotipovuelo	=	$('#cbotipovuelo').data('kendoComboBox');
	var cboruta			=	$('#cboruta').data('kendoMultiSelect');
	var cbofrecuencia	=	$("#cbofrecuencia").data("kendoMultiSelect");
	/*
	** Inicio
	*/
	function startChange() {
		var startDate = start.value(),
		endDate = end.value();
		if (startDate) {
			startDate = new Date(startDate);
			startDate.setDate(startDate.getDate());
			end.min(startDate);
		} else if (endDate) {
			start.max(new Date(endDate));
		} else {
			endDate = new Date();
			start.max(endDate);
			end.min(endDate);
		}
	}
	/*
	** Fin
	*/
	function endChange() {
		var endDate = end.value(),
		startDate = start.value();
		if (endDate) {
			endDate = new Date(endDate);
			endDate.setDate(endDate.getDate());
			start.max(endDate);
		} else if (startDate) {
			end.min(new Date(startDate));
		} else {
			endDate = new Date();
			start.max(endDate);
			end.min(endDate);
		}
	}
	var start = $("#txtfechainicio").kendoDatePicker({
					culture: "es-PE",
					change: startChange,
					format: 'dd/MM/yyyy'
				}).data("kendoDatePicker");
	var end	=	$("#txtfechafinal").kendoDatePicker({
					culture: "es-PE",
					change: endChange,
					format: 'dd/MM/yyyy'
				}).data("kendoDatePicker");
		start.max(end.value());
		end.min(start.value());
	/*
	** Estilos de Botones
	*/	
	$("#btnitisiguiente").kendoButton({
		click: calculoVuelo
	});
	/*
	** Calculo
	*/
	function calculoVuelo(){
		/*
		** Validadores
		*/
		if($('#txtnrovuelo').val() == ''){
			notificacion('#notificacion','Por favor ingrese el número de vuelo.');
			$('#txtnrovuelo').focus();	
			return false; 
		}
		if(cbomatricula.value() == ''){
			notificacion('#notificacion','Por favor ingrese la matrícula del avión.');
			cbomatricula.focus();	
			return false;
		}
		if(cbotipovuelo.value() == ''){
			notificacion('#notificacion','Por favor ingrese el tipo de vuelo.');
			cbotipovuelo.focus();
			return false;
		}
		if(cboruta.value().length <= 1){
			notificacion('#notificacion','Por favor arme su ruta.');
			cboruta.focus()
			return false;
		}
		if($('#txtfechainicio').val() == ''){
			notificacion('#notificacion','Por favor ingrese la fecha inicial.');
			$('#txtfechainicio').focus()
			return false;
		}
		if($('#txtfechafinal').val() == ''){
			notificacion('#notificacion','Por favor ingrese la fecha final.');
			$('#txtfechafinal').focus()
			return false;
		}
		if($('#txthinicio').val() == ''){
			notificacion('#notificacion','Por favor ingrese la hora de inicio.');
			$('#txthinicio').focus()
			return false;
		}
		if(cbofrecuencia.value() == ''){
			notificacion('#notificacion','Por favor ingrese la frecuencia.');
			cbofrecuencia.focus()
			return false;
		}		
		/*
		** Variables
		*/
		var numvuelo		=	$("#txtnrovuelo").val();
		var tipvue			=	parseInt(cbotipovuelo.value());
		var ruta			=	cboruta.value();
		var horini			=	$('#txthinicio').val().toString();
		var hhora			=	horini.split(":");
		var horainicio		=	hhora[0]+":"+hhora[1];
		/*
		** Calcular cantidad de rutas
		*/
		var canrut		=	ruta.length;		
		/*
		** Obtener rutas
		*/
		if(isNaN(tipvue)){
			notificacion('#notificacion','Por favor ingrese el tipo de vuelo.');
			return 0;
		}else{
			cadena	=	"numvuelo="+numvuelo+"&tipvue="+tipvue+"&ruta="+ruta+"&canrut="+canrut+"&horainicio="+horainicio;
			$.ajax({
				url 	:	"<?php echo base_url();?>itinerario/descripcionVuelos",
				type	: 	"POST",
				data	: 	cadena,
				success	: 	function(data){
								$("#tabla_valores").html(data);
								$("#tabla_valores").append('<input type="button" id="btngrabarItinerario" value="Grabar"/>');
								$("#btngrabarItinerario").kendoButton({
									click: grabarItinerario
								});							
				}	
			});
		}
    };
	/*
	** Grabar Itinerario
	*/
	function grabarItinerario(){
		var cadena	=	"nrovuelo="+$("#txtnrovuelo").val()+"&matricula="+cbomatricula.value()+"&tipovuelo="+cbotipovuelo.value()+"&ruta="+cboruta.value()+"&canrut="+cboruta.value().length+"&fecinicio="+$("#txtfechainicio").val()+"&fecfin="+$("#txtfechafinal").val()+"&horinicio="+$("#txthinicio").val()+"&frecuencia="+cbofrecuencia.value();
		if(cbotipovuelo.value()==4){
			var cadena	=	cadena+'&horinicio2='+$('#hi'+cboruta.value().length).val();
		}
		$.ajax({
			url 	:	"<?php echo base_url();?>itinerario/grabarItinerario",
			type	: 	"POST",
			data	: 	cadena,
			success	: 	function(data){
							alert(data);
							/*if(data==""){
								ventana('Notificación','#ventanaExito','');
								$("#okButton").click(function(){
									location.href = 'http://intranet.peruvian.pe/app/itinerario/lista';
								});
							}else{
								location.href = 'http://intranet.peruvian.pe/app/itinerario';
							}*/
			}
		});
	}
	/*
	** Funciones 
	*/
	function horasaminutos(hora){
		vhora	=	hora.split(":");
		hhora	=	parseInt(vhora[0])*60;
		mhora	=	parseInt(vhora[1]);
		return	hhora+mhora;		
	}
	function minutosahoras(minutos){
		hhtotal	=	zerrofill(parseInt(minutos/60),2)
		mhtotal	=	zerrofill(minutos%60,2);
		return hhtotal+":"+mhtotal;
	}
	function zerrofill(str, max){
		str	=	str.toString();
		return str.length < max ? zerrofill("0" + str, max) : str;
	}
});
</script>