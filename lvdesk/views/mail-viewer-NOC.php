<?php
if($dados){
	$a 		= new Model;
	$a->queryFree("UPDATE emails SET unseen = 1 WHERE id = '".$dados['id']."'");
	$query	= "SELECT emails.*, mailcompleto FROM `emails` JOIN emails_cc ON emails.id = emails_cc.id_emails WHERE emails.id = '".$dados['id']."'";
	$return	= $a->queryFree($query);
	$array = $return->fetch_assoc();
	if($array['mailcompleto'] == ''){
		$a->queryFree("UPDATE emails SET unseen = 1 WHERE id = '".$dados['id']."'");
		$query	= "SELECT emails.* FROM `emails` WHERE emails.id = '".$dados['id']."'";
		$return	= $a->queryFree($query);
		$array = $return->fetch_assoc();
	}
	echo "
	<div class='page-header-title' >
	  <h4 class='page-title'><a class='regular-link' link='views/mail-reader.php' title='Voltar para Caixa de Entrada'><i class='mdi mdi-arrow-left-bold-circle-outline'  style='color: white;'></i></a> ".iconv_mime_decode($array['subject'])."</h4>
	  <p>De: <em>".iconv_mime_decode($array['fromaddress'])."</em> em  ".date('d/m/Y H:i:s', strtotime($array['date']))."</p>";
	if(isset($array['mailcompleto'])){ 
		echo "<p>CC: <em>".iconv_mime_decode($array['mailcompleto'])."</em> </p>";
	}
	echo "</div><div class='content-sized'>";	
}	
?>	
	<div class="form-group">
	  	<div class="panel panel-color panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Corpo da Mensagem</h3>
			</div>
			<div class="panel-body">			
				<div class="form-group">
				<textarea class="wysihtml5-textarea form-control" id="email" rows="9" ><?= $array['body'];?></textarea>
				</div>
			</div>
		</div>
	</div>	
</div> <!-- content-sized -->
<!--------------------- Modal de Inserção de Logs -------------------->
<div id="modalLastLog" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalLabelLog" aria-hidden="true" style="display: none;">
<form id="form-log">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title" id="modalLabelLog">Histórico de ações</h3>
		</div>
		<div class="modal-body">		
			<div class="form-group">
				<div class="form-group"><!-- Área da timeline -->
					<label for="historico">Cliente</label><p><?= $nome_cliente;?></p><hr>
					<section class="section_historico"></section>
				</div>
			</div>			
		</div>
		<div class="modal-footer">		
			<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
			<button type="button" class="btn btn-success waves-effect rtrn-conteudo" data-toggle='modal' data-target='#modalAddLog'>Incluir</button>
		</div>
	  </div><!-- /.modal-content -->
	</button>
	</div><!-- /.modal.dialog -->
</form>
</div><!-- /#modal-log -->
<script>
jQuery(document).ready(function(){
	$('#email').wysihtml5({
		locale: 'pt-BR'
	});
});
NProgress.done();
</script>