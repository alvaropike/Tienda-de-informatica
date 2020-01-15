<?php

// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once UTILITY_PATH."funciones.php";

// Compramos la existencia del parámetro id antes de usarlo
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Cargamos el controlador de alumnos
    $id = decode($_GET["id"]);
    $controlador = ControladorAlumno::getControlador();
    $alumno= $controlador->buscarAlumno($id);
    if (is_null($alumno)){
        // hay un error
        header("location: error.php");
        exit();
    } 
}
?>

<!-- Cabecera de la página web -->
<?php require_once VIEW_PATH."cabecera.php"; ?>
<!-- Cuerpo de la página web -->
<div class="wrapper">
    <div class="container-fluid">

    <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Ficha del alumno</h1>
                </div>
                <!-- Muestro los datos del alumno-->
                <a href="../utilidades/descargar.php?opcion=PDFAlumno&id=<?php echo $_GET["id"] ?>" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  PDF</a>
                <table>
                <tr>
                        <td class="align-left">
                            <label>Fotografía</label><br>
                            <img src='<?php echo "../imagenes/Productos/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        </td>
                    </tr>
                </table>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $alumno->getNombre(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                            <p class="form-control-static"><?php echo $alumno->getTipo(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Distribuidor</label>
                            <p class="form-control-static"><?php echo $alumno->getDistribuidor(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                            <p class="form-control-static"><?php echo $alumno->getStock(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                            <p class="form-control-static"><?php echo $alumno->getPrecio(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Descuento</label>
                            <p class="form-control-static"><?php echo $alumno->getDescuento(); ?></p>
                    </div>
            </div>
        </div>        
    </div>
</div>
<br><br><br>
