<?php
    // Doctype, head e meta HTML
    require_once("template.php");
    require_once("header.php");
    echo $headHTML;
    echo $headerHTML;
    if(isset($_SESSION['tipo'])){
        if($_SESSION['tipo'] == 'ONG'){
            header("Location:./acompanharDoacao.php");
        }
        if($_SESSION['tipo'] == 'FORNECEDOR'){
            header("Location:./atenderDoacao.php");
        }
    }


    echo '<main>';

    echo '
        <section class="form-container">
            <form method="POST" id="formLogin">
                <p id="mensagem"></p>
                <h1><i class="fas fa-door-open"></i> Fazer login</h1>
                <input placeholder="Login" type="text" name="login" id="login" required><br>
                <input placeholder="Senha" type="password" name="senha" id="senha" required><br>
                <input type="submit" class="default-button" class="default-button" value="Entrar" id="entrar" name="entrar">
            </form>
        </section>
    ';

    echo '
        </main> 
        <script src="../../javascript/formularioLogin.js"></script>
    ';

    echo $endHTML;	
?>
