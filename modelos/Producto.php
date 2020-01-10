<?php

class Producto {
    //put your code here
    private $id;
    private $nombre;
    private $tipo;
    private $distribuidor;
    private $stock;
    private $precio;
    private $descuento;
	private $imagen;
	
    // Constructor
    public function __construct($id, $nombre, $tipo, $distribuidor, $stock, $precio, $descuento, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->distribuidor = $distribuidor;
        $this->stock = $stock;
        $this->precio = $precio;
        $this->descuento = $descuento;
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

	function getTipo(){
		return $this->tipo;
	}

	function setTipo($tipo){
		$this->tipo = $tipo;
	}

	function getDistribuidor(){
		return $this->distribuidor;
	}

	function setDistribuidor($distribuidor){
		$this->distribuidor = $distribuidor;
	}

	function getStock(){
		return $this->stock;
	}

	function setStock($stock){
		$this->stock = $stock;
	}

	function getPrecio(){
		return $this->precio;
	}

	function setPrecio($precio){
		$this->precio = $precio;
	}

	function getDescuento(){
		return $this->descuento;
	}

	function setDescuento($descuento){
		$this->descuento = $descuento;
	}

	function getImagen(){
		return $this->imagen;
	}

	function setImagen($imagen){
		$this->imagen = $imagen;
	}
    
}

