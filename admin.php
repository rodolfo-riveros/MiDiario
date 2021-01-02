 < ?php
       anggi
require_once "login.php";
require_once "funciones.php";
//gringuita noegueseni
session_start(); 
if (!isset($_SESSION["id"])){
header("Location: index.php");
exit();
}
$conexion = new mysqli($hn, $un, $pw, $db,$port);
if ($conexion->connect_error) {
die("Fatal Error");
}
$usuario_id = $_SESSION["id"];
$query = "SELECT * FROM anotaciones where usuario_id='$usuario_id'";
$result = $conexion->query($query);
if (!$result) {
die ("Falló el acceso a la base de datos");
}

$rows = $result->num_rows;

?>
<!doctype html>
<html lang='es'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0'>
<title>Document</title>
<link rel='stylesheet' href='css/plantilla.css'>
</head>
<body>
<div class='header'>
<div class="nombre">
<h1>Mis Notas</h1>
</div>
<div class='perfil'><?php echo $_SESSION["correo"]; ?> | <a href='cerrar_session.php' id='logout'>cerrar sesión</a></div>
</div>

<div class='main'>
<div class='nav'>
<a href='crearNota.php' class='btn info'>añadir</a>
</div>
<?php for($j = 0; $j < $rows; $j++){ ?>
<?php
$row = $result->fetch_array(MYSQLI_NUM);

$r0 = htmlspecialchars($row[0]);
$r1 = htmlspecialchars($row[1]);
$r2 = htmlspecialchars($row[2]);
$r3 = htmlspecialchars($row[3]);
$r4 = htmlspecialchars($row[4]);
?>
<div class='tarjeta'>
<div class='tarjeta-header'>
<h2><?php echo $r1; ?></h2>
</div>
<div class='tarjeta-cuerpo'>
<p><?php echo $r2; ?></p>
</div>
<div class='tarjeta-footer'>
<small><?php echo $r3; ?></small>
</div>
<a href="borrar.php?id=<?php echo $r0; ?>" class='borrar'>Borrar</a>
<a href="editarNota.php?id=<?php echo $r0; ?>" class='editar'>Editar</a>
</div>
<?php }?>
</div>

<footer>
<strong>Copyright © 2020 Angie bilbao Todos los derechos reservados.</strong>
</footer>
</body>
</html>
