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
$reporteTotal_array1 = array();
$reporteTotal_array2 = array();
$reporteTotal_array3 = array();
$reporteTotal_array4 = array();
$reporteTotal_array5 = array();
$reporteTotal_array6 = array();
$reporteTotal_array7 = array();
$reporteTotal_array8 = array();
$reporteTotal_array9 = array();
$reporteTotal_array10 = array();
$reporteTotal_array11 = array();
$reporteTotal_array12 = array();
$year="0";
$ingresoTotal=0;$ingresoTotal1=0;$ingresoTotal2=0;$ingresoTotal3=0;$ingresoTotal4=0;$ingresoTotal5=0;$ingresoTotal6=0;$ingresoTotal7=0;$ingresoTotal8=0;$ingresoTotal9=0;$ingresoTotal10=0;$ingresoTotal11=0;$ingresoTotal12=0;
$gastoTotal=0;$gastoTotal1=0;$gastoTotal2=0;$gastoTotal3=0;$gastoTotal4=0;$gastoTotal5=0;$gastoTotal6=0;$gastoTotal7=0;$gastoTotal8=0;$gastoTotal9=0;$gastoTotal10=0;$gastoTotal11=0;$gastoTotal12=0;
$diferencia=0;$diferencia1=0;$diferencia2=0;$diferencia3=0;$diferencia4=0;$diferencia5=0;$diferencia6=0;$diferencia7=0;$diferencia8=0;$diferencia9=0;$diferencia10=0;$diferencia11=0;$diferencia12=0;

