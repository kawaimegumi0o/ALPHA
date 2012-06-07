<?php
require_once("../lib/pruebas.php");
$pruebas=new pruebas_gigpz();

if (isset($_POST["enviar"]) and $_POST["enviar"]=="gigpz_yes") {

		$pruebas->contactar();
}	

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<!--<meta name="viewport" content="width=320" content="width=device-width" height=device-height maximum-scale=2, 
	minimum-scale=0.5, user-scalable=no, target-densitydpi=device-dpi>-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../public/img/favicon.ico">
	<link rel="icon" type="image/gif" href="../public/img/gigpz_favicon.gif" />
	<link type="text/css" href="../public/css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="Stylesheet" />
	<link type="text/css" href="css/pruebas.css" rel="Stylesheet" />

	<script type="text/javascript" src="../public/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>
	<script type="text/javascript" src="js/funciones_pruebas.js"></script>
	<title>Bienvenido a gigpz</title>
	<style type="text/css">
		
	</style>

	<script>
	$(document).ready(function(){

	});
	$(function() {
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		$("#accordion").accordion({
			event: "mouseover",
			icons: icons
		});

	});
	</script>

</head>
<body onload="document.frm_contacto.reset();">
	<br>
	<div id="bloke_principal">
		<div id="bloke">
			<br />
			<span>Web en Desarrollo...</span>
			<hr>
			
			<div id="bloke_acordion">
			<div id="accordion">
				<h3><a href="#">&nbsp;Contactarme...</a></h3>
				<div id="div_contacto">
					<form name="frm_contacto" method="post" action="" id="frm_contacto">
						<fieldset>
							<address>Escribeme a: </address>
							<hr>
							<label>Nombre</label>
							<input type="text" name="txt_nombre" id="txt_nombre" title="Ingrese su Nombre"/>
							<label for="txt_email">E-mail:</label>
							<input type="text" name="txt_email" id="txt_email" title="Ingrese su E-mail!"/>
							<label for="txta_mensaje">Mensaje</label>
							<textarea name="txta_mensaje" id="txta_mensaje" cols="30" rows="5" title="Mensaje!"></textarea>
							<img src="../lib/captcha.php" id="captcha">
							<input type="text" name="txt_imagen" id="txt_imagen" title="Ingrese texto de la imagen" />
							<input type="hidden" name="enviar" value="gigpz_yes">
							<input type="button" value="Enviar" onclick="enviar_carreo();" title="Enviar Mensaje"/>
							<span id="rpt_envio">
								<?php
									if (isset($_GET["m_gz"])) {
										switch ($_GET["m_gz"]) {
											case '1':
												?>
													<font style='color:red'>No se ha podido enviar el correo verifique datos.</font>
												<?php
												break;
											case '2':
												?>
													<font style='color:green'>tu correo ha sido enviado correctamente.</font>
												<?php
												break;
											
											default:
												# code...
												break;
										}
									}
								?>

							</span>
						</fieldset>
					</form>
				</div>
				<h3><a href="#">&nbsp;Comentar...</a></h3>
				<div id="div_comentario">
					<h3>Escribenos tu Comentarios</h3>
					<span>Modulo en Construccion</span>
					<form name="frm_comentario" method="post" action="" id="frm_comentario">
						
						<!--<label for="">correo:</label>-->
						<div id="contenedor_chat">
							&nbsp;
						</div>
						<textarea class="formato_text" name="txta_comentario" id="txta_comentario"></textarea><br/>
						
					</form>
				</div>				
				<h3><a href="#">&nbsp;Acerca de gigpz...</a></h3>
				<div>
					
					gigpz fue desarrollado para servir al usuario final, brindando una plataforma
					amigable e &iacute;ntegra en la web.
					
					<ul><strong>Desarrolladores</strong>
						<li>Cristhian joel Acevedo Tipian</li>
						<li>Erick alexander Reynoso Zuñiga</li>
						<li>Alexander Saravia Tasayco</li>
						<li>Pablo Zuñiga Donayre</li>
						<li>Hugo Tasayco Almeyda</li>
					</ul>
					<hr>
				</div>

				

			</div>
			</div>
			<?php
				//Aqui mi condicion para la imagen
			?>
			<img src="../public/img/gigpzp1.png" width="" height="" title="En Desarrollo!" border="0px"/>			
			<!--<img src="image/Flecha_roja_derecha.png">-->
		</div>
		
	</div>
</body>
</html>