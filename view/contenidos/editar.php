<?php
//echo "estos son los Miembros";
require_once("../../lib/pruebas.php");
	//pruebas_gigpz::conexion();
$pruebas=new pruebas_gigpz();

$datos_miembros=$pruebas->get_miembros();
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Insertar datos de Prueba con PHP PDO</title>
	<script type="text/javascript" src="../js/funciones_pruebas.js"></script>
</head>
<body onload="document.form.reset(); document.form.nombre.focus();">
<?php
if (isset($_GET["m"]))
{
	switch ($_GET["m"]) {
		case '1':
			?>
			<h3 style="color:#030">Datos ELiminados Correctamente</h3>
			<?php
			break;
		case '2':
			?>
			<h3 style="color:#030">Datos Editados Correctamente</h3>
			<?php
			break;
		default:
			# code...
			break;
	}
	
}
foreach ($datos_miembros as $d) {
		echo $d["nombre"]."--".$d["email"];

	?>
	&nbsp;&nbsp;--&nbsp;&nbsp;
	<a href='editar_miembro.php?id_m=<?php echo $d["id"];?>' title="Editar datos de <?php echo $d['nombre'];?>"><img src="../image/agregar.gif" border="0" /></a>
	&nbsp;--&nbsp;
	<a href='javascript:void(0)' title="Eliminar datos de <?php echo $d['nombre'];?>" onclick="eliminar('eliminar.php?id=<?php echo $d["id"];?>');"><img src="../image/eliminar.png" border="0" /></a><br>
	<?php

}

?>

</body>
</html>