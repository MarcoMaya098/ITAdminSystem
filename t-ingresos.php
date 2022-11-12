<?php  
require "php/variables.php";
require "clases/dbMySQL.php";
require "clases/usuario.php";
require "clases/session.php";
require "clases/total.php";
$sesion = new Sesion();
$usuario = $sesion->getUsuario();
$data = Usuarios::leeUsuario($usuario);
$id = $data["id"];
$totalIngreso = new Total();
$ingresoTotal_array = array();
$arr = array("Enero-Febrero", "Marzo-Abril", "Mayo-Junio", "Julio-Agosto", "Septiembre-Octubre", "Noviembre-Diciembre");
$year="0";
$bimestre="0";
$ingresoTabla=0;
$ivaTabla=0;
if (isset($_POST["year"])) {
    $year = $_POST["year"];
    $bimestre = $_POST["bimestre"];
    if ($year=="0") {
        array_push($msg, "1Seleccionar un año");
    } else if($bimestre=="0"){
        array_push($msg, "1Selecciona un bimestre");
    } else {
        if ($bimestre=="Enero-Febrero"){
            $mes1 = 1;
            $mes2 = 2;					
        } else if ($bimestre=="Marzo-Abril"){
            $mes1 = 3;
            $mes2 = 4;					
        } else if ($bimestre=="Mayo-Junio"){
            $mes1 = 5;
            $mes2 = 6;					
        } else if ($bimestre=="Julio-Agosto"){
            $mes1 = 7;
            $mes2 = 8;					
        } else if ($bimestre=="Septiembre-Octubre"){
            $mes1 = 9;
            $mes2 = 10;					
        } else if ($bimestre=="Noviembre-Diciembre"){
            $mes1 = 11;
            $mes2 = 12;					
        }									
        if ($totalIngreso->obtnerTotalIngreso($year, $mes1, $mes2, $id)){
            $ingresoTotal_array = $totalIngreso->obtnerTotalIngreso($year, $mes1, $mes2, $id);
			$ingresoTabla = ($ingresoTotal_array[0]["Ingresos"]);      
            $ivaTabla = ($ingresoTotal_array[0]["TotalIva"]); 

			if($ingresoTabla==0 && $ivaTabla==0)
			array_push($msg,"1No hay datos registrados");
			else{
				array_push($msg,"0Calculo exitoso");
			}
			} 
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta charset="utf-8">
	<title>Suma Ingresos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>	
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
			<a href="ingresos.php" class="nav-link">Ingresos</a>
		</li>
		<li class="nav-item">
			<a href="t-ingresos.php" class="nav-link active">S-Ingresos</a>
		</li>
		<li class="nav-item">
			<a href="gastos.php" class="nav-link">Gastos</a>
		</li>
		<li class="nav-item">
			<a href="t-gastos.php" class="nav-link">S-Gastos</a>
		</li>
		<li class="nav-item">
			<a href="r-mensual.php" class="nav-link">R-Mensual</a>
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
				<?php require "php/mensajes.php"; ?>
					<h2>Suma de Ingresos</h2>
					<form action="t-ingresos.php" method="POST">
						<div class="form-group text-start mb-3" >
							<label for="year">Año: </label>
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
						<div class="form-group text-start mb-3" >
							<label for="bimestre">Bimestres: </label>
							<select name="bimestre" id="bimestre" class="form-control">
								<option value="0">Seleccionar un bimestre</option>
								<?php
								for ($i=0; $i < count($arr); $i++) { 
									print "<option ";
									print ($arr[$i]==$bimestre)?"selected":"";
									print " value='".$arr[$i]."'>";
									print $arr[$i];
									print "</option>";
								}
								?>	
							</select>
						</div>
						<div class="form-group text-start mb-3">
							<label for="total"></label>
							<input type="submit" name="total" id="total" class="btn btn-success" value="Ver Ingresos"/>
						</div>												
					</form>	</br>			
			<?php    												  		
				print "<table class='table table-striped' width='100%'>";
				print "<tr>";
				print "<th>Ingreso</th>";
				print "<th>IVA retenido</th>";
				print "</tr>";
				print "<tr>";
				print "<td>".number_format($ingresoTabla,2)."</td>";
				print "<td>".number_format($ivaTabla,2)."</td>";
				print "</tr>";
				print "</table>";															
            ?>
			</div>
			<div class="col-sm-2 sidevar"></div>
		</div>
	</div>
</body>
</html>