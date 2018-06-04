<?php
require("model.inc.php");
$dados = $_POST
$a = new Model();
$a->login($dados["email"], $dados["senha"])
?>