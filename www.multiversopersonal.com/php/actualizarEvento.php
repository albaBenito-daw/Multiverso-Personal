<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(
	isset($_SESSION["usuario"]) &&
	isset($_POST["idEvento"]) &&
	isset($_POST["tituloEvento"]) &&
	isset($_POST["descripcionEvento"]) &&
	isset($_POST["fechaEvento"]) &&
	isset($_POST["colorEvento"])
){
	$usuarioId = $_SESSION["usuario"][0];
	$idEvento = intval($_POST["idEvento"]);
	$tituloEvento = $_POST["tituloEvento"];
	$descripcionEvento = $_POST["descripcionEvento"];
	$fechaEvento = $_POST["fechaEvento"];
	$colorEvento = $_POST["colorEvento"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$consultaEventos = $db->consulta("
		update eventos
		set eventTitle = ?, eventDescription = ?, eventColor = ?, eventDate = ?
		where userId = ? and eventId = ?;
	",[$tituloEvento,$descripcionEvento,$colorEvento,$fechaEvento,$usuarioId,$idEvento]);
	
	$arrayAuxiliar = [1,"Evento modificado con exito.::......::"];
	
	echo json_encode($arrayAuxiliar);
}