<?php
$filename  = dirname(__FILE__).'/chat.txt';

// almacenamos un nuevo mensajes en el archivo  si es que el mensaje exite
//$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

if ($filename) {
	
	$archivo = fopen($filename, 'wb');
	fwrite($archivo, 'soy cristhian joel');
	fclose($archivo);

}

?>