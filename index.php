<?php
//header("Location: view/gigpz.html");

require_once("lib/config.php");

//get_required_files()
if (!empty($_GET["accion"]))
{
	$accion=$_GET["accion"];
}else
{
	$accion="index";	
}
if (is_readable("controller/".$accion."Controller.php")) 
{
	require_once("controller/".$accion."Controller.php");
}
else
{
	require_once("controller/errorController.php");	
}


?>