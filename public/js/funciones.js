// JavaScript Document
//////////////////////////////////DECLARACIONES/////////////////////////////////////
var _elementoError='rpt_registro';

///////////nuevaNoticia
var Nid=0;
var nVeces=0;
//////////////////////
///gigpz_ajaxGet
var Ndiv;
var Nv=0;
var Nv2=0;
////////////////

//////////////////nuevocomentario
var NidComen=0;
var nVe=0;

///////////////////nuevo comentario foto
var NidCfoto=0;
var nVeCfoto=0;

///////////////hizo enter
var swEnter=0;

////////////// funcion el evento de addcampo
var numero=0;

/////////////funcion elegido
var id_elegido;
var posicion;
var conteo;
///////////////////// para uploadify
var swIdAlbum=0;

//////////////para draggable
var id_NoticiaX=0;
var id_div=0;
//////////// crearAlbum ->>>funcion creadora de Elementos ////////////////////////
var swAlbum=0;
//2 var div_album=document.createElement("div");
//3 var div_album=document.getElementById('crear_album');
var span_contenido=document.createElement("span");
var hr_separador=document.createElement("hr");
var frm_album=document.createElement("form");

var txtNombre=document.createElement("input");
var lblNombre=document.createElement("label");
var var_br=document.createElement("br");
var btn_subir=document.createElement("a");
var div_adjuntos=document.createElement("div");
var nfotos=document.createElement("input");
var btn_grabar=document.createElement("input");
var btn_oculto=document.createElement("input");

//fileImagen:false,
var texto_span=document.createTextNode("Individual (Recomendado)");
span_contenido.appendChild(texto_span);

frm_album.setAttribute('name','frmupload_fotos');
frm_album.setAttribute('enctype','multipart/form-data');
frm_album.setAttribute('method','post');
frm_album.setAttribute('action','?accion=upload_fotos');

	txtNombre.setAttribute('type','text');
	txtNombre.setAttribute('id','txt_nombre');
	txtNombre.setAttribute('name','txt_nombre');

	lblNombre.setAttribute('for','txt_nombre');
	lblNombre.innerHTML="Nombre del Album: ";

	div_adjuntos.setAttribute('id','adjuntos');
	//<input type="file" name="fotos[]" id="fotos[]" />
		nfotos.setAttribute('type','file');
		nfotos.setAttribute('name','fotos[]');
		nfotos.setAttribute('id','fotos[]');
		nfotos.onclick=function()
		{
			//alert('hizo click');
		}
	div_adjuntos.appendChild(nfotos);

	btn_subir.setAttribute('href','javascript:void(0)');
	btn_subir.setAttribute('id','btn_subir');
	btn_subir.setAttribute('name','btn_Subir');

	var textop=document.createTextNode("subir otro Foto");

	//gigpz.textoArea.onkeyup=function(elevento)
	btn_subir.onclick=function(evt)
	{
		//alert('funka este boton');
		addcampo();
	}
	btn_subir.appendChild(textop);

	btn_grabar.setAttribute('type','button');
	btn_grabar.setAttribute('id','btn_grabar');
	btn_grabar.setAttribute('name','btn_grabar');
	btn_grabar.setAttribute('value','Grabar');
	btn_grabar.onclick=function()
	{
		//alert('aki se graban los datos');
		//document.frmupload_fotos.submit();
		valida_upload();
	}
	
	btn_oculto.setAttribute('type','hidden');
	btn_oculto.setAttribute('name','grabar');
	btn_oculto.setAttribute('value','si');
	
	

//1 div_album.setAttribute('id','crear_album');

////////////////////////////////////////////////
/*<form name="frmupload_fotos" enctype="multipart/form-data" method="post" action="upload_fotos.php">
        <label for="nombre_album">Nombre del Album</label>
        <input type="text" name="nombre_album" id="nombre_album" value=""/>
        <br />
        <div id="adjuntos">
        <input type="file" name="fotos[]" id="fotos[]" />
    	</div>
        <a href="javascript:void(0);" onclick="addcampo()">Subir otra foto</a>
        <br />
        <input type="button" name="btngrabar" value="Grabar"  onclick="valida_upload();"/><input type="hidden" name="grabar" value="si" /><input type="hidden" name="idm" id="idm" value="<?php echo $id;?>" />!!
        <input type="button" name="btnvolver" value="Volver"  onclick="javascript:window.location='home.php'"/>
	</form>*/

