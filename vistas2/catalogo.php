<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once VIEW_PATH."navbar.php";
require_once CONTROLLER_PATH."ControladorProducto.php";
require_once CONTROLLER_PATH."Paginador.php";
require_once UTILITY_PATH."funciones.php";
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<style>
@import "../css/catalogo.css";

h6{
    font-size: .7rem;
};
.post-title{
            display: table-cell;
            vertical-align: bottom;
            z-index: 2;
            position: relative;
        };
        .post-title b{
            background-color: rgba(51, 51, 51, 0.58);
            display: inline-block;
            margin-bottom: 5px;
            margin-left: 2px;
            color: #FFF;
            padding: 10px 15px;
            margin-top: 10px;
            font-size: 12px;
        };
        .post-title b:first-child{
            font-size: 14px;
        };
.round-tag{
            width: 60px;
            height: 60px;
            border-radius: 50% 50% 50% 0;
            border: 4px solid #FFF;
            background: #245da1;
            position: absolute;
            bottom: 0px;
            padding: 15px 6px;
            font-size: 17px;
            color: #FFF;
            font-weight: bold;
        };
</style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<h3 class="h3">Catalogo de Productos </h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
        <div class="form-group d-flex justify-content-center" >
            <div >
                <label class="" for="proucto"></label>  
                <input id="buscar" type="text" name="producto" placeholder="Buscar Producto" class="form-control input-md">
            </div>
            <button type="submit" class="btn btn-primary mb-3">BUSCAR <i class="fas fa-search"></i></button>
        </div>
    </form>
    <div class="container">
    <div class="row">
<?php
// creamos la consulta dependiendo si venimos o no del formulario
// para el buscador: select * from alumnado where nombre like "%%" or apellidos like "%%"
if (!isset($_POST["producto"])) {
$nombre = "";
} else {
$nombre = filtrado($_POST["producto"]);
}
// Cargamos el controlador de alumnos
$controlador = ControladorProducto::getControlador();

// Parte del paginador
$pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;



//$lista = $controlador->listarAlumnos($nombre, $dni); //-- > Lo hará el paginador

$consulta = "SELECT * FROM producto WHERE nombre LIKE :nombre order by nombre";
$parametros = array(':nombre' => "%".$nombre."%");
$limite = 8; // Limite del paginador
$paginador  = new Paginador($consulta, $parametros, $limite);
$resultados = $paginador->getDatos($pagina);


if(count( $resultados->datos)>0){
    foreach ($resultados->datos as $a) {
    $producto = new Producto($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->stock, $a->precio, $a->descuento, $a->imagen);
    // Pintamos cada fila
    echo "<div class='col-md-3 col-sm-6'>";
    echo "<div class='product-grid2'>";
    echo "<div class='product-image2'>";
    // echo "<a href='read.php?id=" . encode($producto->getId()) . "'><img class='pic-1' src='../imagenes/productos/".$producto->getImagen()."' alt='primera'></a>";
    echo "<a href='read.php?id=" . encode($producto->getId()) . "'>";
    echo "<img class='pic-1' src='../imagenes/productos/".$producto->getImagen()."' alt='primera'>";
    echo "<img class='pic-2' src='../imagenes/productos/".$producto->getImagen()."' alt='primera'></a>";
    echo "<ul class='social'>";
    echo "<li><a href='read.php?id=" . encode($producto->getId()) . "' data-tip='Ver Producto'><i class='fa fa-eye'></i></a></li>";
    // echo "<li><a href='#' data-tip='Añadir al carro'><i class='fa fa-shopping-cart'></i></a></li>";
    echo "</ul>";
    // echo "<a class='add-to-cart' href=''>Añadir al carro</a>";

    if (isset($_SESSION['id'])) {
        // Metemos al carrito.
        echo "<a href='/AppWeb/tiendaInformatica/Tienda-de-informatica/controladores/ControladorCarrito.php?id=" . encode($producto->getId()) ."' class='add-to-cart' value='bottom-right'  >Comprar</a>";
    } else {
        echo "<a href='/AppWeb/tiendaInformatica/Tienda-de-informatica/vistas/login.php' class='add-to-cart'>Comprar</a>";
    }

    echo "<a href ='/AppWeb/tiendaInformatica/Tienda-de-informatica/vistas2/read.php?id='" . encode($producto->getId())."'>";
    echo "</div>";
    echo "<div class='product-content'>";
    echo "<h3 class='title'><a href='read.php?id=" . encode($producto->getId()) . "'>". $producto->getNombre() ."</a></h3>";
    echo "<h6>". ($producto->getTipo()) ."</h6>"; 
    echo "<span class='price'>". $producto->getPrecio() ."€</span>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "<ul class='pagination mx-auto justify-content-center' id='no_imprimir'>"; //  <ul class="pagination">
    echo $paginador->crearLinks($enlaces);
    echo "</ul>";
} else {
// Si no hay nada seleccionado
echo "<p class='lead'><em>No se ha encontrado datos del producto.</em></p>";
}


?>

<script type="text/javascript">


toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "1000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
        
// Toast Type
    $('.add-to-cart').click(function(event) {
        toastr.success('Producto añadido correctamente');
    });
</script>

<?php
if(isset($_GET['stock'])){
    echo '<script type="text/javascript">alert("No hay stock de '.$_GET['stock'].'")</script>';
}
?>