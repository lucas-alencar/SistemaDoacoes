<?php
require_once ("../model/Usuario.php");
require_once ("../model/Fornecedor.php");
require_once ("../model/Produto.php");
require_once ("../model/Fornecedor_has_Produto.php");

$op = $_POST['op'];

if($op == "editar"){

	$idProduto = $_POST['idProduto'];
	$idFornecedor = $_POST['idFornecedor'];
	$valor = $_POST['valor'];

	$resultado = Fornecedor_has_Produto::editar($idFornecedor, $idProduto, $valor);
	if($resultado){
		echo 'Valor alterado com sucesso';
	}else{
		echo 'Ocorreu um erro ao alterar o valor';
	}

}else if ($op == "remover"){
	$idProduto = $_POST['idProduto'];
	$idFornecedor = $_POST['idFornecedor'];

	$resultado = Fornecedor_has_Produto::remover($idFornecedor, $idProduto);
	if($resultado){
		echo 'Produto removido com sucesso.';
	}else{
		http_response_code(500);
		echo 'Ocorreu um erro ao desvincular o fornecedor.';
	}

}else if($op == "fornecer"){
	$idProduto = $_POST['idProduto'];
	$idFornecedor = $_POST['idFornecedor'];
	$valor = $_POST['valor'];

	var_dump($idProduto);
	var_dump($idFornecedor);
	var_dump($valor);

	$resultado = Fornecedor_has_Produto::salvar($idFornecedor, $idProduto, $valor);
	if($resultado){
		echo 'Produto cadastrado com sucesso.';
	}else{
		http_response_code(500);
		echo 'Ocorreu um erro ao cadastrar o produto.';
	}

}
?>
