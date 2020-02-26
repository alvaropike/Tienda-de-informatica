<?php
require_once $_SERVER['DOCUMENT_ROOT']."/AppWeb/tiendaInformatica/Tienda-de-informatica/dirs.php";
require_once CONTROLLER_PATH . "ControladorDescarga.php";
$opcion = $_GET["opcion"];
$id = $_GET["id"];
$fichero = ControladorDescarga::getControlador();
switch ($opcion) {
    case 'XML':
        $fichero->descargarXML();
        break;
    case 'PDF':
        $fichero->descargarPDF();
        break;
    case 'PDFAlumno':
        $fichero->descargarPDFAlumno($id);
        break;

}
