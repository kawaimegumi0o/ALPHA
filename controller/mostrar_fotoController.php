<?php
//print_r($_GET);
//sleep(3);
require_once("../lib/config.php");
require_once("../model/miembrosModel.php");


$m=new miembros();

$miembro=$_GET["idm"];
$album=$_GET["alb"];
$foto=$_GET["vfoto"];
$id_f=$_GET["id_f"];
$totf=$_GET["xtot"];
$pos_f=$_GET["posi"];

$comentarios_foto=$m->get_comentarios_fotos($id_f);

require_once("../view/ver_foto.phtml");

?>



