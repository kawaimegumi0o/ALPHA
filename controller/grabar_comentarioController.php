<?php
require_once("model/miembrosModel.php");
require_once("model/noticiasModel.php");
$n= new noticias();

$comentar=$n->grabar_comentario();
$idComent=mysql_insert_id();
//$nId=$idComent-1;
$mostrar=$n->mostrar_comentario($idComent);
require_once("view/grabar_comentario.phtml");

?>
