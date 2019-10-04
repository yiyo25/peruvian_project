<?php include "header_view.php";?>
<div class="preloader" id="preloader"></div>
<div class="content-wrapper">	
	<section class="content-header" style="padding:5px;">
		<h1>Generar Copia</h1>
		<ol class="breadcrumb">
			<li><a><i class="fa fa-thumb-tack"></i>Generar Copia</a></li>
		</ol>
	</section>
	<section name="contenedor" class="content" style="padding:5px;">
		<div class='box box-danger'>		
			<form method="post" action="<?php echo URLLOGICA?>agregarCopia/insert_contacto" onsubmit="document.forms['insert']['generar'].disabled=true;" name="insert">	
		  	<div class="box-header" style="padding:5px;">
				<div class="col-xs-12" style="margin-bottom: 4px;">					
					<label class="col-md-3 control-label" for="label_num_doc">Número de Documento:</label>
					<div class="col-md-3">
						<select name="select_num_doc" id="select_num_doc" class="form-control input-sm" style="width: 100% !important;">
                			<option value="" selected>SELECCIONE DOCUMENTOS</option>
                    		<?php foreach ($this->objTramU as $listaTram) {?>
								<option value="<?php echo $listaTram["tramseg_id"];?>"><?php echo utf8_encode($listaTram["tram_nro_doc"]);?></option>
							<?php } ?>
						</select>
						<input type="hidden" name="tram_id" id="tram_id" />
					</div>											
				</div>
		  	</div>
			<div class="box-body">
				<div id="MainContent_Div1" class="panel panel-info">
					<div class="panel-heading" style="padding:5px;">
						<h2 class="panel-title">Ingrese datos:</h2>											
					</div>	
					<div style='padding: 5px;'> 
						<div class="row">							
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_nro_documento_reg">Cantidad de Copias:</label>
									<div class="col-md-2">	
										<div class="input-group spinner col-md-4">
										    <input id = "spinner_1" name= "spinner_1" type="text" class="form-control" value="1" onkeypress="return valida(event)">
										    <div class="input-group-btn-vertical">
										      <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
										      <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
										    </div>
										</div>
									</div>
									<div class="col-md-1">	
										<button class="btn btn-default pull-right" type="button" name="copia_generar" id="copia_generar" disabled>Especificar Contactos</button>
									</div>
							</div> 
			        		<div class="col-xs-12" style="margin-bottom: 4px;">								
								<label class="col-md-2 control-label" for="label_nro_documento_reg">Contactos a Derivar:</label>														
			        		</div>
			        		<div class="col-xs-12" style="margin-bottom: 4px;" id="copia"></div>
		        		</div>
		        	</div>
					<div class="modal-footer">
						<button type="submit" name="generar" id="generar" class="btn btn-default btn-sm pull-right">Derivar</button>
					</div>
				</form>
				</div>				
			</div>	
		</div>		
	</section>
</div>
<script>
$('select').select2();

$("select[name='select_num_doc']").on("change",function() {
	var tram_id = $(this).val();
	$('input[name=tram_id]').val(tram_id);	
});

$("select[name='select_num_doc']").on("change",function() {	
	var demo = $("input[name='tram_id']").val(); 	
	if (demo == '') {
		$("button[name='copia_generar']").prop('disabled', true);
    } else{
    	$("button[name='copia_generar']").prop('disabled', false);
    }
});

