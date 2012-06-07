<?php
require_once("../lib/config.php");
require_once("../model/miembrosModel.php");

$m=new miembros();

$miembro=$_POST["idm"];
$posicion=$_POST["xpos"];
$tfoto=$_POST["tot_f"];

echo "Miembro ->".$miembro." Posicion ->".$posicion. " -- total fotos ".$tfoto;
if ($posicion>=0) {
	$navegacion=$m->navegar_fotos($miembro,$posicion);

	$id_foto=$navegacion[0]["id_foto"];
	$comentarios_foto=$m->get_comentarios_fotos($id_foto);
}




require_once("../view/navegar_foto.phtml");
//echo $navegacion[0]["foto"];

?>