<?php

/**
 * Description of Vuelo_Detalle
 *
 * @author ihuapaya
 */
class VueloDetalle extends Model {

    private $database = DB_NAME;
    protected $table = 'Vuelo_Detalle';

    public function __construct() {
        parent::__construct($this->database);
    }

    public function getFligthDetail($id_vuelo_cabecera, $ciudad_origen = "", $nro_vuelo = "") {
        $and_ciudad_origen = "";
        $and_nro_vuelo = "";
        if ($ciudad_origen != "") {
            $and_ciudad_origen = " and a.ciudad_origen='" . $ciudad_origen . "'";
        }
        
       
        if ($nro_vuelo != "") {
            if ($nro_vuelo % 2 == 0) {
                $nroVueloDestino = $nro_vuelo + 1;
            } else {
                $nroVueloDestino = $nro_vuelo - 1;
            }
            $and_nro_vuelo = " and (a.NroVuelo='" . $nro_vuelo . "' or a.NroVuelo='" . ($nroVueloDestino). "')";
        }
       // echo $and_nro_vuelo;Exit;
        $sql_detalle = "SELECT 
                        a.id_vuelo_cabecera,
                        a.id_vuelo_detalle as id_vuelo_detalle_ori,
                        a.IdMatricula,
                        a.NroVuelo,
                        a.ciudad_origen,
                        a.ciudad_destino,
                        a.orden,
                        a.vuelo_direccion,
                        a.vuelo_operativo,
                        a.take_out_hora_despegue,
                        a.arr_in_hora_arribo,
                        a.estado_vuelo,
                        a.nro_paradas,
                        a.ciudad_parada,
                        b.*
                        FROM
                        Vuelo_Detalle a 
                        LEFT JOIN Vuelo_Pasajero b ON (a.id_vuelo_detalle=b.id_vuelo_detalle)
                        WHERE 
                        A.id_vuelo_cabecera = '" . $id_vuelo_cabecera . "' " . $and_ciudad_origen . $and_nro_vuelo;

        $rs_detalle_vuelo = $this->Consultar($sql_detalle);

        return $rs_detalle_vuelo;
    }

    public function getRowById($id) {

        $sql_fligth = $this->selectData($this->table, array("id_vuelo_detalle" => $id));
        return $sql_fligth;
    }

    function verificaHorasVuelo($nroVueloDetalle, $arrayError) {
        $sql = "select * from " . $this->table . " where id_vuelo_detalle=" . $nroVueloDetalle;
        $rsVerificaDetVuelo = $this->Consultar($sql);

        $hora_cierre_puerta = $rsVerificaDetVuelo[0]["hora_cierre_puerta"];
        $puerta_PB = $rsVerificaDetVuelo[0]["puerta_PB"];
        $ENG_ON_hora_embarque = $rsVerificaDetVuelo[0]["ENG_ON_hora_embarque"];
        $take_out_hora_despegue = $rsVerificaDetVuelo[0]["take_out_hora_despegue"];
        $arr_in_hora_arribo = $rsVerificaDetVuelo[0]["arr_in_hora_arribo"];
        $hora_parada = $rsVerificaDetVuelo[0]["hora_parada"];
        $hora_apertura_puerta = $rsVerificaDetVuelo[0]["hora_apertura_puerta"];

        if ($this->verificaHora($hora_cierre_puerta)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Hora Vuelo :: Hora de Cierre de puerta. <br>";
        }

        if ($this->verificaHora($puerta_PB)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Hora Vuelo :: Hora de puerta PB. <br>";
        }
        if ($this->verificaHora($ENG_ON_hora_embarque)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Hora Vuelo :: Hora de embarque. <br>";
        }
        if ($this->verificaHora($take_out_hora_despegue)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Hora Vuelo :: Hora de despegue. <br>";
        }
        if ($this->verificaHora($arr_in_hora_arribo)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Hora Vuelo :: Hora de arribo. <br>";
        }
        if ($this->verificaHora($hora_parada)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Hora Vuelo :: Hora de parada. <br>";
        }
        if ($this->verificaHora($hora_apertura_puerta)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Hora Vuelo :: 
		Hora de apertura de puerta. <br>";
        }
        return $arrayError;
    }

