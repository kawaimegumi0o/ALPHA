<?php
session_start();
interface metodos_prueba
{
	//public static function conexion();
	public static function valida_correo($email);
	public static function ruta();
	public function get_miembros();
	public function get_miembros_id();
	public function insertar_miembros();
	public function eliminar_miembro();
	public function editar_miembro();
	public function p_get_miembros();
	public function p_get_miembros_id($id);
	public function p_insertar();
	public function conexion_sp ();
	public function get_calendario();
	public function insertar_evento();
	public function contactar();
	public function get_captcha($length);
}
class pruebas_gigpz implements metodos_prueba
{
	private $dbh;
	private $miembros;
	private $eventos;
	private $mi_captcha;

	public function __construct($mi_captcha=null){
		$this->miembros=array();
		$this->dbh=new PDO('mysql:host=localhost;dbname=bd_gigpz','root','gigps');
		//$this->dbh=new PDO('mysql:host=localhost;dbname=gigpzcom_gigpz','gigpzcom_publico','publico731');
		//gigpzcom_pruebas
		$this->eventos=array();
		$this->mi_captcha=$mi_captcha;

		date_default_timezone_set('America/Lima');

	}

	/*public static function conexion()
	{
		try {
			$user="root";
			$pass="gigps";
			$dbh=new PDO('mysql:host=localhost;dbname=bd_gigpz',$user,$pass);
			$dbh->query("SET NAMES 'utf8'");
			foreach ($dbh->query('select * from miembros') as $row) {
				//print_r($row);
				//echo $row["nombres"]."<br />";
			}
			$dbh=null;
		} catch (PDOException $e) {
			print "Error!: ".$e->getMessage()."<br />";
			die();
		}
	}*/
	
