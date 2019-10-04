<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<style scoped>
#example{
	font-size:12px;
}
.toolbar{
	line-height:20px;
	font-size:12px;
	font-weight:bold;	
	color:#FFFFFF;
}
.k-grid-toolbar{
	background:#FF6633;
	height:20px;
}
</style>
<div id="ventana"></div>
<div id="example" class="k-content">
    <div id="grid" style="width: 1019px; margin: 15px auto 0;"></div>
</div>
<script type="text/x-kendo-template" id="template">
	<div class="toolbar">
		Bandeja de Reportes		
	</div>
</script>
<script type="text/x-kendo-template" id="ventanaAlerta">
	<p>
		<strong>Esta seguro de eliminar el Reporte</strong>
		<br/>
	</p>
	<br/>
	<center>
		<button class="k-button" id="yesButton">Si</button>
		<button class="k-button" id="noButton"> No</button>
	</center>
</script>
<script>
	$(document).ready(function() {
		var grid = $('#grid').kendoGrid({
			toolbar: kendo.template($('#template').html()),
			dataSource: {
				transport: {
					read: {
						url			:	'<?php echo base_url();?>gso/listaReporte/Bandeja',
						dataType	:	'json'
					}
				},
				pageSize: 9
			},			
			height: 550,
			scrollable: true,
			sortable: false,
			pageable: {
				refresh	:	true,
				messages:	{
					refresh	:	'Refrescar la grilla',
					first	:	'Ir a la primera página',
					last	:	'Ir a la última página',
					next	:	'Ir a la siguiente página',
					previous:	'Ir a la anterior página',
					empty	: 	'No hay datos',
					display	:	'{0}-{1} de {2} Reportes'
				} 
			},
			columns: [
				{ field: 'fecha', title: 'Fecha', width: 80},
				{ field: 'descripcion', title: 'Descripción'},
				{ title: 'Acción',
					command: [
						{ 	
							name	: 	'Ver', 
							click	: 	function(e){
											var dataItem 	=	this.dataItem($(e.currentTarget).closest('tr'));
											var cadena		=	'id='+dataItem.id+'&mantenimiento=Editar';
											$.ajax({
												type 	: 	'POST',
												url 	: 	'<?php echo base_url();?>gso/viewMantenimientoReporte',
												data 	: 	cadena,
												success	:	function(data){
																ventana('Ver Reporte','',data);
															}
											});
										}
						},
						{ 	
							name	: 	'Eliminar', 
							click	: 	function(e){
										var dataItem = this.dataItem($(e.currentTarget).closest('tr'));
										ventana('Confirmación','#ventanaAlerta',dataItem);
										$("#yesButton").click(function(){
											$.ajax({
												type 	: 	'POST',
												url 	: 	'<?php echo base_url();?>gso/eliminarReporte',
												data 	: 	'id='+dataItem.id,
												success	:	function(data){
																if(data===''){
																	var grid = $('#grid').data('kendoGrid');
																		grid.dataSource.read();	
																		ventanaCerrar();
																}
															}				 
											});
										})
										$('#noButton').click(function(){
											ventanaCerrar();
										})
										}
						}
					], width: 200}
			],
			editable: false
		});
	});
</script>      