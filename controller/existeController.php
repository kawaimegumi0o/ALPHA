<?php
require_once("../lib/config.php");
require_once("../model/miembrosModel.php");

$m=new miembros();
$m->existe_miembro();

?>