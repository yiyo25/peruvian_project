<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dashboard
 *
 * @author ihuapaya
 */
class DashboardController extends Controller{
    
    function __construct() {
        parent::__construct();
        $this->_view->assign("JS", "dashboard"); 
        if(!$this->isAccesoApp()){
            header('location:'.URL_LOGIN_APP);
            exit;
        }else{
            if(!$this->isAccessProgram("CCO_HOME", 1)){
                $this->_view->assign("error_text","El usuario <b>". $_SESSION[NAME_SESS_USER]["id_usuario"]."</b> no tiene permisos para accedar a esta Página.");
                $this->_view->show_page("403.tpl");
                exit;
            }
        }
    }
    
    function indexAction(){
        
        $this->_view->show_page('dashboard.tpl');
        
    }
    
    function pasajerosAction(){
        $vuelo_cabecera = new VueloCabecera();
        $vuelo_pasajero = new VueloPasajero();
        $primer_dia_mes_actual = data_first_month_day();
        $dia_actual = date("Y-m-d");
        $fecha_vuelos = $vuelo_cabecera->getdateFligth($primer_dia_mes_actual, $dia_actual);
        
        $fecha= array();
        $total_pasajero = array();
        $borderColor = array();
        $backgroundColor = array();
        foreach ($fecha_vuelos as $vuelos) {
            $fecha[] = $vuelos["fecha_vuelo"];
            $nro_pasajero =$vuelo_pasajero->totalPajeroPorFechaVuelo($vuelos["fecha_vuelo"]);
            if($nro_pasajero!="NULL" && $nro_pasajero!=""){
                $total_pasajero[]= $nro_pasajero;
            }else{
                 $total_pasajero[]= "0";
            }
            $backgroundColor[]= "rgba(54, 162, 235, 0.2)" ;
            $borderColor[] ="rgba(54, 162, 235, 1)";

        }
        
        $data_pasajeros = array(
            "label"=>"# de vuelos",
            "data"=>$total_pasajero,
            "backgroundColor"=>$backgroundColor,
            "borderColor"=>$borderColor
        );
         $data= array("labels"=>$fecha,"datasets"=>array($data_pasajeros));
        echo json_encode(($data));
        exit;
        
    }
    
