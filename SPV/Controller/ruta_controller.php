<?php
if( !isset($_SESSION)){
	session_start();
}

	
class ruta extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar Resumen Ruta ---------------------------------*/
    public function listarResumenRuta(){
        try{
            unset($_SESSION["bRUT_num_vuelo"]);
            unset($_SESSION["bCIU_id_origen"]);
            unset($_SESSION["bCIU_id_destino"]);
            
            $ruta = new Ruta_model();
            $this->view->objResumenRuta = $ruta->listarResumenRuta();
            
            $detalle = new Detalle_model();
            $this->view->objCiudad = $detalle->listarCiudad();
            $this->view->objRuta = $detalle->listarRuta(date("Y-m-d"),'orden');
            
            $this->view->render('ruta');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Ruta ---------------------------------*/
    public function insertRuta(){
        try{
            $ruta = new Ruta_model();
            
            $RUT_num_vueloIDA = $_POST["RUT_num_vueloIDA"];
            $RUT_num_vueloVUELTA = $_POST["RUT_num_vueloVUELTA"];
            $CIU_id_origen = $_POST["CIU_id_origen"];
            $CIU_id_destino = $_POST["CIU_id_destino"];
            $RUT_estado = $_POST["RUT_estado"];
            $cantidadIDA = $_POST["cantidadIDA"];
            $cantidadVUELTA = $_POST["cantidadVUELTA"];
            
            $RUT_orden = $ruta->ordenCorrelativo();
            $RUT_ordenIDA = ($RUT_orden[0]["RUT_orden"]+10);
            $RUT_ordenVUELTA = ($RUT_orden[0]["RUT_orden"]+20);
            
            $RUT_relacion = $RUT_num_vueloIDA;
            $RUT_escala = "0";
            $RUT_primer_vuelo = "No";
            
            $RUT_num_vueloIDA = $ruta->insertRuta($RUT_num_vueloIDA,$RUT_ordenIDA,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_origen,$CIU_id_destino,$RUT_estado);
            $RUT_num_vueloVUELTA = $ruta->insertRuta($RUT_num_vueloVUELTA,$RUT_ordenVUELTA,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_destino,$CIU_id_origen,$RUT_estado);
            
            if( count($RUT_num_vueloIDA) >= 0 ){
                $this->view->RUT_num_vueloIDA = $RUT_num_vueloIDA;
                $this->view->RUT_num_vueloIDA = $this->array_utf8_encode($this->view->RUT_num_vueloIDA);
                header('Content-Type: application/json');
                echo json_encode($this->view->RUT_num_vueloIDA);
            } else {
                for($i = 1; $i <= $cantidadIDA;$i++){
                    $RUT_hora_salidaIDA = $_POST["RUT_hora_salidaIDA".$i];
                    $RUT_hora_llegadaIDA = $_POST["RUT_hora_llegadaIDA".$i];
                    $RUT_diaIDA = $_POST["RUT_diaIDA".$i];
                    $RUTDIA_estado = "1";

                    for($j = 0; $j < count($RUT_diaIDA);$j++){
                        $ruta->insertRutaxDia($RUT_num_vueloIDA,$RUT_diaIDA[$j],$RUT_hora_salidaIDA,$RUT_hora_llegadaIDA,$RUTDIA_estado);
                    }
                }

                for($i = 1; $i <= $cantidadVUELTA;$i++){
                    $RUT_hora_salidaVUELTA = $_POST["RUT_hora_salidaVUELTA".$i];
                    $RUT_hora_llegadaVUELTA = $_POST["RUT_hora_llegadaVUELTA".$i];
                    $RUT_diaVUELTA = $_POST["RUT_diaVUELTA".$i];
                    $RUTDIA_estado = "1";

                    for($j = 0; $j < count($RUT_diaVUELTA);$j++){
                        $ruta->insertRutaxDia($RUT_num_vueloVUELTA,$RUT_diaVUELTA[$j],$RUT_hora_salidaVUELTA,$RUT_hora_llegadaVUELTA,$RUTDIA_estado);
                    }
                }
            }
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar Det. Ruta (JSON) ---------------------------------*/
    public function listarDetRuta(){
        try{
            $ruta = new Ruta_model();
            $RUT_relacion = $_POST["RUT_relacion"];
            
            $this->view->objDetRuta = $ruta->listarDetRuta($RUT_relacion);
            $this->view->objDetRuta = $this->array_utf8_encode($this->view->objDetRuta);
            header('Content-Type: application/json');
            echo json_encode($this->view->objDetRuta);
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Ruta ---------------------------------*/
    public function updateRuta(){
        try{
            $ruta = new Ruta_model();
            
            $RUT_num_vueloIDAhidden = $_POST["RUT_num_vueloIDAhidden"];
            $RUT_num_vueloVUELTAhidden = $_POST["RUT_num_vueloVUELTAhidden"];
            
            $RUT_num_vueloIDA = $_POST["RUT_num_vueloIDA"];
            $RUT_num_vueloVUELTA = $_POST["RUT_num_vueloVUELTA"];
            $CIU_id_origen = $_POST["CIU_id_origen"];
            $CIU_id_destino = $_POST["CIU_id_destino"];
            $RUT_estado = $_POST["RUT_estado"];
            $cantidadIDA = $_POST["cantidadIDA"];
            $cantidadVUELTA = $_POST["cantidadVUELTA"];
            
            $RUT_ordenIDA = $_POST["RUT_ordenIDA"];
            $RUT_ordenVUELTA = $_POST["RUT_ordenVUELTA"];
            
            $RUT_relacion = $RUT_num_vueloIDA;
            $RUT_escala = "0";
            $RUT_primer_vuelo = "No";
            
            $ruta->updateRuta($RUT_num_vueloIDA,$RUT_ordenIDA,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_origen,$CIU_id_destino,$RUT_estado,$RUT_num_vueloIDAhidden);
            $ruta->updateRuta($RUT_num_vueloVUELTA,$RUT_ordenVUELTA,$RUT_relacion,$RUT_escala,$RUT_primer_vuelo,$CIU_id_origen,$CIU_id_destino,$RUT_estado,$RUT_num_vueloVUELTAhidden);
             
            for($i = 1; $i <= $cantidadIDA;$i++){
                $RUT_hora_salidaIDA = $_POST["RUT_hora_salidaIDA".$i];
                $RUT_hora_llegadaIDA = $_POST["RUT_hora_llegadaIDA".$i];
                $RUT_diaIDA = $_POST["RUT_diaIDA".$i];
                $RUTDIA_estado = "1";
                
                $ruta->deleteRutaxDia($RUT_num_vueloIDA);
                for($j = 0; $j < count($RUT_diaIDA);$j++){
                    $ruta->insertRutaxDia($RUT_num_vueloIDA,$RUT_diaIDA[$j],$RUT_hora_salidaIDA,$RUT_hora_llegadaIDA,$RUTDIA_estado);
                }
            }
            
            for($i = 1; $i <= $cantidadVUELTA;$i++){
                $RUT_hora_salidaVUELTA = $_POST["RUT_hora_salidaVUELTA".$i];
                $RUT_hora_llegadaVUELTA = $_POST["RUT_hora_llegadaVUELTA".$i];
                $RUT_diaVUELTA = $_POST["RUT_diaVUELTA".$i];
                $RUTDIA_estado = "1";
                
                $ruta->deleteRutaxDia($RUT_num_vueloVUELTA);
                for($j = 0; $j < count($RUT_diaVUELTA);$j++){
                    $ruta->insertRutaxDia($RUT_num_vueloVUELTA,$RUT_diaVUELTA[$j],$RUT_hora_salidaVUELTA,$RUT_hora_llegadaVUELTA,$RUTDIA_estado);
                }
            }
            
            echo "update";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Itinerario ---------------------------------*/
    public function buscarRuta(){
        try{
            $RUT_num_vuelo = $_POST["bRUT_num_vuelo"];
            $CIU_id_origen = $_POST["bCIU_id_origen"];
            $CIU_id_destino = $_POST["bCIU_id_destino"];
            
            $_SESSION["bRUT_num_vuelo"] = $RUT_num_vuelo;
            $_SESSION["bCIU_id_origen"] = $CIU_id_origen;
            $_SESSION["bCIU_id_destino"] = $CIU_id_destino;
            
            $ruta = new Ruta_model();
            
            if($RUT_num_vuelo == '' and $CIU_id_origen == '' and $CIU_id_destino == '' ){
                $this->model->Redirect(URLLOGICA."ruta/listarResumenRuta/");
            } else {
                $ruta = new Ruta_model();
                $this->view->objResumenRuta = $ruta->buscarResumenRuta($RUT_num_vuelo,$CIU_id_origen,$CIU_id_destino);

                $detalle = new Detalle_model();
                $this->view->objCiudad = $detalle->listarCiudad();
                $this->view->objRuta = $detalle->listarRuta(date("Y-m-d"),'orden');

                $this->view->render('ruta');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>