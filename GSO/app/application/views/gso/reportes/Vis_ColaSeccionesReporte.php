<input type="hidden" id="id" value="<?php echo $dataReporte->Rep_ID;?>"/>
<style>
label {
	display: inline-block;
	width: 150px;
	text-align: right;
}
.rojo{
	color:#F00;
}
</style>
<?php
	if($dataRepSec[2]->RepSec_FechaImplementacion!=''){
		$dataFecha				=	explode('-',$dataRepSec[2]->RepSec_FechaImplementacion);
		$fechaImplementacion	=	$dataFecha[2].'/'.$dataFecha[1].'/'.$dataFecha[0];
	}
?>
<div id="example">
	<div class="demo-section k-header">
        <div id="tabstrip">
            <ul>
            	<li class="k-state-active">
            		Sección I
           		</li>
                <?php
					foreach($dataRepSec as $drs){
						if($drs->RepSec_Estado==0){
				?>
                			<li>
               					<span class="rojo" id="<?php echo $drs->Sec_secID;?>"><?php echo $drs->Sec_Nombre;?></span>
               				</li>
                <?php			
						}else{
				?>
                			<li>
               					<span id="<?php echo $drs->Sec_secID;?>"><?php echo $drs->Sec_Nombre;?></span>
               				</li>
                <?php			
						}
                ?>
                	
                <?php
					}
                ?>                
            </ul>
            <div>
            	<form class="k-content" id="frm_ManReporte">
                    <ul>      	
                        <li>
                            <label for="txtNombre" class="required">Nombre:</label>
                            <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" style="width:300px;" value="Anónimo">
                        </li>
                        <li>
                            <label for="cboProceso" class="required">Proceso:</label>
                            <input type="text" name="cboProceso" id="cboProceso" required data-required-msg=" " style="width:300px;">                    
                            <span class="k-invalid-msg" data-for="cboProceso"></span>
                        </li>
                        <li>
                            <label for="cboSubProceso" class="required">Sub Proceso:</label>
                            <input type="text" name="cboSubProceso" id="cboSubProceso" required data-required-msg=" " style="width:300px;">                    
                            <span class="k-invalid-msg" data-for="cboSubProceso"></span>
                        </li>
                        <li>
                            <label for="cboAspecto" class="required" style="float:left;">Aspecto:</label>
                            <input type="text" name="cboAspecto" id="cboAspecto" style=" float:left;width:298px; margin-left:10px;">
                            <!--required data-required-msg=" "-->
                            <span class="k-invalid-msg" data-for="cboAspecto"></span>
                        </li>
                        <li>
                            <label for="cboTipoReporte" class="required">Tipo de Reporte:</label>
                            <input type="text" name="cboTipoReporte" id="cboTipoReporte" required data-required-msg=" " style="width:300px;">
                            <span class="k-invalid-msg" data-for="cboTipoReporte"></span>
                        </li>                       
                      <li>
                            <label for="txtAreaDescripcion" class="required">Sección 1 - Descripción:</label>
                            <textarea class="k-input k-textbox" style="width:300px;" id="txtAreaDescripcion" data-required-msg=" "><?php echo $dataReporte->Rep_Descripcion;?></textarea>
                            <span class="k-invalid-msg" data-for="txtAreaDescripcion"></span>
                        </li> 
                    </ul>
                </form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion2">
                    <b><?php echo $tituloSeccion2;?></b><br />
                    <span><?php echo $descripcionSeccion2;?></span><br/>
                    <input type="hidden" id="txtidseccion2" value="<?php echo $dataRepSec[0]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion2" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required="required"  data-required-msg=" "><?php echo $dataRepSec[0]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion2"></span>
                    <button id="btnSeccion2">Grabar Sección II</button>
            	</form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion3">
                    <b><?php echo $tituloSeccion3;?></b><br />
                    <span><?php echo $descripcionSeccion3;?></span>
                    <input type="hidden" id="txtidseccion3" value="<?php echo $dataRepSec[1]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion3" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required="required"  data-required-msg=" "><?php echo $dataRepSec[1]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion3"></span>
                    <button id="btnSeccion3">Grabar Sección III</button>
            	</form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion4">
                    <b><?php echo $tituloSeccion4;?></b><br />
                    <span><?php echo $descripcionSeccion4;?></span><br />
                    <input type="hidden" id="txtidseccion4" value="<?php echo $dataRepSec[2]->RepSec_ID;?>"/>
                    <label for="cboTipoAccion" class="required"><b>Tipo de Acción:</b></label>
                    <input type="text" name="cboTipoAccion" id="cboTipoAccion" required data-required-msg=" " style="width:250px;">
                    <textarea id="txtAreaSeccion4" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;"><?php echo $dataRepSec[2]->RepSec_Descripcion;?></textarea>
                    <label for="txtresponsableImplementacion" class="required"><b>R. Implementación:</b></label>
                    <input type="text" name="txtresponsableImplementacion" id="txtresponsableImplementacion" class="k-input k-textbox" required data-required-msg=" " style="width:250px;" value="<?php echo $dataRepSec[2]->RepSec_ResImplementacion;?>"><br />
                    <label for="txtfecImplementacion" class="required"><b>Fecha Implementación:</b></label>
                    <input type="text" name="txtfecImplementacion" id="txtfecImplementacion" required data-required-msg=" " style="width:250px;" value="<?php echo $fechaImplementacion;?>"><br />                    
                    <button id="btnSeccion4">Grabar Sección IV</button>
            	</form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion5">
                    <b><?php echo $tituloSeccion5;?></b><br />
                    <span><?php echo $descripcionSeccion5;?></span>
                    <input type="hidden" id="txtidseccion5" value="<?php echo $dataRepSec[3]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion5" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required="required"  data-required-msg=" "><?php echo $dataRepSec[3]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion5"></span>
                    <button id="btnSeccion5">Grabar Sección V</button>
            	</form>
            </div>
        </div>
