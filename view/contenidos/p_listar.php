<?php
require_once("../../lib/pruebas.php");
$pruebas=new pruebas_gigpz();

$d=$pruebas->p_get_miembros();

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procedimiento Almacenado para Listar Datos</title>
</head>
<body>
	<h2>Listar con Procedimientos Almacenados</h2>
	<ul>
		<?php
			foreach ($d as $dato) 
			{
				?>
					<li>Nombre: <?php echo $dato["nombres"];?>
						<br />Correo: <?php echo $dato["email"];?><hr />
					</li>
				<?php	
			}
		?>
		
	</ul>	

</body>
</html>