<?php
session_start(); 

    // Doctype, head, meta e header HTML
    
    require_once("../model/Refeicao.php");
    require_once ("../model/Produto.php");
    require_once("template.php");
    require_once("header.php");
    if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "ONG"){
		header("Location:login.php");
	}
    echo $headHTML;
    echo $headerHTML;

    echo '<main>';

    echo '
        <section class="form-container">
            <h3>Cadastrar nova refeição:</h3>
            <form method="POST" id="formRefeicao">
                <p id="mensagem"></p>
                <input type="hidden" id="idOng" name="idOng" value="'.$_SESSION["idUsuario"].'">           
                <label for="data">Insira a data da nova refeição</label><br/>
                <input name="data" type="date" id="data" required><br>
                <ul class="lista" id="lista1">';

                $resultado = Produto::listarTodosFornecidos($_SESSION["idUsuario"]);

                foreach($resultado as $res){
						echo '<li class="elementoLista dado-produto" id="'.$res->idProduto.'">';
							echo '<p>'.$res->nome.'</p>';
                            echo '<input class="produto-quantidade" placeholder="Quantidade" type="number" step="1" min=0 name="quantidade">';
                            echo '<input class="check" type="checkbox" value="Selecionar produto" />';
						echo '</li>';
	            }
					echo '</ul>';
                echo '<input type="submit" class="default-button" id="cadastrar" value="Cadastrar" name="cadastrar">';
				echo '</form>';
	echo '</section>';

    // LISTAGEM PARA EDIÇÃO
    echo '<section class="listagem">';
		echo '<h3>Visualizar/Editar Refeições</h3>';
		echo '<p id="mensagem2"></p>';
			echo '<section>';
				echo '<form method="POST" id="editarRefeicao">';
					echo '<ul class="lista lista-refeicoes" id="lista2">';

	$resultado2 = Refeicao::listarRefeicaoOngAtuais($_SESSION["idUsuario"]);

    if(!empty($resultado2)){
        foreach($resultado2 as $res){
                            echo '<li class = "elementoLista" id="'.$res->idRefeicao.'">';
                            
                                echo 'Refeição: '.$res->idRefeicao.' - '. $res->data ;
                                echo '<ul> <br>';

                                foreach($res->produtos as $prodRef){
                                        echo '<li>'.$prodRef[0]->nome;
                                        echo ' - Meta: '.$prodRef[2].'/'.$prodRef[1];
                                        echo'</li>';
                                }
                                echo '<li>';                                   
                                    echo '<input class="list-button" type="submit"  value="Remover Refeição" name="remover">';
                                    echo '<input type="hidden"  value="'.$res->idRefeicao.'" name="idRefeicao">';
                                echo '</li>';
                                echo '</ul>';
                                
                            echo '</li>';
        }
    }
					echo '</ul>';
				echo '</form>';
			echo '</section>';
	echo '</section>';

    echo '
        </main> 
        <script src="../../javascript/formularioRefeicao.js"></script>
    ';
    echo $endHTML;	
?>