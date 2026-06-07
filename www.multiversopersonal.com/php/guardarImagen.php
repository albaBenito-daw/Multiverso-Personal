<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
if(
	isset($_SESSION["usuario"]) &&
	isset($_POST["descripcionImagen"]) &&
	isset($_FILES["imagenArmario"])
){
	$usuarioId = $_SESSION["usuario"][0];
	$descripcionImagen = $_POST["descripcionImagen"];
	$imagenArmario = $_FILES["imagenArmario"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	//Cargar la imagen
	$imagenSubida = imagecreatefromstring(file_get_contents($imagenArmario["tmp_name"]));

	//Corregir la orientación
	$datosImagen = @exif_read_data($imagenArmario["tmp_name"]);

	if(!empty($datosImagen["Orientation"])){
		switch ($datosImagen["Orientation"]) {
			case 3:
				$imagenSubida = imagerotate($imagenSubida, 180, 0);
				break;
			case 6:
				$imagenSubida = imagerotate($imagenSubida, -90, 0);
				break;
			case 8:
				$imagenSubida = imagerotate($imagenSubida, 90, 0);
				break;
		}
	}

	//Tamaño al subir
	$anchoSubida = imagesx($imagenSubida);
	$altoSubida = imagesy($imagenSubida);

	//Dimensiones máximas
	$anchoMaximo = 800;
	$altoMaximo = 800;

	//Proporción
	$proporcion = min(1, $anchoMaximo / $anchoSubida, $altoMaximo / $altoSubida);

	//Nuevo tamaño
	$anchoNuevo = intval($anchoSubida * $proporcion);
	$altoNuevo = intval($altoSubida * $proporcion);

	//Redimensionar
	$imagenRedimensionada = imagecreatetruecolor($anchoNuevo, $altoNuevo);

	imagecopyresampled(
		$imagenRedimensionada,
		$imagenSubida,
		0, 0, 0, 0,
		$anchoNuevo,
		$altoNuevo,
		$anchoSubida,
		$altoSubida
	);

	//Nombre aleatorio para evitar coincidencias
	$nombreImagen = bin2hex(random_bytes(20)) . ".jpg";

	//Guardar
	imagejpeg($imagenRedimensionada, "../uploads/" . $nombreImagen, 96);

	//Liberar memoria
	imagedestroy($imagenSubida);
	imagedestroy($imagenRedimensionada);
	
	$db->consulta("
		insert into imagenes (imageDescription, imagePath, userId)
		values (?,?,?);
	",[$descripcionImagen,$nombreImagen,$usuarioId]);
	
	$arrayAuxiliar = [1,"Imagen guardada con exito.::......::"];
	
	echo json_encode($arrayAuxiliar);
}