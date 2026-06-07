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
					<h1>Notas</h1>
				</div>
				<div id="cuerpoNotas" class="cuerpoFormulario contenidoSubpagina anchoCompleto">
<?php
require("../php/conexionMySQL.php");
$db = new ConexionMySQL();

$usuarioId = $_SESSION["usuario"][0];

$consultaNotas = $db->consulta("
	select notesId, notesTitle, notesContent
	from notas
	where userId = ?
	order by notesDate desc;
",[$usuarioId]);

if($db->lineas($consultaNotas) > 0){
	while($devuelveNotas = $db->devuelve($consultaNotas)){
		echo "
					<div class=\"contenedorNota\">
						<input type=\"hidden\" value=\"".$devuelveNotas["notesId"]."\" />
						<div class=\"infoNota\">
							<div class=\"tituloNota\">
								".$devuelveNotas["notesTitle"]."
							</div>
							<div class=\"descripcionNota\">
								".nl2br($devuelveNotas["notesContent"])."
							</div>
						</div>
						<button type=\"button\" class=\"borrarNota\">X</button>
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
					<!--PRUEBAS
					<div class="contenedorNota">
						<input type="hidden" value="0" />
						<div class="tituloNota">
							Titulo uno
						</div>
						<div class="descripcionNota">
							Esto es el evento número uno del calendario.
						</div>
					</div>
					<button type="button" class="borrarNota">X</button>
					-->
				</div>
				<button type="button" id="botonCasa"></button>
				<button type="button" class="botonMas" id="crearNota"></button>
			</div>
			<div class="rivete inf"></div>
		</div>
		<div id="fondoFormulario" class="fondoFormularios">
			<div class="contenedorFormulario">
				<div class="claseFormulario" id="formularioGuardarNota">
					<div class="tituloFormulario">
						Crear Nota
					</div>
					<div class="cuerpoFormulario">
						<input type="text" id="tituloNota" name="titulo" placeholder="Título" maxlength="20">
						<textarea id="descripcionNota" placeholder="Descripción" maxlength="2000"></textarea>
					</div>	
					<div class="botonesFormulario">
						<button type="button" class="cancelar">Cancelar</button>
						<button type="button" id="guardarNota">Crear</button>
					</div>
				</div>
				<div class="claseFormulario" id="formularioEditarNota">
					<input type="hidden" value="">
					<div class="tituloFormulario">
						Editar Nota
					</div>
					<div class="cuerpoFormulario">
						<input type="text" id="editarTituloNota" name="titulo" placeholder="Título" maxlength="20">
						<textarea id="editarDescripcionNota" placeholder="Descripción" maxlength="2000"></textarea>
					</div>	
					<div class="botonesFormulario">
						<button type="button" class="cancelar">Cancelar</button>
						<button type="button" id="editarNota">Guardar</button>
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
