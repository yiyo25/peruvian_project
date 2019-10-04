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

// Flight
$(function(){
    $('#chooseFlight').mobiscroll().image({
        theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'mixed',//mixed scroller
        labels: ['Elija El Vuelo']
    });      
});
$(function(){
	$('#txtfecha').mobiscroll().date({
        theme: 'android-ics light',//wp light 
		lang: 'es',
		dateFormat: "dd/mm/yy",
        display: 'bottom', 
        mode: 'scroller',
		dateOrder: 'dd MM yy',
		showNow: true
	});		
    $('#cbovuelodg').mobiscroll().select({
      	theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'scroller',
        minWidth: 200
    });
	$('#cbodestc2').mobiscroll().select({
        theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'scroller',
        minWidth: 200
    });
	$('#cbodestc3').mobiscroll().select({
        theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'scroller',
        minWidth: 200
    });
	$('#cbodestc4').mobiscroll().select({
        theme: 'android-ics light',
        display: 'bottom',
		lang: 'es',
        mode: 'scroller',
        minWidth: 200
    });
});
function mostraralerta(data, tipo){
	$("#opaco").css('display','block');
	if(tipo=="a"){
		$("#preloader").css('display','block');
		$("#mensaje h6").html(data);		
		$("#div_btn").css('display','block');
	}else if(tipo=="g"){
		$("#mensaje h6").html(data);
		$("#preloader").css('display','block');
		$("#spinner").css('display','block');
	}
	centroautomaticoalerta();
}
function ocultaralerta(tipo){
	$("#opaco").css('display','none');
	if(tipo=="a"){
		$("#preloader").css('display','none');
		$("#mensaje h6").html("");		
		$("#div_btn").css('display','none');
	}else if(tipo=="g"){
		$("#preloader").css('display','none');
		$("#spinner").css('display','none');
		$("#mensaje h6").html("");		
	}	
}
function centroautomaticoalerta(){
	var heightalerta	=	$("#preloader").height()/2;
	var widthalerta		=	$("#preloader").width()/2;
	$("#preloader").css({'margin-left':-widthalerta,'margin-top':-heightalerta});
}