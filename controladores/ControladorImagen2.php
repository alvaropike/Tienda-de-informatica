<?php
    // Incluimos los ficheros que ncesitamos
    require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
    require_once CONTROLLER_PATH."ControladorProducto.php";
    require_once UTILITY_PATH."funciones.php";



    /**
     * Controlador de descargas
     */
class ControladorImagen2 {
    
    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorImagen2();
        }
        return self::$instancia;
    }

    function salvarImagen($imagen) {
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], IMAGE_PATH2 . $imagen)) {
            return true;
        }
        return false;
    }
    
    function eliminarImagen($imagen) {
        $fichero = IMAGE_PATH2 . $imagen;
        if (file_exists($fichero)) {
            unlink($fichero); // Funcion para borrar desde el servidor
            return true;
            //throw new Exception('No se puede borrar el fichero ' . $fichero . ' Por favor cierre otras aplicaciones que lo pueden estar usando.');
        }
        return false;;
    }

}

?>