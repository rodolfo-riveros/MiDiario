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
	
	$anotacion_id = get_get($conexion, "id");
	
	$query = "SELECT * FROM anotaciones where id='$anotacion_id'";
	$result = $conexion->query($query);
	if (!$result) {
		die ("Falló el acceso a la base de datos");
	}
	

	$rows = $result->num_rows;
	$nota = $result->fetch_array();
	if ($rows) {
		$id_nota = $nota[0];
		$titulo = $nota[1];
		$contenido = $nota[2];
		$fecha = $nota[3];
		$usuario_id = $nota[4];
	}
}
if (isset($_POST["id"]) && isset($_POST["titulo"]) && isset($_POST["nota"]) && isset($_POST["fecha"])) {
	$conexion = new mysqli($hn, $un, $pw, $db, $port);
	if ($conexion->connect_error) {
		die("Fatal Error");
	}
	
	$titulo = get_post($conexion, "titulo");
	$nota = get_post($conexion, "nota");
	$fecha = get_post($conexion, "fecha");
	$id = get_post($conexion, "id");
	$usuario_id = $_SESSION['id'];

	$query = "UPDATE `anotaciones` SET `titulo` = '$titulo', `contenido` = '$nota', `fecha` = '$fecha' WHERE id='$id' and `usuario_id` = '$usuario_id'";
	$result = $conexion->query($query);
	if ($result) {
		header("Location: admin.php");
	} else {
		die("error al editar nota");
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
<form action="editarNota.php" method='post'>
	<div class="container">
		<h1>Editar Nota</h1>
		<p>Comienza editar</p>
		<hr>
		<input type="hidden" value='<?php echo $id_nota; ?>' name="id" required>
		<label for="titulo"><b>Título</b></label>
		<input type="text" value='<?php echo $titulo; ?>' name="titulo" id="titulo" required>
		
		<label for="nota"><b>Nota</b></label>
		<textarea name='nota' id='nota' required><?php echo $contenido; ?></textarea>
		
		<label for="fecha"><b>Fecha</b></label>
		<input type="date" value='<?php echo $fecha; ?>' name="fecha" id="fecha" required>
		
		<button type="submit" class="registerbtn">Editar</button>
	</div>

</form>
</body>
</html>
