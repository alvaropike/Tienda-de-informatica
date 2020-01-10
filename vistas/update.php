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
 
// Variables temporales
$nombre = $raza = $ki = $transformacion = $ataque = $planeta = $imagen ="";
$nombreErr = $razaErr = $kiErr = $transformacionErr = $ataqueErr= $planetaErr = $imagenErr= "";
$imagenAnterior = "";
$errores=[];
// Procesamos la información obtenida por el get
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
   // Procesamos el dni
//    $dniVal = filtrado($_POST["dni"]);
//    if(empty($dniVal)){
//        $dniErr = "Por favor introduzca un DNI válido.";
//    }elseif(!filter_var($dniVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[0-9]{8}[A-Za-z]{1}/")))){
//            $dniErr = "Por favor introduzca un DNI con formato válido XXXXXXXXL, donde X es un dígito y L una letra.";
//    } else{
//        $dni= $dniVal;
//    }
   
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
   
   // Procesamos el email
//    $emailVal = filtrado($_POST["email"]);
//    if(empty($emailVal)){
//        $emailsErr = "Por favor introduzca email válido.";
//        // Un ejemplo de validar expresiones regulares directamente desde PHP
//    //} elseif(!filter_var($apellidosVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
//    //    $apellidosErr = "Por favor introduzca apellidos válidos.";
//    } else{
//        $email= $emailVal;
//    }

   // No lo procesamos porque así lo hemos decidido
   // Procesamos el password
//    $passwordVal = filtrado($_POST["password"]);
//    if(empty($passwordVal) || strlen($passwordVal)<5){
//        $passwordErr = "Por favor introduzca password válido y que sea mayor que 5 caracteres.";
//    } else{
//        // No hacemos el has que si no cambiamos la contraseña
//        $password= $passwordVal;
//    }

//    // Procsamos idiomas
//     if(isset($_POST["idioma"])){
//         $idioma = filtrado(implode(", ", $_POST["idioma"]));
//     }else{
//         $idiomaErr = "Debe elegir al menos un idioma";
//     }

//     // Procesamos matrícula
//     if(isset($_POST["matricula"])){
//         $matricula = filtrado($_POST["matricula"]);
//     }else{
//         $matriculaErr = "Debe elegir al menos una matricula";
//     }

