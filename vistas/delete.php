<?php
      error_reporting(E_ALL & ~E_NOTICE);
      session_start();
      if(isset($_SESSION['USUARIO']['email'])){
        // Si es admin muestra la pagina

    } else{
        // Si no es admin muestra este error
        echo "ERROR: No tienes permiso para acceder aquí";
        exit();
  }
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/Dragonball/dirs.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

// Obtenemos los datos del alumno que nos vienen de la página anterior
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Cargamos el controlador de alumnos
    $id = decode($_GET["id"]);
    $controlador = ControladorAlumno::getControlador();
    $alumno = $controlador->buscarAlumno($id);
    if (is_null($alumno)) {
        // hay un error
        header("location: error.php");
        exit();
    }
}

// Los datos del formulario al procesar el sí.
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $controlador = ControladorAlumno::getControlador();
    $alumno = $controlador->buscarAlumno($_POST["id"]);
    if ($controlador->borrarAlumno($_POST["id"])) {
        //Se ha borrado y volvemos a la página principal
       // Debemos borrar la foto del alumno
       $controlador = ControladorImagen::getControlador();
       if($controlador->eliminarImagen($alumno->getImagen())){
            header("location: ../index.php");
            exit();
       }else{
            header("location: error.php");
            exit();
        }
    } else {
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
                    <h1>Borrar Alumno/a</h1>
                </div>
                <!-- Muestro los datos del alumno-->
                <table>
                    <tr>
                        <td class="align-left">
                            <label>Fotografía</label><br>
                            <img src='<?php echo "../imagenes/" . $alumno->getImagen() ?>' class='rounded' class='img-thumbnail' width='48' height='auto'>
                        </td>
                    </tr>
                </table>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $alumno->getNombre(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Raza</label>
                            <p class="form-control-static"><?php echo $alumno->getRaza(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Ki</label>
                            <p class="form-control-static"><?php echo $alumno->getKi(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Transformacion</label>
                            <p class="form-control-static"><?php echo $alumno->getTransformacion(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Ataque</label>
                            <p class="form-control-static"><?php echo $alumno->getAtaque(); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Planeta</label>
                            <p class="form-control-static"><?php echo $alumno->getPlaneta(); ?></p>
                    </div>
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este alumno/a?</p><br>
                        <p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a href="../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>
<br><br><br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH."pie.php"; ?>
