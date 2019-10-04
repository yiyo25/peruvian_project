/*
** Grabar Cabecera
*/
function  conformecab(){
	if($('#cbovuelodg option:selected').val()==""){
		mostraralerta("Escoja el N&uacute;mero de Vuelo","a");	
		return 0;
	}
	var vuelo			=	$('#cbovuelodg option:selected').val().split("@");
	var idvitinerario	=	vuelo[1];
	$.ajax({
		type 		: 	"POST",
		url 		: 	"http://intranet.peruvian.pe/app/inicio/validarVuelo",
		data 		: 	"idvitinerario="+idvitinerario,
		beforeSend	:	function(){
							mostraralerta("Validando el vuelo.<br>Espere por favor...","g");
						},
		success		:	function(data){
							if(data==""){									
								$('#btnconformedg').attr('disabled','true');
								tripulantes(vuelo[0]);
								pierna(vuelo[1]);	
								var cadena	=	"fecha="+$('#txtfecha').val()+"&vuelo="+vuelo[0]+"&vueloitinerario="+vuelo[1];
								$.ajax({
									type 		: 	"POST",
									url 		: 	"http://intranet.peruvian.pe/app/inicio/grabarCabecera",
									data 		: 	cadena,
									beforeSend	:	function(){
														$("#mensaje h6").html("Grabando Informe de Vuelo.<br>Espere por favor...");
														var heightalerta	=	$("#preloader").height()/2;
														var widthalerta		=	$("#preloader").width()/2;
														$("#preloader").css({'margin-left':-widthalerta,'margin-top':-heightalerta});
													},
									success		:	function(data){
														if(data>0){							
															$('#txtidinformevuelo').val(data);
															$('#txtfechadg').attr('disabled','true');
															$('#cbovuelodg').attr('disabled','true');
															menudiv('tripulacion');	
														}
													},
									complete	:	function(){																												
														ocultaralerta("g");
													}
																 
								});									
							}else{
								$('#btnconformedg').attr('disabled','true');
								tripulantes(vuelo[0]);
								pierna(vuelo[1]);	
								var valor	=	data.split("@");
								if(valor[0]=="1"){														
									$('#btnconformedg').attr('disabled','true');
									if(confirm('Desea cargar los campos registrados.')){
										mostraralerta("Cargando los datos.<br>Espere por favor...","g");
										validarTripulantes(valor[1]);																																	
										$("#txtidinformevuelo").val(valor[1]);
									}									
								}
								if(valor[0]=="2"){
									$("#cbovuelodg").val("").change();
									$("#preloader #spinner").css("display","none");
									$("#btnconformedg").removeAttr("disabled");
									mostraralerta("Este vuelo ya ha sido grabado y enviado correctamente.","a");
									return 0;
								}
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
		mostraralerta("El tripulante 2 no ha sido escogido","a");
		return 0;
	}else if(tc3==""){
		mostraralerta("El tripulante 3 no ha sido escogido","a");
		return 0;
	}else if(tc4==""){
		mostraralerta("El tripulante 4 no ha sido escogido","a");
		return 0;
	}
	if(tc2==tc3){
		mostraralerta("El TC3 es igual al TC2","a");
		return 0;
	}else if(tc2==tc4){
		mostraralerta("El TC4 es igual al TC2","a");
		return 0;
	}else if(tc3==tc4){
		mostraralerta("El TC3 es igual al TC4","a");
		return 0;
	}
	$('#btnconformetri').attr('disabled','true');
	var cadena	=	"infvue="+$('#txtidinformevuelo').val()+"&tc2="+tc2+"&tc3="+tc3+"&tc4="+tc4;
	$.ajax({
		type 		: 	"POST",
		url 		: 	"http://intranet.peruvian.pe/app/inicio/grabar_tripulacion",
		data 		: 	cadena,
		beforeSend	:	function(){
							mostraralerta("Grabando la tripulaci&oacute;n.<br>Espere por favor...","g");
						},
		success		:	function(data){
							$('#txtarraytripulantes').val(data);
							menudiv('tripulacion_desarrollo');
					},
		complete	:	function(){																												
							ocultaralerta("g");
						}
	});
}
/*
** Grabar Desarrollo del Tripulante
*/
function conformetrides(){
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
	if(destc2==""){
		mostraralerta("La descripción del TC2 se encuentra vacio","a");
		return 0;
	}
	if(destc3==""){
		mostraralerta("La descripción del TC3 se encuentra vacio","a");
		return 0;
	}
	if(destc4==""){
		mostraralerta("La descripción del TC4 se encuentra vacio","a");
		return 0;
	}
	var cadena	=	"idtc2="+idtc2+"&nivtc2="+nivtc2+"&destc2="+destc2+"&idtc3="+idtc3+"&nivtc3="+nivtc3+"&destc3="+destc3+"&idtc4="+idtc4+"&nivtc4="+nivtc4+"&destc4="+destc4;
	$('#btnconformedesempeno').attr('disabled','true');
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/grabar_desempeno_tripulacion",
		data 	: 	cadena,
		beforeSend	:	function(){
							mostraralerta("Grabando el desempen&ntilde;o de la tripulaci&oacute;n.<br>Espere por favor...","g");
						},
		success		:	function(data){														
							if(data==1){
								menudiv('totalidad');
							}
					},
		complete	:	function(){																												
							ocultaralerta("g");
						}			 
	});
}
/*
** Grabar Pasajeros
*/
function conformepax(){
	var cadena	=	"";
	var i		=	0;
	if($('#adt1').val()=="" || $('#chd1').val()=="" ||  $('#inf1').val()==""){
		mostraralerta("Llenar los campos de la Primera Ruta","a");
		return 0;
	}else{
		cadena	+=	"&adt1="+$('#adt1').val()+"&chd1="+$('#chd1').val()+"&inf1="+$('#inf1').val()+"&total1="+$('#total1').val()+"&rut1="+$('#rut1').val();
		i++;
	}
	if($('#adt2').val()==undefined || $('#chd2').val()==undefined ||  $('#inf2').val()==undefined || $('#total2').val()==undefined){
		cadena	=	"&id="+$('#txtidinformevuelo').val()+"&i="+i+cadena;
	}else{
		if($('#adt2').val()=="" || $('#chd2').val()=="" ||  $('#inf2').val()==""){
			mostraralerta("Llenar los campos de la Segunda Ruta","a");
			return 0;
		}else{
			cadena	+=	"&adt2="+$('#adt2').val()+"&chd2="+$('#chd2').val()+"&inf2="+$('#inf2').val()+"&total2="+$('#total2').val()+"&rut2="+$('#rut2').val();
			i++;
		}
		if($('#adt3').val()=="" || $('#chd3').val()=="" ||  $('#inf3').val()==""){
			mostraralerta("Llenar los campos de la Tercera Ruta","a");
			return 0;
		}else{
			cadena	+=	"&adt3="+$('#adt3').val()+"&chd3="+$('#chd3').val()+"&inf3="+$('#inf3').val()+"&total3="+$('#total3').val()+"&rut3="+$('#rut3').val();
			i++;
		}
		cadena	=	"&id="+$('#txtidinformevuelo').val()+"&i="+i+cadena;
	}
	$('#btnconformepax').attr('disabled','true');
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/grabar_pasajeros",
		data 	: 	"cadena="+cadena,
		beforeSend	:	function(){
							mostraralerta("Grabando el n&uacute;mero de pasajeros.<br>Espere por favor...","g");
						},
		success		:	function(data){					
							if(data!=""){
								$('#txtarraypasajeros').val(data);
								menudiv('obs_pasajeros');
							}
					},
		complete	:	function(){																												
							ocultaralerta("g");
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
** Matrícula del Avión
*/
function datos_iv(){
	var vuelo	=	$('#cbovuelodg option:selected').val().split("@");
	$('#txtidmatriculadg').val(vuelo[2]);
	$('#txtmatriculadg').val(vuelo[3]);
}
/*
**	Menu $.sidr('open', 'sidr-menu');
*/
function menudiv(id){
	$.sidr('close', 'sidr-menu');
	$('.container form').css("display","none");
	$('#'+id).css("display","block");
};

/*
** Tripulantes
*/
function tripulantes(vuelo){
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/tripulacion",
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
		url 	: 	"http://intranet.peruvian.pe/app/inicio/count_pasajeros",
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
function grabarobservacionpax(){
	var num_campos	=	parseInt($('#numobspax').val());
	if($("#txtpaxobs"+num_campos).val()==""||$("#cbonivelobs"+num_campos).val()==""||$("#txtareaobs"+num_campos).val()==""){
		mostraralerta("Llenar la observación N° "+num_campos,"a");
		return 0;
	}
	var cadena		=	'';
	for (i = 1; i <= num_campos; i++){
		cadena	+=	"&txtpaxobs"+i+"="+$('#txtpaxobs'+i).val()+"&cbonivelobs"+i+"="+$('#cbonivelobs'+i).val()+"&txtareaobs"+i+"="+$('#txtareaobs'+i).val();
	}
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/grabar_obspasajeros",
		data 	: 	"IdInfVue="+$('#txtidinformevuelo').val()+"&numobs="+num_campos+cadena,
		beforeSend	:	function(){
							mostraralerta("Grabando observaci&oanes de pasajeros.<br>Espere por favor...","g");
						},
		success		:	function(data){							
							if(data!=""){
								$('#txtarrayobspasajeros').val(data);
								menudiv('reclamos_pasajeros');
							}
					},
		complete	:	function(){																												
							ocultaralerta("g");
						}	
	});
}		
function grabarreclamopax(){
	var num_campos	=	parseInt($('#numrecpax').val());
	if($("#txtpaxrec"+num_campos).val()==""||$("#cbonivelrec"+num_campos).val()==""||$("#txtarearec"+num_campos).val()==""){
		mostraralerta("Llenar el reclamo N° "+num_campos,"a");
		return 0;
	}
	var cadena		=	'';
	for (i = 1; i <= num_campos; i++){
		cadena	+=	"&txtpaxrec"+i+"="+$('#txtpaxrec'+i).val()+"&cbonivelrec"+i+"="+$('#cbonivelrec'+i).val()+"&txtarearec"+i+"="+$('#txtarearec'+i).val();
	}
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/grabar_recpasajeros",
		data 	: 	"IdInfVue="+$('#txtidinformevuelo').val()+"&numrec="+num_campos+cadena,
		beforeSend	:	function(){
							mostraralerta("Grabando reclamos de pasajeros.<br>Espere por favor...","g");
						},
		success		:	function(data){
							if(data!=""){
								$('#txtarrayrecpasajeros').val(data);
								menudiv('observacion_estacion');
							}
					},
		complete	:	function(){																												
							ocultaralerta("g");
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
		url 	: 	"http://intranet.peruvian.pe/app/inicio/grabar_obsvuelo",
		data 	: 	cadena,
		beforeSend	:	function(){
							mostraralerta("Grabando observaciones del avi&oacute;n.<br>Espere por favor...","g");
						},
		success		:	function(data){
							if(data!=""){
								$('#txtarrayobsvuelo').val(data);
								$.sidr('open', 'sidr-menu');
							}
					},
		complete	:	function(){																												
							ocultaralerta("g");
						}	
	});
}
function enviarcorreo(){
	var idinfvue	=	$('#txtidinformevuelo').val();
	if(idinfvue==""){
		$.sidr('close', 'sidr-menu');
		setTimeout(function(){
					mostraralerta("No tiene vuelos Registrados","a")
		},300);
	}else{	
		$.ajax({
			type 	: 	"POST",
			url 	: 	"http://intranet.peruvian.pe/app/inicio/EnviarReporte",
			data 	: 	"idinfvue="+idinfvue,
			beforeSend	:	function(){
								mostraralerta("Enviando mensaje del reporte.<br>Espere por favor...","g");
							},
			success		:	function(data){							
								if(data=='1'){
									location.href="http://intranet.peruvian.pe/app/inicio/informedevuelo";
								}					
						},
		complete	:	function(){							
							ocultaralerta("g");							
						}	
		});
	}
}
/*
** Recuperar Tripulantes
*/
function validarTripulantes(idinfvue){
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/validarTripulantes",
		data 	: 	"idinfvue="+idinfvue,
		beforeSend: function(){
						$("#preloader h6").html("Cargando Tripulantes...");
						centroautomaticoalerta();
					},
		success		:	function(data){
							if(data!=""){
								var valor	=	data.split("|");
								var cadena	=	"";
								for(var i=0; i<=2; i++){
									var j=i+2;
									dtc	=	valor[i].split("@");									
									$("#txtareatc"+j).val(dtc[2]);
									$("#cbodestc"+j).val(dtc[1]).change();									
									$("#cbotc"+j).val(dtc[0]).change();
									cadena	+=	dtc[3]+"@";
								}
								$("#txtarraytripulantes").val(cadena.substring(0, cadena.length-1));
							}									
					},
		complete	:	function(){
							validarPasajeros(idinfvue);
					}
	});	
}
function validarPasajeros(idinfvue){	
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/validarPasajeros",
		data 	: 	"idinfvue="+idinfvue,
		beforeSend: function(){
						$("#preloader h6").html("Cargando Pasajeros...");
						centroautomaticoalerta();
					},
		success		:	function(data){
							if(data!=""){
								var valor	=	data.split("|");	
								var c 		=	0;
								for(var i=0; i<=data.length; i++){			
									if(data[i]=="|"){
										c++;
									}
								}
								var cadena	=	"";
								for(var j=1; j<=c+1; j++){
									var k	=	parseInt(j)-1;
									var rpax	=	valor[k].split("@");
									$("#adt"+j).val(rpax[0]);
									$("#chd"+j).val(rpax[1]);
									$("#inf"+j).val(rpax[2]);
									$("#total"+j).val(rpax[3]);
									cadena	+=	rpax[4]+"@";
								}			
								$("#txtarraypasajeros").val(cadena.substring(0, cadena.length-1));
							}										
					},
		complete	:	function(){
							validarObservacionesPasajeros(idinfvue);
					}
	});
}
function validarObservacionesPasajeros(idinfvue){
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/validarObservacionesPasajeros",
		data 	: 	"idinfvue="+idinfvue,
		beforeSend: function(){
						$("#preloader h6").html("Cargando Observaciones Pasajeros...");
						centroautomaticoalerta();
					},
		success		:	function(data){
							var c = 0;
							for(var i=0; i<=data.length; i++){			
								if(data[i]=="|"){
									c++;
								}
							}
							if(c==0){
								
							}else{
								$('#trheaderobs').append('<tr><td>Pasajero</td><td>Nivel</td><td>Observaci&oacute;n</td></tr>');
								var valor	=	data.split("|");			
								var cadena	=	"";
								for(var ct=0; ct<=c; ct++){
									var tvalor	=	valor[ct].split("@");									
									$('#trbodyobs').append('<tr><td><input type="text" class="form-control" id="txtpaxobs'+ct+'" value="'+tvalor[0]+'"></td><td><select class="form-control" id="cbonivelobs'+ct+'"><option value="">Nivel</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td><td><textarea class="form-control" rows="1" id="txtareaobs'+ct+'">'+tvalor[2]+'</textarea></td></tr>');
									$("#cbonivelobs"+ct).val(tvalor[1]).change();
									cadena	+=	tvalor[3]+"@";
								}
								$("#txtarrayobspasajeros").val(cadena.substring(0, cadena.length-1));
							}										
					},
		complete	:	function(){
							validarReclamacionesPasajeros(idinfvue);
					}
	});
}
function validarReclamacionesPasajeros(idinfvue){
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/validarReclamacionesPasajeros",
		data 	: 	"idinfvue="+idinfvue,
		beforeSend: function(){
						$("#preloader h6").html("Cargando Reclamaciones Pasajeros...");
						centroautomaticoalerta();
					},
		success		:	function(data){
							var c = 0;
							for(var i=0; i<=data.length; i++){			
								if(data[i]=="|"){
									c++;
								}
							}
							if(c==0){
								
							}else{
								$('#trheaderrec').append('<tr><td>Pasajero</td><td>Nivel</td><td>Reclamo</td></tr>');
								var valor	=	data.split("|");
								var cadena	=	"";		
								for(var ct=0; ct<=c; ct++){
									var tvalor	=	valor[ct].split("@");
									$('#trbodyrec').append('<tr><td><input type="text" class="form-control" id="txtpaxrec'+ct+'" value="'+tvalor[0]+'"></td><td><select class="form-control" id="cbonivelrec'+ct+'"><option value="">Nivel</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></td><td><textarea class="form-control" rows="1" id="txtarearec'+ct+'">'+tvalor[2]+'</textarea></td></tr>');
									$("#cbonivelrec"+ct).val(tvalor[1]).change();
									cadena	+=	tvalor[3]+"@";
								}
							$("#txtarrayrecpasajeros").val(cadena.substring(0, cadena.length-1));	
							}									
					},
		complete	:	function(){
							validarObservaciones(idinfvue);
					}
	});
} 
function validarObservaciones(idinfvue){
	$.ajax({
		type 	: 	"POST",
		url 	: 	"http://intranet.peruvian.pe/app/inicio/validarObservaciones",
		data 	: 	"idinfvue="+idinfvue,
		beforeSend: function(){
						$("#preloader h6").html("Cargando Observaciones...");
						centroautomaticoalerta();
					},
		success		:	function(data){
							var valor	=	data.split("@");
							var check	=	valor[0].split(",");
							var c = 0;
							for(var i=0; i<=valor[0].length; i++){			
								if(data[i]==","){
									c++;
								}
							}
							for(var j=0; j<=c+1; j++){
								$("#chkobs"+check[j]).prop("checked", "checked");
							}
							$("#txtareadesest").val(valor[1]);
							$("#txtarrayobsvuelo").val(valor[2]);
					},
		complete	:	function(){
							ocultaralerta("g");
					}
	});
}