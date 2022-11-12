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
$year = $_POST["valorYear"];
$mes1 = $_POST["valorMes"];
$ingresoTotal = $_POST["valorIngreso"];
$gastoTotal = $_POST["valorGasto"];
$diferencia = $_POST["valorDiferencia"];
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
if ($reporte->obtnerResultado($year, $mes,$id)){
	$reporte_array = $reporte->obtnerResultado($year, $mes,$id);  
}
?>
<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>R-Mensual-PDF</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
</br>
<div class="container-fluid text-center">
		<div class="row content">
		<div class="col-sm text-center" id="reportediv">
					<div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Año:  <?php print $year; ?> </span>
					</div>	
					
					<div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Mes:  <?php print $mes1; ?></span>
					</div>	
					<?php   
				print "<table class='table table-striped' width='100%'>";
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
					print "<td>".number_format($reporte_array[$i]["total"],2)."</td>";
                    print "<td>".$reporte_array[$i]["fecha"]."</td>";
					print "</tr>";
				}	
				print "</table>";	
            ?>     
					<div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Total Ingresos:  <?php print number_format($ingresoTotal,2); ?> </span>
						</div>	
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Total Gastos:  <?php print number_format($gastoTotal,2); ?> </span>
					</div>	
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Diferencia:  <?php print number_format($diferencia,2);  ?></span>
					</div>	
				</div>
		</div>
</div>
</body>
</html>
<?php
$html=ob_get_clean();
//echo $html;
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
//$options->setDefaultFont('Courier');
$dompdf->set_base_path("./bootstrap.min.css");
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter');
//$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_.pdf", array("Attachment" => false));
?>

