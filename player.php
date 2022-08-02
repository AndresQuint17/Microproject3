<?php


//  Consumir API de jugadores
$dataCpkUrea = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evalspereitem.php?uid=F1115&iid=" . $idPlayer . "&eid=40");
//  Decodificar la data que viene en formato json
$json_dataCpkUrea = json_decode($dataCpkUrea, true);

function getJsonDataPlayer($id)
{
    $playerData = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evalspereitem.php?uid=F1115&iid=" . $id . "&eid=40");
    return json_decode($playerData, true);
}

function getPlayerName($playerId)
{
    //  Consumir API de jugadores
    $jugadores = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evitems.php?&eboxid=89");
    //  Decodificar la data que viene en formato json
    $json_data = json_decode($jugadores, true);
    foreach ($json_data as $jugador) {
        if (!empty($jugador['id']) && !empty($jugador['valores'][0]['value']) && strcmp($jugador['id'], $playerId)==0) {
            return $jugador['valores'][0]['value'];
        }
    }
}

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

## Algoritmo para formatear los datos para la gráfica de tiempo comparando jugadores
function getTimeDataSeriesCPKComparePlayers($idPlayer1, $idPlayer2, $idPlayer3)
{
    $allData = array();

    if (!empty($idPlayer1)) {
        $data = array();
        $json_data = getJsonDataPlayer($idPlayer1);
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
        array_push($allData, $data);
    }
    if (!empty($idPlayer2)) {
        $data = array();
        $json_data = getJsonDataPlayer($idPlayer2);
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
        array_push($allData, $data);
    }
    if (!empty($idPlayer3)) {
        $data = array();
        $json_data = getJsonDataPlayer($idPlayer3);
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
        array_push($allData, $data);
    }

    $series = array();
    $cont = 0;
    $cont2 = 0;

    foreach ($allData as $data) {
        if($cont2==0){
            $series[$cont2]['name'] = getPlayerName($idPlayer1);
        } elseif ($cont2==1){
            $series[$cont2]['name'] = getPlayerName($idPlayer2);
        } elseif ($cont2==2){
            $series[$cont2]['name'] = getPlayerName($idPlayer3);
        }
        foreach ($data as $arrayValores) {
            $series[$cont2]['data'][$cont] = array();
            foreach ($arrayValores as $k => $v) {
                array_push($series[$cont2]['data'][$cont], $v);
            }
            $cont++;
        }
        $cont = 0;
        $cont2++;
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


## Algoritmo para formatear los datos para la gráfica de tiempo comparando jugadores
function getTimeDataSeriesUreaComparePlayers($idPlayer1, $idPlayer2, $idPlayer3)
{
    $allData = array();

    if (!empty($idPlayer1)) {
        $json_data = getJsonDataPlayer($idPlayer1);
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
        array_push($allData, $data);
    }
    if (!empty($idPlayer2)) {
        $json_data = getJsonDataPlayer($idPlayer2);
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
        array_push($allData, $data);
    }
    if (!empty($idPlayer3)) {
        $json_data = getJsonDataPlayer($idPlayer3);
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
        array_push($allData, $data);
    }

    $series = array();
    $cont = 0;
    $cont2 = 0;

    foreach ($allData as $data) {
        if($cont2==0){
            $series[$cont2]['name'] = getPlayerName($idPlayer1);
        } elseif ($cont2==1){
            $series[$cont2]['name'] = getPlayerName($idPlayer2);
        } elseif ($cont2==2){
            $series[$cont2]['name'] = getPlayerName($idPlayer3);
        }
        foreach ($data as $arrayValores) {
            $series[$cont2]['data'][$cont] = array();
            foreach ($arrayValores as $k => $v) {
                array_push($series[$cont2]['data'][$cont], $v);
            }
            $cont++;
        }
        $cont = 0;
        $cont2++;
    }

    return $series = json_encode($series);
}


## Algoritmo para formatear los datos para la gráfica de distribución Urea VS CPK
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


## Algoritmo para formatear los datos para la gráfica de distribución Urea VS CPK comparando jugadores
function getCpkVsUreaComparePlayers($idPlayer1, $idPlayer2, $idPlayer3)
{
    $allData = array();

    if (!empty($idPlayer1)) {
        $json_data = getJsonDataPlayer($idPlayer1);
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
        array_push($allData, $data);
    }
    if (!empty($idPlayer2)) {
        $json_data = getJsonDataPlayer($idPlayer2);
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
        array_push($allData, $data);
    }
    if (!empty($idPlayer3)) {
        $json_data = getJsonDataPlayer($idPlayer3);
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
        array_push($allData, $data);
    }

    $series = array();
    $cont = 0;
    $cont2 = 0;
    $rojo = "rgba(223, 83, 83, .5)";
    $azul = "rgba(119, 152, 191, .5)";
    $verde = "rgba(117, 152, 117, .5)";

    foreach ($allData as $data) {
        if($cont2==0){
            $series[$cont2]['name'] = getPlayerName($idPlayer1);
        } elseif ($cont2==1){
            $series[$cont2]['name'] = getPlayerName($idPlayer2);
        } elseif ($cont2==2){
            $series[$cont2]['name'] = getPlayerName($idPlayer3);
        }
        if ($cont2 == 0) {
            $series[$cont2]['color'] = $rojo;
        } elseif ($cont2 == 1) {
            $series[$cont2]['color'] = $azul;
        } else {
            $series[$cont2]['color'] = $verde;
        }
        foreach ($data as $arrayUreaCpkValues) {
            $series[$cont2]['data'][$cont] = array();
            foreach ($arrayUreaCpkValues as $arrayValues) {
                foreach ($arrayValues as $v) {
                    array_push($series[$cont2]['data'][$cont], $v);
                }
            }
            $cont++;
        }
        $cont = 0;
        $cont2++;
    }

    return $series = json_encode($series);
}

## Algoritmo para formatear los datos para la gráfica de Gausiana
function getGaussianDataUrea($json_data)
{
    $data = array();
    foreach ($json_data as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                    array_push($data, round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2));
                }
            }
        }
    }
    $series = array();
    $cont = 0;
    foreach ($data as $v) {
        array_push($series, $v);
        $cont++;
    }

    return $series = json_encode($series);
}

## Algoritmo para formatear los datos para la gráfica de Gausiana
function getGaussianDataCPK($json_data)
{
    $data = array();
    foreach ($json_data as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                    array_push($data, round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2));
                }
            }
        }
    }
    $series = array();
    $cont = 0;
    foreach ($data as $v) {
        array_push($series, $v);
        $cont++;
    }

    return $series = json_encode($series);
}
