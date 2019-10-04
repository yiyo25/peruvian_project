<?php include "header_view.php";?>
<div class="content-wrapper">	
	<section class="content-header" style="padding:5px;">
		<h1>
			Mantenimiento
			<small>Configuración de Alertas</small>
		</h1>
		<ol class="breadcrumb">
			<li><a><i class="fa fa-thumb-tack"></i>Mantenimiento</a></li>
			<li class="active">Configuración de Alertas</li>
		</ol>
	</section>
	<section name="contenedor" class="content" style="padding:5px;">
		<div class='box box-danger'>			
		  	<div class="box-header" style="padding:5px;">
				<div class="col-xs-12" style="margin-bottom: 4px;">					
					<label class="col-md-1 control-label" for="label_num_doc">Tipo Alerta:</label>
					<div class="col-md-3">
						<select name="select_alerta" id="select_alerta" class="form-control input-sm" style="width: 100% !important;">
                			<option value="" selected>SELECCIONE ALERTA</option>
                    		<?php foreach ($this->objAlerta as $listaAlerta) {?>
								<option value="<?php echo $listaAlerta["alerta_id"];?>"><?php echo utf8_encode($listaAlerta["alerta_descripcion"]);?></option>
							<?php } ?>
						</select>
						<input type="hidden" name="nro_alerta" id="nro_alerta" />
					</div>														
				</div>
		  	</div>
			<div class="box-body">
				<div id="MainContent_Div1" class="panel panel-info">
					<div class="panel-heading" style="padding:5px;">
						<h2 class="panel-title">Datos la Alerta:</h2>											
					</div>	
					<div style='padding: 5px;'> 
						<div class="row">					
							<div class="col-xs-12" style="margin-bottom: 4px;">
		                   		<label class="col-md-2 control-label" for="label_asunto">Asunto:<span style="color: #FF0000"><strong>*</strong></span></label>
		                   		<div class="col-md-8">
		                   			<textarea name="text_asunto" maxlength="450" rows="4" cols="30" class="form-control input-sm" style="height:71px;resize:none" required></textarea>
		                   		</div>		                   		
		               		</div>
		                	<div class="col-xs-12" style="margin-bottom: 4px;">
		                   		<label class="col-md-2 control-label" for="label_cuerpo">Cuerpo Mensaje:<span style="color: #FF0000"><strong>*</strong></span></label>
		                   		<div class="col-md-8">
		                   			<textarea name="text_cuepo_msj" maxlength="450" rows="4" cols="30" class="form-control input-sm" style="height:71px;resize:none" required></textarea>
		                   		</div><span style="color: #A4A4A4;font-size: 11px;" id="leyenda"></span>		                   		
		               		</div>  
		               		<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_correo_origen">Correo Origen:<span style="color: #FF0000"><strong>*</strong></span></label>
								<div class="col-md-8">                            
									<input type="text" name="text_correo_origen" id ="text_correo_origen" maxlength="300" class="form-control input-sm" style="width: 100% !important;" required>
								</div>
							</div> 
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_correo_copia">Correo Copia:</label>
								<div class="col-md-8">                            
									<input type="text" name="text_correo_copia" id ="text_correo_copia" maxlength="300" class="form-control input-sm" style="width: 100% !important;">
								</div>								
							</div>
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_correo_copia">Tiempo:</label>
								<div class="col-md-1">                            
									<input type="text" name="text_tiempo" id ="text_tiempo" maxlength="50" class="form-control input-sm" style="width: 100% !important;">									
								</div><span style="color: #A4A4A4;font-size: 11px;" id="texto"></span>
							</div> 
							<div class="col-xs-12" style="margin-bottom: 4px;">
								<label class="col-md-2 control-label" for="label_estado">Estado:</label>
								<div class="col-md-2">                            
									<select name="select_estado" id="select_estado" class="form-control input-sm" style="width: 100% !important;">
			                			<option value="" selected>ESTADO</option>			                    		
										<option value="0">INACTIVO</option>
										<option value="1">ACTIVO</option>
									</select>
								</div>								
							</div>      
			        	</div> 
		        	</div>
		        </div>
                <?php if($this->permisos[0]["Agregar"]){ ?>
				<div class="col-xs-12">
					<button type="button" name="reg_editar" id="reg_editar" class="btn btn-default btn-sm pull-right">Grabar</button>
				</div>
                <?php } ?>
			</div>			
		</div>		
	</section>
</div>

<script>	
$('select').select2();

$("select[name='select_alerta']").on("change",function() {
	var num_alerta = $(this).val();
	cargar_datos(num_alerta);		
});

