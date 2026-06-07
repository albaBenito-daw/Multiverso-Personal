<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(
	isset($_SESSION["usuario"]) &&
	isset($_POST["idNota"]) &&
	isset($_POST["tituloNota"]) &&
	isset($_POST["descripcionNota"])
){
	$usuarioId = $_SESSION["usuario"][0];
	$idNota = intval($_POST["idNota"]);
	$tituloNota = $_POST["tituloNota"];
	$descripcionNota = $_POST["descripcionNota"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$db->consulta("
		update notas
		set notesTitle = ?, notesContent = ?
		where userId = ? and notesId = ?;
	",[$tituloNota,$descripcionNota,$usuarioId,$idNota]);
	
	$arrayAuxiliar = [1,"Nota modificada con exito.::......::"];
	
	echo json_encode($arrayAuxiliar);
}