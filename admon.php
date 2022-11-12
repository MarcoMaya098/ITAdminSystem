<?php  
require "php/variables.php";
require "clases/dbMySQL.php";
require "clases/usuario.php";
require "clases/session.php";
$sesion = new Sesion();
$usuario = $sesion->getUsuario();
$data = Usuarios::leeUsuario($usuario);
//print var_dump($data);
$id = $data["id"];
//$id = $data["id"];
//$conn = new dbMySQL();
/*Modo de la pagina (CRUD)
S - SELECT
A - INSERT (ALTA)
B - DELETE (BAJA)
C - UPDATE (cambiar)
*/

if (isset($_GET["m"])) {
	$m = $_GET["m"];
} else {
	$m = "S";
}
/**************
Validacion
**************/
if (isset($_POST["nueva"])) {
	$nueva = $_POST["nueva"];
	$verifica = $_POST["verifica"];
	$m="C";
	//validar
	if ($nueva=="") {
		array_push($msg, "1La clave de acceso no puede estar vacía");
	} else if($verifica==""){
		array_push($msg, "1La clave de acceso de verificación no puede estar vacía");
	} else if($nueva!=$verifica){
		array_push($msg, "1Las claves de acceso no coinciden");
	} else {
		$clave = substr(hash_hmac("sha512", $nueva, "adivinacuales"),0, 100);
		$r = Usuarios::cambiarClaveAccesso($usuario, $clave);
		array_push($msg,$r);
	}
}

if($m=="D"){
	//$gasto->borrarUsaurio($id);	
	Usuarios::borrarUsaurio($id);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta charset="utf-8">
	<title>Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script>
		window.onload = function(){
			<?php if ($m=="C"){?>
			document.getElementById("regresar").onclick = function(){
				window.open("admon.php", "_self");
			}
			<?php  }?>
			<?php if ($m=="B"){ ?>			
			document.getElementById("nel").onclick = function(){
				window.open("admon.php", "_self");}		
			document.getElementById("simon").onclick = function(){
				var id = <?php print $id; ?>;
				window.open("admon.php?m=D&id="+id, "_self");}
			<?php  }?>

			<?php if ($m=="D"){?>
				window.open("index.php", "_self");
			<?php  }?>
		}
	</script>
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
			<a href="admon.php" class="nav-link active">Admon</a>
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
				<?php if($m == "C"|| $m == "B") {
					require "php/mensajes.php";
					?>
					<h2>Usuario</h2>
					<form action="admon.php" method="POST">
						<div class="form-group text-start mb-3" >
							<label for="usuario">Usuario: </label>
							<input type="text" name="usuario" id="usuario" disabled class="form-control" value="<?php print $usuario; ?>" <?php print ($m=='B')?'disabled':""; ?>>
						</div>
						<div class="form-group text-start mb-3">
							<label for="nueva" <?php if($m=="B"){ echo ' style="display: none;"'; } ?>>Nueva clave de acceso: </label>
							<input type="password" name="nueva" id="nueva" class="form-control"
							 placeholder="Escribe la nueva clave de acceso" <?php if($m=="B"){ echo ' style="display: none;"'; } ?>>
						</div>
						<div class="form-group text-start mb-3">
							<label for="verifica"  <?php if($m=="B"){ echo ' style="display: none;"'; } ?>>Verifica la clave de acceso:</label>
							<input type="password" name="verifica" id="verifica" class="form-control" placeholder="Verifica la clave de acceso" <?php if($m=="B"){ echo ' style="display: none;"'; } ?>>
						</div>
						<?php if ($m=="C") { ?>
						<div class="form-group text-start mb-3">
							<label for="enviar"></label>
							<input type="submit" name="enviar" id="enviar" class="btn btn-success" value="Enviar claves"/>

							<label for="regresar"></label>
							<input type="button" name="regresar" id="regresar" class="btn btn-info" value="Regresar" role="button"/>
						</div>

						<?php } else if($m=="B") { ?>
							<div class="bg-danger p-2 mb-3 rounded" style="--bs-bg-opacity: .3;">
							<p><b>Advertencia:</b> Una vez borrado el Usuario, no se podra recuperar y se eliminarán todos sus registros.</p>
							<p>¿Desea borrar el Usuario?</p>
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
				print	"<h2>Usuario</h2>";
				print "<table class='table table-striped' width='100%'>";
				print "<tr>";
				print "<th>id</th>";
				print "<th>Usuario</th>";
				print "<th>Cambiar clave</th>";
				print "<th>Eliminar Usuario</th>";

				print "</tr>";
				print "<tr>";
				print "<td>".$id."</td>";
				print "<td>".$usuario."</td>";
				print "<td><a class='btn btn-info' href='admon.php?m=C&id=".$id."'>Cambiar clave</a></td>";
				print "<td><a class='btn btn-danger' href='admon.php?m=B&id=".$id."'>Eliminar</a></td>";

				print "</tr>";
				print "</table>";	
				}
            ?>
			</div>
			<div class="col-sm-2 sidevar"></div>
		</div>
	</div>
</body>
</html>