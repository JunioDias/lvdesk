<div class="page-header-title">
  <h4 class="page-title">Atendimento</h4>
  <p>Movimentação dos chamados para atendimento</p>
</div>
<div class="content-sized"> 
<?php
$a 		= new Model;
$log 	= new Logs;
if(!empty($_SESSION["datalogin"])){
	$datalogin 					= $_SESSION["datalogin"];
	$atendente_responsavel		= $datalogin['id'];
	if($datalogin['id_contrato'] != 0){ #zero representa nenhum contrato, isso é um erro
		$query_contrato = "SELECT * FROM contratos WHERE id = '".$datalogin['id_contrato']."' AND lixo = 0";
		$resultado = $a->queryFree($query_contrato);
		$permissao = $resultado->fetch_assoc();
	}
}

if($id_provedor){//Existe um provedor
		
	$query = "SELECT * FROM pav WHERE id = '".$id_provedor."' AND lixo = 0";
	$result = $a->queryFree($query);
	if($result){
		$matriz = $result->fetch_assoc();
	}
	
	$nome_cliente	= $array['nome_cliente'];
	$cpf_cnpj		= $array['cpf_cnpj'];
	$provedor 	 	= $matriz['nome'];
	$endereco 		= $array['endereco'];
	$telefone		= $array['telefone_principal'];
	$usuario		= $array['usuario_autenticacao'];
	$senha_pppoe	= $array['senha_autenticacao'];
	// $nas			= $array['nas'];
	// $pppoe		= $array['pppoe'];
	$ip				= $array['ipv4'];
	$script			= $matriz['script'];
	$status			= $array['status'];
	$flag	 		= "add";
	$retorno		= ".content-sized";
	
}else{
	$id_provedor	= NULL;
	$nome_cliente	= NULL;
	$cpf_cnpj		= NULL;
	$provedor 	 	= NULL;
	$endereco 		= NULL;
	$telefone		= NULL;
	$usuario		= NULL;
	$senha_pppoe	= NULL;
	// $nas			= NULL;
	// $pppoe		= NULL;
	$ip				= NULL;
	$script			= NULL;
	$status			= NULL;
	$flag	 		= "";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Atendimento</h4>
	  <p>Movimentação dos chamados para atendimento</p>
	</div>
	<div class="content-sized">';
}	
?>
	<form id="form-dados">
	<div class="form-group">
		<div class="panel panel-color panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Indentificação</h3>
			</div>
			<div class="panel-body">			
				<div class="form-group">
					<label for="nome_provedor">Provedor</label>
					<input type="text" class="form-control" name="nome_provedor" value="<?= $provedor ;?>">
				</div>
				<div class="form-group">
					<label for="nome_cliente">Cliente</label>
					<input type="text" class="form-control" name="nome_cliente" value="<?= $nome_cliente ;?>">
				</div>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="panel panel-color panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Detalhes do Chamado</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-sm-12">
						<div class="form-group">
							<label for="endereco_cliente">Endereço completo</label>
							<input type="text" class="form-control" name="endereco_cliente" value="<?= $endereco; ?>">
						</div>				
					</div>				
				</div>
				<div class="row">
					<div class="form-group col-sm-4">
					
					<div class="form-group">
						<label for="cpf_cnpj_cliente">CPF</label>
						<input type="text" class="form-control" name="cpf_cnpj_cliente" value="<?= $cpf_cnpj; ?>">			
					</div>							
					
					<div class="form-group">
						<label for="telefone_cliente">Telefone</label>
						<input type="text" class="form-control" name="telefone_cliente" value="<?= $telefone;?>">
					</div>
				
					<div class="form-group">
						<label for="situacao">Situação</label>
						<input type="text" class="form-control" name="situacao" value="<?= $status;?>">
					</div>
					
					<div class="form-group">
						<label for="usuario">Usuário</label>
						<input type="text" class="form-control" name="usuario" value="<?= $usuario;?>">
					</div>
					</div>	

					
					<div class="form-group col-sm-4">
					<div class="form-group">
						<label for="nas">NAS IP</label>
						<input type="text" class="form-control"  value="">			
					</div>
					<div class="form-group">
						<label for="pppoe">PPPoE</label>
						<input type="text" class="form-control"  value="">
					</div>
					
					<div class="form-group">
						<label for="senha_pppoe">Senha</label>
						<input type="text" class="form-control" name="senha_pppoe" value="<?= $senha_pppoe;?>">
					</div>
					<div class="form-group">
						<label for="ip">IP</label>
						<input type="text" class="form-control" name="ip" value="<?= $ip;?>">
					</div>			
					
					</div>
					
					<div class="form-group col-sm-4">
						<div class="form-group">
						<label for="ultimos">ÚLTIMOS ATENDIMENTOS</label>
						</div>
						<section class="section_historico_log">						
							<?php
							$log->ultimosAtendimentos($array['cpf_cnpj']);	
							?>						
							
						</section>						
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-sm-4">
						<div class="form-group">
							<label for="origem">Origem do contato</label>
							<div class="radio radio-primary">
								<input type="radio" name="origem" id="whatsapp" value="whatsapp" >
								<label for="whatsapp">
									WhatsApp
								</label>
							</div>
							<div class="radio radio-primary">
								<input type="radio" name="origem" id="recebida" value="recebida">
								<label for="recebida">
									Ligação Recebida
								</label>
							</div>
							<div class="radio radio-primary">
								<input type="radio" name="origem" id="efetuada" value="efetuada">
								<label for="efetuada">
									Ligação Efetuada
								</label>
							</div>
						</div>							
					</div>
				</div>
				
			</div>			
		</div>
	
	<div class="form-group">		
