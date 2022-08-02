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

    <link rel="stylesheet" href="mystyles.css">
</head>

<body>
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
                    <!-- SINGLEPLAYER -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="microproject3.php">Singleplayer</a></li>
                    </ul>
                    <!-- MULTIPLAYER -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="multiplayer.php">Multiplayer</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container my-5 container-upload-file">
            <div class="col-12">
                <form action="uploadFile.php" method="POST" enctype="multipart/form-data">
                    <div>
                        <div class="flex-center">Cargar Archivo de Configuración</div>
                        <div class="flex-center">
                            <input type="file" name="file_upload" accept=".csv" />
                        </div>
                    </div>
                    <div class="div-btn-upl">
                        <button class="button">Cargar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>