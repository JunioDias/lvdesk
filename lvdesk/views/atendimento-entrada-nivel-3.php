<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");
$a 		= new Model;
$act 	= new Acoes;
$queryAtend	= "SELECT id, nome FROM usuarios WHERE lixo = 0 AND id_contrato = 0 ORDER BY nome ASC";		

if(!empty($_SESSION["datalogin"])){
	$datalogin 					= $_SESSION["datalogin"];
	$atendente_responsavel		= $datalogin['id'];
}
$queryAutor	= "SELECT id, nome FROM usuarios WHERE id = $atendente_responsavel AND lixo = 0";		
$busca_autor = $a->queryFree($queryAutor);
$row = $busca_autor->fetch_assoc();
?>
<div class="page-header-title">
	<h4 class="page-title">Atendimento</h4>
	<p>Formulário para abertura de atendimento para CGR</p>
</div>
<div class="content-sized">	
	<form id="form-dados">
		<div class="form-group">
			<div class="panel panel-color panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title">Detalhes do Chamado</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="data_abertura">Data de abertura</label>
							<input type="text" class="form-control" value="<?= date("d/m/Y");?>"/>
							<input type="hidden" name="data_abertura" value="<?= date("Y-m-d H:i:s");?>" />
						</div>
						<div class="form-group col-sm-6">
							<label for="autor">Autor</label>
							<input type='text' class='form-control' value='<?=$row['nome']; ?>'/>
							<input type='hidden' name='autor' value='<?= $row['id']; ?>' />
						</div>	
						
					</div>
					<div class="row">						
						<div class="form-group col-md-12"  >
							<label for="atendente_responsavel">Responsável</label>
							<select class="form-control" name="atendente_responsavel" >
							<option data-nome=''>Selecione um responsável...</option>
				<?php
				$query_provedor	= "SELECT nome, id FROM usuarios  WHERE lixo = 0 ORDER BY nome ASC";	
				$result = $a->queryFree($query_provedor);
				while($linhas = $result->fetch_assoc()){
					echo "<option value='".$linhas['id']."' data-nome='".$linhas['nome']."'>".$linhas['nome']."</option>";
				}
				?>
							</select>
						</div>
					</div>
					<div class="row">						
						<div class="form-group col-md-12" id="dynamicDiv1" >
							<label for="grupo_responsavel">Grupo Responsável (opcional)</label>
							<input type="text" autocomplete="off" class="form-control col-sm-12" id="buscaDestinatario"placeholder="Digite o nome dos usuários co-responsáveis" > 
							<div class="list-container">
								<div class="list-group"></div>
								<div class="list-search"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="status">Status</label>
							<select class="form-control" name="status" >		
								<option value='0' >Novo</option>
								<option value='1' >Em atendimento</option>
								<option value='2' >Solucionado</option>
							</select>			
						</div>						
						<div class="form-group col-sm-6">
							<label for="protocolo">Protocolo</label>
							<input type="text" class="form-control" name="protocol" value="<?= $a->protocolo();?>" >
						</div>	
					</div>
				</div>
			</div>	
		</div>
		<div class="form-group">
			<div class="panel panel-color panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title">Provedor</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-sm-12">
							<select class="form-control" name="id_contratos" id="select_id_contratos">
							<option data-nome=''>Selecione um provedor ativo...</option>
				<?php
				$query_provedor	= "SELECT clientes.nome, contratos.id FROM clientes INNER JOIN contratos ON clientes.id = id_cliente WHERE clientes.lixo = 0 AND finaliza_em >= now() ORDER BY nome ASC";	
				$result = $a->queryFree($query_provedor);
				while($linhas = $result->fetch_assoc()){
					echo "<option value='".$linhas['id']."' data-nome='".$linhas['nome']."'>".$linhas['nome']."</option>";
				}
				?>
							</select>
							<input type="hidden" name="nome_provedor" />
						</div>
					</div>
					<div class="row">
					  <div class="form-group col-sm-6">
						
						<div class="form-group">
							<label for="nome_cliente">Cliente</label>
							<input type="text" class="form-control" name="nome_cliente" >
						</div>
						
						<div class="form-group">
							<label for="cpf_cnpj_cliente">CPF</label>
							<input type="text" class="form-control" name="cpf_cnpj_cliente" >			
						</div>
						
						<div class="form-group">
							<label for="endereco_cliente_cad">Endereço completo</label>
							<input type="text" class="form-control" name="endereco_cliente_cad" >
						</div>
							
						<div class="form-group">
							<label for="telefone_cliente">Telefone</label>
							<input type="text" class="form-control telefone" name="telefone_cliente" >
						</div>
						<div class="form-group">
							<label for="situacao">Situação</label>
							<input type="text" class="form-control" name="situacao">
						</div>
					  </div>
					  <div class="form-group col-sm-6">
						
						<div class="form-group">
							<label for="nas">NAS IP</label>
							<input type="text" class="form-control" name="nas" >			
						</div>
						<div class="form-group">
							<label for="pppoe">PPPoE</label>
							<input type="text" class="form-control" name="pppoe" >
						</div>
						<div class="form-group">
							<label for="usuario">Usuário</label>
							<input type="text" class="form-control" name="usuario" >
						</div>
						<div class="form-group">
							<label for="senha_pppoe">Senha</label>
							<input type="text" class="form-control" name="senha_pppoe" >
						</div>
						<div class="form-group">
							<label for="ip">IP</label>
							<input type="text" class="form-control" name="ip" >
						</div>						
					  </div>
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
													<textarea class="wysihtml5-textarea form-control" rows="9" id="historico" name="historico"> </textarea>												
													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>  <!-- end row -->
							</div>
						</div>		
					</div>
				</div>
			</div>	
		</div>		
		<input class="btn btn-info " id="" value="Atribuir" type="button" data-toggle='modal' data-target='#modal-atribui' data-objeto="form-dados"/>
		<!------------------- Validadores --------------------->
		<section class="input_hidden" id="atribui_hidden_validadores">
			<input type="hidden" name="flag" value="add" />
			<input type="hidden" name="tbl" value="pav_inscritos" />
			<input type="hidden" name="subTabela" value="pav_movimentos" />
			<input type="hidden" name="retorno" value=".content-sized" />
			<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
		</section>
		<!------------------- Validadores --------------------->
	</form>
</div>
<!--------------------- Modal de Atribuição -------------------->
<div id="modal-atribui" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<form id="form-atribui">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="modal-title" id="myModalLabel">Atribuir serviço</h3>
			</div>
			<div class="modal-body">
				<p>Qual o destino deste serviço?</p>
				<div class="form-group">
					<select class="form-control atribuiGrupo" name='id_grupo'>	
						<option>Selecione uma opção...</option>
						<option value='1'>Comunicação interna</option>
						<option value='2'>Auditoria</option>
						<option value='3'>Despachar a cliente</option>
					</select>	
				</div>
				<div id="callback-atribuiGrupo">
					
				</div>
			</div>
			<div class="modal-footer">					  				
				<div class="form-group col-sm-12">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success waves-effect" id="atribui_envio" data-dismiss="modal" data-objeto="form-dados">Enviar</button>
				</div>					
				<input type="hidden" name="flag" id="flag" value="selecionaGrupoAtribuicao" />
			</div>
		  </div><!-- /.modal-content -->
		</div><!-- /.modal.dialog -->
	</form>
</div><!-- /#modal-atribuição -->
<script>
jQuery(document).ready(function(){
	$('#historico').wysihtml5({
		locale: 'pt-BR'
	});
});
NProgress.done();
</script>