<!-----------------     Área do Script    ------------------------------->
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<h4 class="page-header m-t-0">Script</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-group" id="accordion-test-2">
							<div class="panel panel-success panel-color">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
											Tutorial de atendimento
										</a>
									</h4>
								</div>
								<div id="collapseOne-2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="panel-body">
									<textarea class="wysihtml5-textarea form-control" id="script" rows="9" ><?= $script;?></textarea>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>  <!-- end row -->

			</div>
		</div>
<!----------------- fim da área do script ------------------------------->		
	</div>
	<div class="form-group">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<h4 class="page-header m-t-0">Histórico de Ações</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-group" id="accordion-test-1">
							<div class="panel panel-success panel-color">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion-test-1" href="#collapseOne-1" aria-expanded="false" class="collapsed">
											Descrição
										</a>
									</h4>
								</div>
								<div id="collapseOne-1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="panel-body">
									<form id="form-log">
									<textarea class="wysihtml5-textarea form-control" rows="9" id="historico" name="historico"> </textarea>									
									</form>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>  <!-- end row -->

			</div>
		</div>		
	</div>
	<div class="form-group">
	<hr><label for="resumo">Resumo</label><br>
	<input class="btn btn-success rtrn-conteudo" id="solucionado" value="Solucionado" type="button" objeto="form-dados">
	<?= ($permissao['id_produtos'] == 2 || $permissao['id_produtos'] == 3 ? '<input class="btn btn-warning rtrn-conteudo" value="CGR" type="button" objeto="form-dados">' : '' ); ?>		
	<input class="btn btn-info" id="atrbuir" value="Atribuir" type="button" objeto="form-dados">
	</div>
	<section class="input_hidden">
		<?php 
		if(isset($id_provedor)){
			echo "<input type='hidden' name='id_pav' value='$id_provedor'/>";
		}
		?>
		<input type="hidden" name="flag" value="<?= $flag;?>" />
		<input type="hidden" name="tbl" value="pav_inscritos" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
		<input type="hidden" name="retorno" value="<?= $retorno;?>" />
		<input type="hidden" name="hora_add" value="on" />
		<input type="hidden" name="subTabela" value="pav_movimentos" />
		<input type="hidden" name="atendente_responsavel" value="<?= $atendente_responsavel;?>" />
	</section>
	</form>	
</div>
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
<form id="form_ultimos_atendimentos">
	<input type="hidden" name="flag" value="ultimosAtendimentos" />
	<input type="hidden" name="retorno" value=".section_historico" />
