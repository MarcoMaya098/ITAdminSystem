<?php
class Gastos{
	function __construct(){}

	public function leegastosUsuario($id, $inicio, $registros)
	{
		$db = new dbMySQL();
		$sql = "SELECT * FROM gastos WHERE usuario=".$id." LIMIT ".$inicio.", ".$registros;
		return $db->querySelect($sql);
	}

	public function numRegistros($id)
	{
		$db = new dbMySQL();
		$sql = "SELECT count(*) as num FROM gastos WHERE usuario=".$id;
		$r = $db->querySelect($sql);
		return $r[0]["num"];
	}	

	public function altagasto($idgasto, $id, $fecha, $moneda, $tipoCambio, $cantidad, $iva, $concepto, $ivaporcentaje)
	{
		$db = new dbMySQL();
		if ($idgasto=="") {
			$sql = "INSERT INTO gastos VALUES (0,'".$fecha."', '".$concepto."', ".$cantidad.", '".$moneda."',".$tipoCambio.", '".$ivaporcentaje."', ".$iva.", ".$id.");";			
		} else{
			$sql ="UPDATE gastos SET fecha='".$fecha."', concepto='".$concepto."', cantidad=".$cantidad.", moneda='".$moneda."', tipoCambio=".$tipoCambio.", ivaporcentaje='".$ivaporcentaje."', iva=".$iva." WHERE id=".$idgasto.";";
		}
		return $db->queryNoSelect($sql);		
	}

	public function leeRegistro($idgasto)
	{
		$db = new dbMySQL();
		$sql = "SELECT * FROM gastos WHERE id=".$idgasto;		
		return $db->querySelect($sql);
	}

	public function borrargasto($id)
	{
		$db = new dbMySQL();
		$sql = "DELETE FROM gastos WHERE id=".$id.";";		
		$sql .= " SET @autoid := 0;";
		$sql .= " UPDATE gastos SET id_gastos= @autoid := (@autoid+1);";
		$sql .= " ALTER TABLE gastos AUTO_INCREMENT = 1";
		return $db->queryNoSelect($sql);	
	}
}
?>