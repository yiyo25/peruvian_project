<!--[if !IE]><!-->
<style>
table { 
	width: 100%; 
	border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
	background: #F9F7F3; 
}
th { 
	background: #333; 
	color: white; 
	font-weight: bold; 
}
td, th { 
	padding: 6px; 
	border: 1px solid #ccc; 
	text-align: left; 
	height:40px;
}
/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
		height:40px;
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		font-weight:bold;
	}
	
	/*
	Label the data
	*/
	td:nth-of-type(1):before { content: "Código:"; }
	td:nth-of-type(2):before { content: "Nombre:"; }
	td:nth-of-type(3):before { content: "T. de Embarque:"; }
	td:nth-of-type(4):before { content: "Acción:"; }
}

/* Smartphones (portrait and landscape) ----------- */
@media only screen
and (min-device-width : 320px)
and (max-device-width : 480px) {
	body { 
		padding: 0; 
		margin: 0; 
		width: 320px; }
	}

/* iPads (portrait and landscape) ----------- */
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
	body { 
		width: 495px; 
	}
}
</style>
	<!--<![endif]-->
<div class="contenidoDerecha" id="contenidoDerecha" style="display:none;">
	<div class="form-group">
    	<label class="col-sm-2 control-label">C&oacute;digo:</label>
        <div class="col-sm-10">
       		<input type="text" class="form-control input-sm" id="txtCodigo" placeholder="C&oacute;digo">
        </div>
    </div>
    <div class="form-group">
    	<label class="col-sm-2 control-label">Nombre:</label>
        <div class="col-sm-10">
       		<input type="text" class="form-control input-sm" id="txtNombre" placeholder="Nombre Ciudad">
        </div>
    </div>
    <div class="form-group">
    	<label class="col-sm-2 control-label">Tiempo de Embarque:</label>
        <div class="col-sm-10">
       		<input type="time" class="form-control input-sm" id="txtTiempoEmbarque" placeholder="Nombre Ciudad">
        </div>        
    </div>
    <div class="form-group">
    	<div class="col-sm-offset-2 col-sm-10">
   			 <button type="submit" class="btn btn-default btn-xs" onClick="grabar()" id="btnGrabar">Grabar</button>
             <button type="submit" class="btn btn-default btn-xs" onClick="cerrar()">Cerrar</button>
    	</div>
	</div>
