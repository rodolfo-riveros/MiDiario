<?php
require_once "login.php";
require_once "funciones.php";

session_start(); 
if (!isset($_SESSION["id"])) {
	header("Location: index.php");
	exit();
}


if (isset($_GET["id"])) {
	$conexion = new mysqli($hn, $un, $pw, $db, $port);
	if ($conexion->connect_error) {
		die("Fatal Error");
	}
	
	$id = get_get($conexion, "id");
	$usuario_id = $_SESSION['id'];

	$query = "DELETE FROM `anotaciones` WHERE `id` = '$id' and usuario_id='$usuario_id'";
	$result = $conexion->query($query);
	if ($result) {
		header("Location: admin.php");
	} else {
		die("error al editar nota");
	}
}
