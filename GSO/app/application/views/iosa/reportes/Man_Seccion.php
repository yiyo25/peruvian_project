<style>
#frm_ManCodigo{
	width: 520px;
    height: 250px;
	font-size:12px;
}
#frm_ManCodigo ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
#frm_ManCodigo li{
	margin: 5px 0 0 0;
}
label {
	display: inline-block;
	width: 150px;
	text-align: right;
}
.required {
	font-weight: bold;
}
.k-invalid-msg{
	margin-left: 5px;
}
.k-widget.k-tooltip-validation{
	border: none;
}
span.k-tooltip {
	margin-right:0px;
}
span.k-widget{
	border:none;
	box-shadow:none;
}
</style>
<div class="demo-section">	
	<form class="k-content" id="frm_ManCodigo">
    	<ul>
        	<li>
            	<label for="txtNombre" class="required">Nombre:</label>
                <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" required data-required-msg=" " style="width:300px;" value="<?php echo $dataSeccion->Sec_Nombre;?>" autocomplete="off"/>
                <span class="k-invalid-msg" data-for="txtNombre"></span>
            </li>
            <li>
            	<label for="txtAreaTitulo" class="required">Título:</label>
                <textarea class="k-input k-textbox" style="width:300px; height:70px" id="txtAreaTitulo" required data-required-msg=" "><?php echo $dataSeccion->Sec_Titulo;?></textarea>
                <span class="k-invalid-msg" data-for="txtAreaTitulo"></span>
            </li>
            <li>
            	<label for="txtAreaDescripcion" class="required">Descripción:</label>
                <textarea class="k-input k-textbox" style="width:300px; height:110px" id="txtAreaDescripcion" required data-required-msg=" "><?php echo $dataSeccion->Sec_descripcion;?></textarea>
                <span class="k-invalid-msg" data-for="txtAreaDescripcion"></span>
            </li>         	
            <li class="confirm">
            	<?php 	if($mantenimiento=='Editar'){?>
                			<button class="k-button k-primary" type="button" id="btnEditar">Editar</button>
                            <input type="hidden" id="id" value="<?php echo $dataSeccion->Sec_ID;?>"/>
                <?php 	}else{?>
            				<button class="k-button k-primary" type="button" id="btnGrabar">Grabar</button>
                 <?php 	}?>
            </li>
        </ul>
    </form>
</div>
<script>
$(document).ready(function(e) {
    var validator = $("#frm_ManCodigo").kendoValidator().data("kendoValidator");	
	$("#btnEditar").click(function(event) {
		event.preventDefault();
		if(validator.validate()){
			var cadena	=	'nombre='+$('#txtNombre').val()+'&titulo='+$('#txtAreaTitulo').val()+'&descripcion='+$('#txtAreaDescripcion').val()+'&id='+$('#id').val();
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>iosa/editarSeccion',
				data 		: 	cadena,
				success		:	function(data){
									if(data==='1'){
										alert('La sección se ha modificado.');
										var grid = $('#grid').data('kendoGrid');
										grid.dataSource.read();
										ventanaCerrar();
									}else{
										ventanaCerrar();
									}
								}
											 
			});	
		}else{
			
		}
	});
});
</script>