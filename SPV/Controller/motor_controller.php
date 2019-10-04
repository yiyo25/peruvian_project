<?php
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 300);

if( !isset($_SESSION)){
	session_start();
}
	
class motor extends Controller {
	function __construct(){
        parent::__construct();  //Llama al constructor de su padre
	}
    
    public function listarTripulantesMotorView(){
        try{
            $motor = new Motor_model();
            
            $TIPTRIP_id = $_POST["TIPTRIP_id"];
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            $TIPTRIPU_id = $_POST["TIPTRIPU_id"];
            
            $parts = explode('/',$_POST["ITI_fch"]);
            $fechaProg = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            //------------------- Listar Tripulantes Disponibles -------------------
            if($TIPTRIP_id == "Vuelo" and $TIPTRIPDET_id == "Instructor"){
                //------------------- Para Tripulantes de Vuelo -------------------
                $objTripVueloMotor = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id,'Si','');
                $objTripVueloMotor = $this->array_utf8_encode($objTripVueloMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripVueloMotor);
            } else if($TIPTRIP_id == "Vuelo" and $TIPTRIPDET_id == "Piloto"){
                //------------------- Para Tripulantes de Vuelo -------------------
                $objTripVueloMotor = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id,'','');
                $objTripVueloMotor = $this->array_utf8_encode($objTripVueloMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripVueloMotor);
            } else if($TIPTRIP_id == "Vuelo" and $TIPTRIPDET_id == "Copiloto"){
                $TRIP_id = $_POST["TRIP_id"];
                //------------------- Para Tripulantes de Vuelo -------------------
                $objTripVueloMotor = $motor->listarTripulanteCondicionalesBasicas('1','2',$fechaProg,$TRIP_id,$arrayTRIP_id,'','');
                $objTripVueloMotor = $this->array_utf8_encode($objTripVueloMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripVueloMotor);
            } else if($TIPTRIP_id == "Cabina" and $TIPTRIPDET_id == "JefeCabina"){
                //------------------- Para Tripulantes de Cabina -------------------
                $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','8',$fechaProg,'',$arrayTRIP_id,'','');
                $objTripCabinaMotor = $this->array_utf8_encode($objTripCabinaMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripCabinaMotor);
            } else if($TIPTRIP_id == "Cabina" and $TIPTRIPDET_id == "Cabina"){
                //------------------- Para Tripulantes de Cabina -------------------
                $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id,'','');
                $objTripCabinaMotor = $this->array_utf8_encode($objTripCabinaMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripCabinaMotor);
            } else{
                //------------------- Para Apoyo en Vuelo -------------------
                $objTripApoyoMotor = $motor->listarTripulanteCondicionalesBasicas('','',$fechaProg,'',$arrayTRIP_id,'','');
                $objTripApoyoMotor = $this->array_utf8_encode($objTripApoyoMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripApoyoMotor);
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
	
    /* public function listarTripulantesMotor(){
        try{
            $motor = new Motor_model();
            $detalle = new Detalle_model();
            
            $TIPTRIP_id = $_POST["TIPTRIP_id"];
            $TIPTRIPDET_id = $_POST["TIPTRIPDET_id"];
            $RUT_num_vuelo = $_POST["RUT_num_vuelo"];
            $TIPTRIPU_id = $_POST["TIPTRIPU_id"];
            
            $parts = explode('/',$_POST["ITI_fch"]);
            $fechaProg = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            
            if($TIPTRIPU_id != ""){
                //------------------- Tripulantes para verificar Movimiento -------------------
                $objMoviTripVueloMotor = $motor->listarTripulantexMovimiento('','',$RUT_num_vuelo,$fechaProg);
                
                $objReglasBTMotor = $detalle->listarBlockTimexTripulacion($TIPTRIPU_id);
                $objReglasDTMotor = $detalle->listarDuttyTimexTripulacion($TIPTRIPU_id);
                
                $arrayTRIP_id = "";
                for($j = 0;$j<=count($objReglasBTMotor);$j++){
                    for($i = 0;$i<=count($objMoviTripVueloMotor);$i++){
                        $campo = $objReglasBTMotor[$j]["BT_cantidad"].$objReglasBTMotor[$j]["BT_periodo"]."_BT";
                        if($objMoviTripVueloMotor[$i]["".$campo.""] >= ((($objReglasBTMotor[$j]["BT_horaBT"])*60)-10)){
                            $arrayTRIP_id .= "'".$objMoviTripVueloMotor[$i]["TRIP_id"]."',";
                        }
                    }
                }
                
                for($j = 0;$j<=count($objReglasDTMotor);$j++){
                    for($i = 0;$i<=count($objMoviTripVueloMotor);$i++){
                        $campo = $objReglasDTMotor[$j]["DT_cantidad"].$objReglasDTMotor[$j]["DT_periodo"]."_DT";

                        if($objMoviTripVueloMotor[$i]["".$campo.""] >= ((($objReglasDTMotor[$j]["DT_horaDT"])*60)-10)){
                            $arrayTRIP_id .= "'".$objMoviTripVueloMotor[$i]["TRIP_id"]."',";
                        }
                    }
                }
                $arrayTRIP_id = substr($arrayTRIP_id, 0, -1);
            }
            
            //------------------- Listar Tripulantes Disponibles -------------------
            if($TIPTRIP_id == "Vuelo" and $TIPTRIPDET_id == "Instructor"){
                //------------------- Para Tripulantes de Vuelo -------------------
                $objTripVueloMotor = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id,'Si');
                $objTripVueloMotor = $this->array_utf8_encode($objTripVueloMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripVueloMotor);
            } else if($TIPTRIP_id == "Vuelo" and $TIPTRIPDET_id == "Piloto"){
                //------------------- Para Tripulantes de Vuelo -------------------
                $objTripVueloMotor = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id,'');
                $objTripVueloMotor = $this->array_utf8_encode($objTripVueloMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripVueloMotor);
            } else if($TIPTRIP_id == "Vuelo" and $TIPTRIPDET_id == "Copiloto"){
                $TRIP_id = $_POST["TRIP_id"];
                //------------------- Para Tripulantes de Vuelo -------------------
                $objTripVueloMotor = $motor->listarTripulanteCondicionalesBasicas('1','2',$fechaProg,$TRIP_id,$arrayTRIP_id,'');
                $objTripVueloMotor = $this->array_utf8_encode($objTripVueloMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripVueloMotor);
            } else if($TIPTRIP_id == "Cabina" and $TIPTRIPDET_id == "JefeCabina"){
                //------------------- Para Tripulantes de Cabina -------------------
                $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','8',$fechaProg,'',$arrayTRIP_id,'');
                $objTripCabinaMotor = $this->array_utf8_encode($objTripCabinaMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripCabinaMotor);
            } else if($TIPTRIP_id == "Cabina" and $TIPTRIPDET_id == "Cabina"){
                //------------------- Para Tripulantes de Cabina -------------------
                $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id,'');
                $objTripCabinaMotor = $this->array_utf8_encode($objTripCabinaMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripCabinaMotor);
            } else{
                //------------------- Para Apoyo en Vuelo -------------------
                $objTripApoyoMotor = $motor->listarTripulanteCondicionalesBasicas('','',$fechaProg,'',$arrayTRIP_id,'');
                $objTripApoyoMotor = $this->array_utf8_encode($objTripApoyoMotor);
                header('Content-Type: application/json');
                echo json_encode($objTripApoyoMotor);
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }*/
    
    /*public function programacionAutomatica(){
        try{
            $programacion = new Programacion_model();
            $motor = new Motor_model();
            $detalle = new Detalle_model();
            
            $objModulo = false;

            $objListaModulo = $detalle->listarModulo();
            foreach($objListaModulo as $listaListaModulo){
                if($listaListaModulo["MOD_estado"] == '1'){
                    $objModulo = true;
                    break;
                }
            }
            
            if($objModulo){
                
                $motor->insertMotorLog('INICIO',date("Ymd H:i:s"));
                $motor->insertEstadoFlag('1','EDICION');
                
                // ----- Tipo de Tripulación ----- 
                //Para Trip. de Vuelo Normal
                $TIPTRIPU_id_Vuelo = "1";
                //Para Trip. de Cabina Minima
                $TIPTRIPU_id_CabinaMinima = "2";
                //Para Trip. de Cabina Reforzada
                $TIPTRIPU_id_CabinaReforzada = "3";

                // ----- Validaciones de Normatividad ----- 
                //Trip. de Vuelo: Block Time
                $objReglasBTVuelo = $detalle->listarBlockTimexTripulacion($TIPTRIPU_id_Vuelo);
                //Trip. de Vuelo: Dutty Time
                $objReglasDTVuelo = $detalle->listarDuttyTimexTripulacion($TIPTRIPU_id_Vuelo);
                //Trip. de Cabina: Block Time
                $objReglasBTCabina = $detalle->listarBlockTimexTripulacion($TIPTRIPU_id_CabinaMinima);
                //Trip. de Cabina: Dutty Time
                $objReglasDTCabina = $detalle->listarDuttyTimexTripulacion($TIPTRIPU_id_CabinaMinima);

                $objProgramacion = $programacion->listarProgramacion('','','');
                
                //echo "<pre>".print_r($objProgramacion,true)."</pre>";
                
                $objCTFT = $detalle->listarCTFT();
                
                for($i = 0; $i < count($objProgramacion); $i++){
                    $RUT_relacion_i = $objProgramacion[$i]["RUT_relacion"];
                    $RUT_orden_i = $objProgramacion[$i]["RUT_orden"];
                    $RUT_num_vuelo_i = $objProgramacion[$i]["RUT_num_vuelo"];
                    $ITI_fch_i = $objProgramacion[$i]["ITI_fch"];

                    $RUT_num_vuelo_ini = array();
                    $RUT_num_vuelo_fin = array();
                    $RUT_num_vuelo = array();

                    for($j = ($i+1); $j < count($objProgramacion); $j++){
                        $RUT_relacion_f = $objProgramacion[$j]["RUT_relacion"];
                        $RUT_orden_f = $objProgramacion[$j]["RUT_orden"];
                        $RUT_num_vuelo_f = $objProgramacion[$j]["RUT_num_vuelo"];
                        $ITI_fch_f = $objProgramacion[$j]["ITI_fch"];

                        if( $RUT_relacion_i == $RUT_relacion_f and $RUT_orden_i < $RUT_orden_f and $ITI_fch_i == $ITI_fch_f ){
                            $RUT_num_vuelo_ini = array_merge($RUT_num_vuelo_ini,array($objProgramacion[$i]["RUT_num_vuelo"]));
                            $RUT_num_vuelo_fin = array_merge($RUT_num_vuelo_fin,array($objProgramacion[$j]["RUT_num_vuelo"]));
                            $RUT_num_vuelo = array_merge($RUT_num_vuelo_ini,$RUT_num_vuelo_fin);
                            $RUT_num_vuelo = array_unique($RUT_num_vuelo);
                            $RUT_num_vuelo = array_values($RUT_num_vuelo);
                            
                            if( count($RUT_num_vuelo) != '2' ){
                                $i++;
                            }
                        }
                    }
                    
                    $parts = explode('/',$objProgramacion[$i]["ITI_fch"]);
                    $fechaProg = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                    
                    if( count($RUT_num_vuelo) > '0' ){
                        $objMoviTripVueloMotor = $motor->listarTripulantexMovimiento('','',$RUT_num_vuelo,$fechaProg);
                        
                        // ---------------------------------------- Para Tripulantes de Vuelo ----------------------------------------
                        // ----- Validar Trip. Vuelo - Tiempo Total de BT -----
                        foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                            $TimeBT = array();
                            foreach ($objReglasBTVuelo as $listaReglasBT){

                                $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";

                                if(isset($TimeBT[$campo])){
                                    $TimeBT[$campo] = $TimeBT[$campo] + $listaTripVueloMotor["".$campo.""];
                                }
                                else{
                                    $TimeBT = array_merge($TimeBT,array($campo =>$listaTripVueloMotor["".$campo.""]));
                                }
                            }
                        }
                        // ----- Validar Trip. Vuelo - Tiempo Total de DT -----
                        foreach ($objReglasDTVuelo as $listaReglasDT){
                            $TimeDT = array();
                            foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                                $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                                $TimeDT[$campo] = $listaTripVueloMotor["".$campo.""];
                            }
}

                        $arrayTRIP_id_vuelo = "";
                        // ----- Validar Trip. Vuelo: BT -----
                        foreach ($objReglasBTVuelo as $listaReglasBT){
                            foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                                $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";

                                $llavesBT = array_keys($TimeBT);

                                foreach($llavesBT as $listaLlavesBT){
                                    if($listaLlavesBT == $campo){
                                        if($TimeBT["".$listaLlavesBT.""] >= ((($listaReglasBT["BT_horaBT"])*60)-10)){
                                            $arrayTRIP_id .= "'".$listaTripVueloMotor["TRIP_id"]."',";
                                        }
                                    }
                                }


                            }
}
                        // ----- Validar Trip. Vuelo: DT -----
                        foreach ($objReglasDTVuelo as $listaReglasDT){
                            foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                                $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";

                                $llavesDT = array_keys($TimeDT);
                                foreach($llavesDT as $listaLlavesDT){
                                    if($listaLlavesDT == $campo){
                                        if($TimeDT["".$listaLlavesDT.""] >= ((($listaReglasDT["DT_horaDT"])*60)-10)){
                                            $arrayTRIP_id .= "'".$listaTripVueloMotor["TRIP_id"]."',";
                                        }
                                    }
                                }
                            }
}
                        $arrayTRIP_id_vuelo = substr($arrayTRIP_id, 0, -1);

                        // ---------------------------------------- Para Tripulantes de Cabina ----------------------------------------
                        // ----- Validar Trip. Cabina - Tiempo Total de BT -----
                        foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                            $TimeBT = array();
                            foreach ($objReglasBTCabina as $listaReglasBT){

                                $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";

                                if(isset($TimeBT[$campo])){
                                    $TimeBT[$campo] = $TimeBT[$campo] + $listaTripVueloMotor["".$campo.""];
                                }
                                else{
                                    $TimeBT = array_merge($TimeBT,array($campo =>$listaTripVueloMotor["".$campo.""]));
                                }
                            }
}

                        // ----- Validar Trip. Vuelo - Tiempo Total de DT -----
                        foreach ($objReglasDTCabina as $listaReglasDT){
                            $TimeDT = array();
                            foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                                $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                                $TimeDT[$campo] = $listaTripVueloMotor["".$campo.""];
                            }
}

                        $arrayTRIP_id_cabina = "";
                        // ----- Validar Trip. Vuelo: BT -----
                        foreach ($objReglasBTCabina as $listaReglasBT){
                            foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                                $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";

                                $llavesBT = array_keys($TimeBT);

                                foreach($llavesBT as $listaLlavesBT){
                                    if($listaLlavesBT == $campo){
                                        if($TimeBT["".$listaLlavesBT.""] >= ((($listaReglasBT["BT_horaBT"])*60)-10)){
                                            $arrayTRIP_id .= "'".$listaTripVueloMotor["TRIP_id"]."',";
                                        }
                                    }
                                }


                            }
}
                        // ----- Validar Trip. Vuelo: DT -----
                        foreach ($objReglasDTCabina as $listaReglasDT){
                            foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                                $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";

                                $llavesDT = array_keys($TimeDT);
                                foreach($llavesDT as $listaLlavesDT){
                                    if($listaLlavesDT == $campo){
                                        if($TimeDT["".$listaLlavesDT.""] >= ((($listaReglasDT["DT_horaDT"])*60)-10)){
                                            $arrayTRIP_id .= "'".$listaTripVueloMotor["TRIP_id"]."',";
                                        }
                                    }
                                }
                            }
}
                        $arrayTRIP_id_cabina = substr($arrayTRIP_id, 0, -1);

                        //------------------- Lista de Tripulantes de Vuelo: Piloto -------------------
                        $objTripVueloPiloto = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id_vuelo,'');
                        shuffle($objTripVueloPiloto);
                        $TRIP_id_Piloto = $objTripVueloPiloto[0]["TRIP_id"];

                        //------------------- Lista de Tripulantes de Vuelo: Copiloto -------------------
                        $objTripVueloCopiloto = $motor->listarTripulanteCondicionalesBasicas('1','2',$fechaProg,$TRIP_id_Piloto,$arrayTRIP_id_vuelo,'');
                        shuffle($objTripVueloCopiloto);
                        $TRIP_id_Copiloto = $objTripVueloCopiloto[0]["TRIP_id"];

                        //------------------- Para Tripulantes de JefeCabina -------------------
                        $objTripJefeCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','8',$fechaProg,'',$arrayTRIP_id_cabina,'');
                        shuffle($objTripJefeCabinaMotor);
                        $TRIP_id_JefeCabina = $objTripJefeCabinaMotor[0]["TRIP_id"];
                        
                        //------------------- Para Tripulantes de Cabina -------------------
                        $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id_cabina,'');
                        shuffle($objTripCabinaMotor);
                        $TRIP_id_Cabina1 = $objTripCabinaMotor[1]["TRIP_id"];
                        $TRIP_id_Cabina2 = $objTripCabinaMotor[2]["TRIP_id"];
                        
                        $TIPAVI_serie = $objProgramacion[$i]["TIPAVI_serie"];
                        if($TIPAVI_serie == '400'){
                            $TRIP_id_Cabina3 = $objTripCabinaMotor[3]["TRIP_id"];
                        }
                        
                        for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            
                            $objProgramacionRuta = $programacion->listarProgramacion($objProgramacion[$i]["ITI_fch"],'',$RUT_num_vuelo[$r]);
                            
                            $ITI_id = $objProgramacionRuta[0]["ITI_id"];
                            $RUT_num_vuelo_mov = $objProgramacionRuta[0]["RUT_num_vuelo"];
                            $parts = explode('/',$objProgramacionRuta[0]["ITI_fch"]);
                            $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

                            $fecha_actual = strtotime(date("d-m-Y",time()));
                            $fecha_entrada = strtotime($parts[0] . '-' . $parts[1] . '-' . $parts[2]);

                            if( $fecha_entrada >= $fecha_actual ){
                                $objProgramacionxTripulante = $programacion->listarProgramacionxTripulante($ITI_id);

                                if( count($objProgramacionxTripulante) == 0 ){

                                    foreach($objCTFT as $listaCTFT){
                                        $CT_FT_id = $listaCTFT["CT_FT_id"];
                                        if($objProgramacionRuta[0]["RUT_hora_salida"] >= $listaCTFT["CT_FT_hora_ini"] && $objProgramacionRuta[0]["RUT_hora_salida"] <= $listaCTFT["CT_FT_hora_fin"]){
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_Piloto,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_Copiloto,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_JefeCabina,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina1,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina2,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            if($TIPAVI_serie == '400'){
                                                $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina3,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            }
                                        }
                                    }

                                    $programacion->insertProgramacion($ITI_id,$TRIP_id_Piloto,'1','Piloto');
                                    $programacion->insertMovimientoTrip($TRIP_id_Piloto,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    $programacion->insertProgramacion($ITI_id,$TRIP_id_Copiloto,'1','Copiloto');
                                    $programacion->insertMovimientoTrip($TRIP_id_Copiloto,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    $programacion->insertProgramacion($ITI_id,$TRIP_id_JefeCabina,'2','JefeCabina');
                                    $programacion->insertMovimientoTrip($TRIP_id_JefeCabina,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    $programacion->insertProgramacion($ITI_id,$TRIP_id_Cabina1,'2','TripCabina1');
                                    $programacion->insertMovimientoTrip($TRIP_id_Cabina1,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    $programacion->insertProgramacion($ITI_id,$TRIP_id_Cabina2,'2','TripCabina2');
                                    $programacion->insertMovimientoTrip($TRIP_id_Cabina2,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    if($TIPAVI_serie == '400'){
                                        $programacion->insertProgramacion($ITI_id,$TRIP_id_Cabina3,'2','TripCabina3');
                                        $programacion->insertMovimientoTrip($TRIP_id_Cabina3,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');
                                    }

                                }
                                else {
                                    foreach($objProgramacionxTripulante as $listaProgramacionxTripulante){
                                        $ITI_id = $listaProgramacionxTripulante["ITI_id"];
                                        $TRIP_id = $listaProgramacionxTripulante["TRIP_id"];
                                        $ITI_TRIP_tipo = $listaProgramacionxTripulante["ITI_TRIP_tipo"];

                                        $objTripulanteCondicionalesBasicas_x_Tripulante = $motor->listarTripulanteCondicionalesBasicas_x_Tripulante($ITI_fch,$TRIP_id);

                                        if( count($objTripulanteCondicionalesBasicas_x_Tripulante) > 0 ){
                                            if( $ITI_TRIP_tipo == 'Piloto' ){

                                                $objTripVueloPiloto = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id_vuelo,'');
                                                shuffle($objTripVueloPiloto);
                                                $TRIP_id_Piloto_nuevo = $objTripVueloPiloto[0]["TRIP_id"];
                                                
                                                for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            
                                                    $objProgramacionRuta = $programacion->listarProgramacion($objProgramacion[$i]["ITI_fch"],'',$RUT_num_vuelo[$r]);

                                                    $ITI_id = $objProgramacionRuta[0]["ITI_id"];
                                                    $RUT_num_vuelo_mov = $objProgramacionRuta[0]["RUT_num_vuelo"];
                                                    $parts = explode('/',$objProgramacionRuta[0]["ITI_fch"]);
                                                    $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

                                                    $programacion->updateProgramacion($TRIP_id_Piloto_nuevo,$ITI_id,$ITI_TRIP_tipo);
                                                    $programacion->updateMovimientoTrip($TRIP_id_Piloto_nuevo,$TRIP_id,$ITI_fch,$RUT_num_vuelo_mov);
                                                    $motor->insertMotorCambio($ITI_id,$ITI_fch,$RUT_num_vuelo_mov,$TRIP_id,$TRIP_id_Piloto_nuevo);
                                                }
                                            }
                                            if( $ITI_TRIP_tipo == 'Copiloto' ){

                                                $objTripVueloCopiloto = $motor->listarTripulanteCondicionalesBasicas('1','2',$fechaProg,$TRIP_id_Piloto,$arrayTRIP_id_vuelo,'');
                                                shuffle($objTripVueloCopiloto);
                                                $TRIP_id_Copiloto_nuevo = $objTripVueloCopiloto[0]["TRIP_id"];

                                                //for($s = $i; $s > ($i-count($RUT_num_vuelo)); $s--){
                                                    //$ITI_id = $objProgramacion[$s]["ITI_id"];
                                                    //$RUT_num_vuelo_mov = $objProgramacion[$s]["RUT_num_vuelo"];
                                                    //$parts = explode('/',$objProgramacion[$s]["ITI_fch"]);
                                                    //$ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                                                for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            
                                                    $objProgramacionRuta = $programacion->listarProgramacion($objProgramacion[$i]["ITI_fch"],'',$RUT_num_vuelo[$r]);

                                                    $ITI_id = $objProgramacionRuta[0]["ITI_id"];
                                                    $RUT_num_vuelo_mov = $objProgramacionRuta[0]["RUT_num_vuelo"];
                                                    $parts = explode('/',$objProgramacionRuta[0]["ITI_fch"]);
                                                    $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                                                    
                                                    $programacion->updateProgramacion($TRIP_id_Copiloto_nuevo,$ITI_id,$ITI_TRIP_tipo);
                                                    $programacion->updateMovimientoTripupdateMovimientoTrip($TRIP_id_Copiloto_nuevo,$ITI_fch,$RUT_num_vuelo_mov);
                                                    $motor->insertMotorCambio($ITI_id,$ITI_fch,$RUT_num_vuelo_mov,$TRIP_id,$TRIP_id_Copiloto_nuevo);
                                                }
                                            }
                                            if( $ITI_TRIP_tipo == 'JefeCabina' ){
                                                $objTripJefeCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','8',$fechaProg,'',$arrayTRIP_id_cabina,'');
                                                shuffle($objTripJefeCabinaMotor);
                                                $TRIP_id_JefeCabina_nuevo = $objTripJefeCabinaMotor[0]["TRIP_id"];

                                                for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            
                                                    $objProgramacionRuta = $programacion->listarProgramacion($objProgramacion[$i]["ITI_fch"],'',$RUT_num_vuelo[$r]);

                                                    $ITI_id = $objProgramacionRuta[0]["ITI_id"];
                                                    $RUT_num_vuelo_mov = $objProgramacionRuta[0]["RUT_num_vuelo"];
                                                    $parts = explode('/',$objProgramacionRuta[0]["ITI_fch"]);
                                                    $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                                                    
                                                    $programacion->updateProgramacion($TRIP_id_JefeCabina_nuevo,$ITI_id,$ITI_TRIP_tipo);
                                                    $programacion->updateMovimientoTrip($TRIP_id_JefeCabina_nuevo,$ITI_fch,$RUT_num_vuelo_mov);
                                                    $motor->insertMotorCambio($ITI_id,$ITI_fch,$RUT_num_vuelo_mov,$TRIP_id,$TRIP_id_JefeCabina_nuevo);
                                                }
                                            }
                                            if( $ITI_TRIP_tipo == 'TripCabina1' ){
                                                $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id_cabina,'');
                                                shuffle($objTripCabinaMotor);
                                                $TRIP_id_Cabina1_nuevo = $objTripCabinaMotor[1]["TRIP_id"];

                                                for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            
                                                    $objProgramacionRuta = $programacion->listarProgramacion($objProgramacion[$i]["ITI_fch"],'',$RUT_num_vuelo[$r]);

                                                    $ITI_id = $objProgramacionRuta[0]["ITI_id"];
                                                    $RUT_num_vuelo_mov = $objProgramacionRuta[0]["RUT_num_vuelo"];
                                                    $parts = explode('/',$objProgramacionRuta[0]["ITI_fch"]);
                                                    $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

                                                    $programacion->updateProgramacion($TRIP_id_Cabina1_nuevo,$ITI_id,$ITI_TRIP_tipo);
                                                    $programacion->updateMovimientoTrip($TRIP_id_Cabina1_nuevo,$ITI_fch,$RUT_num_vuelo_mov);
                                                    $motor->insertMotorCambio($ITI_id,$ITI_fch,$RUT_num_vuelo_mov,$TRIP_id,$TRIP_id_Cabina1_nuevo);
                                                }
                                            }
                                            if( $ITI_TRIP_tipo == 'TripCabina2' ){
                                                $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id_cabina,'');
                                                shuffle($objTripCabinaMotor);
                                                $TRIP_id_Cabina2_nuevo = $objTripCabinaMotor[2]["TRIP_id"];

                                                for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            
                                                    $objProgramacionRuta = $programacion->listarProgramacion($objProgramacion[$i]["ITI_fch"],'',$RUT_num_vuelo[$r]);

                                                    $ITI_id = $objProgramacionRuta[0]["ITI_id"];
                                                    $RUT_num_vuelo_mov = $objProgramacionRuta[0]["RUT_num_vuelo"];
                                                    $parts = explode('/',$objProgramacionRuta[0]["ITI_fch"]);
                                                    $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                                                    
                                                    $programacion->updateProgramacion($TRIP_id_Cabina2_nuevo,$ITI_id,$ITI_TRIP_tipo);
                                                    $programacion->updateMovimientoTrip($TRIP_id_Cabina2_nuevo,$ITI_fch,$RUT_num_vuelo_mov);
                                                    $motor->insertMotorCambio($ITI_id,$ITI_fch,$RUT_num_vuelo_mov,$TRIP_id,$TRIP_id_Cabina2_nuevo);
                                                }
                                            }
                                            if( $ITI_TRIP_tipo == 'TripCabina3' ){
                                                $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id_cabina,'');
                                                shuffle($objTripCabinaMotor);
                                                $TRIP_id_Cabina3_nuevo = $objTripCabinaMotor[3]["TRIP_id"];

                                                for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            
                                                    $objProgramacionRuta = $programacion->listarProgramacion($objProgramacion[$i]["ITI_fch"],'',$RUT_num_vuelo[$r]);

                                                    $ITI_id = $objProgramacionRuta[0]["ITI_id"];
                                                    $RUT_num_vuelo_mov = $objProgramacionRuta[0]["RUT_num_vuelo"];
                                                    $parts = explode('/',$objProgramacionRuta[0]["ITI_fch"]);
                                                    $ITI_fch = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

                                                    $programacion->updateProgramacion($TRIP_id_Cabina3_nuevo,$ITI_id,$ITI_TRIP_tipo);
                                                    $programacion->updateMovimientoTrip($TRIP_id_Cabina3_nuevo,$ITI_fch,$RUT_num_vuelo_mov);
                                                    $motor->insertMotorCambio($ITI_id,$ITI_fch,$RUT_num_vuelo_mov,$TRIP_id,$TRIP_id_Cabina3_nuevo);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                $motor->insertEstadoFlag('0','OBSERVAR'); 
                $motor->insertMotorLog('FIN',date("Ymd H:i:s"));
            
                //$detalle->updateModulo('[SPV_APTOMED]','0');
                //$detalle->updateModulo('[SPV_CURSO]','0');
                //$detalle->updateModulo('[SPV_CHEQUEO]','0');
                //$detalle->updateModulo('[SPV_SIMULADOR]','0');
                //$detalle->updateModulo('[SPV_AUSENCIA]','0');
                //$detalle->updateModulo('[SPV_ITINERARIO]','0');
                //$detalle->updateModulo('[SPV_REPROGRAMACION]','0');
            }
            
            
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }*/
    
    public function programacionAutomaticaMensual(){
        try{
            $programacion = new Programacion_model();
            $motor = new Motor_model();
            $detalle = new Detalle_model();
                                        
            $motor->insertMotorLog('INICIO',date("Ymd H:i:s"));
            $motor->insertEstadoFlag('1','EDICION');
            
            date_default_timezone_set('America/Lima');
            $fechaActual = new DateTime(date("Y-m-d"));
            
            $fechaActual->add(new DateInterval('P1M'));
            $fechaProgramar = $fechaActual->format('Y-m-d');
            $parts = explode('-',$fechaProgramar);
            $mesProgramar = $parts[1];
            
            $firtDay = $programacion->data_first_month_day($mesProgramar);
            $lastDay = $programacion->data_last_month_day($mesProgramar);
            
            if( $fechaHoy > $firtDay ){
                $firtDay = $fechaHoy;
            }
            
            for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
                $fechaProg = $q;
                $objProgramacion = $programacion->listarRutaCompleta($fechaProg,'');
                
                // si Existe Itinerario hago este proceso, q hace match de progautomatica a Itinerario
                $itinerario = new Itinerario_model();
                $parts = explode('-',$fechaProg);
                $ITI_fchini = $parts[2] . '/' . $parts[1] . '/' . $parts[0];
                $objItinerario = $itinerario->listarItinerario($ITI_fchini,$ITI_fchini,'');
                if( count($objItinerario) > 0 ){
                    foreach ($objItinerario as $listaItinerario){
                        
                        $RUT_campoAltura = $listaItinerario["RUT_campoAltura"];
                        $ITI_id = $listaItinerario["ITI_id"];
                        
                        $parts = explode('/',$listaItinerario["ITI_fch"]);
                        $fechaProg = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                        
                        $RUT_num_vuelo = array($listaItinerario["RUT_num_vuelo"]);
                        
                        $this->recorrerMotorAutomatico($RUT_num_vuelo,$RUT_campoAltura,$fechaProg,$ITI_id);
                    }
                }
                // Si no existe Itinerario registrado, empiezo de Cero hacer la Programación automatica.
                else {
                    //$fchProgramada = $programacion->verificarFchProgramada($fechaProg);

                    //Si no hay programación por del día se procede a realizar la Prog. Automatica.                    
                    //if( count($fchProgramada) <= 0 ){
                    if( count($objProgramacion) > 0 ){
                        $m = 0;
                        for($i = $m; $i < count($objProgramacion); $i++){
                            $RUT_campoAltura = $objProgramacion[$i]["RUT_campoAltura"];
                            
                            $RUT_relacion_i = $objProgramacion[$i]["RUT_relacion"];
                            $RUT_orden_i = $objProgramacion[$i]["RUT_orden"];
                            $RUT_pairing_i = $objProgramacion[$i]["RUT_pairing"];
                            $RUT_num_vuelo_i = $objProgramacion[$i]["RUT_num_vuelo"];

                            $RUT_num_vuelo_ini = array();
                            $RUT_num_vuelo_fin = array();
                            $RUT_num_vuelo = array();
                            
                            for($j = ($m+1); $j < count($objProgramacion); $j++){

                                $RUT_relacion_f = $objProgramacion[$j]["RUT_relacion"];
                                $RUT_orden_f = $objProgramacion[$j]["RUT_orden"];
                                $RUT_pairing_f = $objProgramacion[$j]["RUT_pairing"];
                                $RUT_num_vuelo_f = $objProgramacion[$j]["RUT_num_vuelo"];

                                if($RUT_pairing_i == $RUT_pairing_f){
                                    $RUT_num_vuelo = array();
                                    $RUT_num_vuelo_ini = array_merge($RUT_num_vuelo_ini,array($objProgramacion[$i]["RUT_num_vuelo"]));
                                    $RUT_num_vuelo_fin = array_merge($RUT_num_vuelo_fin,array($objProgramacion[$j]["RUT_num_vuelo"]));
                                    $RUT_num_vuelo = array_merge($RUT_num_vuelo_ini,$RUT_num_vuelo_fin);
                                    $RUT_num_vuelo = array_unique($RUT_num_vuelo);
                                    $RUT_num_vuelo = array_values($RUT_num_vuelo);
                                    $m++;
                                }
                            }
                            $i = $m;

                            if( count($RUT_num_vuelo) > 0 ){
                                $this->recorrerMotorAutomatico($RUT_num_vuelo,$RUT_campoAltura,$fechaProg,$ITI_id);
                            } else {
                                echo "Paul";
                            }
                        }
                    }
                    else {
                        echo "Alexander.</br>";
                    }
                    //}
                    /*else {
                        $objListaModulo = $detalle->listarModulo();
                        foreach($objListaModulo as $listaListaModulo){
                            if($listaListaModulo["MOD_estado"] == '1'){
                                $objModulo = true;
                                break;
                            }
                        }
                        //Si existen cambios de Condicionales se debe reprogramar
                        if($objModulo){
                            ///Esta tarea ya no será realizada a pedido del usuario
                        }
                        // Si no hay cambios el proceso esta culminado y realizado
                        else {
                            echo "procesado";
                            break;
                        }
                        
                        $motor->insertEstadoFlag('0','OBSERVAR'); 
                        $motor->insertMotorLog('FIN',date("Ymd H:i:s"));

                        $detalle->updateModulo('[SPV_APTOMED]','0');
                        $detalle->updateModulo('[SPV_CURSO]','0');
                        $detalle->updateModulo('[SPV_CHEQUEO]','0');
                        $detalle->updateModulo('[SPV_SIMULADOR]','0');
                        $detalle->updateModulo('[SPV_AUSENCIA]','0');
                        $detalle->updateModulo('[SPV_ITINERARIO]','0');
                        $detalle->updateModulo('[SPV_REPROGRAMACION]','0');
                    }*/
                }
            }
            //eliminar mes posterior y evitar registros basura
            date_default_timezone_set('America/Lima');
            $fechaMesSgte = new DateTime(date("Y-m-d"));
            $fechaMesSgte->add(new DateInterval('P2M'));
            $fechaProgramarSgte = $fechaMesSgte->format('Y-m-d');
            $parts = explode('-',$fechaProgramarSgte);
            $mesProgramar = $parts[1];
            $firtDaySgte = $programacion->data_first_month_day($mesProgramar);
            $lastDaySgte = $programacion->data_last_month_day($mesProgramar);

            $programacion->deleteProgramacionMesSgte($firtDaySgte,$lastDaySgte);
            
            $motor->insertEstadoFlag('0','OBSERVAR'); 
            $motor->insertMotorLog('FIN',date("Ymd H:i:s"));            
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    } 
    
    public function recorrerMotorAutomatico($RUT_num_vuelo,$RUT_campoAltura,$fechaProg,$ITI_id){
        try{                
            $programacion = new Programacion_model();
            $motor = new Motor_model();
            $detalle = new Detalle_model();
            
            /* ----- Tipo de Tripulación ----- */
            //Para Trip. de Vuelo Normal
            $TIPTRIPU_id_Vuelo = "1";
            //Para Trip. de Cabina Minima
            $TIPTRIPU_id_CabinaMinima = "2";
            //Para Trip. de Cabina Reforzada
            $TIPTRIPU_id_CabinaReforzada = "3";

            // ----- Validaciones de Normatividad ----- 
            //Trip. de Vuelo: Block Time
            $objReglasBTVuelo = $detalle->listarBlockTimexTripulacion($TIPTRIPU_id_Vuelo);
            //Trip. de Vuelo: Dutty Time
            $objReglasDTVuelo = $detalle->listarDuttyTimexTripulacion($TIPTRIPU_id_Vuelo);
            //Trip. de Cabina: Block Time
            $objReglasBTCabina = $detalle->listarBlockTimexTripulacion($TIPTRIPU_id_CabinaMinima);
            //Trip. de Cabina: Dutty Time
            $objReglasDTCabina = $detalle->listarDuttyTimexTripulacion($TIPTRIPU_id_CabinaMinima);
            
            // ---------------- Personas que Pernoctan
            $ITI_fchAnt = strtotime ( '-1 day' , strtotime ( $fechaProg ) ) ;
            $ITI_fchAnt = date ( 'Y-m-d' , $ITI_fchAnt );
            $TRIP_id_pernocta = "";
            
            $objRutaPernocte = $programacion->listarRutaPernocte();                    
            for($r = 0; $r < count($RUT_num_vuelo); $r++){
                $RUT_num_vuelo_mov = $RUT_num_vuelo[$r];
                foreach( $objRutaPernocte as $listaRutaPernocte ){
                    if( $RUT_num_vuelo_mov == $listaRutaPernocte["RUT_num_vuelo"] ){
                        $tripulacionPernocta = $programacion->listarProgramacionxTripulante($RUT_num_vuelo_mov,$ITI_fchAnt);
                        foreach($tripulacionPernocta as $listaPernocta){
                            $TRIP_id_pernocta .= "'".$listaPernocta["TRIP_id"]."',";
                        }
                    }
                }
            }
            
            // -------------------------------------------------------------------------------- Para Tripulantes de Vuelo ----------------------------------------
            $objMoviTripVueloMotor = $motor->listarTripulantexMovimiento('1','',$RUT_num_vuelo,$fechaProg);
            // ----- Validar Trip. Vuelo - Tiempo Total de BT -----
            $arrayTRIP_id_vuelo = "";
            $arrayTRIP_id_1 = "";
            $arrayTRIP_id_2 = "";
            $TRIP_id_NOaltura = "";
            foreach($objMoviTripVueloMotor as $listaTripVueloMotor){
                $TimeBT = array();
                foreach ($objReglasBTVuelo as $listaReglasBT){
                    $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";
                    if(isset($TimeBT[$campo])){
                        $TimeBT[$campo] = $TimeBT[$campo] + $listaTripVueloMotor["".$campo.""];
                    }
                    else{
                        $TimeBT = array_merge($TimeBT,array($campo =>$listaTripVueloMotor["".$campo.""]));
                    }
                }
                foreach ($objReglasBTVuelo as $listaReglasBT){
                    $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";
                    $llavesBT = array_keys($TimeBT);
                    foreach($llavesBT as $listaLlavesBT){
                        if($listaLlavesBT == $campo){
                            if( $TimeBT["".$listaLlavesBT.""] >= ((($listaReglasBT["BT_horaBT"])*60)-10) ){
                                $arrayTRIP_id_1 .= "'".$listaTripVueloMotor["TRIP_id"]."',";
                            }
                        }
                    }
                }
                
                // ----- Validar Trip. Vuelo - Tiempo Total de DT -----
                $TimeDT = array();
                foreach ($objReglasDTVuelo as $listaReglasDT){
                    $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                    $TimeDT[$campo] = $listaTripVueloMotor["".$campo.""];
                }
                foreach ($objReglasDTVuelo as $listaReglasDT){
                    $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                    $llavesDT = array_keys($TimeDT);
                    foreach($llavesDT as $listaLlavesDT){
                        if($listaLlavesDT == $campo){
                            if( $TimeDT["".$listaLlavesDT.""] >= ((($listaReglasDT["DT_horaDT"])*60)-10) ){
                                $arrayTRIP_id_2 .= "'".$listaTripVueloMotor["TRIP_id"]."',";
                            }
                        }
                    }
                }
                
                $TRIP_edad = $listaTripVueloMotor["TRIP_edad"];
                if( $RUT_campoAltura == "Si" ){
                    if( $TRIP_edad > "65" ){
                        $TRIP_id_NOaltura = "'".$listaTripVueloMotor["TRIP_id"]."',";
                    }
                }
            }
            $arrayTRIP_id_vuelo = $TRIP_id_NOaltura."".$TRIP_id_pernocta."".$arrayTRIP_id_1."".$arrayTRIP_id_2;
            $arrayTRIP_id_vuelo = substr($arrayTRIP_id_vuelo,0, -1);
                        
            // -------------------------------------------------------------------------------- Para Tripulantes de Cabina ----------------------------------------
            $objMoviTripCabinaMotor = $motor->listarTripulantexMovimiento('2','',$RUT_num_vuelo,$fechaProg);
            // ----- Validar Trip. Cabina - Tiempo Total de BT -----
            $arrayTRIP_id_cabina = "";
            $arrayTRIP_id_3 = "";
            $arrayTRIP_id_4 = "";
            foreach($objMoviTripCabinaMotor as $listaTripCabinaMotor){
                $TimeBT = array();
                foreach ($objReglasBTCabina as $listaReglasBT){
                    $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";
                    if(isset($TimeBT[$campo])){
                        $TimeBT[$campo] = $TimeBT[$campo] + $listaTripCabinaMotor["".$campo.""];
                    }
                    else{
                        $TimeBT = array_merge($TimeBT,array($campo =>$listaTripCabinaMotor["".$campo.""]));
                    }
                }
                foreach ($objReglasBTCabina as $listaReglasBT){
                    $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";
                    $llavesBT = array_keys($TimeBT);
                    foreach($llavesBT as $listaLlavesBT){
                        if($listaLlavesBT == $campo){
                            if($TimeBT["".$listaLlavesBT.""] >= ((($listaReglasBT["BT_horaBT"])*60)-10)){
                                $arrayTRIP_id_3 .= "'".$listaTripCabinaMotor["TRIP_id"]."',";
                            }
                        }
                    }
                }
                
                // ----- Validar Trip. Vuelo - Tiempo Total de DT -----
                $TimeDT = array();
                foreach ($objReglasDTCabina as $listaReglasDT){
                    //foreach($objMoviTripCabinaMotor as $listaTripCabinaMotor){
                        $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                        $TimeDT[$campo] = $listaTripCabinaMotor["".$campo.""];
                    //}

                }
                foreach ($objReglasDTCabina as $listaReglasDT){
                    $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                    $llavesDT = array_keys($TimeDT);
                    foreach($llavesDT as $listaLlavesDT){
                        if($listaLlavesDT == $campo){
                            if($TimeDT["".$listaLlavesDT.""] >= ((($listaReglasDT["DT_horaDT"])*60)-10)){
                                $arrayTRIP_id_4 .= "'".$listaTripCabinaMotor["TRIP_id"]."',";
                            }
                        }
                    }
                }
                
                $TRIP_edad = $listaTripCabinaMotor["TRIP_edad"];
                if( $RUT_campoAltura == "Si" ){
                    if( $TRIP_edad > "65" ){
                        $TRIP_id_NOaltura = "'".$listaTripCabinaMotor["TRIP_id"]."',";
                    }
                }
            }
            $arrayTRIP_id_cabina = $TRIP_id_NOaltura."".$TRIP_id_pernocta."".$arrayTRIP_id_3."".$arrayTRIP_id_4;
            $arrayTRIP_id_cabina = substr($arrayTRIP_id_cabina,0, -1);
                        
            //------------------- Lista de Tripulantes de Vuelo: Piloto -------------------
            $objTripVueloPiloto = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id_vuelo,'','');
            
            shuffle($objTripVueloPiloto);
            $TRIP_id_Piloto = $objTripVueloPiloto[0]["TRIP_id"];
            $TRIP_edad_Piloto = $objTripVueloPiloto[0]["TRIP_edad"];

            //------------------- Lista de Tripulantes de Vuelo: Copiloto -------------------
            $objTripVueloCopiloto = $motor->listarTripulanteCondicionalesBasicas('1','2',$fechaProg,$TRIP_id_Piloto,$arrayTRIP_id_vuelo,'','');
            shuffle($objTripVueloCopiloto);
            $TRIP_id_Copiloto = $objTripVueloCopiloto[0]["TRIP_id"];
            $TRIP_edad_Copiloto = $objTripVueloCopiloto[0]["TRIP_edad"];
            
            while ( $TRIP_edad_Piloto > 65 && $TRIP_edad_Copiloto > 65 ){
                //------------------- Lista de Tripulantes de Vuelo: Piloto -------------------
                $objTripVueloPiloto = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id_vuelo,'','');
                shuffle($objTripVueloPiloto);
                $TRIP_id_Piloto = $objTripVueloPiloto[0]["TRIP_id"];
                $TRIP_edad_Piloto = $objTripVueloPiloto[0]["TRIP_edad"];
                
                //------------------- Lista de Tripulantes de Vuelo: Copiloto -------------------
                $objTripVueloCopiloto = $motor->listarTripulanteCondicionalesBasicas('1','2',$fechaProg,$TRIP_id_Piloto,$arrayTRIP_id_vuelo,'','');
                shuffle($objTripVueloCopiloto);
                $TRIP_id_Copiloto = $objTripVueloCopiloto[0]["TRIP_id"];
                $TRIP_edad_Copiloto = $objTripVueloCopiloto[0]["TRIP_edad"];
            }

            //------------------- Para Tripulantes de JefeCabina -------------------
            $objTripJefeCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','8',$fechaProg,'',$arrayTRIP_id_cabina,'','');
            shuffle($objTripJefeCabinaMotor);
            $TRIP_id_JefeCabina = $objTripJefeCabinaMotor[0]["TRIP_id"];

            //------------------- Para Tripulantes de Cabina -------------------
            $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id_cabina,'','');
            shuffle($objTripCabinaMotor);
            $TRIP_id_Cabina1 = $objTripCabinaMotor[0]["TRIP_id"];
            $TRIP_id_Cabina2 = $objTripCabinaMotor[1]["TRIP_id"];
            
            $condicional = true;
            $validacion4x2 = false;
            $validacionNx2 = false;
            $conteo = 0;
            
            while( $condicional == true ){
                $ITI_fch = $fechaProg;
                for($p = 0; $p < 6; $p++){
                    $ITI_fchDisp = strtotime ( '+'.$p.' day' , strtotime ( $ITI_fch ) ) ;
                    $ITI_fchDisp = date ( 'Y-m-d' , $ITI_fchDisp );

                    if( $p == 4 || $p == 5 ){
                        $disponibilidadPiloto = $motor->listarTripulanteCondicionalesBasicas_x_Tripulante($ITI_fchDisp,$TRIP_id_Piloto);
                    } else {
                        $disponibilidadPiloto = $motor->listarTripulanteCondicionalesBasicas_x_TripulanteVuelo($ITI_fchDisp,$TRIP_id_Piloto);
                    }

                    if( count($disponibilidadPiloto) == 0 ) {
                        $condicional = true;
                        
                        shuffle($objTripVueloPiloto);
                        $TRIP_id_Piloto = $objTripVueloPiloto[0]["TRIP_id"];
                        $TRIP_edad_Piloto = $objTripVueloPiloto[0]["TRIP_edad"];
                        $conteo++;                        
                        
                        if( $conteo == 60 ){
                            $condicional = false;
                            $validacion4x2 = false;
                            break;
                            break;
                        }
                        
                        /*if( $conteo == 60 ){
                            //Nx2
                            $objTripVueloPilotoNx2 = $motor->listarTripulanteCondicionalesBasicas('1','1',$fechaProg,'',$arrayTRIP_id_vuelo,'','Nx2');
                            
                            if( count($objTripVueloPilotoNx2) > 0 ){
                                //Nx2
                                shuffle($objTripVueloPilotoNx2);
                                $TRIP_id_Piloto = $objTripVueloPilotoNx2[0]["TRIP_id"];
                                $TRIP_edad_Piloto = $objTripVueloPilotoNx2[0]["TRIP_edad"];

                                $programacion->deleteLibre($fechaProg,$TRIP_id_Piloto);

                                $validacion4x2 = false;
                                $validacionNx2 = true;
                                $condicional = false;
                            }
                        }*/                     
                    } else {
                        //4x2
                        $validacion4x2 = true;
                        $condicional = false;
                    }
                }
            }
            
            $conteoRuta = 0;
            if($validacion4x2){
                $ITI_fch = $fechaProg;
                
                for($t = 0; $t < 6; $t++){
                    $ITI_fchDispRuta = strtotime ( '+'.$t.' day' , strtotime ( $ITI_fch ) ) ;
                    $ITI_fchDispRuta = date ( 'Y-m-d' , $ITI_fchDispRuta );
                                        
                    if( $conteoRuta > 0){
                        $objRutasCompleto = $programacion->listarRutaCompletaRelacion($ITI_fchDispRuta);
                        shuffle($objRutasCompleto);
                        $RUT_num_vuelo_Aleatorio = $objRutasCompleto[0]["RUT_num_vuelo"];
                        
                        $objRutaPernocte = $programacion->listarRutaPernocte();
                        foreach( $objRutaPernocte as $listaRutaPernocte ){
                            if( $RUT_num_vuelo_mov == $listaRutaPernocte["RUT_num_vuelo"] ){
                                $objSalidaRutaPernocte = $programacion->listarsalidaRutaPernocte($RUT_num_vuelo_mov,$ITI_fchDispRuta);
                                
                                foreach( $objSalidaRutaPernocte as $listaSalidaRutaPernocte ){
                                    $RUT_num_vuelo_Aleatorio = $listaSalidaRutaPernocte["RUT_num_vuelo"];
                                    $RUT_num_vuelo = $programacion->listarRutaCompleta($ITI_fchDispRuta,$RUT_num_vuelo_Aleatorio);
                                    if( count($RUT_num_vuelo) > 0){
                                        break;
                                        break;
                                    }
                                }
                            } else {
                                $RUT_num_vuelo = $programacion->listarRutaCompleta($ITI_fchDispRuta,$RUT_num_vuelo_Aleatorio);
                            }
                        }
                    }                    
                    
                    if( $t == 4 || $t == 5 ){
                        $disponibilidadDetalle = $motor->listarTripulanteCondicionalesBasicas_x_Tripulante($ITI_fchDispRuta,$TRIP_id_Piloto);
                        if( count($disponibilidadDetalle) > 0 ){
                            $programacion->insertLibreTrip($TRIP_id_Piloto,$ITI_fchDispRuta,'1');
                        }
                    } else {
                        for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            if( $conteoRuta > 0){
                                $RUT_num_vuelo_mov = $RUT_num_vuelo[$r]["RUT_num_vuelo"];
                            } else {
                                $RUT_num_vuelo_mov = $RUT_num_vuelo[$r];
                            }
                                                        
                            $disponibilidadDetalle = $motor->listarTripulanteCondicionalesBasicas_x_Tripulante($ITI_fchDispRuta,$TRIP_id_Piloto);
                            if( count($disponibilidadDetalle) > 0 ){
                                if( (($RUT_num_vuelo_mov == '212' || $RUT_num_vuelo_mov == '210' || $RUT_num_vuelo_mov == '211') && $t < 3 ) || ($RUT_num_vuelo_mov != '212' && $RUT_num_vuelo_mov != '210' && $RUT_num_vuelo_mov != '211') ){

                                    $TRIP_adicional = false;
                                    $RUT_AvionTipico = $programacion->listarRutaAvionTipico('400');
                                    foreach($RUT_AvionTipico as $listaRUT_AvionTipico){
                                        if( $listaRUT_AvionTipico["RUT_num_vuelo"] == $RUT_num_vuelo_mov ){
                                            $TRIP_adicional = true;
                                            $TRIP_id_Cabina3 = $objTripCabinaMotor[2]["TRIP_id"];
                                        }
                                    }

                                    /*$RUR_salidaPernocte = $programacion->listarsalidaRutaPernocte();
                                    foreach( $RUR_salidaPernocte as $RUR_salidaPernocte ){
                                        if( $RUT_num_vuelo_mov == $RUR_salidaPernocte["RUT_num_vuelo"] ){
                                            $tripulacionPernocta = $programacion->listarProgramacionxTripulante($RUR_salidaPernocte["RUT_salidaPernocte"],$ITI_fchAnt);
                                            foreach($tripulacionPernocta as $listaPernocta){
                                                $ITI_TRIP_tipo = $listaPernocta["ITI_TRIP_tipo"];
                                                if( $ITI_TRIP_tipo == 'Piloto' ){
                                                    $TRIP_id_Piloto = $listaPernocta["TRIP_id"];
                                                }
                                                if( $ITI_TRIP_tipo == 'Copiloto' ){
                                                    $TRIP_id_Copiloto = $listaPernocta["TRIP_id"];
                                                }
                                                if( $ITI_TRIP_tipo == 'JefeCabina' ){
                                                    $TRIP_id_JefeCabina = $listaPernocta["TRIP_id"];
                                                }
                                                if( $ITI_TRIP_tipo == 'TripCabina1' ){
                                                    $TRIP_id_Cabina1 = $listaPernocta["TRIP_id"];
                                                }
                                                if( $ITI_TRIP_tipo == 'TripCabina2' ){
                                                    $TRIP_id_Cabina2 = $listaPernocta["TRIP_id"];
                                                }
                                            }
                                        }
                                    }*/

                                    $objProgramacionRuta = $programacion->listarRutaConHorario($ITI_fchDispRuta,$RUT_num_vuelo_mov);
                                    $objCTFT = $detalle->listarCTFT();
                                    foreach($objCTFT as $listaCTFT){
                                        $CT_FT_id = $listaCTFT["CT_FT_id"];

                                        if($objProgramacionRuta[0]["RUT_hora_salida"] >= $listaCTFT["CT_FT_hora_ini"] && $objProgramacionRuta[0]["RUT_hora_salida"] <= $listaCTFT["CT_FT_hora_fin"]){
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_Piloto,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            /*$programacion->insertCoTeFiTaTrip($TRIP_id_Copiloto,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_JefeCabina,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina1,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina2,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);

                                            if($TRIP_adicional){
                                                $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina3,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                            }*/
                                        }

                                    }
                                    if( $ITI_id == "" ){
                                        $ITI_id = 'NULL';
                                    }

                                    $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fchDispRuta,$TRIP_id_Piloto,'1','Piloto');
                                    $programacion->insertMovimientoTrip($TRIP_id_Piloto,$ITI_fchDispRuta,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');
                                    /*$programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fch,$TRIP_id_Copiloto,'1','Copiloto');
                                    $programacion->insertMovimientoTrip($TRIP_id_Copiloto,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fch,$TRIP_id_JefeCabina,'2','JefeCabina');
                                    $programacion->insertMovimientoTrip($TRIP_id_JefeCabina,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fch,$TRIP_id_Cabina1,'2','TripCabina1');
                                    $programacion->insertMovimientoTrip($TRIP_id_Cabina1,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fch,$TRIP_id_Cabina2,'2','TripCabina2');
                                    $programacion->insertMovimientoTrip($TRIP_id_Cabina2,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');

                                    if($TRIP_adicional){
                                        $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fch,$TRIP_id_Cabina3,'2','TripCabina3');
                                        $programacion->insertMovimientoTrip($TRIP_id_Cabina3,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');
                            }*/

                                }
                            }
                        }
                        
                    }
                    $conteoRuta++;
                }
            }
            
            /*if($validacionNx2){
                for($w = 0; $w < 3; $w++){
                    $ITI_fchDispRuta = strtotime ( '+'.$w.' day' , strtotime ( $ITI_fch ) ) ;
                    $ITI_fchDispRuta = date ( 'Y-m-d' , $ITI_fchDispRuta );
                    
                    if( $w == 0 ){
                        for($r = 0; $r < count($RUT_num_vuelo); $r++){
                            $RUT_num_vuelo_mov = $RUT_num_vuelo[$r];
                            if( $ITI_id == "" ){
                                $ITI_id = 'NULL';
                            }
                            
                            if( (($RUT_num_vuelo_mov == '212' || $RUT_num_vuelo_mov == '210' || $RUT_num_vuelo_mov == '211') && $t < 3 ) || ($RUT_num_vuelo_mov != '212' && $RUT_num_vuelo_mov != '210' && $RUT_num_vuelo_mov != '211') ){
                                $TRIP_adicional = false;
                                $RUT_AvionTipico = $programacion->listarRutaAvionTipico('400');
                                foreach($RUT_AvionTipico as $listaRUT_AvionTipico){
                                    if( $listaRUT_AvionTipico["RUT_num_vuelo"] == $RUT_num_vuelo_mov ){
                                        $TRIP_adicional = true;
                                        $TRIP_id_Cabina3 = $objTripCabinaMotor[2]["TRIP_id"];
                                    }
                                }

                                $objProgramacionRuta = $programacion->listarRutaConHorario($ITI_fchDispRuta,$RUT_num_vuelo_mov);
                                $objCTFT = $detalle->listarCTFT();
                                foreach($objCTFT as $listaCTFT){
                                    $CT_FT_id = $listaCTFT["CT_FT_id"];

                                    if($objProgramacionRuta[0]["RUT_hora_salida"] >= $listaCTFT["CT_FT_hora_ini"] && $objProgramacionRuta[0]["RUT_hora_salida"] <= $listaCTFT["CT_FT_hora_fin"]){
                                        $programacion->insertCoTeFiTaTrip($TRIP_id_Piloto,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                                    }

                                }

                                $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fchDispRuta,$TRIP_id_Piloto,'1','Piloto');
                                $programacion->insertMovimientoTrip($TRIP_id_Piloto,$ITI_fchDispRuta,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');
                            }
                        }
                    }
                    if( $w == 2 ){
                        $programacion->insertLibreTrip($TRIP_id_Piloto,$ITI_fchDispRuta,'1');
                    }
                }
            }*/
            
            $motor->insertEstadoFlag('0','OBSERVAR');
            $motor->insertMotorLog('FIN',date("Ymd H:i:s"));
            
            //$detalle->updateModulo('[SPV_APTOMED]','0');
            //$detalle->updateModulo('[SPV_CURSO]','0');
            //$detalle->updateModulo('[SPV_CHEQUEO]','0');
            //$detalle->updateModulo('[SPV_SIMULADOR]','0');
            //$detalle->updateModulo('[SPV_AUSENCIA]','0');
            //$detalle->updateModulo('[SPV_ITINERARIO]','0');
            //$detalle->updateModulo('[SPV_REPROGRAMACION]','0');
        }  catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function insertarTripxRutaxFch($RUT_num_vuelo,$fechaProg,$ITI_id){
        try{
            $programacion = new Programacion_model();
            $motor = new Motor_model();
            $detalle = new Detalle_model();
            
            /* ----- Tipo de Tripulación ----- */
            //Para Trip. de Vuelo Normal
            $TIPTRIPU_id_Vuelo = "1";
            //Para Trip. de Cabina Minima
            $TIPTRIPU_id_CabinaMinima = "2";
            //Para Trip. de Cabina Reforzada
            $TIPTRIPU_id_CabinaReforzada = "3";

            // ----- Validaciones de Normatividad ----- 
            //Trip. de Vuelo: Block Time
            $objReglasBTVuelo = $detalle->listarBlockTimexTripulacion($TIPTRIPU_id_Vuelo);
            //Trip. de Vuelo: Dutty Time
            $objReglasDTVuelo = $detalle->listarDuttyTimexTripulacion($TIPTRIPU_id_Vuelo);
            //Trip. de Cabina: Block Time
            $objReglasBTCabina = $detalle->listarBlockTimexTripulacion($TIPTRIPU_id_CabinaMinima);
            //Trip. de Cabina: Dutty Time
            $objReglasDTCabina = $detalle->listarDuttyTimexTripulacion($TIPTRIPU_id_CabinaMinima);
                                    
            // -------------------------------------------------------------------------------- Para Tripulantes de Cabina ----------------------------------------
            $objMoviTripCabinaMotor = $motor->listarTripulantexMovimiento('2','',$RUT_num_vuelo,$fechaProg);
            
            // ----- Validar Trip. Cabina - Tiempo Total de BT -----
            $arrayTRIP_id_cabina = "";
            $arrayTRIP_id_3 = "";
            $arrayTRIP_id_4 = "";
            foreach($objMoviTripCabinaMotor as $listaTripCabinaMotor){
                $TimeBT = array();
                foreach ($objReglasBTCabina as $listaReglasBT){
                    $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";
                    if(isset($TimeBT[$campo])){
                        $TimeBT[$campo] = $TimeBT[$campo] + $listaTripCabinaMotor["".$campo.""];
                    }
                    else{
                        $TimeBT = array_merge($TimeBT,array($campo =>$listaTripCabinaMotor["".$campo.""]));
                    }
                }
                foreach ($objReglasBTCabina as $listaReglasBT){
                    $campo = $listaReglasBT["BT_cantidad"].$listaReglasBT["BT_periodo"]."_BT";
                    $llavesBT = array_keys($TimeBT);
                    foreach($llavesBT as $listaLlavesBT){
                        if($listaLlavesBT == $campo){
                            if($TimeBT["".$listaLlavesBT.""] >= ((($listaReglasBT["BT_horaBT"])*60)-10)){
                                $arrayTRIP_id_3 .= "'".$listaTripCabinaMotor["TRIP_id"]."',";
                            }
                        }
                    }
                }
                
                // ----- Validar Trip. Vuelo - Tiempo Total de DT -----
                $TimeDT = array();
                foreach ($objReglasDTCabina as $listaReglasDT){
                    //foreach($objMoviTripCabinaMotor as $listaTripCabinaMotor){
                        $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                        $TimeDT[$campo] = $listaTripCabinaMotor["".$campo.""];
                    //}

                }
                foreach ($objReglasDTCabina as $listaReglasDT){
                    $campo = $listaReglasDT["DT_cantidad"].$listaReglasDT["DT_periodo"]."_DT";
                    $llavesDT = array_keys($TimeDT);
                    foreach($llavesDT as $listaLlavesDT){
                        if($listaLlavesDT == $campo){
                            if($TimeDT["".$listaLlavesDT.""] >= ((($listaReglasDT["DT_horaDT"])*60)-10)){
                                $arrayTRIP_id_4 .= "'".$listaTripCabinaMotor["TRIP_id"]."',";
                            }
                        }
                    }
                }
            }
            $arrayTRIP_id_cabina = $arrayTRIP_id_3."".$arrayTRIP_id_4;
            $arrayTRIP_id_cabina = substr($arrayTRIP_id_cabina,0, -1);
            
            //------------------- Para Tripulantes de Cabina -------------------
            $objTripCabinaMotor = $motor->listarTripulanteCondicionalesBasicas('2','5',$fechaProg,'',$arrayTRIP_id_cabina,'','');
            shuffle($objTripCabinaMotor);
            $TRIP_id_Cabina3 = $objTripCabinaMotor[0]["TRIP_id"];
            
            for($r = 0; $r < count($RUT_num_vuelo); $r++){

                $RUT_num_vuelo_mov = $RUT_num_vuelo[$r];
                $ITI_fch = $fechaProg;

                $objProgramacionRuta = $programacion->listarRutaConHorario($ITI_fch,$RUT_num_vuelo_mov);
                $objCTFT = $detalle->listarCTFT();
                foreach($objCTFT as $listaCTFT){
                    $CT_FT_id = $listaCTFT["CT_FT_id"];

                    if($objProgramacionRuta[0]["RUT_hora_salida"] >= $listaCTFT["CT_FT_hora_ini"] && $objProgramacionRuta[0]["RUT_hora_salida"] <= $listaCTFT["CT_FT_hora_fin"]){
                        $programacion->insertCoTeFiTaTrip($TRIP_id_Cabina3,$ITI_fch,$RUT_num_vuelo_mov,$CT_FT_id);
                    }
                }
                if( $ITI_id == "" ){
                    $ITI_id = 'NULL';
                }
                
                $programacion->insertProgramacion($ITI_id,$RUT_num_vuelo_mov,$ITI_fch,$TRIP_id_Cabina3,'2','TripCabina3');
                $programacion->insertMovimientoTrip($TRIP_id_Cabina3,$ITI_fch,$RUT_num_vuelo_mov,'','','','MINUTO','','','','MINUTO');
                
            }
        }  catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function verificarEstadoFlag(){
        try{
            $motor = new Motor_model();
            
            $objFlagMotor = $motor->verificarEstadoFlag();
            $objFlagMotor = $this->array_utf8_encode($objFlagMotor);
            
            if(!(isset($_SESSION["FLAG_estado"]))){
                $_SESSION["FLAG_estado"] = $objFlagMotor[0]["FLAG_estado"];
            }
            
            if($_SESSION["FLAG_estado"] != $objFlagMotor[0]["FLAG_estado"]){
                $_SESSION["FLAG_estado"] = $objFlagMotor[0]["FLAG_estado"];
                //unset($_SESSION["FLAG_estado"]);
            }
            
            header('Content-Type: application/json');
            echo json_encode($objFlagMotor);
            
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function verificarCambio(){
        try{            
            $detalle = new Detalle_model();
            $objModulo = false;
            $objListaModulo = $detalle->listarModulo();
            foreach($objListaModulo as $listaListaModulo){
                if($listaListaModulo["MOD_estado"] == '1'){
                    $objModulo = true;
                    break;
                }
            }            
            if($objModulo){
                $objCambio = "divCambio";
            }
            
            header('Content-Type: application/json');
            echo json_encode($objCambio);die();
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    public function insertEstadoFlag(){
        try{
            $motor = new Motor_model();
            $FLAG_estado = $_POST["TIP_trabajo"];
            
            if($FLAG_estado == '0'){
                $FLAG_descripion = 'OBSERVAR';
            } else if($FLAG_estado == '1'){
                $FLAG_descripion = 'REPROGRAMAR';
            }
            
            $motor->insertEstadoFlag($FLAG_estado,$FLAG_descripion);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>