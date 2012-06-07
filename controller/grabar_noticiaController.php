<?php
 //print_r($_GET);
require_once("model/miembrosModel.php");
require_once("model/noticiasModel.php");
//require_once("lib/Pusher.php");

	//print_r($_GET);exit();

//$pusher=PusherInstance::get_pusher();
//$pusher = new Pusher('29f62bc285fb72215530', '6522482bb010bb6799ea', '6522482bb010bb6799ea');

$n= new noticias();

	//$resp=htmlspecialchars($_GET["id_resp"]);
//$texto=htmlspecialchars($_GET["comentario"]);

$responsable=htmlspecialchars($_GET["id_amigo"]);
$id_noticia=htmlspecialchars($_GET["id_resp"]);
//$resp=htmlspecialchars($_SESSION["session_id"]);
$mi_ultima=$n->mi_ultima_noticia($responsable);
//$grabar=$n->grabar_noticia($resp,$texto);
//$idNot=$n->noticia_grabada;
	//echo "Datos guardados correctamente";
	//$nIdx=$idNot;

//$mostrar_Noticia=$n->mostrar_noticia($idNot);
$idNot=$mi_ultima[0]["id_noticia"];
$total_comentarios=noticias::total_comentarios();

//////////////////////////////////////////////
//$pusher->trigger('canal_prueba','nueva_noticia',array('texto'=>$texto),$_GET["socket_id"]);
/////////////////////////////////////////////

require_once("view/grabar_noticia.phtml");

?>