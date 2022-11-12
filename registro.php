<?php  
require "php/variables.php";
require "clases/dbMySQL.php";
require "clases/usuario.php";
require "clases/session.php";
//$dataUsuario = "";
//$dataClave = "";
//print var_dump($data);

if (isset($_POST["usuario"])) {
	$usuario = $_POST["usuario"];
	$nueva = $_POST["nueva"];
	$verifica = $_POST["verifica"];
	if ($usuario=="") {
		array_push($msg, "1El campo usuario no puede estar vacio");
	} else if ($nueva=="") {
		array_push($msg, "1La clave de acceso no puede estar vacía");
	} else if($verifica==""){
		array_push($msg, "1La clave de acceso de verificación no puede estar vacía");
	} else if($nueva!=$verifica){
		array_push($msg, "1Las claves de acceso no coinciden");
	} else {
		$clave = substr(hash_hmac("sha512", $nueva, "adivinacuales"),0, 100);

		if (Usuarios::buscarUsuario($usuario, $clave )) {
			array_push($msg, "1Usuario ya existente");
		} else if (Usuarios::leeUsuario($usuario)) {
				array_push($msg, "1Nombre de usuario ya existente");
		}else {		
			if(Usuarios::insertarUsuario($usuario, $clave))
			header("location:index.php");
			exit;
		}
		
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" />
	<meta charset="utf-8">
	<title>Registro</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script>
		window.onload = function(){
			document.getElementById("regresar").onclick = function(){
				window.open("index.php", "_self");
			}
		}
	</script>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-3">
	<div class="container-fluid">
		<a href="index.php" class="navbar-brand  mb-0 h1">ITAdminSystem</a>
	</div>
	</nav>
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-2 sidevar"></div>
			<div class="col-sm-8 text-center">
				<h2 class="text-center">Registro</h2>
				<?php require "php/mensajes.php"; ?>
				<form action="registro.php" method="POST">
						<div class="form-group text-start mb-3" >
							<label for="usuario">Usuario: </label>
							<input type="text" name="usuario" id="usuario" class="form-control" placeholder="Escribe tu nombre de usuario">
						</div>
						<div class="form-group text-start mb-3">
							<label for="nueva">Clave de acceso: </label>
							<input type="password" name="nueva" id="nueva" class="form-control" placeholder="Escribe la nueva clave de acceso">
						</div>
						<div class="form-group text-start mb-3">
							<label for="verifica">Verifica la clave de acceso:</label>
							<input type="password" name="verifica" id="verifica" class="form-control" placeholder="Verifica la clave de acceso">
						</div>
						<div class="form-group text-start mb-3">
							<label for="enviar"></label>
							<input type="submit" name="enviar" id="enviar" class="btn btn-success" value="Enviar claves"/>

							<label for="regresar"></label>
							<input type="button" name="regresar" id="regresar" class="btn btn-info" value="Regresar" role="button"/>
						</div>
					</form>	
			</div>
			<div class="col-sm-2 sidevar"></div>
		</div>
	</div>
</body>
</html>