<?php
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
// error_reporting(E_ALL & ~E_NOTICE);
// session_start();
// if(!isset($_SESSION['USUARIO']['email'])){
//     //echo $_SESSION['USUARIO']['email'];
//     //exit();
//     header("location: login.php");
//     exit();
// }

// Incluimos el controlador a los objetos a usar
//require_once "../dirs.php";

// Incluimos los directorios a trabajar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

 
// Variables temporales
$nombre = $apellido = $email = $password = $admin = $imagen = $telefono = $f_alta = "";
$nombreErr = $apellidoErr = $emailErr = $passwordErr = $adminErr = $imagenErr = $telefonoErr = $f_alta = "";
 
// Procesamos el formulario al pulsar el botón aceptar de esta ficha
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){
  
    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if(empty($nombreVal)){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } else{
        $nombre= $nombreVal;
    }

    // Procesamos el apellido
    $apellidoVal = filtrado(($_POST["apellido"]));
    if(empty($apellidoVal)){
        $apellidoErr = "Por favor introduzca un apellido válido con solo carávteres alfabéticos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $apellidoVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $apellidoErr = "Por favor introduzca un apellido válido con solo carávteres alfabéticos.";
    } else{
        $apellido= $apellidoVal;
    }

    // Procesamos el email
    $emailVal = filtrado($_POST["email"]);
    if(empty($emailVal)){
        $emailErr = "Por favor introduzca email válido.";
    } else{
        $email= $emailVal;
    }

    // Procesamos el password
    $passwordVal = filtrado($_POST["password"]);
    if(empty($passwordVal) || strlen($passwordVal)<5){
        $passwordErr = "Por favor introduzca password válido y que sea mayor que 5 caracteres.";
    } else{
        $password= hash('sha256',$passwordVal);
    }

    // Procsamos admin
    if(isset($_POST["admin"])){
        $admin = filtrado($_POST["admin"]);
    }else{
        $adminErr = "Debe seleccionar si es admin o no";
    }

    // Procesamos el telefono
    $telefonoVal = filtrado(($_POST["telefono"]));
    if(empty($telefonoVal)){
        $telefonoErr = "Por favor introduzca un telefono válido con solo carávteres numericos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([0-9]{9})/", $telefonoVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $telefonoErr = "Por favor introduzca un telefono válido con solo carávteres numericos.";
    } else{
        $telefono= $telefonoVal;
    }

     // Procesamos fecha
    $f_alta = date("d/m/Y", time());

    // Procesamos la imagen
    $propiedades = explode("/", $_FILES['imagen']['type']);
    $extension = $propiedades[1];
    $tam_max = 5000000; // 50 KBytes
    $tam = $_FILES['imagen']['size'];
    $mod = true; // Si vamos a modificar

    // Si no coicide la extensión
    if($extension != "jpeg" && $extension != "png"){
        $mod = false;
        $imagenErr= "Formato debe ser jpg/png";
    }
    // si no tiene el tamaño
    if($tam>$tam_max){
        $mod = false;
        $imagenErr= "Tamaño superior al limite de: ". ($tam_max/1000). " KBytes";
    }

    // Si todo es correcto, mod = true
    if($mod){
        // salvamos la imagen
        $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'].time()) . "." . $extension;
        $controlador = ControladorImagen::getControlador();
        if(!$controlador->salvarImagen($imagen)){
            $imagenErr= "Error al procesar la imagen y subirla al servidor";
        }
    }

    // Chequeamos los errores antes de insertar en la base de datos
    if(empty($nombreErr) && empty($apellidoErr) && empty($emailErr) && empty($passwordErr) && 
        empty($adminErr) && empty($imagenErr) && empty($telefonoErr) && empty($f_altaErr)){
        // creamos el controlador de alumnado
        $controlador = ControladorUsuario::getControlador();
        $estado = $controlador->almacenarAlumno($nombre, $apellido, $email, $password, $admin, $imagen, $telefono, $f_alta);
        if($estado){
            //El registro se ha lamacenado corectamente
            //alerta("Alumno/a creado con éxito");
            header("location: ../Usuario.php");
            exit();
        }else{
            header("location: error.php");
            exit();
        }
    }else{
        alerta("Hay errores al procesar el formulario revise los errores");
    }

}else{
    $admin = 'no';
}
?>
<!-- Cabecera de la página web -->
<?php require_once VIEW_PATH."navbar.php"; ?>
    <!-- Cuerpo de la página web --> 
        <div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper justify-content-center align-items-center">
        <div class="div-to-align">
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> 
            <fieldset> 
                        <!-- Form Name -->
                        <legend>Añadir usuario</legend>
                        <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label class="col-md-4 control-label" for="textinput">Nombre</label>  
                                <div class="col-md-7">
                                    <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>" 
                                        pattern="([^\s][A-zÀ-ž\s]+)"
                                        title="El nombre no puede contener números"
                                        minlength="3">
                                    <span class="help-block"><?php echo $nombreErr;?></span>
                                </div>
                        </div>      
                        <!-- apellido-->
                        <div class="form-group <?php echo (!empty($apellidoErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Apellido</label>  
                                <div class="col-md-7">
                            <input type="text" required name="apellido" class="form-control" value="<?php echo $apellido; ?>" 
                                pattern="([^\s][A-zÀ-ž\s]+)"
                                title="El apellido no puede contener números"
                                minlength="3">
                            <span class="help-block"><?php echo $apellidoErr;?></span>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="form-group <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">E-mail</label>  
                            <div class="col-md-7">
                            <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $emailErr;?></span>
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Password</label>  
                            <div class="col-md-7">
                            <input type="password" required name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $passwordErr;?></span>
                        </div>
                        </div>                  
                        <!-- Admin DESPLEGABLE-->
                        <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Admin</label>  
                            <div class="col-md-7">
                            <select name="admin"  class="form-control">
                                <option value="si" <?php echo (strstr($admin, 'si')) ?:''; ?>>Si</option>
                                <option value="no" <?php echo (strstr($admin, 'no')) ? 'selected' : ''; ?>>No</option>
                            </select>
                            </div>
                        </div>
                        <!-- telefono -->
                        <div class="form-group <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Telefono</label>  
                            <div class="col-md-7">
                            <input type="text" required name="telefono" class="form-control" pattern="([0-9]{9})" title="Solo numeros enteros positivos" value="<?php echo $telefono; ?>">
                            <span class="help-block"><?php echo $telefonoErr;?></span>
                        </div>
                        </div>
                         <!-- imagen-->
                         <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                         <label class="col-md-4 control-label" for="imagen">imagen</label>  
                            <div class="col-md-7">
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" required name="imagen" class="form-control-file" id="imagen" accept=".png, .jpg">    
                        <span class="help-block"><?php echo $imagenErr;?></span>    
                        </div>
                        </div>
                        <!-- Botones --> 
                        
                        <div class="col-md-7">
                         <button type="submit" name= "aceptar" value="aceptar" class="btn btn-success"> <span class="glyphicon glyphicon-floppy-save"></span>  Aceptar</button>
                         <button type="reset" value="reset" class="btn btn-info"> <span class="glyphicon glyphicon-repeat"></span>  Limpiar</button>
                        <a href="../Usuario.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </fieldset>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
<!-- Pie de la página web -->