////////////////////////////////////////////////
function elegido(idelemento,npos)
{
	//alert(idelemento+" "+npos);
	id_elegido=idelemento;
	posicion=npos;
	conteo=0;
	//alert('posicion '+npos+' id foto '+idelemento);
	return id_elegido;

}
function mostrar_foto(pag,miembro,album,id_foto,tot,xfoto,pos)
{
	//alert('foto mostrada '+id_foto);
	$(document.body).addClass("mi_body");
	$("#sombra").addClass("sombraLoad");
	$("#sombra").show();

	$("#v_modal").removeClass("windowUnload");
	$("#v_modal").addClass("windowLoad");
	$("#v_modal").show();
	$("#mostrar_foto").html('<h3>Cargando...</h3>');

	$.ajax({
		  	url:'controller/mostrar_fotoController.php',
		  	type:"GET",
		  	data:"idm="+miembro+"&alb="+album+"&id_f="+id_foto+"&vfoto="+xfoto+"&xtot="+tot+"&posi="+pos,
		  	cache: false,
		  	//dataType:"json",
		  	success:function(rpt)
		  	{
		  		//alert(rpt);
		  		//document.getElementById("v_modal").innerHTML=rpt;
		  		$("#mostrar_foto").html(rpt);

		  	}
		 }).done(function( obj ) {
		  		//alert( "datos Recibidos: ");
		  					
		 });
}

function navegar_fotos(miembro,pos,orden,tot)
{
	posicion=pos;
	var ntot=tot-1;
	if (orden=='prev') 
		{
			--posicion;
			--conteo;
								
		}
	if (orden=='next') 
		{
			++posicion;
			++conteo;
			
		}

	if (posicion<0)
		{
			posicion=0;
			return false;
		};
	if (posicion>ntot) 
		{
			posicion=ntot;
			return false;
		};

	$.ajax({
			url:'controller/navegar_fotoController.php',
			type:'POST',
			data:'idm='+miembro+'&xpos='+posicion+"&tot_f="+tot,
			cache:false,
			success:function(vrpt)
			{
				$("#mostrar_foto").html(vrpt);
			}
	});
	
}

function probar()
{
	alert('funka');
}
evento=function(evt){
	
	return(!evt)?event:evt;
}

addcampo=function()
{
	ndiv=document.createElement("div");
	//ndiv.className="fotos";
	ndiv.id='file'+(++numero);
	
	  ncampo=document.createElement("input");
	  ncampo.name='fotos[]';
	  ncampo.type='file';
	  
	  a=document.createElement("a");
	  a.name=ndiv.id;
	  a.href='#';
	  
	  a.onclick=elimcamp;
	  a.innerHTML='Cancelar';
	  
	  //INTEGRANDO//
	  ndiv.appendChild(ncampo);
	  ndiv.appendChild(a);
	 
	container=document.getElementById("adjuntos");
	container.appendChild(ndiv);
	  
	
}

elimcamp=function(evt)
{
  evt=evento(evt);
  ncampo=rObj(evt);
  div=document.getElementById(ncampo.name);
  div.parentNode.removeChild(div);
  
}

rObj=function(evt)
{
	return evt.srcElement? evt.srcElement:evt.target;		
}

