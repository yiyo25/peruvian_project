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
      </script>
  </p>
</div>