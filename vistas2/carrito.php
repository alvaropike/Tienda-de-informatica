<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php';
require_once VIEW_PATH.'navbar.php';
require_once CONTROLLER_PATH.'Paginador.php';
require_once CONTROLLER_PATH."ControladorProducto.php";
?>
<?php


if ($_SESSION['carrito'] <= 0) {
    echo"<h2>No hay ningun producto en el carrito</h2>";
    exit();
}
?>
<head>
<style>
#todo{
    width: 90%;
}
</style>
<head>
</br>
<div class='container-fluid' id="todo">
    <div class='row justify-content-center'>
        <h1>Carrito de la compra</h1>
    </div>
    <div class='row'>
        <table class='table'>
            <thead>
                <tr>
                    <th scope='col' hidden></th>
                    <th scope='col'></th>
                    <th scope='col'>Producto</th>
                    <th scope='col'>Precio</th>
                    <th scope='col'>Cantidad</th>
                    <th scope='col'>Total</th>
                    <th scope='col'></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $carrito = $_SESSION['carrito'];
                    for ($i = 0; $i < sizeof($carrito); $i++) {
                        $producto = $carrito[$i];
                ?>
                <form name="prodForm"  action="../controladores/ControladorCarrito.php" method="POST">
                    <tr>
                        <td hidden><input type="number" name="idprod" value="<?=$producto->getId()?>" /></td>
                        <td><img class='pic-2' src='../imagenes/productos/<?=$producto->getImagen()?>' width="80px"
                                alt='primera'></td>
                        <td class="align-middle"><?=$producto->getNombre()?></td>
                        <td class="align-middle"><?=$producto->getPrecio()?> €</td>

                        <td class="align-middle">
                            <button type="submit" class="btn btn-primary" name="resCantidad" value="Restar">
                                <span class="fas fa-minus"></span>
                            </button>

                            <input style="width: 2em" type="text" disabled name="cantidad" value="<?=$producto->getCantidad()?>">

                            <button type="submit" class="btn btn-primary" name="sumCantidad" value="Sumar">
                                <span class="fas fa-plus"></span>
                            </button>
                        </td>

                        <td class="align-middle"><?=$producto->getCantidad() * $producto->getPrecio()?> €</td>
                        <td class="align-middle">
                            <button type="submit" class="btn btn-danger" name="borrarPr" value="Borrar" data-toggle="modal" data-target="#modalConfirmDeleteItem">
                                <span class="far fa-trash-alt"></span>
                            </button>

                        </td>
                    </tr>

                </form>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
        $totalIVA=0;
        $total=0;
        $IVA=0;
        $descuentoTotal =0;
        foreach ($carrito as $producto) {
            $precio=$producto->getCantidad() * $producto->getPrecio();  
            $IVA=$IVA+($precio-($precio/1.21));
            $total=$total+($precio/1.21);
            // $totalIVA=$totalIVA+$IVA+$total;     
            $totalIVA=$total+$IVA;
            if($producto->getDescuento() >0){
                $descuentoTotal = $descuentoTotal+$producto->getPrecio()*$producto->getCantidad()*$producto->getDescuento()/100;
            }
        }
    ?>

    <div class="row">
        <div class="col-lg-4 col-sm-5 ml-auto">
          <table class="table table-clear">
            <tbody>
              <tr>
                <td class="left">
                  <strong>Subtotal</strong>
                </td>
                <td class="right"><?=(round($total,2))?> €</td>
              </tr>
              <tr>
                <td class="left">
                  <strong>I.V.A (21%)</strong>
                </td>
                <td class="right"><?=(round($IVA,2))?> €</td>
              </tr>
              <tr>
                <td class="left">
                  <strong>Descuento</strong>
                </td>
                <td class="right"><?=(round($descuentoTotal,2))?> €</td>
              </tr>
              <tr>
                <td class="left">
                  <strong>Total</strong>
                </td>
                <td class="right">
                  <strong><?=(round($totalIVA,2)-$descuentoTotal)?> €</strong>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>

    <form name="prodForm" action="../controladores/ControladorCarrito.php" method="POST">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
                <a class="btn btn-secondary far fa-arrow-alt-circle-left" href="catalogo.php"> Seguir Comprando</a>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-danger" name="vaciarCarrito" value="Vaciar" data-toggle="modal" data-target="#modalConfirmDeleteCarrito">
                    <span class="far fa-trash-alt"></span> <span>Vaciar Carrito</span>
                </button>
            </li>
            <li class="nav-item">
                <a class="btn btn-success fa fa-credit-card " href="pago.php"> Realizar Compra</a>
                
            </li>
        </ul>
            <!--Modal: modalConfirmDeleteCarrito-->
            <div class="modal fade" id="modalConfirmDeleteCarrito" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
                    <!--Content-->
                    <div class="modal-content text-center">
                        <!--Header-->
                        <div class="modal-header d-flex justify-content-center">
                            <p class="heading">¿Estas seguro que quieres borrar todo el carrito?</p>
                        </div>

                        <!--Body-->
                        <div class="modal-body">

                        <i class="fas fa-times fa-4x animated rotateIn"></i>
                        </div>

                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <button type="submit" name="vaciarCarrito" class="btn  btn-danger">Sí</button>
                            <a type="button" class="btn  btn-danger" data-dismiss="modal">No</a>
                        </div>
                    </div>
                    <!--/.Content-->
                </div>
            </div>
            <!--Modal: modalConfirmDeleteCarrito-->
        </form>
</div>

<?php
if(isset($_GET['stock'])){
    echo '<script type="text/javascript">alert("No hay stock de '.$_GET['stock'].'")</script>';
}
?>