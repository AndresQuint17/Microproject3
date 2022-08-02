<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link rel="stylesheet" href="mystyles.css">
</head>

<body>

    <!-- IMPORT SCRIPTS -->
    <script type="text/javascript" src="./barChart.js"></script>
    <script type="text/javascript" src="./pieChart.js"></script>

    <?php
    require_once('funciones.php');
    require_once('leerConfiguracion.php');
    require_once('validarArchivo.php');
    require_once('cargarGraficas.php');
    ?>

    <div id="wrapper">
        <div class="container" style="margin-top:10px;">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Análisis de Datos G302-2</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- CARGAR ARCHIVO DE CONFIGURACION -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="cargarArchivo.php">Cargar Archivo</a></li>
                    </ul>
                    <!-- SINGLEPLAYER -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="microproject3.php">Single Player</a></li>
                    </ul>
                    <!-- MULTIPLAYER -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="multiplayer.php">Multiplayer Player</a></li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                </div>
            </nav>
        </div>
        <div>
            <nav>
                <div class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <?php
                    $indexTab = 0;
                    foreach ($tabs as $tab) {
                        if ($indexTab == 0) {
                            // TITULO TAB ACTIVO
                            if ($popup[$indexTab] == 0) {
                                echo '<button class="nav-link active" 
                                id="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tab" 
                                data-bs-toggle="pill" data-bs-target="#v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                                type="button" role="tab" aria-controls="v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                                aria-selected="true">' . $tab . '</button>';
                            } else {
                                echo '<button class="nav-link" 
                                id="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tabb" 
                                data-bs-toggle="modal" data-bs-target="#modal'. str_replace(" ", "-", trim($tab)). '">'
                                    . $tab .
                                '</button>';
                            }
                        } else {
                            // TITULOS TABS NO ACTIVOS
                            if ($popup[$indexTab] == 0) {
                                echo '<button class="nav-link" 
                                id="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tab" 
                                data-bs-toggle="pill" data-bs-target="#v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                                type="button" role="tab" aria-controls="v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                                aria-selected="false">' . $tab . '</button>';
                            } else {
                                echo '<button class="nav-link" 
                                id="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tabb" 
                                data-bs-toggle="modal" data-bs-target="#modal'. str_replace(" ", "-", trim($tab)). '">'
                                    . $tab .
                                '</button>';
                            }
                        }
                        $indexTab++;
                    }
                    ?>
                </div>
            </nav>
            <div class="tab-content container-graficas" id="v-pills-tabContent">
                <?php
                $indexTab = 0;
                $contDiv = 1;
                foreach ($tabs as $tab) {
                    if ($indexTab == 0) {
                        if ($popup[$indexTab] == 0) {
                            echo '<div class="tab-pane fade show active" 
                            id="v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                            role="tabpanel" aria-labelledby="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tab">
                                <div class="container">';
                            $indexHowWhatPlot = 0;
                            foreach ($grids as $grid) {
                                $arrayGrid = explode('x', $grid);
                                $row = $arrayGrid[0];
                                $col = $arrayGrid[1];
                                for ($i = 0; $i < $row; $i++) {
                                    echo '<div class="row">';
                                    for ($j = 0; $j < $col; $j++) {
                                        echo '<div class="col-' . 12 / $col . '">
                                                <div class="row div-border" style="' . getRoundedCorners($rounded_corners, $indexTab, $indexHowWhatPlot) . '">';
                                        if (getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) == 0) {
                                            echo '<div class="col-12">
                                                    <figure class="highcharts-figure">
                                                        <div id="container' . $contDiv . '"></div>
                                                    </figure>
                                                </div>';
                                        } else {
                                            echo '<div class="col-' . getGraphSpace($graph_table, $indexTab, $indexHowWhatPlot) . ' horizontal-scroll">
                                                    <figure class="highcharts-figure">
                                                        <div id="container' . $contDiv . '"></div>
                                                    </figure>
                                                </div>
                                                <div class="col-' . getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) . '">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Title</th>
                                                                <th scope="col">Value</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                            $numRow = 1;
                                            foreach (getDataTable($json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)) as $data) {
                                                echo '
                                                                <tr>
                                                                <th scope="row">' . $numRow . '</th>
                                                                <td>' . $data['title'] . '</td>
                                                                <td>' . $data['value'] . '</td>
                                                                </tr>';
                                                $numRow++;
                                            }
                                            echo '</tbody>
                                                        </table>
                                                    </div>
                                                </div>';
                                        }
                                        echo '</div>
                                        </div>';
                                        echo load_chart(
                                            getHowPlot($how_plot, $indexTab, $indexHowWhatPlot),
                                            "container$contDiv",
                                            getGraphName($graph_names, $indexTab, $indexHowWhatPlot),
                                            get_chart_series(getHowPlot($how_plot, $indexTab, $indexHowWhatPlot), $json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)),
                                            getResolution($data_resolution, $indexTab, $indexHowWhatPlot)
                                        );
                                        $indexHowWhatPlot++;
                                        $contDiv++;
                                    }
                                    echo '</div>';
                                }
                                break;
                            }
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo '<div class="modal fade" id="modal'. str_replace(" ", "-", trim($tab)) .'" tabindex="-1" aria-labelledby="modalLabel'. str_replace(" ", "-", trim($tab)) .'" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel'. str_replace(" ", "-", trim($tab)) .'">'. $tab .'</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">';
                                            echo '<div class="tab-pane fade show active" 
                                            id="v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                                            role="tabpanel" aria-labelledby="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tab">
                                                <div class="container">';
                                            $indexHowWhatPlot = 0;
                                            foreach ($grids as $grid) {
                                                $arrayGrid = explode('x', $grid);
                                                $row = $arrayGrid[0];
                                                $col = $arrayGrid[1];
                                                for ($i = 0; $i < $row; $i++) {
                                                    echo '<div class="row">';
                                                    for ($j = 0; $j < $col; $j++) {
                                                        echo '<div class="col-' . 12 / $col . '">
                                                                <div class="row div-border" style="' . getRoundedCorners($rounded_corners, $indexTab, $indexHowWhatPlot) . '">';
                                                        if (getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) == 0) {
                                                            echo '<div class="col-12">
                                                                    <figure class="highcharts-figure">
                                                                        <div id="container' . $contDiv . '"></div>
                                                                    </figure>
                                                                </div>';
                                                        } else {
                                                            echo '<div class="col-' . getGraphSpace($graph_table, $indexTab, $indexHowWhatPlot) . ' horizontal-scroll">
                                                                    <figure class="highcharts-figure">
                                                                        <div id="container' . $contDiv . '"></div>
                                                                    </figure>
                                                                </div>
                                                                <div class="col-' . getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) . '">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-sm">
                                                                            <thead class="thead-dark">
                                                                                <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Title</th>
                                                                                <th scope="col">Value</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>';
                                                            $numRow = 1;
                                                            foreach (getDataTable($json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)) as $data) {
                                                                echo '
                                                                                <tr>
                                                                                <th scope="row">' . $numRow . '</th>
                                                                                <td>' . $data['title'] . '</td>
                                                                                <td>' . $data['value'] . '</td>
                                                                                </tr>';
                                                                $numRow++;
                                                            }
                                                            echo '</tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>';
                                                        }
                                                        echo '</div>
                                                        </div>';
                                                        echo load_chart(
                                                            getHowPlot($how_plot, $indexTab, $indexHowWhatPlot),
                                                            "container$contDiv",
                                                            getGraphName($graph_names, $indexTab, $indexHowWhatPlot),
                                                            get_chart_series(getHowPlot($how_plot, $indexTab, $indexHowWhatPlot), $json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)),
                                                            getResolution($data_resolution, $indexTab, $indexHowWhatPlot)
                                                        );
                                                        $indexHowWhatPlot++;
                                                        $contDiv++;
                                                    }
                                                    echo '</div>';
                                                }
                                                break;
                                            }
                                            echo '</div>';
                                            echo '</div>';
                                        echo '</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    } else {
                        if ($popup[$indexTab] == 0) {
                            echo '<div class="tab-pane fade" id="v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                            role="tabpanel" aria-labelledby="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tab">
                                <div class="container">';
                                $gridCero = 0;
                                $indexHowWhatPlot = 0;
                                foreach ($grids as $grid) {
                                    if ($gridCero != 0) {
                                        $arrayGrid = explode('x', $grid);
                                        $row = $arrayGrid[0];
                                        $col = $arrayGrid[1];
                                        for ($i = 0; $i < $row; $i++) {
                                            echo '<div class="row">';
                                            for ($j = 0; $j < $col; $j++) {
                                                echo '<div class="col-' . 12 / $col . '">
                                                    <div class="row div-border" style="' . getRoundedCorners($rounded_corners, $indexTab, $indexHowWhatPlot) . '">';
                                                if (getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) == 0) {
                                                    echo '<div class="col-12">
                                                        <figure class="highcharts-figure">
                                                            <div id="container' . $contDiv . '"></div>
                                                        </figure>
                                                    </div>';
                                                } else {
                                                    echo '<div class="col-' . getGraphSpace($graph_table, $indexTab, $indexHowWhatPlot) . ' horizontal-scroll">
                                                        <figure class="highcharts-figure">
                                                            <div id="container' . $contDiv . '"></div>
                                                        </figure>
                                                    </div>
                                                    <div class="col-' . getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) . '">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead class="thead-dark">
                                                                    <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Title</th>
                                                                    <th scope="col">Value</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';
                                                    $numRow = 1;
                                                    foreach (getDataTable($json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)) as $data) {
                                                        echo '
                                                                    <tr>
                                                                    <th scope="row">' . $numRow . '</th>
                                                                    <td>' . $data['title'] . '</td>
                                                                    <td>' . $data['value'] . '</td>
                                                                    </tr>';
                                                        $numRow++;
                                                    }
                                                    echo '</tbody>
                                                            </table>
                                                        </div>
                                                    </div>';
                                                }
                                                echo '</div>
                                                    </div>';
                                                echo load_chart(
                                                    getHowPlot($how_plot, $indexTab, $indexHowWhatPlot),
                                                    "container$contDiv",
                                                    getGraphName($graph_names, $indexTab, $indexHowWhatPlot),
                                                    get_chart_series(getHowPlot($how_plot, $indexTab, $indexHowWhatPlot), $json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)),
                                                    getResolution($data_resolution, $indexTab, $indexHowWhatPlot)
                                                );
                                                $indexHowWhatPlot++;
                                                $contDiv++;
                                            }
                                            echo '</div>';
                                        }
                                    } else {
                                        print_r($grid);
                                    }
                                    $gridCero++;
                                }
                                echo '</div>';
                            echo '</div>';
                        } else {
                            echo '<div class="modal fade" id="modal'. str_replace(" ", "-", trim($tab)) .'" tabindex="-1" aria-labelledby="modalLabel'. str_replace(" ", "-", trim($tab)) .'" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel'. str_replace(" ", "-", trim($tab)) .'">'. $tab .'</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">';
                                            echo '<div class="tab-pane fade show" 
                                            id="v-pills-' . str_replace(" ", "-", trim($tab)) . '" 
                                            role="tabpanel" aria-labelledby="v-pills-' . str_replace(" ", "-", trim($tab)) . '-tab">
                                                <div class="container">';
                                                $gridCero = 0;
                                                $indexHowWhatPlot = 0;
                                                foreach ($grids as $grid) {
                                                    if ($gridCero != 0) {
                                                        $arrayGrid = explode('x', $grid);
                                                        $row = $arrayGrid[0];
                                                        $col = $arrayGrid[1];
                                                        for ($i = 0; $i < $row; $i++) {
                                                            echo '<div class="row">';
                                                            for ($j = 0; $j < $col; $j++) {
                                                                echo '<div class="col-' . 12 / $col . '">
                                                                        <div class="row div-border" style="' . getRoundedCorners($rounded_corners, $indexTab, $indexHowWhatPlot) . '">';
                                                                if (getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) == 0) {
                                                                    echo '<div class="col-12">
                                                                            <figure class="highcharts-figure">
                                                                                <div id="container' . $contDiv . '"></div>
                                                                            </figure>
                                                                        </div>';
                                                                } else {
                                                                    echo '<div class="col-' . getGraphSpace($graph_table, $indexTab, $indexHowWhatPlot) . ' horizontal-scroll">
                                                                            <figure class="highcharts-figure">
                                                                                <div id="container' . $contDiv . '"></div>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="col-' . getTableSpace($graph_table, $indexTab, $indexHowWhatPlot) . '">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-sm">
                                                                                    <thead class="thead-dark">
                                                                                        <tr>
                                                                                        <th scope="col">#</th>
                                                                                        <th scope="col">Title</th>
                                                                                        <th scope="col">Value</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>';
                                                                    $numRow = 1;
                                                                    foreach (getDataTable($json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)) as $data) {
                                                                        echo '
                                                                                        <tr>
                                                                                        <th scope="row">' . $numRow . '</th>
                                                                                        <td>' . $data['title'] . '</td>
                                                                                        <td>' . $data['value'] . '</td>
                                                                                        </tr>';
                                                                        $numRow++;
                                                                    }
                                                                    echo '</tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>';
                                                                }
                                                                echo '</div>
                                                                </div>';
                                                                echo load_chart(
                                                                    getHowPlot($how_plot, $indexTab, $indexHowWhatPlot),
                                                                    "container$contDiv",
                                                                    getGraphName($graph_names, $indexTab, $indexHowWhatPlot),
                                                                    get_chart_series(getHowPlot($how_plot, $indexTab, $indexHowWhatPlot), $json_data, getWhatPlot($what_plot, $indexTab, $indexHowWhatPlot)),
                                                                    getResolution($data_resolution, $indexTab, $indexHowWhatPlot)
                                                                );
                                                                $indexHowWhatPlot++;
                                                                $contDiv++;
                                                            }
                                                            echo '</div>';
                                                        }
                                                    }
                                                    $gridCero++;
                                                }
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                    $indexTab++;
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>