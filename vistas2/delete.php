<?php
//       error_reporting(E_ALL & ~E_NOTICE);
//       session_start();
//       if(isset($_SESSION['USUARIO']['email'])){
//         // Si es admin muestra la pagina

//     } else{
//         // Si no es admin muestra este error
//         echo "ERROR: No tienes permiso para acceder aquí";
//         exit();
//   }
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once CONTROLLER_PATH."ControladorImagen2.php";
require_once UTILITY_PATH."funciones.php";

// Obtenemos los datos del alumno que nos vienen de la página anterior
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Cargamos el controlador de alumnos
    $id = decode($_GET["id"]);
    $controlador = ControladorProducto::getControlador();
    $alumno = $controlador->buscarAlumno($id);
    if (is_null($alumno)) {
        // hay un error
        header("location: error.php");
        exit();
    }
}

// Los datos del formulario al procesar el sí.
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $controlador = ControladorProducto::getControlador();
    $alumno = $controlador->buscarAlumno($_POST["id"]);
    if ($controlador->borrarAlumno($_POST["id"])) {
        //Se ha borrado y volvemos a la página principal
       // Debemos borrar la foto del alumno
       $controlador = ControladorImagen2::getControlador();
       if($controlador->eliminarImagen($alumno->getImagen())){
            header("location: ../Producto.php");
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
<?php require_once VIEW_PATH."navbar.php"; ?>
    <!-- Cuerpo de la página web --> 
        <div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper justify-content-center align-items-center">
        <div class="div-to-align">
                    <h1>Eliminar Producto</h1>
                </div>
                <!-- Muestro los datos del alumno-->
                
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
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- <div class="bg-danger"> -->
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este Producot?</p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a role="button" href="../Producto.php" class="btn btn-rounded btn-primary">Volver</a>
                        </p>
                    <!-- </div> -->
                </form>
            </div>
        </div>        
    </div>
</div>
<br><br><br>
