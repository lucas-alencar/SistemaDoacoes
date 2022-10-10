<?php
require_once ("../model/Doacao.php");

$idFornecedor = $_POST['idFornecedor'];
$idDoacao = $_POST['idDoacao'];

$resultado = Doacao::atenderDoacao($idDoacao,$idFornecedor);

if($resultado){
	echo 'Status alterado com sucesso';
}else{
	echo 'Ocorreu um erro ao alterar o status.';
	http_response_code(500);
	
}

?>
