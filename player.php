<?php

//  Consumir API de jugadores
$data_api_jugadores = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evitems.php?&eboxid=89");
//  Decodificar la data que viene en formato json
$json_data_api_jugadores = json_decode($data_api_jugadores, true);

//  Consumir API de jugadores
$dataCpkUrea = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evalspereitem.php?uid=F1115&iid=" . $idPlayer . "&eid=40");
//  Decodificar la data que viene en formato json
$json_dataCpkUrea = json_decode($dataCpkUrea, true);

function getJsonDataPlayer($id)
{
    $playerData = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evalspereitem.php?uid=F1115&iid=" . $id . "&eid=40");
    return json_decode($playerData, true);
}

function getPlayersNamesAndId($json_data)
{
    $playersNamesAndId = array();
    foreach ($json_data as $jugador) {
        if (!empty($jugador['valores'][0]['value']) && !empty($jugador['valores'][1]['value']) && !empty($jugador['id'])) {
            $playerData = array();
            $playerData['id'] = $jugador['id'];
            $playerData['fullName'] = $jugador['valores'][0]['value'] . " " . $jugador['valores'][1]['value'];
            array_push($playersNamesAndId, $playerData);
        }
    }
    return $playersNamesAndId;
}

function getPlayerName($json_data, $playerId)
{
    foreach ($json_data as $jugador) {
        if (!empty($jugador['id']) && !empty($jugador['valores'][0]['value']) && strcmp($jugador['id'], $playerId) == 0) {
            return $jugador['valores'][0]['value'];
        }
    }
}

function isDateBetweenRange($dateDesde, $dateHasta, $date)
{
    $since = new DateTime($dateDesde);
    $dateToCompare = new DateTime($date);
    $until = new DateTime($dateHasta);

    if ($dateToCompare >= $since && $dateToCompare <= $until) {
        return true;
    }

    return false;
}

## Algoritmo para formatear los datos para la gráfica de tiempo
function getTimeDataSeriesCPK($api_jugadores, $dataCpkUrea, $playerId, $dateDesde, $dateHasta)
{
    $data = array();
    foreach ($dataCpkUrea as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                        $obj['conf_date'] = rtrim($splitFecha[0]);
                        $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                        array_push($data, $obj);
                    }
                }
            }
        }
    }
    $series = array();
    $cont = 0;

    if (!empty($data)) {
        $series[0]['name'] = getPlayerName($api_jugadores, $playerId);
        foreach ($data as $arrayValores) {
            $series[0]['data'][$cont] = array();
            foreach ($arrayValores as $k => $v) {
                array_push($series[0]['data'][$cont], $v);
            }
            $cont++;
        }
    }
    return $series = json_encode($series);
}

## Algoritmo para formatear los datos para la gráfica de tiempo comparando jugadores
function getTimeDataSeriesCPKComparePlayers($api_jugadores, $selectedPlayers, $dateDesde, $dateHasta)
{
    $allData = array();

    foreach ($selectedPlayers as $playerId) {
        if (!empty($playerId)) {
            $data = array();
            $json_data = getJsonDataPlayer($playerId);
            foreach ($json_data as $jugador) {
                for ($i = 0; $i < sizeof($jugador); $i++) {
                    if (!empty($jugador[$i]['conf_criteria'])) {
                        if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                            $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                            if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                                $obj['conf_date'] = rtrim($splitFecha[0]);
                                $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                                array_push($data, $obj);
                            }
                        }
                    }
                }
            }
            array_push($allData, $data);
        }
    }

    $series = array();
    $cont = 0;
    $cont2 = 0;

    if (!empty($allData)) {
        foreach ($allData as $data) {
            if (!empty($data)) {
                $series[$cont2]['name'] = getPlayerName($api_jugadores, $selectedPlayers[$cont2]);
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
        }
    }

    return $series = json_encode($series);
}

## Algoritmo para formatear los datos para la gráfica de tiempo
function getTimeDataSeriesUrea($api_jugadores, $json_data, $playerId, $dateDesde, $dateHasta)
{
    $data = array();
    foreach ($json_data as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                        $obj['conf_date'] = rtrim($splitFecha[0]);
                        $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                        array_push($data, $obj);
                    }
                }
            }
        }
    }
    $series = array();
    $cont = 0;

    if (!empty($data)) {
        $series[0]['name'] = getPlayerName($api_jugadores, $playerId);
        foreach ($data as $arrayValores) {
            $series[0]['data'][$cont] = array();
            foreach ($arrayValores as $k => $v) {
                array_push($series[0]['data'][$cont], $v);
            }
            $cont++;
        }
    }

    return $series = json_encode($series);
}


## Algoritmo para formatear los datos para la gráfica de tiempo comparando jugadores
function getTimeDataSeriesUreaComparePlayers($api_jugadores, $selectedPlayers, $dateDesde, $dateHasta)
{
    $allData = array();

    foreach ($selectedPlayers as $playerId) {
        if (!empty($playerId)) {
            $json_data = getJsonDataPlayer($playerId);
            $data = array();
            foreach ($json_data as $jugador) {
                for ($i = 0; $i < sizeof($jugador); $i++) {
                    if (!empty($jugador[$i]['conf_criteria'])) {
                        if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                            $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                            if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                                $obj['conf_date'] = rtrim($splitFecha[0]);
                                $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                                array_push($data, $obj);
                            }
                        }
                    }
                }
            }
            array_push($allData, $data);
        }
    }

    $series = array();
    $cont = 0;
    $cont2 = 0;

    if (!empty($allData)) {
        foreach ($allData as $data) {
            if (!empty($data)) {
                $series[$cont2]['name'] = getPlayerName($api_jugadores, $selectedPlayers[$cont2]);
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
        }
    }

    return $series = json_encode($series);
}


