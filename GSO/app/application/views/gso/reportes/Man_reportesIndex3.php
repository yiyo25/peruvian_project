<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SISTEMA DE REPORTES</title>
<style>
body{
	background:#E11923;
}
.centro{
	background:#FFF;
	border: 1px solid #666;
	border-radius:10px;
	position:absolute;
	left:50%;
	top:50%;
	width:800px;
	height:640px;
	margin-left:-400px;
	margin-top:-320px;
}
.cabecera{
	margin-top:5px;
	width:100%;
	height:55px;
	border-bottom:1px solid #666;
}
.cabecera img{
	margin-left:10px;
	float:left;
}
.cabecera .titulo{
	margin-right:10px;
	margin-top:15px;
	float:right;
	font-size:18px;
	font-weight:bold;
	color:#666;
}
.cuerpo .contenido{
	color:#666;
	text-align:justify;
	padding:10px;
	width:780px;
}
#frm_ManReporte{
	width: 100%;
    height: 350px;
	font-size:12px;
}
#frm_ManReporte ul{
	list-style-type: none;
	width:100%;
	margin: 0;
	padding: 0;
}
#frm_ManReporte li.input{
	margin: 5px 0 0 0;
	width:100%;
}
#frm_ManReporte li.button{
	margin: 5px 0 0 0;
	width:100%;
	text-align:center;
	float:left;
}
label {
	display: inline-block;
	width: 200px;
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
<link href="<?php echo base_url();?>css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo base_url();?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo base_url();?>js/utilitarios/web.js"></script>
</head>
<body>
	<div id="ventana"></div>
	<div class="centro">
    	<div class="cabecera">
        	<img src="<?php echo base_url();?>img/logo.jpg"/>
            <div class="titulo">
            	SISTEMA DE REPORTES
            </div>
        </div>
        <div class="cuerpo">            
            <form class="k-content" id="frm_ManReporte">
                <ul>
                	<div class="contenido">
						<?php echo $descripcion;?>
                    </div>
                    <li class="input">
                        <label for="txtNombre" class="required">Nombre:</label>
                        <input type="text" name="txtNombre" class="k-input k-textbox" id="txtNombre" style="width:500px;">
                    </li>
                    <div class="contenido">
						<span style="font-weight:bold; color:#000;"><?php echo $tituloSeccion1.'<br>';?></span>
                		<?php echo $descripcionSeccion1;?>
                    </div>
                    <li class="input">
                        <label for="txtAreaDescripcion" class="required">Descripción:</label>
                        <textarea style="width:500px; height:50px" class="k-input k-textbox" required data-required-msg=" " id="txtAreaDescripcion" ></textarea>
                        <span class="k-invalid-msg" data-for="txtAreaDescripcion"></span>
                    </li>
                    <li class="input" style="height:50px;">
                        <label for="txtAdjuntar" class="required" style="float:left;">Adjuntar:</label>  
                        <div style="width:500px; float:left; margin-right:5px;">
                        	<input name="txtAdjuntar" id="txtAdjuntar" type="file"/>
                        </div>
                    </li>
                    <li class="button">
                        <button class="k-button k-primary" type="button" id="btnGrabar">Grabar</button>
                    </li>
                </ul>
            </form>
 		</div>       
        
    </div>
	<script>
		$(document).ready(function() {
			$("#txtAdjuntar").kendoUpload({
				async: {
					saveUrl		:	"<?php echo base_url()?>gso/save",
					removeUrl	:	"<?php echo base_url()?>gso/delete",
					autoUpload	: 	true
				}
			});
		});
		var validator 				= 	$("#frm_ManReporte").kendoValidator().data("kendoValidator");
		$("#btnGrabar").click(function(event) {
			if(validator.validate()){
				var cadena	=	'txtNombre='+$('#txtNombre').val()+'&txtareaDescripcion='+$('#txtAreaDescripcion').val();
				$.ajax({
					type 		: 	'POST',
					url 		: 	'<?php echo base_url()?>gso/grabarReporte2',
					data 		: 	cadena,
					success		:	function(data){
										if(data!==0){
											$.ajax({
												type	:	'POST',
												url		:	'<?php echo base_url()?>gso/vistaCodigoReporte',
												data 	: 	'codigo='+data,
												success	: 	function(data2){
																ventanaSinOpcion('Código Generado','',data2);
															}
											});
											
										}
									}
												 
				});	
			}else{
				
			}
		}); 
	</script>
</body>
</html>
