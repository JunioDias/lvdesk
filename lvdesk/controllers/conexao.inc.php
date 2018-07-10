<?php
header('Content-Type: text/html; charset=utf-8'); 
	$bd	   	= "u641689554_bd" ; 
	$senha 	= "Akz9ovKCruSk";
	$user  	= "u641689554_admin";	
	$host	= "sql137.main-hosting.eu";
	
	/*$host	 = 'localhost'; */

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

$username 			= "noc@lvnetwork.com.br";
$password 			= "lvn37w0rk5";
$incoming_server 	= "srv214.prodns.com.br";
$port 				= "993";

$_SESSION['mail_box'] = imap_open("{" . $incoming_server . ":" . $port . "/imap/ssl/novalidate-cert}INBOX", $username, $password) or die("<div class='alert alert-danger fade in'><h4>Falha na conexão</h4><p>Erro retornado: ".imap_last_error()."</p><br><a href='.' class='alert-link'>Clique aqui</a> para atualizar o navegador.</div>");