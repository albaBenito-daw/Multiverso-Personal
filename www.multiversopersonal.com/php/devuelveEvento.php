<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
if(isset($_SESSION["usuario"]) && isset($_POST["idEvento"])){
	$usuarioId = $_SESSION["usuario"][0];
	$idEvento = intval($_POST["idEvento"]);
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$consultaEvento = $db->consulta("
		select eventId, eventTitle, eventDescription, eventColor, eventDate 
		from eventos
		where userId = ? and eventId = ? 
	",[$usuarioId,$idEvento]);
	
	$devuelveEvento = $db->devuelve($consultaEvento);
	
	$arrayAuxiliar = [
		$devuelveEvento["eventId"],
		$devuelveEvento["eventTitle"],
		$devuelveEvento["eventDescription"],
		$devuelveEvento["eventColor"],
		$devuelveEvento["eventDate"]
	];
	
	echo json_encode($arrayAuxiliar);
}
