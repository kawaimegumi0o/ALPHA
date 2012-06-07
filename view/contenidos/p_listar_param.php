<?php
require_once("../../lib/pruebas.php");
$pruebas=new pruebas_gigpz();

$d=$pruebas->p_get_miembros_id(1);

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procedimiento Almacenado para Listar Datos con Parametros</title>
</head>
<body>
	<h2>Listar Procedimientos con Parametros</h2>
	<li>Nombre: <?php echo $d[0]["nombre"];?>
		<br />Correo: <?php echo $d[0]["email"];?><hr />
	</li>
</body>
</html>