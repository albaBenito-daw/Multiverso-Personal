<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(isset($_SESSION["usuario"]) && isset($_POST["cambioNombre"]) && isset($_POST["cambioContrasena"])){
	$cambioNombre = $_POST["cambioNombre"];
	$cambioContrasena = $_POST["cambioContrasena"];
	
	$contrasenaEncriptada = password_hash($cambioContrasena,PASSWORD_DEFAULT);

	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$arrayAuxiliar = [1,"No se han realizado cambios.::......::"];
	
	if($cambioNombre != ""){
		$db->consulta("
			update usuarios
			set userName = ?
			where userId = ?;
		",[$cambioNombre,$_SESSION["usuario"][0]]);
		
		$_SESSION["usuario"][1] = $cambioNombre;
		
		$arrayAuxiliar = [1,"Cambios realizados.::......::"];
	}
	
	if($cambioContrasena != ""){
		$db->consulta("
			update usuarios
			set userPassword = ?
			where userId = ?;
		",[$contrasenaEncriptada,$_SESSION["usuario"][0]]);
		
		$arrayAuxiliar = [1,"Cambios realizados.::......::"];
	}
	
	echo json_encode($arrayAuxiliar);
	
}