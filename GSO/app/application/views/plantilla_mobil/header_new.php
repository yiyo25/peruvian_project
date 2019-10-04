<html>
	<head>
    	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
			body{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				margin:0;
			}
			.nav{
				background:#ED3237;
				color:#ccc;
				height:480px;
				width:320px;
				position:absolute;
				overflow:hidden;
				top:0;
				z-index:0;
			}
			li{
				padding: 20px 10px;
				list-style:none;
				border-bottom:solid 2px #000;
				border-top: solid 1px #4a5572;
			}
			li a{
				color: #ccc;
				font-size:#18px;
				text-decoration:none;
			}
			#menu{
				height:100%;
				overflow:hidden;
				width:80%;
				background-color:#C61317;
				z-index:0;
			}
			#pagina{
				position:absolute;
				top:0;
				width:100%;
				height:100%;
				z-index:5;
				background:#FFF;
			}
			#botton{
				padding:5px;
				cursor:pointer;
			}
			.usuario{
				background-color:#FF9125;
				color:#FFF;
				height:30px;
				padding:5px;
				font-size:14px;
			}
			.marcadores{
				height:50px;
				width:50px;
				float:left;
			}
			.titulo{
				text-align:center;
				font-size:18px;				
				font-weight:bold;
				margin-top:10px;
			}
		</style>
        <link href="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>css/bootstrap/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript">
			var c	=	0;
			$(document).ready(function(e) {
				$('#botton').on("click", function(){
					if(c==0){
						$('#pagina').animate({
							marginLeft: "80%"
						});
						c++;
					}else{
						$('#pagina').animate({
							marginLeft: "0px"
						});
						c--;
					}	
				});
            });
			/*
			** Grabar Cabecera
			*/
			function  conformecab(){
				$('#btnconformedg').attr('disabled','true');
				var vuelo	=	$('#cbovuelodg option:selected').val().split("@");
				var cadena	=	"fecha="+$('#txtfechadg').val()+"&vuelo="+vuelo[0];
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/grabar_cabecera",
					data 	: 	cadena,
					success	:	function(data){
									if(data>0){
										$('#txtidinformevuelo').val(data);
										$('#txtfechadg').attr('disabled','true');
										$('#cbovuelodg').attr('disabled','true');											
										alert("Se Grabo Correctamente");
										$('#pagina').animate({
											marginLeft: "80%"
										});
									}
								}				 
				});		
			}
			/*
			** Grabar Tripulante
			*/
			function conformetri(){
				var tc2	=	$('#cbotc2 option:selected').val();				
				var tc3	=	$('#cbotc3 option:selected').val();
				var tc4	=	$('#cbotc4 option:selected').val();
				if(tc2==""){
					alert("El tripulante 2 no ha sido escogido");
					return 0;
				}else if(tc3==""){
					alert("El tripulante 3 no ha sido escogido");
					return 0;
				}else if(tc4==""){
					alert("El tripulante 4 no ha sido escogido");
					return 0;
				}
				if(tc2==tc3){
					alert("El TC3 es igual al TC2");
					return 0;
				}else if(tc2==tc4){
					alert("El TC4 es igual al TC2");
					return 0;
				}else if(tc3==tc4){
					alert("El TC3 es igual al TC4");
					return 0;
				}
				$('#btnconformetri').attr('disabled','true');
				var cadena	=	"infvue="+$('#txtidinformevuelo').val()+"&tc2="+tc2+"&tc3="+tc3+"&tc4="+tc4;
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/grabar_tripulacion",
					data 	: 	cadena,
					success	:	function(data){
									$('#txtarraytripulantes').val(data);
									alert("Se grabo correctamente");
									$('#pagina').animate({
										marginLeft: "80%"
									})
								}				 
				});
			}
			/*
			** Grabar Desarrollo del Tripulante
			*/
			function conformetrides(){
				$('#btnconformedesempeno').attr('disabled','true');
				var arrtri	=	$('#txtarraytripulantes').val().split("@");
				var idtc2	=	arrtri[0];
				var nivtc2	=	$('#cbodestc2 option:selected').val();
				var destc2	=	$('#txtareatc2').val();
				var idtc3	=	arrtri[1];
				var nivtc3	=	$('#cbodestc3 option:selected').val();
				var destc3	=	$('#txtareatc3').val();
				var idtc4	=	arrtri[2];
				var nivtc4	=	$('#cbodestc4 option:selected').val();
				var destc4	=	$('#txtareatc4').val();
				var cadena	=	"idtc2="+idtc2+"&nivtc2="+nivtc2+"&destc2="+destc2+"&idtc3="+idtc3+"&nivtc3="+nivtc3+"&destc3="+destc3+"&idtc4="+idtc4+"&nivtc4="+nivtc4+"&destc4="+destc4;
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/grabar_desempeno_tripulacion",
					data 	: 	cadena,
					success	:	function(data){							
									if(data==1){
										alert("Se grabo correctamente");
										$('#pagina').animate({
											marginLeft: "80%"
										})
									}
								}				 
				});
			}
			/*
			** Grabar Pasajeros
			*/
			function conformepax(){
				var cadena	=	"";
				var i		=	0;
				//alert($('#adt0').val());
				if($('#adt1').val()=="" || $('#chd1').val()=="" ||  $('#inf1').val()==""){
					alert("Llenar los campos de la Primera Ruta");
					return 0;
				}else{
					cadena	+=	"&adt1="+$('#adt1').val()+"&chd1="+$('#chd1').val()+"&inf1="+$('#inf1').val()+"&total1="+$('#total1').val();
					i++;
				}
				if($('#adt2').val()==undefined || $('#chd2').val()==undefined ||  $('#inf2').val()==undefined || $('#total2').val()==undefined){
					cadena	=	"&id="+$('#txtidinformevuelo').val()+"&i="+i+cadena;
				}else{
					if($('#adt2').val()=="" || $('#chd2').val()=="" ||  $('#inf2').val()==""){
						alert("Llenar los campos de la Segunda Ruta");
						return 0;
					}else{
						cadena	+=	"&adt2="+$('#adt2').val()+"&chd2="+$('#chd2').val()+"&inf2="+$('#inf2').val()+"&total2="+$('#total2').val();
						i++;
					}
					if($('#adt3').val()=="" || $('#chd3').val()=="" ||  $('#inf3').val()==""){
						alert("Llenar los campos de la Segunda Ruta");
						return 0;
					}else{
						cadena	+=	"&adt3="+$('#adt3').val()+"&chd3="+$('#chd3').val()+"&inf3="+$('#inf3').val()+"&total3="+$('#total3').val();
						i++;
					}
					cadena	=	"&id="+$('#txtidinformevuelo').val()+"&i="+i+cadena;
				}
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/grabar_pasajeros",
					data 	: 	"cadena="+cadena,
					success	:	function(data){							
									if(data!=""){
										$('#txtarraypasajeros').val(data);
										alert("Se grabo correctamente");
										$('#pagina').animate({
											marginLeft: "80%"
										})
									}
								}				 
					});
			}
			function tc2(){
				$('#tc2').html($('#cbotc2 option:selected').html());
			}
			function tc3(){
				$('#tc3').html($('#cbotc3 option:selected').html());
			}
			function tc4(){
				$('#tc4').html($('#cbotc4 option:selected').html());
			}
			/*
			**
			*/
			function datos_iv(){
				var vuelo	=	$('#cbovuelodg option:selected').val().split("@");
				$('#txtidmatriculadg').val(vuelo[2]);
				$('#txtmatriculadg').val(vuelo[3]);
				tripulantes(vuelo[0]);
				pierna(vuelo[1]);
			}			
			
			
			
			
			function menudiv(id){
				$('#pagina').animate({
					marginLeft: "0px"
				});
				$('.container form').css("display","none");
				$('#'+id).css("display","block");
			};
			
			/*
			** Tripulantes
			*/
			function tripulantes(vuelo){
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/tripulacion",
					data 	: 	"vuelo="+vuelo,
					success	:	function(data){
									$('#tripulacion').html(data);
								}				 
				});
			}	
			/*
			** Rutas
			*/
			function pierna(vuelo){
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/count_pasajeros",
					data 	: 	"itinerario="+vuelo,
					success	:	function(data){							
									$('#resultado_grilla').html(data);
								}				 
					});
			}		
			/*
			** Sumar Pasajeros
			*/
			function sumarpax(campo){
				if($('#adt'+campo).val()==""){
					adulto = 0;
				}else{
					adulto = parseInt($('#adt'+campo).val());
				}
				if($('#chd'+campo).val()==""){
					nino = 0;
				}else{
					nino = parseInt($('#chd'+campo).val());
				}
				if($('#inf'+campo).val()==""){
					infante = 0;
				}else{
					infante = parseInt($('#inf'+campo).val());
				}
				$('#total'+campo).val(adulto+nino+infante);
			}
			/*
			** Observaciones
			*/
			function anadirobsevacionpax(){
				if($('#numobspax').val()==0){
						$('#trheaderobs').append('<tr><td>Pasajero</td><td>Nivel</td><td>Observaci&oacute;n</td></tr>');
						$('#trbodyobs').append('<tr><td><input type="text" class="form-control" id="txtpaxobs1"></td><td><select class="form-control" id="cbonivelobs1"><option value="">Nivel</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td><td><textarea class="form-control" rows="1" id="txtareaobs1"></textarea></td></tr>');
						$('#trbtnobspax').append('<button type="button" class="btn btn-danger" id="btnconformeobspax" onClick="grabarobservacionpax()">Conforme</button>'); 
						$('#numobspax').val('1');
				}else{
					var i	=	parseInt($('#numobspax').val());
					if($('#txtpaxobs'+i).val()=="" || $('#cbonivelobs'+i+' option:selected').val()=="" || $('#txtareaobs'+i).val()==""){
						alert("Llenar la observación N° "+i);
						return 0;
					}else{
					var j	=	i+1;
					$('#trbodyobs').append('<tr><td><input type="text" class="form-control" id="txtpaxobs'+j+'"></td><td><select class="form-control" id="cbonivelobs'+j+'"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td><td><textarea class="form-control" rows="1" id="txtareaobs'+j+'"></textarea></td></tr>');
					$('#numobspax').val(j);
					}
				}				
			}
			function grabarobservacionpax(){
				var num_campos	=	parseInt($('#numobspax').val());
				var cadena		=	'';
				for (i = 1; i <= num_campos; i++){
					cadena	+=	"&txtpaxobs"+i+"="+$('#txtpaxobs'+i).val()+"&cbonivelobs"+i+"="+$('#cbonivelobs'+i).val()+"&txtareaobs"+i+"="+$('#txtareaobs'+i).val();
				}
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/grabar_obspasajeros",
					data 	: 	"IdInfVue="+$('#txtidinformevuelo').val()+"&numobs="+num_campos+cadena,
					success	:	function(data){
									if(data!=""){
										$('#txtarrayobspasajeros').val(data);
										alert("Se grabo correctamente");
										$('#pagina').animate({
											marginLeft: "80%"
										})
									}
								}
				});
			}	
			/*
			** Reclamos
			*/
			function anadirreclamo(){
				if($('#numrecpax').val()==0){
						$('#trheaderrec').append('<tr><td>Pasajero</td><td>Nivel</td><td>Reclamo</td></tr>');
						$('#trbodyrec').append('<tr><td><input type="text" class="form-control" id="txtpaxrec1"></td><td><select class="form-control" id="cbonivelrec1"><option value="">Nivel</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td><td><textarea class="form-control" rows="1" id="txtarearec1"></textarea></td></tr>');
						$('#trbtnrecpax').append('<button type="button" class="btn btn-danger" id="btnconformerecpax" onClick="grabarreclamopax()">Conforme</button>'); 
						$('#numrecpax').val('1');
				}else{
					var i	=	parseInt($('#numrecpax').val());
					if($('#txtpaxrec'+i).val()=="" || $('#cbonivelrec'+i+' option:selected').val()=="" || $('#txtarearec'+i).val()==""){
						alert("Llenar el reclamo N° "+i);
						return 0;
					}else{
					var j	=	i+1;
					$('#trbodyrec').append('<tr><td><input type="text" class="form-control" id="txtpaxrec'+j+'"></td><td><select class="form-control" id="cbonivelrec'+j+'"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td><td><textarea class="form-control" rows="1" id="txtarearec'+j+'"></textarea></td></tr>');
					$('#numrecpax').val(j);
					}
				}
			}		
			function grabarreclamopax(){
				var num_campos	=	parseInt($('#numrecpax').val());
				var cadena		=	'';
				for (i = 1; i <= num_campos; i++){
					cadena	+=	"&txtpaxrec"+i+"="+$('#txtpaxrec'+i).val()+"&cbonivelrec"+i+"="+$('#cbonivelrec'+i).val()+"&txtarearec"+i+"="+$('#txtarearec'+i).val();
				}
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/grabar_recpasajeros",
					data 	: 	"IdInfVue="+$('#txtidinformevuelo').val()+"&numrec="+num_campos+cadena,
					success	:	function(data){
									if(data!=""){
										$('#txtarrayrecpasajeros').val(data);
										alert("Se grabo correctamente");
										$('#pagina').animate({
											marginLeft: "80%"
										})
									}
								}
				});
			}
			function conformeobsvue(){
				var datos = new Array();
				$('input[name="checkbox_estacion[]"]:checked').each(function() {
					datos.push($(this).val());
				});
				var cadena	=	"IdInfVue="+$('#txtidinformevuelo').val()+"&dato="+datos+"&descripcion="+$('#txtareadesest').val();
				$.ajax({
					type 	: 	"POST",
					url 	: 	"<?php echo base_url();?>inicio/grabar_obsvuelo",
					data 	: 	cadena,
					success	:	function(data){
									if(data!=""){
										$('#txtarrayobsvuelo').val(data);
										alert("Se grabo correctamente");
										$('#pagina').animate({
											marginLeft: "80%"
										})
									}
								}
				});
			}
		</script>
	</head>
    <body>
    	<!--Menu--> 	
    	<div id="menu">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Vuelo</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#datosgenerales" onClick="menudiv('datosgenerales')">Datos Generales</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Tripulaci&oacute;n</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#" onClick="menudiv('tripulacion')">Tripulantes</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" onClick="menudiv('tripulacion_desarrollo')">Desarrollo</a>
                                    </td>
                                </tr>                                
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapseThree">Pasajeros</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#" onClick="menudiv('totalidad')">Totalidad</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" onClick="menudiv('obs_pasajeros')">Observaciones</a>
                                    </td>
                                </tr>  
                                <tr>
                                	<td>
                                    	<a href="#" onClick="menudiv('reclamos_pasajeros')">Reclamos</a>
                                    </td>
                                </tr>                              
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Estaci&oacute;n</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#sales" onClick="menudiv('comentarios')">Comentarios</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#sales" onClick="menudiv('observacion_estacion')">Observaciones</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!--Fin Menu-->
        <!--Inicio Cuerpo-->
        <div id="pagina">
            <nav class="navbar navbar-default" role="navigation">
                <div class="marcadores">
                    <img src="<?php echo base_url();?>img/movil/left.png" id="botton">
                </div>
                <div class="titulo">
	                <?php echo $titulo;?>
                </div>
            </nav>
            <div class="container">
            	<input type="hidden" id="txtidinformevuelo">
                <input type="hidden" id="txtarraytripulantes">
                <input type="hidden" id="txtarraypasajeros">
                <input type="hidden" id="txtarrayobspasajeros">
                <input type="hidden" id="txtarrayrecpasajeros">
                <input type="hidden" id="txtarrayobsvuelo">
                <form class="form-horizontal" role="form" id="totalidad" style="display:none;">
                	<div id="resultado_grilla">
                    </div>
                </form>
                <form class="form-horizontal" role="form" id="obs_pasajeros" style="display:none;">
                    <div class="form-group">
                        <table class="table">
                        	<caption>
                            	<a href="#" onClick="anadirobsevacionpax()">A&ntilde;adir nuevo observaci&oacute;n pasajero</a>
                                <input type="text" value="0" id="numobspax">
                            </caption>
                            <thead id="trheaderobs">
                        		
                            </thead>
                            <tbody id="trbodyobs">
                            
                        	</tbody>
                            <td>
                            	<tr id="trbtnobspax">
                                	
                                </tr>
                            </td>
                        </table>
                    </div>
                </form>
                <form class="form-horizontal" role="form" id="reclamos_pasajeros" style="display:none;">
                    <div class="form-group">
                    	<table class="table">
                        	<caption>
                            	<a href="#" onClick="anadirreclamo()">A&ntilde;adir nuevo reclamo</a>
                                <input type="text" value="0" id="numrecpax">
                            </caption>
                            <thead id="trheaderrec">
                            
                            </thead>
                            <tbody id="trbodyrec">
                                
                        	</tbody>
                            <td>
                            	<tr id="trbtnrecpax">
                                	
                                </tr>
                            </td>
                        </table>
                    </div>
                </form>
 <!-- Datos Generales -->
                <form class="form-horizontal" role="form" id="datosgenerales">
                    <div class="form-group">
                        <label for="txtfechadg" class="col-sm-2 control-label">Fecha:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="txtfechadg" placeholder="Fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cbovuelodg" class="col-sm-2 control-label">Vuelo</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="cbovuelodg" onChange="datos_iv()">
                                <option value="0">Vuelo</option>
                                <?php foreach($vuelo as $vue){?>
                          		<option value="<?php echo $vue->id_vuelo_programado."@".$vue->id_vuelo_itinerario."@".$vue->IdMatricula."@".$vue->Nombre;?>"><?php echo $vue->NroVuelo?></option>
                               	<?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtmatriculadg" class="col-sm-2 control-label">Matr&iacute;cula:</label>
                        <div class="col-sm-10">
                        	<input type="hidden" id="txtidmatriculadg" disabled>
                            <input type="text" class="form-control" id="txtmatriculadg" placeholder="Matr&iacute;cula" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-danger" id="btnconformedg" onClick="conformecab();">Conforme</button>
                        </div>
                    </div>
                </form>
			<!-- Fin Datos Generales -->
            <!-- Inicio Tripulación -->
                <form class="form-horizontal" role="form" id="tripulacion" style="display:none;">
                    <div id="tripulacion">
                    	
                    </div>
                </form>
                <form class="form-horizontal" role="form" id="tripulacion_desarrollo" style="display:none">
                	<div class="form-group">
                    	<table width="100%" class="table">
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>Nivel</td>
                                <td>Observaci&oacute;n</td>
                            </tr>
                            <tr>
                            	<td>TC2</td>
                                <td id="tc2"></td>
                                <td>
                                	<select class="form-control" id="cbodestc2">
                                    	<option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                                <td>
                                	<textarea class="form-control" rows="3" id="txtareatc2"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>TC3</td>
                                <td id="tc3"></td>
                                <td>
                                	<select class="form-control" id="cbodestc3">
                                    	<option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                                <td>
                                	<textarea class="form-control" rows="3" id="txtareatc3"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>TC4</td>
                                <td id="tc4"></td>
                                <td>
                                	<select class="form-control" id="cbodestc4">
                                    	<option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                                <td>
                                	<textarea class="form-control" rows="3" id="txtareatc4"></textarea>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="4">
                            		<button type="button" class="btn btn-danger" id="btnconformedesempeno" onClick="conformetrides()">Conforme</button>
                            	</td>
                            </tr>
                        </table>
                	</div>                 
                </form>                
			<!-- Fin Tripulación -->
            <!-- Estación -->           
                <form class="form-horizontal" role="form" id="observacion_estacion" style="display:none;">
                   <div class="col-sm-12">
                        <? $h=0; foreach($observaciones as $lista){								
                        ?>
                        <div class="checkbox">
                            <label style="font-size:16px">
                                <input type="checkbox" name="checkbox_estacion[]"  value="<? echo $lista->id_observacion;?>">
                                    <?php echo $lista->descripcion?>
                           </label>
                        </div>
                        <?php	$h++; 
                        } ?>
                        <br/>
                        <label for="cbovuelo" class="col-sm-2 control-label">Especificaci&oacute;n:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="2" id="txtareadesest"></textarea>
                        </div>
                        <div class="col-sm-12">
	                        <button type="button" class="btn btn-danger" id="btnconformeobsvuelo" onClick="conformeobsvue()">Conforme</button>
                        </div>
                    </div>
                </form>
          <!-- Fin Estación -->
                <form class="form-horizontal" role="form" id="comentarios" style="display:none;">
                	<label for="cbovuelo" class="col-sm-2 control-label">Comentarios:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="2"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>