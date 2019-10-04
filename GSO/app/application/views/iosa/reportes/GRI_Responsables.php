<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<style scoped>
.k-window-title{
	font-size:12px;
	font-weight:bold;
}
#example{
	font-size:12px;
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
</style>
<div id="ventana"></div>
<div id="example" class="k-content">
    <div id="grid" style="width: 1019px; margin: 15px auto 0;"></div>
</div>
<script type="text/x-kendo-template" id="template">
	<div class="toolbar">
		<a class="k-button k-button-icontext k-grid-nuevo">
			Nuevo Responsable
		</a>
	</div>
</script>
<script type="text/x-kendo-template" id="ventanaAlerta">
	<p>
		<strong>Esta seguro de eliminar el correo:</strong>
		<br/>
		<b>#= data.correo #.</b>
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
			dataSource: {
				transport: {
					read: {
						url			:	'<?php echo base_url();?>iosa/listaResponsables',
						dataType	:	'json'
					}
				},
				pageSize: 12
			},
			toolbar: kendo.template($('#template').html()),
			height: 510,
			sortable: true,
			pageable: {
				refresh	:	true,
				messages:	{
					refresh	:	'Refrescar la grilla',
					first	:	'Ir a la primera página',
					last	:	'Ir a la última página',
					next	:	'Ir a la siguiente página',
					previous:	'Ir a la anterior página',
					empty	: 	'No hay datos',
					display	:	'{0}-{1} de {2} Responsables'
				} 
			},
			columns: [
				//{ field: 'Rep_Nombre', title: 'Nombre'},
				{ field: 'usuario', title: 'Usuario', width: 100},
				{ field: 'responsable', title: 'Responsable'},
				{ field: 'correo', title: 'Correo'},
				{ field: 'proceso', title: 'Proceso'},
				{ field: 'subproceso', title: 'Sub Proceso'},
				{ command: [
					{ 	
						name	: 	'Editar', 
						click	: 	function(e){
										var dataItem 	=	this.dataItem($(e.currentTarget).closest('tr'));
										var cadena		=	'id='+dataItem.id+'&mantenimiento=Editar';
										$.ajax({
											type 	: 	'POST',
											url 	: 	'<?php echo base_url();?>iosa/viewMantenimientoResponsable',
											data 	: 	cadena,
											success	:	function(data){
															ventana('Editar Responsables','',data);
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
												url 	: 	'<?php echo base_url();?>iosa/editarResponsable',
												data 	: 	'id='+dataItem.id+'&mantenimiento=Eliminar',
												success	:	function(data){
																alert(data);
																return 0;
																if(data===1){
																	alert('Se elimino correctamente el registro.');
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
				]}
			],
			editable: false
		});		
		$('.k-grid-nuevo').click(function(e){
			$.ajax({
				type	:	'POST',
				url		:	'<?php echo base_url();?>iosa/viewMantenimientoResponsable',
				data	:	'mantenimiento=Nuevo',
				success	: 	function(data){
								ventana('Nuevo Responsable','',data);
							}
			})
		});
	});
</script>      