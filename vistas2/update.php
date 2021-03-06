<?php
      error_reporting(E_ALL & ~E_NOTICE);
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
require_once VIEW_PATH."navbar.php"; 

session_start();
if(isset($_SESSION['USUARIO']['email'])){
    if($_SESSION['admin'] != "si"){
        header("location: /AppWeb/tiendaInformatica/Tienda-de-informatica/vistas/error.php");
        exit();
    }
}
 
// Variables temporales
$nombre = $tipo = $distribuidor = $stock = $precio = $descuento = $imagen = $imagenAnterior ="";
$nombreErr = $tipoErr = $distribuidorErr = $stockErr = $precioErr = $descuentoErr = $imagenErr = "";
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
    } elseif(!preg_match("/([^\s][A-zÀ-ž0-9\s]+$)/", $nombreVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $nombreErr = "Por favor introduzca un nombre válido con solo carávteres alfabéticos.";
        $errores[]= $nombreErr;
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
        $errores[]= $tipoErr;
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
        $errores[]= $distribuidorErr;
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
        $errores[]= $stockErr;
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
        $errores[]= $precioErr;
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
        $errores[]= $descuentoErr;
    } else{
        $descuento= $descuentoVal;
    }

    // Procesamos la imagen
    // Si nos ha llegado algo mayor que cer
    if($_FILES['imagen']['size']>0 && count($errores)==0){
        $propiedades = explode("/", $_FILES['imagen']['type']);
        $extension = $propiedades[1];
        $tam_max = 5000000; // 50 KBytes
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
            $controlador = ControladorImagen2::getControlador();
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
     if(empty($nombreErr) && empty($tipoErr) && empty($distribuidorErr) && empty($stockErr) && 
     empty($precioErr) && empty($descuentoErr) && empty($imagenErr)){
     // creamos el controlador de alumnado
     $controlador = ControladorProducto::getControlador();
     $estado = $controlador->actualizarAlumno($id, $nombre, $tipo, $distribuidor, $stock, $precio, $descuento, $imagen);
     if($estado){
        $errores=[];
         //El registro se ha lamacenado corectamente
         //alerta("Alumno/a creado con éxito");
         header("location: ../Producto.php");
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
        $controlador = ControladorProducto::getControlador();
        $alumno = $controlador->buscarAlumno($id);
        if (!is_null($alumno)) {
            $nombre = $alumno->getNombre();
            $tipo = $alumno->getTipo();
            $distribuidor = $alumno->getDistribuidor();
            $stock = $alumno->getStock();
            $precio = $alumno->getPrecio();
            $descuento = $alumno->getDescuento();
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

    <!-- Cuerpo de la página web --> 
        <div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper justify-content-center align-items-center">
        <div class="div-to-align">
                        <h2>Actualizar productos</h2>
                    </div>
                    <!-- Formulario-->
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
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
                            <label>Tipo</label>
                            <input type="text" required name="tipo" class="form-control" value="<?php echo $tipo; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $tipoErr;?></span>
                        </div>
                        <!-- distribuidor-->
                        <div class="form-group <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>">
                            <label>Distribuidor</label>
                            <input type="text" required name="distribuidor" class="form-control" value="<?php echo $distribuidor; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $distribuidorErr;?></span>
                        </div>
                        <!-- stock -->
                        <div class="form-group <?php echo (!empty($stockErr)) ? 'error: ' : ''; ?>">
                            <label>Stock</label>
                            <input type="text" required name="stock" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $stock; ?>">
                            <span class="help-block"><?php echo $stockErr;?></span>
                        </div>
                        <!-- precio -->
                        <div class="form-group <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>">
                            <label>Precio</label>
                            <input type="text" required name="precio" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precioErr;?></span>
                        </div>
                        <!-- descuento -->
                        <div class="form-group <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>">
                            <label>Descuento</label>
                            <input type="text" required name="descuento" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $descuento; ?>">
                            <span class="help-block"><?php echo $descuentoErr;?></span>
                        </div>
                         <!-- Foto-->
                         <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                        <label>Fotografía</label>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" name="imagen" class="form-control-file" id="imagen" accept=".png, .jpg">    
                        <span class="help-block"><?php echo $imagenErr;?></span>    
                        </div>
                        <!-- Botones --> 
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                        <button type="submit" value="aceptar" class="btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Modificar</button>
                        <a href="../Producto.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>