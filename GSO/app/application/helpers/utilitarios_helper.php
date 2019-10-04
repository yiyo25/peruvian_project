<?php
if(!defined('BASEPATH')){
	exit('No direct script access allowed');		
}
if(!function_exists('formatoFecha')){
	function formatoFecha($fecha,$tipo){
		if($tipo=='BDaP'){//Base de Datos a Programacion
			$arrayFecha	=	explode('-',$fecha);
			$nuevaFecha	=	$arrayFecha[2].'/'.$arrayFecha[1].'/'.$arrayFecha[0];
		}elseif($tipo=='PaBD'){
			$arrayFecha	=	explode('/',$fecha);
			$nuevaFecha	=	$arrayFecha[2].'-'.$arrayFecha[1].'-'.$arrayFecha[0];
		}
		return $nuevaFecha;
	}
}
/*
** Nombre de Día V2
*/	
if(!function_exists('nombreDia')){
	function nombreDia($dia,$tipo){
		$fecha 	=	$dia;
		$fechats= strtotime($fecha);
		if($tipo=='S'){						
			switch (date('w', $fechats)){ 
				case 0: 
					return 'D'; 
					break; 
				case 1: 
					return 'L'; 
					break;
				case 2: 
					return 'M'; 
					break;
				case 3: 
					return 'X'; 
					break; 
				case 4: 
					return 'J';
					break;
				case 5: 
					return 'V';
					break;
				case 6: 
					return 'S';
					break;
			}
		}elseif($tipo=='M'){
			switch (date('w', $fechats)){ 
				case 0: 
					return 'DOM'; 
					break; 
				case 1: 
					return 'LUN'; 
					break;
				case 2: 
					return 'MAR'; 
					break;
				case 3: 
					return 'MIÉ'; 
					break; 
				case 4: 
					return 'JUE';
					break;
				case 5: 
					return 'VIE';
					break;
				case 6: 
					return 'SÁB';
					break;
			}
		}elseif($tipo=='L'){
			switch (date('w', $fechats)){ 
				case 0: 
					return 'DOMINGO'; 
					break; 
				case 1: 
					return 'LUNES'; 
					break;
				case 2: 
					return 'MARTES'; 
					break;
				case 3: 
					return 'MIÉRCOLES'; 
					break; 
				case 4: 
					return 'JUEVES';
					break;
				case 5: 
					return 'VIERNES';
					break;
				case 6: 
					return 'SÁBADO';
					break;
			}
		}
	}
}
/*
** Nombre de Día V2
*/	
if(!function_exists('nombreMes')){
	function nombreMes($periodo){
		$dataPerido	=	explode('-',$periodo);
		$mes		=	$dataPerido[1];
		switch($mes){
			case 1:
				return 'Enero';
				break;
			case 2:
				return 'Febrero';
				break;
			case 3:
				return 'Marzo';
				break;
			case 4:
				return 'Abril';
				break;
			case 5:
				return 'Mayo';
				break;
			case 6:
				return 'Junio';
				break;
			case 7:
				return 'Julio';
				break;
			case 8:
				return 'Agosto';
				break;
			case 9:
				return 'Septiembre';
				break;
			case 10:
				return 'Octubre';
				break;
			case 11:
				return 'Noviembre';
				break;
			case 12:
				return 'Diciembre';
				break;
		}
	}
}
/*
** Horas a Minutos
*/
if(!function_exists('horaMinuto')){
	function horaMinuto($hora){
		$datoHora	=	explode(':',$hora);
		$HHora		=	$datoHora[0]*60;
		$MHora		=	$datoHora[1];
		return $HHora+$MHora;
	}
}
/*
** Minutos a Horas
*/
if(!function_exists('minutoHora')){
	function minutoHora($hora){
		$HHora	=	str_pad(intval($hora/60),2,'0',STR_PAD_LEFT);
		$MHora	=	str_pad($hora%60,2,'0',STR_PAD_LEFT);
		return $HHora.':'.$MHora;
	}
}
if(!function_exists('diasPeriodo')){
	 function diasPeriodo($periodo) {
		$partePeriodo	=	explode('-',$periodo);
		$mes			=	$partePeriodo[1];
		$ano			=	$partePeriodo[0];
		return date("d",mktime(0,0,0,$mes+1,0,$ano));
	}
}
if(!function_exists('arraydiasPeriodo')){
	 function arraydiasPeriodo($periodo) {
		$dias	=	diasPeriodo($periodo);
		for($d=1;$d<=$dias;$d++){
			$fecha	=	$periodo.'-'.str_pad($d, 2, '0', STR_PAD_LEFT);
			$arrayDias[$fecha]	=	array(
										'dia'	=>	str_pad($d, 2, '0', STR_PAD_LEFT),
										'nombre'=>	nombreDia($fecha,'M')
									);
		}
		return $arrayDias;
	}
}
if(!function_exists('operacionesFecha')){
	function operacionesFecha($fecha,$dias){
		$nuevaFecha	=	date('Y-m-d',strtotime($dias.' day',strtotime($fecha)));
		return $nuevaFecha;
	}
}
if(!function_exists('operacionesPeriodo')){
	function operacionesPeriodo($periodo,$Nmes){
		$dataPeriodo	=	explode('-',$periodo);
		$ano			=	$dataPeriodo[0];
		$mes			=	$dataPeriodo[1];
		if($Nmes[0]=='-'){
			if($mes>1){
				$mesResultado	=	$mes-1;
				$anoResultado	=	$ano;
			}else{
				$mesResultado	=	'12';
				$anoResultado	=	$ano-1;
			}
		}else{
			if($mes<12){
				$mesResultado	=	$mes+1;
				$anoResultado	=	$ano;
			}else{
				$mesResultado	=	'01';
				$anoResultado	=	$ano+1;
			}
		}
		return $anoResultado.'-'.str_pad($mesResultado,2,'0',STR_PAD_LEFT);
	}
}
/*
** Hora Proxima Salida
*/
if(!function_exists('horaProximaSalida')){
	function horaProximaSalida($arrayValores,$TV,$HF){
		$TransIda	=	horaMinuto($arrayValores['TIda']);
		//$TransRet	=	horaMinuto($arrayValores['TRetor']);
		$CheckIn	=	horaMinuto($arrayValores['Chkin']);
		$CheckOut	=	horaMinuto($arrayValores['Chkout']);	
		$HMax		=	horaMinuto($arrayValores['HMax']);
		$DMin		=	horaMinuto($arrayValores['DMin']);
		$HDia		=	horaMinuto('24:00');
		if((2*$TV)<=$HMax){
			$tD	=	$DMin;
		}else{
			$tD	=	(2*$TV);
		}
		$mps	=	$TransIda+$CheckIn+$CheckOut+$tD+$HF;
		/*if($mps<=$HDia){
			$hps	=	$mps;
		}else{
			$hps	=	$mps-$HDia;
		}*/	
		//echo minutoHora($mps).' '.minutoHora($HDia).' '.minutoHora($hps).'<---';
		return minutoHora($mps);
		
	}
}
if(!function_exists('interval_date')){
	function interval_date($init,$finish){
		$date 		=	new DateTime($init); // Fecha actual
		$date2 		=	new DateTime($finish); // Segunda fecha
		$interval 	=	$date->diff($date2); // Restamos la Fecha1 menos la Fecha2		 
		return $interval->format('%a dias'); // Mostramos el resultado
	}
}
if(!function_exists('restaHoras')){
	function restaHoras($hmenor, $hmayor){
  		$dif=date("H:i", strtotime("00:00") + strtotime($hmenor) - strtotime($hmayor));
  		return $dif;
	}   
}
if(!function_exists('sumaHoras')){
	function sumaHoras($h1, $h2){
  		$sum=date("H:i", strtotime($h1) + strtotime($h2)-strtotime("00:00"));
  		return $sum;
	}   
}
if(!function_exists('sumaHoras24')){
	function sumaHoras24($h1, $h2){
		$dataH1	=	explode(':', $h1);
		$dataH2	=	explode(':', $h2);
		$h1 	=	$dataH1[0];
		$m1 	=	$dataH1[1];
		$h2 	=	$dataH2[0];
		$m2 	=	$dataH2[1];
		$sumaM	=	$m1+$m2;
		$sumaH 	=	$h1+$h2;
		if($sumaM>=60){
			$AH	=	1;	
			$M =	$sumaM-60;
		}else{
			$AH = 	0;
			$M 	=	$sumaM;
		}
		$H 	=	$AH+$sumaH;
			
		/*$residuoM	=	$sumaM%60;
  		$sum=date("H:i", strtotime($h1) + strtotime($h2)-strtotime("00:00"));*/
  		return str_pad($H, 2, '0', STR_PAD_LEFT).':'.str_pad($M, 2, '0', STR_PAD_LEFT);
	}   
}
?>