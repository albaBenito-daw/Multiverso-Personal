<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
if(isset($_POST["nombreRegistro"]) && isset($_POST["emailRegistro"]) && isset($_POST["contrasenaRegistro"])){
	$nombreRegistro = $_POST["nombreRegistro"];
	$emailRegistro = $_POST["emailRegistro"];
	$contrasenaRegistro = $_POST["contrasenaRegistro"];
	
	$contrasenaEncriptada = password_hash($contrasenaRegistro,PASSWORD_DEFAULT);
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$validado = true;
	
	$consultaEmail = $db->consulta("
		select userEmail
		from usuarios
		where userEmail like ?
	",[$emailRegistro]);
	
	if($db->lineas($consultaEmail) > 0){
		$validado = false;
	}
	
	$arrayAuxiliar = [];
	
	if($validado){
		$consultaRegistro = $db->consulta("
			insert into usuarios (userName, userEmail, userPassword)
			values (?,?,?);
		",[$nombreRegistro,$emailRegistro,$contrasenaEncriptada]);
		
		$arrayAuxiliar = [1,"Te has registrado correctamente.::......::Acepta para iniciar sesión.::......::"];
	}
	else{
		$arrayAuxiliar = [0,"Ha habido un error.::......::"];
	}
	
	echo json_encode($arrayAuxiliar);
}
