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
$mail_box = $a->conectaIMAP();
if ($mail_box) {
	$total_de_mensagens = imap_num_msg($mail_box); #echo $total_de_mensagens . "<br>";
	$numero_mens_nao_lidas = imap_num_recent($mail_box); #echo $numero_mens_nao_lidas;
	if($numero_mens_nao_lidas > 0){
		if ($total_de_mensagens > 0) {
			for ($mensagem = 1; $mensagem <= $numero_mens_nao_lidas; $mensagem++) {
				#Gravação dos e-mails no BD
				$header = imap_header($mail_box, $mensagem);
				$body = imap_fetchbody ($mail_box, $mensagem, 1.2);				
				$array_header = json_decode(json_encode($header), true);
				$retorno = $a->addingEmail('emails', $array_header, $body);	
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