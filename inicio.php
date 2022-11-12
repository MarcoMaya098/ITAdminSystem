<?php  
require "clases/dbMySQL.php";
require "clases/usuario.php";
require "clases/session.php";
require "clases/reportes.php";
require "php/funciones.php";
$sesion = new Sesion();
$usuario = $sesion->getUsuario();
$data = Usuarios::leeUsuario($usuario);
$id = $data["id"];

$reporte = new Reportes();
$reporte_array = array();
$ingresoChart=0;
$gastoChart=0;
$diferencia=0;
if($reporte->obtnerTotalChart($id)) {
	$reporte_array = $reporte->obtnerTotalChart($id); 
	$ingresoChart = ($reporte_array[0]["ingresoChart"]);
	$gastoChart = ($reporte_array[0]["gastoChart"]);      
	$diferencia = ($reporte_array[0]["dChart"]); 
	$ingresoTotal = ($reporte_array[0]["tIngreso"]); 
	$gastoTotal = ($reporte_array[0]["tGasto"]); 
}	
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta charset="utf-8">
	<title>Control de gastos | Inicio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<script src="https://code.highcharts.com/modules/pattern-fill.js"></script>
	<script src="https://code.highcharts.com/themes/high-contrast-light.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-3">
	<div class="container-fluid">
	<a href="inicio.php" class="navbar-brand">ITAdminSystem</a>
	<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		<li class="nav-item">
			<a href="inicio.php" class="nav-link active">Resumen</a>
		</li>
		<li class="nav-item ">
			<a href="ingresos.php" class="nav-link ">Ingresos</a>
		</li>
		<li class="nav-item">
			<a href="t-ingresos.php" class="nav-link">S-Ingresos</a>
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
	</nav>
	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidevar"></div>
			<div class="col-sm-8 text-center">
				<h1>EMPRESA SERVINDTEC</h1>
				<div id="container"></div>  
				<h3>Diferencia $<?php print number_format($diferencia,2); ?></h3>
			</div>
			<div class="col-sm-2 sidevar"></div>
		</div>
	</div>
<script type="text/javascript">
var clrs = Highcharts.getOptions().colors;
var pieColors = [clrs[0], clrs[2]];
function getPattern(i) {
  return {
    pattern: Highcharts.merge(Highcharts.patterns[i], {
      color: pieColors[i]
    })
  };
}
var patterns = [0, 1].map(getPattern);
var chart = Highcharts.chart('container', {
  chart: {
    type: 'pie'
  },
  title: {
    text: 'SUMA DE GASTOS E INGRESOS'
  },
  colors: patterns,
  tooltip: {
    valueSuffix: '%',
    borderColor: '#8ae'
  },
  plotOptions: {
    series: {
      dataLabels: {
        enabled: true,
        connectorColor: '#777',
        format: '<b>{point.name}</b> '
      },
      cursor: 'pointer',
      borderWidth: 3
    }
  },
  series: [{
    name: 'Screen reader usage',
    data: [{
			name: 'Gastos: $<?php print number_format($gastoTotal,2); ?>',
			y: <?php print number_format($gastoChart,1); ?>,
		}, {
			name: 'Ingresos: $<?php print number_format($ingresoTotal,2); ?>',
			y: <?php print number_format($ingresoChart,1); ?>,
		}, ]
  }],
  responsive: {
    rules: [{
      condition: {
        maxWidth: 500
      },
      chartOptions: {
        plotOptions: {
          series: {
            dataLabels: {
              format: '<b>{point.name}</b>'
            }
          }
        }
      }
    }]
  }
});
// Toggle patterns enabled
document.getElementById('patterns-enabled').onclick = function () {
  chart.update({
    colors: this.checked ? patterns : pieColors
  });
};
</script>
</body>
</html>