<?php
//Almacenar archivo cargado
$lineas = readFromCsvFile("config-file.csv");

//Validar contenido archivo
if (!empty($lineas) & count($lineas) > 1) {
    $i = 0;
    $cabecera;
    $configs = array();
    foreach ($lineas as $linea) {

        if ($i == 0) {
            $cabecera = explode(";", $linea);
        } else {
            array_push($configs, explode(";", $linea));
        }
        $i++;
    }
    // Validar que sí haya configuraciones parametrizadas
    if (!empty($configs)) {

        // Get what and how to plot
        $what_plot = getArrayWhatPlot($configs);
        $how_plot = getArrayHowPlot($configs);

        // Get graph names
        $graph_names = getArrayGraphNames($configs);

        // Get grids
        $grids = getArrayGrids($configs);

        // Get rounded corners
        $rounded_corners = getArrayRoundedCorners($configs);

        // Get graph and table space
        $graph_table = getArrayGraphTable($configs);

        // Get data resolution
        $data_resolution = getArrayDataResolution($configs);

        // Get TABS
        $tabs = getArrayTabs($configs);

        // Get PopUp
        $popup = getArrayPopup($configs);
    }
}

//  Consumir API de jugadores
$data = file_get_contents("http://evalua.fernandoyepesc.com/04_Modules/11_Evalua/10_WS/ws_evitems.php?&eboxid=89");
//  Decodificar la data que viene en formato json
$json_data = json_decode($data, true);

/*
// Obtener nombres completos de los jugadores
$histogram_data = array();
$nombresJugadores = array();

foreach ($json_data as $jugador) {
    if (!empty($jugador['valores'][2]['value'])) {

        $fechaNacimiento = explode(" ", $jugador['valores'][2]['value']);

        $edad = substr($fechaNacimiento[1], 1);

        array_push($histogram_data, $edad);

        $nombreCompleto = $jugador['valores'][0]['value'] . " " . $jugador['valores'][1]['value'];

        array_push($nombresJugadores, $nombreCompleto);
    }
}

// Formatear la data para el histograma
$series_edades_jugadores = get_histogram_series($json_data, $histogram_data, $nombresJugadores);
*/
