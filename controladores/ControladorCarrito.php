<?php
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once MODEL_PATH."Producto.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once UTILITY_PATH."funciones.php";  


session_start();

$controlador = ControladorProducto::getControlador();

if (isset($_GET["id"]) && !empty($_GET["id"])){
    $id = decode($_GET['id']);
    if(isset($_SESSION['carrito'])){
        $carrito = $_SESSION['carrito'];

        $prod = $controlador->buscarAlumno($id);
        // print_r ($producto);
        $contador = 0;
        $index = 0;
        $existe=false;
        foreach ($carrito as $producto) {
            // echo"</br></br>";
            // print_r($producto->getId());
            if($prod->getId() == $producto->getId()) {
                // echo"</br></br>me añado";
                $prodMod = $producto;
                $prodMod->sumCarrito();
               $existe=true;
               $index = $contador;
            }
            $contador++;
        }
        if($existe){ 
            $carrito[$index] = $prodMod;
        } else {
            $prod->sumCarrito();
            $carrito[sizeof($carrito)] = $prod;
        }
        $_SESSION['carrito'] = $carrito;
    }else{
        // echo "</br></br>me añado, soy un producto nuevo" ;
        $producto = $controlador->buscarAlumno($id);
        $producto->sumCarrito();
        $carrito[0]=$producto;
        $_SESSION['carrito'] = $carrito; 
    }
    sleep(1);
    header("location: ../vistas2/catalogo.php?add=si"); 

}


if (isset($_REQUEST['borrarPr'])) {
    $id = $_REQUEST['idprod'];
    
    $carrito = $_SESSION['carrito'];
        $contador = 0;
        $index = 0;
        foreach ($carrito as $producto) {
            if($producto->getId()==$id){
               $index = $contador;
            }
            $contador++;
        }

        $carrito[$index] = null;
        $contNormal = 0;
        for ($i=0; $i < sizeof($carrito) ; $i++) { 
            if ($carrito[$i] != null) {
                $carritoNuevo[$contNormal] = $carrito[$i];
                $contNormal++;
            }
        }
        
        $_SESSION['carrito'] = $carritoNuevo;
        // print_r($_SESSION['carrito']);
        header("location: ../vistas2/carrito.php"); 
}

if (isset($_REQUEST['resCantidad'])) {
    $id = $_REQUEST['idprod'];
    
    $carrito = $_SESSION['carrito'];
    $prod = $controlador->buscarAlumno($id);
        $contador = 0;
        $index = 0;
        foreach ($carrito as $producto) {
            if($prod->getId() == $producto->getId()) {
                $prodMod = $producto;
                if($producto->getCantidad() <= 1){
                    header("location: ../vistas2/carrito.php"); 
                    exit();
                }
                $prodMod->resCarrito();
                $index = $contador;
            }
            $contador++;
        }

        $carrito[$index] = $prodMod;

        $_SESSION['carrito'] = $carrito;
        // print_r($_SESSION['carrito']);
        header("location: ../vistas2/carrito.php"); 
}

if (isset($_REQUEST['sumCantidad'])) {
    $id = $_REQUEST['idprod'];
    
    $carrito = $_SESSION['carrito'];
    $prod = $controlador->buscarAlumno($id);
        $contador = 0;
        $index = 0;
        foreach ($carrito as $producto) {
            if($prod->getId() == $producto->getId()) {
                $prodMod = $producto;
                $prodMod->sumCarrito();
                $index = $contador;
            }
            $contador++;
        }

        $carrito[$index] = $prodMod;

        $_SESSION['carrito'] = $carrito;

        header("location: ../vistas2/carrito.php"); 
}

if (isset($_REQUEST['vaciarCarrito'])){
    //eliminamos esa linea del array completa
    unset($_SESSION['carrito']);
    header("location: ../vistas2/catalogo.php"); 
}

?>