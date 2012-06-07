<?php
require_once("../../lib/pruebas.php");
	//pruebas_gigpz::conexion();
if (isset($_POST["grabar"]) && $_POST["grabar"]=="si") {
	
	$pruebas=new pruebas_gigpz();
	$pruebas->insertar_miembros();

	//print_r($_POST);
	//exit();
}

//$datos_miembros=$pruebas->get_miembros_id();
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Insertar datos de Prueba con PHP PDO</title>
</head>
<body onload="document.form.reset(); document.form.nombre.focus();">
	<hr />
	<?php
		if (isset($_GET["m"]) and $_GET["m"]==1)
		{
		
		?>
			<h3 style="color:#093">Datos Grabados Correctamente</h3>
		
		<?php

		}
	?>
	<form name="form" action="" method="post">
		<h2>Ingresar datos de prueba</h2>
		Nombre:<input type="text" name="nombre"><br />
		E-mail:<input type="text" name="email"><br />
		Edad<input type="text" name="edad">
		<input type="hidden" name="grabar" value="si">
		<input type="submit" value="Insertar" title="Insertar">

	</form>
	<hr />
</body>
</html>
