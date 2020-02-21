<?php
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

// Incluimos los directorios a trabajar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
// require_once CONTROLLER_PATH."ControladorProducto.php";
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
    } elseif(!preg_match("/[0-9]{0,2}/", $descuentoVal)) { //filter_var($nombreVal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([^\s][A-zÀ-ž\s]+$)/")))){
        $descuentoErr = "Por favor introduzca un descuento válido con solo carávteres numericos.";
    } else{
        $descuento= $descuentoVal;
    }

     // Procesamos la foto
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
         $controlador = ControladorImagen2::getControlador();
         if(!$controlador->salvarImagen($imagen)){
             $imagenErr= "Error al procesar la imagen y subirla al servidor";
         }
     }

    // Chequeamos los errores antes de insertar en la base de datos
    if(empty($nombreErr) && empty($tipoErr) && empty($distribuidorErr) && empty($stockErr) && 
        empty($precioErr) && empty($descuentoErr) && empty($imagenErr)){
        // creamos el controlador de alumnado
        $controlador = ControladorProducto::getControlador();
        $estado = $controlador->almacenarAlumno($nombre, $tipo, $distribuidor, $stock, $precio, $descuento, $imagen);
        if($estado){
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

}else{

}
?>
 
<!-- Cabecera de la página web -->
    <!-- Cuerpo de la página web --> 
    <div class="col-10 offset-1 col-lg-8 offset-lg-2 div-wrapper justify-content-center align-items-center">
        <div class="div-to-align">
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> 
            <fieldset> 
                        <!-- Form Name -->
                        <h2>Añadir Productos</h2>
                        <!-- Nombre-->
                        <div class="form-group <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Nombre</label>  
                                <div class="col-md-7">
                            <input type="text" required name="nombre" class="form-control" value="<?php echo $nombre; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9-\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $nombreErr;?></span>
                        </div>
                        </div>
                        <!-- tipo-->
                        <div class="form-group <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Tipo</label>  
                                <div class="col-md-7">
                            <input type="text" required name="tipo" class="form-control" value="<?php echo $tipo; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $tipoErr;?></span>
                        </div>
                        </div>
                        <!-- distribuidor-->
                        <div class="form-group <?php echo (!empty($distribuidorErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Distribuidor</label>  
                                <div class="col-md-7">
                            <input type="text" required name="distribuidor" class="form-control" value="<?php echo $distribuidor; ?>" 
                                pattern="([^\s][A-zÀ-ž0-9\s]+)"
                                minlength="3">
                            <span class="help-block"><?php echo $distribuidorErr;?></span>
                        </div>
                        </div>
                        <!-- stock -->
                        <div class="form-group <?php echo (!empty($stockErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Stock</label>  
                                <div class="col-md-7">
                            <input type="text" required name="stock" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $stock; ?>">
                            <span class="help-block"><?php echo $stockErr;?></span>
                        </div>
                        </div>
                        <!-- precio -->
                        <div class="form-group <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Precio</label>  
                                <div class="col-md-7">
                            <input type="text" required name="precio" class="form-control" pattern="([0-9]+)" title="Solo numeros enteros positivos" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precioErr;?></span>
                        </div>
                        </div>
                        <!-- descuento -->
                        <div class="form-group <?php echo (!empty($descuentoErr)) ? 'error: ' : ''; ?>">
                        <label class="col-md-4 control-label" for="textinput">Descuento</label>  
                                <div class="col-md-7">
                            <input type="text" required name="descuento" class="form-control" pattern="([0-9]{0,2})" title="Solo numeros enteros positivos" value="<?php echo $descuento; ?>">
                            <span class="help-block"><?php echo $descuentoErr;?></span>
                        </div>
                        </div>
                         <!-- Foto-->
                         <div class="form-group <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                         <label class="col-md-4 control-label" for="textinput">Fotografia</label>  
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
                        <a href="../Producto.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<br><br><br>
<!-- Pie de la página web -->