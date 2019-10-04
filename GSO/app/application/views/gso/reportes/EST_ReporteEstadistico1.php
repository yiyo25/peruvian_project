
<?php 
//var_dump($dataesta);
//die("hola");
echo $var_pro = $_GET['proceso'];
echo "<br>"; 
echo $var_usu = $_GET['usuario'];
echo "<br>";
echo $var_ano = $_GET['ano'];
$ano_hoy = date("Y"); 
echo "<br>";
//echo count($dataesta);
echo $cont_usa= count($datausa);
echo $cont_pro= count($datapro);
/*$tm=new listaCodigos_EST();
$combo_desde=$tm->ListarComboDesde();*/
//echo "<br>";
//echo $dataesta[0]->Pro_ID;


?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
        	['Meses', '# Procesos Atendidos'],
        
        	
        <?php	   for($i=0;$i<$cont_pro;$i++){ 
        	          $nombrex[$i]=$datapro[$i]->Rep_Fechav;
					  $cantidadx[$i]=$datapro[$i]->Pro_ID;
				        echo "['".$nombrex[$i]."',".$cantidadx[$i]."],";
			
			   } ?>
      
          ['--', 0]
          ]);
          var options = {
          width: 1020,
          chart: {
            title: 'Nearby galaxies',
            subtitle: 'distance on the left, brightness on the right'
          },
          bars: 'horizontal', // Required for Material Bar Charts.
          series: {
            1: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            x: {
              distance: {label: 'parsecs'}, // Bottom x-axis.
              brightness: {side: 'top', label: 'Cantidad de Atenciones'} // Top x-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
    };
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
  margin-top: 30px;
  margin-bottom: 30px;
  /*margin-right:100px;*/
  background-color: #FF5733;
	
}
#my_estadistica{
  width: 1020px;
  height: auto;
  margin-left: 210px;
  /*margin-right:100px;*/
  /*background-color: #FF5733;*/
	
}
</style>
<form class="k-content" id="frm_EST_ReporteEstadistico">
<div id="my_menu" align="left" >
	 <ul>
        	<li>
            	Años : <select id="loc_from" name="ano" onchange="locFromLocTo(this.value)">
				       <option value="-1">Seleccione el Año</option>
				      <?php for($i=2016;$i<= $ano_hoy;$i++){ ?>
				      <option value="<?php echo $i ;?>" <?php if($i==$var_ano){ echo "selected";}?>><?php echo $i;?></option>
				      <?php } ?>
				</select>	
            </li>
        </ul>
<p>
	<ul>
		<li>
  Responsables : <select id="loc_from" name="usuario" onchange="locFromLocTo(this.value)">
				       <option value="0">Todos los Usuarios</option>
				      <?php for($i=0;$i<$num_cod=count($datausa);$i++){ ?>
				      <option value="<?php echo $datausa[$i]->idusuario ;?>" <?php if($datausa[$i]->idusuario==$var_usu){ echo "selected";}?>><?php echo ucwords(strtolower($datausa[$i]->apellido." , ".$datausa[$i]->nombre));?></option>
				      <?php } ?>
				</select>	
      </li>
  </ul>
<p>
		<ul>
			<li>
			  	Procesos : <select id="loc_from" name="proceso" onchange="locFromLocTo(this.value)">				    
				       <option value="0">Todos los Proceso</option>
				      <?php for($i=0;$i<$num_cod=count($dataesta);$i++){ ?>
				      <option value="<?php echo $dataesta[$i]->Pro_ID ;?>" <?php if($dataesta[$i]->Pro_ID==$var_pro){ echo "selected";}?>><?php echo ucwords(strtolower($dataesta[$i]->Pro_Descripcion));?></option>
				      <?php } ?>
				</select>	
			</li>
		</ul> 
<p>
	 <ul>
        <li>
            <td width="150px"><input name="busca" type="submit" class="button"  value="Generar" />
        </li>
     </ul>       	
</div>

<div id="my_estadistica">
   <p>
   		<div id="dual_x_div" style="width: 300px; height: 500px;" align="center"></div>
   </p>
</div>
</form>