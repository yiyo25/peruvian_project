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
#example{
	font-size:12px;
}
#frm_ManReporte{
	width: auto;
    height: auto;
	font-size:12px;
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
.k-content{
	text-align:center;
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
            <ul class="tab">
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
                            <textarea class="k-input k-textbox" style="width:300px;" id="txtAreaDescripcion" data-required-msg=" "><?php echo $dataReporte->Rep_Descripcion;?></textarea>
                            <span class="k-invalid-msg" data-for="txtAreaDescripcion"></span>
                        </li> 
                    </ul>
                </form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion2">
                    <b style="text-align:center;"><?php echo $tituloSeccion2;?></b><br />
                    <span style="text-align:center;"><?php echo $descripcionSeccion2;?></span><br/>
                    <input type="hidden" id="txtidseccion2" value="<?php echo $dataRepSec[0]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion2" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required="required"  data-required-msg=" "><?php echo $dataRepSec[0]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion2"></span>
            	</form>
            </div>
            <div>
            	<form class="k-content" id="frm_Seccion3">
                    <b style="text-align:center;"><?php echo $tituloSeccion3;?></b><br />
                    <span style="text-align:center;"><?php echo $descripcionSeccion3;?></span>
                    <input type="hidden" id="txtidseccion3" value="<?php echo $dataRepSec[1]->RepSec_ID;?>"/>
                    <textarea id="txtAreaSeccion3" class="k-input k-textbox" style="min-width:470px; max-width:470px; min-height:150px; max-height:150px; margin:10px 0;" required="required"  data-required-msg=" "><?php echo $dataRepSec[1]->RepSec_Descripcion;?></textarea>
                    <span class="k-invalid-msg" data-for="txtAreaSeccion3"></span>
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
            	</form>
            </div>
        </div>
</div>

  <p>

      
<script>
combobox('#cboProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>gso/listaProcesos','');
combobox('#cboSubProceso','Seleccione el Proceso','id','descripcion','<?php echo base_url()?>gso/listaSubProcesos','');
multiselect('#cboAspecto','Seleccione el Aspecto','Escoja el aspecto','descripcion','id','<?php echo base_url()?>gso/listaSubCategoria/1','');
combobox('#cboTipoReporte','Seleccione el Tipo de Reporte','id','descripcion','<?php echo base_url()?>gso/listaSubCategoria/2','');
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
$('#txtNombre').attr('disabled',true);
$('#txtAreaSeccion2').attr('disabled',true);
$('#txtAreaSeccion3').attr('disabled',true);
$('#txtAreaSeccion4').attr('disabled',true);
$('#txtresponsableImplementacion').attr('disabled',true);
$('#txtfecImplementacion').attr('disabled',true);
cboTipoAccion.enable(false);
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
datePicker('#txtfecImplementacion');
      </script>
  </p>
</div>