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
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
 
// Variables temporales
$nombre = $apellido = $email = $password = $admin = $foto = $telefono = $f_alta = $imagenAnterior = "";
$nombreErr = $apellidoErr = $emailErr = $passwordErr = $adminErr = $fotoErr = $telefonoErr = $f_alta = "";
$errores=[];
// Procesamos la información obtenida por el get
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if(empty($nombreVal)){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([^\s][A-zÀ-ž\s]+$)/", $nombreVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
        $errores[]= $nombreErr;
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
        $errores[]= $apellidoErr;
    } else{
        $apellido= $apellidoVal;
    }

    // Procesamos el email
    $emailVal = filtrado($_POST["email"]);
    if(empty($emailVal)){
        $emailErr = "Por favor introduzca email válido.";
    } else{
        $email= $emailVal;
        $errores[]= $emailErr;
    }

    // Procesamos el password
    $passwordVal = filtrado($_POST["password"]);
    if(empty($passwordVal) || strlen($passwordVal)<5){
        $passwordErr = "Por favor introduzca password válido y que sea mayor que 5 caracteres.";
    } else{
        $password= hash('sha256',$passwordVal);
        // $password= $passwordVal;
        $errores[]= $passwordErr;
    }

    // Procsamos admin
    if(isset($_POST["admin"])){
        $admin = filtrado($_POST["admin"]);
    }else{
        $adminErr = "Debe seleccionar si es admin o no";
        $errores[]= $adminErr;
    }

    // Procesamos el telefono
    $telefonoVal = filtrado(($_POST["telefono"]));
    if(empty($telefonoVal)){
        $telefonoErr = "Por favor introduzca un telefono válido con solo carávteres numericos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([0-9]{9})/", $telefonoVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $telefonoErr = "Por favor introduzca un telefono válido con solo carávteres numericos.";
        $errores[]= $telefonoErr;
    } else{
        $telefono= $telefonoVal;
    }

    // Procesamos la imagen
    // Si nos ha llegado algo mayor que cer
    if($_FILES['foto']['size']>0 && count($errores)==0){
        $propiedades = explode("/", $_FILES['foto']['type']);
        $extension = $propiedades[1];
        $tam_max = 50000; // 50 KBytes
        $tam = $_FILES['foto']['size'];
        $mod = true;
        // Si no coicide la extensión
        if($extension != "png" && $extension != "jpeg"){
            $mod = false;
            $fotoErr= "Formato debe ser jpg/png";
        }
        // si no tiene el tamaño
        if($tam>$tam_max){
            $mod = false;
            $fotoErr= "Tamaño superior al limite de: ". ($tam_max/1000). " KBytes";
        }
        // Si todo es correcto, mod = true
        if($mod){
            // salvamos la imagen
            $foto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name'].time()) . "." . $extension;
            $controlador = ControladorImagen::getControlador();
            if(!$controlador->salvarImagen($foto)){
                $fotoErr= "Error al procesar la foto y subirla al servidor";
            }

            // Borramos la antigua
            $imagenAnterior = trim($_POST["imagenAnterior"]);
            if($imagenAnterior!=$foto){
                if(!$controlador->eliminarImagen($imagenAnterior)){
                    $fotoErr= "Error al borrar la antigua foto en el servidor";
                }
            }
        }else{
        // Si no la hemos modificado
            $foto=trim($_POST["imagenAnterior"]);
        }

    }else{
        $foto=trim($_POST["imagenAnterior"]);
    }
    
     // Chequeamos los errores antes de insertar en la base de datos
     if(empty($nombreErr) && empty($apellidoErr) && empty($emailErr) && empty($passwordErr) && 
     empty($adminErr) && empty($fotoErr) && empty($telefonoErr) && empty($f_altaErr)){
     // creamos el controlador de alumnado
     $controlador = ControladorUsuario::getControlador();
     $estado = $controlador->actualizarAlumno($id, $nombre, $apellido, $email, $password, $admin, $foto, $telefono, $f_alta);
     if($estado){
        $errores=[];
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

}

    // Comprobamos que existe el id antes de ir más lejos
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  decode($_GET["id"]);
        $controlador = ControladorUsuario::getControlador();
        $alumno = $controlador->buscarAlumno($id);
        if (!is_null($alumno)) {
            $nombre = $alumno->getNombre();
            $apellido = $alumno->getApellido();
            $email = $alumno->getEmail();
            $password = $alumno->getPassword();
            $admin = $alumno->getAdmin();
            $foto = $alumno->getFoto();
            $telefono = $alumno->getTelefono();
            $f_alta = $alumno->getF_alta();
            $imagenAnterior = $foto;
        }
        else{
        // hay un error
            header("location: error.php");
            exit();
        }
    }else{
         // hay un error
            header("location: error.php");
            exit();
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
                        <h2>Crear Usuario/a</h2>
                    </div>
                    <p>Por favor rellene este formulario para añadir un nuevo usuario/a a la base de datos de la clase.</p>
                    <!-- $nombre = $apellido = $email = $password = $admin = $foto = $telefono = $f_alta = ""; -->
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>" 
                                pattern="([^\s][A-zÀ-ž\s]+)"
                                title="El nombre no puede contener números"
                                minlength="3">
                            <span class="help-block"><?php echo $nombreErr;?></span>
                        </div>
                        <!-- apellido-->
                        <div class="form-group <?php echo (!empty($apellidoErr)) ? 'error: ' : ''; ?>">
                            <label>apellido</label>
                            <input type="text" required name="apellido" class="form-control" value="<?php echo $apellido; ?>" 
                                pattern="([^\s][A-zÀ-ž\s]+)"
                                title="El apellido no puede contener números"
                                minlength="3">
                            <span class="help-block"><?php echo $apellidoErr;?></span>
                        </div>
                        <!-- Email -->
                        <div class="form-group <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>">
                            <label>E-Mail</label>
                            <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $emailErr;?></span>
                        </div>
                        <!-- Password -->
                        <div class="form-group <?php echo (!empty($passwordErr)) ? 'error: ' : ''; ?>">
                            <label>Contraseña</label>
                            <input type="password" required name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $passwordErr;?></span>
                        </div>
                        <!-- Admin DESPLEGABLE-->
                        <div class="form-group">
                        <label>Admin</label>
                            <select name="admin">
                                <option value="si" <?php echo (strstr($admin, 'si')) ? 'selected' : ''; ?>>Si</option>
                                <option value="no" <?php echo (strstr($admin, 'no')) ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <!-- telefono -->
                        <div class="form-group <?php echo (!empty($telefonoErr)) ? 'error: ' : ''; ?>">
                            <label>telefono</label>
                            <input type="text" required name="telefono" class="form-control" pattern="([0-9]{9})" title="Solo numeros enteros positivos" value="<?php echo $telefono; ?>">
                            <span class="help-block"><?php echo $telefonoErr;?></span>
                        </div>
                         <!-- Foto-->
                         <div class="form-group <?php echo (!empty($fotoErr)) ? 'error: ' : ''; ?>">
                        <label>Fotografía</label>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" name="foto" class="form-control-file" id="foto" accept=".png, .jpg">    
                        <span class="help-block"><?php echo $fotoErr;?></span>    
                        </div>
                        <!-- Botones --> 
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                        <button type="submit" value="aceptar" class="btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Modificar</button>
                        <a href="../Usuario.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>