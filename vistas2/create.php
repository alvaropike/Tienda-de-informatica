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
require_once CONTROLLER_PATH."ControladorAlumno2.php";
require_once CONTROLLER_PATH2."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";

 
// Variables temporales
$nombre = $tipo = $distribuidor = $stock = $precio = $descuento = $imagen = "";
$nombreErr = $tipoErr = $distribuidorErr = $stockErr = $precioErr = $descuentoErr = $imagenErr = "";
 
// Procesamos el formulario al pulsar el botón aceptar de esta ficha
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["aceptar"]){
  
    // Procesamos el nombre
    $nombreVal = filtrado(($_POST["nombre"]));
    if(empty($nombreVal)){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([^\s][A-zÀ-ž0-9\s]+$)/", $nombreVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
    } else{
        $nombre= $nombreVal;
    }

    // Procesamos el tipo
    $tipoVal = filtrado(($_POST["tipo"]));
    if(empty($tipoVal)){
        $tipoErr = "Por favor introduzca un tipo válido con solo carávteres alfabéticos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([^\s][A-zÀ-ž0-9\s]+$)/", $tipoVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $tipoErr = "Por favor introduzca un tipo válido con solo carávteres alfabéticos.";
    } else{
        $tipo= $tipoVal;
    }
    // Procesamos el distribuidor
    $distribuidorVal = filtrado(($_POST["distribuidor"]));
    if(empty($distribuidorVal)){
        $distribuidorErr = "Por favor introduzca un distribuidor válido con solo carávteres alfabéticos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([^\s][A-zÀ-ž0-9\s]+$)/", $distribuidorVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $distribuidorErr = "Por favor introduzca un distribuidor válido con solo carávteres alfabéticos.";
    } else{
        $distribuidor= $distribuidorVal;
    }
    // Procesamos el stock
    $stockVal = filtrado(($_POST["stock"]));
    if(empty($stockVal)){
        $stockErr = "Por favor introduzca un stock válido con solo carávteres numericos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([0-9]+)/", $stockVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $stockErr = "Por favor introduzca un stock válido con solo carávteres numericos.";
    } else{
        $stock= $stockVal;
    }

    // Procesamos el precio
    $precioVal = filtrado(($_POST["precio"]));
    if(empty($precioVal)){
        $precioErr = "Por favor introduzca un precio válido con solo carávteres numericos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([0-9]+)/", $precioVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $precioErr = "Por favor introduzca un precio válido con solo carávteres numericos.";
    } else{
        $precio= $precioVal;
    }

    // Procesamos el descuento
    $descuentoVal = filtrado(($_POST["descuento"]));
    if(empty($descuentoVal)){
        $descuentoErr = "Por favor introduzca un descuento válido con solo carávteres numericos.";
        // Un ejemplo de validar expresiones regulares directamente desde PHP
    } elseif(!preg_match("/([0-9]+)/", $descuentoVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $descuentoErr = "Por favor introduzca un descuento válido con solo carávteres numericos.";
    } else{
        $descuento= $descuentoVal;
    }

     // Procesamos la foto
     $propiedades = explode("/", $_FILES['imagen']['type']);
     $extension = $propiedades[1];
     $tam_max = 50000; // 50 KBytes
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
    if(empty($nombreErr) && empty($tipoErr) && empty($distribuidorErr) && empty($stockErr) && 
        empty($precioErr) && empty($descuentoErr) && empty($imagenErr)){
        // creamos el controlador de alumnado
        $controlador = ControladorAlumno2::getControlador();
        $estado = $controlador->almacenarAlumno($nombre, $tipo, $distribuidor, $stock, $precio, $descuento, $imagen);
        if($estado){
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

}else{

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
                    <!-- $nombre = $tipo = $email = $password = $admin = $foto = $stock = $f_alta = ""; -->
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $nombreErr;?></span>
                        </div>
                        <!-- tipo-->
                        <div class="form-group <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>">
                            <label>tipo</label>
                            <input type="text" required name="tipo" class="form-control" value="<?php echo $tipo; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $tipoErr;?></span>
                        </div>
                        <!-- distribuidor-->
                        <div class="form-group <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>">
                            <label>distribuidor</label>
                            <input type="text" required name="distribuidor" class="form-control" value="<?php echo $distribuidor; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $distribuidorErr;?></span>
                        </div>
                        <!-- stock -->
                        <div class="form-group <?php echo (!empty($stockErr)) ? 'error: ' : ''; ?>">
                            <label>stock</label>
                            <input type="text" required name="stock" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $stock; ?>">
                            <span class="help-block"><?php echo $stockErr;?></span>
                        </div>
                        <!-- precio -->
                        <div class="form-group <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>">
                            <label>precio</label>
                            <input type="text" required name="precio" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precioErr;?></span>
                        </div>
                        <!-- descuento -->
                        <div class="form-group <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>">
                            <label>descuento</label>
                            <input type="text" required name="descuento" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $descuento; ?>">
                            <span class="help-block"><?php echo $descuentoErr;?></span>
                        </div>
                         <!-- Foto-->
                         <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                        <label>Fotografía</label>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" required name="imagen" class="form-control-file" id="imagen" accept=".png, .jpg">    
                        <span class="help-block"><?php echo $imagenErr;?></span>    
                        </div>
                        <!-- Botones --> 
                         <button type="submit" name= "aceptar" value="aceptar" class="btn btn-success"> <span class="glyphicon glyphicon-floppy-save"></span>  Aceptar</button>
                         <button type="reset" value="reset" class="btn btn-info"> <span class="glyphicon glyphicon-repeat"></span>  Limpiar</button>
                        <a href="../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
<!-- Pie de la página web -->