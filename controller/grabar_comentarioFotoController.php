<?php
require_once("lib/config.php");
require_once("model/miembrosModel.php");

$m=new miembros();
miembros::grabar_comentarios_fotos();
$u_id=mysql_insert_id();
//echo $u_id;
$u_comentario=$m->ultimo_comentario_foto($u_id);

echo $u_comentario;

?>
