<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/histogram-bellcurve.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="mystyles.css">
</head>

<body>
    <!-- IMPORT SCRIPTS -->
    <script type="text/javascript" src="./timeIrregularIntervalsChart.js"></script>
    <script type="text/javascript" src="./scatterPlot.js"></script>

    <?php
    //Assign the value to 287 or the value defined in the $_POST variable.
    $idPlayer = 287;
    if (isset($_POST['selectPlayers'])) {
        $idPlayer =  $_POST['selectPlayers'];
    }

    require_once('player.php');
    require_once('cargarGraficas.php');
    ?>

    <div id="wrapper">
        <div class="container" style="margin-top:10px;">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.php">Análisis de Datos G302-2</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- GRAFICAS MICROPROJECT 2 -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Ver Gráficas</a></li>
                    </ul>
                    <!-- CARGAR ARCHIVO DE CONFIGURACION -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="cargarArchivo.php">Cargar Archivo</a></li>
                    </ul>
                    <!-- MULTIPLAYER -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="multiplayer.php">Multiplayer</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <form action="" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <select class="form-select" name="selectPlayers" id="selectPlayers" size="8" aria-label="size 3 select example">
                            <?php
                            $playersNamesAndId = getPlayersNamesAndId($json_data_api_jugadores);
                            $index = 0;
                            foreach ($playersNamesAndId as $playerData) {
                                if ($index == 0) {
                                    echo '<option selected value="' . $playerData['id'] . '">' . $playerData['fullName'] . '</option>';
                                } else {
                                    echo '<option value="' . $playerData['id'] . '">' . $playerData['fullName'] . '</option>';
                                }
                                $index++;
                            }
                            ?>
                        </select>
                    </div>
                    <!--<div class="col-3">
                        <label for="customRange" class="form-label">ID Player</label>
                        <input type="range" name="customRange" id="customRange" class="form-range" min="287" max="316" value="287" onchange="document.getElementById('rangeValue').value=value" />
                        <input type="text" id="rangeValue" name="rangeValue" for="customRange" value="287" disabled="true">
                    </div>-->
                    <div class="col-3">
                        <label for="dateDesde" class="form-label">Fecha Desde</label>
                        <input type="date" name="dateDesde" id="dateDesde" class="form-control" value="2017-01-01" min="2017-01-01" max="2017-12-31" />
                    </div>
                    <div class="col-3">
                        <label for="dateHasta" class="form-label">Fecha Hasta</label>
                        <input type="date" name="dateHasta" id="dateHasta" class="form-control" value="2017-01-01" min="2017-01-01" max="2017-12-31" />
                    </div>
                    <div class="col-3 d-flex align-items-center">
                        <button type="submit" id="buscar" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <figure class="highcharts-figure div-border-multiplayer">
                        <div id="timePlotCPK"></div>
                    </figure>
                </div>
                <div class="col-12">
                    <figure class="highcharts-figure div-border-multiplayer">
                        <div id="timePlotUrea"></div>
                    </figure>
                </div>
                <div class="col-12">
                    <figure class="highcharts-figure div-border-multiplayer">
                        <div id="scatterPlotUreaVsCpk"></div>
                    </figure>
                </div>
                <div class="col-6 div-border-multiplayer">
                    <figure class="highcharts-figure">
                        <div id="GaussianUrea"></div>
                    </figure>
                </div>
                <div class="col-6">
                    <figure class="highcharts-figure div-border-multiplayer">
                        <div id="GaussianCpk"></div>
                    </figure>
                </div>
            </div>
        </div>

        <?php
        time_chart("timePlotCPK", "CPK Data Time Chart", getTimeDataSeriesCPK($json_dataCpkUrea, $idPlayer), "CPK units/L");
        time_chart("timePlotUrea", "Urea Data Time Chart", getTimeDataSeriesUrea($json_dataCpkUrea, $idPlayer), "Urea mmol/L.");
        scatter_chart("scatterPlotUreaVsCpk", "Urea VS CPK", getCpkVsUrea($json_dataCpkUrea, $idPlayer));
        gaussian_chart("GaussianUrea", "Urea - " . getPlayerName($idPlayer), getGaussianDataUrea($json_dataCpkUrea), "Urea mmol/L", "Distribución Gaussiana");
        gaussian_chart("GaussianCpk", "CPK - " . getPlayerName($idPlayer), getGaussianDataCPK($json_dataCpkUrea), "CPK units/L", "Distribución Gaussiana");

        ?>
    </div>
</body>

</html>