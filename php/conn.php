<?php
function conexion(){
    $_host = "localhost";
    $_usuario = "root";
    $_clave = "";
    $_db = "administrador";
    $conn = mysqli_connect($_host,$_usuario, $_clave, $_db);
    return $conn;
}

?>