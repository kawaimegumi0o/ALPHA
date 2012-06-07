<?php
interface plantilla_noticias
{
	
	public function get_noticias($miembro);
	public static function total_comentarios();
	public static function ultima_noticia_amistad($yo);
	public function grabar_noticia($responsable,$detalle);
	public function mostrar_noticia($noticia);
	public function get_comentarios_de_noticia($id);
	public function grabar_comentario();
	public function mostrar_comentario($id_coment);
	public function ultima_noticia_miembro($miembro);
	public function mi_ultima_noticia($id);
	public function eliminar_noticia($id_n,$id_p);
	public static function filtrar_noticia($web,$id_noticia);
}

class noticias extends miembros implements plantilla_noticias
{	

	protected $noticias_gigpz;
	private $noticiaId;
	private $comentarios_de_noticias;
	private $comentario_mostrar;
	public $noticia_grabada;
	protected $ultima_noticia;
	protected $mi_ultima_not;


	//private $total;
	//private $ultima;

	public function __construct($noticia_grabada=null)
	{
		$this->noticias_gigpz=array();
		$this->noticiaId=array();
		$this->noticia_grabada=$noticia_grabada;
		$this->comentarios_de_noticias=array();
		$this->comentario_mostrar=array();
		$this->ultima_noticia=array();
		$this->mi_ultima_not=array();
		//$this->ultima=$ultima;

	}

	public function get_noticias($miembro)
	{
		// noticias en gips mias y amigos
		parent::con();
		//$this->con();
		$miembro=htmlspecialchars($miembro);
	  	$n_noticias=sprintf
	  	(
	  		$n_noticias="select web_miembro.id_web,web_miembro.id_miembro,miembros.id_miembro,miembros.nombres,amistad.id_amigo,amistad.id_miembro,amigos.id_amigo,amigos.avatar,amigos.email,noticias_gipz.* from web_miembro inner join miembros on web_miembro.id_miembro=miembros.id_miembro inner join amistad on miembros.id_miembro=amistad.id_miembro inner join amigos on amistad.id_amigo=amigos.id_amigo inner join noticias_gipz on amigos.id_amigo= noticias_gipz.id_miembro where noticias_gipz.estado=1 and miembros.id_miembro=%s and noticias_gipz.id_tipo_not between 1 and 2 order by noticias_gipz.id_noticia desc limit 10",
			parent::comillas_inteligentes($miembro)
	  	);
	   	$res=mysql_query($n_noticias);
	   	while($reg=mysql_fetch_assoc($res))
	   	{
			$this->noticias_gigpz[]=$reg;
		}
		return $this->noticias_gigpz;
	 	
	}
		
	public static function total_comentarios()
	{
		$sql="select count(*) as tot from coment_not_gipz";
		$res=mysql_query($sql,parent::con());
	 	if ($reg=mysql_fetch_array($res))
		 {
   			$total=$reg["tot"];
		 }
	    return $total;
		
	}

	public static function ultima_noticia_amistad($yo)
	{
		$yo=htmlspecialchars($yo);
		parent::con();
		$sql=sprintf
		(
			"select noticias_gipz.id_noticia,noticias_gipz.id_miembro,miembros.id_miembro,amistad.id_amigo,amistad.id_miembro,amigos.id_amigo from noticias_gipz inner join miembros on noticias_gipz.id_miembro=miembros.id_miembro inner join amistad on miembros.id_miembro=amistad.id_amigo inner join amigos on amistad.id_amigo=amigos.id_amigo where amistad.id_miembro=%s order by noticias_gipz.id_noticia desc limit 1",
			 parent::comillas_inteligentes($yo)

		);
		$res=mysql_query($sql);
	 	if($reg=mysql_fetch_array($res))
		 {
   			$ultima=$reg["id_noticia"];
		 }else
		 {
		 	$ultima='';
		 }
	    return $ultima;
	}