## Algoritmo para formatear los datos para la gráfica de distribución Urea VS CPK
function getCpkVsUrea($api_jugadores, $json_data, $playerId, $dateDesde, $dateHasta)
{
    $data = array();
    foreach ($json_data as $jugador) {
        $cpkUreaValues = array();
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                        $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                        array_push($cpkUreaValues, $obj);
                    }
                }
            }
        }
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                        $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                        array_push($cpkUreaValues, $obj);
                    }
                }
            }
        }
        array_push($data, $cpkUreaValues);
    }
    $series = array();
    $cont = 0;

    $series[0]['name'] = getPlayerName($api_jugadores, $playerId);
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
function getCpkVsUreaComparePlayers($api_jugadores, $selectedPlayers, $dateDesde, $dateHasta)
{
    $allData = array();

    foreach ($selectedPlayers as $playerId) {
        if (!empty($playerId)) {
            $json_data = getJsonDataPlayer($playerId);
            $data = array();
            foreach ($json_data as $jugador) {
                $cpkUreaValues = array();
                for ($i = 0; $i < sizeof($jugador); $i++) {
                    if (!empty($jugador[$i]['conf_criteria'])) {
                        if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                            $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                            if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                                $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                                array_push($cpkUreaValues, $obj);
                            }
                        }
                    }
                }
                for ($i = 0; $i < sizeof($jugador); $i++) {
                    if (!empty($jugador[$i]['conf_criteria'])) {
                        if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                            $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                            if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                                $obj['conf_value'] = round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2);
                                array_push($cpkUreaValues, $obj);
                            }
                        }
                    }
                }
                array_push($data, $cpkUreaValues);
            }
            array_push($allData, $data);
        }
    }

    $series = array();
    $cont = 0;
    $cont2 = 0;
    $rojo = "rgba(223, 83, 83, .5)";
    $azul = "rgba(119, 152, 191, .5)";
    $verde = "rgba(117, 152, 117, .5)";

    foreach ($allData as $data) {
        $series[$cont2]['name'] = getPlayerName($api_jugadores, $selectedPlayers[$cont2]);
        if ($cont2 == 0) {
            $series[$cont2]['color'] = $rojo;
        } elseif ($cont2 == 1) {
            $series[$cont2]['color'] = $azul;
        } elseif ($cont2 == 2) {
            $series[$cont2]['color'] = $verde;
        } else {
            $series[$cont2]['color'] = "rgba(" . (1 + $cont2 * 2) . "," . (2 + $cont2 * 2) . "," . (3 + $cont2 * 2) . ")";
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
function getGaussianDataUrea($json_data, $dateDesde, $dateHasta)
{
    $data = array();
    foreach ($json_data as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("Urea")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                        array_push($data, round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2));
                    }
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

    return $series;
}

## Algoritmo para formatear los datos para la gráfica de Gausiana
function getGaussianDataCPK($json_data, $dateDesde, $dateHasta)
{
    $data = array();
    foreach ($json_data as $jugador) {
        for ($i = 0; $i < sizeof($jugador); $i++) {
            if (!empty($jugador[$i]['conf_criteria'])) {
                if (strcmp(strtoupper($jugador[$i]['conf_criteria']), strtoupper("CPK")) == 0) {
                    $splitFecha = explode(" ", rtrim(strtoupper($jugador[$i]['conf_date'])));
                    if (isDateBetweenRange($dateDesde, $dateHasta, rtrim($splitFecha[0]))) {
                        array_push($data, round(floatval(rtrim(strtoupper($jugador[$i]['conf_value']))), 2));
                    }
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

    return $series;
}

function getMedia($series)
{
    return round((array_sum($series) / count($series)), 2);
}

function getMediana($series)
{
    sort($series);
    if ((count($series) % 2) == 0) {
        return array_sum(array_slice($series, (count($series) / 2) - 1, 2)) / 2;
    } else {
        return array_slice($series, count($series) / 2, 1)[0];
    }
}

function getModa($series)
{
    $seriesInString = array();
    foreach ($series as $serie) {
        array_push($seriesInString, strval($serie));
    }
    $datos = array_count_values($seriesInString);
    arsort($datos);

    $moda = array();
    $contador = 0;
    $frecuencia = 0;

    foreach ($datos as $key => $valor) {
        if ($valor >= $contador) {
            $moda[] = $key;
            $contador = $valor;
            $frecuencia = $valor;
        }
    }

    $tipoModa = "";
    if (count($moda) == 1) {
        $tipoModa = "Moda Modal";
    }
    if (count($moda) == 2) {
        $tipoModa = "Moda Bimodal";
    }
    if (count($moda) == count($datos)) {
        $tipoModa = "No Hay Moda";
    }
    if (count($moda) < count($datos) && count($moda) > 2) {
        $tipoModa = "Moda Multimodal";
    }

    if ($tipoModa != "No Hay Moda") {
        $result = $tipoModa . "<br/><b>";
        foreach ($moda as $valor) {
            $result = $result . " " . $valor;
        }
        $result = $result . "</b>";
        $result = $result . "<br/> Con frecuencia de " . $frecuencia . " apariciones";
        return $result;
    } else {
        return "No hay Moda";
    }
}

function getVarianza($series, $media)
{
    $sum2 = 0;
    for ($i = 0; $i < count($series); $i++) {
        $sum2 += ($series[$i] - $media) * ($series[$i] - $media);
    }
    $varianza = $sum2 / count($series);
    return round($varianza, 2);
}
