<?php
session_start(); 
require_once ("../model/Usuario.php");
require_once ("../model/Pix.php");

if(empty($_SESSION["idUsuario"]) ){
	header("Location:../view/login.php");	
} else{
	$op = $_POST['op'];

	if($op == "editar" || $op == "remover"){
	
		$idUsuario = $_POST['idUsuario'];
		$login = $_POST['login'];
		$nome = $_POST['nome'];
		$senha = MD5($_POST['senha']);
		$telefone = $_POST['telefone'];
		

		$novoObjeto = new Usuario([$login,$nome,$senha,$telefone, $_SESSION["tipo"]]);
		$novoObjeto->idUsuario = $idUsuario;

		if($op == "editar"){
			$resultado = $novoObjeto->editar();
			if($resultado){
				echo 'Informações editadas com sucesso!';
				$_SESSION["nome"] = $nome;

			}else{
				echo 'Ocorreu um erro ao editar as informações. Já existe um outro usuário com esse login';
			}

		}else if($op == "remover"){
			
			$resultado = $novoObjeto->remover();
			if($resultado){
				echo 'Conta excluída com sucesso!';
				unset($_SESSION["idUsuario"]);
				unset($_SESSION["tipo"]);
				unset($_SESSION["nome"]);
			}else{
				echo 'Ocorreu um erro. Tente novamente';
			}
			
		}
	}else if($op == "cadastrarpix" || $op == "removerpix"){
		
		$pix = $_POST['pix'];
		$novoObjeto = new Pix([$pix,$_SESSION["idUsuario"]]);

		if($op == "cadastrarpix"){
			
			$resultado = $novoObjeto->salvar();
			if($resultado){
				echo 'Pix cadastrado com sucesso!';
			}else{
				echo 'Ocorreu um problema ao salvar a chave pix:(';
			}
		}else if($op == "removerpix"){
			$resultado = $novoObjeto->remover();
			if($resultado){
				echo 'Pix removida com sucesso!';
			}else{
				echo 'Ocorreu um problema ao remover a chave pix.';
			}
		}

	}
	
}

?>
