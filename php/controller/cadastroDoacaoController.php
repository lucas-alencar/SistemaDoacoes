<?php
session_start(); 

if(empty($_SESSION["idUsuario"])){
	header("Location:../view/login.php");	
}

$op = $_POST['op'];
$doacao = $_POST['doacao'];

$_SESSION["doacao"] = $doacao;

?>
