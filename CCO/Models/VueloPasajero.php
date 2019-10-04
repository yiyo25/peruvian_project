<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VueloPasajero
 *
 * @author ihuapaya
 */
class VueloPasajero extends Model {

    private $database = DB_NAME;
    protected $table = 'Vuelo_Pasajero';

    public function __construct() {
        parent::__construct($this->database);
    }

    public function getRowByFlight($id_vuelo_detalle) {

        $sql_pasajeros = "select * from " . $this->table . " where id_vuelo_detalle=" . $id_vuelo_detalle;
        $rs_pasajeros = $this->Consultar($sql_pasajeros);
        $array_data = array();
        foreach ($rs_pasajeros as $pasajeros) {
            $data = new stdClass();

            $data->clase_j = $pasajeros["clase_j"];
            $data->clase_y = $pasajeros["clase_y"];
            $data->nro_adultos = $pasajeros["nro_adultos"];
            $data->nro_menores = $pasajeros["nro_menores"];
            $data->nro_infantes = $pasajeros["nro_infantes"];
            $data->nro_nr = $pasajeros["nro_nr"];
            $data->nro_toneladas_ttl = $pasajeros["nro_toneladas_ttl"];
            $data->nro_piezas = $pasajeros["nro_piezas"];
            $data->nro_klos = $pasajeros["nro_klos"];
            $data->nro_bin = $pasajeros["nro_bin"];
            $data->nro_piezas_carga = $pasajeros["nro_piezas_carga"];
            $data->nro_kilos_carga = $pasajeros["nro_kilos_carga"];
            $data->nro_bin_carga = $pasajeros["nro_bin_carga"];
            $array_data[] = $data;
        }
        return $array_data;
    }

    public function update($array_data = array(), $where = array()) {
        return $this->updateData($this->table, $array_data, $where);
    }

    public function insert($array_data) {
        return $this->insertData($this->table, $array_data);
    }

    function verificaPasajerosEquipajeDetalle($nroVueloDetalle, $arrayError) {

        $sql = "select count(*) as valor from " . $this->table . " where id_vuelo_detalle=" . $nroVueloDetalle;

        $rsVerificaDetPaxEqui = $this->Consultar($sql);

        if ((int) $rsVerificaDetPaxEqui[0]["valor"] > 0) {
            $sql = "select * from " . $this->table . " where id_vuelo_detalle=" . $nroVueloDetalle;
            //echo $sql . "<br>"; 
            $rsDetPaxEqui = $this->Consultar($sql);

            $nro_adultos = $rsDetPaxEqui[0]["nro_adultos"];
            $nro_menores = $rsDetPaxEqui[0]["nro_menores"];
            $nro_infantes = $rsDetPaxEqui[0]["nro_infantes"];
            $nro_piezas = $rsDetPaxEqui[0]["nro_piezas"];
            $nro_klos = $rsDetPaxEqui[0]["nro_klos"];
            $nro_bin = $rsDetPaxEqui[0]["nro_bin"];

            if (!(is_numeric($nro_adultos) and $nro_adultos > 0)) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Pasajeros :: Pax Adultos no ingresado correctamente. <br>";
            }
            if (!(is_numeric($nro_menores) and $nro_menores >= 0)) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Pasajeros :: Pax Nemores no ingresado correctamente. <br>";
            }
            if (!(is_numeric($nro_infantes) and $nro_infantes >= 0)) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Pasajeros :: Pax Infantes no ingresado correctamente. <br>";
            }

            if (!(is_numeric($nro_piezas) and $nro_piezas >= 0)) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Equipaje :: Nro de Piezas no ingresado correctamente. <br>";
            }

            if (!(is_numeric($nro_klos) and $nro_klos >= 0)) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Equipaje :: Nro de Kilos no ingresado correctamente. <br>";
            }

            if (!(strlen($nro_bin) > 0 and $nro_bin != 0)) {
                $arrayError["nroError"] += 1;
                $arrayError["mensaje"] .= "Error: Equipaje :: Nro de bodega no ingresado correctamente. <br>";
            }
        } else {
            $arrayError["nroError"] += 1;
            $arrayError["mensaje"] .= "Error: Vuelo :: El vuelo no tienen ningun dato de Pasajero y Equipaje.<br>";
        }
        return $arrayError;
    }

    
    function totalPajeroPorFechaVuelo($fecha_vuelo){
        $sql_total_pasajero = "select sum(vp.clase_y) as total_pasajero
                                from 
                                Vuelo_Cabecera vc LEFT JOIN Vuelo_Detalle  vd on (vc.id_vuelo_cabecera = vd.id_vuelo_cabecera) 
                                LEFT JOIN Vuelo_Pasajero vp on (vd.id_vuelo_detalle = vp.id_vuelo_detalle)
                                where 
                                vc.fecha_vuelo = '".$fecha_vuelo."' 
                                ";
        
        $rs_pasajeros = $this->Consultar($sql_total_pasajero);

        //var_dump($rs_pasajeros[0]["total_pasajero"]);
        /*if($rs_pasajeros[0]["total_pasajero"]=="NULL"){
            $valor =  "0";
        }else{
            $valor = $rs_pasajeros[0]["total_pasajero"];
        }*/
        

        return $rs_pasajeros[0]["total_pasajero"];
    }
   
}