</form>
<!--------------------- Modal de Inserção de Logs -------------------->
<div id="modalAddLog" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalLabelLog" aria-hidden="true" style="display: none;">
<form id="form-add-log">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title" id="modalLabelLog">Incluir Ações</h3>
		</div>
		<div class="modal-body">		
			<p>Relate abaixo as informações relativas ao atendimento selecionado</p>
			<div class="form-group">
				<label for="protocol">Protocolo</label>
				<div class="row">
					<div class="form-group col-sm-8">
					  <input type="text" class="form-control" name="protocol" id="protocol" value="" >
					</div>
					<div class="form-group col-sm-4" title="Gerar novo protocolo">
					  <button type="button" class="btn waves-effect btn-warning" id="new_protcol" style="float: left; height: 100%;"> 
						<i class="fa fa-refresh"></i> 
					  </button>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="historico">Histórico</label>
				<textarea class="wysihtml5-textarea form-control" rows="9" id="log" name="historico"></textarea>
			</div>
			
		</div>
		<div class="modal-footer">
		<!------------------- Validadores --------------------->
			<section class="input_hidden">
				<input type='hidden' name='id' value=''/>
				<input type="hidden" name="subTabela" value="pav_movimentos" />
				<input type="hidden" name="id_atendente" value="<?= $atendente_responsavel; ?>" />
				<input type="hidden" name="flag" value="addLog" />
				<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
				<input type="hidden" name="retorno" value=".section_historico" />				
			</section>
		<!------------------- Validadores --------------------->
		<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
		<button type="button" class="btn btn-success waves-effect rtrn-conteudo" data-dismiss="modal" objeto="form-add-log">Salvar
		</div>
	  </div><!-- /.modal-content -->
	</button>
	</div><!-- /.modal.dialog -->
</form>
</div><!-- /#modal-log -->

<!--------------------- Modal de alerta para clientes com pendências contratuais -------------------->
<div id="alerta_cliente_contrato" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalContratoAlerta" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 class="modal-title" id="modalContratoAlerta">Atenção!</h3>
	</div>
	<div class="modal-body">
		<h4>Possíveis pendências contratuais.</h4>
		<p>Esta entidade possui uma observação contratual.<br>
		Confira a validade do contrato ou número de atendimentos máximo.<br>
		Por favor, encaminhe um aviso para o setor responsável.</p>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-success waves-effect" data-dismiss="modal">OK</button>
	</div>
  </div><!-- /.modal-content -->
</div><!-- /.modal.dialog -->

<!--------------------- Modal de alerta para CGR ativo -------------------->
<div id="alerta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 class="modal-title" id="myModalLabel">Atenção!</h3>
	</div>
	<div class="modal-body">
		<h4>Chamado de segundo nível em curso.</h4>
		<p>Este cliente já possui um chamado em aberto sendo verificado pelo CGR.<br>Por favor, cheque os últimos atendimentos realizados.</p>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-success waves-effect" data-dismiss="modal">OK</button>
	</div>
  </div><!-- /.modal-content -->
</div><!-- /.modal.dialog -->
<script>
	jQuery(document).ready(function(){
		$('#historico').wysihtml5({
		    locale: 'pt-BR'
		});
		$('#script').wysihtml5({
		  locale: 'pt-BR'
		});
		$('#log').wysihtml5({
		  locale: 'pt-BR'
		});
	});
</script>
<?php
#Teste de CGR ativo
$cgr_query = "SELECT COUNT(id) AS id FROM pav_inscritos WHERE cpf_cnpj_cliente = '".$array['cpf_cnpj']."' AND validado = 0 AND lixo = 0";
$teste = $a->queryFree($cgr_query);
if(isset($teste)){
	$cgr_teste = $teste->fetch_assoc();
	if($cgr_teste['id'] > 0){
		echo ("
		<script type='text/javascript'>
		$(document).ready(function () {
			$('#alerta').modal('toggle');	
		});
		</script>
		");
	}
}
?>