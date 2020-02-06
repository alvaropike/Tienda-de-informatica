<!-- Página principal -->
<?php 
    //require_once "vistas/principal.php"; 
    //echo hash("sha256", "admin");  // esta seria la contraseña codificada en sha256 que tendremos que pasarla a la bd
    //echo date("d/m/Y", time());


    error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
    require_once CONTROLLER_PATH."ControladorAcceso.php";
    require_once CONTROLLER_PATH."ControladorUsuario.php";
    require_once VIEW_PATH."cabecera.php"; 


    if ((($_SESSION['admin'])=="si") && (isset($_SESSION['USUARIO']['email']))){
        require_once VIEW_PATH2."admin_listado.php";

    }else{
        header("location: vistas/error.php");
    }
    
?>