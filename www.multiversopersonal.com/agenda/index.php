<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
if(!isset($_SESSION['usuario'])){
	header("Location: ../");
	exit;
}
else{
?>	
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<title>Multiverso Personal</title>
		<link rel="icon" href="../img/favicon_32x32.png" sizes="32x32">
		<link rel="icon" href="../img/favicon_192x192.png" sizes="192x192">
		<link rel="apple-touch-icon" href="../img/favicon_180x180.png">
		<meta name="msapplication-TileImage" content="../img/favicon_270x270.png">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../css/styles.css?v=<?php echo rand(1, 9999);?>"> 
		<script src="../js/script.js?v=<?php echo rand(1, 9999);?>"></script>
	</head>
	<body>
		<div class="cuerpo subpagina">
			<div class="cuerpoCentral cuerpoSubpagina">
				<div class="rivete sup"></div>
				<div class="tituloSubpagina">
					<h1 id="tituloAgenda">Agenda</h1>
					<button type="button" id="botonDcha"></button>
					<button type="button" id="botonIzq"></button>
				</div>
				<div id="calendario" class="cuerpoFormulario contenidoSubpagina grande">
					<!--PRUEBAS
					<div class="diaCalendario">
						<div class="diaNumero">
							1
						</div>
						<div class="diaEventos">
							<span class="evento rosaOscuro"></span>
							<span class="evento rosaClaro"></span>
							<span class="evento verdeOscuro"></span>
							<span class="evento verdeClaro"></span>
							<span class="evento gris"></span>
						</div>
					</div>
					-->
				</div>
				<div id="cuerpoEventos" class="cuerpoFormulario contenidoSubpagina grande">
					<!--PRUEBAS
					<div class="filaEvento">
						<input type="hidden" value="0" />
						<div class="horaEvento">
							08:00
						</div>
						<div class="rayaEvento">
							<span class="verdeClaro"></span>
						</div>
						<div class="infoEvento">
							<div class="tituloEvento">
								Titulo Uno
								<button type="button" class="borrarEvento">X</button>
							</div>
							<div class="descripcionEvento">
								Esto es el evento número uno del calendario.
							</div>
						</div>
					</div>
					-->
				</div>
				<button type="button" id="botonCasa"></button>
				<button type="button" class="botonMas" id="crearEvento"></button>
			</div>
			<div class="rivete inf"></div>
		</div>
		<div id="fondoFormulario" class="fondoFormularios">
			<div class="contenedorFormulario">
				<div class="claseFormulario" id="formularioCrearEvento">
					<div class="tituloFormulario">
						Crear Evento
					</div>
					<div class="cuerpoFormulario">
						<input type="text" id="tituloEvento" placeholder="Título" maxlength="20">
						<textarea id="descripcionEvento" placeholder="Descripción" maxlength="300"></textarea>
						<input type="datetime-local" id="fechaEvento">
						<div class="botonesColores">
							<input id="rosaOscuro" type="radio" value="rosaOscuro" name="colorEvento">
							<label for="rosaOscuro" style="background-color:#f0729d;"><span></span></label>
							<input id="rosaClaro" type="radio" value="rosaClaro" name="colorEvento">
							<label for="rosaClaro" style="background-color:#fcaebf;"><span></span></label>
							<input id="verdeOscuro" type="radio" value="verdeOscuro" name="colorEvento">
							<label for="verdeOscuro" style="background-color:#a7b750;"><span></span></label>
							<input id="verdeClaro" type="radio" value="verdeClaro" name="colorEvento">
							<label for="verdeClaro" style="background-color:#d0d8a2;"><span></span></label>
							<input id="gris" type="radio" value="gris" name="colorEvento">
							<label for="gris" style="background-color:#919191;"><span></span></label>
						</div>
					</div>	
					<div class="botonesFormulario">
						<button type="button" class="cancelar">Cancelar</button>
						<button type="button" id="guardarEvento">Crear</button>
					</div>
					
				</div>
				<div class="claseFormulario" id="formularioEditarEvento">
					<input type="hidden" value="">
					<div class="tituloFormulario">
						Edición de Evento
					</div>
					<div class="cuerpoFormulario">
						<input type="text" id="editarTituloEvento" placeholder="Título" maxlength="20">
						<textarea id="editarDescripcionEvento" placeholder="Descripción" maxlength="300"></textarea>
						<input type="datetime-local" id="editarFechaEvento">
						<div class="botonesColores">
							<input id="editarrosaOscuro" type="radio" value="rosaOscuro" name="colorEvento">
							<label for="editarrosaOscuro" style="background-color:#f0729d;"><span></span></label>
							<input id="editarrosaClaro" type="radio" value="rosaClaro" name="colorEvento">
							<label for="editarrosaClaro" style="background-color:#fcaebf;"><span></span></label>
							<input id="editarverdeOscuro" type="radio" value="verdeOscuro" name="colorEvento">
							<label for="editarverdeOscuro" style="background-color:#a7b750;"><span></span></label>
							<input id="editarverdeClaro" type="radio" value="verdeClaro" name="colorEvento">
							<label for="editarverdeClaro" style="background-color:#d0d8a2;"><span></span></label>
							<input id="editargris" type="radio" value="gris" name="colorEvento">
							<label for="editargris" style="background-color:#919191;"><span></span></label>
						</div>
					</div>	
					<div class="botonesFormulario">
						<button type="button" class="cancelar">Cancelar</button>
						<button type="button" id="modificarEvento">Guardar</button>
					</div>
					
				</div>
			</div>
		</div>
		<div id="fondoAlerta" class="fondoFormularios">
			<div class="contenedorFormulario alerta">
				<div class="claseFormulario" id="formularioAlerta">
					<div class="tituloFormulario">
						Aviso
					</div>
					<div class="cuerpoFormulario">
						<p></p>
					</div>
					<div class="botonesFormulario">
						<button type="button" class="cancelarAlerta">Aceptar</div>
					</div>
				</div>
			</div>
		</div>
		<div id="contenedorCargaAjax">
			<div id="spinnerCargaAjax">
		</div>
    </div>
	</body>
</html>
<?php
}
?>