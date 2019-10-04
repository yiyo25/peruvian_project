
<?php 


$var_subpro = $_GET['proceso'];
$var_pro = $_GET['proceso'];
$var_subpro_real = $_GET['subproceso'];
$var_usu = $_GET['usuario'];
$var_ano = $_GET['ano'];

$busca=$_GET['busca'];
$ano_hoy = date("Y"); 

$cont_usa= count($datausa);
$cont_pro= count($datapro);
$cont_subpro= count($datasubpro);

$mes = array("","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
        	['Month', 'Eliminados','En Bandeja', 'No Atendidos', 'En Seguimiento','Terminados'],                   	
        <?php	   
        		for($i=0;$i<$cont_pro;$i++){
        	
        	          $nombrex[$i]=$datapro[$i]->Rep_Fechav;
					  $ddmesx[$i]=$datapro[$i]->ddmes;
					  $cantidadx[$i]=$datapro[$i]->Pro_ID;
					  $cantidadxo[$i]=$datapro[$i]->cero;
					  $cantidadxa[$i]=$datapro[$i]->uno;
					  $cantidadxb[$i]=$datapro[$i]->dos;
					  $cantidadxc[$i]=$datapro[$i]->tres;
					  //$cantidadxd[$i]=$datapro[$i]->cuatro;
					  //$cantidadxe[$i]=$datapro[$i]->cinco;
					  $cantidadxf[$i]=$datapro[$i]->seis;
					  //$cantidadxg[$i]=$datapro[$i]->siete;
				      // echo "['".$nombrex[$i]."',".$cantidadx[$i]."],";
						
				      echo "['".$mes[$ddmesx[$i]]."',".$cantidadxo[$i].",".$cantidadxa[$i].",".$cantidadxb[$i].",".$cantidadxc[$i].",".$cantidadxf[$i]."],";			
		} 
		?>      
          ['', 0,0,0,0,0]]);

        var options = {
        width: 1020,
          title : ' Reportes GSO <?php echo $var_ano;?>',
          vAxis: {title: 'Atenciones'},
          hAxis: {title: 'Meses <?php echo $var_ano;?>'},
          //seriesType: 'bars'
          seriesType: 'line'
         // series: {6: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      
      function ejecutar(){
      	
       location.href='EST_ReporteEstadistico.php';
      	
      }
      
      
    </script>
<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<style scoped>
.k-window-title{
	font-size:8px;
	font-weight:bold;
}
#example{
	font-size:8px;
}
#funciones{
	vertical-align: middle;
}
.k-grid-nuevo{
	float:left;
}
.combo{
	float:right;
}


#my_menu{
  width: 1020px;
  height: auto;
  margin-left: 210px;
  margin-top:10px;
  margin-bottom:5px;
  /*margin-right:100px;*/
  background-color: #F8F7F7;
  font-size:12px;
  font-style: normal;	
}

#my_estadistica{
  width: 1020px;
  height: auto;
  margin-left: 210px;
 /* background-color: #0BF331;*/
  /*margin-right:100px;*/
  /*background-color: #FF5733;*/
 font-size:8px;
 font-style: normal;	
}

#my_titulo{
  width: 1020px;
  height: auto;
  /*margin-left: 210px;*/
  margin-top:10px;
  margin-bottom:5px;
  /*margin-right:100px;*/
  /*background-color: #F8F7F7;*/
  font-size:14px;
  font-style:normal;
  font-weight: bold;
  	
}
</style>
<form class="k-content" id="frm_EST_ReporteEstadistico"  >

<div id="my_menu" align="left" >
	 <ul>
	 	<li>
	 	&nbsp;&nbsp;Año &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  
            	: <select id="loc_from" name="ano" onchange="locFromLocTo(this.value)">
				      <option value="-1">Seleccione el Año</option>
				      <?php for($i=2016;$i<= $ano_hoy;$i++){ ?>
				      <option value="<?php echo $i ;?>" <?php if($i==$var_ano){ echo "selected";}?>><?php echo $i;?></option>
				      <?php } ?>
				</select>	
            </li>
        </ul>
<p>
<!--	<ul>
		<li>
  &nbsp;&nbsp;Responsables : <select id="loc_from" name="usuario" onchange="locFromLocTo(this.value)">
				       <option value="0">Todos los Usuarios</option>
				      <?php for($i=0;$i<$num_cod=count($datausa);$i++){ ?>
				      <option value="<?php echo $datausa[$i]->idusuario ;?>" <?php if($datausa[$i]->idusuario==$var_usu){ echo "selected";}?>><?php echo ucwords(strtolower($datausa[$i]->apellido." , ".$datausa[$i]->nombre));?></option>
				      <?php } ?>
				</select>	
      </li>
  </ul> -->

		<ul>
			<li>
			  	&nbsp;&nbsp;Procesos&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:
			  	<select id="loc_from" name="proceso" onchange="submit()">				    
				       <option value="0">Todos los Proceso</option>
				      <?php for($i=0;$i<$num_cod=count($dataesta);$i++){ ?>
				      <option value="<?php echo $dataesta[$i]->Pro_ID ;?>" <?php if($dataesta[$i]->Pro_ID==$var_pro){ echo "selected";}?>><?php echo ucwords(strtolower($dataesta[$i]->Pro_Descripcion));?></option>
				      <?php } ?>
				</select>	
			</li>
		</ul> 
	<p>
	<?php if($var_pro!=0){?>	
		<ul>
			<li>
			  	&nbsp;&nbsp;Sub Procesos&nbsp;&nbsp;:
			  	<select id="loc_from" name="subproceso" onchange="locFromLocTo(this.value);">				    
				      <option value="0">Todos los Sub Proceso</option>
				      <?php for($i=0;$i<$num_cod=count($datasubpro);$i++){ ?>
				      <option value="<?php echo $datasubpro[$i]->SubPro_ID ;?>" <?php if($datasubpro[$i]->SubPro_ID==$var_subpro_real){ echo "selected";}?>><?php echo ucwords(strtolower($datasubpro[$i]->SubPro_Descripcion));?></option>
				      <?php } ?>
				</select>	
			</li>
		</ul> 
    <p>
    <?php } ?>
	 <ul>
        <li>
            &nbsp;<td width="150px"><input name="busca" type="submit" class="button"  value="Generar" />
        </li>
     </ul>       	
</div>
<?php if($busca=='Generar'){ ?>
<div id="my_estadistica">
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
 </div>
<?php }else{ ?>
	<div id="my_estadistica">
    <div  style="width: 900px; height: 500px;"></div>
 </div>
	
<?php } ?>
</form>