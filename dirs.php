<?php 

// Definimos con una constante cada uno de los directorios que tenemos para poder llamarlos
if ( !defined('ROOT_PATH') )
    define('ROOT_PATH', dirname(__FILE__)."/");

if ( !defined('MODEL_PATH') )
    define('MODEL_PATH', ROOT_PATH."modelos/");

if ( !defined('VIEW_PATH') )
    define('VIEW_PATH', ROOT_PATH."vistas/");

if ( !defined('VIEW_PATH2') )
    define('VIEW_PATH2', ROOT_PATH."vistas2/");

if ( !defined('CONTROLLER_PATH') )
    define('CONTROLLER_PATH', ROOT_PATH."controladores/");

if ( !defined('CONTROLLER_PATH2') )
    define('CONTROLLER_PATH2', ROOT_PATH."controladores2/");

if ( !defined('UTILITY_PATH') )
    define('UTILITY_PATH', ROOT_PATH."utilidades/");

if ( !defined('IMAGE_PATH') )
    define('IMAGE_PATH', ROOT_PATH."imagenes/usuarios/");

if ( !defined('VENDOR_PATH') )
    define('VENDOR_PATH', ROOT_PATH."vendor/");

?>