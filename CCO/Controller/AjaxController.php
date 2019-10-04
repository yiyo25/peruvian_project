<?php

/**
 * Description of AjaxController
 *
 * @author ihuapaya
 */
class AjaxController extends Controller {

    private $ciudad;

    public function __construct() {
        parent::__construct();
        $this->ciudad = new Ciudad();
    }

    public function guardarVueloAction() {
        
        $rpt = 0;
        $error_msg = "";
        if($this->isPost()){
            $obj_vuelo_detalle =new VueloDetalle();
            if($this->validNumero($_POST["nroVuelo"])){
                if($_POST["nroVuelo"]>0){
                    $nro_vuelo = ltrim($_POST["nroVuelo"],"0");
                    if($obj_vuelo_detalle->existNroVuelo($nro_vuelo,$_POST["fecha"])){
                        $ruta = $_POST["ruta"];
                        $tipo_vuelo = $_POST["tipo"];
                        $fecha = $_POST["fecha"];
                        $nroVuelo = $nro_vuelo;
                        $hora = $_POST["hora"];
                        $tipo_operacion = $_POST["tipoOperacion"];
                        $arrayFecha = explode("-", $fecha);
                        $diaRecibe = mktime(0, 0, 0, $arrayFecha[1], $arrayFecha[2], $arrayFecha[0]);
                        $diaSemana = diaSemana(date("N", $diaRecibe));

                        $matricula = $_POST['matricula'];
                        $array_ruta_ida = $ruta;
                        $array_ruta_vuelta = array_reverse($array_ruta_ida);
                        if($this->existeRuta($tipo_vuelo, $array_ruta_ida, $array_ruta_vuelta)){
                            $nro_paradas = 0;
                            $ciudad_parada = "";
                            if (count($ruta) == 3) {
                                $nro_paradas = 1;
                                $ciudad_parada = $ruta[1];
                            }

                            $segmento_ida = implode("-", $array_ruta_ida);
                            $segmento_vuelta = "";
                            if ($tipo_vuelo == "RT") {
                                $segmento_vuelta = implode("-", $array_ruta_vuelta);
                            }

                            /*         * *******Generado la cabecera *************** */
                            $vuelo_cabecera = new VueloCabecera();
                            $cabecera_values = array(
                                "ITIDET_id" => 1,
                                "IdMatricula" => $matricula,
                                "dia_semana_vuelo" => $diaSemana,
                                "fecha_vuelo" => date("Y-m-d", strtotime($fecha)),
                                "IdTipoVuelo" => $tipo_vuelo,
                                "IdTipoOperacion" => $tipo_operacion,
                                "segmento_ida" => $segmento_ida,
                                "segmento_vuelta" => $segmento_vuelta,
                                "flag" => "1"
                            );


                            try {

                                $vuelo_cabecera->exec('BEGIN TRANSACTION;');
                                if ($vuelo_cabecera->insertData("Vuelo_Cabecera", $cabecera_values)) {
                                    $new_id = $vuelo_cabecera->getLastId('Vuelo_Cabecera');
                                    $array_vuelos = $this->generarDatosVuelo($tipo_vuelo, $nroVuelo, $array_ruta_ida, $array_ruta_vuelta, $hora);

                                    foreach ($array_vuelos as $key => $vuelos) {
                                        foreach ($vuelos as $key2 => $value) {
                                            $values_detalle_vuelo = array(
                                                "id_vuelo_cabecera" => $new_id[0]['last_id'],
                                                "IdMatricula" => $matricula,
                                                "ciudad_origen" => $value->origen,
                                                "ciudad_destino" => $value->destino,
                                                "hora_salida" => $value->hora_inicio,
                                                "hora_llegada" => $value->hora_fin,
                                                "tiempo_vuelo" => "0",
                                                "orden" => $value->orden,
                                                "vuelo_direccion" => strtoupper($value->trayecto),
                                                "vuelo_operativo" => $value->tipo,
                                                "NroVuelo" => $value->nro_vuelo,
                                                "nro_paradas" => $value->nro_paradas,
                                                "ciudad_parada" => $ciudad_parada,
                                                "estado_vuelo" => 1
                                            );
                                            $error_insert = 0;
                                            if (!$vuelo_cabecera->insertData("Vuelo_Detalle", $values_detalle_vuelo)) {
                                                $error_insert++;
                                            }
                                        }
                                    }
                                    if ($error_insert > 0) {
                                        $vuelo_cabecera->exec('ROLLBACK; ');
                                        $rpt= 0;

                                    } else {
                                        $vuelo_cabecera->exec('COMMIT; ');
                                         $rpt= 1;
                                    }
                                } else {
                                    $vuelo_cabecera->exec('ROLLBACK; ');
                                    $rpt= 0;
                                    $error_msg = "Error!: " . $e->getMessage() . "</br>";

                                }
                            } catch (Exception $e) {
                                $vuelo_cabecera->exec('ROLLBACK; ');
                                $rpt= 0;
                                $error_msg = "Error!: " . $e->getMessage() . "</br>";
                            }
                        }else{
                            $rpt = 0;
                            $error_msg = "La ruta ingresada no existe o esta inactiva";
                        }
                    }else{
                        $rpt = 0;
                        $error_msg = "El Nro. de Vuelo ".$_POST["nroVuelo"]." ya existe para esta Fecha =>".$_POST["fecha"];
                    }
                }else{
                    $rpt = 0;
                        $error_msg = "El Nro. de Vuelo ".$_POST["nroVuelo"]." es incorrecto";
                }
            }else{
                $rpt = 0;
                $error_msg = "El Nro de Vuelo debe ser Numérico.";
            }  
        }else{
            $rpt = 0;
            $error_msg = "Metodo no valido.";
        }
        
        echo json_encode(array("rpt"=>$rpt,"error_msg"=>$error_msg));
        exit;
    }

