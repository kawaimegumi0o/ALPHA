<?php
//namespace libreria_gigpz
//{
//}
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)).DS);
define('APP_PATH', ROOT.'Admin'.DS);

date_default_timezone_set('America/Lima');
///////////////////////
//$idioma=$_SERVER["HTTP_ACCEPT_LANGUAGE"];
//$navegador=$_SERVER["HTTP_USER_AGENT"];

/*trait mis_metodos {
	public function calculador()
	{
		echo "el calculo se realizo...";
	}
}*/

///////////////////////
class gigpz
{
	private $servidor;
	private	$usuario;
	private	$pass;
	private	$bd;
	private $meses;
	//use mis_metodos;
	
	public function __construct($serv=null,$usu=null,$pas=null,$bd=null,$meses)
	{
		$this->servidor=$serv;
		$this->usuario=$usu;
		$this->pass=$pas;
		$this->bd=$bd;
		$this->meses=array();
	}
	public static function con()
	{
		/*$servidor="localhost";
		$usuario="gigpzcom_Acevedo";
		$pass="diosesmiesperanza123";
		$bd="gigpzcom_gigpz";*/

		/*$servidor="localhost";
		$usuario="gigpzcom_publico";
		$pass="publico731";
		$bd="gigpzcom_gigpz";*/

		$servidor="localhost";
		$usuario="root";
		$pass="gigps";
		$bd="bd_gigpz";
		
		$conexion=mysql_connect($servidor,$usuario,$pass) or die("Lo Sentimos se Ha producido un Error ".mysql_error());
		mysql_query("SET NAMES 'utf8'");
		mysql_select_db($bd);
		return $conexion;
	}
	// Aplicar comillas sobre la variable para hacerla segura
	public static function comillas_inteligentes($valor)
	{
		// Retirar las barras
		if (get_magic_quotes_gpc()) {
			$valor = stripslashes($valor);
		}
	
		// Colocar comillas si no es entero
		if (!is_numeric($valor)) {	
			$valor = "'" . mysql_real_escape_string($valor) . "'";
		}
		return $valor;
	}

	public static function con_guion($url)
  	{
        $url = strtolower($url);
        //Rememplazamos caracteres especiales latinos 
        $find = array('á','é','í','ó','ú','ñ');
        $repl = array('a','e','i','o','u','n');
        $url = str_replace($find,$repl,$url);
        // Añaadimos los guiones
        $find = array(' ', '&', '\r\n', '\n', '+'); 
                $url = str_replace ($find, '-', $url); 
        // Eliminamos y Reemplazamos demás caracteres especiales 
        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/'); 
        $repl = array('', '-', ''); 
        $url = preg_replace ($find, $repl, $url); 
        //$palabra=trim($palabra);
        //$palabra=str_replace(" ","-",$palabra);
        return $url;
	} 
	
	public static function ruta()
	{
		return "http://localhost/ALPHA/";
		//return "http://www.gigpz.com/";
	}

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
	public function cargarMeses()
	{
	    $this->meses[0]="Enero";
	 	$this->meses[1]="Febrero";
		$this->meses[2]="Marzo";
		$this->meses[3]="Abril";
		$this->meses[4]="Mayo";
		$this->meses[5]="Junio";
		$this->meses[6]="Julio";
		$this->meses[7]="Agosto";
		$this->meses[8]="Setiembre";
		$this->meses[9]="Octubre";
		$this->meses[10]="Noviembre";
		$this->meses[11]="Diciembre";
		

	    return $this->meses;
	}
}

?>