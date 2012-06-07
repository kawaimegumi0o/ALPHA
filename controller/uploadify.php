<?php
/*
Uploadify v3.1.0
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
//require_once("../lib/config.php");
require_once("../lib/config.php");
require_once("../model/miembrosModel.php");
$m= new miembros();

require_once("../lib/resize.php");
// Define a destination
$targetFolder = '/ALPHA/public/upload'; // Relative to the root
//$targetFolder = '/public/upload';

$idm=$_POST["album"];
$idAlb=$_POST["id_alb"];
$id_alb=array();

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	//$targetPath = $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

	$n_nombre=md5($_FILES['Filedata']['name']).".jpg";
	$destino = rtrim($targetPath,'/') . '/' .$idm. '/fotos/' .$n_nombre;
	$v_img=$_FILES['Filedata']['name'];
	//$album=$_POST['album'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','JPG'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		
		move_uploaded_file($tempFile,$targetFile);

		$thumb=new thumbnail($targetFile);
		$thumb->size_width(300);
        $thumb->size_height(300);
        $thumb->jpeg_quality(75);
        //$thumb->save($targetFile);
        $thumb->save($destino);
		unlink($targetFile);

		gigpz::con();
		$ultimo_album=sprintf
		(
			"select id_album,nombre,id_miembro from album where id_miembro=%s order by id_album desc limit 1",
			gigpz::comillas_inteligentes($idm)
		);
		$res=mysql_query($ultimo_album);
        if($reg=mysql_fetch_assoc($res))
        {
            $id_alb[]=$reg;
        }
		
		$mi_album=$id_alb[0]["id_album"];
        $grabar_foto="insert into fotos values(null,".$mi_album.",'".$n_nombre."',1)";
        mysql_query($grabar_foto,gigpz::con());

		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>