<?php

class Usuario {
    //put your code here
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $admin;
    private $foto;
	private $telefono;
	private $f_alta;
	
    // Constructor
    public function __construct($id, $nombre, $apellido, $email, $password, $admin, $foto, $telefono, $f_alta) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->foto = $foto;
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

	function getFoto(){
		return $this->foto;
	}

	function setFoto($foto){
		$this->foto = $foto;
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

