<!-- Página principal -->
<?php 
    //require_once "vistas/principal.php"; 
    //echo hash("sha256", "admin");  // esta seria la contraseña codificada en sha256 que tendremos que pasarla a la bd
    //echo date("d/m/Y", time());
    // require_once "dirs.php";
    // require_once VIEW_PATH2."principal.php";
    session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once CONTROLLER_PATH."ControladorAcceso.php";
                print_r($_SESSION['nombre']);
                print_r($_SESSION['tipo']);
            exit();
?>

<a href="Usuario.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>Administración  Usuarios</a>
<br>
<a href="Producto.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>Administración Productos</a>








