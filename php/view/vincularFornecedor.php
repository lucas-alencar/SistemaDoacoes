<?php
	session_start(); 
	require_once ("../model/Fornecedor.php");
	if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "ONG"){
		header("Location:index.php");
	}

	// Doctype, head, meta e header HTML
	require_once("template.php");
	require_once("header.php");
	echo $headHTML;
	echo $headerHTML;

	echo '<main>';

	echo '<section>';
		echo '<h3>Fornecedores vinculados</h3>';
		
			//FORNECEDORES VINCULADOS
			echo '<section class="listagem">';		
			echo '<p id="mensagem"></p>';
				echo '<section class="form-container">';
					echo '<form method="POST" id="fornecedorVinculadoForm">';
						echo '<input type="hidden" id="idOngDesvincular" name="idOngDesvincular" value="'.$_SESSION["idUsuario"].'">';
						echo '<ul class="lista" id="lista1">';
						$resultado = Fornecedor::listarFornecedoresOng($_SESSION["idUsuario"]);
						if(!empty($resultado)){
											
							foreach($resultado as $res){
												echo '<li class="elementoLista dado-fornecedor" id="'.$res->idUsuario.'">';
													echo '<p>'.$res->nome.'-';
													if(isset($res->telefone)) echo $res->telefone.'</p>';
													echo ' <input class="list-button" type="submit" value="Desvincular" name="desvincular">';
														
												echo '</li>';
							}

						}
						echo '</ul>';
						echo '</form>';
					echo '</section>';
			echo '</section>';

		$resultado2 = Fornecedor::listarNaoFornecedoresOng($_SESSION["idUsuario"]);

		echo '<h3>Fornecedores não vinculados</h3>';
		
			//FORNECEDORES NÃO VINCULADOS
			echo '<section class="listagem">';			
				echo '<p id="mensagem2"></p>';
					echo '<section class="form-container">';
						echo '<form method="POST" id="fornecedorNaoVinculadoForm">';
							echo '<input type="hidden" id="idOngVincular" name="idOngVincular" value="'.$_SESSION["idUsuario"].'">';
							echo '<ul class="lista" id="lista2">';
							$resultado2 = Fornecedor::listarNaoFornecedoresOng($_SESSION["idUsuario"]);
							if(!empty($resultado2)){


								foreach($resultado2 as $res){
													echo '<li class="elementoLista dado-fornecedor" id="'.$res->idUsuario.'">';
														echo '<p>'.$res->nome.'-';
														if(isset($res->telefone)) echo $res->telefone.'</p>';
														echo ' <input class="list-button" type="submit" value="Vincular" name="vincular">';
															
													echo '</li>';
								}
												
						}
						echo '</ul>';
					echo '</form>';
				echo '</section>';
		echo '</section>';
	echo '</section>';

	echo '
		</main> 
		<script src="../../javascript/vincularFornecedor.js"></script>
	';

	echo $endHTML;	
?>
