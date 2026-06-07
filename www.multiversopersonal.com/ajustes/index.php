<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
if(!isset($_SESSION["usuario"])){
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
			<div class="cuerpoSubpagina">
				<div class="rivete sup"></div>
				<div class="tituloSubpagina">
					<h1>Ajustes de Usuario</h1>
				</div>
				<div id="cuerpoAjustes" class="cuerpoFormulario contenidoSubpagina">
					<input type="text" id="cambioNombre" name="cambioNombre" placeholder="Cambiar nombre de Usuario" maxlength="30">
					<input type="password" id="cambioContrasena" name="cambioContrasena" placeholder="Cambiar Contraseña" maxlength="20">
					<input type="password" id="RepCambioContrasena" name="RepCambioContrasena" placeholder="Repetir Contraseña" maxlength="20">
				</div>	
				<div class="botonesFormulario botonesAjustes">
					<button type="button" id="cerrarSesion">Cerrar Sesión</button>
					<button type="button" id="guardarCambios">Guardar Cambios</button>
				</div>
				<button type="button" id="botonCasa"></button>
			</div>
			<div class="rivete inf"></div>
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
