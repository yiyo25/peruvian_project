<?
$array1=explode("/",$fi);
$array2=explode("/",$ff);
$fi=$array1[2]."-".$array1[1]."-".$array1[0];
$ff=$array2[2]."-".$array2[1]."-".$array2[0];
?>
<script>
var wnd,detailsTemplate;
$(document).ready(function(){
	var dataSource = new kendo.data.DataSource({
                
            transport: {
				read: {
					url: "<?php echo base_url();?>gc/conciliar_respuesta/<?php echo $fi."/".$ff."/".$fp; ?>",
					dataType: "json"	
				}
				
			},requestEnd: function(e) {				
				
			}
			,schema: {
				model: {
					id: "id_reserva",
					fields: {
						id_reserva:{},
						fecha_hora : {},
						cod_reserva : {}						
					}
				}
			},
			pageSize: 10
   });
   
   var grid=$("#grid").kendoGrid({
		dataSource: dataSource,
		columns: [ 
			{  field : "id_reserva", title : "Cod", width : 60},
			{  field : "fecha_hora", title : "Fecha", width : 90},
			{  field : "cod_reserva", title : "Cod Reserva", width : 100},			
			{  command: { text: "Detalle", click: showDetails }, title: "Detalle", width: 70},
			
			
		],		
		sortable: true,
		resizable: true,
		selectable: true,
		pageable: {
			refresh: true,
			pageSizes: true,
			buttonCount: 5,
			messages:{
				display:"{0} - {1} de {2} registros",
				itemsPerPage: "registros por pagina",
				empty: "No hay registros"
			}
		},
		editable: { 
			mode: "inline"
		}
}).data("kendoGrid"); 

detailsTemplate = kendo.template($("#template").html());

wnd = $("#details").kendoWindow({
			title: "Detalle Reserva",
			modal: true,
			visible: false,
			resizable: false,
			width: "650px",
			height: "350px",
	  }).data("kendoWindow");


});

function showDetails(e){

	e.preventDefault();
	var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
	wnd.content(detailsTemplate(dataItem));
	wnd.center().open();
	
}
</script>

<div class="interfaces" style="width: 1019px;margin: 0 auto;">

	<div id="grid" class="fuente" NoDetailRecordsText="">
		<div id="window">	
		</div>
		<div id="details"></div>
	</div>
</div>

<style>
.tabla_detalle{
	font-size:13px;
	font-family:Arial;
}
.cab_det{
	background:red;
	color:white;
}
.col_table{
	border-right:1px groove red;
}

.tabla_detalle tr:nth-child(odd){

	background-color: #ffffff;
	
}
.tabla_detalle tr:nth-child(even){

	background:#EDEDED;
	
}
.tabla_detalle tr td:first-child{
	border-left:1px groove red;

}
</style>

<script type="text/x-kendo-template" id="template">
		<table border=0 align="center" class="tabla_detalle">
			<tr>
				<td colspan=4 width=400 height=20 class="cab_det">Detalle de la Reserva </td>
				<td colspan=4 width=300 class="cab_det">Detalle de la Tarjeta </td>
			</tr>
			<tr>
				<td width=75 class="col_table">Id Reserva  </td>
				<td width=100 class="col_table">#= id_reserva #</td>
				<td class="col_table">Ruc</td>
				<td class="col_table">#= id_reserva #</td>
				<td  width=80 class="col_table">IP</td>
				<td class="col_table">#= ip #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Cod Reserva  </td>
				<td class="col_table">#= cod_reserva #</td>
				<td class="col_table">Fecha Op.</td>
				<td class="col_table">#= fecha_hora #</td>
				<td  width=80 class="col_table">CC Code  </td>
				<td class="col_table">#= cc_code #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Nombre  </td>
				<td class="col_table">#= nombre #</td>
				<td class="col_table">Vuelo  </td>
				<td class="col_table">#= vuelo_ida # - #= vuelo_retorno #</td>
				<td  width=80 class="col_table">CC Number  </td>
				<td class="col_table">#= cc_number #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Apellido  </td>
				<td class="col_table">#= apellido #</td>
				<td class="col_table">Ruta  </td>
				<td class="col_table">#= vuelo_vuelta #  #= origen # - #= destino #</td>
				<td  width=80 class="col_table">Card Holder  </td>
				<td class="col_table">#= cc_cardholder #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Documento  </td>
				<td class="col_table">#= tipo_documento #- #= documento #</td>
				<td class="col_table">Fecha ida  </td>
				<td class="col_table">#= vuelo_fecha_depart #</td>
				<td  width=80 class="col_table">Importe  </td>
				<td class="col_table">#= total #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Telefono  </td>
				<td class="col_table">#= telefono #</td>
				<td class="col_table">Hora ida  </td>
				<td class="col_table">#= vuelo_hora_depart #</td>
				<td  width=110 class="col_table">CC Auth / Id SP  </td>
				<td class="col_table">#= cc_auth #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Celular  </td>
				<td class="col_table">#= celular #</td>
				<td class="col_table">Fecha Retorno  </td>
				<td class="col_table">#= vuelo_fecha_return #</td>
				<td  width=110 class="col_table">Respuesta  </td>
				<td class="col_table">#= cc_respuesta #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">E-mail  </td>
				<td class="col_table">#= email #</td>
				<td class="col_table">Hora Retorno  </td>
				<td class="col_table">#= vuelo_hora_return #</td>
				<td  width=110 class="col_table">Codigo Accion  </td>
				<td class="col_table">#= cc_cod_accion #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Pais  </td>
				<td class="col_table">#= pais #</td>
				<td class="col_table">Class  </td>
				<td class="col_table">#= fare_depart # - #= fare_return #</td>
				<td  width=110 class="col_table">Eci  </td>
				<td class="col_table">#= cc_eci #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Ciudad  </td>
				<td class="col_table">#= ciudad #</td>
				<td class="col_table">Pax  </td>
				<td class="col_table">#= adultos # - #= menores # - #= bebes #</td>
				<td  width=110 class="col_table">Cc Pais   </td>
				<td class="col_table">#= cc_pais #</td>
			</tr>
			<tr>
				<td width=80 class="col_table">Direccion  </td>
				<td class="col_table">#= direccion #</td>
				<td class="col_table">Referencia   </td>
				<td colspan=3 class="col_table">#= saft_ReferenceNo #</td>
			</tr>
		</table>
</script>