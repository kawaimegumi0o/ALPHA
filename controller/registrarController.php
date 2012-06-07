<?php
//print_r($_POST);
//require_once("/lib/config.php");
require_once("model/miembrosModel.php");


$m=new miembros();
$m->registrar_miembro();


?>