function valida_upload(){
	var form=document.frmupload_fotos;
	if(form.txt_nombre.value.length==0)
	{
		form.txt_nombre.value="";
		form.txt_nombre.focus();
		return false;
	}		
	form.submit();	
}
///////////////////////////////////////////////////////////////////////////////////
function valida_correo(correo) 
{
		  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(correo))
		  {
			
		   return (true)
		  } 
		  else 
		  {
		   
		   return (false);
		  }
}
function escribio(valor,div)
{
	//alert("funciona");
	if(valor!="")
	{
  	 document.getElementById(div).style.display="none";
	}
	
}
function validar_error(elemento,msj)
{
		document.getElementById(elemento).innerHTML=msj;
		document.getElementById(elemento).style.display="block";
		document.getElementById(elemento).style.color="red";
}
function validaregistro()
{
  var form=document.form_registro;
	if(form.nombre.value==0){
		validar_error(_elementoError,'Debe ingresar su Nombre');

		form.nombre.value="";
		form.nombre.focus();
		return false;
		}
	if(form.apellido.value==0){
		validar_error(_elementoError,'Debe ingresar su apellido');

		form.apellido.value="";
		form.apellido.focus();
		return false;
		}
	if(form.email.value==0){
		validar_error(_elementoError,'Debe ingresar su email');

		form.email.value="";
		form.email.focus();
		return false;
		}
		
	///////////////////////////////////////	
	if (valida_correo(form.email.value)==false)
	{
		validar_error(_elementoError,'el Email ingresado no es Correcto o Valido');

		form.email.value="";
		form.email.focus();
		return false;
	}
	///////////////////////////////////////////////
	if(form.pass.value==0){
		
		validar_error(_elementoError,'Debe ingresar el password');

		form.pass.value="";
		form.pass.focus();
		return false;
		}
	if(form.repass.value==0 || form.repass.value!=form.pass.value){
		
		validar_error(_elementoError,'Los password no coinciden o no son validos');

		form.repass.value="";
		form.repass.focus();
		return false;
		}
	if(form.sexo.value=="Seleccione el Sexo"){
		
		validar_error(_elementoError,'Debe de seleccionar tu sexo');

		form.sexo.value="";
		form.sexo.focus();
		return false;
		}
		
	if(form.cbo_dias.value=="dia"){
		
		validar_error(_elementoError,'Debe de seleccionar un dia valido');

		form.cbo_dias.value="";
		form.cbo_dias.focus();
		return false;
		}
	if(form.cbo_meses.value=="mes"){
		
		validar_error(_elementoError,'Debe de seleccionar un mes valido');

		form.cbo_meses.value="";
		form.cbo_meses.focus();
		return false;
		}
	if(form.cbo_anos.value=="ano"){
		
		validar_error(_elementoError,'Debe de seleccionar un año valido');

		form.cbo_anos.value="";
		form.cbo_anos.focus();
		return false;
		}
	 form.repass.value=calcMD5(form.repass.value);
	 form.pass.value=calcMD5(form.pass.value);
	 form.submit();
 }
 
function validalogueo()
{
	var form=document.form_ingreso;
    if (form.nom_miembro.value.length >0 && form.pass_miembro.value.length>0)
	{
		//alert('se envio');return false;
			//form.nom_usuario.value=htmlSpecialChars
		form.pass_miembro.value=calcMD5(form.pass_miembro.value);
		form.submit();
	}else
	{
		//alert('No se ha Enviado');
	}
}

function enter(elevento,funx)
{
  //alert('funcion enter');
  var evento=elevento || window.event; 
  if(evento.keyCode==13 && evento.type=="keyup")
  {
	 
	 swEnter=1;
	 //alert('Enviado Enter '+swEnter);
	 if (funx==1) 
	 	{
	 		validalogueo();
	 	};

	 }else{
	 swEnter=0;
  }                
}

/////////////////////////////////////////////////////////////////////////////////7
function eliminar(url)
{
	//alert("Funciona...");
	if(confirm("realmente desea eliminar este registro ?"))
	{
		window.location=url;
	}
}
function limpiar_form(frm,txt)
{
	//document.form_add.reset();
	document.getElementById(frm).reset();
	document.getElementById(txt).focus();
	//document.forms[0].elements[0]
	//document.form_add.nom.focus();
}
///////////////////////////////////////////////////////////////////////////////////////
function ocultar_ventana()
{			

			$("#v_modal").removeClass("windowLoad");
			$("#v_modal").addClass("windowUnlooad");
			$("#v_modal").hide();

  			$(document.body).removeClass("mi_body");
  			$("#sombra").removeClass("sombraLoad");

  			$("#crear_album").hide();
  			swAlbum=0;
  			div_album.innerHTML="";
  			div_album.parentNode.removeChild(div_album);

			$("#sombra").addClass("sombraUnload");
			$("#sombra").hide();

			//document.getElementById('sombra').className='sombraUnload';
			//document.getElementById('v_modal').className='windowUnload';
			//document.getElementById('mi_marco').src="";

			//$("#sombra").removeClass("sombraLoad");

			//$("#sombra").addClass("sombraUnload");
			//$("#sombra").hide();

			//$("#v_modal").hide();
}

