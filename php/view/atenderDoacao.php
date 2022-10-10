<?php
session_start(); 
    require_once ("../model/Doacao.php");
    // Doctype, head, meta e header HTML
    require_once("template.php");
    require_once("header.php");
    if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "FORNECEDOR"){
		header("Location:login.php");
	}
    echo $headHTML;
    echo $headerHTML;

    echo '<main>';

    echo '
            <section class="listagem">
            <h3>Doações pendentes de atendimento</h3>
            <form method="POST" id="formAtenderDoacao">
                <p id="mensagem"></p>
                <input type="hidden" id="idFornecedor" value="'.$_SESSION["idUsuario"].'" name="idFornecedor">
                <ul class="lista" id="lista">';

                $resultado = Doacao::listarConfirmadas($_SESSION["idUsuario"]);
                if(!empty($resultado)){

                    foreach($resultado as $res){
                            echo '<li class="elementoLista dado-doacao" id="'.$res->idDoacao.'">';
                                echo '<p><b>Doação de '.$res->quantidade.' '. $res->produto->nome.' </b>';
                                echo 'para a ONG '.$res->ong->nome.' com valor de R$ '.$res->valor. ' em '.$res->data. '</p>';
                                echo ' <input class="list-button" type="submit" value="Atender" name="atender">';
                                
                            echo '</li>';
                    }
                }
					echo '</ul>';
                
				echo '</form>';
	echo '</section>';
    echo '
        </main> 
        <script src="../../javascript/atenderDoacao.js"></script>
    ';
    echo $endHTML;	
?>