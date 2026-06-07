<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(isset($_SESSION["usuario"]) && isset($_POST["idImagen"])){
	$usuarioId = $_SESSION["usuario"][0];
	$idImagen = $_POST["idImagen"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$consultaImagen = $db->consulta("
		select imagePath
		from imagenes
		where userId = ? and imageId = ?;
	",[$usuarioId,$idImagen]);
	
	$devuelveImagen = $db->devuelve($consultaImagen);
	
	$arrayAuxiliar = [];
	if($db->lineas($consultaImagen) > 0){
		$db->consulta("
			delete from imagenes
			where userId = ? and imageId = ?;
		",[$usuarioId,$idImagen]);
		
		unlink("../uploads/".$devuelveImagen["imagePath"]);
	
		$arrayAuxiliar = [1,"Imagen borrada con éxito.::......::"];
	}
	else{
		$arrayAuxiliar = [0,"Ha habído algún error.::......::"];
	}
	echo json_encode($arrayAuxiliar);
}