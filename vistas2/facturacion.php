<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php';
require_once VIEW_PATH.'navbar.php';
require_once CONTROLLER_PATH.'Paginador.php';
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
            <a href="javascript:window.print()" class="btn btn-info"><i class="fas fa-print"></i> Imprimir </a>
            <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> PDF</button>
            <hr>
        </div>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <img class="navbar-brand" src="https://s3.amazonaws.com/designmantic-logos/logos/2020/Jan/medium-4645-5e21d5ac477de.png" width="220px">
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="https://lobianijs.com">
                            InforShop
                            </a>
                        </h2>
                        <div>Paseo San Gregorio 24</div>
                        <div>684090929</div>
                        <div>compras@inforshop.com</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">Facturado a:</div>
                        <h2 class="to">John Doe</h2>
                        <div class="address">796 Silver Harbour, TX 79273, US</div>
                        <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE 3-2-1</h1>
                        <div class="date">Date of Invoice: 01/10/2018</div>
                        <div class="date">Due Date: 30/10/2018</div>
                    </div>
                </div>
                <table cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-left">Producto</th>
                            <th class="text-right">Precio</th>
                            <th class="text-right">IVA</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="no"></td>
                            <td class="text-left"><h3>
                                <a target="_blank" href="https://www.youtube.com/channel/UC_UMEcP_kF0z4E6KbxCpV1w">
                                Youtube channel
                                </a>
                                </h3>
                               <a target="_blank" href="https://www.youtube.com/channel/UC_UMEcP_kF0z4E6KbxCpV1w">
                                   Useful videos
                               </a> 
                               to improve your Javascript skills. Subscribe and stay tuned :)
                            </td>
                            <td class="unit">$0.00</td>
                            <td class="qty">100</td>
                            <td class="total">$0.00</td>
                        </tr>
                        <tr>
                            <td class="no"></td>
                            <td class="text-left"><h3>Website Design</h3>Creating a recognizable design solution based on the company's existing visual identity</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">30</td>
                            <td class="total">$1,200.00</td>
                        </tr>
                        <tr>
                            <td class="no"></td>
                            <td class="text-left"><h3>Website Development</h3>Developing a Content Management System-based Website</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">80</td>
                            <td class="total">$3,200.00</td>
                        </tr>
                        <tr>
                            <td class="no"></td>
                            <td class="text-left"><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">20</td>
                            <td class="total">$800.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>$5,200.00</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">I.V.A 21%</td>
                            <td>$1,300.00</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TOTAL</td>
                            <td>$6,500.00</td>
                        </tr>
                    </tfoot>
                </table>
            </main>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>