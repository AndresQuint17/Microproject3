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
                        <li class="nav-item"><a class="nav-link" href="microproject3.php">Singleplayer</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <form action="" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <div class="input-group">
                            <span class="input-group-text">First Player - Second Player - Third Player</span>
                            <input type="text" id="firstPlayer" name="firstPlayer" aria-label="First player" class="form-control">
                            <input type="text" id="secondPlayer" name="secondPlayer" aria-label="Second player" class="form-control">
                            <input type="text" id="thirdPlayer" name="thirdPlayer" aria-label="Third player" class="form-control">
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <button type="submit" id="comparar" class="btn btn-primary">Comparar</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <figure class="highcharts-figure">
                        <div id="timePlotCPK"></div>
                    </figure>
                </div>
                <div class="col-12">
                    <figure class="highcharts-figure">
                        <div id="timePlotUrea"></div>
                    </figure>
                </div>
                <div class="col-12">
                    <figure class="highcharts-figure">
                        <div id="scatterPlotUreaVsCpk"></div>
                    </figure>
                </div>
                <div class="col-6">
                    <figure class="highcharts-figure">
                        <div id="GaussianUrea"></div>
                    </figure>
                </div>
                <div class="col-6">
                    <figure class="highcharts-figure">
                        <div id="GaussianCpk"></div>
                    </figure>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST['firstPlayer'])) {
            //print_r($_POST);
            $idPlayer =  $_POST['firstPlayer'];

            require_once('player.php');
            require_once('cargarGraficas.php');

            time_chart_compare_players("timePlotCPK", "CPK Data Time Chart", getTimeDataSeriesCPKComparePlayers($_POST['firstPlayer'], $_POST['secondPlayer'], $_POST['thirdPlayer']), "CPK units/L");
            time_chart_compare_players("timePlotUrea", "Urea Data Time Chart", getTimeDataSeriesUreaComparePlayers($_POST['firstPlayer'], $_POST['secondPlayer'], $_POST['thirdPlayer']), "Urea mmol/L.");
            scatter_chart("scatterPlotUreaVsCpk", "Urea VS CPK", getCpkVsUreaComparePlayers($_POST['firstPlayer'], $_POST['secondPlayer'], $_POST['thirdPlayer']));
            //gaussian_chart("GaussianUrea", "Urea", getGaussianDataUreaComparePlayers($_POST['firstPlayer'], $_POST['secondPlayer'], $_POST['thirdPlayer']), "Urea mmol/L", "Distribución Gaussiana");
            //gaussian_chart("GaussianCpk", "CPK", getGaussianDataCPKComparePlayers($_POST['firstPlayer'], $_POST['secondPlayer'], $_POST['thirdPlayer']), "CPK units/L", "Distribución Gaussiana");
        }
        ?>
    </div>
</body>

</html>