<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
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
                <!-- GRAFICAS MICROPROJECT 2 -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Ver Gráficas</a></li>
                    </ul>
                </div>
                <!-- CARGAR ARCHIVO DE CONFIGURACION -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="cargarArchivo.php">Cargar Archivo</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <form action="" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <label for="customRange" class="form-label">ID Player</label>
                        <input type="range" name="customRange" id="customRange" class="form-range" min="287" max="316" value="287" onchange="document.getElementById('rangeValue').value=value" />
                        <input type="text" id="rangeValue" name="rangeValue" for="customRange" value="287" disabled="true">
                        <button type="submit">Buscar</button>
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
            </div>
        </div>

        <?php
        //Assign the value to 287 or the value defined in the $_POST variable.
        $idPlayer = 288;
        if (isset($_POST['customRange'])) {
            $idPlayer =  $_POST['customRange'];
        }

        require_once('player.php');
        require_once('cargarGraficas.php');

        time_chart("timePlotCPK", "CPK Data Time Chart", getTimeDataSeriesCPK($json_dataCpkUrea));
        time_chart("timePlotUrea", "Urea Data Time Chart", getTimeDataSeriesUrea($json_dataCpkUrea));
        scatter_chart("scatterPlotUreaVsCpk","Urea VS CPK", getCpkVsUrea($json_dataCpkUrea));

        ?>
    </div>
</body>

</html>