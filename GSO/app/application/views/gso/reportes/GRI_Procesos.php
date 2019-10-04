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
    <div id="grid" style="width: 100%; margin: 15px auto 0;"></div>
</div>

<script type="text/x-kendo-template" id="template">
    <?php if($permiso_agregar == 1){ ?>
	<div class="toolbar">
		<a class="k-button k-button-icontext k-grid-nuevo">
			Nuevo Proceso
		</a>
	</div>
    <?php }?>
</script>

<script type="text/x-kendo-template" id="ventanaAlerta">
	<p>
		<strong>Esta seguro de eliminar el Proceso:</strong>
		<br/>
		<b>#= data.descripcion #.</b>
	</p>
	<br/>
	<center>
		<button class="k-button" id="yesButton">Si</button>
		<button class="k-button" id="noButton"> No</button>
	</center>
</script>

<script>
    var permisoselimminar =  <?php echo $permiso_eliminar; ?>;
    var permisoseditar =  <?php echo $permiso_editar; ?>;
	$(document).ready(function() {
           var  eliminar = {
                name: 'Eliminar',
                click: function (e) {
                    var dataItem = this.dataItem($(e.currentTarget).closest('tr'));
                    ventana('Confirmación', '#ventanaAlerta', dataItem);
                    $("#yesButton").click(function () {
                        var cadena = 'id=' + dataItem.id + '&mantenimiento=Eliminar';
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url();?>gso/editarProceso',
                            data: cadena,
                            success: function (data) {
                                if (data === '1') {
                                    alert('Se ha eliminado el proceso escogido.');
                                    var grid = $('#grid').data('kendoGrid');
                                    grid.dataSource.read();
                                    ventanaCerrar();
                                }
                            }
                        });
                    })
                    $('#noButton').click(function () {
                        ventanaCerrar();
                    })
                }
            };

	    var editar = {
            name	: 	'Editar',
            click	: 	function(e){
                var dataItem 	=	this.dataItem($(e.currentTarget).closest('tr'));
                var cadena		=	'id='+dataItem.id+'&mantenimiento=Editar';
                $.ajax({
                    type 	: 	'POST',
                    url 	: 	'<?php echo base_url();?>gso/viewMantenimientoProceso',
                    data 	: 	cadena,
                    success	:	function(data){
                        ventana('Editar Permiso','',data);
                    }
                });
            }
        };

	    var command = [];
        if(permisoseditar==1){
            command = [editar];
        }
	    if(permisoselimminar==1){
            command = [eliminar];
        }

	    if(permisoseditar==1 && permisoselimminar==1){
            command = [editar,eliminar];
        }

		var grid = $('#grid').kendoGrid({
			dataSource: {
				transport: {
					read: {
						url			:	'<?php echo base_url();?>gso/listaProcesos',
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
					display	:	'{0}-{1} de {2} Procesos'
				} 
			},
			columns: [
				//{ field: 'Rep_Nombre', title: 'Nombre'},
				{ field: 'abreviatura', title: 'Abreviatura'},
				{ field: 'descripcion', title: 'Descripción'},
				{ command:command}
			],
			editable: false
		});		
		$('.k-grid-nuevo').click(function(e){
			$.ajax({
				type	:	'POST',
				url		:	'<?php echo base_url();?>gso/viewMantenimientoProceso',
				data	:	'mantenimiento=Nuevo',
				success	: 	function(data){
								ventana('Nuevo Proceso','',data);
							}
			})
		});
	});
</script>      