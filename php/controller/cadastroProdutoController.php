<?php
session_start(); 
require_once ("../model/Produto.php");

if(is_null($_SESSION["tipo"]) || empty($_SESSION["tipo"]) || $_SESSION["tipo"] == "DOADOR"){
	header("Location:../view/login.php");	
} else{
	$op = $_POST['op'];
	

	if($op == "cadastrar"){
	
		$nome = $_POST['nome'];
		$imagem = $_POST['imagem'];
		$novoObjeto = new Produto([$nome,$imagem]);
		$resultado = $novoObjeto->salvar();
		
		if($resultado){
			echo 'Produto cadastrado com sucesso!';
		}else{
			echo 'O produto já existe';
		}
	}else if($op == "editar" || $op == "remover"){
		$idProduto = $_POST['idProduto'];
		$nome = $_POST['nome'];
		$imagem = $_POST['imagem'];
		$novoObjeto = new Produto([$nome,$imagem]);
		$novoObjeto->idProduto = $idProduto;

		if($op == "editar"){
			$resultado = $novoObjeto->editar();
			if($resultado){
				echo 'Produto editado com sucesso!';
			}else{
				echo 'Ocorreu um erro ao editar o produto. Já existe um produto com esse nome';
			}

		}else if($op == "remover"){
			
			$resultado = $novoObjeto->remover();
			if($resultado){
				echo 'Produto removido com sucesso!';
			}else{
				echo 'O produto não pode ser removido pois faz parte de registros que não podem ser excluídos';
			}
			
		}

	}
	
}

?>
