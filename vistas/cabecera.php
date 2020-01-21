<!-- Cabecera de las páginas web común a todos -->

<?php 
// Coockie contador
//Importante: las cookies se envían al cliente mediante encabezados HTTP. 
//Como cualquier otro encabezado, las cookies se deben enviar antes que cualquier salida que genere la página 
//(antes que <html>, <head> o un simple espacio en blanco).
  if(isset($_COOKIE['CONTADOR']))
  { 
    // Caduca en un día
    setcookie('CONTADOR', $_COOKIE['CONTADOR'] + 1, time() + 24 * 60 * 60); // un día
    $contador = 'Número de visitas hoy: ' . $_COOKIE['CONTADOR']; 
  } 
  else 
  { 
    // Caduca en un día
    setcookie('CONTADOR', 1, time() + 24 * 60 * 60); 
    $cotador = 'Número de visitas hoy: 1'; 
  } 
  if(isset($_COOKIE['ACCESO']))
  { 
    // Caduca en un día
    setcookie('ACCESO', date("d/m/Y  H:i:s"), time() + 39*60*60 + 27*60 + 5); // 39h+27minutos+5segundos
    $acceso = '<br>Último acceso: ' . $_COOKIE['ACCESO']; 
  } 
  else 
  { 
    // Caduca en un día
    setcookie('ACCESO', date("d/m/Y  H:i:s"), time() + 39*60*60 + 27*60 + 5); // 39h+27minutos+5segundos
    $acceso = '<br>Último acceso: '. date("d/m/Y  H:i:s"); 
  } 
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Tienda de informatica</title>
        
<style type="text/css">
.pull-right {
  float: right !important;
}

</style>

        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>
    <body>
<!-- Cabecera de las páginas web común a todos -->
<!-- Barra de Navegacion -->
<?php require_once VIEW_PATH."navbar.php"; ?>