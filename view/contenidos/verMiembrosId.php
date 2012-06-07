<?php
require_once("../../lib/pruebas.php");
	//pruebas_gigpz::conexion();
$pruebas=new pruebas_gigpz();

$datos_miembros=$pruebas->get_miembros_id();

foreach ($datos_miembros as $d) {
		echo $d["nombre"]."--".$d["email"];
}

?>