<?php
if (isset($_SESSION["session_id"])) {

	header("Location: ".gigpz::ruta()."?accion=home");
}
//require_once("model/miembrosModel.php");
function __autoload($class_name) 
{
    require_once("model/".$class_name."Model.php");
}

$miembro=new miembros();
$meses=$miembro->mostrar_meses();
if (isset($_POST["ingresar"]) and $_POST["ingresar"]=="si")
{
	$miembro->logueo();
}
//lamamos al html o su vista//
require_once("view/index.phtml");


?>