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
    <div id="grid" style="width: 100%; margin: 15px auto 0;"></div>
</div>
<script type="text/x-kendo-template" id="template">
	<div class="toolbar">		
		REPORTES SMS
	</div>
</script>
<script>
	$(document).ready(function() {
		$("#grid").kendoGrid({
			toolbar: kendo.template($('#template').html()),
			dataSource: {
				transport: {
					read: {
						url			:	'<?php echo base_url();?>gso/listaReporteResponsables',
						dataType	:	'json'
					}
				},
				schema: {
					model: {
						fields: {
							fecha		:	{ type: "string" },
							codigo		:	{ type: "string" },
							descripcion	:	{ type: "string" }
						}
					}
				},
				pageSize: 9
			},
			height: 550,
			scrollable: true,
			sortable: false,
			filterable: {
				extra: false,
				operators: {
					string: {
						startswith: "Empieza con",
						eq: "Es igual a",
						neq: "No es igual a"
					}
				},
				messages: {
				  info: "Buscar:",
				  clear: "Limpiar",
				  filter: "Buscar",
				  checkAll: "Todos"
				}
			},
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
				{
					field: 'fecha', 
					title: 'Fecha',
					filterable:false,
					width: 80
				},
				{
					field: 'codigo', 
					title: 'Código',
					width: 70,
					filterable: {
						ui: codigo
				   }
				},
				{
					field: "descripcion",
					title: 'Descripción',
					filterable: false
				},
				 {
                    field: "fecha_recepcion",
                    title: 'F. Reenvío',
                     width: 90,
                    filterable: false
                },
				{ command: [
					{ 	
						name	: 	'Secciones', 
						click	: 	function(e){
										var dataItem 	=	this.dataItem($(e.currentTarget).closest('tr'));
										var cadena		=	'id='+dataItem.id+'&tipo=SeguimientoDP';
										$.ajax({
											type 	: 	'POST',
											url 	: 	'<?php echo base_url();?>gso/viewSeccionesReporteDP',
											data 	: 	cadena,
											success	:	function(data){
															ventana('Ver Reporte','',data);
														}
										});	
									}
					}
				],width:100,title:'Acción'}
		   ]
		});
	});
	function codigo(element) {
		element.kendoAutoComplete({
			dataSource: codigo
		});
	}
</script> 





<script>
/*	$(document).ready(function() {
		var grid = $('#grid').kendoGrid({
			dataSource: {
				transport: {
					read: {
						url			:	'<?php echo base_url();?>gso/listaReporteResponsables',
						dataType	:	'json'
					}
				},
				pageSize: 9
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
					display	:	'{0}-{1} de {2} Reportes'
				} 
			},
			columns: [
				{ field: 'fecha', title: 'Fecha', width: 80},
				{ field: 'codigo', title: 'Código', width: 80},
				{ field: 'descripcion', title: 'Descripción'},
				{ command: [
					{ 	
						name	: 	'Secciones', 
						click	: 	function(e){
										var dataItem 	=	this.dataItem($(e.currentTarget).closest('tr'));
										var cadena		=	'id='+dataItem.id+'&tipo=SeguimientoDP';
										$.ajax({
											type 	: 	'POST',
											url 	: 	'<?php echo base_url();?>gso/',
											data 	: 	cadena,
											success	:	function(data){
															ventana('Ver Reporte','',data);
														}
										});	
									}
					}
				],width:100,title:'Acción'}
			],
			editable: false
		});
	});*/
</script>      