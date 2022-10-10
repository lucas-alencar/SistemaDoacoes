<?php
	session_start(); 
	require_once ("../model/Usuario.php");
	require_once ("../model/Pix.php");

	if(empty($_SESSION["idUsuario"]) ){
		header("Location:login.php");
	}

	// Doctype, head, meta e header HTML
	require_once("template.php");
	require_once("header.php");	
	echo $headHTML;
	echo $headerHTML;

	$res = Usuario::getObjetoPorId($_SESSION["idUsuario"]);

	echo '<main>';
	echo 	'<section class="form-container">';
	echo '<h4>Editar Informações de Usuário:</h4>';
	echo 		'<form method="POST" id="editarUsuario">';
	echo 			'<p id="mensagem"></p>';
	echo 			'<input type="hidden" id="idUsuario" name="idUsuario" value="'.$res->idUsuario.'">';
	echo 			'<label>Login:</label><input type="text" name="login" id="login" value="'.$res->login.'"required><br>';
	echo 			'<label>Senha:</label><input type="password" name="senha" id="senha"><br>';
	echo 			'<label>Nome:</label><input type="text" name="nome" id="nome"  value="'.$res->nome.'"required><br>';
	echo 			'<label>Telefone:</label><input type="text" name="telefone" id="telefone" value="'.$res->telefone.'"><br>';
	echo 			'<input type="submit" class="default-button" value="Editar" id="editar" name="editar"><br><br>';
	echo 			'<h4>Exclusão de Conta:</h4>';
	echo 			'<input type="submit" class="default-button" value="Excluir conta" id="remover" name="remover">';
	echo 		'</form>';
	echo 	'<section>';

	if($_SESSION["tipo"] == "ONG"){
		echo '
			<h3>Cadastro de Pix</h3>
			<section class="form-container">
				<form method="POST" id="formPix">
					<p id="mensagempix"></p>
					<label>Chave Pix:</label><input type="text" name="pix" id="pix" required>
					<input type="submit" class="default-button" value="Cadastrar" id="cadastrarpix" name="cadastrarpix">
				</form>
			</section>
		';

		echo '<section class="listagem form-container">';
			echo '<h3>Chaves pix cadastradas</h3>';
			echo '<form method="POST" id="formEditarPix">';
				echo '<p id="mensagempix2"></p>';
				echo '<ul class="lista" id="lista">';

		$resultado = Pix::listarTodosOng($_SESSION["idUsuario"]);

		foreach($resultado as $res){
					echo '<li class="elementoLista dado-pix" id="'.$res->pix.'">';
					echo '<p>'.$res->pix.'</p>';
					echo '<input type="submit" class="list-button" value="Remover" id="removerpix "name="removerpix">';
					echo '</li>';
		}
				echo '</ul>';
			echo '</form>';
		echo '</section>';
	}

	echo ' 
		</main> 
		<script src="../../javascript/editarUsuario.js"></script>
	';

	echo $endHTML;	
?>
