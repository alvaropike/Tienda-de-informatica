<?php
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH . "ControladorAlumno.php";
require_once MODEL_PATH . "Alumno.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;

class ControladorDescarga{
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
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }

    // public function descargarJSON()
    // {
    //     $this->fichero = "alumnado.json";
    //     header("Content-Type: application/octet-stream");
    //     header('Content-type: application/json');
    //     //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida
    //     $controlador = ControladorAlumno::getControlador();
    //     $lista = $controlador->listarAlumnos("", "");
    //     $sal = [];
    //     foreach ($lista as $al) {
    //         $sal[] = $this->json_encode_private($al);
    //     }
    //     echo json_encode($sal);
    // }

    // private function json_encode_private($object)
    // {
    //     $public = [];
    //     $reflection = new ReflectionClass($object);
    //     foreach ($reflection->getProperties() as $property) {
    //         $property->setAccessible(true);
    //         $public[$property->getName()] = $property->getValue($object);
    //     }
    //     return json_encode($public);
    // }

    public function descargarXML()
    {
        $this->fichero = "luchadores.xml";
        $lista = $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $alumnos = $doc->createElement('luchadores');

        foreach ($lista as $a) {
            // Creamos el nodo
            $alumno = $doc->createElement('luchador');
            // Añadimos elementos
            $alumno->appendChild($doc->createElement('nombre', $a->getNombre()));
            $alumno->appendChild($doc->createElement('raza', $a->getRaza()));
            $alumno->appendChild($doc->createElement('ki', $a->getKi()));
            $alumno->appendChild($doc->createElement('transformacion', $a->getTransformacion()));
            $alumno->appendChild($doc->createElement('ataque', $a->getAtaque()));
            $alumno->appendChild($doc->createElement('planeta', $a->getPlaneta()));
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
        $sal ='<h2 class="pull-left">Fichas de los luchadores</h2>';
        $lista = $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Apellido</th>";
            $sal.="<th>Email</th>";
            $sal.="<th>Password</th>";
            $sal.="<th>Admin</th>";
            $sal.="<th>Fecha alta</th>";
            $sal.="<th>telefono</th>";
            $sal.="<th>Foto</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $alumno) {
                // Pintamos cada fila
                $sal.="<tr>";
                $sal.="<td>" . $alumno->getNombre() . "</td>";
                $sal.="<td>" . $alumno->getApellido() . "</td>";
                $sal.="<td>" . $alumno->getEmail() . "</td>";
                $sal.="<td>" . str_repeat("*",strlen($alumno->getPassword())) . "</td>";
                $sal.="<td>" . $alumno->getAdmin() . "</td>";
                $sal.="<td>" . $alumno->getF_alta() . "</td>";
                $sal.="<td>" . $alumno->gettelefono() . "</td>";
                // Para sacar una imagen hay que decirle el directprio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/AppWeb/Dragonball/imagenes/".$alumno->getFoto()."'  style='max-width: 12mm; max-height: 12mm'></td>";
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
        $sal ='<h2 class="pull-left">Fichas de los luchadores</h2>';
        $lista = $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumno($id);
        if (!is_null($lista) && count($lista) > 0) {
            $sal.="<table class='table table-bordered table-striped'>";
            $sal.="<thead>";
            $sal.="<tr>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Apellido</th>";
            $sal.="<th>Email</th>";
            $sal.="<th>Password</th>";
            $sal.="<th>Admin</th>";
            $sal.="<th>Fecha alta</th>";
            $sal.="<th>telefono</th>";
            $sal.="<th>Foto</th>";
            $sal.="</tr>";
            $sal.="</thead>";
            $sal.="<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $alumno) {
                // Pintamos cada fila
                $sal.="<tr>";
                $sal.="<td>" . $alumno->getNombre() . "</td>";
                $sal.="<td>" . $alumno->getApellido() . "</td>";
                $sal.="<td>" . $alumno->getEmail() . "</td>";
                $sal.="<td>" . str_repeat("*",strlen($alumno->getPassword())) . "</td>";
                $sal.="<td>" . $alumno->getAdmin() . "</td>";
                $sal.="<td>" . $alumno->getF_alta() . "</td>";
                $sal.="<td>" . $alumno->gettelefono() . "</td>";
                // Para sacar una imagen hay que decirle el directprio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/AppWeb/Dragonball/imagenes/".$alumno->getFoto()."'  style='max-width: 12mm; max-height: 12mm'></td>";
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

