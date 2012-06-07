<?php
//echo "estos son los Miembros";
require_once("../../lib/pruebas.php");
	//pruebas_gigpz::conexion();
$pruebas=new pruebas_gigpz();

$datos_miembros=$pruebas->get_miembros();

foreach ($datos_miembros as $d) {
		echo $d["nombre"]."--".$d["email"]."--<a href='verMiembrosId.php?id_m=".$d["id"]."'>ver datos completos</a><hr />";
}

?>