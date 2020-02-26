<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php';
require_once VIEW_PATH.'navbar.php';
require_once CONTROLLER_PATH."ControladorProducto.php";
?>

<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->
<head>
<title>Factura</title>
<style>
@import "../css/progress.css";
@import"../css/facturacion.css";
@media print {.no-print, br{display: none !important;}}
#invoice{width:80%;margin: auto;padding: 10px;}
</style>
</head>
<?php
    $carrito = $_SESSION['carrito'];

    $controlador = ControladorProducto::getControlador();
    foreach ($carrito as $producto) {
        $controlador->actualizarStock($producto->getId(),$producto->getCantidad());
    }
    
    $idFactura = rand(0,99999);
    $controlador->generarFactura($idFactura);
    $factura = $controlador->buscarFactura($idFactura);

?>

<div class="checkout-wrap no-print">
  <ul class="checkout-bar">
    <li class="visited first"><a href="#">Login</a></li>
    <li class="previous visited">Productos</li>
    <li class="previous visited">Pago y Envio</li> 
    <li class="active">Facturación</li>   
    <li class="">Complete</li>      
  </ul>
  <br>
</div>
<div id="invoice">
    <div class="toolbar hidden-print">
        <div class="text-right no-print">
            <a href="javascript:window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir </a>
            <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> PDF</button>
            <a href="../utilidades/descargar2.php?opcion=Factura&id=all" class="btn btn-rounded btn-primary ml-auto" target="_blank"><span class="fas far fa-file-pdf pl-1"></span>  PDF</a>
            <hr>
        </div>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <img class="navbar-brand" name="foto" src="https://s3.amazonaws.com/designmantic-logos/logos/2020/Jan/medium-4645-5e21d5ac477de.png" width="220px">
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="https://lobianijs.com">
                            InforShop
                            </a>
                        </h2>
                        <div>Paseo San Gregorio 24</div>
                        <div>684 09 09 29</div>
                        <div>compras@inforshop.com</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">Facturado a:</div>
                        <h2 class="to"><?=$_REQUEST['nombre'];?> <?=$_REQUEST['apellido'];?></h2>
                        <div class="address"><?=$_REQUEST['direccion'];?></div>
                        <div class="email"><a href="mailto:<?=$_REQUEST['email'];?>"><?=$_REQUEST['email'];?></a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">Factura:<?=$factura?> </h1>
                        <div class="date">Fecha de la Factura: <?=date("d/m/Y", time());?></div>
                    </div>
                </div>
                <table cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-left">Producto</th>
                            <th class="text-right">Precio</th>
                            <th class="text-right">Cantidad</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $carrito = $_SESSION['carrito'];
                            for ($i = 0; $i < sizeof($carrito); $i++) {
                                $producto = $carrito[$i];
                    ?>
                        <tr>
                            <td class="no"></td>
                            <td class="text-left"><h3><img class='pic-2' src='../imagenes/productos/<?=$producto->getImagen()?>' width="50px" alt='primera'> <?=$producto->getNombre()?></h3></td>
                            <td class="unit"><?=$producto->getPrecio()?> €</td>
                            <td class="qty"><?=$producto->getCantidad()?></td>
                            <td class="total"><?=$producto->getCantidad() * $producto->getPrecio()?> €</td>
                        </tr>
                        <?php } ?>
                    </tbody>
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
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td><?=(round($total,2))?> €</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">I.V.A. 21%</td>
                            <td><?=(round($IVA,2))?> €</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Descuento</td>
                            <td><?=(round($descuentoTotal,2))?> €</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TOTAL</td>
                            <td><?=(round($totalIVA,2)-$descuentoTotal)?> €</td>
                        </tr>
                    </tfoot>
                </table>
            </main>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>

<?php

unset($_SESSION['carrito']);

?>