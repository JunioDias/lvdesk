<?php
include("../controllers/model.inc.php");
include("../controllers/logs.inc.php"); 
include("../controllers/actions.inc.php"); 
if(isset($_POST['id'])){ # Campo id em comunicacao_interna definido em comunicacao-enviados.php, comunicacao-recebidos.php ou actions.inc.php
	$dados = $_POST;
	$id = $dados['id'];
	$query_lidas = "UPDATE comunicacao_interna_movimentos SET lida = 1 WHERE id = $id";	
	$query = "SELECT pav_inscritos.* FROM comunicacao_interna_movimentos INNER JOIN pav_inscritos ON pav_inscritos.protocol = comunicacao_interna_movimentos.protocol WHERE ".$dados['var']." = '$id' AND comunicacao_interna_movimentos.lixo = 0";
	/* --------------- Sentença antiga ---------------------------------------
	"SELECT c.*, u.nome AS nome_user FROM comunicacao_interna_movimentos AS c
	INNER JOIN usuarios AS u ON c.autor = u.id 
	WHERE c.lixo = 0 AND c.id = '$id'"; 
	------------------------------------------------------------------------*/
	
	$a = new Model;
	$act = new Acoes;
	$a->queryFree($query_lidas);
	$result = $a->queryFree($query);
	if(isset($result)){
		$matriz = $result->fetch_assoc(); 
	}
}

$data_abertura	= $matriz['data_abertura'];
$nome_cliente	= $matriz['nome_cliente'];
$cpf_cnpj		= $matriz['cpf_cnpj_cliente'];
$autor	 	 	= $matriz['autor'];
$endereco 		= $matriz['endereco_cliente_cad'];
$telefone		= $matriz['telefone_cliente'];
$usuario		= $matriz['usuario'];
$senha_pppoe	= $matriz['senha_pppoe'];
$nas			= $matriz['nas'];
$pppoe			= $matriz['pppoe'];
$ip				= $matriz['ip'];
$protocol		= $matriz['protocol'];
$grupo		 	= $act->grupo_responsavel($protocol);
$status			= $matriz['status'];
$historico		= $matriz['historico'];
$nome_provedor  = $matriz['nome_provedor'];
$situacao		= $matriz['situacao'];
$flag	 		= "teste";
$retorno		= ".content-sized";

if($matriz['atendente_responsavel'] == ''){
	if(!empty($_SESSION["datalogin"])){
		$datalogin 					= $_SESSION["datalogin"];
		$atendente_responsavel		= $datalogin['id'];
	}
}else{
	$atendente_responsavel			= $matriz['atendente_responsavel'];
}
$log = new Logs;
?>

<form id="form-dados">
	<div class="form-group">
		<div class="panel panel-color panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Detalhes do Serviço</h3>
			</div>
			<div class="panel-body">
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="data_abertura">Data de abertura</label>
					<input type="text" class="form-control" value="<?= date("d/m/Y", strtotime($data_abertura)) ;?>">
				</div>
				<div class="form-group col-sm-6">
					<label for="grupo_responsavel">Grupo responsável</label>
					<input type="text" class="form-control" name="grupo_responsavel" value="<?= $grupo ;?>">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="status">Status</label>
					<select class="form-control" name="status" >			
						<option value='0' <?=($status== 0  ? 'selected' : ''); ?>>Novo</option>
						<option value='1' <?=($status== 1  ? 'selected' : ''); ?>>Em atendimento</option>
						<option value='2' <?=($status== 2  ? 'selected' : ''); ?>>Solucionado</option>						
					</select>			
				</div>
				<div class="form-group col-sm-6">
					<label for="atendente_responsavel">Atendente responsável</label>
					<select class="form-control" name="atendente_responsavel" >						
						<option data-nome=''>Selecione um responsável...</option>
						<?php
						$query_provedor	= "SELECT usuarios.nome AS nome, usuarios.id AS id, atendentes.id_usuarios AS id_user FROM `usuarios` JOIN atendentes ON usuarios.usuario = atendentes.usuario WHERE usuarios.lixo = 0 ORDER BY nome ASC";				
						$resulting = $a->queryFree($query_provedor);
						while($linhas = $resulting->fetch_assoc()){
							echo "<option value='".$linhas['id']."' data-nome='".$linhas['nome']."' ".($linhas['id_user']== $atendente_responsavel  ? 'selected' : '').">".$linhas['nome']."</option>";
						}
						?>
					</select>	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="autor">Autor</label>
					<?php
					$queryAtend	= "SELECT id, nome FROM usuarios WHERE id = ".$autor;
					if($id != ''){
						$result = $a->queryFree($queryAtend);
						$linha = $result->fetch_assoc();
						echo '<input type="text" class="form-control" value="'.$linha['nome'].'" />';	
					}				
					?>
				</div>	
				
				<div class="form-group col-sm-6">
					<label for="protocolo">Protocolo</label>
					<input type="text" class="form-control" value="<?= $protocol ;?>">
				</div>	
			</div>
		</div>
	</div>	
	
	<div class="form-group">
		<div class="panel panel-color panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Provedor: <?= $nome_provedor ;?></h3>
			</div>
			<div class="panel-body">
			<div class="row">
			  <div class="form-group col-sm-6">
				
				<div class="form-group">
					<label for="nome_cliente">Cliente</label>
					<input type="text" class="form-control" name="nome_cliente" value="<?= $nome_cliente ;?>">
				</div>
				
				<div class="form-group">
					<label for="cpf_cnpj_cliente">CPF</label>
					<input type="text" class="form-control" name="cpf_cnpj_cliente" value="<?= $cpf_cnpj; ?>">			
				</div>
				
				<div class="form-group">
					<label for="endereco_cliente">Endereço completo</label>
					<input type="text" class="form-control" name="endereco_cliente" value="<?= $endereco; ?>">
				</div>
					
				<div class="form-group">
					<label for="telefone_cliente">Telefone</label>
					<input type="text" class="form-control" name="telefone_cliente" value="<?= $telefone;?>">
				</div>
				<div class="form-group">
					<label for="situacao">Situação</label>
					<input type="text" class="form-control" name="situacao" value="<?= $situacao;?>">
				</div>
			  </div>
			  <div class="form-group col-sm-6">
				
				<div class="form-group">
					<label for="nas">NAS IP</label>
					<input type="text" class="form-control" name="nas" value="<?= $nas ;?>">			
				</div>
				<div class="form-group">
					<label for="pppoe">PPPoE</label>
					<input type="text" class="form-control" name="pppoe" value="<?= $pppoe ;?>">
				</div>
				<div class="form-group">
					<label for="usuario">Usuário</label>
					<input type="text" class="form-control" name="usuario" value="<?= $usuario;?>">
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
								<!--<input class="btn btn-success btn_driver" value="Novo" type="button" data-toggle='modal' data-target='#modal-log' style="float: right; margin: 0 15px 15px 0;">-->
								
  <!---------------------------------------------------------  Timeline  --------------------------------------------->						 <div class="content">
							<h4><span style="color: #000;">Protocolo: <?= $protocol; ?></span></h4>
							<section class="section_historico">
								<textarea class="wysihtml5-textarea form-control" rows="9" id="historico" name="historico">
								<?= $historico; ?>
								</textarea>
							</section>
						</div> <!-- content -->
