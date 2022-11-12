<?php
class dbMySQL {
	private $host = "localhost";
	private $usuario = "root";
	private $clave = "";
	private $db = "admin";
	//private $puertos = "8080";
	private $conn;
	
	public function __construct(){
		$this->conn = mysqli_connect( //funcion generica
			$this->host, 
			$this->usuario, 
			$this->clave, 
			$this->db, 
	//		$this->puertos
		);		
		if(mysqli_connect_error()){
			printf("Error en la conexion: %d",mysqli_connect_error());
			exit;
		} else {
			//print "Conexion exitosa<br>";	
		}
	}

	public function querySelect($q)
	{
		$data = array();
		if($q!=""){
			if ($r=mysqli_query($this->conn,$q)) {
				while($row = mysqli_fetch_assoc($r)){
					array_push($data, $row);
				}
			}
		}
		return $data;
	}


	public function query($q)
	{
		$data = array();
		if($q!=""){
			if ($r=mysqli_query($this->conn,$q)) {
				$data = mysqli_fetch_assoc($r);
			}
		}
		return $data;
	}


	public function queryNoSelect($q)
	{
		//U,I,D Regresar un valor booleano
		$r = false;
		if($q!=""){
			$r=mysqli_multi_query($this->conn,$q);
		}
		return $r;
	}

	public function close(){
		mysqli_close($this->conn);	
	}
}
?>