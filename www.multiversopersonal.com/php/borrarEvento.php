<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(isset($_SESSION["usuario"]) && isset($_POST["idEvento"])){
	$usuarioId = $_SESSION["usuario"][0];
	$idEvento = $_POST["idEvento"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$db->consulta("
		delete from eventos
		where userId = ? and eventId = ?;
	",[$usuarioId,$idEvento]);
	
	$arrayAuxiliar = [1,"Evento borrado con éxito.::......::"];
	
	echo json_encode($arrayAuxiliar);
}