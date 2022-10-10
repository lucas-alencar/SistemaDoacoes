<?php
require_once ("../model/Usuario.php");
require_once ("../model/Fornecedor.php");

$idOng = $_POST['idOng'];
$idFornecedor = $_POST['idFornecedor'];
$op = $_POST['op'];

if($op == "vincular"){
	$resultado = Fornecedor::vincular($idOng, $idFornecedor);
	if($resultado){
		echo 'Fornecedor vinculado com sucesso.';
	}else{
		http_response_code(500);
		echo 'Ocorreu um erro ao vincular o fornecedor.';
	}

}else if ($op == "desvincular"){
	$resultado = Fornecedor::desvincular($idOng, $idFornecedor);
	if($resultado){
		echo 'Fornecedor desvinculado com sucesso.';
	}else{
		http_response_code(500);
		echo 'Ocorreu um erro ao desvincular o fornecedor.';
	}

}
?>