</div>
<div class="contenidoizquierdo" id="contenidoizquierdo" style="position:relative">
    <div class="nuevo" style="text-align:right">
        <a href="#" onClick="nuevo()">Nuevo Registro</a>
    </div>
    <div class="paginacion" style="margin:5px auto; text-align:center;">  
        <ul class="pagination pagination-sm" style="margin:0 auto">
            <li>
                <a href="#" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
                <?php for($n=0;$n<$paginacion;$n++){?>
                    <li><a href="#" onClick="paginacion('<?=$n+1?>')"><?=$n+1?></a></li>
                <?php }?>
            <li>
                <a href="#" aria-label="Siguiente">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>
    <table>
        <thead>
            <tr style="background: #C6000F; color:#FFF;font-weight:bold;">
                <td width="10%">Nro. Vuelo</td>
                <td width="20%">Matrícula</td>
                <td width="20%">Ruta</td>
                <td width="10%">F. Inicio</td>
                <td width="10%">F. Fin</td>
                <td width="10%">Frecuencia</td>
                <td width="10%">Accion</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaItinerario as $value){?>
                <tr>
                    <td><?=$value->ItiCab_NumeroVuelo?></td>
                    <td id="itinerario<?=$value->ItiCab_Id?>"><?=$value->idMatricula?></td>
                    <td id="itinerario<?=$value->ItiCab_Id?>"><?=$value->ItiCab_Ruta?></td>
                    <td id="itinerario<?=$value->ItiCab_Id?>"><?=$value->ItiCab_FechaInicio?></td>
                    <td id="itinerario<?=$value->ItiCab_Id?>"><?=$value->ItiCab_FechaFin?></td>
                    <td id="itinerario<?=$value->ItiCab_Id?>"><?=$value->ItiCab_Frecuencia?></td>                   
                    <td id="button<?=$value->ItiCab_Id?>"><button type="button" class="btn btn-default btn-xs" onClick="editarCiudad('<?=$value->ItiCab_Id?>')" id="inputEditar<?=$value->ItiCab_Id?>">Editar</button><button type="button" class="btn btn-default btn-xs" onClick="modificarCiudad('<?=$value->ItiCab_Id?>')" id="inputModificar<?=$value->ItiCab_Id?>" style="display:none; float:left">Modificar</button>&nbsp;<button type="button" class="btn btn-default btn-xs" onClick="cancelarCiudad('<?=$value->ItiCab_Id?>')" id="inputCancelar<?=$value->ItiCab_Id?>" style="display:none; float:left; margin-left:5px;">Cancelar</button></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <input type="hidden" id="hiddenItinerario">
</div>
<script>
	function editarCiudad(id){
		if($('#hiddenCiudad').val()!==''){
			
		}else{
			var id		=	id;
			var nombre	=	$('#nombre'+id).html();
			var embarque=	$('#embarque'+id).html();
			$('#hiddenCiudad').val(id+'@'+nombre+'@'+embarque);
			$('#nombre'+id).html('<input type="text" class="form-control input-sm" id="inputNombre'+id+'">');
			$('#inputNombre'+id).val(nombre);
			$('#embarque'+id).html('<input type="time" class="form-control input-sm" id="inputEmbarque'+id+'">');
			$('#inputEmbarque'+id).val(embarque);
			$('#inputModificar'+id).css('display','block');
			$('#inputCancelar'+id).css('display','block');
			$('#inputEditar'+id).css('display','none');
		}
	}
	function cancelarCiudad(id){
		var data=	$('#hiddenCiudad').val().split('@');
		$('#nombre'+id).html(data[1]);
		$('#embarque'+id).html(data[2]);		
		$('#inputModificar'+id).css('display','none');
		$('#inputCancelar'+id).css('display','none');
		$('#inputEditar'+id).css('display','block');
		$('#hiddenCiudad').val('');
	}
	function nuevo(){
		$("#contenidoizquierdo").css("display","none");
		$("#contenidoDerecha").css("display","block");
	}
	function grabar(){
		$('#btnGrabar').attr("disabled","true");
		var codigo			=	$("#txtCodigo").val();
		var nombre			=	$("#txtNombre").val();
		var tiempoEmbarque	=	$("#txtTiempoEmbarque").val();
		var cadena			=	"codigo="+codigo+"&nombre="+nombre+"&tiempoEmbarque="+tiempoEmbarque;
		$.ajax({
			type 	: 	'POST',
			url 	: 	'<?=base_url();?>index.php/ciudad/grabarCiudad',
			data 	: 	cadena,
			success	:	function(data){
							if(data===1){
								cerrar();
								paginacion(1)		
							}
						}
		});
	}
	function cerrar(){
		$("#contenidoizquierdo").css("display","block");
		$("#contenidoDerecha").css("display","none");
	}
	function modificarCiudad(id){
		var nombre	=	$('#inputNombre'+id).val();
		var embarque=	$('#inputEmbarque'+id).val();
		if(nombre===''){
			alert('Ingrese el Nombre');
			return 0;
		}
		if(embarque===''){
			alert('Ingrese el Tiempo de Embarque');
			return 0;
		}
		var cadena	=	'id='+id+'&nombre='+nombre+'&embarque='+embarque;
		$.ajax({
			type 	: 	'POST',
			url 	: 	'<?=base_url();?>index.php/ciudad/modificarCiudad',
			data 	: 	cadena,
			success	:	function(data){
							$('#nombre'+id).html(nombre);
							$('#embarque'+id).html(embarque);
							$('#inputModificar'+id).css('display','none');
							$('#inputCancelar'+id).css('display','none');
							$('#inputEditar'+id).css('display','block');
							$('#hiddenCiudad').val('');
						}
		});	
	}
	function paginacion(pagina){
		var limit	=	10;
		var inicio	=	(pagina-1)*limit+1;
		var fin		=	pagina*limit;
		$.ajax({
			type 	: 	'POST',
			url 	: 	'<?=base_url();?>itinerario/paginador',
			data 	: 	'limit='+limit+'&inicio='+inicio+'&fin='+fin,
			success	:	function(data){
							$('#container').html(data);
						}
		});	
	}
	
</script>
