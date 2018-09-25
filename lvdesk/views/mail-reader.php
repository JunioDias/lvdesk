<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");
$a = new Model;
$act = new Acoes;
$mail_box = $a->conectaIMAP();
if ($mail_box) {
	$total_de_mensagens = imap_num_msg($mail_box); 
	$numero_mens_novas = imap_num_recent($mail_box);
	$status = imap_status ( $mail_box , '{srv214.prodns.com.br:993/imap/ssl/novalidate-cert}INBOX' , SA_ALL );
	$msgs = imap_sort($mail_box, SORTDATE, 1, SE_UID);
	if ($status) {
echo "
	<script>NProgress.start();</script>
	<div class='page-header-title'>
	  <h4 class='page-title'>E-mails de Serviço</h4>
	  <p>E-mails de serviço de 2º nível. Todos os e-mails aqui são importados automaticamente para a sessão de serviços.</p>
	";
	  echo "Mensagens:   " . $status->messages    . "<br>";
	  echo "Recentes:     " . $status->recent      . "<br>";
	  echo "Não lidas:     " . $status->unseen      . "</div><div class='content-sized'>";	  
	}else{
	  echo "imap_status failed: " . imap_last_error() . "\n";
	}

	if($numero_mens_novas > 0){
		foreach ($msgs as $msguid) {
			$msgno = imap_msgno($mail_box, $msguid);
			$header = imap_header($mail_box, $msgno);
			$body = $a->getBody($msguid, $mail_box);				
			$array_header = json_decode(json_encode($header), true);
			# Grava na tabela emails para controle
			$flag = $a->addingEmail('emails', $array_header, $body);
			# Grava em pav_inscritos para serviço
			$a->filterEmailtoCGR($flag);
			# Trigger para não identar TODAS as mensagens
			$numero_mens_novas--;
			if($numero_mens_novas == 0){
				return;
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