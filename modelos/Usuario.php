<?php

class Usuario {
    //put your code here
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $admin;
    private $imagen;
	private $telefono;
	private $f_alta;
	
    // Constructor
    public function __construct($id, $nombre, $apellido, $email, $password, $admin, $imagen, $telefono, $f_alta) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->imagen = $imagen;
		$this->telefono = $telefono;
		$this->f_alta = $f_alta;
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

	function getApellido(){
		return $this->apellido;
	}

	function setApellido($apellido){
		$this->apellido = $apellido;
	}

	function getEmail(){
		return $this->email;
	}

	function setEmail($email){
		$this->email = $email;
	}

	function getPassword(){
		return $this->password;
	}

	function setPassword($password){
		$this->password = $password;
	}

	function getAdmin(){
		return $this->admin;
	}

	function setAdmin($admin){
		$this->admin = $admin;
	}

	function getImagen(){
		return $this->imagen;
	}

	function setImagen($imagen){
		$this->imagen = $imagen;
	}

	function getTelefono(){
		return $this->telefono;
	}

	function setTelefono($telefono){
		$this->telefono = $telefono;
	}

	function getF_alta(){
		return $this->f_alta;
	}

	function setF_alta($f_alta){
		$this->f_alta = $f_alta;
	}
    
}

