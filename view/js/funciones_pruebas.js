function reiniciar()
{
	//var mitxt=miform.getElementsByTagName("input");
	//mitxt[0].focus();	
}
function prueba()
{
	alert('funka');

}

function eliminar(url)
{
	if (confirm("realmente desea eliminar este registro ?")) 
	{
		window.location=url;

	};
}

function limpiar()
{
	var form=document.form_evento;
	form.reset();
	form.titulo.focus();
}

function validar()
{
	//alert('la funcion validar');
	var form=document.form_evento;
	if (form.titulo.value==0)
	{
		alert('Debe ingresar Titulo');
		form.titulo.value="";
		form.titulo.focus();
		return false;
	};
	if (form.descrip.value==0)
	{
		alert('Debe ingresar la descripcion');
		form.descrip.value="";
		form.descrip.focus();
		return false;
	};
	if (form.inicio.value==0)
	{
		alert('Debe ingresar el inicio');
		form.inicio.value="";
		form.inicio.focus();
		return false;
	};
	if (form.termino.value==0)
	{
		alert('Debe ingresar el termino');
		form.termino.value="";
		form.termino.focus();
		return false;
	};
	form.submit();

}
function limpiar_frm(frm)
{
	miform=document.getElementById(frm);
	miform.reset();
	var mitxt=miform.getElementsByTagName("input");
	mitxt[0].focus();
}

function validar_envio(elemento,msj)
{
		document.getElementById(elemento).innerHTML=msj;
		document.getElementById(elemento).style.color="red";
		document.getElementById(elemento).style.display="block";
		
}

function enviar_carreo()
{
	
	var form=document.frm_contacto;
	if(form.txt_nombre.value==0){
		validar_envio('rpt_envio','Debe ingresar su nombre');
		form.txt_nombre.value="";
		form.txt_nombre.focus();
		return false;
	}
	if(form.txt_email.value==0){
		validar_envio('rpt_envio','Debe ingresar el E-mail');
		form.txt_email.value="";
		form.txt_email.focus();
		return false;
	}
	
	if(valida_correo(form.txt_email.value)==false)
	{
		validar_envio('rpt_envio','Debe ingresar un E-mail valido');
		form.txt_email.value="";
		form.txt_email.focus();
		return false;
	}

	if(form.txta_mensaje.value==0){
		validar_envio('rpt_envio','Debe ingresar el Mensaje');
		form.txta_mensaje.value="";
		form.txta_mensaje.focus();
		return false;
	}
	if(form.txt_imagen.value==0){
		validar_envio('rpt_envio','Debe ingresar texto de la imagen');
		form.txt_imagen.value="";
		form.txt_imagen.focus();
		return false;
	}
	validar_envio("rpt_envio","<font style='color:orange'>Tus Datos Estan Siendo Procesados...</font>");
	form.submit();
	limpiar_frm('frm_contacto');

}

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

