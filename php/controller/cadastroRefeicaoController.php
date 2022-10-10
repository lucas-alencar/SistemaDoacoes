<?php
session_start(); 
require_once ("../model/Refeicao.php");

$op = $_POST['op'];

if($op=="cadastrar"){
	$data = $_POST['dataref'];
	$idOng = $_POST['idOng'];
	$produtos = $_POST['produtosEscolhidos'];

	$novoObjeto = new Refeicao();
	$novoObjeto->data = $data;
	$novoObjeto->ong= $idOng;
	$novoObjeto->produtos = $produtos;
	
	$resultado = $novoObjeto->salvar();

	if($resultado){
		echo 'Refeição cadastrada com sucesso.';
	}else{
		echo 'Ocorreu um problema ao cadastrar a refeição';
		http_response_code(500);		
	}

}else if($op=="remover"){
	$idRefeicao = $_POST['idRefeicao'];

	$resultado = Refeicao::remover($idRefeicao);

	if($resultado){
		echo 'Refeição removida com sucesso.';
	}else{
		echo 'Ocorreu um problema ao remover a refeição';
		http_response_code(500);		
	}

}


?>
