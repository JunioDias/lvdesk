<?php
include("../controllers/model.inc.php");
$a = new Model;
$username 			= "noc@lvnetwork.com.br";
$password 			= "lvn37w0rk5";
$incoming_server 	= "srv214.prodns.com.br";
$port 				= "993";

/* $_SESSION['mail_box'] = imap_open("{".$incoming_server.":".$port."/imap/ssl/novalidate-cert}INBOX", $username, $password);
$total_de_mensagens = imap_num_msg($_SESSION['mail_box']); */
?>
<div class="page-header-title">
  <h4 class="page-title">Leitura de e-mails</h4>
  <p>Caixa de e-mails de serviços</p>
</div>
<div class="content-sized">
<div class="page-content-wrapper ">

	<div class="container">
		<div class="row">
		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/mail-reader.php">			
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Caixa de Entrada</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="mdi mdi-email-open text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20"> Ver e-mails</p>
				</div>
			</div>
			</a>
		</div>	
	</div>
</div>
<script>
NProgress.done();
</script>