	public function grabar_noticia($responsable,$detalle)
	{

		/*parent::con();
		$sql=sprintf
		(
			"select nombres from miembros where id_miembro=%s",
			 parent::comillas_inteligentes($responsable)
		);
		
		$eje=mysql_query($sql);
		if ($resul=mysql_fetch_array($eje))
		{
			$nom_responsable=$resul["nombres"];

			parent::con();
			$sql_grabar=sprintf
			(
				"insert into noticias_gipz values(null,'".date("Y-m-d")."',
			'".date("H:i:s")."',%s,%s,%s,2,1)",
			parent::comillas_inteligentes($nom_responsable),
			parent::comillas_inteligentes($detalle),
			parent::comillas_inteligentes($responsable)
			);
		    $reg=mysql_query($sql_grabar);

			$id_not=mysql_insert_id();
			$this->noticia_grabada=$id_not;
			
			//$grabar_web="insert into not_web values($id_not,$responsable,1)";
			//mysql_query($grabar_web,Conectar::con());
		}*/
		
		$nom_responsable=htmlspecialchars($_SESSION["session_nombre"]);
		parent::con();
		$sql_grabar=sprintf
		(
				"insert into noticias_gipz values(null,'".date("Y-m-d")."',
			'".date("H:i:s")."',%s,%s,%s,2,1)",
			parent::comillas_inteligentes($nom_responsable),
			parent::comillas_inteligentes($detalle),
			parent::comillas_inteligentes($responsable)
		);
		$reg=mysql_query($sql_grabar);

