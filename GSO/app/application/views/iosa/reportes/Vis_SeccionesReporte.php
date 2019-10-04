<input type="hidden" id="id" value="<?php echo $dataReporte->Rep_ID;?>"/>
<style>
.k-window .k-window-titlebar{
	background-color:#FF6633;
	height:20px;
}
.k-window .k-window-titlebar .k-window-title{
	line-height:20px;
	font-size:12px;
	font-weight:bold;	
	color:#FFFFFF;
}
label {
	display: inline-block;
	width: 150px;
	text-align: right;
}
.rojo{
	color:#F00;
}
</style>
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


//echo var_dump($dataRepSec);

//$dataRepSec=array_unique($dataRepSec);

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
            	<form class="k-content" id="frm_ManReporte" style="padding-bottom:5px; height:auto;">
                    <ul>      	
                        <li>
                            <label for="txtNombre" class="required">Nombre:</label>
                            <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" style="width:300px;" value="Confidencial">
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
                            <textarea class="k-input k-textbox" style="width:300px; max-width:300px; min-width:300px; min-height:100px; height:100px;" id="txtAreaDescripcion" data-required-msg=" "><?php echo $dataReporte->Rep_Descripcion;?></textarea>
                            <span class="k-invalid-msg" data-for="txtAreaDescripcion"></span>
                      </li>
                      <?php if(str_replace(' ','',$dataReporte->Rep_Adjunto)!==''){?>
                        <li style="margin-bottom:10px; height:auto;">
                            <label for="adjunto" class="required">Adjunto:</label>
                            <div class="k-input k-textbox" style="width:300px; max-width:300px; min-width:300px; height:auto; background:#FFFFFF; text-align:left;">
                                <?php
                                    $arrayAdjunto	=	explode(',',$dataReporte->Rep_Adjunto);
                                    for($aA=0;$aA<count($arrayAdjunto);$aA++){
                                        $a	=	$aA+1;
                                        echo '<a href="https://intranet.peruvian.pe/app//upload/archivosReportesGSO/'.$arrayAdjunto[$aA].'" target="new" style="text-decoration:none; color: #000000;">Adjunto N° '.$a.'</a><br>';
                                    }
                                ?> 
                            </div>          
                		</li>
            		<?php }?> 
                    </ul>
                </form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion2">
                    <b><?php echo $tituloSeccion2;?></b><br />
                    <span><?php echo $descripcionSeccion2;?></span><br/>
                    <input type="hidden" id="txtidseccion2" value="<?php echo $dataRepSec[0]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion2" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required  data-required-msg=" "><?php echo $dataRepSec[0]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion2"></span>
                    <?php
						if($tipo==='Seguimiento' || $tipo==='Terminado'){
						}elseif($tipo==='SeguimientoDP'){
                    		echo "<button id='btnSeccion2'>Grabar Sección II</button>";	
						}
                    ?>
                    	
            	</form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion3">
                    <b><?php echo $tituloSeccion3;?></b><br />
                    <span><?php echo $descripcionSeccion3;?></span>
                    <input type="hidden" id="txtidseccion3" value="<?php echo $dataRepSec[1]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion3" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required  data-required-msg=" "><?php echo $dataRepSec[1]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion3"></span>
                    <?php
						if($tipo==='Seguimiento' || $tipo==='Terminado'){
						}elseif($tipo==='SeguimientoDP'){
                    		echo "<button id='btnSeccion3'>Grabar Sección III</button>";	
						}
                    ?>                    
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
                    <?php
						if($tipo==='Seguimiento' || $tipo==='Terminado'){
						}elseif($tipo==='SeguimientoDP'){
                    		echo "<button id='btnSeccion4'>Grabar Sección IV</button>";	
						}
                    ?>
            	</form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion5">
                    <b><?php echo $tituloSeccion5;?></b><br />
                    <span><?php echo $descripcionSeccion5;?></span>
                    <input type="hidden" id="txtidseccion5" value="<?php echo $dataRepSec[3]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion5" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required  data-required-msg=" "><?php echo $dataRepSec[3]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion5"></span>                    
                    <br/>
                    <br/>
                    <?php
						if($tipo==='Seguimiento'){
							echo "<input type='checkbox' id='terminoReporte'/>Da por concluido el Reporte.";
							echo "<br>";
							echo "<br>";
							echo "<button id='btnSeccion5'>Grabar Sección V</button>";	
						}elseif($tipo==='Terminado' || $tipo==='SeguimientoDP'){
                    		
						}
                    ?>                     
            	</form>
            </div>
        </div>
</div>
  
