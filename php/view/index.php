<?php
session_start(); 

if(empty($_SESSION["idUsuario"]) || $_SESSION["tipo"] != "DOADOR"){
    header("Location:login.php");
}
    // Doctype, head e meta HTML
    require_once("template.php");
    require_once("header.php");
    require_once("../model/Refeicao.php");
    require_once ("../model/Produto.php");
    require_once ("../model/Usuario.php");
    require_once ("../model/Fornecedor_has_Produto.php");
    echo $headHTML;
    echo $headerHTML;

    echo '<main>';

    echo '
        <section>
        <form method="POST" id="formDoacao">
        <p id="mensagem"></p>
            <h1><i class="fas fa-utensils"></i> Faça já sua doação</h1>
            
            <table id="products-table">
                <tbody> 
                ';

    $resultado = Refeicao::listarRefeicaoAberta();

    if(!empty($resultado)){
        

        foreach($resultado as $res){
            echo '<tr class="linharefeicao">';
                echo '<td>'; 
                    echo $res->ong->nome." em ".$res->data." precisa de: ";
                echo '</td>';
            echo '</tr>';
            foreach($res->produtos as $prodRef){
                echo '<tr class="linhaproduto" id="'.$prodRef[0]->idProduto.'">';
                    echo '<td>';
                    echo ' <img src="'.$prodRef[0]->imagem.'" alt="Alimento"> </img>';
                    echo '</td>';

                    echo '<td>';
                    echo $prodRef[0]->nome;
                    echo '</td>';

                    echo '<td>';
                    $menorpreco = Fornecedor_has_Produto::menorPreco( $prodRef[0]->idProduto, $res->ong->idUsuario);
                    echo 'R$ '.$menorpreco;
                    echo '</td>';

                    echo '<td>';
                    echo $prodRef[2]."/".$prodRef[1];
                    echo '</td>';

                    echo '<td>';
                        echo '<input class="quantity" step="1" min="1" name="quantity" value="1" type="number">';

                    echo '</td>';
                    
                    echo '<td>';
                        echo '<input type="hidden" name="nomeProduto" value="'.$prodRef[0]->nome.'" />';
                        echo '<input type="hidden" name="menorpreco" value="'.$menorpreco.'" />';
                        echo '<input type="hidden" name="idOng" value="'.$res->ong->idUsuario.'" />';
                        echo '<input type="hidden" name="idDoador" value="'.$_SESSION["idUsuario"].'" />';
                        echo '<input type="hidden" name="idProduto" value="'.$prodRef[0]->idProduto.'" />';
                        echo '<input type="hidden" name="idRefeicao" value="'.$res->idRefeicao.'" />';
                        echo '<input type="submit" class="list-button" value="Doar" name="doar">';
                    echo '</td>';

                echo '</tr>';

            }

        }
    }
    echo '</table>';
    echo '</form>';

    echo '
        </main> 
        <script src="../../javascript/quantidadeAlimentos.js"></script>
        <script src="../../javascript/formularioDoacao.js"></script>
    ';

    echo $endHTML;	
?>