<?php
require_once("../../lib/pruebas.php");
$pruebas=new pruebas_gigpz();
if (isset($_POST["editar"])) {
	
	//$pruebas->insertar_miembros();
	$pruebas->editar_miembro();
	//print_r($_POST);
	//exit();
}

$datos=$pruebas->get_miembros_id();
//print_r($datos);
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Editar datos de <?php echo $datos[0]["nombre"];?></title>
</head>
<body onload="document.form.reset(); document.form.nombre.focus();">
	<hr />
	<?php
		if (isset($_GET["m"]) and $_GET["m"]==1)
		{
		
		?>
			<h3 style="color:#093">Datos Editados Correctamente</h3>
		
		<?php

		}
	?>
	<form name="form" action="" method="post">
		<h2>Editar datos <?php echo $datos[0]["nombre"];?></h2>
		Nombre:<input type="text" name="nombre" value="<?php echo $datos[0]['nombre'];?>"><br />
		E-mail:<input type="text" name="email" value="<?php echo $datos[0]['email'];?>"><br />
		Edad<input type="text" name="edad" value="<?php echo $datos[0]['edad'];?>">
		<input type="hidden" name="editar" value="<?php echo $_GET["id_m"];?>">
		<input type="button" value="Volver Atras" title="Volver" onclick="javascript:window.location='editar.php'">
		<input type="submit" value="Editar" title="Editar">

	</form>
	<hr />
</body>
</html>
