<?php
require_once("../../lib/pruebas.php");
$pruebas=new pruebas_gigpz();
if (isset($_POST["grabar"]) && $_POST["grabar"]=="si") {
	$pruebas->p_insertar();

}
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procedimiento Almacenado para Insertar Datos</title>
</head>
<body onload="document.form.reset(); document.form.nombre.focus();">
	<h2>Insertar con Procedimientos Almacenados</h2>
	<?php
		if (isset($_GET["m"]) and $_GET["m"]==1)
		{
		
		?>
			<h3 style="color:#093">Datos Grabados Correctamente con SP</h3>
		
		<?php

		}
	?>
	<form name="form" action="" method="post">
		<h2>Ingresar datos con SP</h2>
		Nombre:<input type="text" name="nombre"><br />
		E-mail:<input type="text" name="email"><br />
		Edad<input type="text" name="edad">
		<input type="hidden" name="grabar" value="si">
		<input type="submit" value="Insertar" title="Insertar">

	</form>

</body>
</html>