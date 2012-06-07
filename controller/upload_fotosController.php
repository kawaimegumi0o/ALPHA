<?php

/*function __autoload($class_name) 
{
    	require_once("model/".$class_name."Model.php");
}
*/


if (isset($_POST["grabar"]) && $_POST["grabar"]=='si')
{
	//echo "la sesion es de: ".$_SESSION["session_id"]."\ntotal de archivos subidos ";
	//print_r(count($_FILES["fotos"]["name"]));
	require_once("lib/config.php");
	require_once("model/miembrosModel.php");
	$m= new miembros();

	$idm=$_SESSION["session_id"];
	$m->crear_album($idm);
}else if (isset($_GET["gFoto"]) && $_GET["gFoto"]=='si') {
	
	//echo "grabar";
	require_once("../lib/config.php");
	require_once("../model/miembrosModel.php");
	$m= new miembros();

	$idm=$_SESSION["session_id"];
	$grabar_album="insert into album values(null,$idm,'Album sin Titulo')";
    mysql_query($grabar_album,gigpz::con());
    $id_album=mysql_insert_id();
    $m->xalbum=$id_album;
    echo $m->xalbum;
}else
{
	echo "no se grabo";
}


?>