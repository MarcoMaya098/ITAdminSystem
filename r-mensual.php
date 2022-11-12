<?php  
require "php/variables.php";
require "clases/dbMySQL.php";
require "clases/usuario.php";
require "clases/session.php";
require "clases/reportes.php";
$sesion = new Sesion();
$usuario = $sesion->getUsuario();
$data = Usuarios::leeUsuario($usuario);
$id = $data["id"];
$reporte = new Reportes();
$reporte_array = array();
$arr = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$reporteTotal_array = array();
$year="0";
$mes1="0";
$ingresoTotal = 0;
$gastoTotal = 0;
$diferencia = 0;


if (isset($_POST["year"])) {
    $year = $_POST["year"];
    $mes1 = $_POST["mes"];
    if ($year=="0") {
        array_push($msg, "1Seleccionar un año");
    } else if($mes1=="0"){
        array_push($msg, "1Selecciona un mes");
    } else {     
        if($mes1=="Enero") $mes=1;
        else if($mes1=="Febrero") $mes=2;
        else if($mes1=="Marzo") $mes=3;
        else if($mes1=="Abril") $mes=4;
        else if($mes1=="Mayo") $mes=5;
        else if($mes1=="Junio") $mes=6;
        else if($mes1=="Julio") $mes=7;
        else if($mes1=="Agosto") $mes=8;
        else if($mes1=="Septiembre") $mes=9;
        else if($mes1=="Octubre") $mes=10;
        else if($mes1=="Noviembre") $mes=11;
        else if($mes1=="Diciembre") $mes=12;
        if ($reporte->obtnerResultado($year, $mes,$id) && $reporte->obtnerTotal($year, $mes,$id)){
            $reporte_array = $reporte->obtnerResultado($year, $mes,$id);            
            $reporteTotal_array = $reporte->obtnerTotal($year, $mes,$id); 
            $ingresoTotal = ($reporteTotal_array[0]["ingresoTotal"]);
            $gastoTotal = ($reporteTotal_array[0]["gastoTotal"]);      
            $diferencia = ($reporteTotal_array[0]["diferencia"]);  
            array_push($msg,"0Calculo exitoso");

        } else     
		array_push($msg,"1No hay datos registrados");					
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta charset="utf-8">
	<title>Reporte-Mensual</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>	
	<script>
		function toggle(o) {
			var el=document.getElementById("reportediv");
			el.style.display="block";
			window.open("reporteMes.php", "_self");
		}
	</script>
	<style>
	#reporte {display:none;}	
	#reportediv {display:none;}	
	</style>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-3">
	<div class="container-fluid">
	<a href="inicio.php" class="navbar-brand">ITAdminSystem</a>
	<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		<li class="nav-item">
			<a href="inicio.php" class="nav-link">Resumen</a>
		</li>
		<li class="nav-item ">
			<a href="ingresos.php" class="nav-link">ingresos</a>
		</li>
		<li class="nav-item">
			<a href="t-ingresos.php" class="nav-link ">S-ingresos</a>
		</li>
		<li class="nav-item">
			<a href="gastos.php" class="nav-link">Gastos</a>
		</li>
		<li class="nav-item">
			<a href="t-gastos.php" class="nav-link">S-Gastos</a>
		</li>
		<li class="nav-item">
			<a href="r-mensual.php" class="nav-link active">R-Mensual</a>
		</li>
		<li class="nav-item">
			<a href="r-anual.php" class="nav-link">R-Anual</a>
		</li>			
		<li class="nav-item">
			<a href="admon.php" class="nav-link">Admon</a>
		</li>
	</ul>
		<ul class="navbar-nav">
			<li class="nav-item">
				<a href="salir.php" class="nav-link">Salir</a>
			</li>
		</ul>
		</div>
	</nav></br>
	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidevar">
			</div>
			<div class="col-sm-8 text-center">			
				<?php 
					require "php/mensajes.php";	
					?>
					<h2>Reporte Mensual</h2>
					<form action="r-mensual.php" method="POST">
					<div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Año: </span>
							<select name="year" id="year" class="form-control">
								<option value="0">Seleccionar un año</option>
								<?php
								for ($i=2020; $i <= 2050; $i++) { 									
									print "<option ";
									print ($i==$year)?"selected":"";
									print " value='".$i."'>";
									print $i;
									print "</option>";
								}								
								?>
							</select>
						</div>
						<div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Mes: </span>
							<select name="mes" id="mes" class="form-control">
								<option value="0">Seleccionar un mes</option>
								<?php
                                
                                   for ($i=1; $i <count($arr); $i++) { 
									print "<option ";
									print ($arr[$i]==$mes1)?"selected":"";
									print " value='".$arr[$i]."'>";
									print $arr[$i];
									print "</option>";                                    
								}
								?>															
							</select>
						</div>                        						
						<div class="d-grid gap-2 col-6 mx-auto">
							<input type="submit" name="enviar" id="enviar" class="btn btn-success" value="Enviar datos"/>							
						</div></br>
					</form>
					<form action="reporteMes.php" method="post">
					<input type="hidden" name="valorMes" value="<?php print $mes1; ?>" >
					<input type="hidden" name="valorYear" value="<?php print $year; ?>" >
					<input type="hidden" name="valorIngreso" value="<?php print $ingresoTotal; ?>" >
					<input type="hidden" name="valorGasto" value="<?php print $gastoTotal; ?>" >
					<input type="hidden" name="valorDiferencia" value="<?php print $diferencia; ?>">
					<div class="d-grid gap-2 col-6 mx-auto">
					<input <?php if($ingresoTotal!=0 || $gastoTotal!=0 || $diferencia!=0 ){ echo ' style="display: block;"'; }  ?>  type="submit" name="reporte" id="reporte" class="btn btn-danger" onclick="toggle(this)"  value="Reporte PDF" role="button"/>
					</form>
					</div></br>
			<?php   
				print "<table class='table table-striped table-hove' width='100%'>";
				print "<tr>";
				print "<th>Concepto</th>";
                print "<th>Tipo</th>";
                print "<th>Cantidad</th>";
				print "<th>Fecha</th>";
				print "</tr>";
				for($i=0;$i< count($reporte_array) ;$i++){
					print "<tr>";
					print "<td>".$reporte_array[$i]["concepto"]."</td>";
                    print "<td>".$reporte_array[$i]["Tipo"]."</td>";
					print "<td>".number_format($reporte_array[$i]["cantidad"],2)."</td>";
                    print "<td>".$reporte_array[$i]["fecha"]."</td>";
					print "</tr>";
				}	
				print "<tr ";
				if($year!="0" && $mes1!="0") { print "style='display: none;'";} print " >";
				print "<td>Concepto</td>";
                print "<td>Tipo</td>";
                print "<td>0.00</td>";
				print "<td>Fecha</td>";
				print "</tr>";
				print "</table>";	
            ?>                  
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Total Ingresos:</span>
						<input type="text" name="totali" id="totali" class="form-control" value="<?php print number_format($ingresoTotal,2); ?>" disabled/>
					</div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Total Gastos:</span>
						<input type="text" name="totalg" id="totalg" class="form-control" value="<?php print number_format($gastoTotal,2);  ?>" disabled/>
					</div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Diferencia:</span>
						<input type="text" name="diferencia" id="diferencia" class="form-control" value="<?php print number_format($diferencia,2);  ?>" disabled/>
					</div>
				</div>
		</div>
	</div></br></br>
</body>
</html>




