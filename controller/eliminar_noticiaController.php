<?php
require_once("../lib/config.php");
require_once("../model/miembrosModel.php");
require_once("../model/noticiasModel.php");
/*function __autoload($class_name) 
{
    require_once("model/".$class_name."Model.php");
}*/

$n= new noticias();

$id=$_POST["id_n"];
$pro=$_POST["id_p"];

$n->eliminar_noticia($id,$pro);

//echo $id." - ".$pro;
printf("datos eliminados correctamente: %d\n",mysql_affected_rows());

?>