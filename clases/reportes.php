<?php
class Reportes{
	function __construct(){}	

    public function obtnerResultado($year, $mes1,$idUsuario)
	{
		$db = new dbMySQL();
        $sql = "CALL `SP_Mensual` (".$mes1.",'".$year."',".$idUsuario.");";        																	
		return $db->querySelect($sql);
	}

    public function obtnerTotal($year, $mes1,$idUsuario)
	{
		$db = new dbMySQL();
        $sql = "CALL `SP_TotalMensual` ('".$mes1."','".$year."',".$idUsuario.");";        																	
		return $db->querySelect($sql);
	}

	public function obtnerTotalAnual($year,$idUsuario)
	{
		$db = new dbMySQL();
        $sql = "CALL `SP_TotalAnual` ('".$year."',".$idUsuario.");";        																	
		return $db->querySelect($sql);
	}

	public function obtnerTotalChart($id)
	{
		$db = new dbMySQL();
        $sql = "CALL `SP_TOTALCHART` (".$id.");";        																	
		return $db->querySelect($sql);
	}
}


?>
