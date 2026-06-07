<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
if(isset($_POST["emailUsuario"]) && isset($_POST["contrasenaUsuario"])){
	$emailUsuario = $_POST["emailUsuario"];
	$contrasenaUsuario = $_POST["contrasenaUsuario"];
	
	require("./conexionMySQL.php");
	$db = new ConexionMySQL();
	
	$validado = true;
	
	$consultaUsuario = $db->consulta("
		select userId, userName, userEmail, userPassword
		from usuarios
		where userEmail like ?
	",[$emailUsuario]);
	
	$resultadoUsuario = $db->devuelve($consultaUsuario);
	
	$arrayAuxiliar = [];
	
	if($db->lineas($consultaUsuario) > 0){
		if(password_verify($contrasenaUsuario,$resultadoUsuario["userPassword"])){
			$_SESSION["usuario"] = [intval($resultadoUsuario["userId"]),$resultadoUsuario["userName"]];
			$arrayAuxiliar = [1,"Sesión iniciada con exito.::......::"];
		}
		else{
			$arrayAuxiliar = [0,"El email o la contraseña no coinciden.::......::"];
		}
	}
	else{
		$arrayAuxiliar = [0,"El email o la contraseña no coinciden.::......::"];
	}
	
	echo json_encode($arrayAuxiliar);
}