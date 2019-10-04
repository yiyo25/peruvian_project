<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('human_file_size')) {

    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function human_file_size($bytes, $decimals = 2) {
        $sz = 'BKMGTPE';
        $factor = (int) floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $sz[$factor];
    }

}

if (!function_exists('in_arrayi')) {

    /**
     * Checks if a value exists in an array in a case-insensitive manner
     *
     * @param mixed $needle
     * The searched value
     *
     * @param $haystack
     * The array
     *
     * @param bool $strict [optional]
     * If set to true type of needle will also be matched
     *
     * @return bool true if needle is found in the array,
     * false otherwise
     */
    function in_arrayi($needle, $haystack, $strict = false) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack), $strict);
    }

}

if (!function_exists('clean')) {

    function clean($string) {
        $table = array(
            '?' => 'S', '?' => 's', '?' => 'Dj', '?' => 'dj', '?' => 'Z',
            '?' => 'z', '?' => 'C', '?' => 'c', '?' => 'C', '?' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', '?' => 'R', '?' => 'r', 'ü' => 'u', 'º' => '',
            'ª' => '',
        );
        $string = strtr($string, $table);
        return $string;
    }

}

if (!function_exists('buildTree')) {

    function buildTree($elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if (count($children) > 0) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

}

if (!function_exists('toJson')) {

    function toJson($dados, $charset = 'UTF-8') {
        header('Content-Type: application/json');
        if ($charset <> 'UFT-8') {
            array_walk_recursive($dados, function(&$value, $key) {
                if (is_string($value)) {
                    $value = utf8_encode(clean($value));
                }
            });
        }
        return json_encode($dados);
    }

}


if (!function_exists('formatoFecha')) {

    function formatoFecha($fecha, $tipo) {
        if ($tipo == 'BDaP') {//Base de Datos a Programacion
            $arrayFecha = explode('-', $fecha);
            $nuevaFecha = $arrayFecha[2] . '/' . $arrayFecha[1] . '/' . $arrayFecha[0];
        } elseif ($tipo == 'PaBD') {
            $arrayFecha = explode('/', $fecha);
            $nuevaFecha = $arrayFecha[2] . '-' . $arrayFecha[1] . '-' . $arrayFecha[0];
        }
        return $nuevaFecha;
    }

}
/*
 * * Nombre de Día V2
 */
if (!function_exists('nombreDia')) {

    function nombreDia($dia, $tipo) {
        $fecha = $dia;
        $fechats = strtotime($fecha);
        if ($tipo == 'S') {
            switch (date('w', $fechats)) {
                case 0:
                    return 'D';
                    break;
                case 1:
                    return 'L';
                    break;
                case 2:
                    return 'M';
                    break;
                case 3:
                    return 'X';
                    break;
                case 4:
                    return 'J';
                    break;
                case 5:
                    return 'V';
                    break;
                case 6:
                    return 'S';
                    break;
            }
        } elseif ($tipo == 'M') {
            switch (date('w', $fechats)) {
                case 0:
                    return 'DOM';
                    break;
                case 1:
                    return 'LUN';
                    break;
                case 2:
                    return 'MAR';
                    break;
                case 3:
                    return 'MIÉ';
                    break;
                case 4:
                    return 'JUE';
                    break;
                case 5:
                    return 'VIE';
                    break;
                case 6:
                    return 'SÁB';
                    break;
            }
        } elseif ($tipo == 'L') {
            switch (date('w', $fechats)) {
                case 0:
                    return 'DOMINGO';
                    break;
                case 1:
                    return 'LUNES';
                    break;
                case 2:
                    return 'MARTES';
                    break;
                case 3:
                    return 'MIÉRCOLES';
                    break;
                case 4:
                    return 'JUEVES';
                    break;
                case 5:
                    return 'VIERNES';
                    break;
                case 6:
                    return 'SÁBADO';
                    break;
            }
        }
    }

}
/*
 * * Nombre de Día V2
 */
if (!function_exists('nombreMes')) {

    function nombreMes($periodo) {
        $dataPerido = explode('-', $periodo);
        $mes = $dataPerido[1];
        switch ($mes) {
            case 1:
                return 'Enero';
                break;
            case 2:
                return 'Febrero';
                break;
            case 3:
                return 'Marzo';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Mayo';
                break;
            case 6:
                return 'Junio';
                break;
            case 7:
                return 'Julio';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Septiembre';
                break;
            case 10:
                return 'Octubre';
                break;
            case 11:
                return 'Noviembre';
                break;
            case 12:
                return 'Diciembre';
                break;
        }
    }

}
/*
 * * Horas a Minutos
 */
if (!function_exists('horaMinuto')) {

    function horaMinuto($hora) {
        $datoHora = explode(':', $hora);
        $HHora = $datoHora[0] * 60;
        $MHora = $datoHora[1];
        return $HHora + $MHora;
    }

}
/*
 * * Minutos a Horas
 */
if (!function_exists('minutoHora')) {

    function minutoHora($hora) {
        $HHora = str_pad(intval($hora / 60), 2, '0', STR_PAD_LEFT);
        $MHora = str_pad($hora % 60, 2, '0', STR_PAD_LEFT);
        return $HHora . ':' . $MHora;
    }

}
if (!function_exists('diasPeriodo')) {

    function diasPeriodo($periodo) {
        $partePeriodo = explode('-', $periodo);
        $mes = $partePeriodo[1];
        $ano = $partePeriodo[0];
        return date("d", mktime(0, 0, 0, $mes + 1, 0, $ano));
    }

}
if (!function_exists('arraydiasPeriodo')) {

    function arraydiasPeriodo($periodo) {
        $dias = diasPeriodo($periodo);
        for ($d = 1; $d <= $dias; $d++) {
            $fecha = $periodo . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);
            $arrayDias[$fecha] = array(
                'dia' => str_pad($d, 2, '0', STR_PAD_LEFT),
                'nombre' => nombreDia($fecha, 'M')
            );
        }
        return $arrayDias;
    }

}
if (!function_exists('operacionesFecha')) {

    function operacionesFecha($fecha, $dias) {
        $nuevaFecha = date('Y-m-d', strtotime($dias . ' day', strtotime($fecha)));
        return $nuevaFecha;
    }

}
if (!function_exists('operacionesPeriodo')) {

    function operacionesPeriodo($periodo, $Nmes) {
        $dataPeriodo = explode('-', $periodo);
        $ano = $dataPeriodo[0];
        $mes = $dataPeriodo[1];
        if ($Nmes[0] == '-') {
            if ($mes > 1) {
                $mesResultado = $mes - 1;
                $anoResultado = $ano;
            } else {
                $mesResultado = '12';
                $anoResultado = $ano - 1;
            }
        } else {
            if ($mes < 12) {
                $mesResultado = $mes + 1;
                $anoResultado = $ano;
            } else {
                $mesResultado = '01';
                $anoResultado = $ano + 1;
            }
        }
        return $anoResultado . '-' . str_pad($mesResultado, 2, '0', STR_PAD_LEFT);
    }

}
/*
 * * Hora Proxima Salida
 */
