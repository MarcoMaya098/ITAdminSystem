<?php
class Ingresos{
	function __construct(){}

	public function leeingresosUsuario($id, $inicio, $registros)
	{
		$db = new dbMySQL();
		$sql = "SELECT * FROM ingresos WHERE usuario=".$id." LIMIT ".$inicio.", ".$registros;
		return $db->querySelect($sql);
	}

	public function numRegistros($id)
	{
		$db = new dbMySQL();
		$sql = "SELECT count(*) as num FROM ingresos WHERE usuario=".$id;
		$r = $db->querySelect($sql);
		return $r[0]["num"];
	}

	public function altaingreso($id, $idUsuario, $fecha, $cantidad, $iva, $empresa, $concepto, $moneda, $tipoCambio)
	{
		$db = new dbMySQL();
		//WHERE usuario=".$idUsuario."
		if ($id=="") {
			$sql = "INSERT INTO ingresos VALUES (0,'".$fecha."', ".$cantidad.",".$iva.",'".$empresa."','".$concepto."','".$moneda."', ".$idUsuario.", ".$tipoCambio.");";			
		} else{
			$sql ="UPDATE ingresos SET fecha='".$fecha."', cantidad=".$cantidad.", iva=".$iva.", empresa='".$empresa."', concepto='".$concepto."', moneda='".$moneda."', tipoCambio=".$tipoCambio." WHERE id=".$id.";";
		}
		return $db->queryNoSelect($sql);		
	}

	public function leeRegistro($idingreso)
	{
		$db = new dbMySQL();
		$sql = "SELECT * FROM ingresos WHERE id=".$idingreso;		
		return $db->querySelect($sql);
	}

	public function borraringreso($id)
	{
		$db = new dbMySQL();
		$sql = "DELETE FROM ingresos WHERE id=".$id.";";		
		$sql .= " SET @autoid := 0;";
		$sql .= " UPDATE ingresos SET id= @autoid := (@autoid+1);";
		$sql .= " ALTER TABLE ingresos AUTO_INCREMENT = 1";
		return $db->queryNoSelect($sql);	
	}
}
?>