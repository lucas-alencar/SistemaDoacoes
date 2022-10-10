<?php
	session_start(); 
	require_once ("../model/Produto.php");
	if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "ONG"){
		header("Location:login.php");
	}

	// Doctype, head, meta e header HTML
	require_once("template.php");
	require_once("header.php");
	echo $headHTML;
	echo $headerHTML;

	echo '<main>';

	echo '
		<section class="form-container">
			<form method="POST" id="formProduto">
				<p id="mensagem"></p>
				<label>Nome do produto:</label><input type="text" name="nome" id="nome" required><br>
				<label>Imagem:</label><input type="text" name="imagem" id="imagem"><br>
				<input type="submit" class="default-button" value="Cadastrar" id="cadastrar" name="cadastrar">
			</form>
		</section>
	';

	echo '<section class="listagem">';
		echo '<h3>Visualizar/Editar produtos</h3>';
		echo '<p id="mensagem2"></p>';
			echo '<section class="form-container">';
				echo '<form method="POST" id="editarProduto">';
					echo '<ul class="lista" id="lista">';

	$resultado = Produto::listarTodos();

	foreach($resultado as $res){
						echo '<li class = "elementoLista" id="'.$res->idProduto.'">';
							echo '<input type="text" name="nomeedit" value="'.$res->nome.'" required> ';
							echo '<input class="imagemEdit" type="text" name="imagemedit" value="'.$res->imagem.'">';
							echo '<input class="list-button" type="submit" value="Editar" name="editar">';
							echo '<input class="list-button" type="submit" value="Remover" name="remover">';
						echo '</li>';
	}
					echo '</ul>';
				echo '</form>';
			echo '</section>';
	echo '</section>';

	echo '
		</main> 
		<script src="../../javascript/formularioProduto.js"></script>
	';

	echo $endHTML;	
?>
