<?php
require_once "login.php";
require_once "funciones.php";

session_start(); 
if (isset($_SESSION["id"])) {
	header("Location: admin.php");
	exit();
}
if (isset($_POST["email"]) && isset($_POST["password"])) {
	$conexion = new mysqli($hn, $un, $pw, $db,$port);
	if ($conexion->connect_error) {
		die("Fatal Error");
	}

	$correo=get_post($conexion,"email");
	$password=get_post($conexion, "password");
	$password=md5($password);

	$query = "SELECT * FROM usuario where correo='$correo' and password='$password'";
	$result = $conexion->query($query);
	if (!$result) die ("Falló el acceso a la base de datos");
	
	$rows = $result->num_rows;
	$usuario=$result->fetch_array();
	if ($rows) {
		$_SESSION["id"]=$usuario[0];
		$_SESSION["correo"]=$usuario[1];
		$_SESSION["password"]=$usuario[2];
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
<form action="index.php" method='post'>
	<div class="container">
		<h1>Iniciar sesión</h1>
		<p>Ingrese sus datos</p>
		<hr>
		
		<label for="email"><b>Correo</b></label>
		<input type="email" placeholder="Ingrese su Correo" name="email" id="email" required>
		
		<label for="psw"><b>Contraseña</b></label>
		<input type="password" placeholder="ingrese su contraseña" name="password" id="psw" required>
		
		<button type="submit" class="registerbtn">Iniciar Sesión</button>
	</div>
	
	<div class="container signin">
		<p>¿Todavía no tienes una cuenta? <a href="registro.php">Registrarme</a>.</p>
	</div>
</form>
</body>
</html>
<?  