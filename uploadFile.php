<?php
$rutaGuardado = "config-file.csv";
    move_uploaded_file($_FILES['file_upload']['tmp_name'], $rutaGuardado);
    echo "<script type='text/javascript'>
                            alert('Archivo cargado correctamente.');
                            window.location='index.php';
                            </script>";
?>