$( function() {
	var spinner = $("#spinner_1").val();  
    $('input[name=nro_spinner]').val(spinner);	
});
  
  $("button[name=copia_generar]").on("click",function() {
  	var num_spinner = $("#spinner_1").val();
  	
  	$("#copia").html("");	
  	for (var newnum = 1; newnum <= num_spinner; newnum++) {    		
 			
    		var html = '<label class="col-md-1 control-label" for="label_nro_documento_reg">Contacto:</label>'
						+'<div class="col-md-3">'                            
							+'<select name="contac_id_'+newnum+'" id="contac_id_'+newnum+'" class="form-control input-sm js-example-basic-single" style="text-transform: uppercase; width: 100% !important;" method="POST" onchange="demo('+newnum+');">'
			                +'<option value="" selected>SELECCIONE CONTACTO</option>'
		                		<?php foreach ($this->objCon as $listaContacto) {?>
									+'<option value="<?php echo $listaContacto["contac_id"];?>"><?php echo utf8_encode($listaContacto["contac_nombre"]);?></option>'
								<?php } ?>
							+'</select>'
							+'<input type = "hidden" name = "usu_nombre_'+newnum+'" id = "usu_nombre_'+newnum+'">'
							+'<input type = "hidden" name = "usu_correo_'+newnum+'" id = "usu_correo_'+newnum+'">'
							+'<input type = "hidden" name = "usu_numdoc_'+newnum+'" id = "usu_numdoc_'+newnum+'">'												
						+'</div>'
						+'<label class="col-md-1 control-label" for="label_area_contacto">Área Contacto:</label>'
						+'<div class="col-md-3" >'                            
							+'<input class="form-control input-sm" style="text-transform: uppercase;width:100%;" type = "text" name = "area_descripcion_'+newnum+'" id = "area_descripcion_'+newnum+'" disabled>'
							+'<input type = "hidden" name = "area_descripcion1_'+newnum+'" id = "area_descripcion1_'+newnum+'">'
							+'<input type = "hidden" name = "area_id_'+newnum+'" id = "area_id_'+newnum+'">'
						+'</div>'	
						+'<label class="col-md-1 control-label" for="label_cargo_contacto">Cargo del Contacto:</label>'
						+'<div class="col-md-3">'                            
							+'<input class="form-control input-sm" style="text-transform: uppercase;width:100%;" type = "text" name = "cargo_descripcion_'+newnum+'" id = "cargo_descripcion_'+newnum+'" disabled>'
							+'<input type = "hidden" name = "cargo_descripcion1_'+newnum+'" id = "cargo_descripcion1_'+newnum+'">'
							+'<input type = "hidden" name = "cargo_id_'+newnum+'" id = "cargo_id_'+newnum+'">'
						+'</div>'
						+'<div class="clearfix"></div>';	
			
			$("#copia").append(html);	
	} 
	$('select').select2();
	
});

	function demo(num){
		var id_contacto = $("#contac_id_"+num).val();
		var empresa_id = 1;
		pull_area_cargo(id_contacto,empresa_id);								
		function pull_area_cargo(id_contacto,empresa_id) {
			$.ajax({
				method: "POST",
				url: "../registro/lista_area_contacto",
				data: { contacto: id_contacto,empresa:empresa_id},
				dataType: 'json',
			}).done(function( data ) {
				console.log( data[0].areatrab_id );
				console.log( data[0].cargocontac_id );
				$('#usu_nombre_'+num).val(data[0].contac_nombre);
			   // $('#area_id_'+num).val(data[0].areatrab_id);
			    $('#area_descripcion_'+num).val(data[0].area_descripcion);
			    $('#area_descripcion1_'+num).val(data[0].area_descripcion);
			    $('#area_descripcion_'+num).prop("disabled", true);
			    //$('#cargo_id_'+num).val(data[0].cargocontac_id);
			    $('#cargo_descripcion_'+num).val(data[0].cargo_descripcion);
			    $('#cargo_descripcion1_'+num).val(data[0].cargo_descripcion);
			    $('#cargo_descripcion_'+num).prop("disabled", true);
			    $('#usu_correo_'+num).val(data[0].usu_correo);
			    $('#usu_numdoc_'+num).val(data[0].usu_numdoc);
			});
		}
	}	

	function valida(e){
    tecla = (document.all) ? e.keyCode : e.which;
    
     //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
      
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
   }


</script>
<?php include "footer_view.php";?>
