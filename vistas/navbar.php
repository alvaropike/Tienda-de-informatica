
<?php
ob_start();
session_start();
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorAcceso.php";

?>





<style>
@import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css);
@import url(https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.3/css/mdb.min.css);

.hm-gradient {
    background-image: linear-gradient(to top, #f3e7e9 0%, #e3eeff 99%, #e3eeff 100%);
}
.darken-grey-text {
    color: #2E2E2E;
}
.navbar .dropdown-menu a:hover {
    color: #616161 !important;
}
.darken-grey-text {
    color: #2E2E2E;
}
.div-to-align {
    width: 75%;
    margin: 10px 210px;
}

.div-wrapper {
    height: 200px;
    margin-top: 40px;
}
</style>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">  
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark blue lighten-1">
  <img class="navbar-brand" src="https://s3.amazonaws.com/designmantic-logos/logos/2020/Jan/medium-4645-5e21d5ac477de.png" width="100px"></a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/AppWeb/tiendaInformatica/Tienda-de-informatica/vistas2/catalogo.php">Home</a>
      </li>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Productos </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
          <a class="dropdown-item" href="catalogo.php?tipo=Fuente">Fuentes de alimentación</a>
          <a class="dropdown-item" href="catalogo.php?tipo=Grafica">Graficas</a>
          <a class="dropdown-item" href="catalogo.php?tipo=Portatiles">Portatiles</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="catalogo.php?tipo=Ofertas">Ofertas</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto nav-flex-icons">
    <?php
          
          if(!isset($_SESSION['USUARIO']['email'])){
            echo '<li class="nav-item"><a href="/AppWeb/tiendaInformatica/Tienda-de-informatica/vistas/create.php" class="nav-link">Registrarse</a></li>';
            echo '<li class="nav-item"><a href="/AppWeb/tiendaInformatica/Tienda-de-informatica/vistas/login.php" class="nav-link"> Login</a></li>';
          }else{
            echo '<li class="nav-item"><a class="nav-link" href="/AppWeb/tiendaInformatica/Tienda-de-informatica/Usuario.php">Usuarios</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="/AppWeb/tiendaInformatica/Tienda-de-informatica/Producto.php">Productos</a></li>';
            echo '<li class="nav-item"><a href="#" class="nav-link">'.$_SESSION['email'].'</a></li>';
            echo '<li class="nav-item"><a href="/AppWeb/tiendaInformatica/Tienda-de-informatica/vistas/login.php" class="nav-link"> Salir</a></li>';
            echo '<li class="nav-item avatar dropdown">';
            echo '<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
             echo  '<img src="../imagenes/usuarios/'.$_SESSION['imagen'].'" class="rounded-circle z-depth-0" alt="avatar image" height="3s5">';
            // print_r($_SESSION['USUARIO']); 
            // print_r($_FILES['foto']['tmp_name']); 

            //echo '<img src="../imagenes/usuarios/"' . $alumno->getFoto().'" class="rounded" class="img-thumbnail" width="48" height="auto">';

            // 
            echo '</a>';
            echo '<div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">';
            //  echo  '<a class="dropdown-item" href="#">Hola Pepito</a>';
            // echo "<li><a href='ficha.php?id= ''>  ".$alumno->getNombre()."</a></li>";
             echo  '<a class="dropdown-item" href="#">Mi perfil</a>';
             echo  '<a class="dropdown-item" href="/AppWeb/tiendaInformatica/Tienda-de-informatica/vistas/login.php">Cerrar Sesion</a>';
           echo  '</div>';
         echo  '</li>';
          }
      ?>
    </ul>
</nav>
<!--/.Navbar -->
