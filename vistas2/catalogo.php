<?php
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH . "ControladorCatalogo.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once CONTROLLER_PATH . "Paginador.php";


// Recogemos el tipo de catalogo
$opcion = "";
if (isset($_GET["tipo"]) && !empty(trim($_GET["tipo"]))) {
    $tipo = trim($_GET["tipo"]);
    switch ($tipo) {
    case "Fuente":
        $opcion= "Fuente";
        break;
    case "Grafica":
        $opcion= "Grafica";
        break;
    case "Portatiles":
        $opcion= "Portatiles";
        break;
    case "Ofertas":
        $opcion= "Ofertas";
        break;
    }

}
// Marca o Modelo
if (isset($_GET["filter"]) && !empty(trim($_GET["filter"]))) {
    $filtro = $_GET["filter"];
} else{
    $filtro ="";
}

// Procesamos el buscador
if (isset($_POST["filter"])) {
    $filtro = $_POST["filter"];
    $opcion = $_POST["opcion"];
}

 // Consulta a realizar
$controlador = ControladorCatalogo::getControlador();
$consulta = $controlador->getConsultaCatalogo($filtro, $filtro, $opcion);
//echo $consulta;

// Configuramos el paginador
$filas = 2;
$columnas = 4;
$limite = $filas * $columnas; // Dos filas de 4

$pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$enlaces = ( isset($_GET['limit']) ) ? $_GET['limit'] : 10;

$paginador  = new Paginador($consulta, $limite);
$resultados = $paginador->getDatos($pagina);


?>

<!-- Codigo HTML -->
<main role="main">

    <section class="page-header clearfix text-center">
        <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group mx-sm-5 mb-2">
                        <input type="text" class="form-control" id="buscar" name="filter" placeholder="Marca o Modelo">
                    </div>
                    <input type="hidden" name="opcion" value="<?php echo $opcion; ?>"/>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar en <?php echo $opcion; ?></button>
                </form>
    </section>

    <div class="container">
        
        <?php
        if (count( $resultados->datos)>0) {
            // Contador de items
            $item = 0;
            // Inicio de Fila
            echo $controlador->filaInicio();
            // Sacamos los resultados
            foreach($resultados->datos as $dato){
                // Obtenemos el producto
                $producto = new Producto($dato["ID"], $dato["TIPO"], $dato["MARCA"], $dato["MODELO"], $dato["DESCRIPCION"], $dato["PRECIO"], 
                            $dato["STOCK"], $dato["OFERTA"], $dato["FOTO"]);
                // Imprimimos los resultados
                echo $controlador->getProducto($producto, base64_encode("principal.php"));
                $item++;
                if($item % $columnas == 0){
                    $controlador->filaFin();
                    echo $controlador->filaInicio();
                }
            }
            $controlador->filaFin();
            // Paginador
                echo "<div class='text-center'>"; // Para centrar
                echo "<ul class='pagination'>"; //  <ul class="paginationr">
                    echo $paginador->crearLinks($enlaces, $filtro, $pagina);
                echo "</ul>";
                echo "</div>";
            
        } else {
                // Si no hay nada seleccionado
            echo "<p class='lead'><em>No se ha encontrado datos de productos.</em></p>";
        }
        ?>


    </div>

</main>

<!-- Codigo HTML -->