function cargar_datos(num_alerta) {
	$.ajax({	
	  method: "POST",
	  url: "../alertasEdit/cargaAlertas/",	
	  data: { num_alerta: num_alerta},
	  dataType: 'json',
	}).done(function( data ) {		
	    console.log(data[0].alerta_asunto);		      
	    $("textarea[name='text_asunto']").val(data[0].alerta_asunto);
	    console.log(data[0].alerta_mensaje);
	    $("textarea[name='text_cuepo_msj']").val(data[0].alerta_mensaje);	      
	    console.log(data[0].alerta_correo_origen);
	    $('#text_correo_origen').val(data[0].alerta_correo_origen);
	    console.log(data[0].alerta_correo_copia);
	    $('#text_correo_copia').val(data[0].alerta_correo_copia);
	    console.log(data[0].alerta_tiempo_dia);
	    $('#text_tiempo').val(data[0].alerta_tiempo_dia);  
	    console.log(data[0].alerta_estado);
	    $("select[name='select_estado']").val(data[0].alerta_estado).trigger("change");;   
	});	
} 	

$("button[name='reg_editar']").on("click",function(){
	var id = $("select[name='select_alerta']").val();
	var asunto = $("textarea[name='text_asunto']").val();
	var cuerpo = $("textarea[name='text_cuepo_msj']").val();
	var correo_origen = $('#text_correo_origen').val();
	var correo_copia = $('#text_correo_copia').val();
	var tiempo = $('#text_tiempo').val();
	var estado = $("select[name='select_estado']").val();
	
	if(id !='1' && id !='6'){
		if (tiempo < 0){
		alert("El numero ingresado en Tiempo es menor que 0");	
		}else{
			editar_registro(asunto,cuerpo,correo_origen,correo_copia,tiempo,estado,id);
		}
		
	}else{
		editar_registro(asunto,cuerpo,correo_origen,correo_copia,tiempo,estado,id);
	}
});

function editar_registro(asunto,cuerpo,correo_origen,correo_copia,tiempo,estado,id){
	$.post('editar_registro',{asunto:asunto,cuerpo:cuerpo,correo_origen:correo_origen,correo_copia:correo_copia,tiempo:tiempo,estado:estado,id:id})
	.done(function (data) {		
		console.log(data);
	});
}

$("select[name='select_alerta']").on("change",function() {
	var nro_alerta = $( "#select_alerta" ).val();  
	if (nro_alerta == '1'){
    	$("#text_tiempo").attr('disabled','disabled');	
    	$("#texto").html("");
    	$("#leyenda").html("");	
    	var html = 'Alerta será enviada diariamente';	
    	var leyenda = 'Leyenda: </br>'
    				 + '<strong>%1</strong>: Dias transcurridos del documento en tránsito sin haber sido recibido.';
		$("#texto").append(html);
		$("#leyenda").append(leyenda);	
    }else{
    	$("input[name='text_tiempo']").removeAttr('disabled');
    	if(nro_alerta == '2'){
    		$("#texto").html("");	
    		$("#leyenda").html("");
    		var html = 'intervalo es de 0 - 30';	
    		var leyenda = 'Leyenda: </br>'
    				 + '<strong>%1</strong>: Dias previos a la fecha de respuesta urgente del documento.';
			$("#texto").append(html);
			$("#leyenda").append(leyenda);	
    	}else{
    		if(nro_alerta == '3'){
	    		$("#texto").html("");	
	    		$("#leyenda").html("");
	    		var html = 'intervalo es de 0 - 60';	
	    		var leyenda = 'Leyenda: </br>'
	    				 	+ '<strong>%1</strong>: Días restantes para concluir el documento '
	    				 	+ 'automaticamente, desde que fue recepcionado.';
				$("#texto").append(html);
				$("#leyenda").append(leyenda); 
			}else{
				if(nro_alerta == '5'){
		    		$("#texto").html("");	
		    		$("#leyenda").html("");
		    		var html = 'intervalo es de 0 - 30';	
		    		var leyenda = 'Leyenda: </br>'
		    				 	+ '<strong>%1</strong>: Dias restantes para recibir el documento '
	    				 		+ 'automaticamente, desde que paso a tránsito.';
					$("#texto").append(html);
					$("#leyenda").append(leyenda);  
				} else{					
					if(nro_alerta == '6'){
			    		$("#text_tiempo").attr('disabled','disabled');
			    		$("#texto").html("");	
		    			$("#leyenda").html("");	 
					}
				} 	
    		} 
    	}  
    }    	
});
</script>
<?php include "footer_view.php";?>
