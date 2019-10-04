<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VueloCabecera
 *
 * @author ihuapaya
 */
class VueloCabecera extends Model {

    //put your code here
    /* protected static $table = "usuarios";

      protected static $_primary_key = 'id';
      protected $database = 'db_cco_new'; */

    protected $table = "Vuelo_Cabecera";
    private $database = DB_NAME;

    public function __construct() {
        parent::__construct($this->database);
    }

    public function getFligthByDate($date = "") {
        
        
        $sql_fligth = $this->selectRowData($this->table, "id_vuelo_cabecera,fecha_vuelo", array("fecha_vuelo" => date('Y-m-d', strtotime($date))));
        //$sql_vuelo = "select id_vuelo_cabecera from Vuelo_Cabecera where fecha_vuelo = '".date('Y-m-d', strtotime($date))."'";
        
        //$rs_vuelo = $this->Consultar($sql_vuelo);
        return $sql_fligth;
    }
    
    public function getRowById($id){
        $sql_fligth = $this->selectData($this->table, array("id_vuelo_cabecera"=> $id ));
        return $sql_fligth;
    }
    
    public function getdateFligth($fecha_ini,$fecha_fin){
        
        $sql_data = "select  distinct(vc.fecha_vuelo) as fecha_vuelo  "
                . "from Vuelo_Cabecera vc "
                . "where fecha_vuelo BETWEEN  '".$fecha_ini."' and '".$fecha_fin."'";
        $rs_vuelo = $this->Consultar($sql_data);
        return $rs_vuelo;
        
    }
    
    public function pasajeros_HorasBlock_CantVuelosxMes(){
        $query = " select  distinct MONTH(vc2.fecha_vuelo)as mes,DATENAME(month, (vc2.fecha_vuelo)) as NombreMes, 
                ( select sum(vp.clase_y) as total_pasajero
                from 
                Vuelo_Cabecera vc1 LEFT JOIN Vuelo_Detalle  vd on (vc1.id_vuelo_cabecera = vd.id_vuelo_cabecera) 
                LEFT JOIN Vuelo_Pasajero vp on (vd.id_vuelo_detalle = vp.id_vuelo_detalle)
                where 
                MONTH(vc1.fecha_vuelo) = MONTH(vc2.fecha_vuelo) ) as pasajeros,
                (select SUM(vd.horas_block) 
                from Vuelo_Cabecera vc3 
                INNER JOIN Vuelo_Detalle vd on (vc3.id_vuelo_cabecera = vd.id_vuelo_cabecera)
                where MONTH(vc3.fecha_vuelo) = MONTH(vc2.fecha_vuelo) ) as horasblock,
                (select count(vd.id_vuelo_detalle) as nro_vuelos
                from 
                Vuelo_Cabecera vc LEFT JOIN Vuelo_Detalle  vd on (vc.id_vuelo_cabecera = vd.id_vuelo_cabecera) 
                where 
                MONTH(vc.fecha_vuelo) = MONTH(vc2.fecha_vuelo)  and vd.vuelo_operativo ='O') as cant_vuelos,

                (select sum(case when DATEDIFF(MINUTE, puerta_PB, hora_cierre_puerta_itin)<0 then 1 else 0 end)

                from Vuelo_Detalle vd , Vuelo_Cabecera vca

                where vca.id_vuelo_cabecera = vd.id_vuelo_cabecera and
                MONTH(vca.fecha_vuelo) = MONTH(vc2.fecha_vuelo)  and vd.vuelo_operativo ='O'
                ) as vuelo_demorado
                from Vuelo_Cabecera vc2 ";
        $rs_reporte = $this->Consultar($query);
        return $rs_reporte;
    }
    
    
    public function vuelos_por_localidad($year,$mes){
        $query = "select 
                vd.ciudad_origen, 
                COUNT(id_vuelo_detalle) nro_vuelos,
                sum(case when DATEDIFF(MINUTE, puerta_PB, hora_cierre_puerta_itin)<0 then 1 else 0 end) demorados
                from Vuelo_Cabecera vc2, Vuelo_Detalle vd
                where 
                vc2.id_vuelo_cabecera = vd.id_vuelo_cabecera and
                year(vc2.fecha_vuelo) = '".$year."' and MONTH(vc2.fecha_vuelo) = '".$mes."' and vd.vuelo_operativo='O'
                group by vd.ciudad_origen";
        
        $rs_reporte = $this->Consultar($query);
        return $rs_reporte;
    }

}
