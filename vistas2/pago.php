<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php';
require_once VIEW_PATH.'navbar.php';
// require_once CONTROLLER_PATH.'Paginador.php';
?>
<head>
<link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">  
<style>
@import "../css/progress.css";
.container {max-width: 960px;}
.border-top { border-top: 1px solid #e5e5e5; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }
.border-top-gray { border-top-color: #adb5bd; }
.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
.lh-condensed { line-height: 1.25; }

</style>
</head>
<script>
function checkdate(){
  var fecha = document.getElementById('cc-expiration').value;
  var fechas = fecha.split('/');
  var actyear = new Date().getFullYear();
  var actmonth = new Date().getMonth()+1;
  var anio = parseInt(fechas[1]);
  var mes = parseInt(fechas[0]);

if(anio > actyear){
  return true;
}
  if(anio === actyear){

    if(mes >= actmonth){
      return true;
    }else{
      alert("No puedes comprar con una tarjeta caducada");
      return false;
    }
  }else{
    alert("No puedes comprar con una tarjeta caducada");
    return false;
  }
}
</script>
<div class="checkout-wrap">
  <ul class="checkout-bar">
    <li class="visited first"><a href="#">Login</a></li>
    <li class="previous visited">Productos</li>
    <li class="active">Pago y Envio</li> 
    <li class="">Facturación</li>        
  </ul>
  <br>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Resumen</span>
      </h4>
      <ul class="list-group mb-3"></ul>
      <?php
      $carrito = $_SESSION['carrito'];
        $totalIVA=0;
        $total=0;
        $IVA=0;
        $descuentoTotal =0;
        foreach ($carrito as $producto) {
            $precio=$producto->getCantidad() * $producto->getPrecio();  
            $IVA=$IVA+($precio-($precio/1.21));
            $total=$total+($precio/1.21);    
            $totalIVA=$total+$IVA;
            if($producto->getDescuento() >0){
              $descuentoTotal = $descuentoTotal+$producto->getPrecio()*$producto->getCantidad()*$producto->getDescuento()/100;
          }
        }

          
              for ($i = 0; $i < sizeof($carrito); $i++) {
                  $producto = $carrito[$i];
        ?>
        <li class="list-group-item d-flex justify-content-between lh-sm">
          <div>
          <img class='pic-2' src='../imagenes/productos/<?=$producto->getImagen()?>' width="50px" alt='primera'> <?=$producto->getNombre()?>
          </div>
          <span class="text-muted"><?=$producto->getCantidad() * $producto->getPrecio()-$producto->getPrecio()*$producto->getDescuento()/100?> €</span>
        </li>
        <?php } ?>
        <li class="list-group-item d-flex justify-content-between">
          <span>Total</span>
          <strong><?=(round($totalIVA,2)-$descuentoTotal)?> €</strong>
        </li>
      </ul>
    </div>

    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Dirección de Envio</h4>
      <form action="facturacion.php" onsubmit="return checkdate()" method="post" class="form-horizontal">
        <div class="row">
          <div class="col-md-5 mb-3">
            <label for="firstName">Nombre</label>
            <input type="text" class="form-control" name="nombre" id="firstName" placeholder="" value="" required>
            <div class="invalid-feedback">
              Nombre Requerido
            </div>
          </div>

          <div class="col-md-5 mb-3">
            <label for="lastName">Apellidos</label>
            <input type="text" class="form-control" name="apellido" id="lastName" placeholder="" value="" required>
            <div class="invalid-feedback">
              Apellido Requerido
            </div>
          </div>
        </div>

        <div class="row">
        <div class="col-md-10 mb-3">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="tu@ejemplo.com" required>
          <div class="invalid-feedback">
            Porfavor introduce un email valido.
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-10 mb-3">
          <label for="address">Direccion 1</label>
          <input type="text" class="form-control" name="direccion" id="address" placeholder="Calle Ancha 23" required>
          <div class="invalid-feedback">
            Porfavor, introduce tu direccion de envio
          </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-10 mb-3">
          <label for="address2">Dirección 2<span class="text-muted"> (Opcional)</span></label>
          <input type="text" class="form-control" id="address2" placeholder="">
        </div>
        </div>

        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="form-group">
              <label>Provincia</label>  
                <select name="admin" class="form-control" required>
                  <option value="">Elige...</option>
                  <option>Ciudad Real</option>
                  <option>Toledo</option>
                  <option>Albacete</option>
                  <option>Guadalajara</option>
                  <option>Cuenca</option>
              </select>
              <div class="invalid-feedback">
                    Introduce una provincia
                  </div>
            </div>
          </div>

          <div class="col-md-3 mb-3">
          <div class="form-group">
            <label>Ciudad</label>  
              <select name="admin" class="form-control" required>
                <option value="">Elige...</option>
                <option>Puertollano</option>
                <option>Oropesa</option>
                <option>Almansa</option>
                <option>Atienza</option>
                <option>Huete</option>
              </select>
              <div class="invalid-feedback">
                    Introduce una ciudad
                </div>
          </div>
          </div>

          <div class="col-md-4 mb-3">
            <label for="zip">Codigo Postal</label>
            <input type="text" class="form-control" id="zip" placeholder="" pattern="([0-9]{5})" required>
            <div class="invalid-feedback">
              Codigo postal valido Requerido
            </div>
          </div>
        </div>
        <hr class="mb-4">

        <h4 class="mb-3">Pago</h4>

        <div class="d-block my-3">
          <div class="form-check">
            <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
            <label class="form-check-label" for="credit">Tarjeta de credito</label>
          </div>
          <div class="form-check">
            <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
            <label class="form-check-label" for="debit">Tarjeta de debito</label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 mb-3">
            <label for="cc-name">Tarjeta de credito</label>
            <input type="text" class="form-control" id="cc-name" placeholder="" required>
            <small class="text-muted">Todo el nombre que aparezca en la tarjeta</small>
            <div class="invalid-feedback">
              Nombre de la tarjeta Requerido
            </div>
          </div>
          <div class="col-md-5 mb-3">
            <label for="cc-number">Número de la tarjeta de credito</label>
            <input type="text" class="form-control" id="cc-number" pattern="([0-9]{16})" title="tiene que contener 16 digitos" placeholder="" required>
            <div class="invalid-feedback">
              Numero de tarjeta de credito Requerido
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <label for="cc-expiration">Caducidad</label>
            <input type="text" class="form-control" id="cc-expiration" pattern="([0-9]{2}/[0-9]{4})" title="Ejemplo 01/2021"  placeholder="01/2021" required>
            <div class="invalid-feedback">
              Fecha de caducidad Requerida
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <label for="cc-cvv">CVV</label>
            <input type="text" class="form-control" id="cc-cvv" pattern=([0-9]{3}) title="CVV son 3 digitos" placeholder="" required>
            <div class="invalid-feedback">
              Codigo de seguridad valido Requerido
            </div>
          </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Finalizar Compra</button>
      </form>
    </div>
  </div>

</div>

    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>