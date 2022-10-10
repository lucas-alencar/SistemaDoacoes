<?php
session_start(); 
    require_once ("../model/Doacao.php");
    // Doctype, head, meta e header HTML
    require_once("template.php");
    require_once("header.php");
    if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "ONG"){
		header("Location:login.php");
	}
    echo $headHTML;
    echo $headerHTML;

    echo '<main>';

    echo '
            <section class="listagem">
            <h3>Doações cadastradas (pendentes de confirmação de pagamento) </h3>
            <form method="POST" id="formDoacaoCadastrada">
                <p id="mensagem1"></p>
                <input type="hidden" id="idOng1" value="'.$_SESSION["idUsuario"].'" name="idOng1">
                <ul class="lista" id="lista1">';

                $resultado = Doacao::listarCadastradas($_SESSION["idUsuario"]);
                if(isset($resultado)){
                    foreach($resultado as $res){
						echo '<li class = "elementoLista" id="'.$res->idDoacao.'">';
                            echo '<p><b>Doação de '.$res->quantidade.' '. $res->produto->nome.'. </b> &nbsp;</p>';
                            echo '<p class="doacao-middle">Doada por '.$res->doador->nome;
                            echo ' com valor de R$ '.$res->valor. ' em '.$res->data. '&nbsp; &nbsp; </p>';
                            echo ' <input class="list-button" type="submit" value="Confirmar Pagamento" name="confirmarPagamento"> ';
                            echo ' <input class="list-button" type="submit" value="Informar não pagamento" name="naoPagou">';
                            echo ' <input type="hidden" value="'.$res->quantidade.'" name="quantidade">';
                            echo ' <input type="hidden" value="'.$res->produto->idProduto.'" name="idProduto">';
                            echo ' <input type="hidden" value="'.$res->ong->idUsuario.'" name="idOng">';
                            
						echo '</li>';
	                }

                }
					echo '</ul>';
                
				echo '</form>';
	echo '</section>';

    echo '
    <section class="listagem">
            <h3>Doações em atendimento pelo fornecedor</h3>
            <form method="POST" id="formDoacaoAtendida">
                <p id="mensagem2"></p>
                <input type="hidden" id="idOng2" value="'.$_SESSION["idUsuario"].'" name="idOng2">
                <ul class="lista" id="lista2">';

                $resultado = Doacao::listarEmAtendimento($_SESSION["idUsuario"]);
                if(isset($resultado)){
                    foreach($resultado as $res){
						echo '<li class = "elementoLista" id="'.$res->idDoacao.'">';
                            echo '<p><b>Doação de '.$res->quantidade.' '. $res->produto->nome.'. </b> &nbsp;</p>';
                            echo '<p class="doacao-middle">Em atendimento por '.$res->fornecedor->nome;
                            echo ' com valor de R$ '.$res->valor. ' em '.$res->data. '&nbsp; &nbsp; </p>';
                            echo ' <input class="list-button" type="submit" value="Confirmar entrega" name="confirmarEntrega">';                            
						echo '</li>';
	                }

                }
					echo '</ul>';
                
				echo '</form>';
	echo '</section>';


    
    echo '
        </main> 
        <script src="../../javascript/acompanharDoacao.js"></script>
    ';
    echo $endHTML;	
?>