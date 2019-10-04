//------------------------------------------------------------Calendario
$(function(){
    $('#date').mobiscroll().date({
       // invalid: {
		//daysOfWeek: [1,5,6],   dias de la semana no seleccionables
		//daysOfMonth: ['5/1', '12/24', '12/25']  dias del año no seleccionables - feriados, etc
		//},  
        theme: 'android-ics light',//wp light 
		lang: 'es',
		startYear: 2013,
		//startYear: 2009,
		//endYear: now.getFullYear() + 5,
		//endYear:2020,
		endYear:2013,
		dateFormat: "dd/mm/yy",
        display: 'bottom',
        mode: 'clickpick',//clickpick  , mixed , scroller
		dateOrder: 'dd MM yy'
    }); 

//---------------------------------------------------Funciones de Tiempo
	$('#time').mobiscroll().time({
        theme: 'android-ics light',
        lang: 'es',
        display: 'bottom',
        mode: 'scroll',
		timeFormat:'h:ii A',
		timeWheels:'hhiiA',
    }); 
	
   /*$('#show').click(function(){
        $('#date').mobiscroll('show'); 
        return false;
    });
    $('#clear').click(function () {
        $('#date').val('');
        return false;
    });*/
});


////---------------------------------------------------Elegir Tarjeta
$(function(){
    $('#chooseCard').mobiscroll().image({
        theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'mixed',//
        labels: ['Formas de Pago'],
        
    });      
});

// Expiracion de Tarjeta
$(function(){
    var now = new Date();

    $('#ccexp').mobiscroll().date({
        theme: 'android-ics light',
        lang: 'es',
        display: 'bottom',
        mode: 'mixed',//mixed
        dateOrder: 'mmyy',
        dateFormat: 'mm/yy',
        startYear: now.getFullYear(),
        endYear: now.getFullYear() + 10,
        width: 100
    });
});