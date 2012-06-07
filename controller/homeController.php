<?php
if (isset($_SESSION["session_id"])) {

	$foto=$_SESSION["session_foto"];
	$sexo=$_SESSION["session_sexo"];
	$id_miembro=$_SESSION["session_id"];
	$email=$_SESSION["session_email"];
	$nombre=$_SESSION["session_nombre"];

	//require_once("model/miembrosModel.php");
	//require_once("model/noticiasModel.php");
	function __autoload($class_name) 
	{
    	require_once("model/".$class_name."Model.php");
	}

	$m=new miembros();
	$n= new noticias();

	$fotos_destacadas=$m->mostrar_album_inicial($id_miembro);
	$total_destacadas=miembros::todas_destacadas($id_miembro);
	
	$total_coment=noticias::total_comentarios();
	$noticias=$n->get_noticias($id_miembro);
	//llevar el total de las notcias
	if (count($noticias)>0) {
		$total_noticia=count($noticias);
	}else{
		$total_noticia=0;
	}
	

	$ultima_noticia=noticias::ultima_noticia_amistad($id_miembro);
	require_once("view/home.phtml");

}else
{
	header("Location: ".gigpz::ruta());
}

?>