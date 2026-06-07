<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(isset($_SESSION["usuario"]) && isset($_POST["fechaDia"])){
	$usuarioId = $_SESSION["usuario"][0];
	$fechaDia = $_POST["fechaDia"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$consultaEventos = $db->consulta("
		select eventId, eventTitle, eventDescription, eventColor, date_format(eventDate, '%H:%i') as eventDate 
		from eventos
		where date(eventDate) = ? and userId = ?
		order by eventDate asc;
	",[$fechaDia,$usuarioId]);
	
	$arrayAuxiliar = [];
	while($devuelveEventos = $db->devuelve($consultaEventos)){
		 array_push($arrayAuxiliar,[
			$devuelveEventos["eventId"],
			$devuelveEventos["eventTitle"],
			$devuelveEventos["eventDescription"],
			$devuelveEventos["eventColor"],
			$devuelveEventos["eventDate"]
		]);
	}
	
	echo json_encode($arrayAuxiliar);
}