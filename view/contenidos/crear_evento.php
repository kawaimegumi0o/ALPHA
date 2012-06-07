<?php
require_once("../../lib/pruebas.php");
$pruebas=new pruebas_gigpz();
if (isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	//print_r($_POST);
	$pruebas->insertar_evento();
}

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="../js/funciones_pruebas.js"></script>
	<title>Crear Nuevo Eventos</title>
</head>
<body onload="limpiar();">
	<form name="form_evento" method="post" action="">
		<h2>Crear Evento</h2>
		Titulo:<input type="text" name="titulo" />
		<br>
		Descripcion:<textarea name="descrip" cols="30" rows="5"></textarea>
		<br>
		Inicio<input type="text" name="inicio">
		<br>
		Termino<input type="text" name="termino">
		<br>
		Fecha<input type="text" name="fecha">
		<hr>
		<input type="hidden" name="grabar" value="si">
		<input type="button" value="volver" title="volver" onclick="window.location='calendario.php'">&nbsp;
		<input type="button" value="Crear Evento" title="Crear Evento" onclick="validar();">

	</form>
</body>
</html>