    function reportexMesAction(){
        $vuelo_cabecera = new VueloCabecera();
        $array_reportes_Data = $vuelo_cabecera->pasajeros_HorasBlock_CantVuelosxMes();
        $mes=array();
        $total_pasajero = array();
        $total_vuelos=array();
        $total_horasBlock = array();
        $total_vuelos_demorado = array();
        foreach ($array_reportes_Data as $datos) {
            if($datos["pasajeros"] !="NULL" && $datos["pasajeros"]!=""){
                $total_pasajero[]= $datos["pasajeros"];
            }else{
                $total_pasajero[]= "0";
            }
            
            if($datos["horasblock"] !="NULL" && $datos["horasblock"]!=""){
                $total_horasBlock[]= $datos["horasblock"];
            }else{
                $total_horasBlock[]= "0";
            }
            if($datos["cant_vuelos"] !="NULL" && $datos["cant_vuelos"]!=""){
                $total_vuelos[]= $datos["cant_vuelos"];
            }else{
                $total_vuelos[]= "0";
            }
            
            if($datos["vuelo_demorado"] !="NULL" && $datos["vuelo_demorado"]!=""){
                $total_vuelos_demorado[]= $datos["vuelo_demorado"];
            }else{
                $total_vuelos_demorado[]= "0";
            }
                        
            $backgroundColor[]= "rgba(255, 0, 0, 0.2)" ;
            $borderColor[] ="rgba(255, 0, 0, 1)";
                        
            $mes[] = $datos["NombreMes"];
        }
        
        $dataset_pasajeros = array(
            "id"=>"chart_pasajeros",
            "type"=>"bar",
            "data"=>array(
                "labels"=>$mes,
                "datasets"=>array(array(
                    "label"             =>"# de pasajeros",
                    "data"              =>$total_pasajero,
                    "backgroundColor"   =>$backgroundColor,
                    "borderColor"       =>$borderColor
                ))
            )
        );
        
        $dataset_horasBlock = array(
            "id"=>"chart_horasBlock",
            "type"=>"line",
            "data"=>array(
                "labels"=>$mes,
                "datasets"=>array(array(
                    "label"             =>"# de horasBlock",
                    "data"              =>$total_horasBlock,
                    "borderColor"=> 'rgba(75, 192, 192, 1)',
                    "backgroundColor"=> 'rgba(0, 0, 0, 0)'
                ))
            )
        );
        
        $data_vuelo_demorados = array(
            "label"=>"# vuelo demorado",
            "type"=> 'line',
            "labels"=>$mes,
            "data"=>$total_vuelos_demorado,
            "borderColor"=> 'rgba(255, 0, 0, 1)',
            "backgroundColor"=> 'rgba(255, 0, 0, 0.7)',
        );
        
        $dataset_vuelos = array(
            "id"=>"chart_vuelos",
            "type"=>"bar",
            "data"=>array(
                "labels"=>$mes,
                "datasets"=>array(array(
                    "label"             =>"# de vuelos",
                    "data"              =>$total_vuelos,
                    "borderColor"=> 'rgba(0, 0, 255, 1)',
                    "backgroundColor"=> 'rgba(0, 0, 255, 0.2)',
                ),$data_vuelo_demorados)
            )
        );

        $data = array($dataset_pasajeros,$dataset_horasBlock,$dataset_vuelos);
        echo json_encode($data);
        exit;
    }
    
    
    /*function vuelospordiaAction(){
        $vuelo_cabecera = new VueloCabecera();
        $vuelo_pasajero = new VueloDetalle();
        $primer_dia_mes_actual = data_first_month_day();
        $dia_actual = date("Y-m-d");
        $fecha_vuelos = $vuelo_cabecera->getdateFligth("2019-08-01", "2019-08-30");
        
        $fecha= array();
        $fecha_demo = array();
        $total_pasajero = array();
        $borderColor = array();
        $backgroundColor = array();
        foreach ($fecha_vuelos as $vuelos) {
            $fecha[] = $vuelos["fecha_vuelo"];
            $cant_vuelos =$vuelo_pasajero->cantVueloPorDia($vuelos["fecha_vuelo"]);
            if($cant_vuelos!="NULL" && $cant_vuelos!=""){
                $total_vuelos[]= $cant_vuelos;
            }else{
                 $total_vuelos[]= "0";
            }
            $backgroundColor[]= "rgba(54, 162, 235, 0.2)" ;
            $borderColor[] ="rgba(54, 162, 235, 1)";
            
            $rs_vuelos = $vuelo_pasajero->getVuelosOperativos($vuelos["fecha_vuelo"]);
            $sum_vuelos_salidos_itin = 0;
            $sum_vuelos_llegados_itin = 0;
         
            foreach ($rs_vuelos["data"]["vuelo_cabecera"] as $key => $valueDetalle) {
                $cont_cel = 0;
                if(isset($valueDetalle["detalle"])){
                    foreach ($valueDetalle["detalle"] as $key => $value) {
                        $hora_cierre_puerta = $value["ETD"];
                        $hora_apertura_puerta = $value["ETA"];
                        $ATD = $value["ATD"];
                        $ATA = $value["ATA"];
                        if ($value["id_vuelo_detalle"] > 0) {
                            $time_hora_cierre_puerta = strtotime((trim($hora_cierre_puerta) != "" ? $hora_cierre_puerta : "00:00") . ":00");
                            $timeATD = strtotime((trim($ATD) != "" ? $ATD : "00:00") . ":00");
                            $time_hora_apertura_puerta = strtotime((trim($hora_apertura_puerta) != "" ? $hora_apertura_puerta : "00:00") . ":00");
                            $time_hora_llegada = strtotime((trim($ATA) != "" ? $ATA : "00:00") . ":00");

                            $datetime_hora_cierre_puerta = new DateTime((trim($hora_cierre_puerta) != "" ? "$hora_cierre_puerta:00" : "00:00:00"));
                            $datetime_ATD = new DateTime((trim($ATD) != "" ? "$ATD:00" : "00:00:00"));
                            $vuelos_salidos_itin = $timeATD <= $time_hora_cierre_puerta ? 1 : 0;
                            $vuelos_llegados_itin = $time_hora_llegada <= $time_hora_apertura_puerta ? 1 : 0;
                            $sum_vuelos_salidos_itin += $vuelos_salidos_itin;
                            $sum_vuelos_llegados_itin += $vuelos_llegados_itin;
                        }

                    }
                }
            }

            $fecha_demo["data"][]=$rs_vuelos["cant"]-$sum_vuelos_salidos_itin;
            
            $nro_vuelo_demorado = $rs_vuelos["cant"]-$sum_vuelos_salidos_itin;
            $total_vuelo_demorados[] = $nro_vuelo_demorado;
            $array_nuevo []=46-$sum_vuelos_salidos_itin;
            
        }
        
        
        
        $data_vuelos = array(
            "label"=>"# de vuelos",
            "labels"=>$fecha,
            "data"=>$total_vuelos,
            "borderColor"=> 'rgba(0, 0, 255, 1)',
            "backgroundColor"=> 'rgba(0, 0, 255, 0.2)',
        );
        $data_vuelo_demorados = array(
            "label"=>"vuelo demorado",
            "type"=> 'line',
            "labels"=>$fecha,
            "data"=>$total_vuelo_demorados,
            "borderColor"=> 'rgba(255, 0, 0, 1)',
            "backgroundColor"=> 'rgba(255, 0, 0, 0.7)',
        );
        $data= array("labels"=>$fecha,"datasets"=>array($data_vuelos,$data_vuelo_demorados));
        echo json_encode($data);
        exit;
        
    }*/
    
