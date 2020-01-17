<?php
// Incluimos los directorios a trabajar
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH."ControladorUsuario.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
?>
<?php require_once "navbar.php"; ?>


<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Añadir usuario</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Nombre</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" type="text" placeholder="Nombre" class="form-control input-md" required="">
  <span class="help-block">Longitud mínima 3</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Apellido">Apellido</label>  
  <div class="col-md-4">
  <input id="Apellido" name="Apellido" type="text" placeholder="Apellido" class="form-control input-md" required="">
  <span class="help-block">Longitud minima 3</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Email">Email</label>  
  <div class="col-md-4">
  <input id="Email" name="Email" type="text" placeholder="Email" class="form-control input-md" required="">
  <span class="help-block">test@test.com</span>  
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">contraseña</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="contraseña" class="form-control input-md" required="">
    <span class="help-block">contraseña</span>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="admin">admin</label>
  <div class="col-md-4">
    <select id="admin" name="admin" class="form-control">
      <option value="Si">Si</option>
      <option value="No">No</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="telefono">telefono</label>  
  <div class="col-md-4">
  <input id="telefono" name="telefono" type="text" placeholder="telefono" class="form-control input-md" required="">
  <span class="help-block">9 digitos</span>  
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="foto">foto</label>
  <div class="col-md-4">
    <input id="foto" name="foto" class="input-file" type="file">
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit">Enviar</label>
  <div class="col-md-8">
    <button id="submit" name="submit" class="btn btn-success">Enviar</button>
    <button id="Atras" name="Atras" class="btn btn-primary">Atras</button>
  </div>
</div>

</fieldset>
</form>
