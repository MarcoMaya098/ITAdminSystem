<?php
require "clases/session.php";
$session = new Sesion();
$session->finLogin();
header("Location:index.php")
?>