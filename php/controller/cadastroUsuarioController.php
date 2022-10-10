<?php
require_once ("../model/Usuario.php");

$login = $_POST['login'];
$nome = $_POST['nome'];
$senha = MD5($_POST['senha']);
$telefone = $_POST['telefone'];
$tipo = $_POST['tipo'];

$novoObjeto = new Usuario([$login,$nome,$senha,$telefone,$tipo]);
$resultado = $novoObjeto->salvar();
if($resultado){
	echo 'Usuário cadastrado com sucesso.';
}else{
	echo 'Já existe usuário com esse login.';
	http_response_code(500);
	
}
echo'<script>window.location.href = "../view/login.php"</script>';
?>