function eliminar_noticia(id_elemento,id_noticia,id_pro)
{
	//alert(id_elemento+' '+id_noticia+' '+id_pro);
	var xdiv=document.getElementById(id_elemento);
  	xdiv.parentNode.removeChild(xdiv);

  	$.ajax({
  		url:'controller/eliminar_noticiaController.php',
  		type:'post',
  		data:'id_n='+id_noticia+'&id_p='+id_pro,
  		cache:false,
  		success:function(vrpt)
  		{
  			alert(vrpt);
  		}
  	});
  	
}

///////////////////////////////MIS FUNCIONES AJAX///////////////////////////////////////7
function getXMLHTTPRequest()
{
 var req=false;
 try {
 	//req=new XMLHTTPRequest();
	req = new XMLHttpRequest(); 
 }
 catch(err1)
 {
	try
	{
	 req= new ActiveXObject('Msxml2.XMLHTTP');
	 //req = new ActiveXObject('MSXML2.XMLHTTP'); // IE
	}
 catch(err2)
 {
	try
	{
	 req= new ActiveXObject('Microsoft.XMLHTTP');
    }
 catch(err3)
  {
    req= false;
  }
 }
 }
 return req;	
}
var httpgigpz = getXMLHTTPRequest();

function gigpz_ajaxGet(div,pag,id_not,coment,btnId,resp,ultima)
{	
	//gigpz_ajaxGet(<?php echo $total_noticia; ?>,'?accion=grabar_noticia',<?php echo $id_miembro; ?>,frm_ideas.txtideas.value,'a',<?php echo $id_miembro;?>,<?php echo $ultima_noticia;?>);
   //alert(id_not+" "+div+" "+pag+" "+coment+" "+btnId+" "+resp+" "+ultima);return false;
   if(coment.length>0)
   {
   		var mi_aleatorio=parseInt(Math.random()*99999999);
   		if(btnId=="a"){
		  	Nv=Nv+1;
  			//Ndiv="datos_noticias"+(div+Nv);
  			Ndiv="datos_noticias"+Nid;
  		}else if(btnId=="b"){
   			Nv2=Nv2+1;
   			Ndiv="comentGeneradoD"+(div+Nv2);
  		}else if(btnId=="c")
  		{
			Ndiv=div;
  		}
  		//var vinculo=pag+"?id_noticia="+id+"&rand="+mi_aleatorio;
  		//var id_p=pusher.connection.socket_id;   -->>+"&socket_id="+id_p
  		var vinculo=pag+"&id_resp="+id_not+"&id_amigo="+resp+"&comentario="+coment+"&rand="+mi_aleatorio;
  		//alert(vinculo);return false;
   		httpgigpz.open("GET",vinculo,true); //true para q la peticion sea asincrona..
   		//httpgips.setRequestHeader("Content-Type", "text/javascript");  //"application/x-www-form-urlencoded" "text/javascript"
   		function respuestaHttp()
   		{
	   	if(httpgigpz.readyState==4)
	   	{
		   if(httpgigpz.status==200)
		   {
		  	   var httpOptenida=httpgigpz.responseText;
			   document.getElementById(Ndiv).innerHTML=httpOptenida;
			   Ndiv=null;
			   //gigpz.enviar_peticion(coment,resp,ultima);
			   //gigpz.enviar_peticion($('#txtideas').val(),<?php echo $id_miembro;?>,<?php echo $ultima_noticia;?>);
			   				  
			}
	   	}else{
		   //document.getElementById(div).innerHTML="Cargando...";
		   document.getElementById(Ndiv).innerHTML="<img src='public/img/preloadgigpz.gif' title='Cargando...' width='39px' height='15px'>";
		   
		}
	}

	httpgigpz.onreadystatechange=respuestaHttp; //OTRO METODO
    httpgigpz.send(null); //OTRO METODO	
 }  
}
 
