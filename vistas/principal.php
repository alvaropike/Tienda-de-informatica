<!-- Cabecera de la página web -->
<?php require_once VIEW_PATH."cabecera.php"; ?>

<!-- Cuerpo de la página web -->
<?php ; 
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();    
    if(isset($_SESSION['USUARIO']['email'])){
        // Menu de administrador
        require_once VIEW_PATH."admin_listado.php";
    } else{
        // Menú normal
        require_once VIEW_PATH."user_listado.php";
  }
  ?>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH."pie.php"; ?>