<?php
class Total{
	function __construct(){}

	public function obtnerTotalGasto($year, $mes1, $mes2,$idusuario)
	{
		$db = new dbMySQL();
        $sql = "CALL `SP_Gasto` (".$mes1.",".$mes2.",'".$year."',".$idusuario.");";        																	
		return $db->querySelect($sql);
	}
	
	public function obtnerTotalIngreso($year, $mes1, $mes2,$idusuario)
	{
		$db = new dbMySQL();
        $sql = "CALL `SP-Ingreso` (".$mes1.",".$mes2.",'".$year."',".$idusuario.");";
		return $db->querySelect($sql);
	}
}
?>
