<?php 
require_once("../app/Database.php");
require_once("../app/Model.php");
require_once("../app/Config.php");
require_once("../app/Datos.php");
require_once("../Models/EnviarTuaDAO.php");

$objEnviarTUUA = new EnviarTuaDAO();
try {
    $da = new Datos();

    $data = $objEnviarTUUA->ObtenerInfoCorreoVueloCheckIn("");
    echo "<pre>".print_r($data,true)."</pre>";
    if (!empty($data["nroCorreosEliminar"])) {
        $cabecera = $objEnviarTUUA->insertarCabecera("", "", "", "", "", "", "", $data["cabecera"]);
        $detalle = $objEnviarTUUA->insertpasajeroprueba($cabecera["arrIdFileTuua"], $data["grupo_boletos"]);
        if ($cabecera) {
            if (!$da->EjecutarDatosNuevo($detalle["sql"])) {
                throw new Exception("Ha habido un problema con la inserción Detalle");
            }
            //eliminar correos
            $idFileTuua = $cabecera["arrIdFileTuua"]["firstIdFileTuua"];
            foreach ($data["cabecera"] as $value) {
                $reprocesar = send_adp_http($idFileTuua, $value["origen"]);
                $idFileTuua++;
            }
            if ($reprocesar) {
                $objEnviarTUUA->eliminar_correos_leidos($data["nroCorreosEliminar"]);
            }
        } else {
            throw new Exception("Ha habido un problema en la inserción de la Cabecera");
        }
    }else{
        echo "no hay correos para insertar o eliminar, proceso cancelado";
    }
} catch (Exception $error) {
    echo $error;
}
function send_adp_http($id_file,$embarque)
{
    $postdata = http_build_query( array( 'flag' => "Reprocesar", 'id_file' => $id_file,'embarque' => $embarque));
    $opts = array('http' => array( 'method'  => 'POST', 'header'  => 'Content-Type: application/x-www-form-urlencoded', 'content' => $postdata));
    $context  = stream_context_create($opts);
    //desarrollo
    //$result = file_get_contents('https://dev.peruvian.pe/intranet/tuua_application/controller/AdpController.php', false, $context);
    //producción
    $result = file_get_contents(BASE_URL.'Controller/AdpController.php', false, $context);
    print_r($result);
    return true;
}


/*
$demo = $objEnviarTUUA->ObtenerInfoCorreoVueloCheckIn('body');
echo "<pre>".print_r($demo,true)."</pre>";*/
?>