//     // Procesamos lenguaje
//     $lenguaje = filtrado($_POST["lenguaje"]);

    // // Procesamos fecha
    // $fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
    // $hoy = date("d-m-Y", time());

    // // Comparamos las fechas
    // $fecha_mat = new DateTime($fecha);
    // $fecha_hoy = new DateTime($hoy);
    // $interval = $fecha_hoy->diff($fecha_mat);

    // if($interval->format('%R%a días')>0){
    //     $fechaErr = "La fecha no puede ser superior a la fecha actual";
    //     $errores[]=  $fechaErr;

    // }else{
    //     $fecha = date("d/m/Y",strtotime($fecha));
    // }

    // Procsamos raza
    if(isset($_POST["raza"])){
        $raza = filtrado($_POST["raza"]);
    }else{
        $razaErr = "Debe elegir al menos una raza";
        $errores[]=  $razaErr;
    }

    $kiVal = filtrado(($_POST["ki"]));
    if(empty($kiVal)){
        $kiErr = "Por favor introduzca un ki válido con solo carávteres numericos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([0-9])/", $kiVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $kiErr = "Por favor introduzca un ki válido con solo carávteres numericos.";
        $errores[]= $kiErr;
    } else{
        $ki= $kiVal;
    }

    // Procsamos transformacion
    if(isset($_POST["transformacion"])){
        $transformacion = filtrado($_POST["transformacion"]);
    }else{
        $transformacionErr = "Debe seleccionar la transformacion";
        $errores[]=  $transformacionErr;
    }

    // Procsamos ataque
    if(isset($_POST["ataque"])){
        $ataque = filtrado($_POST["ataque"]);
    }else{
        $ataqueErr = "Debe seleccionar el ataque";
        $errores[]=  $ataqueErr;
    }    

    $planetaVal = filtrado(($_POST["planeta"]));
    if(empty($planetaVal)){
        $planetaErr = "Por favor introduzca un planeta válido con LLLNN.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([a-zA-Z]{3}[0-9]{2})/", $planetaVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $planetaErr = "Por favor introduzca un planeta válido con LLLNN.";
        $errores[]= $planetaErr;
    } else{
        $planeta= $planetaVal;
    }

    // Procesamos la imagen
    // Si nos ha llegado algo mayor que cer
    if($_FILES['imagen']['size']>0 && count($errores)==0){
        $propiedades = explode("/", $_FILES['imagen']['type']);
        $extension = $propiedades[1];
        $tam_max = 50000; // 50 KBytes
        $tam = $_FILES['imagen']['size'];
        $mod = true;
        // Si no coicide la extensión
        if($extension != "png" && $extension != "jpeg"){
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

            // Borramos la antigua
            $imagenAnterior = trim($_POST["imagenAnterior"]);
            if($imagenAnterior!=$imagen){
                if(!$controlador->eliminarImagen($imagenAnterior)){
                    $imagenErr= "Error al borrar la antigua imagen en el servidor";
                }
            }
        }else{
        // Si no la hemos modificado
            $imagen=trim($_POST["imagenAnterior"]);
        }

    }else{
        $imagen=trim($_POST["imagenAnterior"]);
    }
    
     // Chequeamos los errores antes de insertar en la base de datos
    if(empty($nombreErr) && empty($razaErr) && empty($kiErr) && empty($transformacionErr) && 
        empty($ataqueErr) && empty($planetaErr) && empty($imagenErr)){
        // creamos el controlador de alumnado
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->actualizarAlumno($id, $nombre, $raza, $ki, $transformacion, $ataque, $planeta, $imagen);
        if($estado){
            $errores=[];
            //El registro se ha lamacenado corectamente
            //alerta("Alumno/a creado con éxito");
            header("location: ../index.php");
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
        $controlador = ControladorAlumno::getControlador();
        $alumno = $controlador->buscarAlumno($id);
        if (!is_null($alumno)) {
            $nombre = $alumno->getNombre();
            $raza = $alumno->getRaza();
            $ki = $alumno->getKi();
            $transformacion = $alumno->getTransformacion();
            $ataque = $alumno->getAtaque();
            $planeta = $alumno->getPlaneta();
            $imagen = $alumno->getImagen();
            $imagenAnterior = $imagen;
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
                        <h2>Crear Alumno/a</h2>
                    </div>
                    <p>Por favor rellene este formulario para añadir un nuevo alumno/a a la base de datos de la clase.</p>
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
                        <!-- raza -->
                        <div class="form-group <?php echo (!empty($razaErr)) ? 'error: ' : ''; ?>">
                            <label>raza</label>
                            <input type="radio" name="raza" value="saiyan" <?php echo (strstr($raza, 'saiyan')) ? 'checked' : ''; ?>>Saiyan</input>
                            <input type="radio" name="raza" value="tericula" <?php echo (strstr($raza, 'tericula')) ? 'checked' : ''; ?>>Tericula</input>
                            <input type="radio" name="raza" value="namekiano" <?php echo (strstr($raza, 'namekiano')) ? 'checked' : ''; ?>>Namekiano</input>
                            <input type="radio" name="raza" value="otro" <?php echo (strstr($raza, 'otro')) ? 'checked' : ''; ?>>Otro</input><br>
                            <span class="help-block"><?php echo $razaErr;?></span>
                        </div>
                        <!-- ki -->
                        <div class="form-group <?php echo (!empty($kiErr)) ? 'error: ' : ''; ?>">
                            <label>Ki</label>
                            <input type="text" required name="ki" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $ki; ?>">
                            <span class="help-block"><?php echo $kiErr;?></span>
                        </div>
                        <!-- transformacion -->
                        <div class="form-group <?php echo (!empty($transformacionErr)) ? 'error: ' : ''; ?>">
                            <label>transformacion</label>
                            <input type="radio" name="transformacion" value="si" <?php echo (strstr($transformacion, 'si')) ? 'checked' : ''; ?>>Si</input>
                            <input type="radio" name="transformacion" value="no" <?php echo (strstr($transformacion, 'no')) ? 'checked' : ''; ?>>No</input><br>
                            <span class="help-block"><?php echo $transformacionErr;?></span>
                        </div>
                        <!-- ataque -->
                        <div class="form-group <?php echo (!empty($ataqueErr)) ? 'error: ' : ''; ?>">
                            <label>ataque</label>
                            <input type="radio" name="ataque" value="todo" <?php echo (strstr($ataque, 'todo')) ? 'checked' : ''; ?>>Fisico - Onda de energia - Ultra instinto</input>
                            <input type="radio" name="ataque" value="ninguno" <?php echo (strstr($ataque, 'ninuno')) ? 'checked' : ''; ?>>Ninguno</input><br>
                            <span class="help-block"><?php echo $ataqueErr;?></span>
                        </div>
                        <!-- planeta -->
                        <div class="form-group <?php echo (!empty($planetaErr)) ? 'error: ' : ''; ?>">
                            <label>Planeta</label>
                            <input type="text" required name="planeta" class="form-control" value="<?php echo $planeta; ?>" 
                                pattern="([a-zA-Z]{3}[0-9]{2})"
                                title="El patron es LLLNN"
                                minlength="5">
                            <span class="help-block"><?php echo $planetaErr;?></span>
                        </div>
                         <!-- Foto-->
                         <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                        <label>Fotografía</label>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" name="imagen" class="form-control-file" id="imagen" accept=".jpg, .png">    
                        <span class="help-block"><?php echo $imagenErr;?></span>    
                        </div>
                        <!-- Botones --> 
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                        <button type="submit" value="aceptar" class="btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Modificar</button>
                        <a href="../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH."pie.php"; ?>