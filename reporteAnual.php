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
$reporteTotal_array = array();
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
if ($reporte->obtnerTotalAnual($year,$id)) {
    $reporte_array = $reporte->obtnerTotalAnual($year,$id); 
    $ingresoTotal = ($reporte_array[0]["tIngreso"]);
    $gastoTotal = ($reporte_array[0]["tGasto"]);      
    $diferencia = ($reporte_array[0]["dAnual"]);   
      array_push($msg,"0Calculo exitoso");

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
}     
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>R-Anual-PDF</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid text-center">
<div class="row content">
    <div class="col-sm-2 sidevar">
    </div>
    <div class="col-sm-8 text-center">
    <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Año:  <?php print $year; ?> </span>
	</div>	                         					                                                 		                   
    <?php    												  		
        print "<table class='table table-striped' width='100%'>";
        print "<tr>";
        print "<th>Mes</th>";
        print "<th>Total Ingresos</th>";
        print "<th>Gastos</th>";
        print "<th>diferencia</th>";
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
        print "<td class='text-center fw-bold'>TOTALES: </td>";
        print "<td>".number_format($ingresoTotal,2)."</td>";
        print "<td>".number_format($gastoTotal,2)."</td>";
        print "<td>".number_format($diferencia,2)."</td>";
        print "</tr>";
        print "</table>";															
    ?>            
</div>
</div></br></br>
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