    function verificaCombustibleVuelo($nroVueloDetalle, $arrayError) {
        $sql = "select * from " . $this->table . " where id_vuelo_detalle=" . $nroVueloDetalle;
        $rsVerificaExistencia = $this->Consultar($sql);

        $toma_in = $toma_out = $nivel_vuelo = $rmntFull_lbs_kgs = $recagFull_lbs_gal = $total_full_lbs_kgs = $total_full_kgs_kgs = $nro_entrega_Exxon_1 = $nro_entrega_Exxon_1_nro2 = $nro_entrega_Exxon_1_nro3 = $recagFull_lbs_gal_nro1 = $recagFull_lbs_gal_nro2 = $recagFull_lbs_gal_nro3nro_entrega_Exxon_2 = $cantidad_ingreso_kilos_libras = $cant_librasGalones = $total_full_lbs_kgs = $total_full_kgs_kgs = 0;

        $id_vuelo_detalle = $rsVerificaExistencia[0]["id_vuelo_detalle"];
        $id_vuelo_itinerario = $rsVerificaExistencia[0]["id_vuelo_itinerario"];
        $IdMatricula = $rsVerificaExistencia[0]["IdMatricula"];

        $toma_in = trim($rsVerificaExistencia[0]["toma_in"]);
        $toma_out = trim($rsVerificaExistencia[0]["toma_out"]);
        $nivel_vuelo = trim($rsVerificaExistencia[0]["nivel_vuelo"]);

        $rmntFull_lbs_kgs = trim($rsVerificaExistencia[0]["rmntFull_lbs_kgs"]);
        $recagFull_lbs_gal = trim($rsVerificaExistencia[0]["recagFull_lbs_gal"]);
        $total_full_lbs = trim($rsVerificaExistencia[0]["total_full_lbs_kgs"]);
        $total_full_kgs = trim($rsVerificaExistencia[0]["total_full_kgs_kgs"]);

        $nro_entrega_Exxon_1 = trim($rsVerificaExistencia[0]["nro_entrega_Exxon_1"]);
        $nro_entrega_Exxon_1_nro2 = trim($rsVerificaExistencia[0]["nro_entrega_Exxon_1_nro2"]);
        $nro_entrega_Exxon_1_nro3 = trim($rsVerificaExistencia[0]["nro_entrega_Exxon_1_nro3"]);

        $recagFull_lbs_gal_nro1 = trim($rsVerificaExistencia[0]["recagFull_lbs_gal_nro1"]);
        $recagFull_lbs_gal_nro2 = trim($rsVerificaExistencia[0]["recagFull_lbs_gal_nro2"]);
        $recagFull_lbs_gal_nro3 = trim($rsVerificaExistencia[0]["recagFull_lbs_gal_nro3"]);

        $nro_entrega_Exxon_2 = trim($rsVerificaExistencia[0]["nro_entrega_Exxon_2"]); //

        $cantidad_ingreso_kilos_libras = trim($rsVerificaExistencia[0]["cantidad_ingreso_kilos_libras"]);
        $cantidad_ingreso_libras_de_galones = trim($rsVerificaExistencia[0]["cant_librasGalones"]);

        $total_full_lbs_kgs = trim($rsVerificaExistencia[0]["total_full_lbs_kgs"]);
        $total_full_kgs_kgs = trim($rsVerificaExistencia[0]["total_full_kgs_kgs"]);

        if (!($total_full_lbs_kgs > 0 && $total_full_kgs_kgs > 0)) {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Coombustible :: Remamente no ingresado. <br>";
        }

        if ($recagFull_lbs_gal_nro1 > 0) {
            if ($nro_entrega_Exxon_1 <= 0) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Coombustible :: Error en ingreso de Exxon Movil nro 1.<br>";
            }
        } elseif ($recagFull_lbs_gal_nro1 > 0) {
            if ($recagFull_lbs_gal_nro1 <= 0) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Coombustible :: Error en ingreso de Exxon Movil nro 1.<br>";
            }
        }

        return $arrayError;
    }

    function verificaHora($tiempo) {
        $errorValor = 0;
        if (trim($tiempo) != "00:00") {
            if (strlen(trim($tiempo)) > 0) {
                $arrayTime = explode(":", $tiempo);
                $hora = (int) $arrayTime[0];
                $minuto = (int) $arrayTime[1];

                if (!($hora < 24 && $minuto < 60)) {
                    $errorValor = 1;
                }
            } else {
                $errorValor = 1;
            }
        } else {
            $errorValor = 1;
        }

        return $errorValor;
    }

    function verificarPreCierreVuelo($fecha) {
        $sql_vuelo = "select vd.id_vuelo_detalle, vd.estado_vuelo "
                . "from Vuelo_Cabecera vc, Vuelo_Detalle vd "
                . "where vc.id_vuelo_cabecera = vd.id_vuelo_cabecera and"
                . " vc.fecha_vuelo='" . $fecha . "' and estado_vuelo!=6";
        $rs_vuelos = $this->Consultar($sql_vuelo);

        return count($rs_vuelos);
    }

    function verificarEstadoCierreVuelo($id_vuelo_detalle) {
        $sql_estado_vuelo = "select id_vuelo_detalle , estado_vuelo from " . $this->table . " where id_vuelo_detalle='" . $id_vuelo_detalle . "'";
        $rs_estado_vuelo = $this->Consultar($sql_estado_vuelo);

        if ($rs_estado_vuelo[0]["estado_vuelo"] == 6) {
            return true;
        }

        return false;
    }

    function getVuelosOperativos($fecha) {
        $sql_vuelo_cabecera = "select * from Vuelo_Cabecera where fecha_vuelo ='" . $fecha . "'";
        $rs_vuelo_cabecera = $this->Consultar($sql_vuelo_cabecera);
        $data = array();
        $cont = 0;
        foreach ($rs_vuelo_cabecera as $key => $vuelo_cabecera) {
            $sql_vuelos = "
                    SELECT 
                    vd.id_vuelo_detalle,
                    vc.id_vuelo_cabecera,
                    vd.NroVuelo,
                    vc.IdMatricula,
                    vc.IdTipoVuelo,
                    vd.orden,
                    vd.vuelo_direccion,
                    vd.ciudad_origen,
                    vd.ciudad_destino,
                    vd.hora_cierre_puerta_itin as ETD,
                    vd.hora_apertura_puerta as ETA,
                    vd.puerta_PB as ATD,
                    vd.hora_parada as ATA,
                    vd.hora_salida,
                    vd.hora_llegada,
                    vp.clase_y
                    FROM 
                    Vuelo_Cabecera vc inner join Vuelo_Detalle vd on (vc.id_vuelo_cabecera = vd.id_vuelo_cabecera)
                    left join Vuelo_Pasajero vp on (vd.id_vuelo_detalle = vp.id_vuelo_detalle)
                    WHERE 
                    vc.fecha_vuelo='" . $fecha . "' AND
                    vd.vuelo_operativo = 'O' and vc.id_vuelo_cabecera='" . $vuelo_cabecera["id_vuelo_cabecera"] . "' ";
            $rs_vuelos = $this->Consultar($sql_vuelos);
            $detalle = array();
            foreach ($rs_vuelos as $key => $value) {
                $detalle["detalle"][$key] = $value;
                if ($value["IdTipoVuelo"] == "OW") {
                    $detalle["detalle"][$key] = $value;
                    $detalle["detalle"][$key + 1] = array(
                        "id_vuelo_detalle" => 0,
                        "id_vuelo_cabecera" => $value["id_vuelo_cabecera"],
                        "NroVuelo" => "",
                        "IdMatricula" => "",
                        "IdTipoVuelo" => "",
                        "orden" => "",
                        "vuelo_direccion" => "",
                        "ciudad_origen" => "",
                        "ciudad_destino" => "",
                        "ETD" => "",
                        "ETA" => "",
                        "ATD" => "",
                        "ATA" => "",
                        "hora_salida" => "",
                        "hora_llegada" => "",
                        "clase_y" => ""
                    );
                }

                $cont++;
            }

            $data["vuelo_cabecera"][] = $detalle;
        }

        return array("data" => $data, "cant" => $cont);
    }

    function existNroVuelo($nro_vuelo, $fecha) {
        $sql_nro_vuelo = "select vd.id_vuelo_detalle from Vuelo_Detalle vd, Vuelo_Cabecera vc
                            where
                            vd.id_vuelo_cabecera = vc.id_vuelo_cabecera and
                            vd.NroVuelo='" . $nro_vuelo . "' and vc.fecha_vuelo='" . $fecha . "'";

        $rs_nro_vuelo = $this->Consultar($sql_nro_vuelo);

        if (count($rs_nro_vuelo) > 0) {
            return false;
        }
        return true;
    }
    
    function cantVueloPorDia($fecha){
        $sql = "select count(vd.id_vuelo_detalle) as nro_vuelos
                from 
                Vuelo_Cabecera vc LEFT JOIN Vuelo_Detalle  vd on (vc.id_vuelo_cabecera = vd.id_vuelo_cabecera) 
                where 
                vc.fecha_vuelo = '".$fecha."'  and vd.vuelo_operativo ='O'";
         $rs_vuelos = $this->Consultar($sql);

        //var_dump($rs_pasajeros[0]["total_pasajero"]);
        /*if($rs_pasajeros[0]["total_pasajero"]=="NULL"){
            $valor =  "0";
        }else{
            $valor = $rs_pasajeros[0]["total_pasajero"];
        }*/
        

        return $rs_vuelos[0]["nro_vuelos"];
    }
    
    function data_reporte_pasajeros($fecha_ini,$fecha_fin){
        $query = "select 
                vc.fecha_vuelo,
                vc.IdMatricula,
                vd.NroVuelo,
                vd.ciudad_origen,
                ciudad_destino ,
                vd.ciudad_parada,
                vd.nro_paradas,
                vp.clase_y , 
                vp.nro_nr, 
                vp.nro_infantes,
                (vp.clase_y - vp.nro_nr - vp.nro_infantes) as pasajeroPagoDirecto ,
                vp.nro_nr as pasajeroNoPagos,
                (vp.clase_y - vp.nro_infantes) as pasajeroPagoTotal ,
                vp.nro_infantes as pasajeroInfantes,
                vp.nro_kilos_carga 
                from
                Vuelo_Cabecera vc inner join Vuelo_Detalle vd on (vc.id_vuelo_cabecera = vd.id_vuelo_cabecera)
                left join Vuelo_Pasajero vp on(vd.id_vuelo_detalle = vp.id_vuelo_detalle) 
                where 
                vc.fecha_vuelo between '".$fecha_ini."' and '".$fecha_fin."' order by vc.fecha_vuelo 
                ";
        $rs_query = $this->Consultar($query);
        return $rs_query;
    }

}
