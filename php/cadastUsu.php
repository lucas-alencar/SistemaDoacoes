<?php
require '.\BdConnection.php';
$banco = new Bd();
$retorno = $banco->reqSQL("SELECT ...");
unset($banco);
?>