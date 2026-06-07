<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(
	isset($_SESSION["usuario"]) &&
	isset($_POST["tituloEvento"]) &&
	isset($_POST["descripcionEvento"]) &&
	isset($_POST["fechaEvento"]) &&
	isset($_POST["colorEvento"])
){
	$usuarioId = $_SESSION["usuario"][0];
	$tituloEvento = $_POST["tituloEvento"];
	$descripcionEvento = $_POST["descripcionEvento"];
	$fechaEvento = $_POST["fechaEvento"];
	$colorEvento = $_POST["colorEvento"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$db->consulta("
		insert into eventos (eventTitle, eventDescription, eventDate, eventColor, userId)
		values (?,?,?,?,?);
	",[$tituloEvento,$descripcionEvento,$fechaEvento,$colorEvento,$usuarioId]);
	
	$arrayAuxiliar = [1,"Evento creado con éxito.::......::"];
	
	echo json_encode($arrayAuxiliar);
}