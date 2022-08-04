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
    $idPlayer = 287;
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
                        <li class="nav-item"><a class="nav-link" href="microproject3.php">Singleplayer</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <form action="" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <select class="form-select" name="selectPlayers[]" id="selectPlayers" multiple size="8" aria-label="size 3 multiple select example">
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
                    <div class="col-2">
                        <label for="dateDesde" class="form-label">Fecha Desde</label>
                        <input type="date" name="dateDesde" id="dateDesde" class="form-control" value="2017-01-01" min="2017-01-01" max="2017-12-31" />
                    </div>
                    <div class="col-2">
                        <label for="dateHasta" class="form-label">Fecha Hasta</label>
                        <input type="date" name="dateHasta" id="dateHasta" class="form-control" value="2017-01-01" min="2017-01-01" max="2017-12-31" />
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
                <?php
                if (isset($_POST['selectPlayers']) && isset($_POST['dateDesde']) && isset($_POST['dateHasta'])) {
                    foreach ($_POST['selectPlayers'] as $id) {
                        echo '<div class="col-6">
                        <div class="row div-border-multiplayer">
                            <div class="col-12">
                                <figure class="highcharts-figure">
                                    <div id="GaussianUrea' . $id . '"></div>
                                </figure>
                            </div>';
                            $seriesGaussianUrea = getGaussianDataUrea($json_dataCpkUrea, $_POST['dateDesde'], $_POST['dateHasta']);
                            gaussian_chart("GaussianUrea" . $id, "Urea - " . getPlayerName($json_data_api_jugadores, $id), json_encode($seriesGaussianUrea), "Urea mmol/L", "Distribución Gaussiana");
                            $mediaUrea = getMedia($seriesGaussianUrea);
                            $varianzaUrea = getVarianza($seriesGaussianUrea, $mediaUrea);
                            echo '<div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">UREA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">µ</th>
                                                <td>MEDIA</td>
                                                <td>'; echo $mediaUrea; echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">X̅</th>
                                                <td>MEDIANA</td>
                                                <td>'; echo getMediana($seriesGaussianUrea); echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">M</th>
                                                <td>MODA</td>
                                                <td>'; echo getModa($seriesGaussianUrea); echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">σ2</th>
                                                <td>VARIANZA</td>
                                                <td>'; echo $varianzaUrea; echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">σ</th>
                                                <td>DESVIACION ESTANDAR</td>
                                                <td>'; echo round(sqrt($varianzaUrea), 2); echo '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row div-border-multiplayer">
                            <div class="col-12">
                                <figure class="highcharts-figure">
                                    <div id="GaussianCpk' . $id . '"></div>
                                </figure>
                            </div>';
                            $seriesGaussianCpk = getGaussianDataCPK($json_dataCpkUrea, $_POST['dateDesde'], $_POST['dateHasta']);
                            gaussian_chart("GaussianCpk" . $id, "CPK - " . getPlayerName($json_data_api_jugadores, $id), json_encode($seriesGaussianCpk), "CPK units/L", "Distribución Gaussiana");
                            $mediaCpk = getMedia($seriesGaussianCpk);
                            $varianzaCpk = getVarianza($seriesGaussianCpk, $mediaCpk);
                            echo '<div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">UREA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">µ</th>
                                                <td>MEDIA</td>
                                                <td>'; echo $mediaCpk; echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">X̅</th>
                                                <td>MEDIANA</td>
                                                <td>'; echo getMediana($seriesGaussianCpk); echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">M</th>
                                                <td>MODA</td>
                                                <td>'; echo getModa($seriesGaussianCpk); echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">σ2</th>
                                                <td>VARIANZA</td>
                                                <td>'; echo $varianzaCpk; echo '</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">σ</th>
                                                <td>DESVIACION ESTANDAR</td>
                                                <td>'; echo round(sqrt($varianzaCpk), 2); echo '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                        
                    </div>';
                    }
                }
                ?>
            </div>
        </div>

        <?php
        if (isset($_POST['selectPlayers']) && isset($_POST['dateDesde']) && isset($_POST['dateHasta'])) {
            time_chart_compare_players("timePlotCPK", "CPK Data Time Chart", getTimeDataSeriesCPKComparePlayers($json_data_api_jugadores, $_POST['selectPlayers'], $_POST['dateDesde'], $_POST['dateHasta']), "CPK units/L");
            time_chart_compare_players("timePlotUrea", "Urea Data Time Chart", getTimeDataSeriesUreaComparePlayers($json_data_api_jugadores, $_POST['selectPlayers'], $_POST['dateDesde'], $_POST['dateHasta']), "Urea mmol/L.");
            scatter_chart("scatterPlotUreaVsCpk", "Urea VS CPK", getCpkVsUreaComparePlayers($json_data_api_jugadores, $_POST['selectPlayers'], $_POST['dateDesde'], $_POST['dateHasta']));
        }
        ?>
    </div>
</body>

</html>