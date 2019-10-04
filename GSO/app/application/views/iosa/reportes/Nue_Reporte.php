<!--Borrar-->
<div class="k-edit-form-container">
    <div class="k-edit-label">
        <label for="entidad">Entidad:</label>
    </div>
   	<div class="k-edit-field" data-container-for="entidad">
    	<select id="entidad"></select>
	</div>
	<div class="k-edit-label">
    	<label for="nombre">Nombre:</label>
	</div>
   	<div class="k-edit-field" data-container-for="nombre">
    	<input type="text" class="k-input k-textbox" id="nombre" name="nombre" required data-bind="value:nombre">
	</div>
    <div class="k-edit-buttons k-state-default">
    	<a href="#" class="k-button k-button-icontext k-grid-editar" onclick="grabarRegla()">
            Grabar
        </a>
        <a href="#" class="k-button k-button-icontext k-grid-cancel" onclick="cerrarRegla()">
        	Cancel
        </a>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(e) {
		$("#entidad").kendoComboBox({
			placeholder: "Seleccione la Regla",
			dataTextField: "Ent_Nombre",
			dataValueField: "Ent_Id",
			filter: "contains",
			autoBind: false,
			minLength: 1,
			dataSource: {
				transport: {
					read: {
						dataType:	"json",
						url		:	"<?php echo base_url();?>reglas/entidad"
					}
				}
			}
		});
    });
	function cerrarRegla(){
		wnd.close();
	}
	function grabarRegla(){
		if($("#entidad").val()==""){
			alert("Debe escoger la entidad");
			$("#entidad").focus();
			return 0;
		}
		if($("#nombre").val()==""){
			alert("Debe poner el nombre de la regla");
			$("#nombre").focus();
			return 0;
		}
		var cadena	=	"entidad="+$('#entidad').val()+"&nombre="+$("#nombre").val();
		$.ajax({
			url 	:	"<?php echo base_url();?>reglas/grabarRegla",
			type	: 	"POST",
			data	: 	cadena,
			success	: 	function(data){
							if(data==""){
								alert("Registro grabado correctamente");
								var grid = $("#grid").data("kendoGrid");
								grid.dataSource.read();
								wnd.close();
							}
						}
		});
	}
</script>