<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(isset($_SESSION["usuario"]) && isset($_POST["mesAgenda"]) && isset($_POST["anoAgenda"])){
	$usuarioId = $_SESSION["usuario"][0];
	$mesAgenda = intval($_POST["mesAgenda"])+1;
	$anoAgenda = intval($_POST["anoAgenda"]);
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$consultaEventos = $db->consulta("
		select eventColor, date(eventDate) as eventDate
		from eventos
		where month(eventDate) = ? and year(eventDate) = ? and userId = ?
		order by eventDate asc;
	",[$mesAgenda,$anoAgenda,$usuarioId]);
	
	$arrayAuxiliar = [];
	while($devuelveEventos = $db->devuelve($consultaEventos)){
		 array_push($arrayAuxiliar,[$devuelveEventos["eventDate"],$devuelveEventos["eventColor"]]);
	}
	
	echo json_encode($arrayAuxiliar);
}