if (!function_exists('horaProximaSalida')) {

    function horaProximaSalida($arrayValores, $TV, $HF) {
        $TransIda = horaMinuto($arrayValores['TIda']);
        //$TransRet	=	horaMinuto($arrayValores['TRetor']);
        $CheckIn = horaMinuto($arrayValores['Chkin']);
        $CheckOut = horaMinuto($arrayValores['Chkout']);
        $HMax = horaMinuto($arrayValores['HMax']);
        $DMin = horaMinuto($arrayValores['DMin']);
        $HDia = horaMinuto('24:00');
        if ((2 * $TV) <= $HMax) {
            $tD = $DMin;
        } else {
            $tD = (2 * $TV);
        }
        $mps = $TransIda + $CheckIn + $CheckOut + $tD + $HF;
        /* if($mps<=$HDia){
          $hps	=	$mps;
          }else{
          $hps	=	$mps-$HDia;
          } */
        //echo minutoHora($mps).' '.minutoHora($HDia).' '.minutoHora($hps).'<---';
        return minutoHora($mps);
    }

}
if (!function_exists('interval_date')) {

    function interval_date($init, $finish) {
        $date = new DateTime($init); // Fecha actual
        $date2 = new DateTime($finish); // Segunda fecha
        $interval = $date->diff($date2); // Restamos la Fecha1 menos la Fecha2		 
        return $interval->format('%a dias'); // Mostramos el resultado
    }

}
if (!function_exists('restaHoras')) {

    function restaHoras($hmenor, $hmayor) {
        $dif = date("H:i", strtotime("00:00") + strtotime($hmenor) - strtotime($hmayor));
        return $dif;
    }

}
if (!function_exists('sumaHoras')) {

    function sumaHoras($h1, $h2) {
        $sum = date("H:i", strtotime($h1) + strtotime($h2) - strtotime("00:00"));
        return $sum;
    }

}
if (!function_exists('sumaHoras24')) {

    function sumaHoras24($h1, $h2) {
        $dataH1 = explode(':', $h1);
        $dataH2 = explode(':', $h2);
        $h1 = $dataH1[0];
        $m1 = $dataH1[1];
        $h2 = $dataH2[0];
        $m2 = $dataH2[1];
        $sumaM = $m1 + $m2;
        $sumaH = $h1 + $h2;
        if ($sumaM >= 60) {
            $AH = 1;
            $M = $sumaM - 60;
        } else {
            $AH = 0;
            $M = $sumaM;
        }
        $H = $AH + $sumaH;
        return str_pad($H, 2, '0', STR_PAD_LEFT) . ':' . str_pad($M, 2, '0', STR_PAD_LEFT);
    }

}

if (!function_exists('diaSemana')) {

    function diaSemana($dia) {
        switch ($dia) {
            case 1: return "LU";
                break;
            case 2: return "MA";
                break;
            case 3: return "MI";
                break;
            case 4: return "JU";
                break;
            case 5: return "VI";
                break;
            case 6: return "SA";
                break;
            case 7: return "DO";
                break;
        }
    }

}

if (!function_exists('string_sanitize')) {

    function string_sanitize($string, $force_lowercase = true, $anal = false) {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", "<", ">", "/", "?", "-");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        //$clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
                (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
                $clean;
    }

}


if (!function_exists('data_last_month_day')){
    function data_last_month_day() { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }
}

if (!function_exists('data_first_month_day')){
  
  function data_first_month_day() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
}
