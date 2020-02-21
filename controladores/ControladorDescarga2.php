<?php
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once MODEL_PATH . "usuario.php";
require_once VENDOR_PATH . "autoload.php";
require MODEL_PATH.'Producto.php';
use Spipu\Html2Pdf\HTML2PDF;

class ControladorDescarga2{
    // Configuración del servidor
    private $fichero;
    // Variable instancia para Singleton
    static private $instancia = null;
    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
        //echo "Conector creado";
    }
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga2();
        }
        return self::$instancia;
    }

    public function descargarXML()
    {
        $this->fichero = "productos.xml";
        $lista = $controlador = ControladorProducto::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $alumnos = $doc->createElement('protuctos');

       

        foreach ($lista as $a) {
            // Creamos el nodo
            $alumno = $doc->createElement('protucto');
            // Añadimos elementos          
            $alumno->appendChild($doc->createElement('nombre', $a->getNombre()));
            $alumno->appendChild($doc->createElement('tipo', $a->getTipo()));
            $alumno->appendChild($doc->createElement('distribuidor', $a->getDistribuidor()));
            $alumno->appendChild($doc->createElement('stock', $a->getStock()));
            $alumno->appendChild($doc->createElement('precio', $a->getPrecio()));
            $alumno->appendChild($doc->createElement('descuento', $a->getDescuento()));
            $alumno->appendChild($doc->createElement('imagen', $a->getImagen()));

            //Insertamos
            $alumnos->appendChild($alumno);
        }

        $doc->appendChild($alumnos);
        header('Content-type: application/xml');
        //header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida
        echo $doc->saveXML();

        exit;
    }

    public function descargarPDF(){
        $sal ='<h2 class="pull-left">Fichas de los productos</h2>';
        $lista = $controlador = ControladorProducto::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>tipo</th>";
            $sal.="<th>distribuidor</th>";
            $sal.="<th>stock</th>";
            $sal.="<th>precio</th>";
            $sal.="<th>descuento</th>";
            $sal.="<th>imagen</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $alumno) {
                // Pintamos cada fila
                $sal.="<tr>";
                $sal.="<td>" . $alumno->getNombre() . "</td>";
                $sal.="<td>" . $alumno->getTipo() . "</td>";
                $sal.="<td>" . $alumno->getDistribuidor() . "</td>";
                $sal.="<td>" . $alumno->getStock() . "</td>";
                $sal.="<td>" . $alumno->getPrecio() . "</td>";
                $sal.="<td>" . $alumno->getDescuento() . "</td>";
                // Para sacar una imagen hay que decirle el directprio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/AppWeb/tiendaInformatica/Tienda-de-informatica/imagenes/productos/".$alumno->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            // Si no hay nada seleccionado
            $sal.="<p class='lead'><em>No se ha encontrado datos de alumnos/as.</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');

    }
    public function descargarPDFAlumno($id){
        $id = decode($id);
        $sal ='<h2 class="pull-left">Fichas de los productos</h2>';
        $lista = $controlador = ControladorProducto::getControlador();
        $lista = $controlador->listarAlumno($id);
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>tipo</th>";
            $sal.="<th>distribuidor</th>";
            $sal.="<th>stock</th>";
            $sal.="<th>precio</th>";
            $sal.="<th>descuento</th>";
            $sal.="<th>imagen</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $alumno) {
                // Pintamos cada fila
                $sal.="<tr>";
                $sal.="<td>" . $alumno->getNombre() . "</td>";
                $sal.="<td>" . $alumno->getTipo() . "</td>";
                $sal.="<td>" . $alumno->getDistribuidor() . "</td>";
                $sal.="<td>" . $alumno->getStock() . "</td>";
                $sal.="<td>" . $alumno->getPrecio() . "</td>";
                $sal.="<td>" . $alumno->getDescuento() . "</td>";
                // Para sacar una imagen hay que decirle el directprio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/AppWeb/tiendaInformatica/Tienda-de-informatica/imagenes/productos/".$alumno->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            // Si no hay nada seleccionado
            $sal.="<p class='lead'><em>No se ha encontrado datos de alumnos/as.</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');
    
    }
}

