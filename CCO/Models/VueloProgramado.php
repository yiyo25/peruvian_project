<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VueloProgramado
 *
 * @author ihuapaya
 */
class VueloProgramado extends Model {
    /*protected static $table = "vuelo_programado";
    protected static $_primary_key = 'id_vuelo_programado'; */

    protected  $database = 'db_cco';

    public function __construct() {
        parent::__construct($this->database);
    }

    public function listadoVuelo() {
        //echo $this->hola();exit;
        //$DB = $this;
        $sql = " 		
  	SELECT 
            vp.id_vuelo_programado, 
            vi.id_vuelo_itinerario, 
            vp.fecha_vuelo, 
            vp.IdMatricula, 
            flag, 
            vi.estado_vuelo_regular,
            vi.ciudad_paradas,
            vi.ciudad_paradas_imprevisto,
            vi.estadoVuelo,
            vi.NroVuelo,
            vi.orden,
            vi.ciudad_origen_principal,
            vi.ciudad_destino_principal,
            vi.nro_paradas_imprevisto,
            vi.nro_paradas
        FROM 
            vuelo_programado vp, 
            vuelo_itinerario vi 
        WHERE 
            vp.id_vuelo_programado=vi.id_vuelo_programado AND 
            vp.fecha_vuelo='20190607' AND 
            vp.flag=1 AND 
            vi.estado_vuelo_regular=1";

        $stmt = $this->Consultar($sql);
        return $stmt;
    }

    public function detalleVuelo($idItinerario = "", $ciudad = "") {
        $and_ciudad = "";
        if ($ciudad != "") {
            $and_ciudad = " and ciudad_origen_detalle='" . $ciudad . "'";
        }
        $sql_detalle_vuelo = "
                SELECT 
                    id_vuelo_detalle,
                    id_vuelo_itinerario,
                    IdMatricula,
                    ciudad_origen_detalle,
                    ciudad_destino_detalle,
                    orden 
                FROM 
                vuelo_detalle 
                WHERE id_vuelo_itinerario=" . $idItinerario . $and_ciudad;

        $rs_detalle_vuelo = $this->Consultar($sql_detalle_vuelo);
        return $rs_detalle_vuelo;
    }
    
    public function getpasajero($id_vuelo_detalle) {
        $sql_pasajero = "select * from vuelo_pasajero_vuelo_detalle where id_vuelo_detalle = ?" ;
        $rs_pasajero = $this->Consultar($sql_pasajero, array($id_vuelo_detalle));
        return $rs_pasajero;        
    }
    
}
