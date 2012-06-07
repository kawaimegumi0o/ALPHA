<?php
interface plantilla_miembros
{
    public function mostrar_meses();
    public function existe_miembro();
    public function registrar_miembro();
    public function get_miembros();
    public function edit_miembro();
    public function eliminar_miembro();
    public function miembros_id();
    public function logueo();
    public function cerrar_sesion();
    public function mostrar_album_inicial($miembro);
    public function crear_album($miembro);
    public static function ValidaDimensiones($id_m,$foto_a,$id_foto,$posicion,$tot_f,$id_alb);
    public function navegar_fotos($m,$pos);
    public static function todas_destacadas($miembro);
    public function get_comentarios_fotos($id_foto);
    public static function grabar_comentarios_fotos();
    public function ultimo_comentario_foto($id);
}
class miembros extends gigpz implements plantilla_miembros
{
	private $miembro;
    protected $album_inicial;
    public $xalbum;
    private $comentarios_foto;
    private $rpt_navegacion;
	public function __construct($xalbum=null)
	{
		$this->miembro=array();
		$this->album_inicial=array();
        $this->xalbum=$xalbum;
        $this->comentarios_foto=array();
        $this->rpt_navegacion=array();
	}
    /*function __autoload($class_name) 
    {
        include("model/".$class_name."Model.php");
    }*/
    public function mostrar_meses()
    {
        return parent::cargarMeses();
    }
    public function existe_miembro()
    {
        $id_v=htmlspecialchars($_POST["id_valor"]);
        parent::con();
        $sql=sprintf
        (
            "select id_miembro,email from miembros where email=%s",
            parent::comillas_inteligentes($id_v)
        );
        $res=mysql_query($sql);
        if (mysql_num_rows($res)>0) {
            //header("Location: ".parent::ruta()."?accion=index&m=5");
            echo "<h3 style='color:red'>El Usuario Ingresado ya Existe</h3>";
            //exit();
        }else
        {
            echo "<h3 style='color:green'>Usuario Disponible</h3>";
        }
    }
    public function registrar_miembro()
    {
        //print_r($_POST);
        if (empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["email"]) or empty($_POST["pass"]) or empty($_POST["repass"]) or parent::valida_correo($_POST["email"])==false or ($_POST["sexo"]=="Seleccione" or empty($_POST["sexo"])) or ($_POST["cbo_dias"]=="dia" or empty($_POST["cbo_dias"])) or ($_POST["cbo_meses"]=="mes" or empty($_POST["cbo_meses"])) or ($_POST["cbo_anos"]=="ano" or empty($_POST["cbo_anos"])) or $_POST["pass"]!=$_POST["repass"])
        {
            header("Location: ".parent::ruta()."?accion=index&m=1");exit();
        }
        //echo "Hola";
        //validamos que el login exista en la base de datos
        $v_email=htmlspecialchars($_POST["email"]);
        parent::con();
        $sql=sprintf
        (
            "select id_miembro,email from miembros where email=%s",
            parent::comillas_inteligentes($v_email)
        );
        $res=mysql_query($sql);
        if (mysql_num_rows($res)>0) {
            header("Location: ".parent::ruta()."?accion=index&m=5");exit();
        }else{
            
            if($_POST["sexo"]=="h")
            {
              $foto="defaul1.jpg";
              }else{
              $foto="defaul2.jpg";
            }

            $nom_m=htmlspecialchars($_POST["nombre"]);
            $ape_m=htmlspecialchars($_POST["apellido"]);
            $pass_js=htmlspecialchars($_POST["pass"]);
            $pass_php=md5(htmlspecialchars($_POST["pass"]));
            $perfil='1';
            $email=htmlspecialchars($_POST["email"]);
            $empresa='1';
            $zona='1';
            //$fecha_ins=date("Y,m,d");
            $dia=$_POST["cbo_dias"];
            $mes=$_POST["cbo_meses"];
            $ano=$_POST["cbo_anos"];
            
            //$fecha = DateTime::createFromFormat('Y-m-d', $fecha_v);
            //echo $fecha->format('Y-m-d H:i:s');
            //$fecha_v=$ano.$mes.$dia;
            $fecha_ins=$ano."-".$mes."-".$dia;

            $fecha_nac=date("Y,m,d");
            $sexo=htmlspecialchars($_POST["sexo"]);
            $estado='1';

            $query=sprintf
            (
                "insert into miembros values(null,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                parent::comillas_inteligentes($nom_m),
                parent::comillas_inteligentes($ape_m),
                parent::comillas_inteligentes($pass_js),
                parent::comillas_inteligentes($pass_php),
                parent::comillas_inteligentes($foto),
                parent::comillas_inteligentes($perfil),
                parent::comillas_inteligentes($email),
                parent::comillas_inteligentes($empresa),
                parent::comillas_inteligentes($zona),
                parent::comillas_inteligentes($fecha_ins),
                parent::comillas_inteligentes($fecha_nac),
                parent::comillas_inteligentes($sexo),
                parent::comillas_inteligentes($estado)

            );
            mysql_query($query);
            /////////////////////////////////
                    $ultimo_id=mysql_insert_id(); //extrae el id
                    mkdir("public/upload/$ultimo_id"); //Crea carpeta personal
                    mkdir("public/upload/$ultimo_id/fotos"); //crea carpeta de fotos para usuario
                    copy("public/img/$foto","public/upload/$ultimo_id/$foto");
                    
                    /*Crear avatar defaul*/
                    require_once("lib/resize.php");
                    $thumbMini=new thumbnail("public/upload/$ultimo_id/$foto");
                    $thumbMini->size_width(40);
                    $thumbMini->size_height(40);
                    $thumbMini->jpeg_quality(70);
                    $thumbMini->save("public/upload/$ultimo_id/avatarDefaul.jpg");

            ///////////////Enviar Correo////////////////////
            
            ////////////////////////////////////////////////

            ///////////////GRABAR COMO NOTICIA EN GIPS/////////////////
            $insertar_noticia_gips="insert into noticias_gipz values(null,'".date("Y-m-d")."',
            '".date("H:i:s")."','".$nom_m." ya es parte de gips','Lo Nuevo en Gips',$ultimo_id,1,1)";
            mysql_query($insertar_noticia_gips,parent::con());
            //////////////////////////////////////////////////////////

