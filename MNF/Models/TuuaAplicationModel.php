<?php


class TuuaAplicationModel extends Model
{
    private $database = DB_NAME;
    // protected $table = 'AVIONTIPO';

    public function __construct() {
        parent::__construct($this->database);
    }
    public function tuua_cabecera($data=array()){
        $origen = $data["origen"];
        $fe1 = $data["fe1"];
        $fe2 = $data["fe2"];
        if( strlen($origen)>0)
        {
            $sql="SELECT c.idFileTuua, c.nombreArchivo, c.nroVuelo, c.fecVueloTip, c.aeroEmbarque, p.destinoPax, c.IdManifiesto,
            (SELECT COUNT(*) FROM tuuaPasajerosFile WHERE idFileTuua=c.idFileTuua and estado=1) Pax, e.nombre as Estado, c.Estado as nEstado,
            STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') Fecha,c.horaCierrePuerta,c.horaCierreDespegue,c.horaLlegadaDestino,c.matriculaAvion
            FROM tuuaCabeceraFile c
            LEFT JOIN tuuaPasajerosFile p ON c.idFileTuua=p.idFileTuua
            LEFT JOIN tuuaEstados e on e.estado = c.Estado
            WHERE STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') >=:fecVueloTip AND  STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') <=:fecVueloTip2 and c.aeroEmbarque=:aeroEmbarque and e.estado<>3 GROUP BY 1 ORDER BY 11, 3";
            $response = $this->executeQuery( $sql,array("fecVueloTip"=>$fe1,"fecVueloTip2"=>$fe2,"aeroEmbarque"=>$origen) );
        }
        else
        {
            $sql="SELECT c.idFileTuua, c.nombreArchivo, c.nroVuelo, c.fecVueloTip, c.aeroEmbarque, p.destinoPax, c.IdManifiesto,
            (SELECT COUNT(*) FROM tuuaPasajerosFile WHERE idFileTuua=c.idFileTuua and estado=1) Pax, e.nombre as Estado, c.Estado as nEstado,
            STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') Fecha,c.horaCierrePuerta,c.horaCierreDespegue,c.horaLlegadaDestino,c.matriculaAvion
            FROM tuuaCabeceraFile c
            LEFT JOIN tuuaPasajerosFile p ON c.idFileTuua=p.idFileTuua
            LEFT JOIN tuuaEstados e on e.estado = c.Estado
            WHERE STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') >=:fecVueloTip AND  STR_TO_DATE(c.fecVueloTip,'%d/%m/%Y') <=:fecVueloTip2 and e.estado<>3 GROUP BY 1 ORDER BY 11, 3";
            $response = $this->executeQuery( $sql,array("fecVueloTip"=>$fe1,"fecVueloTip2"=>$fe2) );
        }


        return $response;
    }
    public function EliminarManifiesto($idTuuaFile){
        if (!$sql = $this->updateData("tuuaCabeceraFile", array("Estado"=>3), array("idFileTuua"=>$idTuuaFile))) {
            return false;
        }
        echo "El manifiesto ha sido eliminado.";
        return true;
    }
    public function ListarCabeceraTuua($idFileTuua){
        $cabecera="SELECT idFileTuua,fecVueloTip,aeroEmbarque,nombreArchivo,nroVuelo,matriculaAvion,Estado FROM tuuaCabeceraFile  WHERE idFileTuua=:idFileTuua";
        $cabecera= $this->executeQuery( $cabecera,array("idFileTuua"=>$idFileTuua) );
        return $cabecera;
    }
    public function ListarPasajero($idFileTuua){
        $pasajeros="SELECT idItensPax,nroTicketPax,apellidoPax,nombrePax,tipoPax,foidPax,destinoPax,clasePax,nroCuponPax,nroReferencia,nroAsientoPax,nroDoc,nacPax,tres,Estado FROM tuuaPasajerosFile  WHERE idFileTuua=:idFileTuua and estado=:estado";
        $pasajeros= $this->executeQuery( $pasajeros,array("idFileTuua"=>$idFileTuua,"estado"=>1) );
        return $pasajeros;
    }
    public function UpdatePasajero($id,$values){

        if (!$sql = $this->updateData("tuuaPasajerosFile",$values, array("idItensPax"=>$id))) {
            return false;
        }

        return true;
    }
    public function EliminarPasajero($idItensPax){
        if (!$sql = $this->updateData("tuuaPasajerosFile",array("estado" => "0","categoria_Pax" => "T"), array("idItensPax"=>$idItensPax))) {
            return false;
        }
        return true;
    }
    public function CrearPasajero($values) {
        $sql = $this->insertData("tuuaPasajerosFile",$values);
        return $sql;
    }
}