function gigpz_ajax(id,div,pag)
{
   if (id.length>0) 
   	{
   	   //valida_correo(form.email.value)
   		//alert(id+" "+div+" "+pag);return false;
	   var mi_aleatorio=parseInt(Math.random()*99999999);
	   var vinculo=pag+"?rand="+mi_aleatorio+"&id_valor="+id;
	   //alert(vinculo);return false;
	   
	   httpgigpz.open("POST",vinculo,true); //true para q la peticion sea asincrona..
	   httpgigpz.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  //"application/x-www-form-urlencoded" "text/javascript"
	   httpgigpz.send(vinculo);
	   function respuestaHttp(){
		   if(httpgigpz.readyState==4)
		   {
			   if(httpgigpz.status==200){
			  	   var httpOptenida=httpgigpz.responseText;
			  	   //document.getElementById(div).style.display="block";
			  	   $('#rpt_registro').toggle();
				   document.getElementById(div).innerHTML=httpOptenida;
				   div=null;
					  
			 	}
		   }else{
		   		//document.getElementById(div).style.display="block";
		   		$('#rpt_registro').toggle();
			    document.getElementById(div).innerHTML="Cargando...";
			}
		  
		  
		}
		httpgigpz.onreadystatechange=respuestaHttp; //OTRO METODO
	    httpgigpz.send(null); //OTRO METODO
    }
}

function nuevaNoticia(id,texto)
{

 //alert(id);return false;
 if (texto.length>0)
 	{
	 nVeces=nVeces+1;
	 Nid=id+nVeces;
	 var divNoticias=document.createElement("div");
	 var contenidoDiv=document.createTextNode("Cargando...!");
	 divNoticias.id="datos_noticias"+Nid;
	 divNoticias.className="noticias draggable";

	 //divNoticias.className="noticias draggable";
	 divNoticias.appendChild(contenidoDiv);
	 
	 if (nVeces>1){
			var dVeces=nVeces-1;
			var divId=document.getElementById("datos_noticias"+(id+dVeces));
			document.getElementById("bloke_noticias").insertBefore(divNoticias,divId);
			}else if(nVeces==1){
			//var xdiv=document.getElementById("datos_noticias0");
			var xdiv=document.getElementById("datos_noticias");
			document.getElementById('bloke_noticias').insertBefore(divNoticias,xdiv);
		}

		$(function() {
			$( "#datos_noticias"+Nid).draggable({ 
				revert: true,
				scroll:true,
				zIndex:2700,
				start: function(event, ui) {
					//id_NoticiaX=<?php echo $noticias[$i]["id_noticia"];?>;
					id_div=Nid;
				}

			});
		});
		/*new Draggable('datos_noticias'+Nid,
						{revert: true,
						 zindex:999,
						 onStart:function()
						 {
							//id_Noticia=;
						 }
						});
		*/
 	}	
}

function nuevoComentario(id,lugar)
{
	nVe=nVe+1;
	NidComen=id+nVe;
	
	var divComentario=document.createElement("div");
	var divSeparador=document.createElement("div");
	//var contenidoDiv=document.createTextNode("Este es un Texto de Prueba"+NidComen);
	divComentario.id="comentGeneradoD"+NidComen;
	divComentario.className="comentarios_grabados";
	//divComentario.appendChild(contenidoDiv);
	divSeparador.className="formatoInternoSeparador";
	//lugar=resultado_de_comentarios$x donde se mostrar o agregara
	document.getElementById(lugar).appendChild(divComentario);
	document.getElementById(lugar).appendChild(divSeparador);
}

function nuevo_comentario_foto(ultimo_id,pag,id_foto,coment,btnId,resp)
{
	if(swEnter==1)
	{
		//alert(ultimo_id+' '+pag+' '+id_foto+' '+coment+' '+btnId+' '+resp);
		if (coment.length>1)
			{
				nVeCfoto=nVeCfoto+1;
				NidCfoto=ultimo_id+nVeCfoto;

				var divComentarioFoto=document.createElement("div");
				divComentarioFoto.id="comentFoto"+NidCfoto;
				divComentarioFoto.className="";

				document.getElementById("bloke_comentarios_foto").appendChild(divComentarioFoto);
				var idc=divComentarioFoto.id;
				gigpz_ajaxGet(idc,pag,id_foto,coment,btnId,resp);

				swEnter=0;
			};

	}
}

