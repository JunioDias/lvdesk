<?php
echo "
<script>NProgress.start();</script>
	<div class='page-header-title'>
	  <h4 class='page-title'>E-mails de Serviço</h4>
	  <p>E-mails de serviço de 2º nível. Todos os e-mails aqui são importados automaticamente para a sessão de serviços.</p>
	</div>
	<div class='content-sized'>";
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");
$a = new Model;
$act = new Acoes;
$username 			= "noc@lvnetwork.com.br";
$password 			= "lvn37w0rk5";
$incoming_server 	= "srv214.prodns.com.br";
$port 				= "993";
function detect_encoding($string)
{
    ////w3.org/International/questions/qa-forms-utf-8.html
    if (preg_match('%^(?: [\x09\x0A\x0D\x20-\x7E] | [\xC2-\xDF][\x80-\xBF] | \xE0[\xA0-\xBF][\x80-\xBF] | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} | \xED[\x80-\x9F][\x80-\xBF] | \xF0[\x90-\xBF][\x80-\xBF]{2} | [\xF1-\xF3][\x80-\xBF]{3} | \xF4[\x80-\x8F][\x80-\xBF]{2} )*$%xs', $string))
        return 'UTF-8';
 
    return mb_detect_encoding($string, array('UTF-8', 'ASCII', 'ISO-8859-1', 'JIS', 'EUC-JP', 'SJIS'));
}
 
function convert_encoding($string, $to_encoding, $from_encoding = '')
{
    if ($from_encoding == '')
        $from_encoding = detect_encoding($string);
 
    if ($from_encoding == $to_encoding)
        return $string;
 
    return mb_convert_encoding($string, $to_encoding, $from_encoding);
}

$mail_box = imap_open("{" . $incoming_server . ":" . $port . "/imap/ssl/novalidate-cert}INBOX", $username, $password) or die("<div class='alert alert-danger fade in'><h4>Falha na conexão</h4><p>Erro retornado: ".imap_last_error()."</p><br><a href='.' class='alert-link'>Clique aqui</a> para atualizar o navegador.</div>");

if ($mail_box) {
	$total_de_mensagens = imap_num_msg($mail_box);
	$numero_mens_nao_lidas = imap_num_recent($mail_box);
	if($numero_mens_nao_lidas > 0){
		if ($total_de_mensagens > 0) {
			for ($mensagem = 1; $mensagem <= $total_de_mensagens; $mensagem++) {
				$header = imap_headerinfo($mail_box, $mensagem);
				$body = imap_fetchbody ($mail_box, $mensagem, 1.2);
				$array_header = json_decode(json_encode($header), true);
				$retorno = $a->addingEmail('emails', $array_header, $body);
							
				/* if($mensagem == 4)
					die(); */
			}
		}
	}
    imap_close($mail_box); 
	#Montagem do Layout
	echo "
	<table class='table table-hover' id='tabela'>
	<thead>
	<tr class='filtro'>
		<th>De <a><i class='mdi mdi-filter-variant icone-filtro'></i></a></th>
		<th>Assunto <a><i class='mdi mdi-filter-variant icone-filtro'></i></a></th>        
		<th>Data<a><i class='mdi mdi-filter-variant icone-filtro'></i></a></th>	
	</tr>
	<tr class='input-filtro' style='display:none;'>
		<th><input type='text' class='form-control' id='txtColuna1'/></th>
		<th><input type='text' class='form-control' id='txtColuna2'/></th>
		<th><input type='text' class='form-control' id='txtColuna3'/></th>	
	</tr> 
	</thead>
	";
	$query_email = "SELECT * FROM emails WHERE lixo = 0 ORDER BY date DESC";
	$foo = $a->queryFree($query_email);
	if($foo){
		while($array_emails = $foo->fetch_assoc()){
			$act->gradeEmail($array_emails);
		}
	}else{
		echo "<tr><td colspan='3'>Nenhum e-mail foi encontrado.</td></tr>";
	}	
	echo "</table></div>";
	#Fim da Montagem do Layout
	echo "<script>NProgress.done();</script>";
}
?>