if (isset($_POST["year"])) {
    $year = $_POST["year"];	
    if ($year=="0") {
        array_push($msg, "1Seleccionar un año");    
    } else {     		
            if ($reporte->obtnerTotalAnual($year,$id)) {
            $reporte_array = $reporte->obtnerTotalAnual($year,$id); 
            $ingresoTotal = ($reporte_array[0]["tIngreso"]);
            $gastoTotal = ($reporte_array[0]["tGasto"]);      
            $diferencia = ($reporte_array[0]["dAnual"]);   
			  			
			  $reporteTotal_array1 = $reporte->obtnerTotal($year,1,$id); 
			  $ingresoTotal1 = ($reporteTotal_array1[0]["ingresoTotal"]);
			  $gastoTotal1 = ($reporteTotal_array1[0]["gastoTotal"]);      
			  $diferencia1 = ($reporteTotal_array1[0]["diferencia"]);  
			  
			  $reporteTotal_array2 = $reporte->obtnerTotal($year,2,$id); 
			  $ingresoTotal2 = ($reporteTotal_array2[0]["ingresoTotal"]);
			  $gastoTotal2 = ($reporteTotal_array2[0]["gastoTotal"]);      
			  $diferencia2 = ($reporteTotal_array2[0]["diferencia"]);
			  
			  $reporteTotal_array3 = $reporte->obtnerTotal($year,3,$id);  
			  $ingresoTotal3 = ($reporteTotal_array3[0]["ingresoTotal"]);
			  $gastoTotal3 = ($reporteTotal_array3[0]["gastoTotal"]);      
			  $diferencia3 = ($reporteTotal_array3[0]["diferencia"]);  
		  
			  $reporteTotal_array4 = $reporte->obtnerTotal($year,4,$id); 
			  $ingresoTotal4 = ($reporteTotal_array4[0]["ingresoTotal"]);
			  $gastoTotal4 = ($reporteTotal_array4[0]["gastoTotal"]);      
			  $diferencia4 = ($reporteTotal_array4[0]["diferencia"]);      
		  
			  $reporteTotal_array5 = $reporte->obtnerTotal($year,5,$id);  
			  $ingresoTotal5 = ($reporteTotal_array5[0]["ingresoTotal"]);
			  $gastoTotal5 = ($reporteTotal_array5[0]["gastoTotal"]);      
			  $diferencia5 = ($reporteTotal_array5[0]["diferencia"]);    
			  
			  $reporteTotal_array6 = $reporte->obtnerTotal($year,6,$id); 
			  $ingresoTotal6 = ($reporteTotal_array6[0]["ingresoTotal"]);
			  $gastoTotal6 = ($reporteTotal_array6[0]["gastoTotal"]);      
			  $diferencia6 = ($reporteTotal_array6[0]["diferencia"]); 
			  
			  $reporteTotal_array7 = $reporte->obtnerTotal($year,7,$id); 
			  $ingresoTotal7 = ($reporteTotal_array7[0]["ingresoTotal"]);
			  $gastoTotal7 = ($reporteTotal_array7[0]["gastoTotal"]);      
			  $diferencia7 = ($reporteTotal_array7[0]["diferencia"]);     
			  
			  $reporteTotal_array8 = $reporte->obtnerTotal($year,8,$id); 
			  $ingresoTotal8 = ($reporteTotal_array8[0]["ingresoTotal"]);
			  $gastoTotal8 = ($reporteTotal_array8[0]["gastoTotal"]);      
			  $diferencia8 = ($reporteTotal_array8[0]["diferencia"]); 
			  
			  $reporteTotal_array9 = $reporte->obtnerTotal($year,9,$id); 
			  $ingresoTotal9 = ($reporteTotal_array9[0]["ingresoTotal"]);
			  $gastoTotal9 = ($reporteTotal_array9[0]["gastoTotal"]);      
			  $diferencia9 = ($reporteTotal_array9[0]["diferencia"]);       
		  
			  $reporteTotal_array10 = $reporte->obtnerTotal($year,10,$id); 
			  $ingresoTotal10 = ($reporteTotal_array10[0]["ingresoTotal"]);
			  $gastoTotal10 = ($reporteTotal_array10[0]["gastoTotal"]);      
			  $diferencia10 = ($reporteTotal_array10[0]["diferencia"]);    
		  
			  $reporteTotal_array11 = $reporte->obtnerTotal($year,11,$id); 
			  $ingresoTotal11 = ($reporteTotal_array11[0]["ingresoTotal"]);
			  $gastoTotal11 = ($reporteTotal_array11[0]["gastoTotal"]);      
			  $diferencia11 = ($reporteTotal_array11[0]["diferencia"]);    
		  
			  $reporteTotal_array12 = $reporte->obtnerTotal($year,12,$id); 
			  $ingresoTotal12 = ($reporteTotal_array12[0]["ingresoTotal"]);
			  $gastoTotal12 = ($reporteTotal_array12[0]["gastoTotal"]);      
			  $diferencia12 = ($reporteTotal_array12[0]["diferencia"]);     		  					  
			  if($ingresoTotal==0 && $gastoTotal==0 && $diferencia==0)
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
	<title>Reporte-Anual</title>
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
			<a href="r-mensual.php" class="nav-link ">R-Mensual</a>
		</li>
		<li class="nav-item">
			<a href="r-anual.php" class="nav-link active">R-Anual</a>
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
					<h2>Reporte Anual</h2>
					<form action="r-anual.php" method="POST">
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
						<div class="d-grid gap-2 col-6 mx-auto">
							<input type="submit" name="total" id="total" class="btn btn-success" value="Ver Reporte"/>							
						</div></br>
					</form>
					<form action="reporteAnual.php" method="post">
					<input type="hidden" name="valorYear" value="<?php print $year; ?>" >					
					<div class="d-grid gap-2 col-6 mx-auto">
					<input <?php if($ingresoTotal!=0 && $gastoTotal!=0 && $diferencia!=0){ echo ' style="display: block;"'; } ?>  type="submit" name="reporte" id="reporte" class="btn btn-danger" onclick="toggle(this)"  value="Reporte PDF" role="button"/>
					</form>
					</div></br>			                   
			<?php    												  		
				print "<table class='table table-striped table-hover' width='100%'>";
				print "<tr>";
                print "<th>Mes</th>";
				print "<th>Total Ingresos</th>";
                print "<th>Gastos</th>";
                print "<th>Diferencia</th>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Enero </td>";
				print "<td>".number_format($ingresoTotal1,2)."</td>";
                print "<td>".number_format($gastoTotal1,2)."</td>";
				print "<td>".number_format($diferencia1,2)."</td>";
				print "</tr>";
                
                print "<tr>";
                print "<td class='text-xl-center'>Febrero </td>";
				print "<td>".number_format($ingresoTotal2,2)."</td>";
                print "<td>".number_format($gastoTotal2,2)."</td>";
				print "<td>".number_format($diferencia2,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Marzo </td>";
				print "<td>".number_format($ingresoTotal3,2)."</td>";
                print "<td>".number_format($gastoTotal3,2)."</td>";
				print "<td>".number_format($diferencia3,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Abril </td>";
				print "<td>".number_format($ingresoTotal4,2)."</td>";
                print "<td>".number_format($gastoTotal4,2)."</td>";
				print "<td>".number_format($diferencia4,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Mayo </td>";
				print "<td>".number_format($ingresoTotal5,2)."</td>";
                print "<td>".number_format($gastoTotal5,2)."</td>";
				print "<td>".number_format($diferencia5,2)."</td>";
				print "</tr>";
                
                print "<tr>";
                print "<td class='text-xl-center'>Junio </td>";
				print "<td>".number_format($ingresoTotal6,2)."</td>";
                print "<td>".number_format($gastoTotal6,2)."</td>";
				print "<td>".number_format($diferencia6,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Julio </td>";
				print "<td>".number_format($ingresoTotal7,2)."</td>";
                print "<td>".number_format($gastoTotal7,2)."</td>";
				print "<td>".number_format($diferencia7,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Agosto </td>";
				print "<td>".number_format($ingresoTotal8,2)."</td>";
                print "<td>".number_format($gastoTotal8,2)."</td>";
				print "<td>".number_format($diferencia8,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Septiembre </td>";
				print "<td>".number_format($ingresoTotal9,2)."</td>";
                print "<td>".number_format($gastoTotal9,2)."</td>";
				print "<td>".number_format($diferencia9,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Octubre </td>";
				print "<td>".number_format($ingresoTotal10,2)."</td>";
                print "<td>".number_format($gastoTotal10,2)."</td>";
				print "<td>".number_format($diferencia10,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Noviembre </td>";
				print "<td>".number_format($ingresoTotal11,2)."</td>";
                print "<td>".number_format($gastoTotal11,2)."</td>";
				print "<td>".number_format($diferencia11,2)."</td>";
				print "</tr>";

                print "<tr>";
                print "<td class='text-xl-center'>Diciembre </td>";
				print "<td>".number_format($ingresoTotal12,2)."</td>";
                print "<td>".number_format($gastoTotal12,2)."</td>";
				print "<td>".number_format($diferencia12,2)."</td>";
				print "</tr>";

                //principal
				print "<tr>";
                print "<td class='text-end fw-bold'>TOTALES: </td>";
				print "<td>".number_format($ingresoTotal,2)."</td>";
                print "<td>".number_format($gastoTotal,2)."</td>";
				print "<td>".number_format($diferencia,2)."</td>";
				print "</tr>";
				print "</table>";															
            ?>            
			</div>
			<div class="col-sm-2 sidevar"></div>
		</div>
	</div></br></br>
</body>
</html>