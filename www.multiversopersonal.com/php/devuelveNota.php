<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
if(isset($_SESSION["usuario"]) && isset($_POST["idNota"])){
	$usuarioId = $_SESSION["usuario"][0];
	$idNota = intval($_POST["idNota"]);
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$consultaNota = $db->consulta("
		select notesId , notesTitle, notesContent
		from notas
		where userId = ? and notesId = ? 
	",[$usuarioId,$idNota]);
	
	$devuelveNota = $db->devuelve($consultaNota);
	
	$arrayAuxiliar = [
		$devuelveNota["notesId"],
		$devuelveNota["notesTitle"],
		$devuelveNota["notesContent"],
	];
	
	echo json_encode($arrayAuxiliar);
}
