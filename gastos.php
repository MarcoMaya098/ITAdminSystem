<?php  
require "php/variables.php";
require "php/funciones.php";
require "clases/dbMySQL.php";
require "clases/usuario.php";
require "clases/session.php";
require "clases/Gastos.php";

$sesion = new Sesion();
$usuario = $sesion->getUsuario();
$data = Usuarios::leeUsuario($usuario);
$id = $data["id"];
//Lee gastos
$gasto = new Gastos();
$gastos_array = array();
$numRegistros = $gasto->numRegistros($id);
$arr = array("8", "16"); 
$arrMoneda = array("Dolares","Pesos"); 

/*******************
Variables paginacion
********************/
$TAMANO_PAGINA = 5;
$PAGINAS_MAXIMAS = 3;
//Recuperamos página
if(isset($_GET["p"])){
	$pagina = $_GET["p"];
} else {
	$pagina = 1;
}
//Cálculo del num de páginas
$inicio = ($pagina-1)*$TAMANO_PAGINA;
$total_paginas = ceil($numRegistros/$TAMANO_PAGINA);
/*Modo de la pagina (CRUD)
S - SELECT
A - INSERT (ALTA)
B - DELETE (BAJA)
C - UPDATE (cambiar)
D - Baja definitiva
*/
/**************
variables de trabajo
**************/
$idgasto="";// no see modifica
$fecha="";
$cantidad=0;
$moneda="3";
$tipoCambio=0;
$iva=0;
$concepto="";
$ivaporcentaje="0";
if (isset($_GET["m"])) {
	$m = $_GET["m"];
} else {
	$m = "S";
}
/**************
Validacion
**************/
if (isset($_POST["concepto"])) {
	$idgasto = (isset($_POST["idgasto"]))?$_POST["idgasto"]:"";
	$concepto = $_POST["concepto"];
    $fecha = date('Y-m-d', strtotime($_POST["fecha"]))?$_POST["fecha"] : null;
    //$fecha = isset($_POST["fecha"])? $_POST["fecha"] : null;
    $cantidad = $_POST["cantidad"];
    $moneda = $_POST["moneda"];
	$tipoCambio = $_POST["tipoCambio"];
	$iva = $_POST["iva"];
	$ivaporcentaje = $_POST["ivaporcentaje"];
	$m="S";
	//validar

	if(!validaRequerido($concepto)) $msg[] = "1El campo de 'concepto' es requerido.";
    if(!validaFecha($fecha)) $msg[] = "1El campo de 'fecha' es incorrecto.";
	if(($ivaporcentaje=="0")) $msg[] = "1El campo de 'ivaporcentaje' es requerido.";
    if(($moneda=="3")) $msg[] = "1Debes seleccionar un tipo de moneda.";
    if($cantidad<=0) {$msg[] = "1El campo de 'cantidad' no puede ser menor o igual a cero y solo acepta valores numericos.";
		$cantidad=0;}
	if($iva<=0){ $msg[] = "1El campo de 'iva' no puede ser menor o igual a cero y solo acepta valores numericos.";
		$iva=0;}	
	if ($moneda=="Dolares"){	
		if( $tipoCambio<=0){ $msg[] = "1El campo de 'tipo de cambio' no puede ser menor o igual a cero y solo acepta valores numericos.";
		$tipoCambio=0;}}
						
		$cantidad = limpiarNumero($cantidad);
		$iva = limpiarNumero($iva);
		$tipoCambio = limpiarNumero($tipoCambio);
		
	if (count($msg)==0) {							
		$cantidad = limpiarNumero($cantidad);
		$iva = limpiarNumero($iva);
		$tipoCambio = limpiarNumero($tipoCambio);
		if ($tipoCambio!=0 && $moneda=="Dolares"){
			$cantidad = $cantidad * $tipoCambio;
			$iva = $iva * $tipoCambio;					
		} 
        $gasto->altagasto($idgasto, $id, $fecha, $moneda, $tipoCambio, $cantidad, $iva, $concepto, $ivaporcentaje);
        }
		else{
			$m = "A";			
		}	
}
//Baja definitiva
if($m=="D"){
	$idgasto = $_GET["id"];
	$gasto->borrargasto($idgasto);	
	$m="S";
}
//Consulta o baja previa del registro
if($m=="C" || $m=="B"){
	$idgasto = $_GET["id"];
	$data= $gasto->leeRegistro($idgasto);
	$idgasto=$data[0]["id"];
	$fecha=$data[0]["fecha"];
	$cantidad=$data[0]["cantidad"];
	$moneda=$data[0]["moneda"];
	$tipoCambio=$data[0]["tipoCambio"];
	$iva=$data[0]["iva"];
	$concepto=$data[0]["concepto"];
	$ivaporcentaje=$data[0]["ivaporcentaje"];
	
}
else if($m=="S"){
	$gastos_array = $gasto->leegastosUsuario($id,$inicio,$TAMANO_PAGINA);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta charset="utf-8">
	<title>Gastos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script>
		window.onload = function(){
			<?php if ($m=="S"){?>
			document.getElementById("alta").onclick = function(){
				window.open("gastos.php?m=A", "_self");}
			<?php  }?>

			<?php if ($m=="C" || $m=="A"){?>
			document.getElementById("regresar").onclick = function(){
				window.open("gastos.php", "_self");}
			<?php  }?>

			<?php if ($m=="B"){ ?>			
			document.getElementById("nel").onclick = function(){
				window.open("gastos.php", "_self");}		
			document.getElementById("simon").onclick = function(){
				var idgasto = <?php print $idgasto; ?>;
				window.open("gastos.php?m=D&id="+idgasto, "_self");}
			<?php  }?>
		}
		function cambiaPagina(p) {
			window.open("gastos.php?p="+p,"_self");}	
            
        function toggle(o) {
			var el=document.getElementById("mostrar");
			if (o.value=="Dolares") el.style.display="block";
			if (o.value=="Pesos") el.style.display="none";
			if (o.value=="3") el.style.display="none";
		}
	</script>
	<style>
	#mostrar {display:none;}	
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
			<a href="ingresos.php" class="nav-link">Ingresos</a>
		</li>
		<li class="nav-item">
			<a href="t-ingresos.php" class="nav-link">S-Ingresos</a>
		</li>
		<li class="nav-item">
			<a href="gastos.php" class="nav-link active">Gastos</a>
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
			<div class="col-sm-2 sidevar">
				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Gastos</h2>
				<?php if($m=="C" || $m=="A" || $m=="B") {
					require "php/mensajes.php";
					?>
                    
					<form action="gastos.php" method="POST">
					<div class="form-group text-start mb-3" >
							<label for="concepto">Concepto: </label>
							<input type="text" name="concepto" id="concepto"  class="form-control" 
							placeholder="Escribe el concepto" value="<?php print $concepto; ?>" <?php print ($m=='B')?'disabled':""; ?>/>
						</div>
						<div class="form-group text-start mb-3" >
							<label for="fecha">Fecha: </label>
							<input type="date" name="fecha" id="fecha"  class="form-control" 
							placeholder="Selecciona la fecha" value="<?php print $fecha; ?>" <?php print ($m=='B')?'disabled':""; ?>/>
						</div>			
						<div class="form-group text-start mb-3">
							<label for="moneda">Moneda: </label></br>
							<select name="moneda" id="moneda" class="form-control" onclick="toggle(this)" <?php print ($m=='B')?'disabled':""; ?>>
								<option value="3" selected>Selecciona un tipo de moneda</option>	
								<?php
								for ($i=0; $i < count($arrMoneda); $i++) { 
									print "<option ";
									print ($arrMoneda[$i]==$moneda)?"selected":"";
									print " value='".$arrMoneda[$i]."'>";
									print $arrMoneda[$i];
									print "</option>";
								}
								?>
							</select>
						</div>																														
						<div class="form-group text-start mb-3" id="mostrar"  <?php if($moneda=="Dolares"){ echo ' style="display: block;"'; } ?>>
							<label for="tipoCambio">Tipo de Cambio:</label>
							<input type="text" name="tipoCambio" id="tipoCambio" class="form-control"
							placeholder="Digita el tipo de cambio" value="<?php print number_format($tipoCambio,2); ?>" <?php print ($m=='B')?'disabled':""; ?>/>
						</div>
						<div class="form-group text-start mb-3">
							<label for="cantidad">Cantidad:</label>
							<input type="text" name="cantidad" id="cantidad" class="form-control" <?php if($m=='C' && $moneda=="Dolares"){ $cantidad= $cantidad/$tipoCambio; } ?>
							placeholder="Digita la cantidad en dolares o pesos" value="<?php print number_format($cantidad,2); ?>" <?php print ($m=='B')?'disabled':""; ?>/>
						</div>
						<div class="form-group text-start mb-3">
							<label for="iva">IVA: </label></br>
							<input type="text" name="iva" id="iva" class="form-control" <?php if($m=='C' && $moneda=="Dolares"){ $iva= $iva/$tipoCambio; } ?> 
							placeholder="Digita el iva" value="<?php print number_format($iva,2); ?>" <?php print ($m=='B')?'disabled':""; ?>/>
						</div>
						<div class="form-group text-start mb-3">
							<label for="ivaporcentaje">IVA % </label></br>
							<select name="ivaporcentaje" id="ivaporcentaje" class="form-control" <?php print ($m=='B')?'disabled':""; ?>>
								<option value="0">Selecciona un porcentaje del iva</option>									
								<?php
								for ($i=0; $i < count($arr); $i++) { 
									print "<option ";
									print ($arr[$i]==$ivaporcentaje)?"selected":"";
									print " value='".$arr[$i]."'>";
									print $arr[$i]."%";
									print "</option>";
								}
								?>	
							</select>
						</div>		                        						
						<input type="hidden" name="idgasto" id="idgasto" value="<?php print $idgasto; ?>">
						<?php if ($m=="C" || $m=="A") { ?>
						<div class="form-group text-start mb-3">
							<label for="enviar"></label>
							<input type="submit" name="enviar" id="enviar" class="btn btn-success" value="Enviar datos"/>
							<label for="regresar"></label>
							<input type="button" name="regresar" id="regresar" class="btn btn-info" value="Regresar" role="button"/>
						</div>

						<?php } else if($m=="B") { ?>
							<div class="bg-danger p-2 mb-3 rounded" style="--bs-bg-opacity: .3;">
							<p><b>Advertencia:</b> Una vez borrado el registro, no se podra recuperar.</p>
							<p>¿Desea borrar el registro?</p>
							<label for="simon"></label>
							<input type="button" name="simon" id="simon" class="btn btn-danger" value="Si" role="button"/>
							<label for="nel"></label>
							<input type="button" name="nel" id="nel" class="btn btn-light" value="No" role="button"/>
						</div>
						<?php } ?>
					</form>				
                
			<?php                      
				}       				
				if($m == "S"){
					if($numRegistros=="0"){
						array_push($msg,"2No hay registro disponibles");
					} 
					require "php/mensajes.php";
				print "<table class='table table-striped' width='100%'>";
				print "<tr>";
				//print "<th>id</th>";
				print "<th>Concepto</th>";
				print "<th>Fecha</th>";
				print "<th>Cantidad</th>";
				print "<th>IVA</th>";
				print "<th>Modifcar</th>";
				print "<th>Borrar</th>";
				print "</tr>";

				for($i=0;$i< count($gastos_array) ;$i++){
				print "<tr>";
				//print "<td>".$gastos_array[$i]["id"]."</td>";
				print "<td class='text-start'>".$gastos_array[$i]["concepto"]."</td>";
				print "<td>".$gastos_array[$i]["fecha"]."</td>";
				print "<td class='text-start'>".number_format($gastos_array[$i]["cantidad"],2)."</td>";
				print "<td class='text-start'>".number_format($gastos_array[$i]["iva"],2)."</td>";
				print "<td><a class='btn btn-primary' href='gastos.php?m=C&id=".$gastos_array[$i]["id"]."'>Modificar</a></td>";
				print "<td><a class='btn btn-danger' href='gastos.php?m=B&id=".$gastos_array[$i]["id"]."'>Borrar</a></td>";
				print "</tr>";	
				}				
				print "</table>";
				require "php/paginaBaja.php";	                
				}                
            ?>
			<?php if($m=="S"){?>
			</br><label for="alta"></label>
					<input type="button" name="alta" id="alta" class="btn btn-info" value="Dar de alta un gasto" role="button"/>
				<?php }?>
			</div>
			<div class="col-sm-2 sidevar"></div>
		</div>
	</div>
</body>
</html>