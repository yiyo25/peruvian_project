<?php
	//$url	=	'https://intranet.peruvian.pe/app/';
	$url	=	'https://dev.peruvian.pe/intranet/app/';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="<?php echo $url;?>/css/kendo-styles/kendo.common.min.css" rel="stylesheet" />
<link href="<?php echo $url;?>css/kendo-styles/kendo.default.min.css" rel="stylesheet" />
<script src="<?php echo $url;?>js/kendo-js/jquery.min.js"></script>
<script src="<?php echo $url;?>js/kendo-js/kendo.web.min.js"></script>
<script src="<?php echo $url;?>js/kendo-js/cultures/kendo.culture.es-PE.min.js"></script>
<script src="<?php echo $url;?>js/utilitarios/web.js"></script>
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
	width:600px;
	height:300px;
	margin-left:-300px;
	margin-top:-150px;
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
.padre{
	width:100%;
	margin:95px 10px 0;
}
.buscar{	
	margin:85px 0;
	padding:10px;
	border-top:1px solid #666;
	height:auto;
}
#frm_Buscador ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}
#frm_Buscador li{
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
.span.k-tooltip {
	border:none;
}
</style>
</head>
<div id="ventana"></div>
<body>
	<div class="centro">
    	<div class="cabecera">
        	<img src="<?php echo $url;?>img/logo.jpg"/>
            <div class="titulo">
            	SISTEMA DE REPORTES
            </div>
        </div>
       	<div class="cuerpo">
        	<ul>
            	<li><a href="<?php echo $url;?>gso/index2">Registrar un Reporte de SMS</a></li>
		<!--<li><a href="<?php echo $url;?>gso/index2">Registrar un Reporte de Mercancías Peligrosas</a></li>-->
            </ul>                       
        </div>
        <div class="buscar"> 
        	<span style="color:#666; font-weight:bold;">BUSQUEDA DE REPORTE:</span><br />  
            <div style="margin-top:10px">            	
                <form class="k-content" id="frm_Buscador">
                	<ul>
                    	<li>
                        	<label for="cboProceso" class="required">Código:</label>
                            <input type="text" name="txtCodigo" id="txtCodigo" maxlength="6" class="k-input k-textbox" required data-required-msg="Requerido" style="width:300px;">                    
                            <span class="k-invalid-msg" data-for="txtCodigo"></span>
                        </li>
                        <li class="confirm" style="text-align:center">
                            <button class="k-button k-primary" type="button" id="btnbuscarReporte">Buscar Reporte</button>
                        </li>
                    </ul>
            	</form>
            </div>
        </div>
    </div>
</body>
</html>
<script>
/*
$(document).ready(function(){
	$(location).attr('href','https://intranet.peruvian.pe/reportes/');
});
*/
$("#btnbuscarReporte").kendoButton();
var validator = $("#frm_Buscador").kendoValidator().data("kendoValidator");
$('#btnbuscarReporte').click(function(event){
	event.preventDefault();
	if(validator.validate()){
		var cadena	=	'codigo='+$('#txtCodigo').val();
		$.ajax({
			type 		: 	'POST',
			url 		: 	'<?php echo $url;?>gso/verificarCodigo',
			data 		: 	cadena,
			success		:	function(data){
								var dataResult	=	data.split('@');
								if(dataResult[0]==='1'){
									alert('Su reporte aún lo están procesando.');
									$('#txtCodigo').val('');
								}else{
									var cadena2	=	'id='+dataResult[1];
									$.ajax({
										type 		: 	'POST',
										url 		: 	'<?php echo $url?>gso/verReporteUsuario',
										data 		: 	cadena2,
										success		:	function(data2){
															ventana('Ver Reporte','',data2);
														}
																	 
									});	
								}
							}
										 
		});	
	}
});
</script>