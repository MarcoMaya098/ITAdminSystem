<?php

class Usuarios{
	private $usuario;
	private $clave;
	
	function __construct(){}

	public static function buscarUsuario($usuario, $clave)
	{
		$db = new dbMySQL();
		$sql = "SELECT * FROM usuarios WHERE usuario='".$usuario."' AND clave='".$clave."'";
		$data = $db->query($sql);
		$db->close();
		unset($db);
		return isset($data);
	}

	public static function leeUsuario($usuario)
	{
		$db = new dbMySQL();
		$sql = "SELECT * FROM usuarios WHERE usuario='".$usuario."'";
		$data = $db->query($sql);
		$db->close();
		unset($db);
		return $data;
	}

	public static function cambiarClaveAccesso($usuario, $clave)
	{
		$db = new dbMySQL();
		$sql = "UPDATE usuarios SET clave='".$clave."' WHERE usuario='".$usuario."'";
		$r = $db->queryNoSelect($sql);
		$db->close();
		unset($db);
		if ($r) {
			$c = "0Clave de acceso modificada exitosamente";
		} else {
			$c = "1Error al modificar la clave de acceso";
		}
		return $c;
	}

	public static function insertarUsuario($usuario, $clave)
	{
		$db = new dbMySQL();
		$sql = "INSERT INTO usuarios VALUES (0,'".$usuario."','".$clave."')";
		$data = $db->queryNoSelect($sql);
		$db->close();
		unset($db);
		return $data;
	}

	public static function borrarUsaurio($id)
	{
		$db = new dbMySQL();
		$sql = "DELETE FROM usuarios WHERE id=".$id.";";	
		$sql .= "DELETE FROM gastos WHERE usuario=".$id.";";		
		$sql .= "DELETE FROM ingresos WHERE usuario=".$id.";";		
		$sql .= " SET @autoid := 0;";
		$sql .= " UPDATE usuarios SET id= @autoid := (@autoid+1);";
		$sql .= " ALTER TABLE usuarios AUTO_INCREMENT = 1";
		return $db->queryNoSelect($sql);	
	}
}
?>