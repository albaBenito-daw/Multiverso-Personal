<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
header("Content-Type:text/html; charset=UTF-8");
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
		<link rel="icon" href="./img/favicon_32x32.png" sizes="32x32">
		<link rel="icon" href="./img/favicon_192x192.png" sizes="192x192">
		<link rel="apple-touch-icon" href="./img/favicon_180x180.png">
		<meta name="msapplication-TileImage" content="./img/favicon_270x270.png">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="./css/styles.css?v=<?php echo rand(1, 9999);?>"> 
		<script src="./js/script.js?v=<?php echo rand(1, 9999);?>"></script>
	</head>
	<body>
		<div class="cuerpo">
			<div class="rivete sup"></div>
			<div class="cuerpoCentral">
				<div class="titulo">
<?php //El título lo englobamos en un php para poder hacerlo personalizado con el nombre del usuario.
if(!isset($_SESSION["usuario"])){
	echo "
					<h1>Multiverso Personal</h1>	
	";
}
else{
	echo "
					<h1>Multiverso Personal<br><span>de ".$_SESSION["usuario"][1]."</span></h1>	
	";
}
?>
				</div>
				<div id="buttonsCont">
					<button id="agenda"><img src="./img/imgButtonAgenda_150x150.png" alt="gatito dibujando"><span>Agenda</span></button>
					<button id="armario"><img src="./img/imgButtonCloset_150x150.png" alt="gatito sobre ropa"><span>Armario</span></button>
					<button id="notas"><img src="./img/imgButtonNotes_150x150.png" alt="gatito dibujando"><span>Notas</span></button>
					<button id="ajustes"><img src="./img/imgButtonSettings_150x150.png" alt="gatito con ordenador"><span>Ajustes</span></button>
				</div>
			</div>
			<div class="rivete inf"></div>
		</div>
		<!--Esta es la base de todos los formularios que se usarán a lo largo de la aplicación-->
		<div id="fondoFormulario" class="fondoFormularios">
			<div class="contenedorFormulario">
				<div class="claseFormulario" id="formularioInicioSesion">
					<div class="tituloFormulario">
						Inicio de Sesión
					</div>
					<div class="cuerpoFormulario">
						<input type="email" id="emailUsuario" name="email" placeholder="Correo Electrónico" maxlength="255">
						<input type="password" id="contrasenaUsuario" name="contrasena" placeholder="Contraseña" maxlength="20">
					</div>	
					<div class="botonesFormulario">
						<button type="button" class="cancelar">Cancelar</button>
						<button type="button" id="accederUsuario">Acceder</button>
					</div>
					<div class="nuevaCuenta">
						<span id="registrarUsuario">¿No tienes una cuenta?</span>
					</div>
				</div>
				<div class="claseFormulario" id="formularioRegistro">
					<div class="tituloFormulario">
						Registro de usuario
					</div>
					<div class="cuerpoFormulario">
						<input type="text" id="nombreRegistro" name="nombre" placeholder="Nombre usuario" maxlength="30">
						<input type="email" id="emailRegistro" name="email" placeholder="Correo Electrónico" maxlength="255">
						<input type="password" id="contrasenaRegistro" name="contrasena" placeholder="Contraseña" maxlength="20">
						<input type="password" id="confirmarContrasenaRegistro" name="contrasena" placeholder="Repetir contraseña" maxlength="20">
					</div>	
					<div class="botonesFormulario">
						<button type="button" class="cancelar">Cancelar</button>
						<button type="button" id="crearUsuario">Registrar</button>
					</div>
				</div>
			</div>
		</div>
		<!--Esta es la base de todas las alertas que se usarán a lo largo de la aplicación-->
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
		<!--Ventana de carga-->
		<div id="contenedorCargaAjax">
			<div id="spinnerCargaAjax">
		</div>
    </div>
	</body>
</html>