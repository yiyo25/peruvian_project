<style>
#frm_ManCodigo{
	width: 520px;
    height: 100px;
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
            	<label for="txtAbreviatura" class="required">Abreviatura:</label>
                <input type="text" name="txtAbreviatura" class="k-input k-textbox" id="txtAbreviatura" required data-required-msg=" " style="width:300px;" value="<?php echo $dataSubCategoria->SubCat_Abreviatura;?>" autocomplete="off"/>
                <span class="k-invalid-msg" data-for="txtAbreviatura"></span>
            </li>
            <li>
            	<label for="txtDescripcion" class="required">Descripción:</label>
                <input type="text" name="txtDescripcion" class="k-input k-textbox" id="txtDescripcion" required data-required-msg=" " style="width:300px;" value="<?php echo $dataSubCategoria->SubCat_Descripcion;?>" autocomplete="off"/>
                <span class="k-invalid-msg" data-for="txtDescripcion"></span>
            </li>             	
            <li class="confirm">
            	<?php 	if($mantenimiento=='Editar'){?>
                			<button class="k-button k-primary" type="button" id="btnEditar">Editar</button>
                            <input type="hidden" id="id" value="<?php echo $dataSubCategoria->SubCat_ID;?>"/>
                <?php 	}else{?>
            				<button class="k-button k-primary" type="button" id="btnGrabar">Grabar</button>
                            <input type="hidden" id="idCatID" value="<?php echo $catID;?>"/>
                 <?php 	}?>
            </li>
        </ul>
    </form>
</div>
<script>
$(document).ready(function(e) {
    var validator = $("#frm_ManCodigo").kendoValidator().data("kendoValidator");
	$("#btnGrabar").click(function(event){
		event.preventDefault();
		if(validator.validate()){			
			var cadena	=	'abreviatura='+$('#txtAbreviatura').val()+'&descripcion='+$('#txtDescripcion').val()+'&catID='+$('#idCatID').val();		
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/grabarSubCategoria',
				data 		: 	cadena,
				success		:	function(data){
									if(data!==0){
										alert('Se registro correctamente.');
										var grid = $("#grid").data("kendoGrid");
										grid.dataSource.read();
										ventanaCerrar();
									}
								}											 
			});	
		}else{
			
		}
	});	
	$("#btnEditar").click(function(event) {
		event.preventDefault();
		if(validator.validate()){
			var cadena	=	'abreviatura='+$('#txtAbreviatura').val()+'&descripcion='+$('#txtDescripcion').val()+'&id='+$('#id').val();
			$.ajax({
				type 		: 	'POST',
				url 		: 	'<?php echo base_url()?>gso/editarSubCategoria',
				data 		: 	cadena,
				success		:	function(data){
									if(data==='1'){
										alert('El dato se ha modificado.');
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