    function vueloporLocalidadAction(){
        $vuelo_cabecera = new VueloCabecera();
        $year = date("Y");
        $mes = date("m");
        $vuelos_localidad = $vuelo_cabecera->vuelos_por_localidad('2019','07');
        $localidad = array();
        $cant_vuelos = array();
        $vuelo_demorados = array();
        $cant_vuelos2 = array();
        $vuelo_demorados2 = array();
        foreach ($vuelos_localidad as $value) {
            $localidad[] = $value["ciudad_origen"];
            $cant_vuelos[] = 100;
            $cant_vuelos2[] = $value["nro_vuelos"];
            $vuelo_demorados[] =  ($value["demorados"]*100)/$value["nro_vuelos"];
            $vuelo_demorados2[] = $value["demorados"];
        }
        
        $data_vuelos = array(
            "label"=>"# de vuelos",
            "labels"=>$localidad,
            "data"=>$cant_vuelos,
            "borderColor"=> 'rgb(54, 162, 235)',
            "backgroundColor"=> 'rgb(54, 162, 235,0.5)',
        );
        $data_vuelo_demorados = array(
            "label"=>"# vuelo demorado",
            "type"=> 'line',
            "labels"=>$localidad,
            "data"=>$vuelo_demorados,
            "borderColor"=> 'rgba(255, 99, 132, 1)',
            "backgroundColor"=> 'rgba(255, 99, 132,0.7)',
        );
        
        $data_vuelos2 = array(
            "label"=>"# de vuelos",
            "labels"=>$localidad,
            "data"=>$cant_vuelos2,
            "borderColor"=> 'rgb(54, 162, 235)',
            "backgroundColor"=> 'rgb(54, 162, 235,0.5)',
        );
        $data_vuelo_demorados2 = array(
            "label"=>"# vuelo demorado",
            "type"=> 'line',
            "labels"=>$localidad,
            "data"=>$vuelo_demorados2,
            "borderColor"=> 'rgba(255, 99, 132, 1)',
            "backgroundColor"=> 'rgba(255, 99, 132,0.7)',
        );
        $data= array("labels"=>$localidad,"datasets"=>array($data_vuelos,$data_vuelo_demorados),"datasets2"=>array($data_vuelos2,$data_vuelo_demorados2));
        echo json_encode($data);
        exit;
    }
    
    function vueloporLocalidadDataAction(){
        $vuelo_cabecera = new VueloCabecera();
        $year = date("Y");
        $mes = date("m");
        $vuelos_localidad = $vuelo_cabecera->vuelos_por_localidad('2019','07');
        $localidad = array();
        $cant_vuelos = array();
        $vuelo_demorados = array();
        foreach ($vuelos_localidad as $value) {
            $localidad[] = $value["ciudad_origen"];
            $cant_vuelos[] = $value["nro_vuelos"];
            //$vuelo_demorados[] =  ($value["demorados"]*100)/$value["nro_vuelos"];
            $vuelo_demorados[] = $value["demorados"];
        }
        
        $data_vuelos = array(
            "label"=>"# de vuelos",
            "labels"=>$localidad,
            "data"=>$cant_vuelos,
            "borderColor"=> 'rgb(54, 162, 235)',
            "backgroundColor"=> 'rgb(54, 162, 235,0.5)',
        );
        $data_vuelo_demorados = array(
            "label"=>"# vuelo demorado",
            "type"=> 'line',
            "labels"=>$localidad,
            "data"=>$vuelo_demorados,
            "borderColor"=> 'rgba(255, 99, 132, 1)',
            "backgroundColor"=> 'rgba(255, 99, 132,0.7)',
        );
        $data= array("labels"=>$localidad,"datasets"=>array($data_vuelos,$data_vuelo_demorados));
        echo json_encode($data);
        exit;
    }
    
    
}
