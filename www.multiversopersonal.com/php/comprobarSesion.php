<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();
$existeUsuario = 0;
if(isset($_SESSION["usuario"])){
	$existeUsuario = 1;
}
echo json_encode([$existeUsuario]);