<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(isset($_SESSION["usuario"]) && isset($_POST["idNota"])){
	$usuarioId = $_SESSION["usuario"][0];
	$idNota = $_POST["idNota"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$db->consulta("
		delete from notas
		where userId = ? and notesId = ?;
	",[$usuarioId,$idNota]);
	
	$arrayAuxiliar = [1,"Nota borrada con éxito.::......::"];
	
	echo json_encode($arrayAuxiliar);
}