		$id_not=mysql_insert_id();
		$this->noticia_grabada=$id_not;
		$grabar_web="insert into not_web values($id_not,$responsable,1)";
		mysql_query($grabar_web,parent::con());
		
	}
	public function mostrar_noticia($noticia)
	{
	   parent::con();
	   $Mi_noticia=sprintf
	   (
	   		"select id_noticia,fecha_noticia,hora_noticia,titulo_noticia,acontecimiento,id_miembro,id_tipo_not,amigos.avatar from noticias_gipz inner join amigos on noticias_gipz.id_miembro=amigos.id_amigo where id_noticia=%s",
			parent::comillas_inteligentes($noticia)		
	   );
	   $res=mysql_query($Mi_noticia);
	   if($reg=mysql_fetch_assoc($res))
		{
			//$this->total_comentarios=$reg["total_coment"];
			$this->noticiaId[]=$reg;
		}
		
		return $this->noticiaId;
	}
	public function get_comentarios_de_noticia($id)
	{
		$id=htmlspecialchars($id);
		parent::con();
		$consulta=sprintf
		(
		 	"select coment_not_gipz.*,amigos.avatar from coment_not_gipz inner join amigos on coment_not_gipz.id_amigo=amigos.id_amigo where id_noticia=%s order by id_comentario asc limit 0,7",
		 	parent::comillas_inteligentes($id)
		);
		$res=mysql_query($consulta);
		$rpt=mysql_num_rows($res);
		if($rpt==0)
		{
			return "0";
		}
		elseif($rpt>0)
		{	 
			unset($this->comentarios_de_noticias);
			while($reg=mysql_fetch_assoc($res))
			{
				$this->comentarios_de_noticias[]=$reg;
			}		 
			return $this->comentarios_de_noticias;	 
	 	}
	}
	public function grabar_comentario()
	{
		
			$id_noticia=htmlspecialchars($_GET["id_resp"]);
			$id_amigo=htmlspecialchars($_GET["id_amigo"]);
			$comentario=htmlspecialchars($_GET["comentario"]);
			parent::con();

			$grabar=sprintf
			(
				"insert into coment_not_gipz values(null,%s,%s,%s,now(),now())",
				parent::comillas_inteligentes($id_noticia),
				parent::comillas_inteligentes($id_amigo),
				parent::comillas_inteligentes($comentario)
			);
		  	mysql_query($grabar);
		  	//echo "Datos Guardados Correctamente";
		 
		 	/*$sql_noticia="insert into noticias_gipz values(null,'".date("Y-m-d")."',
		 	'".date("H:i:s")."','Dice:','$detalle','".$_GET["id_amigo"]."',2,1)";
	     	$reg=mysql_query($sql_noticia,Conectar::con());*/
	    
	}
	public function mostrar_comentario($id_coment)
	{
		$id_noticia=htmlspecialchars($_GET["id_resp"]);
		parent::con();
		$consulta=sprintf
		(
			"select coment_not_gipz.*,amigos.avatar from coment_not_gipz inner join amigos on coment_not_gipz.id_amigo=amigos.id_amigo where id_noticia=%s and id_comentario=%s order by id_comentario asc",
			parent::comillas_inteligentes($id_noticia),
			parent::comillas_inteligentes($id_coment)
		);

		 $res=mysql_query($consulta);
		 if($reg=mysql_fetch_assoc($res))
	 	{
			$this->comentario_mostrar[]=$reg;
		}		 
	 	return $this->comentario_mostrar;
	}

	public function ultima_noticia_miembro($miembro)
	{	
		$miembro=htmlspecialchars($miembro);
		parent::con();
		$sql=sprintf
		(
			"select miembros.id_miembro,miembros.nombres,amistad.id_amigo,amistad.id_miembro,amigos.id_amigo,amigos.avatar,amigos.email,noticias_gipz.* from miembros inner join amistad on miembros.id_miembro=amistad.id_miembro inner join amigos on amistad.id_amigo=amigos.id_amigo inner join noticias_gipz on amigos.id_amigo= noticias_gipz.id_miembro where amistad.id_miembro=%s and noticias_gipz.id_miembro<>%s and noticias_gipz.id_tipo_not between 1 and 2 order by noticias_gipz.id_noticia desc limit 1",
			parent::comillas_inteligentes($miembro),
			parent::comillas_inteligentes($miembro)
		);
		$result=mysql_query($sql);
		if($reg=mysql_fetch_assoc($result))
		{
			$this->ultima_noticia[]=$reg;
			
		}
		return $this->ultima_noticia;

	}
	public function mi_ultima_noticia($id)
	{
		$mid=htmlspecialchars($id);
		parent::con();
		$sql=sprintf
		(
			"select noticias_gipz.id_noticia,noticias_gipz.titulo_noticia,noticias_gipz.fecha_noticia,noticias_gipz.hora_noticia,noticias_gipz.acontecimiento,noticias_gipz.id_miembro,noticias_gipz.estado,amigos.id_amigo,amigos.avatar from noticias_gipz inner join amigos on noticias_gipz.id_miembro=amigos.id_amigo where id_miembro=%s order by id_noticia desc limit 1",
			parent::comillas_inteligentes($mid)
		);
		$res=mysql_query($sql);
		if ($reg=mysql_fetch_assoc($res)) {
			$this->mi_ultima_not[]=$reg;
		}
		return $this->mi_ultima_not;
	}
	public function eliminar_noticia($id_n,$id_p)
	{
		$sql="update not_web set visible=0 where id_noticia=$id_n and id_web=$id_p";
		$reg=mysql_query($sql,parent::con());
		if(mysql_affected_rows()==0)
		{
			$grabar="insert into not_web values($id_n,$id_p,0)";
			//$sql_web="update not_web set visible=0 where id_noticia=$id";
			$reg_grabar=mysql_query($grabar,parent::con());
		}
	}

	public static function filtrar_noticia($web,$id_noticia)
	{
		parent::con();
		$sql=sprintf
		(
			"select id_web,id_noticia,visible from not_web where id_noticia=%s",
			parent::comillas_inteligentes($id_noticia)
		);
		$reg=mysql_query($sql);
		$cuantos=mysql_num_rows($reg);

		if($cuantos==1)
		{
			if($res=mysql_fetch_array($reg))
			{
				if($res["id_web"]==$web && $res["visible"]==1)
				{
					return true;
				}
				if($res["id_web"]!=$web && $res["visible"]==1)
				{
					return true;
				}
				if($res["id_web"]!=$web && $res["visible"]==0)
				{
					return true;
				}
				if($res["id_web"]==$web && $res["visible"]==0)
				{
					return false;
				}
		
			}else{
				return false;
			}
		}
		if ($cuantos>1) {
			parent::con();
			$sql=sprintf
			(
				"select id_web,id_noticia,visible from not_web where id_noticia=%s and id_web=%s",
				 parent::comillas_inteligentes($id_noticia),
				 parent::comillas_inteligentes($web)
			);
			$reg=mysql_query($sql);
			if($res=mysql_fetch_array($reg))
			{
				if($res["visible"]==1)
				{
					return true;
				}else{
					return false;
				}	
			}
		}
		
	}

//select foto from fotos where id_album=$album order by id_foto desc limit $pos,1;
}

?>