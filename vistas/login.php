<!-- Cabecera de la página web -->
<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAcceso.php";

//Debemos decir que no estamos identificando
$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>

<?php require_once VIEW_PATH."cabecera.php"; ?>
<!-- Barra de Navegacion -->

<?php
    
    // Procesamos la indetificación
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $controlador = ControladorAcceso::getControlador();
        $controlador->procesarIdentificacion($_POST['email'], $_POST['password'], $_POST['foto']);
    }
 
?>
<!-- Cuerpo de la página web -->
<body>
    <div id="login">
        <h3 class="text-center text-black pt-5">Identificación de Usuario/a:</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">  
                <!-- Formulario-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- Nombre-->
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" required name="email" class="form-control" value="alvaropiqueras@hotmail.com">
                    </div>
                    <!-- Contraseña -->
                    <div class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" required name="password" class="form-control" value="trenado">
                    </div>
                    <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-log-in"></span>  Entrar</button>
                    <a href="../vistas2/catalogo.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                </form>
            </div>
        </div>        
    </div>
</div>
<br>
