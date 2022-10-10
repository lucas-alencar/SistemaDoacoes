<?php 
if(!isset($_SESSION)){
    session_start();
} 

$nome ="";
if(isset($_SESSION["nome"])){
    $nome = $_SESSION["nome"];   
}
    $headerHTML = '
        <header class="title-class">        
            <div class="logo">
                <a href="/bancodedados/php/view/index.php">
                <img id="header-img" src="../../img/logo.jpg" alt="Logo"> </img>
                </a>
            </div>    
        </header>

        <div class="navbar-container">
            <div class="navbar-left">';
            if(isset($_SESSION["tipo"])){
                $headerHTML .= 'Você entrou como: '.$nome.'.';
            } else {
                $headerHTML .= '  ';
            }
            $headerHTML .= '
            </div>
            <div class="navbar-center"></div>
            <div class="navbar-right">';
            if(isset($_SESSION["tipo"])){
                if($_SESSION["tipo"] == 'DOADOR'){
                    $headerHTML .= '
                    <a href="/bancodedados/php/view/editarUsuario.php"><i class="fa fa-gear"></i> Configurações</a>
                    ';
                }
                else if($_SESSION["tipo"] == 'ONG'){
                    $headerHTML .= '
                    <a href="/bancodedados/php/view/cadastroUsuario.php"><i class="fa fa-fw fa-user"></i> Cadastro</a>
                    <a href="/bancodedados/php/view/vincularFornecedor.php"><i class="fa fa-motorcycle"></i> Fornecedores</a>
                    <a href="/bancodedados/php/view/cadastroProduto.php"><i class="fas fa-cheese"></i> Adicionar Produtos</a>
                    <a href="/bancodedados/php/view/cadastroRefeicao.php"><i class="fa fa-shopping-bag""></i> Adicionar Refeição</a>
                    <a href="/bancodedados/php/view/acompanharDoacao.php"><i class="fas fa-calendar"></i> Acompanhar Doação</a>
                    <a href="/bancodedados/php/view/editarUsuario.php"><i class="fa fa-gear"></i> Configurações</a>';
                }
                else if($_SESSION['tipo'] == 'FORNECEDOR'){
                    $headerHTML .= '
                    <a href="/bancodedados/php/view/atenderDoacao.php"><i class="fa fa-motorcycle"></i> Atender Doação</a>
                    <a href="/bancodedados/php/view/fornecerProduto.php"><i class="fa fa-motorcycle"></i> Fornecer Produto</a>
                    <a href="/bancodedados/php/view/editarUsuario.php"><i class="fa fa-gear"></i> Configurações</a>';
                }
                $headerHTML .='<a href="/bancodedados/php/controller/logoffSessionController.php"><i class="fas fa-door-open"></i> Sair</a>';
        }
            else{
            $headerHTML .= '
                <a href="/bancodedados/php/view/login.php"><i class="fas fa-door-open"></i> Fazer login</a>
                <a href="/bancodedados/php/view/cadastroUsuario.php"><i class="fa fa-fw fa-user"></i> Cadastro</a>';
            }
            $headerHTML .= '
            
            </div>
        </div>';

?>
