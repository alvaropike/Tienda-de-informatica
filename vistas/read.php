<?php

// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once UTILITY_PATH."funciones.php";

// Compramos la existencia del parámetro id antes de usarlo
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Cargamos el controlador de alumnos
    $id = decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
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
                    <h1>Ficha del alumno</h1>
                </div>
                <!-- Muestro los datos del alumno-->
                <div class="d-flex">
                <a href="../utilidades/descargar.php?opcion=PDFAlumno&id=<?php echo $_GET["id"] ?>" class="btn btn-rounded btn-primary ml-auto" target="_blank"><span class="fas far fa-file-pdf pl-1"></span>  PDF</a>
                </div>
                <table>
                    <tr>
                        <td class="align-left">
                            <label>Fotografía</label><br>
                            <img src='<?php echo "../imagenes/usuarios/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        </td>
                    </tr>
                </table>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $alumno->getNombre(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                            <p class="form-control-static"><?php echo $alumno->getApellido(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>email</label>
                            <p class="form-control-static"><?php echo $alumno->getEmail(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>password</label>
                            <p class="form-control-static"><?php echo str_repeat("*",strlen($alumno->getPassword())); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Admin</label>
                            <p class="form-control-static"><?php echo $alumno->getAdmin(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Telefono</label>
                            <p class="form-control-static"><?php echo $alumno->getTelefono(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha de alta</label>
                            <p class="form-control-static"><?php echo $alumno->getF_alta(); ?></p>
                    </div>
                    <a href="../Usuario.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
            </div>
        </div>        
    </div>
</div>
<br><br><br>
