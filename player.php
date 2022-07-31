<?php


//  Consumir API de jugadores
$dataCpkUrea = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evalspereitem.php?uid=F1115&iid=" . $idPlayer . "&eid=40");
//  Decodificar la data que viene en formato json
$json_dataCpkUrea = json_decode($dataCpkUrea, true);

## Algoritmo para formatear los datos para la gráfica de tiempo
function getTimeDataSeriesCPK($json_data)
{
    $data = array();
    foreach ($json_data as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    $obj['conf_date'] = rtrim($splitFecha[0]);
                    $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                    array_push($data, $obj);
                }
            }
        }
    }
    $series = array();
    $cont = 0;

    $series[0]['name'] = "Player Data";
    foreach ($data as $arrayValores) {
        $series[0]['data'][$cont] = array();
        foreach ($arrayValores as $k => $v) {
            array_push($series[0]['data'][$cont], $v);
        }
        $cont++;
    }

    return $series = json_encode($series);
}

## Algoritmo para formatear los datos para la gráfica de tiempo
function getTimeDataSeriesUrea($json_data)
{
    $data = array();
    foreach ($json_data as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    $obj['conf_date'] = rtrim($splitFecha[0]);
                    $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                    array_push($data, $obj);
                }
            }
        }
    }
    $series = array();
    $cont = 0;

    $series[0]['name'] = "Player Data";
    foreach ($data as $arrayValores) {
        $series[0]['data'][$cont] = array();
        foreach ($arrayValores as $k => $v) {
            array_push($series[0]['data'][$cont], $v);
        }
        $cont++;
    }

    return $series = json_encode($series);
}


## Algoritmo para formatear los datos para la gráfica de tiempo
function getCpkVsUrea($json_data)
{
    $data = array();
    foreach ($json_data as $jugador) {
        $cpkUreaValues = array();
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                    $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                    array_push($cpkUreaValues, $obj);
                }
            }
        }
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                    $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                    array_push($cpkUreaValues, $obj);
                }
            }
        }
        array_push($data, $cpkUreaValues);
    }
    $series = array();
    $cont = 0;

    $series[0]['name'] = "Player Data";
    $series[0]['color'] = "rgba(223, 83, 83, .5)";
    foreach ($data as $arrayUreaCpkValues) {
        $series[0]['data'][$cont] = array();
        foreach ($arrayUreaCpkValues as $arrayValues) {
            foreach ($arrayValues as $v) {
                array_push($series[0]['data'][$cont], $v);
            }
        }
        $cont++;
    }

    return $series = json_encode($series);
}