	public static function valida_correo($email)
	{
	    $mail_correcto = 0;
	    
	    //compruebo unas cosas primeras
	    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
	       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
	          //miro si tiene caracter .
	          if (substr_count($email,".")>= 1){
	             //obtengo la terminacion del dominio
	             $term_dom = substr(strrchr ($email, '.'),1);
	             //compruebo que la terminaci�n del dominio sea correcta
	             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
	                //compruebo que lo de antes del dominio sea correcto
	                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
	                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
	                if ($caracter_ult != "@" && $caracter_ult != "."){
	                   $mail_correcto = 1;
	                }
	             }
	          }
	       }
	    }
	    if ($mail_correcto)
	    {
	    	return true;
	    }
	    else{
	    	return false;
	    }       
	}

	private function set_names(){

		return $this->dbh->query("SET NAMES 'utf8'");
	}

	public static function ruta()
	{
		return "http://localhost/ALPHA/";
		//return "http://www.gigpz.com/";
	}

	public function get_miembros(){
		
		self::set_names();
		$sql="select * from tabla_prueba";
		$this->dbh->query($sql);
		foreach ($this->dbh->query($sql) as $row) {
			$this->miembros[]=$row;
		}

		return $this->miembros;
		$this->dbh=null;
	}

	public function get_miembros_id()
	{
		self::set_names();
		//$sql="select * from miembros where id_miembro= ? and email= ?"; con mas parametros
		$sql="select * from tabla_prueba where id= ?";
		$stmt=$this->dbh->prepare($sql);
		if ($stmt->execute(array($_GET['id_m']))) {
			while ( $row = $stmt->fetch()) {
					$this->miembros[]=$row;
			}
			return $this->miembros;
			$this->dbh=null;
		}
		/*$this->dbh->query($sql);
		foreach ($this->dbh->query($sql) as $row) {
			$this->miembros[]=$row;
		}
		return $this->miembros;
		$this->dbh=null;*/
	}

	public function insertar_miembros()
	{
		$sql="insert into tabla_prueba values(null,?,?,?);";
		$stmt=$this->dbh->prepare($sql);
		$stmt->bindParam(1, $nombre);
		$stmt->bindParam(2, $email);
		$stmt->bindParam(3, $edad);

		$nombre=$_POST["nombre"];
		$email=$_POST["email"];
		$edad=$_POST["edad"];

		$stmt->execute();
		//echo "datos insertados"."<br />";
		//print_r($_POST);
		header("Location: insertar.php?m=1");
	}
	public function eliminar_miembro()
	{
		//print_r($_GET);
		//$sql="delete from tabla_prueba where id=".$_GET['id']."";
		//$this->dbh->exec($sql);
		$sql="delete from tabla_prueba where id= ?";
		$stmt=$this->dbh->prepare($sql);
		$stmt->bindParam(1,$id);
		$id=$_GET["id"];

		$stmt->execute();
		header("Location: editar.php?m=1");

	}
	public function editar_miembro()
	{
		//print_r($_POST);
		self::set_names();
		$sql="update tabla_prueba set nombre= ?, email= ?, edad= ? where id= ?";
		$stmt=$this->dbh->prepare($sql);

		//$stmt->bindValue(1, $nombre, PDO::PARAM_INT);
		//$stmt->bindValue(2, $email, PDO::PARAM_STR);
		
		$stmt->bindParam(1, $nombre);
		$stmt->bindParam(2, $email);
		$stmt->bindParam(3, $edad);
		$stmt->bindParam(4, $id);

		$nombre=$_POST["nombre"];
		$email=$_POST["email"];
		$edad=$_POST["edad"];
		$id=$_POST["editar"];

		$stmt->execute();
		//echo "datos insertados"."<br />";
		//print_r($_POST);
		header("Location: editar.php?m=2");

	}

	public function p_get_miembros()
	{	
		self::set_names();

		$stmt=$this->dbh->prepare("call get_miembros();"); //llama al procedimiento almacenado
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			$this->miembros[]=$row;
		}
		return $this->miembros;

	}

	public function p_get_miembros_id($id)
	{
		self::set_names();
		$stmt=$this->dbh->prepare("call sp_get_miembros_id(?);"); //llama al procedimiento almacenado
		$id_m=$id;
		$stmt->bindParam(1, $id_m, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			$this->miembros[]=$row;
		}
		return $this->miembros;
	}

	public function p_insertar()
	{
		self::set_names();
		//create procedure sp_insertar(in n varchar(200), in c varchar(200), in e int)
		//insert into tabla_prueba values (null, n,c,e);
		$stmt=$this->dbh->prepare("call sp_insertar(?,?,?);");

		$nombre=$_POST["nombre"];
		$email=$_POST["email"];
		$edad=$_POST["edad"];

		$stmt->bindParam(1, $nombre,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
		$stmt->bindParam(2, $email,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
		$stmt->bindParam(3, $edad,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);

		$stmt->execute();
		header("Location: p_insertar.php?m=1");

	}
	
	//////////////////////////////////////MYSQLI///////////////////////////////
	/*CREATE DEFINER=`root`@`localhost` PROCEDURE `ingresar`(in nom varchar(200), in c varchar(200),in e int)
	begin
     if e<18 then
       insert into tabla_prueba values(null,nom,c,e);       
     else     
       insert into tabla_prueba values(null,nom,c,e);
     end if;
	end;*/
	public function conexion_sp()
	{	
		$mysqli= new mysqli('localhost','root','gigps');
		$mysqli->select_db("bd_gigpz");
		$datos=$mysqli->query("CALL ingresar('joel','acevedo@hotmail.com',24);");
		
		/*if ($datos = $mysqli->query("CALL ingresar('joel','acevedo@hotmail.com',24);")) {
			while ($reg=$datos->fetch_object()) {
				echo $reg->nombre;
				echo "<br />";
			}
			$reg->close();
		}
		$mysqli->close();*/
	}

	public function get_calendario()
	{
		//dato CLIENT_MULTI_RESULTS -- mysql_real_connect ()
		$mysqli=new mysqli('localhost','root','gigps');
		$mysqli->query("SET NAMES 'utf8'");
		$mysqli->select_db('bd_gigpz');
		$fecha=date("Y-m-d");

		$res=$mysqli->query("call listar_calendario('$fecha');");
		
		while ($reg=$res->fetch_array()) {
			$this->eventos[]=$reg;
		}
		return $this->eventos;
		$mysqli->close();
	}
	public function insertar_evento()
	{
		/*create procedure crear_evento(in titulo varchar(200),in des text,in inicio varchar(100),in termino varchar(100),in fe varchar(10))
			begin
     		insert into calendario values(null,titulo,des,inicio,termino,fe);
			end;

			CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_calendario`(in fe varchar(10))
			begin
     		select * from calendario where fecha=fe order by id_calendario desc;
			end;
		*/
		$mysqli=new mysqli('localhost','root','gigps');
		$mysqli->query("SET NAMES 'utf8'");
		$mysqli->select_db('bd_gigpz');
		
		$titulo=$_POST["titulo"];
		$des=$_POST["descrip"];
		$inicio=$_POST["inicio"];
		$termino=$_POST["termino"];
		$fecha=$_POST["fecha"];

		$res=$mysqli->query("call crear_evento('$titulo','$des','$inicio','$termino','$fecha');");
		header("Location: calendario.php");
	}

	public function contactar()
	{	

		if (empty($_POST["txt_nombre"]) or empty($_POST["txt_email"]) or empty($_POST["txta_mensaje"]) or (self::valida_correo(($_POST["txt_email"])==false)) or $_POST["txt_imagen"]!=$_SESSION['tmptxt'])
		{
			//ojo falta validar el correo x php
			header("Location: index.php?m_gz=1");exit();
		}
		//print_r($_POST);
		///////////////Enviar Correo////////////////////
		//$identidad=$id;
		$fecha=date("d-m-Y"); //devuelve de la fecha el dia-mes-año//
		$hora=date("H:m:s");

		$nombre=$_POST["txt_nombre"];
		//$email=$_POST["txt_email"];
		$email='webmaster@gigpz.com';
		$mensaje=$_POST["txta_mensaje"];

		//$remitente="Remitente acevedo-001@hotmail.com"; //quien te invita
		$remitente="Remitente: <".$_POST["txt_email"].">";
		$asunto="contactar";
		//$cuerpo=$mensaje;
		$cuerpo="Nombre: ".$nombre." Correo: ".$remitente." Mensaje: ".$mensaje;	
		//enviar cabeceras opcional no envio esta vez//
		$cabecera= "From: ".$remitente." <".$remitente.">";
		//mail($email,$asunto,$cuerpo); //envia el correo*/
		//echo "correo enviado --> ".$remitente." - ".$email." - ".$asunto." - ".$cuerpo." - ".$cabecera;
		header("Location: index.php?m_gz=2");

		/*///////////AQUI SE ENVIA EL CORREO FORMATO/////////////////
		$mi_mail="tucorreo@correo.com";
		$remitente="Remitente<tucorreo@hotmail.com>";
		$asunto="Asunto del correo"; //Asunto 
		$cuerpo="
		<html> 
		<body> 
		<table> 
		<tr bgcolor='#f0f0f0'><td>
		<font size='1' face='Verdana'>
		Nombre:&nbsp;".$nom."<br>
		Tel&eacute;fono:&nbsp;".$tel."<br>Correo:
		&nbsp;".$correo."<br>Mensaje:&nbsp;".$mensaje."
		</font> 
		</td>
		</tr>
		</table>
		</body> 
		</html>
		"; //mensaje
		$sheader="From:".$remitente."\nReply-To:".$remitente."\n"; 
		$sheader=$sheader."X-Mailer:PHP/".phpversion()."\n"; 
		$sheader=$sheader."Mime-Version: 1.0\n"; 
		$sheader=$sheader."Content-Type: text/html";
		mail($mi_mail,$asunto,$cuerpo,$sheader); 
		//***********************************///
		
	}

	public function get_captcha($length)
	{

    	$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
    	for($i=0;$i<$length;$i++) {
      		$this->mi_captcha .= $pattern{rand(0,35)};
    		//return $mi_clave;
      	}

      	//echo $this->mi_captcha;
		$_SESSION['tmptxt'] = $this->mi_captcha;

		$captcha = imagecreatefromgif("../public/img/bgcaptcha.gif");
		$colText = imagecolorallocate($captcha, 0, 0, 0);
		imagestring($captcha, 5, 16, 7, $_SESSION['tmptxt'], $colText);
		header("Content-type: image/gif");
		imagegif($captcha);
		//echo $_SESSION['tmptxt'];

	}

}	
?>