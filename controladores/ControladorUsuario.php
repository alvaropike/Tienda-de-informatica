<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorAlumno
 *
 * @author link
 */

require_once MODEL_PATH."Usuario.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorUsuario {

     // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorUsuario();
        }
        return self::$instancia;
    }
    
    /**
     * Lista el alumnado según el nombre o dni
     * @param type $nombre
     * @param type $dni
     */
    public function listarAlumnos($nombre){
        // Creamos la conexión a la BD
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta pero esta vez paremtrizada
        $consulta = "SELECT * FROM usuario WHERE nombre LIKE :nombre";
        $parametros = array(':nombre' => "%".$nombre."%");
        // Obtenemos las filas directamente como objetos con las columnas de la tabla
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        //var_dump($filas);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $alumno = new Usuario($a->id, $a->nombre, $a->apellido, $a->email, $a->password, $a->admin, $a->imagen, $a->telefono, $a->f_alta);
                // Lo añadimos
                $lista[] = $alumno;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }

    public function listarAlumno($id){
        // Creamos la conexión a la BD
        $lista=[];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta pero esta vez paremtrizada
        $consulta = "SELECT * FROM usuario WHERE id = :id";
        $parametros = array(':id' => $id);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas = $res->fetchAll(PDO::FETCH_OBJ);
        //var_dump($filas);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $alumno = new Usuario($a->id, $a->nombre, $a->apellido, $a->email, $a->password, $a->admin, $a->imagen, $a->telefono, $a->f_alta);
                // Lo añadimos
                $lista[] = $alumno;
            }
            $bd->cerrarBD();
            return $lista;
        }else{
            return null;
        }    
    }
    
    public function almacenarAlumno($nombre, $apellido, $email, $password, $admin, $imagen, $telefono, $f_alta){
        //$alumno = new Usuario("",$dni, $nombre, $email, $password, $idioma, $matricula, $lenguaje, $fecha, $imagen);
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "INSERT INTO usuario (nombre, apellido, email, password, admin, 
            imagen, telefono, f_alta) VALUES (:nombre, :apellido, :email, :password, :admin, :imagen, 
            :telefono, :f_alta)";
        
        $parametros= array(':nombre'=>$nombre,':apellido'=>$apellido, ':email'=>$email, ':password'=>$password, ':admin'=>$admin,':imagen'=>$imagen,
                            ':telefono'=>$telefono, ':f_alta'=>$f_alta);

        // $consulta2 = "SELECT count(nombre) FROM usuario where nombre = :nombre";
        // $parametros2 = array(':nombre' => $nombre);
        // $result = $bd->consultarBD($consulta2,$parametros2); 
        // $row = $result->fetch(PDO::FETCH_NUM);
        // if ($row[0] == 0) {
            $estado = $bd->actualizarBD($consulta,$parametros);
            $bd->cerrarBD();
            return $estado;
        // }else{
        //     return null;
        //     exit();
        // }
    }
    
    public function buscarAlumno($id){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuario WHERE id = :id";
        $parametros = array(':id' => $id);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $alumno = new Usuario($a->id, $a->nombre, $a->apellido, $a->email, $a->password, $a->admin, $a->imagen, $a->telefono, $a->f_alta);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $alumno;
        }else{
            return null;
        }    
    }

    public function buscarAlumnoDni($nombre){ 
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM usuario  WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $alumno = new Usuario($a->id, $a->nombre, $a->apellido, $a->email, $a->password, $a->admin, $a->imagen, $a->telefono, $a->f_alta);
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $alumno;
        }else{
            return null;
        }    
    }
    
    public function borrarAlumno($id){ 
        $estado=false;
        // Borro el alumno de la
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM usuario WHERE id = :id";
        $parametros = array(':id' => $id);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
    
    public function actualizarAlumno($id, $nombre, $apellido, $email, $password, $admin, $imagen, $telefono){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "UPDATE usuario SET id=:id, nombre=:nombre, apellido=:apellido, email=:email, password=:password, 
            admin=:admin, imagen=:imagen, telefono=:telefono
            WHERE id=:id";
        $parametros = array(':id'=>$id, ':nombre'=>$nombre,':apellido'=>$apellido, ':email'=>$email, ':password'=>$password,':admin'=>$admin,
                            ':imagen'=>$imagen, ':telefono'=>$telefono);
        $estado = $bd->actualizarBD($consulta,$parametros);
        $bd->cerrarBD();
        return $estado;
    }
}
