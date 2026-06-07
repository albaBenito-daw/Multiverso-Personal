/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
document.addEventListener('DOMContentLoaded', () => {
	'use strict';
	
	/*Variables globales de los elementos*/
	let contenedorCargaAjax,
		fondoFormulario,
		formularioInicioSesion,
		formularioRegistro,
		fondoAlerta,
		formularioAlerta,
		formularioCrearEvento,
		formularioEditarEvento,
		formularioGuardarImagen,
		formularioGuardarNota,
		formularioEditarNota;
		
	/*Variables globales*/
	let colorNormal = "#ffffff";
	let colorError = "#fae2df";
	let mesAgenda = 0;
	let anoAgenda = 0;

    /*Inicialización de elementos*/
    function inicializarElementos(){
        if(document.getElementById("contenedorCargaAjax") !== null){contenedorCargaAjax = document.getElementById("contenedorCargaAjax");}
		if(document.getElementById("fondoFormulario") !== null){fondoFormulario = document.getElementById("fondoFormulario");}
		if(document.getElementById("formularioInicioSesion") !== null){formularioInicioSesion = document.getElementById("formularioInicioSesion");}
		if(document.getElementById("formularioRegistro") !== null){formularioRegistro = document.getElementById("formularioRegistro");}
		if(document.getElementById("fondoAlerta") !== null){fondoAlerta = document.getElementById("fondoAlerta");}
		if(document.getElementById("formularioAlerta") !== null){formularioAlerta = document.getElementById("formularioAlerta");}
		if(document.getElementById("formularioCrearEvento") !== null){formularioCrearEvento = document.getElementById("formularioCrearEvento")};
		if(document.getElementById("formularioEditarEvento") !== null){formularioEditarEvento = document.getElementById("formularioEditarEvento")};
		if(document.getElementById("formularioGuardarImagen") !== null){formularioGuardarImagen = document.getElementById("formularioGuardarImagen")};
		if(document.getElementById("formularioGuardarNota") !== null){formularioGuardarNota = document.getElementById("formularioGuardarNota")};
		if(document.getElementById("formularioEditarNota") !== null){formularioEditarNota = document.getElementById("formularioEditarNota")};
	}

    /*Inicialización de eventos*/
    function inicializarEventos(){
		/*Evento que retorna al color original el input, select o textarea donde esté el foco*/
        delegadorEvento.on(document,"focusin","input,select,textarea",function(e){
			this.style.backgroundColor = colorNormal;
		});
		
		/*Evento que verifica si la sesión esta iniciada al intentar usar cada botón de la aplicación*/
		delegadorEvento.on(document,"click","#buttonsCont > button",function(e){
			let botonId = this.id;
			cargandoAjax(true);
			solicitudPost("./php/comprobarSesion.php", {}, function(data){
				let arrayDatos = JSON.parse(data);
				if(arrayDatos[0] == 1){
					switch(botonId){
						case "agenda":
							window.location.href = "./agenda";
							break;
						case "armario":
							window.location.href = "./armario";
							break;
						case "notas":
							window.location.href = "./notas";
							break;
						case "ajustes":
							window.location.href = "./ajustes";
							break;
						default:
							window.location.href = "./";
					}
				}
				else{
					document.getElementById("emailUsuario").value = "";
					document.getElementById("emailUsuario").style.backgroundColor = colorNormal;
					document.getElementById("contrasenaUsuario").value = "";
					document.getElementById("contrasenaUsuario").style.backgroundColor = colorNormal;
					mostrarFormulario(0);
				}
				cargandoAjax(false);
			},true);
		});
		
		/*Botón cancelar de los formularios*/
		delegadorEvento.on(document,"click",".cancelar",function(e){
			ocultarFormulario();
		});
		
		/*Dispara el formulario y borra registros anteriores escritos en él*/
		delegadorEvento.on(document,"click","#registrarUsuario",function(e){
			document.getElementById("nombreRegistro").value = "";
			document.getElementById("nombreRegistro").style.backgroundColor = colorNormal;
			document.getElementById("emailRegistro").value = "";
			document.getElementById("emailRegistro").style.backgroundColor = colorNormal;
			document.getElementById("contrasenaRegistro").value = "";
			document.getElementById("contrasenaRegistro").style.backgroundColor = colorNormal;
			document.getElementById("confirmarContrasenaRegistro").value = "";
			document.getElementById("confirmarContrasenaRegistro").style.backgroundColor = colorNormal;
			mostrarFormulario(1);
		});
		
		/*Validaciones de los datos introducidos en el registro de usuario*/
		delegadorEvento.on(document,"click","#crearUsuario",function(e){
			let nombreRegistro = document.getElementById("nombreRegistro");
			let emailRegistro = document.getElementById("emailRegistro");
			let contrasenaRegistro = document.getElementById("contrasenaRegistro");
			let confirmarContrasenaRegistro = document.getElementById("confirmarContrasenaRegistro");
			
			let validado = true;
			let textoError = "";
			
			if(nombreRegistro.value.length >= 3 && nombreRegistro.value.length <= 30){
				nombreRegistro.style.backgroundColor = colorNormal;
			}
			else{
				nombreRegistro.style.backgroundColor = colorError;
				textoError += "El nombre debe tener entre 3 y 30 caracteres.::......::";
				validado = false;
			}
			
			let expresionRegular = /^([0-9a-zA-Z]([-\.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/;
			
			if(emailRegistro.value.length >= 3 && emailRegistro.value.length <= 255){
				if(!expresionRegular.test(emailRegistro.value)){
					emailRegistro.style.backgroundColor = colorError;
					textoError += "El e-mail que has introducido tiene un formato incorrecto.::......::";
					validado = false;
				}
				else{
					emailRegistro.style.backgroundColor = colorNormal;
				}
			}
			else{
				emailRegistro.style.backgroundColor = colorError;
				textoError += "Debes introducir el e-mail de tu cuenta.::......::";
				validado = false;
			}
			
			if(contrasenaRegistro.value.length >= 6 && contrasenaRegistro.value.length <= 20){
				if(contrasenaRegistro.value == confirmarContrasenaRegistro.value){
					contrasenaRegistro.style.backgroundColor = colorNormal;
				}
				else{
					confirmarContrasenaRegistro.style.backgroundColor = colorError;
					textoError += "Las contraseñas deben coincidir.::......::";
					validado = false;
				}
			}
			else{
				contrasenaRegistro.style.backgroundColor = colorError;
				textoError += "La contraseña debe tener entre 6 y 20 caracteres.::......::";
				validado = false;
			}
			
			if(validado){
				cargandoAjax(true);
				solicitudPost("./php/registrarUsuario.php", {
					nombreRegistro:nombreRegistro.value,
					emailRegistro:emailRegistro.value,
					contrasenaRegistro:contrasenaRegistro.value
				}, function(data){
					let arrayDatos = JSON.parse(data);
					if(arrayDatos[0] == 1){
						mostrarFormulario(0);
					}
					else{
						ocultarFormulario();
					}
					mostrarMensajeAlerta(arrayDatos);
					cargandoAjax(false);
				},true);
			}
			else{
				mostrarMensajeAlerta([0,textoError]);
			}
		});
		
		/*Evento para iniciar sesión, una vez validados los datos, el servidor nos devuelve nuestra cuenta*/
		delegadorEvento.on(document,"click","#accederUsuario",function(e){
			let emailUsuario = document.getElementById("emailUsuario");
			let contrasenaUsuario = document.getElementById("contrasenaUsuario");
			cargandoAjax(true);
			solicitudPost("./php/iniciarSesion.php", {
				emailUsuario:emailUsuario.value,
				contrasenaUsuario:contrasenaUsuario.value
			},function(data){
				let arrayDatos = JSON.parse(data);
				if(arrayDatos[0] == 1){
					ocultarFormulario();
					setTimeout(function(){
						window.location.href = "./";
					},1000);
				}
				mostrarMensajeAlerta(arrayDatos);
				cargandoAjax(false);
			},true);
		});
		
		/*Evento que cierra la ventana de alerta*/
		delegadorEvento.on(document,"click",".cancelarAlerta",function(e){
			ocultarAlerta();
		});
		
		/*Evento para cerrar sesión*/
		delegadorEvento.on(document,"click","#cerrarSesion",function(e){
			cargandoAjax(true);
			solicitudPost("../php/cerrarSesion.php", {}, function(data){
				let arrayDatos = JSON.parse(data);
				if(arrayDatos[0] == '1'){
					window.location.href = "../";
				}
			},true);
		});
		
		/*Verificación de los nuevos datos de cuenta introducidos al intentar modificarlos*/
		delegadorEvento.on(document,"click","#guardarCambios",function(e){
			
			let cambioNombre = document.getElementById("cambioNombre");
			let cambioContrasena = document.getElementById("cambioContrasena");
			let RepCambioContrasena = document.getElementById("RepCambioContrasena");
			
			let validado = true;
			let textoError = "";
			
			if(cambioNombre.value != ""){
				if(cambioNombre.value.length >= 3 && cambioNombre.value.length <= 30){
					cambioNombre.style.backgroundColor = colorNormal;
					}
				else{
					cambioNombre.style.backgroundColor = colorError;
					textoError += "El nombre debe tener entre 3 y 30 caracteres.::......::";
					validado = false;
				}
			}
			
			if(cambioContrasena.value != ""){
				if(cambioContrasena.value.length >= 6 && cambioContrasena.value.length <= 20){
					if(cambioContrasena.value == RepCambioContrasena.value){
						cambioContrasena.style.backgroundColor = colorNormal;
					}
					else{
						RepCambioContrasena.style.backgroundColor = colorError;
						textoError += "Las contraseñas deben coincidir.::......::";
						validado = false;
					}
				}
				else{
					cambioContrasena.style.backgroundColor = colorError;
					textoError += "La contraseña debe tener entre 6 y 20 caracteres.::......::";
					validado = false;
				}
			}
			
			if(validado){
				cargandoAjax(true);
				solicitudPost("../php/actualizarDatos.php", {
					cambioNombre:cambioNombre.value,
					cambioContrasena:cambioContrasena.value
				},function(data){
					let arrayDatos = JSON.parse(data);
					
					mostrarMensajeAlerta(arrayDatos);
					cargandoAjax(false);
				},true);
			}
			else{
				mostrarMensajeAlerta([0,textoError]);
			}
		});
		
		/*Evento para el botón de retroceso a la página principal*/
		delegadorEvento.on(document,"click","#botonCasa",function(e){
			window.location.href = "../";
		});
		
		/*Evento para el botón derecha del calendario*/
		delegadorEvento.on(document,"click","#botonDcha",function(e){
			mesAgenda++;
			
			if(mesAgenda > 11){
				mesAgenda = 0;
				anoAgenda++;
			}
			
			eliminarHijos(document.getElementById("calendario"));
			
			let arrayMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
			let tituloAgenda = document.createTextNode("Agenda de " + arrayMeses[mesAgenda] + " " + anoAgenda);
			eliminarHijos(document.getElementById("tituloAgenda"));
			document.getElementById("tituloAgenda").appendChild(tituloAgenda);

			let arrayCalendario = crearCalendario(anoAgenda,mesAgenda);
			
			dibujarCalendario(arrayCalendario);
			
			verMarcadores(anoAgenda,mesAgenda);
		});
		
		/*Evento para el botón izquierda del calendario*/
		delegadorEvento.on(document,"click","#botonIzq",function(e){
			mesAgenda--;
			
			if(mesAgenda < 0){
				mesAgenda = 11;
				anoAgenda--;
			}
			
			eliminarHijos(document.getElementById("calendario"));
			
			let arrayMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
			let tituloAgenda = document.createTextNode("Agenda de " + arrayMeses[mesAgenda] + " " + anoAgenda);
			eliminarHijos(document.getElementById("tituloAgenda"));
			document.getElementById("tituloAgenda").appendChild(tituloAgenda);

			let arrayCalendario = crearCalendario(anoAgenda,mesAgenda);
			
			dibujarCalendario(arrayCalendario);
			
			verMarcadores(anoAgenda,mesAgenda);
		});
		
		/*Devolución de eventos al pulsar en el día del calendario*/
		delegadorEvento.on(document,"click",".diaCalendario",function(e){
			let diaCalendario = this;
			
			let elementoCalendario = document.getElementById("calendario");
			let hijosCalendario = elementoCalendario.getElementsByClassName("diaCalendario");
			let numeroHijos = hijosCalendario.length;
			
			for(let i = 0; i < numeroHijos; i++){
				if(hijosCalendario[i].classList.contains("seleccionado")){
					hijosCalendario[i].classList.remove("seleccionado");
				}
			}
			
			diaCalendario.classList.add("seleccionado");
			if(diaCalendario.getElementsByTagName("input").length > 0){
				let fechaDia = diaCalendario.getElementsByTagName("input")[0].value;
				
				cargandoAjax(true);
				solicitudPost("../php/devolverEventos.php",{fechaDia:fechaDia},function(data){
					let arrayDatos = JSON.parse(data);
					
					let cuerpoEventos = document.getElementById("cuerpoEventos");
					eliminarHijos(cuerpoEventos);
					if(arrayDatos.length > 0){
						for(let i = 0; i < arrayDatos.length; i++){
							let fragmentoHTML = document.createDocumentFragment();
							
							let filaEvento = document.createElement("div");
							filaEvento.classList.add("filaEvento");
							fragmentoHTML.appendChild(filaEvento);
							
							let elementoInput = document.createElement("input");
							elementoInput.setAttribute("type","hidden");
							elementoInput.value = arrayDatos[i][0];
							filaEvento.appendChild(elementoInput);
							
							let horaEvento = document.createElement("div");
							horaEvento.classList.add("horaEvento");
							horaEvento.appendChild(document.createTextNode(arrayDatos[i][4]));
							filaEvento.appendChild(horaEvento);
							
							let rayaEvento = document.createElement("div");
							rayaEvento.classList.add("rayaEvento");
							
							let elementoSpan = document.createElement("span");
							elementoSpan.classList.add(arrayDatos[i][3]);
							rayaEvento.appendChild(elementoSpan);
							
							filaEvento.appendChild(rayaEvento);
							
							let infoEvento = document.createElement("div");
							infoEvento.classList.add("infoEvento");
							filaEvento.appendChild(infoEvento);
							
							let tituloEvento = document.createElement("div");
							tituloEvento.classList.add("tituloEvento");
							tituloEvento.appendChild(document.createTextNode(arrayDatos[i][1]));
							infoEvento.appendChild(tituloEvento);
							
							let borrarEvento =  document.createElement("button");
							borrarEvento.classList.add("borrarEvento");
							borrarEvento.appendChild(document.createTextNode("X"));
							tituloEvento.appendChild(borrarEvento);
							
							let descripcionEvento = document.createElement("div");
							descripcionEvento.classList.add("descripcionEvento");
							descripcionEvento.appendChild(document.createTextNode(arrayDatos[i][2]));
							infoEvento.appendChild(descripcionEvento);
							
							cuerpoEventos.appendChild(fragmentoHTML);
						}
					}
					else{
						let fragmentoHTML = document.createDocumentFragment();
						
						let filaEvento = document.createElement("div");
						filaEvento.classList.add("filaEvento");
						filaEvento.classList.add("vacio");
						filaEvento.appendChild(document.createTextNode("No hay Eventos"));
						fragmentoHTML.appendChild(filaEvento);
						
						cuerpoEventos.appendChild(fragmentoHTML);
					}
					
					cargandoAjax(false);
				},true);
			}
		});
		
		/*Dispara el formulario y borra registros anteriores escritos en él*/
		delegadorEvento.on(document,"click","#crearEvento",function(e){
			document.getElementById("tituloEvento").value = "";
			document.getElementById("tituloEvento").style.backgroundColor = colorNormal;
			document.getElementById("descripcionEvento").value = "";
			document.getElementById("descripcionEvento").style.backgroundColor = colorNormal;
			document.getElementById("fechaEvento").value = "";
			document.getElementById("fechaEvento").style.backgroundColor = colorNormal;
			
			let botonesColores = document.getElementsByClassName("botonesColores")[0];
			for(let i = 0; i < botonesColores.getElementsByTagName("input").length; i++){
				botonesColores.getElementsByTagName("input")[i].checked = false;
			}
			
			mostrarFormulario(2);
		});
		
		/*Validaciones en el formulario de creacion de eventos*/
		delegadorEvento.on(document,"click","#guardarEvento",function(e){
			let tituloEvento = document.getElementById("tituloEvento");
			let descripcionEvento = document.getElementById("descripcionEvento");
			let fechaEvento = document.getElementById("fechaEvento");
			let botonesColores = document.getElementsByClassName("botonesColores")[0];
			
			let validado = true;
			let textoError = ""
			
			if(tituloEvento.value != ""){
				if(tituloEvento.value.length >= 3 && tituloEvento.value.length <= 20){
					tituloEvento.style.backgroundColor = colorNormal;
				}
				else{
					tituloEvento.style.backgroundColor = colorError;
					textoError += "El título debe tener entre 3 y 20 caracteres.::......::";
					validado = false;
				}
			}
			else{
				tituloEvento.style.backgroundColor = colorError;
				textoError += "Debes escribir un título.::......::";
				validado = false;
			}
			
			if(descripcionEvento.value != ""){
				if(descripcionEvento.value.length >= 3 && descripcionEvento.value.length <= 300){
					descripcionEvento.style.backgroundColor = colorNormal;
				}
				else{
					descripcionEvento.style.backgroundColor = colorError;
					textoError += "La descripción debe tener entre 3 y 300 caracteres.::......::";
					validado = false;
				}
			}
			else{
				descripcionEvento.style.backgroundColor = colorError;
				textoError += "Debes escribir una descripción.::......::";
				validado = false;
			}
			
			if(fechaEvento.value == ""){
				fechaEvento.style.backgroundColor = colorError;
				textoError += "Debes seleccionar una fecha y hora.::......::";
				validado = false;
			}
			
			let colorSeleccionado = false;
			let color = "";
			
			for(let i = 0; i < botonesColores.getElementsByTagName("input").length; i++){
				if(botonesColores.getElementsByTagName("input")[i].checked){
					colorSeleccionado = true;
					color = botonesColores.getElementsByTagName("input")[i].value;
				}
			}
		
			if(!colorSeleccionado){
				textoError += "Debes seleccionar un color.::......::";
				validado = false;
			}
			
			if(validado){
				cargandoAjax(true);
				solicitudPost("../php/crearEvento.php", {
					tituloEvento:tituloEvento.value,
					descripcionEvento:descripcionEvento.value,
					fechaEvento:fechaEvento.value,
					colorEvento:color
				},function(data){
					ocultarFormulario();
					let arrayDatos = JSON.parse(data);
					
					mostrarMensajeAlerta(arrayDatos);
					
					setTimeout(function(){
						window.location.href = "./";
					},2000);
					
					cargandoAjax(false);
				},true);
			}
			else{
				mostrarMensajeAlerta([0,textoError]);
			}
		});
		
		/*Botón para poder eliminar un evento del calendario*/
		delegadorEvento.on(document,"click",".borrarEvento",function(e){
			e.preventDefault();
			e.stopImmediatePropagation();
			
			let idEvento = this.parentNode.parentNode.parentNode.getElementsByTagName("input")[0].value;
			
			solicitudPost("../php/borrarEvento.php", {idEvento:idEvento},function(data){
				let arrayDatos = JSON.parse(data);
				
				mostrarMensajeAlerta(arrayDatos);
				
				setTimeout(function(){
					window.location.href = "./";
				},2000);
				
				cargandoAjax(false);
			},true);
		});
		
		/*Evento para el formulario de edición de eventos*/
		delegadorEvento.on(document,"click",".filaEvento",function(e){
			let idEvento = this.getElementsByTagName("input")[0].value;
			
			cargandoAjax(true);
			solicitudPost("../php/devuelveEvento.php", {idEvento:idEvento},function(data){
				let arrayDatos = JSON.parse(data);
				
				document.getElementById("formularioEditarEvento").getElementsByTagName("input")[0].value = arrayDatos[0];
				document.getElementById("editarTituloEvento").value = arrayDatos[1];
				document.getElementById("editarDescripcionEvento").value = arrayDatos[2];
				document.getElementById("editarFechaEvento").value = arrayDatos[4];
				
				let botonesColores = document.getElementsByClassName("botonesColores")[1];
				for(let i = 0; i < botonesColores.getElementsByTagName("input").length; i++){
					if(botonesColores.getElementsByTagName("input")[i].id == "editar" + arrayDatos[3]){
						botonesColores.getElementsByTagName("input")[i].checked = true; 
					}
				}
				
				mostrarFormulario(3);
				
				cargandoAjax(false);
			},true);
		});
		
		/*Validaciones de los nuevos datos del formulario de edición de eventos*/
		delegadorEvento.on(document,"click","#modificarEvento",function(e){
			let idEvento = document.getElementById("formularioEditarEvento").getElementsByTagName("input")[0].value;
			let tituloEvento = document.getElementById("editarTituloEvento");
			let descripcionEvento = document.getElementById("editarDescripcionEvento");
			let fechaEvento = document.getElementById("editarFechaEvento");
			let botonesColores = document.getElementsByClassName("botonesColores")[1];
			
			let validado = true;
			let textoError = ""
			
			if(tituloEvento.value != ""){
				if(tituloEvento.value.length >= 3 && tituloEvento.value.length <= 20){
					tituloEvento.style.backgroundColor = colorNormal;
				}
				else{
					tituloEvento.style.backgroundColor = colorError;
					textoError += "El título debe tener entre 3 y 20 caracteres.::......::";
					validado = false;
				}
			}
			else{
				tituloEvento.style.backgroundColor = colorError;
				textoError += "Debes escribir un título.::......::";
				validado = false;
			}
			
			if(descripcionEvento.value != ""){
				if(descripcionEvento.value.length >= 3 && descripcionEvento.value.length <= 300){
					descripcionEvento.style.backgroundColor = colorNormal;
				}
				else{
					descripcionEvento.style.backgroundColor = colorError;
					textoError += "La descripción debe tener entre 3 y 300 caracteres.::......::";
					validado = false;
				}
			}
			else{
				descripcionEvento.style.backgroundColor = colorError;
				textoError += "Debes escribir una descripción.::......::";
				validado = false;
			}
			
			if(fechaEvento.value == ""){
				fechaEvento.style.backgroundColor = colorError;
				textoError += "Debes seleccionar una fecha y hora.::......::";
				validado = false;
			}
			
			let colorSeleccionado = false;
			let color = "";
			
			for(let i = 0; i < botonesColores.getElementsByTagName("input").length; i++){
				if(botonesColores.getElementsByTagName("input")[i].checked){
					colorSeleccionado = true;
					color = botonesColores.getElementsByTagName("input")[i].value;
				}
			}
		
			if(!colorSeleccionado){
				textoError += "Debes seleccionar un color.::......::";
				validado = false;
			}
			
			if(validado){
				cargandoAjax(true);
				solicitudPost("../php/actualizarEvento.php", {
					idEvento:idEvento,
					tituloEvento:tituloEvento.value,
					descripcionEvento:descripcionEvento.value,
					fechaEvento:fechaEvento.value,
					colorEvento:color
				},function(data){
					let arrayDatos = JSON.parse(data);
					
					mostrarMensajeAlerta(arrayDatos);
					
					setTimeout(function(){
						window.location.href = "./";
					},2000);
					
					cargandoAjax(false);
				},true);
			}
			else{
				mostrarMensajeAlerta([0,textoError]);
			}
		});
		
		/*Dispara el formulario y borra registros anteriores escritos en él*/
		delegadorEvento.on(document,"click","#crearImagen",function(e){
			document.getElementById("descripcionImagen").value = "";
			document.getElementById("descripcionImagen").style.backgroundColor = colorNormal;
			document.getElementById("imagenArmario").value = null;
			document.getElementById("imagenArmario").style.backgroundColor = colorNormal;
			mostrarFormulario(4);
		});
		
		/*Validaciones de los datos del formulario de guardado de imagenes*/
		delegadorEvento.on(document,"click","#guardarImagen",function(e){
			let descripcionImagen = document.getElementById("descripcionImagen");
			let imagenArmario = document.getElementById("imagenArmario");
			
			let validado = true;
			let textoError = "";
			
			if(descripcionImagen.value != ""){
				if(descripcionImagen.value.length >= 3 && descripcionImagen.value.length <= 300){
					descripcionImagen.style.backgroundColor = colorNormal;
				}
				else{
					descripcionImagen.style.backgroundColor = colorError;
					textoError += "La descripción debe tener entre 3 y 300 caracteres.::......::";
					validado = false;
				}
			}
			else{
				descripcionImagen.style.backgroundColor = colorError;
				textoError += "Debes escribir una descripción.::......::";
				validado = false;
			}
			
			if(imagenArmario.files.length === 0){
				imagenArmario.style.backgroundColor = colorError;
				textoError += "Debes seleccionar una imagen.::......::";
				validado = false;
			}
			else{
				let archivo = imagenArmario.files[0];
				if(!archivo.type.match("image/jpeg")){
					imagenArmario.style.backgroundColor = colorError;
					textoError += "La imagen debe ser JPG.::......::";
					validado = false;
				}
				if(archivo.size > 10485760){
					imagenArmario.style.backgroundColor = colorError;
					textoError += "La imagen no debe superar 10MB.::......::";
					validado = false;
				}
			}
			if(validado){
				cargandoAjax(true);
				solicitudPost("../php/guardarImagen.php", {
					descripcionImagen:descripcionImagen.value,
					imagenArmario:imagenArmario.files[0]
				},function(data){
					let arrayDatos = JSON.parse(data);
					
					mostrarMensajeAlerta(arrayDatos);
					
					setTimeout(function(){
						window.location.href = "./";
					},2000);
					
					cargandoAjax(false);
				},true);
			}
			else{
				mostrarMensajeAlerta([0,textoError]);
			}
		});
		
		/*Evento para poder visualizar la imagen en grande*/
		delegadorEvento.on(document,"click",".contenedorImagen > img",function(e){
			let rutaImagen = this.src;
			let tituloImagen = this.getAttribute("title");
			
			document.getElementById("contenedorImagenGrande").getElementsByTagName("img")[0].src = rutaImagen;
			document.getElementById("contenedorImagenGrande").getElementsByTagName("img")[0].setAttribute("title",tituloImagen);
			
			document.getElementById("contenedorImagenGrande").style.display = "flex";
			setTimeout(function(){
				document.getElementById("contenedorImagenGrande").style.opacity = "1";
			},10);
		});
		
		/*Evento para cerrar la imagen que se esta visualizando*/
		delegadorEvento.on(document,"click","#cerrarImagenGrande",function(e){
			document.getElementById("contenedorImagenGrande").style.opacity = "0";
			setTimeout(function(){
				document.getElementById("contenedorImagenGrande").style.display = "none";
			},200);
		});
		
		/*Evento para poder borrar una imagen de armario*/
		delegadorEvento.on(document,"click",".borrarImagen",function(e){
			let idImagen = this.parentNode.getElementsByTagName("input")[0].value;
			
			solicitudPost("../php/borrarImagen.php", {idImagen:idImagen},function(data){
				let arrayDatos = JSON.parse(data);
				
				mostrarMensajeAlerta(arrayDatos);
				
				setTimeout(function(){
					window.location.href = "./";
				},2000);
				
				cargandoAjax(false);
			},true);
		});	
		
		/*Dispara el formulario de creación de notas y borra registros anteriores escritos en él*/
		delegadorEvento.on(document,"click","#crearNota",function(e){
			document.getElementById("tituloNota").value = "";
			document.getElementById("tituloNota").style.backgroundColor = colorNormal;
			document.getElementById("descripcionNota").value = "";
			document.getElementById("descripcionNota").style.backgroundColor = colorNormal;
			
			mostrarFormulario(5);
		});
		
		delegadorEvento.on(document,"click","#guardarNota",function(e){
			let tituloNota = document.getElementById("tituloNota");
			let descripcionNota = document.getElementById("descripcionNota");
			
			let validado = true;
			let textoError = "";
			
			if(tituloNota.value != ""){
				if(tituloNota.value.length >= 3 && tituloNota.value.length <= 20){
					tituloNota.style.backgroundColor = colorNormal;
				}
				else{
					tituloNota.style.backgroundColor = colorError;
					textoError += "El título debe tener entre 3 y 20 caracteres.::......::";
					validado = false;
				}
			}
			else{
				tituloNota.style.backgroundColor = colorError;
				textoError += "Debes escribir un título.::......::";
				validado = false;
			}
			
			if(descripcionNota.value != ""){
				if(descripcionNota.value.length >= 3 && descripcionNota.value.length <= 2000){
					descripcionNota.style.backgroundColor = colorNormal;
				}
				else{
					descripcionNota.style.backgroundColor = colorError;
					textoError += "La descripción debe tener entre 3 y 2000 caracteres.::......::";
					validado = false;
				}
			}
			else{
				descripcionNota.style.backgroundColor = colorError;
				textoError += "Debes escribir una descripción.::......::";
				validado = false;
			}
			if(validado){
				cargandoAjax(true);
				solicitudPost("../php/crearNota.php", {
					tituloNota:tituloNota.value,
					descripcionNota:descripcionNota.value
				},function(data){
					let arrayDatos = JSON.parse(data);
					
					mostrarMensajeAlerta(arrayDatos);
					
					setTimeout(function(){
						window.location.href = "./";
					},2000);
					
					cargandoAjax(false);
				},true);
			}
			else{
				mostrarMensajeAlerta([0,textoError]);
			}
		});
		
		/*Evento para el formulario de edición de notas*/
		delegadorEvento.on(document,"click",".infoNota",function(e){
			let idNota = this.parentNode.getElementsByTagName("input")[0].value;
			
			cargandoAjax(true);
			solicitudPost("../php/devuelveNota.php", {idNota:idNota},function(data){
				let arrayDatos = JSON.parse(data);
				
				document.getElementById("formularioEditarNota").getElementsByTagName("input")[0].value = arrayDatos[0];
				document.getElementById("editarTituloNota").value = arrayDatos[1];
				document.getElementById("editarDescripcionNota").value = arrayDatos[2];
				
				mostrarFormulario(6);
				
				cargandoAjax(false);
			},true);
		});
		
		/*Validaciones de los datos del formulario de edición de notas*/
		delegadorEvento.on(document,"click","#editarNota",function(e){
			let idNota = document.getElementById("formularioEditarNota").getElementsByTagName("input")[0].value;
			let tituloNota = document.getElementById("editarTituloNota");
			let descripcionNota = document.getElementById("editarDescripcionNota");
			
			let validado = true;
			let textoError = "";
			
			if(tituloNota.value != ""){
				if(tituloNota.value.length >= 3 && tituloNota.value.length <= 20){
					tituloNota.style.backgroundColor = colorNormal;
				}
				else{
					tituloNota.style.backgroundColor = colorError;
					textoError += "El título debe tener entre 3 y 20 caracteres.::......::";
					validado = false;
				}
			}
			else{
				tituloNota.style.backgroundColor = colorError;
				textoError += "Debes escribir un título.::......::";
				validado = false;
			}
			
			if(descripcionNota.value != ""){
				if(descripcionNota.value.length >= 3 && descripcionNota.value.length <= 2000){
					descripcionNota.style.backgroundColor = colorNormal;
				}
				else{
					descripcionNota.style.backgroundColor = colorError;
					textoError += "La descripción debe tener entre 3 y 2000 caracteres.::......::";
					validado = false;
				}
			}
			else{
				descripcionNota.style.backgroundColor = colorError;
				textoError += "Debes escribir una descripción.::......::";
				validado = false;
			}
			if(validado){
				cargandoAjax(true);
				solicitudPost("../php/actualizarNota.php", {
					idNota:idNota,
					tituloNota:tituloNota.value,
					descripcionNota:descripcionNota.value
				},function(data){
					let arrayDatos = JSON.parse(data);
					
					mostrarMensajeAlerta(arrayDatos);
					
					setTimeout(function(){
						window.location.href = "./";
					},2000);
					
					cargandoAjax(false);
				},true);
			}
			else{
				mostrarMensajeAlerta([0,textoError]);
			}
		});
		
		/*Evento para poder borrar una nota*/
		delegadorEvento.on(document,"click",".borrarNota",function(e){
			let idNota = this.parentNode.getElementsByTagName("input")[0].value;
			solicitudPost("../php/borrarNota.php", {idNota:idNota},function(data){
				let arrayDatos = JSON.parse(data);
				
				mostrarMensajeAlerta(arrayDatos);
				
				setTimeout(function(){
					window.location.href = "./";
				},2000);
				
				cargandoAjax(false);
			},true);
		});	
	}
		
	
	/*Inicialización de funciones*/
	function inicializarFunciones(){
		if(document.getElementById("calendario") !== null){
			let hoy = new Date();

			mesAgenda = hoy.getMonth();     // mes (0-11)
			anoAgenda = hoy.getFullYear();  // año completo
			
			let arrayMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
			let tituloAgenda = document.createTextNode("Agenda de " + arrayMeses[mesAgenda] + " " + anoAgenda);
			eliminarHijos(document.getElementById("tituloAgenda"));
			document.getElementById("tituloAgenda").appendChild(tituloAgenda);

			let arrayCalendario = crearCalendario(anoAgenda,mesAgenda);
			
			dibujarCalendario(arrayCalendario);
			
			verMarcadores(anoAgenda,mesAgenda);
		}
	}
	
	/*Funciones para ver los marcadores*/
	function verMarcadores(anoAgenda,mesAgenda){
		cargandoAjax(true);
		solicitudPost("../php/devolverMarcadores.php", {
			anoAgenda:anoAgenda,
			mesAgenda:mesAgenda
		},function(data){
			let arrayDatos = JSON.parse(data);
			
			let elementoCalendario = document.getElementById("calendario");
			let hijosCalendario = elementoCalendario.getElementsByClassName("diaCalendario");
			let numeroHijos = hijosCalendario.length;
			
			for(let i = 0; i < numeroHijos; i++){
				let hijoCalendario = hijosCalendario[i];
				if(!hijoCalendario.classList.contains("titulo") && !hijoCalendario.classList.contains("noSeleccionable")){
					let fechaDia = hijoCalendario.getElementsByTagName("input")[0].value;
					let contador = 0;
					for(let j = 0; j < arrayDatos.length; j++){
						if(fechaDia == arrayDatos[j][0]){
							if(contador < 5){
								let diaEventos = hijoCalendario.getElementsByClassName("diaEventos")[0];
								
								let fragmentoHTML = document.createDocumentFragment();
								
								let elementoSpan = document.createElement("span");
								elementoSpan.classList.add("evento");
								elementoSpan.classList.add(arrayDatos[j][1]);
								fragmentoHTML.appendChild(elementoSpan);
								
								diaEventos.appendChild(fragmentoHTML);
							}
							contador++;
						}
					}
				}
			}
			cargandoAjax(false);
		},true);
	}
	
	/*Funciones para dibujar calendario*/
	function dibujarCalendario(arrayCalendario){
		let contenedor = document.getElementById("calendario");
		
		let fragmentoHTML = document.createDocumentFragment();
		
		for(let i=0;i<arrayCalendario.length;i++){
			for(let j=0;j<arrayCalendario[i].length;j++){
				let diaCalendario = document.createElement("div");
				diaCalendario.classList.add("diaCalendario");
				if(i == 0){
					diaCalendario.classList.add("titulo");
				}
				fragmentoHTML.appendChild(diaCalendario);
				
				if(i > 0){
					if(arrayCalendario[i][j] !== null){
						let input = document.createElement("input");
						input.setAttribute("type","hidden");
						input.value = arrayCalendario[i][j][1];
						diaCalendario.appendChild(input);
						
						let ahora = new Date();

						let anoAhora = ahora.getFullYear();
						let mesAhora = ahora.getMonth();
						let diaAhora = ahora.getDate();

						let fechaAhora = `${anoAhora}-${String(mesAhora + 1).padStart(2, '0')}-${String(diaAhora).padStart(2, '0')}`;

						if(fechaAhora == arrayCalendario[i][j][1]){
							diaCalendario.classList.add("actual");
						}
					}
					else{
						diaCalendario.classList.add("noSeleccionable");
					}
				}
				
				let diaNumero = document.createElement("div");
				diaNumero.classList.add("diaNumero");
				if(i > 0){
					if(arrayCalendario[i][j] !== null){
						diaNumero.appendChild(document.createTextNode(arrayCalendario[i][j][0]));
					}
				}
				else{
					diaNumero.appendChild(document.createTextNode(arrayCalendario[i][j]));
				}
				diaCalendario.appendChild(diaNumero);
				
				if(i > 0){
					let diaEventos = document.createElement("div");
					diaEventos.classList.add("diaEventos");
					diaCalendario.appendChild(diaEventos);
				}
				
				contenedor.appendChild(fragmentoHTML);
			}
		}
	}
	
	/*Funciones para mostrar calendario en agenda*/
	function crearCalendario(ano, mes) {
		const diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

		let primerDia = new Date(ano, mes, 1).getDay();
		let diasMes = new Date(ano, mes + 1, 0).getDate();
		
		//Cambiar orden de los días de la semana para que empiece en Lunes
		primerDia = (primerDia === 0) ? 6 : primerDia - 1;
		
		let calendario = [];

		//Añadir días de la semana
		calendario.push(diasSemana);

		let semana = [];

		//Espacios anteriores al día 1
		for(let i = 0; i < primerDia; i++){
			semana.push(null);
		}

		//Añadir días del mes
		for(let dia = 1; dia <= diasMes; dia++){
			let fecha = new Date(ano, mes, dia);
			let fechaFormateada = `${ano}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
			semana.push([dia,fechaFormateada]);

			if(semana.length === 7){
				calendario.push(semana);
				semana = [];
			}
		}

		//Días de semana incompleta
		if(semana.length > 0){
			while (semana.length < 7) {
				semana.push(null);
			}
			calendario.push(semana);
		}

		return calendario;
	}

	/*Funciones para mostrar y ocultar formularios*/
	function mostrarFormulario(tipo){
		document.body.className = "noscroll";
		fondoFormulario.style.display = "flex";
		setTimeout(function(){
			fondoFormulario.style.opacity = "1";
		},10);

		if(document.getElementById("formularioInicioSesion") !== null){
			formularioInicioSesion.style.display = "none";
		}
		if(document.getElementById("formularioRegistro") !== null){
			formularioRegistro.style.display = "none";
		}
		if(document.getElementById("formularioCrearEvento") !== null){
			formularioCrearEvento.style.display = "none";
		}
		if(document.getElementById("formularioEditarEvento") !== null){
			formularioEditarEvento.style.display = "none";
		}
		if(document.getElementById("formularioGuardarImagen") !== null){
			formularioGuardarImagen.style.display = "none";
		}
		if(document.getElementById("formularioGuardarNota") !== null){
			formularioGuardarNota.style.display = "none";
		}
		if(document.getElementById("formularioEditarNota") !== null){
			formularioEditarNota.style.display = "none";
		}
		switch(tipo){
			case 0:
				formularioInicioSesion.style.display = "block";
				break;
			case 1:
				formularioRegistro.style.display = "block";
				break;
			case 2:
				formularioCrearEvento.style.display = "block";
				break;
			case 3:
				formularioEditarEvento.style.display = "block";
				break;
			case 4:
				formularioGuardarImagen.style.display = "block";
				break;
			case 5:
				formularioGuardarNota.style.display = "block";
				break;
			case 6:
				formularioEditarNota.style.display = "block";
				break;
		}
	}
	
	/*Función para que el formulario desaparezca*/
	function ocultarFormulario(){
		if(document.getElementById("fondoFormulario") !== null){
			document.body.className = "";
			fondoFormulario.style.opacity = "0";
			setTimeout(function(){
				fondoFormulario.style.display = "none";
			},200);
		}
	}
	
	/*Funciones para mostrar u ocultar alertas*/
	function mostrarAlerta(type){
		document.body.className = "noscroll";
		fondoAlerta.style.display = "flex";
		setTimeout(function(){
			fondoAlerta.style.opacity = "1";
		},10);
			
		formularioAlerta.style.display = "none";
		
		switch(type){
			case 0:
				formularioAlerta.style.display = "block";
				break;
		}
	}
	
	function ocultarAlerta(){
		if(document.getElementById("fondoAlerta") !== null){
			document.body.className = "";
			fondoAlerta.style.opacity = "0";
			setTimeout(function(){
				fondoAlerta.style.display = "none";
			},200);
		}
	}
	
	/*Función para mostrar mensajes flotantes*/
	function mostrarMensajeAlerta(arrayMensaje){
		if(arrayMensaje[1].length > 0){
			let contenedorMensaje = formularioAlerta.getElementsByTagName("p")[0];
			eliminarHijos(contenedorMensaje);
			if(arrayMensaje[1].indexOf("::......::") == -1){
				contenedorMensaje.appendChild(document.createTextNode(arrayMensaje));
			}
			else{
				let arrayMensajeAux = arrayMensaje[1].substr(0,arrayMensaje[1].length-10).split("::......::");
				for(let i=0;i<arrayMensajeAux.length;i++){
					contenedorMensaje.appendChild(document.createTextNode(arrayMensajeAux[i]));
					if(i < arrayMensajeAux.length - 1){
						contenedorMensaje.appendChild(document.createElement("br"));
					}
				}
			}
			mostrarAlerta(0);
		}
	}
	
    /*Función para mostrar y ocultar el fondo e indicador de carga*/
	function cargandoAjax(activado){
		if(activado){
			contenedorCargaAjax.style.display = "block";
			setTimeout(function(){
				contenedorCargaAjax.style.opacity = "1";
			},10);
		}
		else{
			contenedorCargaAjax.style.opacity = "0";
			setTimeout(function(){
				contenedorCargaAjax.style.display = "none";
			},200);
		}
	}
	
    /*Función para eliminar todos los hijos de un elemento*/
	function eliminarHijos(elemento){
		while(elemento.hasChildNodes()){
			elemento.removeChild(elemento.lastChild);
		}
	}

    /*Función para asignar eventos a elementos que posiblemente no existan*/
	const delegadorEvento = {
		on: function(contenedor,nombreEvento,selector,manejador){
			const listener = function(e){
				let objetivo = e.target;
				while(objetivo && objetivo !== contenedor){
					if(objetivo.matches && objetivo.matches(selector)){
						manejador.call(objetivo,e);
						return;
					}
					objetivo = objetivo.parentNode;
				}
			};
			contenedor.addEventListener(nombreEvento,listener);
			return listener;
		},
		off: function(contenedor,nombreEvento,selector,manejador){
			contenedor.removeEventListener(nombreEvento,manejador);
		}
	};

    /*Función para crear peticiones ajax*/
	function solicitudPost(url, data, callback, saltarCarga, metodo) {
		if (!saltarCarga) {
			cargandoAjax(true);
		}
		
		const metodoSolicitud = metodo || 'POST';
		let cuerpoSolicitud;
		
		if (data instanceof FormData) {
			cuerpoSolicitud = data;
		} else {
			cuerpoSolicitud = new FormData();
			for (let key in data) {
				cuerpoSolicitud.append(key, data[key]);
			}
		}
		
		fetch(url, {
			method: metodoSolicitud,
			body: cuerpoSolicitud
		})
		.then(respuesta => respuesta.text())
		.then(textoRespuesta => {
			if (!saltarCarga) {
				cargandoAjax(false);
			}
			callback(textoRespuesta);
		})
		.catch(error => {
			if (!saltarCarga) {
				cargandoAjax(false);
			}
			callback('{"error": "Error de conexión"}');
		});
	}
	
	/*INICIO DEL CÓDIGO*/
	(function(){
		inicializarElementos();
		inicializarEventos();
		inicializarFunciones();
		setTimeout(function(){
			document.body.style.opacity = "1";
		},10);
	})();
});