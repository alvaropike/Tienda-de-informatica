<?php

class Alumno {
    //put your code here
    private $id;
    private $nombre;
    private $raza;
    private $ki;
    private $transformacion;
    private $ataque;
    private $planeta;
	private $imagen;
	
    // Constructor
    public function __construct($id, $nombre, $raza, $ki, $transformacion, $ataque, $planeta, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->raza = $raza;
        $this->ki = $ki;
        $this->transformacion = $transformacion;
        $this->ataque = $ataque;
        $this->planeta = $planeta;
        $this->imagen = $imagen;
    }
    
    // **** GETS & SETS
    function getId(){
		return $this->id;
	}

	function setId($id){
		$this->id = $id;
	}

	function getNombre(){
		return $this->nombre;
	}

	function setNombre($nombre){
		$this->nombre = $nombre;
	}

	function getRaza(){
		return $this->raza;
	}

	function setRaza($raza){
		$this->raza = $raza;
	}

	function getKi(){
		return $this->ki;
	}

	function setKi($ki){
		$this->ki = $ki;
	}

	function getTransformacion(){
		return $this->transformacion;
	}

	function setTransformacion($transformacion){
		$this->transformacion = $transformacion;
	}

	function getAtaque(){
		return $this->ataque;
	}

	function setAtaque($ataque){
		$this->ataque = $ataque;
	}

	function getPlaneta(){
		return $this->planeta;
	}

	function setPlaneta($planeta){
		$this->planeta = $planeta;
	}

	function getImagen(){
		return $this->imagen;
	}

	function setImagen($imagen){
		$this->imagen = $imagen;
	}
    
}