var gigpz={
	
			valor:'Funciona',
			comentador:false,
			miForm: false,
			textoArea:false,
			vTexto:false,
			btn_a:false,
			///////////////
			conexiones:0,
			timestamp: 0,
  			url: 'controller/backendController.php',
  			noerror: true,
  			id_ultima:0,

  			mifuncion:function(){
				//alert(this.valor+' con el this');
				alert(gigpz.valor+ 'con gigpz');
			},

  			inicializar:function(){},

  			manejador_respuesta:function(rpt)
  			{				
  				//alert('manejador ha sido llamado');
  				if (rpt["msg"]!='')
  					{
  						var msgN=rpt["msg"];

  						nuevaNoticia(10,msgN);
  						//alert(Nid);
  						//$('#chat').append('<br />'+rpt["msg"]);
  						document.getElementById("datos_noticias"+Nid).innerHTML=rpt["msg"];
  					}
  				
  			},

  			conectar:function(id_m,ultima_noti)
  			{		
  					//alert("conectar");
  					gigpz.conexiones++;
  					if (gigpz.conexiones>1)
  						{
  							var misDatos='timestamp='+gigpz.timestamp+"&id_miembro="+id_m+"&ultima_noticia="+gigpz.id_ultima;
  						}else{
  							var misDatos='timestamp='+gigpz.timestamp+"&id_miembro="+id_m+"&ultima_noticia="+ultima_noti;
  						}
  					//data:'timestamp='+gigpz.timestamp+"&id_miembro="+id_m+"&ultima_noticia="+gigpz.id_ultima,

  					this.gigpz_ajax=$.ajax({
  					url:gigpz.url,
  					type:"GET",
  					data:misDatos,
  					cache: false,
  					dataType:"json",
  					success:function(datos){
  						//alert(datos.codigo);
  						var respuesta=datos;
  						gigpz.timestamp=respuesta["timestamp"];
  						gigpz.id_ultima=respuesta["id_ultima"];
  						//alert(this.timestamp);
  						gigpz.manejador_respuesta(respuesta);
  						gigpz.noerror=true;
  					}
  					/*complete:function(datos){
  						if (!this.noerror)
  							{
  								setTimeout(function(){ this.conectar() }, 5000); 
  							};
  							}else{
  								gigpz.conectar();
  								gigpz.noerror=false;
  								
  							}*/

  					}).done(function( msg ) {
  						
  						if (!gigpz.noerror)
  							{
  								setTimeout(function(){ gigpz.conectar(id_m,ultima_noti) }, 5000); 
  							}else{
  								setTimeout(function(){ gigpz.conectar(id_m,ultima_noti); gigpz.noerror=false; }, 5000); 
  								//gigpz.conectar(id_m,ultima_noti);
  								//gigpz.noerror=false;
  							}
  					});
  					//this.gigpz_ajax.comet = this;
  				//.done(function( msg ) {alert( "Data Saved: ");});					
  				
  				/*
  			   var cod='codigo='+texto;	
  			   $.ajax({
			   url:'pruebaJquery.php',
			   data:cod,
			   type:"POST",
			   //dataType:"json",
			   success:function(respuesta){
							alert(respuesta);
							}
		   
		   		});
				*/

  			},

  			desconectar:function(){},

  			enviar_peticion:function(peticion,id_m,ultima_noti,btnId,tot_noti)
  			{
  				//data: "name=John&location=Boston"
  				//gigpz_ajaxGet(div,pag,id_not,coment,btnId,resp,ultima)
  				/////////////////////////////////////////////////////////
  				//gigpz_ajaxGet(<?php echo $total_noticia; ?>,'?accion=grabar_noticia',<?php echo $id_miembro; ?>,frm_ideas.txtideas.value,'a',<?php echo $id_miembro;?>,<?php echo $ultima_noticia;?>);  				
  				 //alert(id_not+" "+div+" "+pag+" "+coment+" "+btnId+" "+resp);return false;
				  //alert(peticion+' '+id_m+' '+ultima_noti+' '+btnId+' '+tot_noti); return false;
				  if(peticion.length>0)
				   {
				   		//var mi_aleatorio=parseInt(Math.random()*99999999);
				   		if(btnId=="a"){
						  	Nv=Nv+1;
				  			//Ndiv="datos_noticias"+(div+Nv);
				  			Ndiv="datos_noticias"+Nid;
				  		}else if(btnId=="b"){
				   			Nv2=Nv2+1;
				   			Ndiv="comentGeneradoD"+(div+Nv2);
				  		}else if(btnId=="c")
				  		{
							Ndiv=div;
				  		}
				  		//var vinculo=pag+"?id_noticia="+id+"&rand="+mi_aleatorio;
				  		//var id_p=pusher.connection.socket_id;   -->>+"&socket_id="+id_p

				  		////////////////////////////////////////////////////////
		  				//alert("datos enviados "+peticion+' '+id_m+' '+ultima_noti);
		  				gigpz.conexiones++;
  						if (gigpz.conexiones>1)
  						{
  							var misDatos="msg="+peticion+"&id_miembro="+id_m+"&ultima_noticia="+gigpz.id_ultima;
  						}else{
  							var misDatos="msg="+peticion+"&id_miembro="+id_m+"&ultima_noticia="+ultima_noti;
  						}
  						

		  				$.ajax({
		  					url:gigpz.url,
		  					type:"GET",
		  					data:misDatos,
		  					cache: false,
		  					dataType:"json",
		  					success:function()
		  					{
		  						////////////
		  					}
		  				}).done(function( obj ) {
		  					//alert( "datos Recibidos: ");
		  					gigpz_ajaxGet(tot_noti,'?accion=grabar_noticia',id_m,peticion,btnId,id_m,ultima_noti);
		  				});
		  				//this.conectar();

		  				/*
				  		var vinculo=pag+"&id_resp="+id_not+"&id_amigo="+resp+"&comentario="+coment+"&rand="+mi_aleatorio;
				  		//alert(vinculo);return false;
				   		httpgigpz.open("GET",vinculo,true); //true para q la peticion sea asincrona..
				   		//httpgips.setRequestHeader("Content-Type", "text/javascript");  //"application/x-www-form-urlencoded" "text/javascript"
				   		function respuestaHttp()
				   		{
						   	if(httpgigpz.readyState==4)
						   	{
							   if(httpgigpz.status==200)
							   {
							  	   var httpOptenida=httpgigpz.responseText;
								   document.getElementById(Ndiv).innerHTML=httpOptenida;
								   Ndiv=null;
								   //gigpz.enviar_peticion(coment,resp,ultima);
								   //gigpz.enviar_peticion($('#txtideas').val(),<?php echo $id_miembro;?>,<?php echo $ultima_noticia;?>);
								   				  
								}
						   	}else{
						   	//document.getElementById(div).innerHTML="Cargando...";
						  	 document.getElementById(Ndiv).innerHTML="<img src='public/img/preloadgigpz.gif' title='Cargando...' width='39px' height='15px'>";
						 	}
						}

						httpgigpz.onreadystatechange=respuestaHttp; //OTRO METODO
				    	httpgigpz.send(null); //OTRO METODO	
						*/
					}
  			},
  			
  			///////////////////////////
  			crearAlbum:function()
  			{  				
  				if (swAlbum<1)
  				{		

  					$(document.body).addClass("mi_body");
					$("#sombra").addClass("sombraLoad");
					$("#sombra").show();

  					//4 document.getElementById("contenido_cuerpo").appendChild(div_album);
  					var div_album=document.getElementById('crear_album');
  					//textoCabecera=document.createTextNode("Subir Archivos");
  					//div_album.appendChild(textoCabecera);			
  					 					
  					frm_album.appendChild(div_adjuntos);
  					frm_album.appendChild(btn_subir);
  					frm_album.appendChild(var_br);
  					frm_album.appendChild(lblNombre);
  					frm_album.appendChild(txtNombre);
  					frm_album.appendChild(btn_grabar);
  					frm_album.appendChild(btn_oculto);

  					
  					//$('#crear_album').append('<hr /><span>Individual (Recomendado)</span>');
  					div_album.appendChild(span_contenido);
  					div_album.appendChild(hr_separador);
  					div_album.appendChild(frm_album);


  					$("#crear_album").toggle("slow");
  					swAlbum=1;
  				}
  			},
			
			crearComentador:function(id,totC,lugar,pag,id_not,btnId,resp)
			{
				//alert(id+" "+totC+" "+lugar+" "+pag+" "+id_not+" "+btnId+" "+resp);return false;
				//alert(id);
				if(!document.getElementById('div_comentador'+id))
				{
				   //alert('No existe el div con este Id');
				
				//alert('soy comentador'); return false;
				gigpz.comentador=document.createElement("div");
				gigpz.comentador.setAttribute('id','div_comentador'+id);
				//gigpz.comentador.className='comentador';
				//gigpz.texto=document.createTextNode("Este es un Texto de Prueba");
				//gigpz.comentador.appendChild(gigpz.texto);
					gigpz.miForm=document.createElement("form");
					gigpz.miForm.setAttribute('id','form'+id);
					gigpz.miForm.setAttribute('name','form'+id);
					
					gigpz.textoArea=document.createElement("textarea");
					gigpz.textoArea.setAttribute('id','txt_comentario'+id);
					gigpz.textoArea.setAttribute('name','txt_comentario'+id);
					gigpz.textoArea.setAttribute('cols','10');
					gigpz.textoArea.setAttribute('rows','1');
					gigpz.textoArea.className='formatoInternoText';
					gigpz.textoArea.onkeyup=function(elevento)
					{
						
						var evento=elevento || window.event;
  						if(evento.keyCode==13 && evento.type=="keyup")
  						{
	 						//alert("El enter");
	 						swEnter=1;
	 						if (swEnter==1)
	 						 {
	 						 	nuevoComentario(totC,lugar);
								gigpz_ajaxGet(totC,pag,id_not,gigpz.vTexto,btnId,resp);
								gigpz.comentador.parentNode.removeChild(gigpz.comentador);	
								swEnter=0;
	 						 }
  						}else{
	 						swEnter=0;
	  					}

						gigpz.vTexto=gigpz.textoArea.value;
						
					}
					
					gigpz.miForm.appendChild(gigpz.textoArea);
					
					//gigpz.btn_a=document.createElement("a");
					//gigpz.btn_a.setAttribute('id','btn_comentario'+id);
					//gigpz.btn_a.setAttribute('href','javascript:void(0)');
					//gigpz.btn_a.className='formatoInternoBoton';
					//gigpz.btn_a.onclick=function()
	   			    //{
							//alert('Funcion el onclick');

						//nuevoComentario(totC,lugar);
						//gigpz_ajaxGet(totC,pag,id_not,gigpz.vTexto,btnId,resp);
						//gigpz.comentador.parentNode.removeChild(gigpz.comentador);

							//div.parentNode.removeChild(div);
				     //}
					
					
					//var comen=document.createTextNode("Publicar");
					//gigpz.btn_a.appendChild(comen);
					//gigpz.miForm.appendChild(gigpz.btn_a);
				
				gigpz.comentador.appendChild(gigpz.miForm);
				//document.getElementById('noticias_cuerpo'+id).appendChild(gigpz.comentador);
				//alert('Se ejecuto'); comentarios_separador
				 var div_sepa=document.getElementById("noticias_separador"+id);
				 document.getElementById('noticias_cuerpo'+id).insertBefore(gigpz.comentador,div_sepa);
				
				}else if (document.getElementById('div_comentador'+id)){
					//alert('existe '+gigpz.comentador.id);
					gigpz.comentador.parentNode.removeChild(gigpz.comentador);
					return false;
				}
				
			},
			
			mostrar_coordenadas:function(evento)
			{
				//alert('esta es la funcion');
				//return false;
				
				var evt=evento || window.event;
				var coocx=evt.clientX;
				var coocy=evt.clientY;
				//alert('la posicion respecto a la ventana es: x='+coocx+' y='+coocy);
				//exit;
				var coosx=evt.screenX;
				var coosy=evt.screenY;
				//valida navegador//
				var ie=navigator.userAgent.toLowerCase().indexOf('msie')!=-1;
				if(ie)
					{
						coohx=evt.clientX+document.body.scrollLeft;
						coohy=evt.clientY+document.body.scrollTop;
					}else{
						coohx=evt.pageX;
						coohy=evt.pageY;
					}
				alert('la posicion respecto a la ventana es: x='+coocx+' y='+coocy);
				alert('la posicion respecto al documento completo es: x='+coohx+' y='+coohy);
				alert('la posicion respecto al la pantalla es: x='+coosx+' y='+coosy);

			},
			medida_pantalla:function()
			{
				//alert('Altura Total '+screen.height+' Anchura Total '+screen.width);
				alert('La Altura de la Ventana '+screen.availHeight+' La Anchura de la Ventana '+screen.availWidth);
				alert('La Altura en Windows '+window.outerHeight+' La Anchura en Windows '+window.outerWidth);
			}	

};