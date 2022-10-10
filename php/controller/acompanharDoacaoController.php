<?php
require_once ("../model/Doacao.php");

$op = $_POST['op'];
$idDoacao = $_POST['idDoacao'];

if($op == "confirmarPagamento"){
	$resultado = Doacao::confirmarPagamento($idDoacao);
	if($resultado){
		echo 'Pagamento confirmado';
	}else{
		echo 'Ocorreu um erro ao alterar confirmar o pagamento';
		http_response_code(500);	
	}

} else if ($op == "rejeitarPagamento"){
	$quantidade = $_POST['quantidade'];
	$idProduto = $_POST['idProduto'];
	$idOng = $_POST['idOng'];
	$resultado = Doacao::rejeitarPagamento($idDoacao,$idProduto,$idOng,$quantidade);
	if($resultado){
		echo 'Foi registrado que o doador não efetuou o pagamento';
	}else{
		echo 'Ocorreu um erro ao registrar que o doador não efetuou o pagamento';
	}

}else if($op == "concluirDoacao"){
	$resultado = Doacao::concluirDoacao($idDoacao);
	if($resultado){
		echo 'A doação foi concluída!';
	}else{
		echo 'Ocorreu um erro ao registrar a conclusão da doação';
		http_response_code(500);	
	}

}

?>
