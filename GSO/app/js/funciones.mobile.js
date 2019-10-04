//Funcion de fecha
//clickpick  , mixed , scroller
$(function(){
    $('#date').mobiscroll().date({
        theme: 'android-ics light',//wp light 
		lang: 'es',
		dateFormat: "dd/mm/yy",
        display: 'bottom',
        mode: 'scroller',
		dateOrder: 'dd MM yy',
		//startYear: now.getFullYear(),
		}); 

//Funcion Time
	$('#time').mobiscroll().time({
        theme: 'android-ics light',
        lang: 'es',
        display: 'bottom',
        mode: 'scroll',
		timeFormat:'h:ii A',
		timeWheels:'hhiiA',
    }); 

});


//elegir tarjeta
$(function(){
    $('#chooseCard').mobiscroll().image({
        theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'scroller',//mixed 
        labels: ['Formas de Pago'],
        
    });      
});

$(function(){
    $('#chooseCity').mobiscroll().image({
        theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'mixed',//mixed scroller
        labels: ['Elija La Ciudad'],
        
    });      
});

// fecha de expiracion
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