    public function showDataFlightAction() {
        $rpt = 0;
        $html_vuelo="";
        $error_msg = "";
        if($this->isPost()){
            $obj_vuelo_detalle =new VueloDetalle();
            
            if($this->validNumero($_POST["nro_vuelo"])){
                if($_POST["nro_vuelo"]>0){
                    $nro_vuelo = ltrim($_POST["nro_vuelo"],"0");
                    //echo $nro_vuelo;exit;
                    if($obj_vuelo_detalle->existNroVuelo($nro_vuelo,$_POST["fecha"])){
                        $ruta = $_POST["ruta"];
                        $tipo_vuelo = $_POST["tipo"];
                        $fecha = $_POST["fecha"];
                        $nroVuelo =$nro_vuelo;
                        $hora = $_POST["hora_ini"];
                        $array_ruta_ida = explode(",", $ruta);
                        $array_ruta_vuelta = array_reverse($array_ruta_ida);
                        $rpt = 0;
                        $html_vuelo="";
                        if($this->existeRuta($tipo_vuelo, $array_ruta_ida, $array_ruta_vuelta)){
                            $array_vuelos = $this->generarDatosVuelo($tipo_vuelo, $nroVuelo, $array_ruta_ida, $array_ruta_vuelta, $hora);
                            $rpt = 1;
                            $html_vuelo=$this->buildFlightTable($array_vuelos);
                        }else{
                            $rpt = 0;
                            $html_vuelo="";
                            $error_msg = "La ruta ingresada no existe o esta inactiva";
                        }
                    }else{
                        $rpt = 0;
                        $html_vuelo="";
                        $error_msg = "El Nro. de Vuelo ".$_POST["nro_vuelo"]." ya existe para esta Fecha =>".$_POST["fecha"];
                    }
                }else{
                    $rpt = 0;
                        $error_msg = "El Nro. de Vuelo ".$_POST["nro_vuelo"]." es incorrecto";
                }
            }else{
                $rpt = 0;
                $html_vuelo="";
                $error_msg = "El Nro de Vuelo debe ser Numérico.";
            }  
        }else{
            $rpt = 0;
            $html_vuelo="";
            $error_msg = "Metodo no valido.";
        }
        
        echo json_encode(array("rpt"=>$rpt,"html_vuelo"=>$html_vuelo,"error_msg"=>$error_msg));
        exit;
    }

    public function generarDatosVuelo($tipo_vuelo, $nroVuelo, $array_ruta_ida, $array_ruta_vuelta, $hora) {

        $ruta_completa = array();
        $nroVueloDestino = $nroVuelo;
        switch ($tipo_vuelo) {
            case "OW":
                $ruta_completa = array($array_ruta_ida);
                break;
            case "RT":
                $ruta_completa = array($array_ruta_ida, $array_ruta_vuelta);
                if ($nroVuelo % 2 == 0) {
                    $nroVueloDestino = $nroVuelo + 1;
                } else {
                    $nroVueloDestino = $nroVuelo - 1;
                }
                break;
        }

        $array_data_vuelo = array();

        foreach ($ruta_completa as $key => $value) {

            $cant = count($value) - 1;
            $recorrehasta = count($value) - 1;
            if (count($value) > 2) {
                $recorrehasta = count($value);
            }
            $trayecto = "ida";
            $nro_vuelo_creado = $nroVuelo;
            if ($key == 1) {//vuelta
                $trayecto = "vuelta";
                $nro_vuelo_creado = $nroVueloDestino;
                $embarque = $this->ciudad->tiempoEmbarque(end($array_ruta_ida));
                $tiempo_embarque = $embarque[0]['ciu_Embarque'];
                //obtenemos la ultima hora fin de la ida
                $hora_fin = $array_data_vuelo["ida"][$key - 1]->hora_fin;
                if (count($value) > 2) {
                    $hora_fin = $array_data_vuelo["ida"][count($value) - 2]->hora_fin;
                }
                $hora = sumaHoras($hora_fin, $tiempo_embarque);
            }
            $a = 1;
            for ($i = 0; $i < $recorrehasta; $i++) {

                if ($i < count($value) - 1) {//vuelo operacional
                    $horas = $this->getHora($value[$i], $value[$i + 1], $hora, $a);
                    $hora_ini = $horas["inicio"];
                    $hora_final = $horas["fin"];
                    $hora = $hora_final; //reseteo la hora inicial con la ulitma hora;
                    $array_data_vuelo[$trayecto][$i] = $this->dataVuelo($value[$i], $value[$i + 1], $a, "O", $nro_vuelo_creado, $hora_ini, $hora_final, $trayecto, 0);
                } else {//vuelo comercial
                    $hora_ini = $array_data_vuelo[$trayecto][0]->hora_inicio;
                    $hora_fin = $array_data_vuelo[$trayecto][$i - 1]->hora_fin;
                    $array_data_vuelo[$trayecto][$i] = $this->dataVuelo($value[0], $value[$cant], $a, "C", $nro_vuelo_creado, $hora_ini, $hora_fin, $trayecto, 1, $value[$cant - 1]);
                }
                $a++;
            }
        }

        return $array_data_vuelo;
    }

