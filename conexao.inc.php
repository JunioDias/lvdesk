<?php
header('Content-Type: text/html; charset=utf-8'); 
	$bd	   = "lvnet125_desk" ; 
	$senha = "040506@09414200606";
	$user  = "lvnet125_desk";	
	$host	 = 'localhost';

$mysqli = new MySQLi($host,$user,$senha,$bd);
if($mysqli->connect_errno) {
    echo "Falha na conexão do MySQL: " . $mysqli->connect_error;
	exit();
}
if (!$mysqli->set_charset("utf8")) {
    printf("Erro no carregamento de CHARSET UTF-8: %s\n", $mysqli->error);
} else {
    $mysqli->character_set_name();
}