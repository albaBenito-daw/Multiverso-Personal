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
					<h1>Armario</h1>
				</div>
				<div id="cuerpoArmario" class="cuerpoFormulario contenidoSubpagina anchoCompleto">
<?php
require("../php/conexionMySQL.php");
$db = new ConexionMySQL();

$usuarioId = $_SESSION["usuario"][0];

$consultaImagenes = $db->consulta("
	select imageId, imageDescription, imagePath
	from imagenes
	where userId = ?
	order by imageDate desc;
",[$usuarioId]);

if($db->lineas($consultaImagenes) > 0){
	while($devuelveImagenes = $db->devuelve($consultaImagenes)){
		echo "
					<div class=\"contenedorImagen\">
						<input type=\"hidden\" value=\"".$devuelveImagenes["imageId"]."\">
						<img src=\"../uploads/".$devuelveImagenes["imagePath"]."\" title=\"".$devuelveImagenes["imageDescription"]."\" />
						<button type=\"button\" class=\"borrarImagen\">X</button>
					</div>
		";
	}
}
else{
	echo "
					<div class=\"vacio\">Todavía no hay contenido en este área.</div>
	";
}
?>
				</div>
				<button type="button" id="botonCasa"></button>
				<button type="button" class="botonMas" id="crearImagen"></button>
			</div>
			<div class="rivete inf"></div>
		</div>
		<div id="fondoFormulario" class="fondoFormularios">
			<div class="contenedorFormulario">
				<div class="claseFormulario" id="formularioGuardarImagen">
					<div class="tituloFormulario">
						Guardar Imagen
					</div>
					<div class="cuerpoFormulario">
						<textarea id="descripcionImagen" placeholder="Descripción" maxlength="300"></textarea>
						<input type="file" id="imagenArmario" accept="image/jpeg" max-size="10485760">
					</div>	
					<div class="botonesFormulario">
						<button type="button" class="cancelar">Cancelar</button>
						<button type="button" id="guardarImagen">Guardar</button>
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
		<div id="contenedorImagenGrande">
			<img src="" title="" />
			<button type="button" id="cerrarImagenGrande">X</button>
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
