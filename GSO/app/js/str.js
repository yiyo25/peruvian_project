

function Transccion(flag){
	var ocultar = 
	{ 
		margin: 0,
		overflow: "hidden", 
		padding: 0,
		width: 0
	};
	var mostrar =
	{
		height: "auto",
		opacity: 1,
		width: "90%",
		height:"500px"
	};
	
	if(flag==1){
		$("#matricula1").css(mostrar);
		$("#matricula2").css(ocultar);
		$("#matricula3").css(ocultar);
	 	$("#matricula4").css(ocultar);
		$("#matricula5").css(ocultar);
		
	}
	if(flag==2){
		$("#matricula1").css(ocultar);
		$("#matricula2").css(mostrar);
		$("#matricula3").css(ocultar);
	 	$("#matricula4").css(ocultar);
		$("#matricula5").css(ocultar);
	}
	if(flag==3){
		$("#matricula1").css(ocultar);
		$("#matricula2").css(ocultar);
		$("#matricula3").css(mostrar);
	 	$("#matricula4").css(ocultar);
		$("#matricula5").css(ocultar);
	}
	if(flag==4){
		$("#matricula1").css(ocultar);
		$("#matricula2").css(ocultar);
		$("#matricula3").css(ocultar);
	 	$("#matricula4").css(mostrar);
		$("#matricula5").css(ocultar);
	}
	if(flag==5){
		$("#matricula1").css(ocultar);
		$("#matricula2").css(ocultar);
		$("#matricula3").css(ocultar);
	 	$("#matricula4").css(ocultar);
		$("#matricula5").css(mostrar);
	}	
	
}
