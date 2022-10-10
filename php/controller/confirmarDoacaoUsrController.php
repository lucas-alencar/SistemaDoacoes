<?php
    require_once ("../model/Doacao.php");

    $idDoador =  $_POST["idDoador"];
    $idOng =  $_POST["idOng"];
    $idProduto =  $_POST["idProduto"];
    $quantidade =  $_POST["quantidade"];
    $valor =  $_POST["valor"];
    $idRefeicao =  $_POST["idRefeicao"];

    $confirmarDoacao = new Doacao($idDoador,$idOng,$idProduto,$quantidade,$idRefeicao,$valor);
    $resultado = $confirmarDoacao->doar();
    if($resultado){
        echo 'Doação realizada com sucesso.';
    }else{
        echo 'Falha durante o processo de doação';
        http_response_code(500);
        
    }
?>