</div>

  <p>
      <style scoped>
.demo-section {
    width: 500px;
}
.sunny, .cloudy, .rainy {
    display: inline-block;
    margin: 50px 0 50px 110px;
    width: 128px;
    height: 128px;
    background: url('../content/web/tabstrip/weather.png') transparent no-repeat 0 0;
}

.cloudy{
    background-position: -128px 0;
}

.rainy{
    background-position: -256px 0;
}

.weather {
    width: 200px;
    padding: 65px 110px 50px 0;
    float: right;
}

#tabstrip h2 {
    font-weight: lighter;
    font-size: 5em;
    line-height: 1;
    padding: 0;
    margin: 0;
}

#tabstrip h2 span {
    background: none;
    padding-left: 5px;
    font-size: .5em;
    vertical-align: top;
}

#tabstrip p {
    margin: 0;
    padding: 0;
}
      </style>
      
    <script>
combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>gso/listaProcesos','');
combobox('#cboSubProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>gso/listaSubProcesos','');
multiselect('#cboAspecto','Seleccione el Aspecto','Escoja el aspecto','SubCat_Descripcion','SubCat_ID','<?php echo base_url()?>gso/listaSubCategoria/1','');
combobox('#cboTipoReporte','Seleccione el Tipo de Reporte','SubCat_ID','SubCat_Descripcion','<?php echo base_url()?>gso/listaSubCategoria/2','');
combobox('#cboTipoAccion','Seleccione el Tipo de Acción','SubCat_ID','SubCat_Descripcion','<?php echo base_url()?>gso/listaSubCategoria/4','');
var cboProceso				=	$('#cboProceso').data('kendoComboBox');
var cboSubProceso			=	$('#cboSubProceso').data('kendoComboBox');
var cboAspecto				=	$('#cboAspecto').data('kendoMultiSelect');
var cboTipoReporte			=	$('#cboTipoReporte').data('kendoComboBox');
var cboTipoAccion			=	$('#cboTipoAccion').data('kendoComboBox');
$(document).ready(function() {
    $("#tabstrip").kendoTabStrip({
        animation:  {
            open: {
                effects: "fadeIn"
            }
        }
    });
});
$("#btnSeccion2").kendoButton();
$("#btnSeccion3").kendoButton();
$("#btnSeccion4").kendoButton();
$("#btnSeccion5").kendoButton();