<script>
combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>iosa/listaProcesos','');
combobox('#cboSubProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>iosa/listaSubProcesos','');
multiselect('#cboAspecto','Seleccione el Aspecto','Escoja el aspecto','descripcion','id','<?php echo base_url()?>iosa/listaSubCategoria/1','');
combobox('#cboTipoReporte','Seleccione el Tipo de Reporte','id','descripcion','<?php echo base_url()?>iosa/listaSubCategoria/2','');
combobox('#cboTipoAccion','Seleccione el Tipo de Acción','id','descripcion','<?php echo base_url()?>iosa/listaSubCategoria/4','');
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
function seccion1(){
	$('#txtNombre').attr('disabled',true);
	cboProceso.enable(true);
	cboProceso.value('<?php echo $dataReporte->Pro_ID;?>');
	cboProceso.enable(false);
	cboSubProceso.enable(true);
	cboSubProceso.value('<?php echo $dataReporte->SubPro_ID;?>');	
	cboSubProceso.enable(false);
	cboTipoReporte.enable(true);
	cboTipoReporte.value('<?php echo $dataReporte->Rep_TipoReporte;?>');
	cboTipoReporte.enable(false);
	$('#txtAreaDescripcion').attr('disabled',true);
	cboAspecto.enable(false);
	var aspecto	=	'<?php echo $dataReporte->Rep_Aspecto;?>';
	cboAspecto.value(aspecto.split(','));	
}
function seccion2(){
	$('#txtAreaSeccion2').attr('disabled',true);
}
function grabarSeccion2(){
	$("#btnSeccion2").kendoButton();
	var validator2 = $("#frm_Seccion2").kendoValidator().data("kendoValidator"),
		status = $(".status");
	$('#btnSeccion2').click(function(event){
		event.preventDefault();
		if(validator2.validate()){
			var cadena	=	'txtDescripcion='+$('#txtAreaSeccion2').val()+'&id='+$('#txtidseccion2').val()+'&estado=3&idReporte='+$('#id').val();
					$.ajax({
						type 		: 	'POST',
						url 		: 	'<?php echo base_url()?>iosa/grabarSeccionesReporte',
						data 		: 	cadena,
						success		:	function(data){
											$('#sec2').removeAttr('class');
											alert('Se grabo Correctamente');
										}												 
					});	
		}
	});
}
function grabarSeccion3(){
	$("#btnSeccion3").kendoButton();
	var validator3 = $("#frm_Seccion3").kendoValidator().data("kendoValidator"),
		status = $(".status");
	$('#btnSeccion3').click(function(event){
		event.preventDefault();
		if(validator3.validate()){
			var cadena	=	'txtDescripcion='+$('#txtAreaSeccion3').val()+'&id='+$('#txtidseccion3').val()+'&estado=4&idReporte='+$('#id').val();
					$.ajax({
						type 		: 	'POST',
						url 		: 	'<?php echo base_url()?>iosa/grabarSeccionesReporte',
						data 		: 	cadena,
						success		:	function(data){
											$('#sec3').removeAttr('class');
											alert('Se grabo Correctamente');
										}
													 
					});	
		}
	});
}
function grabarSeccion4(){
	$("#btnSeccion4").kendoButton();
	var validator4 = $("#frm_Seccion4").kendoValidator().data("kendoValidator"),
		status = $(".status");
	$('#btnSeccion4').click(function(event){
		event.preventDefault();
		if(validator4.validate()){		
			var cadena	=	'cboTipoAccion='+cboTipoAccion.value()+'&resimplementacion='+$('#txtresponsableImplementacion').val()+'&fecImplementacion='+$('#txtfecImplementacion').val()+'&txtDescripcion='+$('#txtAreaSeccion4').val()+'&id='+$('#txtidseccion4').val()+'&idsec=4&estado=5&idReporte='+$('#id').val();
					$.ajax({
						type 		: 	'POST',
						url 		: 	'<?php echo base_url()?>iosa/grabarSeccionesReporte',
						data 		: 	cadena,
						success		:	function(data){
											$('#sec4').removeAttr('class');
											alert('Se grabo Correctamente');
										}
													 
					});	
		}
	});
}
function grabarSeccion5(){
	$("#btnSeccion5").kendoButton();
	var validator5 = $("#frm_Seccion5").kendoValidator().data("kendoValidator"),
		status = $(".status");
	$('#btnSeccion5').click(function(event){		
		event.preventDefault();
		if(validator5.validate()){			
			if( $('#terminoReporte').is(':checked') ) {
				var cadena	=	'txtDescripcion='+$('#txtAreaSeccion5').val()+'&id='+$('#txtidseccion5').val()+'&estado=6'+'&idReporte='+$('#id').val();
			}else{
				var cadena	=	'txtDescripcion='+$('#txtAreaSeccion5').val()+'&id='+$('#txtidseccion5').val()+'&estado=5'+'&idReporte='+$('#id').val();
			}
					$.ajax({
						type 		: 	'POST',
						url 		: 	'<?php echo base_url()?>iosa/grabarSeccionesReporte',
						data 		: 	cadena,
						success		:	function(data){
											$('#sec5').removeAttr('class');
											alert('Se grabo Correctamente');
											var grid = $("#grid").data("kendoGrid");
											grid.dataSource.read();
											ventanaCerrar();
										}
													 
					});	
		}
	});
}
function seccion3(){
	$('#txtAreaSeccion3').attr('disabled',true);
}
function seccion4(){
	cboTipoAccion.value('<?php echo $dataRepSec[2]->Cat_ID;?>');
	$('#txtAreaSeccion4').attr('disabled',true);
	cboTipoAccion.enable(false);
	$('#txtfecImplementacion').attr('disabled',true);
	$('#txtresponsableImplementacion').attr('disabled',true);
	datePicker('#txtfecImplementacion');
}
function seccion5(){
	$('#txtAreaSeccion5').attr('disabled',true);
}
var tipo	=	'<?php echo $tipo;?>';
if(tipo==='Seguimiento'){
	//Boton
	$("#btnSeccion5").kendoButton();	
	//Seccion1
	seccion1();
	//Seccion2
	seccion2();
	//Seccion3
	seccion3();
	//Seccion4
	seccion4();	
	//Accion
	grabarSeccion5();	
}else if(tipo==='Terminado'){
	seccion1();
	seccion2();
	seccion3();
	seccion4();
	seccion5();
}else if(tipo==='SeguimientoDP'){
	datePicker('#txtfecImplementacion');
	cboTipoAccion.value('<?php echo $dataRepSec[2]->Cat_ID;?>');
	seccion1();
	grabarSeccion2();
	grabarSeccion3();
	grabarSeccion4();
}else{
}
</script>
</div>