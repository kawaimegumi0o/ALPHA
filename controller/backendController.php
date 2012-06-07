<?php
	/*try {
		
	} catch (Exception $e) {
		echo "excepcion capturada: ". $e->getMessage();
	}*/
	
		// dirname -> parte del path correspondiente al directorio
	require_once("../lib/config.php");

		//$filename  = gigpz::ruta().'mis_files/chat.txt';
		//$filename  = dirname(__FILE__).'/chat.txt';
	
	//$filename  = ROOT.'chat.txt';

	require_once("../model/miembrosModel.php");
	require_once("../model/noticiasModel.php");
	$id=$_GET["id_miembro"];
	$ultima=$_GET["ultima_noticia"];
	
		// almacenamos un nuevo mensajes en el archivo  si es que el mensaje exite
	$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

	$n= new noticias();
	$ultima_noticia=$n->ultima_noticia_miembro($id);
	$noticia_final=$ultima_noticia[0]["id_noticia"];
	$responsable=$ultima_noticia[0]["id_miembro"];
	
	/////////////////////////////////
		//si el mensaje existe lo escribimos en nuestro archivo
	if ($msg != '')
	{
        //////Aqui GRABAMOS LA NOTICIA//////////////
        //$responsable=htmlspecialchars($_GET["id_amigo"]); xxx
        $n->grabar_noticia($id,$msg);
        $idNot=$n->noticia_grabada;
        
        //$mostrar_Noticia=$n->mostrar_noticia($idNot);
        //$ultima=$mostrar_Noticia[0]["id_noticia"];
        	//file_put_contents -> escribir una cadena sobre un archivo
  	  	//file_put_contents($filename,$msg);
  	  	$vRpt='1';
        die();
        
        //$mostrar_Noticia=$n->mostrar_noticia($idNot);
		//$total_comentarios=noticias::total_comentarios();
        //require_once("view/grabar_noticia.phtml");
        //exit();
	}else{
		$vRpt='0';
	}


		// bucle infinito mientras los datos del archivo no son modificados
	$ultima_modificacion = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;

		//filemtime -> obtiene la hora de modificación del archivo
	//$actual_modificacion = filemtime($filename);
	$actual_modificacion = 50 + rand(0,5000);

	////////////////////////////////////////////////////
	//si mi noticia es mayor o igual a la noticia final de algun amigo///
	if ($ultima>=$noticia_final) {
			//no pasa nada
		$response = array();
		//$response['msg'] = '1= '.$ultima.' 2='.$noticia_final;		
		$response['id_ultima']=$ultima;

		if ($vRpt=='1')
		{
			//$mostrar_Noticia=$n->mostrar_noticia($ultima);
			//$total_comentarios=noticias::total_comentarios();
			$response['msg'] ='mensaje lleno';
			
		}else{
			$response['msg'] = '';

		}
		
		/*while ($ultima>=$noticia_final) {
			usleep(10000);
        	clearstatcache();
        	$actual_modificacion = filemtime($filename);
		}*/
		$response['timestamp'] = $actual_modificacion;
		echo json_encode($response);
		flush();
		
		//si la noticia de un amigo es mas actualizada que la mia
	}else if ($ultima<$noticia_final) {
		
		
		$mostrar_Noticia=$n->mostrar_noticia($noticia_final);
		$total_comentarios=noticias::total_comentarios();
		
		$response = array();
		$response['id_ultima']=$noticia_final;
		$response['msg'] ="<div class='noticias_separador'></div><div class='noticias_titulo' onmousemove='javascript:id_NoticiaX=".$mostrar_Noticia[0]['id_noticia']."'><img src='public/upload/".$mostrar_Noticia[0]['avatar']."' alt='avatar' border='0' width='40' height='50'/><strong>".$mostrar_Noticia[0]['titulo_noticia']."</strong><span>!! ".$mostrar_Noticia[0]['fecha_noticia']." - ".$mostrar_Noticia[0]['hora_noticia']."<br>".$mostrar_Noticia[0]['acontecimiento']."</span></div><div class='noticias_linea_cuerpo'></div><div class='noticias_separador'></div><div class='noticias_cuerpo' onmousemove='javascript:id_NoticiaX=".$mostrar_Noticia[0]['id_noticia']."' id='noticias_cuerpo".$noticia_final."'><div class='comentarios_generados_noticias' id='resultado_de_comentariosX".$noticia_final."'></div><div class='operaciones_noticia'><a href='javascript:void(0)'' id='' onclick='gigpz.crearComentador(".$noticia_final.",".$total_comentarios.",\"resultado_de_comentariosX".$noticia_final."\",\"?accion=grabar_comentario\",".$noticia_final.",\"b\",".$id.");'>Comentar</a>&nbsp;&nbsp;&nbsp;--------&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);'>Me gusta! </a>total de comentarios -- >> 0</div></div><div class='noticias_foot'></div>";
		//$mostrar_Noticia[0]["acontecimiento"]
		$response['timestamp'] = $actual_modificacion;
	
		echo json_encode($response);
		
		flush();
	}
	///////////////////////////////////////////////////////////

	/*while($actual_modificacion < $ultima_modificacion){ // verificar si el archivo de datos ha sido modificado
        usleep(10000); // hacemos descansar al CPU por 10ms
        
        //clearstatcache -> limpia la cache de estado de un archivo
        clearstatcache();
        $actual_modificacion = filemtime($filename);
	}*/


	/*$response = array();
		//file_get_contents -> lee un archivo entero en una cadena
	$response['msg'] = file_get_contents($filename);
	$response['timestamp'] = $actual_modificacion;
	

	echo json_encode($response);
	flush();*/

?>