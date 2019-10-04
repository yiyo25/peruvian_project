/*
** Ventana
*/
function ventana(title,ventanacontenido,data){
	$('#ventana').kendoWindow({
		actions		:	['Close'],
		animation	:	{
							close	:	{
											effects	:	'fade:out'
										},
							open	:	{
											effects	:	'fade:in'
										}
						},
		height		:	'auto',//200
		width		:	'auto',//500
		modal		:	true,
		resizable	: 	false,
		draggable	:	false
	});
	var ventana	=	$('#ventana').data('kendoWindow');
	ventana.title(title);
	if(ventanacontenido==''){
		ventana.content(data).center().open();
	}else{
		var ventanaContenido 	=	kendo.template($(ventanacontenido).html());
		ventana.content(ventanaContenido(data)).center().open();		
	}
}
function ventanaSinOpcion(title,ventanacontenido,data){
	$('#ventana').kendoWindow({
		actions		: 	[],
		animation	:	{
							close	:	{
											effects	:	'fade:out'
										},
							open	:	{
											effects	:	'fade:in'
										}
						},
		height		:	'auto',//200
		width		:	'auto',//500
		modal		:	true,
		resizable	: 	false,
		draggable	:	false
	});
	var ventana	=	$('#ventana').data('kendoWindow');
	ventana.title(title);
	if(ventanacontenido==''){
		ventana.content(data).center().open();
	}else{
		var ventanaContenido 	=	kendo.template($(ventanacontenido).html());
		ventana.content(ventanaContenido(data)).center().open();		
	}
}
/*
** Ventana Cerrar
*/
function ventanaCerrar(){
	var ventana				=	$('#ventana').data('kendoWindow');
	ventana.close();
}
/*
** Máscara
*/
function masked(input,format,funcion){
	$(input).kendoMaskedTextBox({
		mask: format,
		change:function(){
			funcion();
		}
	});
}
/*
** Notificación
*/
function notificacion(input,contenido){
	var popupNotification = $(input).kendoNotification({
								position		:	{
														right	: 	20
													}
							}).data("kendoNotification");
	popupNotification.show(contenido);
}
/*
** Combo
*/
function combo(cbo,placeholder,dataValueField,dataTextField,url){
	$(cbo).kendoComboBox({
		dataValueField	:	dataValueField,
		dataTextField	:	dataTextField,		
		placeholder		: 	placeholder,
		filter			: 	"contains",
		minLength		: 	1,
		dataSource		:	{
							transport	:	{
											read	:	{
															dataType:	'json',
															url		:	url
														}
						}
		}
	});
}
/*
** Combo Box
*/
function combobox(cbo,placeholder,dataValueField,dataTextField,url,changecombobox){				
	$(cbo).kendoComboBox({		
		placeholder		: 	placeholder,
		dataValueField	:	dataValueField,
		dataTextField	:	dataTextField,
		filter			: 	'contains',
		autoBind		:	false,
		minLength		: 	1,
		dataSource		:	{
							transport	:	{
											read	:	{
															url		:	url,
															dataType:	'json'
														}
											}
							},
		change			:	function(e){
								if(changecombobox!=''){
									changecombobox();
								}
							}
	}).data('kendoComboBox');
}
/*
** Combo Box Cascada
*/
function comboboxCascada(cbo,placeholder,dataValueField,dataTextField,url,cascadeFrom){
	$(cbo).kendoComboBox({		
		autoBind		:	false,
		cascadeFrom		:	cascadeFrom,
		//cascadeFromField:	cascadeFromField,
		filter			: 	'contains',		
		placeholder		: 	placeholder,
		dataTextField	:	dataTextField,
		dataValueField	:	dataValueField,
		minLength		: 	1,
		dataSource		:	{
							transport	:	{
											read	:	{
															url		:	url,
															dataType:	'json'
														}
											}
							}
	});
}
/*
** Multi Select
*/
function multiselect(input,placeholder,headerTemplate,dataTextField,dataValueField,url,value){
	$(input).kendoMultiSelect({
		headerTemplate	:	headerTemplate,
		placeholder		:	placeholder,
		dataValueField	:	dataValueField,
		dataTextField	:	dataTextField,
		filter			:	'contains',
		autoBind		:	false,
		dataSource		:	{
							transport	:	{
											read	:	{
															dataType:	'json',
															url		:	url
														}
											}
							},
		value			:	value
	});
}
function datePicker(input){
	$(input).kendoDatePicker({
		culture	:	'es-PE',
		format	:	'dd/MM/yyyy'
	});
}