$('#txtNombre').attr('disabled',true);
cboProceso.enable(false);
cboProceso.value('<?php echo $dataReporte->Pro_ID;?>');
cboSubProceso.enable(false);
cboSubProceso.value('<?php echo $dataReporte->SubPro_ID;?>');
cboTipoReporte.enable(false);
cboTipoReporte.value('<?php echo $dataReporte->Rep_TipoReporte;?>');
$('#txtAreaDescripcion').attr('disabled',true);
cboAspecto.enable(false);
var aspecto	=	'<?php echo $dataReporte->Rep_Aspecto;?>';
cboAspecto.value(aspecto.split(','));
cboTipoAccion.value('<?php echo $dataRepSec[2]->Cat_ID;?>');

var validator2 = $("#frm_Seccion2").kendoValidator().data("kendoValidator"),
	status = $(".status");
$('#btnSeccion2').click(function(event){
	event.preventDefault();
	if(validator2.validate()){
		var cadena	=	'txtDescripcion='+$('#txtAreaSeccion2').val()+'&id='+$('#txtidseccion2').val();
				$.ajax({
					type 		: 	'POST',
					url 		: 	'<?php echo base_url()?>gso/grabarSeccionesReporte',
					data 		: 	cadena,
					success		:	function(data){
										$('#sec2').removeAttr('class');
										alert('Se grabo Correctamente');
									}												 
				});	
	}
});
var validator3 = $("#frm_Seccion3").kendoValidator().data("kendoValidator"),
	status = $(".status");
$('#btnSeccion3').click(function(event){
	event.preventDefault();
	if(validator3.validate()){
		var cadena	=	'txtDescripcion='+$('#txtAreaSeccion3').val()+'&id='+$('#txtidseccion3').val();
				$.ajax({
					type 		: 	'POST',
					url 		: 	'<?php echo base_url()?>gso/grabarSeccionesReporte',
					data 		: 	cadena,
					beforeSend	:	function(){
										
									},
					success		:	function(data){
										$('#sec3').removeAttr('class');
										alert('Se grabo Correctamente');
									},
					complete	:	function(){																												
										
									}
												 
				});	
	}
});
datePicker('#txtfecImplementacion');
datePicker('#txtfecVerificacion');
var validator4 = $("#frm_Seccion4").kendoValidator().data("kendoValidator"),
	status = $(".status");
$('#btnSeccion4').click(function(event){
	event.preventDefault();
	if(validator4.validate()){		
		var cadena	=	'cboTipoAccion='+cboTipoAccion.value()+'&resimplementacion='+$('#txtresponsableImplementacion').val()+'&fecImplementacion='+$('#txtfecImplementacion').val()+'&txtDescripcion='+$('#txtAreaSeccion4').val()+'&id='+$('#txtidseccion4').val()+'&idsec=4';
				$.ajax({
					type 		: 	'POST',
					url 		: 	'<?php echo base_url()?>gso/grabarSeccionesReporte',
					data 		: 	cadena,
					beforeSend	:	function(){
										
									},
					success		:	function(data){
										$('#sec4').removeAttr('class');
										alert('Se grabo Correctamente');
									},
					complete	:	function(){																												
										
									}
												 
				});	
	}
});
	
var validator5 = $("#frm_Seccion5").kendoValidator().data("kendoValidator"),
	status = $(".status");
$('#btnSeccion5').click(function(event){
	event.preventDefault();
	if(validator5.validate()){
		var cadena	=	'txtDescripcion='+$('#txtAreaSeccion5').val()+'&id='+$('#txtidseccion5').val();
				$.ajax({
					type 		: 	'POST',
					url 		: 	'<?php echo base_url()?>gso/grabarSeccionesReporte',
					data 		: 	cadena,
					beforeSend	:	function(){
										
									},
					success		:	function(data){
										$('#sec5').removeAttr('class');
										alert('Se grabo Correctamente');
									},
					complete	:	function(){																												
										
									}
												 
				});	
	}
});
      </script>
  </p>
  <p>&nbsp; </p>
</div>