<form id="form_principal" class="form-horizontal" style="background-color:#FFF;padding:5px">
    <div class="form-group">
        <label class="col-sm-2 control-label">Nro. Vuelo:</label>
        <div class="col-sm-1">
            <input type="number" class="form-control input-sm" id="txtNroVuelo" placeholder="Nro.">
        </div>
        <label class="col-sm-1 control-label">Matr&iacute;cula:</label>
        <div class="col-sm-2">
            <select id="cboMatricula" class="form-control input-sm" style="width:100%;">
                <?php foreach($listaMatriculas as $value){?>
                    <option value="<?=$value->idMatricula?>"><?=$value->Nombre;?></option>
                <?php }?>
            </select>
        </div>
        <label class="col-sm-1 control-label">Tipo:</label>
        <div class="col-sm-2">
        	<select id="cboTipoVuelo" class="form-control input-sm" style="width:100%;">
                <?php foreach($listaTipoVuelo as $value){?>
                    <option value="<?=$value->TipVue_Id?>"><?=$value->TipVue_Abreviatura;?></option>
                <?php }?>
            </select>
        </div>
        <label class="col-sm-1 control-label">Trayecto:</label>
        <div class="col-sm-2">
            <select id="cboTrayecto" class="form-control input-sm" style="width:100%;">
                <?php foreach($listaTrayecto as $value){?>
                    <option value="<?=$value->TipTra_Id?>"><?=$value->TipTra_Abreviatura;?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Ruta:</label>
        <div class="col-sm-4">
        	<div id="ruta1">
                <select id="cboRuta"  multiple="multiple" data-placeholder="Seleccione los Sectores" style="width:100%;" >
                    <?php foreach($listaCiudad as $value){?>
                        <option value="<?=$value->cod_ciudad?>"><?=$value->cod_ciudad;?></option>
                    <?php }?>
                </select>
            </div>
            <div id="ruta2" style="display:none">
           		<input type="text" class="form-control input-sm" id="txtRuta2" placeholder="Ruta 2" style="width:100%;">
        	</div>
        </div>
        <label class="col-sm-1 control-label">F. Inicio:</label>
        <div class="col-sm-2">
            <input type="date" class="form-control input-sm" id="txtFechaInicio" placeholder="F. Inicio" style="width:100%;">
        </div>
        <label class="col-sm-1 control-label">F. Fin:</label>
        <div class="col-sm-2">
            <input type="date" class="form-control input-sm" id="txtFechaFin" placeholder="F. Fin" style="width:100%;" min="2016-02-19">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Frecuencia:</label>
        <div class="col-sm-4">
            <select id="cboFrecuencia" multiple="multiple" data-placeholder="Seleccione la Frecuencia" style="width:100%">
                <option selected>L</option>
                <option selected>M</option>
                <option selected>X</option>
                <option selected>J</option>
                <option selected>V</option>
                <option selected>S</option>
                <option selected>D</option>
            </select>
            <!--<input type="text" class="form-control input-sm" id="txtFrecuencia" placeholder="Frecuencia">-->
        </div>
        <label class="col-sm-1 control-label">H. Inicio:</label>
        <div class="col-sm-2">
            <input type="time" class="form-control input-sm" id="txtHoraInicio" placeholder="H. Inicio" style="width:100%">
        </div>
        <label class="col-sm-1 control-label">&nbsp;</label>
        <div class="col-sm-2">
            <button type="button" class="btn btn-default btn-sm" onClick="Generar()">Generar</button>
        </div>
    </div>
</form>
<div id="resultadoItinerario" style="display:none">
	
</div>
<script>
$(document).ready(function(e) {	
	function onchangeTrayecto(){
		if(this.value()=='4'){
			$('#ruta1').css('display','none');
			$('#ruta2').css('display','block');
		}else{
			$('#ruta1').css('display','block');
			$('#ruta2').css('display','none');
		}	
	}	
	$("#cboTrayecto").kendoComboBox({
		change: onchangeTrayecto
	});
	$("#cboMatricula").kendoComboBox();
	$("#cboTipoVuelo").kendoComboBox()
	$("#cboRuta").kendoMultiSelect();	
	var frecuencia	= 	$("#cboFrecuencia").kendoMultiSelect().data("kendoMultiSelect");	
	var dataSource = new kendo.data.DataSource({
		transport: {
			read: {
				url: '<?php echo base_url()?>index.php/itinerario/listaCiudadJson',
				dataType: "json"
			}
		}
	});
	$("#txtRuta2").kendoAutoComplete({
		dataSource		:	dataSource,
		template		: 	"#= cod_ciudad # | #= nombre_ciudad #",
		dataTextField	:	"cod_ciudad",
		filter			:	"startswith",
		placeholder		:	"Seleccione Rutas...",
		separator		: 	"-"
	});
	
});
function Generar(){	
	$("#resultadoItinerario").html("");
	var NroVuelo		=	$("#txtNroVuelo").val();
	if(NroVuelo==""){
		alert("Ingrese el Nro. de Vuelo");
		return 0;
	}
	var matricula 		= 	$("#cboMatricula").data("kendoComboBox");
	var tipoVuelo		=	$("#cboTipoVuelo").data("kendoComboBox");
	var tipoTrayecto	=	$("#cboTrayecto").data("kendoComboBox");
	var horaInicio		=	$("#txtHoraInicio").val();	
	if(tipoTrayecto.value()==4){		
		var sector	=	$("#txtRuta2").data("kendoAutoComplete");
	}else{
		var sector	= 	$("#cboRuta").data("kendoMultiSelect");		
	}
	var ruta			=	sector.value();
	if(ruta==""){
		alert("Ingrese la Ruta");
		return 0;
	}
	var fInicio			=	$("#txtFechaInicio").val();
	if(fInicio==""){
		alert("Ingrese la Fecha de Inicio");
		return 0;
	}
	var fFin			=	$("#txtFechaFin").val();
	if(fFin==""){
		alert("Ingrese la Fecha Fin");
		return 0;
	}
	if(horaInicio==""){
		alert("Ingrese la Hora de Inicio");
		return 0;
	}
	
	var cadena			=	"NroVuelo="+NroVuelo+"&ruta="+ruta+"&tipoTrayecto="+tipoTrayecto.value()+"&horaInicio="+horaInicio;
	$.ajax({
				type 	: 	'POST',
				url 	: 	'<?php echo base_url();?>itinerario/gridItinerario',
				data 	: 	cadena,
				success	:	function(data){
								$("#resultadoItinerario").css("display","block");
								$("#form_principal").css("display","none");
								$("#resultadoItinerario").html(data);
							}			
	
	});
}
function atras(){
	$("#form_principal").css("display","block");
	$("#resultadoItinerario").css("display","none");
}
function grabar(){
	var NroVuelo	=	$('#txtNroVuelo').val();
	var Matricula	=	$('#cboMatricula').data('kendoComboBox').value();
	var tipoVuelo	=	$('#cboTipoVuelo').data('kendoComboBox').value();
	var tipoTrayecto=	$("#cboTrayecto").data("kendoComboBox").value();
	if(tipoTrayecto==4){		
		var sector	=	$("#txtRuta2").data("kendoAutoComplete");
	}else{
		var sector	= 	$("#cboRuta").data("kendoMultiSelect").value();		
	}		
	var frecuencia	=	$("#cboFrecuencia").data("kendoMultiSelect").value();	
	var fInicio		=	$("#txtFechaInicio").val();
	var fFin		=	$("#txtFechaFin").val();
	var horaInicio	=	$("#txtHoraInicio").val();	
	var cadena	=	"NroVuelo="+NroVuelo+'&Matricula='+Matricula+'&tipoVuelo='+tipoVuelo+'&tipoTrayecto='+tipoTrayecto+'&sector='+sector+'&frecuencia='+frecuencia+'&horaInicio='+horaInicio+'&fInicio='+fInicio+'&fFin='+fFin+'&n='+$('#nPiernas').val();
	for(n=1;n<=$('#nPiernas').val();n++){
		cadena	+=	'&NroVuelo'+n+'='+$('#txtNroVuelo'+n).val()+'&horaOrigen'+n+'='+$('#txtHoraOrigen'+n).val()+'&horaDestino'+n+'='+$('#txtHoraDestino'+n).val();
	}
	$.ajax({
				type 	: 	'POST',
				url 	: 	'<?php echo base_url();?>itinerario/grabar',
				data 	: 	cadena,
				success	:	function(data){					
								alert(data)
								//$("#resultadoItinerario").css("display","block");
								//$("#form_principal").css("display","none");
								//$("#resultadoItinerario").html(data);
							}			
	
	});
}
</script>
</body>
</html>