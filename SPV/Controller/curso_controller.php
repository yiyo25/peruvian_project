<?php
if( !isset($_SESSION)){
	session_start();
}
	
class curso extends Controller {
	function __construct(){
		parent::__construct();  //Llama al constructor de su padre
	}
	
    /*--------------------------------- Listar ResumenCurso  ---------------------------------*/
    public function listarResumenCurso(){
        try{
            unset($_SESSION["TIPTRIP_id"]);
            unset($_SESSION["TIPCUR_id"]);
            unset($_SESSION["PART_indicador"]);
            unset($_SESSION["TRIP_apellido"]);
            unset($_SESSION["TRIP_numlicencia"]);
            
            $curso = new Curso_model();
            $this->view->objResumenCurso = $curso->listarResumenCurso();
            $this->view->objResumenCursoMatriz = $curso->listarResumenCursoMatriz();
            
            $tripulante = new Tripulante_model();
            $this->view->objTripulanteInstructor = $tripulante->listarTripulante('','','','Si');
            $this->view->objTripulante = $tripulante->listarTripulante('','','','');
            
            $detalle = new Detalle_model();
            $this->view->objTipoTripulante = $detalle->listarTipoTrip();
            $this->view->objTipoCurso = $detalle->listarTipoCurso();
            
            $this->view->render('curso');
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Insertar Curso  ---------------------------------*/
    public function insertCurso(){
        try{
            $TIPCUR_id = $_POST["TIPCUR_id"];
            $parts = explode('/',$_POST["CUR_fchini"]);
            $CUR_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            $parts = explode('/',$_POST["CUR_fchfin"]);
            $CUR_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            $CUR_estado = $_POST["CUR_estado"];
            
            $curso = new Curso_model();
            $CUR_id = $curso->insertCurso($TIPCUR_id,$CUR_fchini,$CUR_fchfin,$CUR_estado);
            //echo $CUR_id;die();
            if(!(is_array($CUR_id))){
                $TRIP_id_i = $_POST["TRIP_id_i"];
                $curso->insertParticipante($TRIP_id_i,$CUR_id,'APROBADO','Instructor');

                $PART_indicador = $_POST["PART_indicador"];
                $cantidad = $_POST["cantidad"];

                for($i = 1; $i <= $cantidad; $i++){
                    $TRIP_id_a = $_POST["TRIP_id_a".$i];
                    $curso->insertParticipante($TRIP_id_a,$CUR_id,$PART_indicador,'Alumno');
                }
            }
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_CURSO]','1');
            
            $this->view->objCurso = $CUR_id;
            $this->view->objCurso = $this->array_utf8_encode($this->view->objCurso);
            header('Content-Type: application/json');
            echo json_encode($this->view->objCurso);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Listar CursoxidCurso (JSON)  ---------------------------------*/
    public function listarCurso($CUR_id){
        try{
            $CUR_id = $_POST["CUR_id"];
            $curso = new Curso_model();
            $this->view->objCurso = $curso->listarCurso($CUR_id,'');
            $this->view->objCurso = $this->array_utf8_encode($this->view->objCurso);
            
            header('Content-Type: application/json');
            echo json_encode($this->view->objCurso);
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Modificar Curso  ---------------------------------*/
    public function updatecurso(){
        try{
            $CUR_id = $_POST["CUR_id"];
            $TIPCUR_id = $_POST["TIPCUR_id"];
            $parts = explode('/',$_POST["CUR_fchini"]);
            $CUR_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            $parts = explode('/',$_POST["CUR_fchfin"]);
            $CUR_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            $CUR_estado = $_POST["CUR_estado"];
            
            if($_POST["CUR_fchinforme"] == ""){
                $CUR_fchinforme = "NULL";
            } else {
                $parts = explode('/',$_POST["CUR_fchinforme"]);
                $CUR_fchinforme = "'" . $parts[2] . '-' . $parts[1] . '-' . $parts[0] . "'";
            }
            
            $curso = new Curso_model();
            $Log = new Log_model();
            
            $DetCurso = $curso->listarCurso($CUR_id,'');
            if($DetCurso[0]["TIPCUR_id"] != $TIPCUR_id){
                $Log->insertarLog("[SPV_TIPOCURSO]","[TIPCUR_id]","UPDATE",$DetCurso[0]["TIPCUR_id"],$TIPCUR_id,'',$CUR_id);
            }
            if($DetCurso[0]["CUR_fchini"] != $CUR_fchini){
                $Log->insertarLog("[SPV_TIPOCURSO]","[CUR_fchini]","UPDATE",$DetCurso[0]["CUR_fchini"],$CUR_fchini,'',$CUR_id);
            }
            if($DetCurso[0]["CUR_fchfin"] != $CUR_fchfin){
                $Log->insertarLog("[SPV_TIPOCURSO]","[CUR_fchfin]","UPDATE",$DetCurso[0]["CUR_fchfin"],$CUR_fchfin,'',$CUR_id);
            }
            if($DetCurso[0]["CUR_estado"] != $CUR_estado){
                $Log->insertarLog("[SPV_TIPOCURSO]","[CUR_estado]","UPDATE",$DetCurso[0]["CUR_estado"],$CUR_estado,'',$CUR_id);
            }
            if($DetCurso[0]["CUR_fchinforme"] != $CUR_fchinforme){
                $Log->insertarLog("[SPV_TIPOCURSO]","[CUR_fchinforme]","UPDATE",$DetCurso[0]["CUR_fchinforme"],$CUR_fchinforme,'',$CUR_id);
            }
            
            $curso->updateCurso($TIPCUR_id,$CUR_fchini,$CUR_fchfin,$CUR_id,$CUR_fchinforme,$CUR_estado);
            
            
            $TRIP_id_i = $_POST["TRIP_id_i"];
            $PART_id = $TRIP_id_i;
            
            $DetCurso = $curso->listarCurso($CUR_id,$TRIP_id);
            if($DetCurso[0]["TRIP_id"] != $TRIP_id_i){
                $Log->insertarLog("[SPV_TIPOCURSO]","[TRIP_id]","UPDATE",$DetCurso[0]["TRIP_id"],$TRIP_id_i,'',$PART_id);
            }
            
            $curso->updateParticipante($TRIP_id_i,$CUR_id,'APROBADO','Instructor',$PART_id);
            
            $cantidad = $_POST["cantidad"];
            for($i = 1; $i <= $cantidad; $i++){
                $PART_id = $_POST["PART_id_a".$i];
                $TRIP_id_a = $_POST["TRIP_id_a".$i];
                $PART_indicador = $_POST["PART_indicador".$i];
                $PART_observacion = $_POST["PART_observacion".$i];
                
                $DetCurso = $curso->listarCurso($CUR_id,$TRIP_id);
                if($DetCurso[0]["TRIP_id"] != $TRIP_id_a){
                    $Log->insertarLog("[SPV_TIPOCURSO]","[TRIP_id]","UPDATE",$DetCurso[0]["TRIP_id"],$TRIP_id_a,'',$PART_id);
                }
                if($DetCurso[0]["PART_observacion"] != $PART_observacion){
                    $Log->insertarLog("[SPV_TIPOCURSO]","[PART_observacion]","UPDATE",$DetCurso[0]["PART_observacion"],$PART_observacion,'',$PART_id);
                }
                $curso->updateParticipante($TRIP_id_a,$CUR_id,$PART_indicador,$PART_observacion,'Alumno',$PART_id);
            }
            
            $detalle = new Detalle_model();
            //$detalle->updateModulo('[SPV_CURSO]','1');
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Buscar Curso  ---------------------------------*/
    public function buscarCurso(){
        try{
            $TIPTRIP_id = $_POST["bTIPTRIP_id"];
            $TIPCUR_id = $_POST["bTIPCUR_id"];
            $PART_indicador = $_POST["bPART_indicador"];
            $TRIP_apellido = trim(mb_strtoupper($_POST["bTRIP_apellido"],'UTF-8'));
            $TRIP_numlicencia = $_POST["bTRIP_numlicencia"];
            
            $_SESSION["TIPTRIP_id"] = $TIPTRIP_id;
            $_SESSION["TIPCUR_id"] = $TIPCUR_id;
            $_SESSION["PART_indicador"] = $PART_indicador;
            $_SESSION["TRIP_apellido"] = $TRIP_apellido;
            $_SESSION["TRIP_numlicencia"] = $TRIP_numlicencia;
            
            if($TIPTRIP_id == '' and $TIPCUR_id == '' and $PART_indicador == '' and $TRIP_apellido == '' and $TRIP_numlicencia == ''){
                $this->model->Redirect(URLLOGICA."curso/listarResumenCurso/");
            } else {
                $curso = new Curso_model();
                $this->view->objResumenCurso = $curso->buscarResumenCurso($TIPTRIP_id,$TIPCUR_id,$PART_indicador,$TRIP_apellido,$TRIP_numlicencia);
                $this->view->objResumenCursoMatriz = $curso->buscarResumenCursoMatriz($TIPTRIP_id,$TIPCUR_id,$PART_indicador,$TRIP_apellido,$TRIP_numlicencia);
            
                $tripulante = new Tripulante_model();
                $this->view->objTripulante = $tripulante->listarTripulante('','');
                
                $detalle = new Detalle_model();
                $this->view->objTipoTripulante = $detalle->listarTipoTrip();
                $this->view->objTipoCurso = $detalle->listarTipoCurso();

                $this->view->render('curso');
            }
        } catch(Exception $e){
			$this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
    
    /*--------------------------------- Enviar Correo de Curso ---------------------------------*/
    public function enviarCorreoCurso(){
        try{
            $CUR_id = $_POST["CUR_id"];
            
            $curso = new Curso_model();
            $objCurso = $curso->listarCurso($CUR_id,'');
            $objCurso = $this->array_utf8_encode($objCurso);
            
            $TIPTRIP_descripcion = $objCurso[0]["TIPTRIP_descripcion"];
            $TIPCUR_descripcion = $objCurso[0]["TIPCUR_descripcion"];
            $CUR_fchini_Mes = strftime('%B',strtotime($objCurso[0]["CUR_fchini2"]));
            $CUR_fchfin_Anio = strftime('%Y',strtotime($objCurso[0]["CUR_fchini2"]));
                        
            $detalle = new Detalle_model();
            $objCorreos = $detalle->listarCorreoCondicionales();
            foreach($objCorreos as $listaCorreos){
                $listaDestino = $listaDestino.",".$listaCorreos["CORR_correo"];
            }
            $listaDestino = substr($listaDestino, 1);
            
            $email = new Email();
            $txt = "<p>Señores:<p>";
            $txt .= "<p>El presente es para informarles la programación del Curso de ". $TIPCUR_descripcion ." de los ".$TIPTRIP_descripcion." de fecha de ".$objCurso[0]["CUR_fchini"]." al ".$objCurso[0]["CUR_fchfin"].":<p>";
            
            foreach( $objCurso as $listaCurso ){
                if( $listaCurso["PART_descripcion"] == "Instructor" ){
                    $txt .= "<p>Instructor: ". $listaCurso["TRIP_nombre"] ." ". $listaCurso["TRIP_apellido"] ."<p>"; 
                }
                if( $listaCurso["PART_descripcion"] == "Alumno" ){
                    $txt .= "<p>Alumno: ". $listaCurso["TRIP_nombre"] ." ". $listaCurso["TRIP_apellido"] ."<p>";
                }
            }
            
            $txt .= "<p>Fch. Inicio: ". $objCurso[0]["CUR_fchini"] ."<p>";
            $txt .= "<p>Fch. Fin : ". $objCurso[0]["CUR_fchfin"] ."<p>";
            $txt .= "<p><br/><p>";
            
            $txt .= "<p>Saludos cordiales.</p>";
                        
            $asunto = "PROGRAMACIÓN DE CURSOS DE ".$TIPCUR_descripcion;
            $email->Enviar(utf8_decode($asunto),utf8_decode($txt),array($listaDestino),"alexander.varon@peruvian.pe",'','',"curso");
            
            
            echo "exito";
        } catch (Exception $e){
            $this->view->msg_catch = $e->getMessage();
			$this->view->render('error');
        }
    }
}
?>