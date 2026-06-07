<?php
/*
	Desarrollado por
	
	Alba Benito Aliste
	
	alba_benali@hotmail.com
*/
session_start();

if(isset($_SESSION["usuario"])){
	unset($_SESSION["usuario"]);
	echo json_encode([1]);
}