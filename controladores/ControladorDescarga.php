<?php
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once MODEL_PATH . "usuario.php";
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

    public function descargarXML()
    {
        $this->fichero = "usuarios.xml";
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $alumnos = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            // Creamos el nodo
            $alumno = $doc->createElement('usuario');
            // Añadimos elementos          
            $alumno->appendChild($doc->createElement('nombre', $a->getNombre()));
            $alumno->appendChild($doc->createElement('apellido', $a->getApellido()));
            $alumno->appendChild($doc->createElement('email', $a->getEmail()));
            $alumno->appendChild($doc->createElement('password', str_repeat("*",strlen($a->getPassword()))));
            $alumno->appendChild($doc->createElement('admin', $a->getAdmin()));
            $alumno->appendChild($doc->createElement('telefono', $a->getTelefono()));
            $alumno->appendChild($doc->createElement('imagen', $a->getImagen()));
            $alumno->appendChild($doc->createElement('f_alta', $a->getF_alta()));

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
        $sal ='<h2 class="pull-left">Fichas de los usuarios</h2>';
        $lista = $controlador = ControladorUsuario::getControlador();
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
            $sal.="<th>Fecha de alta</th>";
            $sal.="<th>Telefono</th>";
            $sal.="<th>Imagen</th>";
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
                $sal.="<td>" . $alumno->getTelefono() . "</td>";
                // Para sacar una imagen hay que decirle el directprio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/AppWeb/tiendaInformatica/Tienda-de-informatica/imagenes/usuarios/".$alumno->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
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
        $sal ='<h2 class="pull-left">Fichas de los usuarioss</h2>';
        $lista = $controlador = ControladorUsuario::getControlador();
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
            $sal.="<th>Imagen</th>";
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
                $sal.="<td>" . $alumno->getTelefono() . "</td>";
                // Para sacar una imagen hay que decirle el directprio real donde está
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/AppWeb/tiendaInformatica/Tienda-de-informatica/imagenes/usuarios/".$alumno->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
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

