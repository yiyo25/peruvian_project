<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
<style>
	#example{
		font-size:12px;
	}
	.k-window-title{
		font-size:14px;
		font-weight:bold;
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
        <div id="grid" style="width: 1019px;margin: 15px auto 0;"></div>
    </div>
<!--<div id="details"></div>-->
<script type="text/x-kendo-template" id="template">
	<div class="toolbar">
		<a class="k-button k-button-icontext k-grid-nuevo">
			Añadir Nuevo Itinerario
		</a>
	</div>
</script>
<script type="text/x-kendo-template" id="ventanaAlerta">
	<p>
		<strong>Se encuentra seguro de eliminar:
		<br/>
		El vuelo Nro: <b>#= ItiCab_NumeroVuelo #.</b>
		<br/>
		Ruta: <b>#= ItiCab_Ruta #.</b>
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
            dataSource: {
                transport: {
                    read: {
                                url			:	'<?php echo base_url();?>itinerario/dataItinerario',
                                dataType	:	'json'
                    }
                },
                pageSize: 12
            },
            toolbar: kendo.template($('#template').html()),
            height: 505,
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
                    display	:	'{0}-{1} de {2} Itinerarios Registrados'
                } 
            },
            columns: [
                { field: 'TipTra_Abreviatura', title: 'Tipo', width: 60},
                { field: 'idMatricula', title: 'Matricula', width: 80},
                { field: 'ItiCab_NumeroVuelo', title: 'N°. Vuelo', width: 80},
                { field: 'ItiCab_Ruta', title: 'Ruta', width: 250},
                { field: 'ItiCab_FechaInicio', title: 'Inicio', width: 90},
                { field: 'ItiCab_FechaFin', title: 'Fin', width: 90},
                { field: 'ItiCab_Frecuencia', title: 'Frecuencia', width: 150},
                { title: 'Acciones',
                command: [{
                            name: 'Editar',
                            click: function(e) {
                                e.preventDefault();
                                var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
								 $.ajax({
									type 	: 	'POST',
									url 	: 	'https://intranet.peruvian.pe/app/itinerario/viewEditarItinerario/',
									data 	: 	'id='+dataItem.ItiCab_Id,
									success	:	function(data){
													ventana('Editar Itinerario','',data);
												}
								});								
                            }
                        },
                        { 	name: 'Eliminar', 
                            click:function(e){
                                e.preventDefault();
								var dataItem = this.dataItem($(e.currentTarget).closest('tr'));
								ventana('Confirmación','#ventanaAlerta',dataItem);
								$('#yesButton').click(function(){
									$.ajax({
											type 	: 	'POST',
											url 	: 	'https://intranet.peruvian.pe/app/itinerario/eliminarItinerario/',
											data 	: 	'id='+dataItem.ItiCab_Id,
											success	:	function(data){
															var grid = $('#grid').data('kendoGrid');
															grid.dataSource.read();
															ventanaCerrar();
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
            $(location).attr('href','https://intranet.peruvian.pe/app/itinerario');
        });
    });
</script>