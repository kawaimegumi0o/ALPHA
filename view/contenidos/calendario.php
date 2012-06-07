<?php
require_once("../../lib/pruebas.php");
$pruebas=new pruebas_gigpz();
$datos=$pruebas->get_calendario();

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Calendario de Eventos</title>
</head>
<body>
	<h2>Listado  de Eventos Hoy <?php echo date("d-m-Y");?></h2>
	<ul>
		<?php
			foreach ($datos as $d) {
				
				?>
				<li>Titulo: <?php echo $d["titulo"];?><br />
					Descripcion:<?php echo $d["descrip"];?><br>
					Inicio:<?php echo $d["inicio"];?><br>
					Termino:<?php echo $d["termino"];?><br>
				</li>
				<?php
			}
		?>
		
	</ul>
	<input type="button" value="Crear Evento" title="Crear Evento" onclick="javascript:window.location='crear_evento.php'" />

</body>
</html>