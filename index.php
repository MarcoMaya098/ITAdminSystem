<?php  
require "php/variables.php";
require "clases/dbMySQL.php";
require "clases/usuario.php";
require "clases/session.php";
$sesion = new Sesion();
//$conn = new dbMySQL();
if (isset($_POST["usuario"])) {
	$usuario = $_POST["usuario"];
	$nueva = $_POST["clave"];
	$clave = substr(hash_hmac("sha512", $nueva, "adivinacuales"),0, 100);
	if (Usuarios::buscarUsuario($usuario, $clave)) {
		$sesion->inicioLogin($usuario);
		header("location:inicio.php");
		exit;
	} else {
		array_push($msg, "1Clave de acceso o usuario inválidos");
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta charset="utf-8">
	<title>Iniciar Sesion</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script>
		window.onload = function(){
			document.getElementById("registro").onclick = function(){
				window.open("registro.php", "_self");
			}
		}
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-3">
	<div class="container-fluid">
		<a href="index.php" class="navbar-brand  mb-0 h1">ITAdmindSytem</a>
	</div>
	</nav>
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-2 sidevar"></div>
			<div class="col-sm-8">
				<h2 class="text-center">Iniciar sesión</h2>
				<?php require "php/mensajes.php"; ?>

				<form class="text-left" action="index.php" method="post">
					<div class="mb-3">
						<label for="usuario">Usuario:</label>
						<input type="text" name="usuario" id="usuario" class="form-control" required placeholder="Escribe tu usuario"/>
					</div>
					<div class="mb-3">
						<label for="clave">Clave de acceso:</label>
						<input type="password" name="clave" id="clave" class="form-control" required placeholder="Escribe tu clave de acceso"/>
					</div>					
					<div class="mb-3"><button type="submit" name="entrar" id="entrar" class="btn btn-success">Entrar</button>
					<button type="button" name="registro" id="registro" class="btn btn-info" role="button">Registrarse</button></div>	
				</form>
			</div>
			<div class="col-sm-2 sidevar"></div>
		</div>
	</div>
</body>
</html>