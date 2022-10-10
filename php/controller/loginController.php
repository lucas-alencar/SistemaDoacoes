<?php
require_once ("../model/Usuario.php");

$login = $_POST['login'];
$senha = MD5($_POST['senha']);

$resultado = Usuario::validar([$login,$senha]);

if($resultado){
	session_start(); 	
	$_SESSION["nome"]=$resultado->nome; 
	$_SESSION["idUsuario"]=$resultado->idUsuario; 
	$_SESSION["tipo"]= Usuario::tipoUsuario([$resultado->idUsuario]); 
	
	echo 'Login realizado com sucesso' ;

}else{
	echo 'Dados incorretos ou usuário inexistente';
}


?>
