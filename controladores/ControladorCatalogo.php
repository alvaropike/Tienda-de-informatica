<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
// require_once CONTROLLER_PATH . "ControladorCarrito.php";

class ControladorCatalogo {

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia de controlador
     * @return instancia del controlador
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorCatalogo();
        }
        return self::$instancia;
    }

    public function getConsultaCatalogo($marca, $modelo, $opcion) {
        if ($opcion != "Ofertas")
            return "select * from productos where (marca like '%" . $marca . "%' or modelo like '%" . $modelo . "%') "
                    . "and tipo like '%" . $opcion . "%'";
        else
            return "select * from productos where (marca like '%" . $marca . "%' or modelo like '%" . $modelo . "%') "
                    . "and oferta = '1'";;
    }
    
    public function filaInicio(){
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
    }
    
    public function filaFin(){
        echo "</div>";
        echo "</div>";
    }
    

    public function getProducto($producto, $pagina){
        $contCarrito = ControladorCarrito::getControlador();
        $itemsCarrito = $contCarrito->getTotalItems();
        echo "<div class = 'col-xs-12 col-sm-6 col-md-3'>";
            echo "<div class = 'thumbnail' >";
                echo "<h4 class = 'text-center' class = 'text-primary'>".$producto->getMarca(). " ".$producto->getModelo()."</h4>";
                echo "<img src = '".PICTURE_PATH.$producto->getFoto()."' class = 'img-responsive'>";
                //echo "<p class = 'text-justify'>".str_replace("\n", "<br/>",utf8_encode(substr($producto->getDescripcion(),0,125)))."...</p>";
                echo "<p class = 'text-justify'>".utf8_encode(substr($producto->getDescripcion(),0,117))."...</p>";
                echo "<div class = 'text-center'>";
                    echo "<h4 class = 'text-danger'>".$producto->getPrecio()."€</h4>";
                    echo "<a href = 'catalogo_producto.php?id=" . base64_encode($producto->getId()) . "' class = 'btn btn-info'><span class = 'glyphicon glyphicon-eye-open'></span> Ver más</a> ";
                    //echo "<a href = 'carrito_añadir.php?id=" .base64_encode($producto->getId()). "' class = 'btn btn-success'><span class = 'glyphicon glyphicon-shopping-cart'></span> Comprar</a>";
                    if($producto->getStock()>0){
                        echo "<a href = 'carrito_añadir.php?id=" .base64_encode($producto->getId()). "&dest=".$pagina."'  class = 'btn btn-success'><span class = 'glyphicon glyphicon-shopping-cart'></span> Comprar</a>";
                    }else{
                        echo "<button type='button' class='btn btn-warning'>Sin Stock</button>";
                    }
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
    

}
