<style>
#frm_Codigo{
	width: 520px;
    height: 120px;
	font-size:12px;
}
#frm_Codigo ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
#frm_Codigo li{
	margin: 5px 0 0 0;
}
#frm_Codigo li.button{
	margin: 5px 0 0 0;
	width:100%;
	text-align:center;
	float:left;
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
	<div class="k-content" id="frm_Codigo"> 
        <p>
            El código Generado de su reporte es: <?php echo $codigo;?>           
        </p>
        <p>
            Si desea podemos enviarle a su correo electrónico...
        </p>
        <ul>        	
            <li>
                <label for="txtemail" class="required">Correo Electrónico:</label>
                <input type="text" name="txtemail" class="k-input k-textbox" id="txtemail" style="width:300px;">
            </li>
            <li class="button">
                <button class="k-button k-primary" id="btnEnviar">Enviar</button>
                <button class="k-button k-primary" id="btnCerrar">Cerrar</button>
            </li>
    	</ul>
	</div>
</div>
<script>
	$('#btnEnviar').click(function(e){
		$.ajax({
			type	:	'POST',
			url		:	'<?php echo base_url()?>gso/enviarCorreoUsuario',
			data 	: 	'email='+$('#txtemail').val()+'&codigo=<?php echo $codigo;?>',
			success	: 	function(data){
							if(data==1){
								alert('Se envío correctamente a su correo el código.');
								window.location.href = "<?php echo base_url()?>gso/portada";
							}
						}
		});
    });
	$('#btnCerrar').click(function(e){
		var answer = confirm('¿Ha copiado su código generado?');
		if (answer){
			ventanaCerrar();
			window.location.href = "<?php echo base_url()?>gso/portada";		  	
		}else{
		  return 0;
		}
    });
</script>