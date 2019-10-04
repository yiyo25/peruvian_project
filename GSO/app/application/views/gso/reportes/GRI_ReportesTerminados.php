<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<style scoped>
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
#example{
	font-size:12px;
}
.k-filter-menu{
	text-align:left;
}
</style>
<div id="ventana"></div>
<div id="example" class="k-content">
    <div id="grid" style="width: 1019px; margin: 15px auto 0;"></div>
</div>
<script type="text/x-kendo-template" id="template">
	<div class="toolbar">		
		REPORTES SMS - TERMINADOS
	</div>
</script>
<script>
	$(document).ready(function() {
		$("#grid").kendoGrid({
			toolbar: kendo.template($('#template').html()),
			dataSource: {
				transport: {
					read: {
						url			:	'<?php echo base_url();?>gso/listaReporte/Terminado',
						dataType	:	'json'
					}
				},
				schema: {
					model: {
						fields: {
							fecha		:	{ type: "string" },
							codigo		:	{ type: "string" },
							proceso		:	{ type: "string" },
							subProceso	:	{ type: "string" },
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
					display	:	'{0}-{1} de {2} Reportes No Atendidos'
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
					field: "proceso",
					title: 'Proceso',
					width: 80,
					filterable: {
						multi:true ,
						dataSource: {
							transport: {
								read: {
									url: '<?php echo base_url();?>gso/filtrarReporteProceso/Terminado',
									dataType: "json",
									data: {
										field: "proceso"
									}
								}
							}
						}
					}
				},
				{
					field: "subProceso",
					title: 'Sub Proceso',
					width: 100,
					filterable: {
						multi: true,
						dataSource: {
							transport: {
								read: {
									url: '<?php echo base_url();?>gso/filtrarReporteSubProceso/Terminado',
									dataType: "json",
									data: {
										field: "subProceso"
									}
								}
							}
						}
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
						name	: 	'Ver', 
						click	: 	function(e){
										var dataItem 	=	this.dataItem($(e.currentTarget).closest('tr'));
										var cadena		=	'id='+dataItem.id+'&tipo=Terminado';
										$.ajax({
											type 	: 	'POST',
											url 	: 	'<?php echo base_url();?>gso/viewSegumientoReporte',
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