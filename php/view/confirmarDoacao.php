<?php
session_start(); 

require_once("../model/Doacao.php");
require_once("../model/Pix.php");
require_once("template.php");
require_once("header.php");

$doacao = $_SESSION["doacao"]; //os dados que tão vindo do index tão sendo salvos aqui, é um array!
unset($_SESSION["doacao"]);

$dados = [1,4];
if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "doador"){
	//header("Location:login.php");
}

	// Doctype, head, meta e header HTML
	
	echo $headHTML;
	echo $headerHTML;

	echo '<main>';

	echo '<section class="listagem">';
		echo '<h3>Confirmar Doação</h3>';
		echo '<p id="mensagem2"></p>';
			echo '<section class="form-container">';
				echo '<form method="POST" id="confirmarDoacaoUsr">';
					echo'<br>';
					echo 'Você está doando '.$doacao[3]. ' '.$doacao[6].'<br>';
					echo ' valor total da doação R$'. $doacao[5];

				echo '<br>';
				echo '<h4>Dados do pix disponíveis</h4>';
					$lista = Pix::listarTodosOng($doacao[1]);

					if(!empty($lista)){
						foreach($lista as $pix){
							echo $pix->pix;
							
						}
					}
					echo '<br>';
					echo '<img width=300px align="center" height= 300px src="../../img/qrcode.png">';
					echo '<input type="submit" class="default-button" class="default-button" value="Confirmar Doação" id="entrar" name="entrar">	';
					echo '<input type="hidden" id="idDoador" value="'.$doacao[0].'"">';
					echo '<input type="hidden" id="idOng" value="'.$doacao[1].'"">';
					echo '<input type="hidden" id="idProduto" value="'.$doacao[2].'"">';
					echo '<input type="hidden" id="qtdProduto" value="'.$doacao[3].'"">';
					echo '<input type="hidden" id="idRefeicao" value="'.$doacao[4].'"">';
					echo '<input type="hidden" id="valor" value="'.$doacao[5].'"">';
				echo '</form>';
			echo '</section>';
	echo '</section>';

	echo '
		<script src="../../javascript/confirmarDoacaoUsr.js"></script>
		</main> 
	';

	echo $endHTML;	
?>
