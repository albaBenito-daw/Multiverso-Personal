<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(
	isset($_SESSION["usuario"]) &&
	isset($_POST["tituloNota"]) &&
	isset($_POST["descripcionNota"])
){
	$usuarioId = $_SESSION["usuario"][0];
	$tituloNota = $_POST["tituloNota"];
	$descripcionNota = $_POST["descripcionNota"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$db->consulta("
		insert into notas (notesTitle, notesContent, userId)
		values (?,?,?);
	",[$tituloNota,$descripcionNota,$usuarioId]);
	
	$arrayAuxiliar = [1,"Nota creada con éxito.::......::"];
	
	echo json_encode($arrayAuxiliar);
}