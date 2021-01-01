<?php

require_once "login.php";
require_once "funciones.php";

session_start(); 
if (!isset($_SESSION["id"])) {
	header("Location: /index.php");
	exit();
}


if (isset($_POST["titulo"]) && isset($_POST["nota"]) && isset($_POST["fecha"])) {
	$conexion = new mysqli($hn, $un, $pw, $db, $port);
	if ($conexion->connect_error) {
		die("Fatal Error");
	}
	
	$titulo = get_post($conexion, "titulo");
	$nota = get_post($conexion, "nota");
	$fecha = get_post($conexion, "fecha");
	$usuario_id = $_SESSION['id'];

	$query = "INSERT INTO `anotaciones`(`titulo`, `contenido`, `fecha`, `usuario_id`) VALUES ('$titulo', '$nota', '$fecha', '$usuario_id')";
	$result = $conexion->query($query);
	if ($result) {
		header("Location: admin.php");
	} else {
		die("error al crear nota");
	}
	
}

?>
<!doctype html>
<html lang='es'>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0'>
	<title>Document</title>
	<link rel='stylesheet' href='css/login.css'>
</head>
<body>
<form action="crearNota.php" method='post'>
	<div class="container">
		<h1>Crear Nueva Nota</h1>
		<p>Agregue todo los campo</p>
		<hr>

		<label for="titulo"><b>Título</b></label>
		<input type="text" placeholder="Ingrese el título" name="titulo" id="titulo" required>

		<label for="nota"><b>Nota</b></label>
		<textarea name='nota' id='nota' required></textarea>

		<label for="fecha"><b>Fecha</b></label>
		<input type="date" name="fecha" id="fecha" required>

		<button type="submit" class="registerbtn">Crear</button>
	</div>

</form>
</body>
</html>