            /////////////////////Redirecciona al Index/////////////////////
            header("Location: ".parent::ruta()."?accion=index&m=4");exit();
        }
    }
	public function get_miembros()
	{
		//parent::con();
		$sql="select id_miembro,nombres,email,foto,date_format(fecha_ins,'%d-%m-%Y')as fecha from miembros";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->miembro[]=$reg;
		}
		return $this->miembro;
	}
    public function edit_miembro()
    {
        if (empty($_POST["nom"]) or empty($_POST["pass"])) 
        {
            $id=htmlspecialchars($_POST["id_miembro"]);
            header("Location: ".parent::ruta()."?accion=editmiembro&m=1&valor=$id");exit();
        }
        parent::con();
        $query=sprintf
            (
                "update miembros set nombres=%s, pass_php=%s where id_miembro=%s",
                parent::comillas_inteligentes($_POST["nom"]),
                parent::comillas_inteligentes($_POST["pass"]),
                parent::comillas_inteligentes($_POST["id_miembro"])
            );
            $id=$_POST["id_miembro"];
            //mysql_query($query);
            header("Location: ".parent::ruta()."?accion=editmiembro&m=2&valor=$id");exit();

    }
    public function eliminar_miembro()
    {
        if (is_numeric($_GET["v"])) {

            parent::con();
            $sql=sprintf(
            "delete from miembros where id_miembro=%s",
            parent::comillas_inteligentes($_GET["v"])
            );
            mysql_query($sql);
            header("Location: ".parent::ruta()."?accion=vermiembros&m=2");
        }else{
            header("Location: ".parent::ruta()."?accion=vermiembros&m=3");
        }
    }
    public function miembros_id()
    {   
        if (isset($_GET["valor"]) and is_numeric($_GET["valor"])) {
            $user=htmlspecialchars($_GET["valor"]);
            parent::con();
            $sql=sprintf(
            "select id_miembro,nombres,email,pass_php from miembros where id_miembro=%s",
            parent::comillas_inteligentes($user)
            );
            $res=mysql_query($sql);
            while($reg=mysql_fetch_assoc($res))
            {
                $this->miembro[]=$reg;
            }
            return $this->miembro;
        }
        
         
    }
    public function logueo()
    {
    	//rint_r($_POST);
    	if (empty($_POST["pass_miembro"]) or empty($_POST["nom_miembro"]))
    	{
    		header("Location: ".parent::ruta()."?accion=index&m=1");

    	}
    		$user=htmlspecialchars($_POST["nom_miembro"]);
			$pass_js=htmlspecialchars($_POST["pass_miembro"]);
			$pass_php=md5(htmlspecialchars($_POST["pass_miembro"]));
			//echo $user." ".$pass_php;exit();
    		parent::con();
    		$sql=sprintf
    		(
	    		"select id_miembro,nombres,email,foto,sexo from miembros where email=%s and pass_js=%s and pass_php=%s and estado=1",
	    		parent::comillas_inteligentes($user),
                parent::comillas_inteligentes($pass_js),
                parent::comillas_inteligentes($pass_php)
	    		
		    );
    		$res=mysql_query($sql);
    		if (mysql_num_rows($res)==0) {
    			header("Location: ".parent::ruta()."?accion=index&m=2");
    		}else
            {
                if ($reg=mysql_fetch_array($res)) 
                {
    				$_SESSION["session_id"]	=$reg["id_miembro"];
    				$_SESSION["session_email"]=$reg["email"];
                    $_SESSION["session_nombre"]=$reg["nombres"];
                    $_SESSION["session_foto"]=$reg["foto"];
                    $_SESSION["session_sexo"]=$reg["sexo"];
    				header("Location: ".parent::ruta()."?accion=home");
    			}
    			
    		}
    	
    }
    public function cerrar_sesion()
    {
    	session_destroy();
    	header("Location: ".parent::ruta()."?accion=index&m=3");

    }

    public function mostrar_album_inicial($miembro)
    {   
        $miembro=htmlspecialchars($miembro);
        parent::con();
        $album=sprintf
        (
            //"select miembros.id_miembro,album.id_album,album.nombre,fotos.id_foto,fotos.foto from miembros inner join album on miembros.id_miembro=album.id_miembro inner join fotos on album.id_album=fotos.id_album where miembros.id_miembro=%s and album.id_album=1 order by id_foto desc limit 4",
            //"select fotos.id_foto,fotos.id_album,fotos.foto,fotos.votos,album.id_album,album.id_miembro from fotos inner join album on fotos.id_album=album.id_album where album.id_miembro=%s and fotos.votos>1",
            "select fotos.id_foto,fotos.id_album,fotos.foto,fotos.votos,album.id_album,album.id_miembro from fotos inner join album on fotos.id_album=album.id_album where album.id_miembro=%s order by fotos.id_foto desc limit 4",
             parent::comillas_inteligentes($miembro)
        );
        
        $res=mysql_query($album);
        while($reg=mysql_fetch_assoc($res))
        {
            $this->album_inicial[]=$reg;
        }      
        return $this->album_inicial;
    }

    public function crear_album($miembro)
    {
        require_once("lib/resize.php");
        if (isset($_FILES["fotos"]) || isset($_FILES["Filedata"]))
        {
            $nombre_album=$_POST["txt_nombre"];
            
            $grabar_album="insert into album values(null,$miembro,'".$nombre_album."')";
            mysql_query($grabar_album,parent::con());
            $id_album=mysql_insert_id();
            //$this->album=$id_album;

            $tot=count($_FILES["fotos"]["name"]);
            //echo "grabado correctamente ".$tot;
            ///////////////////////////////////////////////////////
            for($i=0;$i<$tot;$i++){
     
                $tamano=$_FILES["fotos"]["size"][$i];
                $tipo=$_FILES["fotos"]["type"][$i];
                if($tipo=="image/jpeg" || $tipo=="image/png" || $tipo=="image/gif" || $tipo=="image/pjpeg")
                {
                    $nfoto=$_FILES["fotos"]["name"][$i];
                    $tmpfoto=$_FILES["fotos"]["tmp_name"][$i];
            
                    copy($tmpfoto,"public/upload/$miembro/fotos/".$nfoto);
         
                    $nNombre=md5("foto".date("dMYHis")).$i;
         
                    $thumb=new thumbnail("public/upload/$miembro/fotos/".$nfoto);
                    $thumb->size_width(300);
                    $thumb->size_height(300);
                    $thumb->jpeg_quality(75);
                    $thumb->save("public/upload/$miembro/fotos/$nNombre.jpg");
         
                    unlink("public/upload/$miembro/fotos/".$nfoto);
                    $grabar_foto="insert into fotos values(null,".$id_album.",'$nNombre.jpg',1)";
                    mysql_query($grabar_foto,parent::con());
                }else{
                    continue;
                    //echo"tipo de archivo no permitido en la foto $tipo ".$i;
                    //exit;
                    
                }
            }
            //echo "grabado correctamente ".$tot;
            header("Location: ?accion=home");
        }else
        {
            echo "no se ha echo post";
        }
    }

    public static function ValidaDimensiones($id_m,$foto_a,$id_foto,$posicion,$tot_f,$id_alb)
    {
        $dimensionex=getimagesize("public/upload/".$id_m."/fotos/$foto_a");
        $anchox=$dimensionex[0];
        $altox=$dimensionex[1];
        if($anchox>$altox)
        {
         echo"<div class='destacado_h'>
         <a href=\"javascript:void(0);\" onclick=\"elegido($id_foto,$posicion); mostrar_foto('?accion=mostrar_foto',$id_m,$id_alb,$id_foto,$tot_f,'$foto_a',$posicion); mostrar_ventana('public/upload/".$id_m."/fotos/$foto_a'); \"><img src='public/upload/".$id_m."/fotos/$foto_a' width='100%' height='80px' border='0px' alt='album'/></a>
         </div>";
     
        }else
        {
         echo"<div class='destacado_v'>
         <a href=\"javascript:void(0);\" onclick=\"elegido($id_foto,$posicion); mostrar_foto('?accion=mostrar_foto',$id_m,$id_alb,$id_foto,$tot_f,'$foto_a',$posicion); mostrar_ventana('public/upload/".$id_m."/fotos/$foto_a'); \"><img src='public/upload/".$id_m."/fotos/$foto_a' width='100%' height='100px' border='0px' alt='album'/></a>
         </div>";
        }
    }

    public function navegar_fotos($m,$pos)
    {
        $m=htmlspecialchars($m);
        $p=htmlspecialchars($pos);
        parent::con();
        $sql=sprintf
        (
            "select fotos.id_foto,fotos.id_album,fotos.foto,album.id_album,album.id_miembro from fotos inner join album on fotos.id_album=album.id_album where album.id_miembro=%s order by fotos.id_foto desc limit %s,1",
            parent::comillas_inteligentes($m),
            parent::comillas_inteligentes($p)
        );

        $res=mysql_query($sql);
        if($reg=mysql_fetch_assoc($res))
        {
            $this->rpt_navegacion[]=$reg;
        }      
        return $this->rpt_navegacion;
    }

    public static function todas_destacadas($miembro)
    {
        $miembro=htmlspecialchars($miembro);
        parent::con();
        $sql=sprintf
        (
            "select count(*) as total from miembros inner join album on miembros.id_miembro=album.id_miembro inner join fotos on album.id_album=fotos.id_album where miembros.id_miembro=%s",
            parent::comillas_inteligentes($miembro)
        );
        $res=mysql_query($sql);
        if($reg=mysql_fetch_array($res))
        {
            $total_fotos=$reg["total"];
        }
        return $total_fotos;
    }

    public function get_comentarios_fotos($id_foto)
    {
     parent::con();
     $consulta=sprintf
     (
        "select coment_fotos.*,amigos.avatar from coment_fotos inner join amigos on coment_fotos.id_amigo=amigos.id_amigo where coment_fotos.id_foto=%s order by id_comentario asc",
        parent::comillas_inteligentes($id_foto)
     );
     $res=mysql_query($consulta);
     while($reg=mysql_fetch_assoc($res))
     {
        $this->comentarios_foto[]=$reg;
     }       
     return $this->comentarios_foto;
    }

    public static function grabar_comentarios_fotos()
    {
        $grabar="insert into coment_fotos values(null,".$_GET["id_resp"].",".$_GET["id_amigo"].",'".strip_tags($_GET["comentario"])."')";
        mysql_query($grabar,gigpz::con());
    }

    public function ultimo_comentario_foto($id)
    {   
        $id=htmlspecialchars($id);
        parent::con();
        $sql=sprintf
        (
            "select id_comentario,id_foto,comentario from coment_fotos where id_comentario=%s",
            parent::comillas_inteligentes($id)
        );
        $res=mysql_query($sql);
        if($reg=mysql_fetch_array($res))
        {
            $comentario=$reg["comentario"];
        }
        return $comentario;
     }

}
?>