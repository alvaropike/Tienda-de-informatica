<?php

// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once UTILITY_PATH."funciones.php";

// Compramos la existencia del parámetro id antes de usarlo
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Cargamos el controlador de alumnos
    $id = decode($_GET["id"]);
    $controlador = ControladorProducto::getControlador();
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
<div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper justify-content-center align-items-center">
        <div class="div-to-align">
                    <h1>Ficha del Producto</h1>
                </div>
                <!-- Muestro los datos del alumno-->
                <div class="d-flex">
                <a href="../utilidades/descargar2.php?opcion=PDFAlumno&id=<?php echo $_GET["id"] ?>" class="btn btn-rounded btn-primary ml-auto" target="_blank"><span class="fas far fa-file-pdf pl-1"></span>  PDF</a>
                </div>
                <table>
                    <tr>
                        <td class="align-left">
                            <label class="font-weight-bold">Fotografía</label><br>
                            <img src='<?php echo "../imagenes/Productos/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        </td>
                    </tr>
                </table>
                    <div class="form-group ">
                        <label class="font-weight-bold">Nombre</label>
                        <p class="form-control-static"><?php echo $alumno->getNombre(); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Tipo</label>
                            <p class="form-control-static"><?php echo $alumno->getTipo(); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Distribuidor</label>
                            <p class="form-control-static"><?php echo $alumno->getDistribuidor(); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Stock</label>
                            <p class="form-control-static"><?php echo $alumno->getStock(); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Precio</label>
                            <p class="form-control-static"><?php echo $alumno->getPrecio(); ?></p>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Descuento</label>
                            <p class="form-control-static"><?php echo $alumno->getDescuento(); ?></p>
                    </div>
                    <a href="catalogo.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
            </div>
        </div>        
    </div>
</div>
<br><br><br>
