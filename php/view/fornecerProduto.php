<?php
	session_start(); 
	require_once ("../model/Fornecedor.php");
	require_once ("../model/Produto.php");
	require_once ("../model/Fornecedor_has_Produto.php");
	if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "FORNECEDOR"){
		header("Location:index.php");
	}

	// Doctype, head, meta e header HTML
	require_once("template.php");
	require_once("header.php");
	echo $headHTML;
	echo $headerHTML;

	echo '<main>';
	echo '<section>';

		$resultado = Fornecedor_has_Produto::listarProdutosFornecidos($_SESSION["idUsuario"]);
		
		echo '<h3>Produtos fornecidos</h3>';
		if(!empty($resultado)){
			//PRODUTOS FORNECIDOS
			echo '<section class="listagem">';		
			echo '<p id="mensagem"></p>';
				echo '<section class="form-container">';
					echo '<form method="POST" id="produtosFornecidosForm">';
						echo '<input type="hidden" id="idFornecedor" name="idFornecedor" value="'.$_SESSION["idUsuario"].'">';
						echo '<ul class="lista" id="lista1">';

			foreach($resultado as $res){
								echo '<li class = "elementoLista" id="'.$res->produto->idProduto.'">';
									echo '<p>'.$res->produto->nome.'</p>';
									if(isset($res->valor)) echo '<input class="produto-quantidade" placeholder="Preço" type="number" step="0.01" min=0 id="valorcadastrado" name="valorcadastrado" value="'.$res->valor.'" >';
									echo '<input class="list-button" type="submit"  value="Editar" name="editar">';
									echo '<input class="list-button" type="submit"  value="Remover" name="remover">';	
								echo '</li>';
			}
							echo '</ul>';
						echo '</form>';
					echo '</section>';
			echo '</section>';
		}

		$resultado2 =  Fornecedor_has_Produto::listarProdutosNaoFornecidos($_SESSION["idUsuario"]);

		echo '<h3>Produtos não fornecidos</h3>';
		if(!empty($resultado2)){
			//PRODUTOS NÃO FORNECIDOS
			echo '<section class="listagem">';			
				echo '<p id="mensagem2"></p>';
					echo '<section class="form-container">';
						echo '<form method="POST" id="produtosNaoFornecidosForm">';
							echo '<input type="hidden" id="idFornecedor2" name="idFornecedor2" value="'.$_SESSION["idUsuario"].'">';
							echo '<ul class="lista" id="lista2">';


			foreach($resultado2 as $res){
								echo '<li class = "elementoLista dado-produto" id="'.$res->produto->idProduto.'">';
									echo '<p>'.$res->produto->nome.'</p>';
									echo '<input class="produto-quantidade" placeholder="Preço" type="number" step="0.01" min=0 name="valoracadastrar">';
									echo '<input class="list-button" type="submit" value="Fornecer" name="fornecer">';	
								echo '</li>';
			}
							echo '</ul>';
						echo '</form>';
					echo '</section>';
			echo '</section>';
		}
	
	echo '</section>';
	echo '
		</main> 
		<script src="../../javascript/fornecerProduto.js"></script>
	';

	echo $endHTML;	
?>