<!-------------------------------------------------------  Fim da Timeline  --------------------------------------------->
								</div>
								<div class="panel-footer">
								<input type="button" class="btn btn-default" data-toggle="collapse" data-parent="#accordion-test-1" href="#collapseOne-1" aria-expanded="false" value="Fechar">
								<!--<input class="btn btn-success btn_driver" value="Novo" type="button" data-toggle='modal' data-target='#modal-log'>-->
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
		
	</div><!-- Fim Painel -->	
	
	<!-- Validadores -->
	<section class="input_hidden">
		<?=(isset($id)?"<input type='hidden' name='id' value='$id'/>":'');?>
		<input type="hidden" name="flag" value="<?= $flag;?>" />
		<input type="hidden" name="tbl" value="pav_inscritos" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
		<input type="hidden" name="retorno" value="<?= $retorno;?>" />
		<input type="hidden" name="atendente_responsavel" value="<?= $atendente_responsavel;?>" />
	</section>
	<!-- Fim dos Validadores -->	
	<input class="btn btn-success rtrn-conteudo" id="solucionado" value="Solucionado" type="button" data-objeto="form-dados">
	<input class="btn btn-info" id="" value="Atribuir" type="button" data-toggle='modal' data-target='#modal-atribui' />
</form>

<!--------------------- Modal de Inserção de Logs -------------------->
<div id="modal-log" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<form id="form-log">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title" id="myModalLabel">Incluir Ações</h3>
		</div>
		<div class="modal-body">
			<p>Relate abaixo as informações relativas a esse atendimento</p>
			<div class="form-group">
				<label for="protocol">Protocolo</label>
				<input type="text" class="form-control" name="protocol" value="<?= $a->protocolo(); ?>">
			</div>
			<div class="form-group">
				<label for="historico">Histórico</label>
				<textarea class="wysihtml5-textarea form-control" rows="9" id="historico" name="historico"></textarea>
			</div>
		</div>
		<div class="modal-footer">			
			
		<!------------------- Validadores --------------------->
			<section class="input_hidden">
				<?= (isset($id) ? "<input type='hidden' name='id' value='$id'/>" : "" ) ?>
				<input type="hidden" name="id_atendente" value="<?= $atendente_responsavel; ?>" />
				<input type="hidden" name="flag" value="addLog" />
				<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
				<input type="hidden" name="retorno" value=".section_historico" />
				<div class="row">
				  <div class="form-group col-sm-6">
					<label><input name="solution" type="checkbox" value='1'> Marcar este como solução</label>
				  </div>				
				  <div class="form-group col-sm-6">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success waves-effect rtrn-conteudo" data-dismiss="modal" data-objeto="form-log">Salvar</button>
				  </div>
				</div>
			</section>
		<!------------------- Validadores --------------------->

		</div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal.dialog -->
</form>
</div><!-- /#modal-log -->
<!--------------------- Modal de Atribuição de Serviços -------------------->
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
					</select>	
				</div>
				<div id="callback-atribuiGrupo"></div>
			</div>
			<div class="modal-footer">					  				
				<div class="form-group col-sm-12">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success waves-effect" id="atribui_envio" data-dismiss="modal" data-objeto="form-dados">Enviar</button>
				</div>					
				<input type="hidden" name="flag" id="flag-dismiss" value="selecionaGrupoAtribuicao" />
			</div>
		  </div><!-- /.modal-content -->
		</div><!-- /.modal.dialog -->
	</form>
</div><!-- /#modal-atribui -->
<script>
	jQuery(document).ready(function(){
		$('#historico').wysihtml5({
		  locale: 'pt-BR'
		}); 
	});
</script> 