    function dataVuelo($origen, $destino, $orden, $tipo, $nro_vuelo, $horaInicio = "", $hora_fin = "", $trayecto = "", $paradas = "", $ciudad_parada = "") {
        $data = new stdClass();
        $data->trayecto = $origen . "-" . $destino;
        $data->origen = $origen;
        $data->destino = $destino;
        $data->orden = $orden;
        $data->tipo = $tipo;
        $data->nro_vuelo = $nro_vuelo;
        $data->hora_inicio = $horaInicio;
        $data->hora_fin = $hora_fin;
        $data->trayecto = substr($trayecto, 0, 3);
        $data->nro_paradas = $paradas;
        $data->ciudad_parada = $ciudad_parada;
        return $data;
    }

    public function getHora($origen, $destino, $horaInicio, $orden) {
        $minutos_entre_ciudad = $this->ciudad->minutosEntreCiudad(array($origen, $destino));
        $hora = $minutos_entre_ciudad[0]['tiempo'];

        $horaFin = sumaHoras($horaInicio, $hora);
        if ($orden > 1) {
            $embarque = $this->ciudad->tiempoEmbarque($origen);
            $tiempo_embarque = $embarque[0]['ciu_Embarque'];
            $horaInicio = sumaHoras($horaInicio, $tiempo_embarque);
            $horaFin = sumaHoras($horaInicio, $hora);
        }

        return array("inicio" => $horaInicio, "fin" => $horaFin);
    }
    
    public function  existeRuta($tipo_vuelo,$array_ruta_ida, $array_ruta_vuelta){
        $objruta = new Ruta();
        $ruta_completa = array();
        switch ($tipo_vuelo) {
            case "OW":
                $ruta_completa = array($array_ruta_ida);
                break;
            case "RT":
                $ruta_completa = array($array_ruta_ida, $array_ruta_vuelta);
                break;
        }
        $error=0;
        foreach ($ruta_completa as $key => $ruta) {
            
            $recorrehasta = count($ruta) - 1;
            if (count($ruta) > 2) {
                $recorrehasta = count($ruta);
            }
            for ($i = 0; $i < $recorrehasta; $i++) {

                if ($i < count($ruta) - 1) {//vue
                    if(!$objruta->existRuta($ruta[$i], $ruta[$i + 1])){
                        $error++;
                    }
                }
            }
        }
        
        if($error>0){
            return false;
        }
        
        return true;
    }

    public function buildFlightTable($array_data) {
        $html = "";
        foreach ($array_data as $key1 => $data) {
            $html .= '<div class="table-responsive"><table>';
            $html .= '<table  class="table table-striped table-bordered table-responsive" >';
            $html .= '<thead>
                        <tr>
                            <th  scope="col" >Direccion</th>
                            <th  scope="col">Orden</th>
                            <th  scope="col">Origen</th>
                            <th  scope="col">Destino</th>
                            <th scope="col">Nro.Vuelo</th>
                            <th  scope="col">O/c</th>
                            <th  scope="col">Salida</th>
                            <th  scope="col">Llegada</th>
                            <th  scope="col">Nro. Parada</th>
                            <th  scope="col">Ciudad Parada</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($data as $key => $value) {
                $td_rowspan = '';
                if ($key == 0) {
                    $td_rowspan = '<td class="info" rowspan="7" style="vertical-align: middle; "><b>' . strtoupper($key1) . '</b></td>';
                }

                $html .= '<tr>
                                    ' . $td_rowspan . '    
                                    <td class="row">' . $value->orden . '</td>
                                    <td>' . $value->origen . '</td>
                                    <td>' . $value->destino . '</td>
                                    <td>' . $value->nro_vuelo . '</td>
                                    <td>' . $value->tipo . '</td>
                                    <td>' . $value->hora_inicio . '</td>
                                    <td>' . $value->hora_fin . '</td>
                                    <td>' . $value->nro_paradas . '</td>
                                    <td>' . $value->ciudad_parada . '</td>    
                                </tr>';
            }
            $html .= "</tbody><table></div>";
        }
        return $html;
    }

}
