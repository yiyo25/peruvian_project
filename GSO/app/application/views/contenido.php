<script>	
function Modificar(id){
	$("#id_curso").html(id);
	var url = $("#url_abs").val();
	
	$.ajax({
		   type : "POST",
		   url : url+"index.php/inicio/select_curso",
		   data : "id="+id,
		   success:function(data){		  
		   		  var obj=eval('('+data+')');
		   		  $("#nombre_curso").val(obj["cursos"][0]["nombre_curso"]);
		   		  $("#curso_vigencia").val(obj["cursos"][0]["curso_vigencia"])
		   		  $("#estado").val(obj["cursos"][0]["estado"]);
				 }				 
			});	
	
	
		$("#modificar").dialog({
			
			
			title:"Actualizar Curso",				
			modal: true,	
		    width: 550,
		    height:220,
		    minWidth: 400,
		    maxWidth: 650,
		    show: "fold",
		    hide: "fade",
		    buttons:{
		    	"Actualizar":function(){
		    		
		    		var nombre_curso=$("#nombre_curso").val();	
		    		var curso_vigencia=$("#curso_vigencia").val();	
		    		var estado=$("#estado").val();	
		    		
		    		$.ajax({
						   type : "POST",
						   url : url+"index.php/inicio/update_curso",
						   data : "id="+id+"&nombre_curso="+nombre_curso+"&curso_vigencia="+curso_vigencia+"&estado="+estado,
						   success:function(data){		  
						   		 location.reload();
								 }				 
							});	
		    		 $(this).dialog("close");		     
				  },
				  "Cancelar":function(){
				     $(this).dialog("close");
				  } 
		   		 }		
			});
}


</script>

<div id="contenido">
<div id="modificar" style="display:none">
	<? include("./includes/modificar.php");?>
</div>
	<table align="center" border=1>
		<tr>
			<td> Id Curso </td>
			<td>Nombre Curso</td>
			<td>Curso Vigencia</td>
			<td>Estado</td>
			<td></td>
		</tr>
		<? foreach ($cursos as $lista):?>
		<tr>
			<td><?= $lista->id_curso?></td>
			<td><?= $lista->nombre_curso?></td>
			<td><?= $lista->curso_vigencia?></td>
			<td><?= $lista->estado?></td>
			<td><a onclick="Modificar(<?=$lista->id_curso?>)" class="mod">Modificar</a></td>
		</tr>
		<? endforeach?>
   </table>
</div>