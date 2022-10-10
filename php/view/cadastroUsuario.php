<?php
    session_start(); 
    // Doctype, head, meta e header HTML
    require_once("template.php");
    require_once("header.php");
    echo $headHTML;
    echo $headerHTML;

    $tipo = "DOADOR";
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "ONG"){
        $tipo = "FORNECEDOR";
    }
   
    echo '<main>';

    echo '
        <section class="form-container">
        ';
    if(isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "ONG"){
        echo '<h3>Cadastro de Fornecedor</h3>';
    }

    echo '
            <form method="POST" id="formUsuario">
                <p id="mensagem"></p>
                <h1><i class="fa fa-fw fa-user"></i> Cadastro</h1>
                <input placeholder="Login" type="text" name="login" id="login" required><br>
                <input placeholder="Senha" type="password" name="senha" id="senha" required><br>
                <input placeholder="Nome" type="text" name="nome" id="nome" required><br>
                <input placeholder="Telefone" type="text" name="telefone" id="telefone"><br>
                <input type="hidden" id="tipo" name="tipo" value="'.$tipo.'">
                <input class="default-button" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
            </form>
        </section>
    ';

    echo '
        </main> 
        <script src="../../javascript/formularioUsuario.js"></script>
    ';

    echo $endHTML;	
?>
