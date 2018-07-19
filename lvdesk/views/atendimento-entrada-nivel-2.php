<?php
if(isset($id)){//Campo id em pav_incritos definido em crud.sys
	$query = "
	SELECT pav.*, atend.nome 
	FROM pav_inscritos AS pav 
	INNER JOIN atendentes AS atend ON atend.id = pav.atendente_responsavel 
	WHERE pav.id = '$id'";
	$a = new Model;
	$result = $a->queryFree($query);
	if(isset($result)){
		$matriz = $result->fetch_assoc(); 
	}
}
$data_abertura	= $matriz['data_abertura'];
$grupo		 	= $matriz['grupo_responsavel'];
$nome_cliente	= $matriz['nome_cliente'];
$cpf_cnpj		= $matriz['cpf_cnpj_cliente'];
$autor	 	 	= $matriz['autor'];
$endereco 		= $matriz['endereco_cliente'];
$telefone		= $matriz['telefone_cliente'];
$usuario		= $matriz['usuario'];
$senha_pppoe	= $matriz['senha_pppoe'];
$nas			= $matriz['nas'];
$pppoe			= $matriz['pppoe'];
$ip				= $matriz['ip'];
$protocol		= $matriz['protocol'];
$status			= $matriz['status'];
$historico		= $matriz['historico'];
$nome_provedor  = $matriz['nome_provedor'];
$situacao		= $matriz['situacao'];
$flag	 		= "update";
$retorno		= ".content-sized";

if(!empty($_SESSION["datalogin"])){
	$datalogin 					= $_SESSION["datalogin"];
	$atendente_responsavel		= $datalogin['id'];
}
$log = new Logs;
?>

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
					<?php					
					if(isset($id)){
						$queryStatus	= "SELECT status FROM pav_inscritos WHERE id = $id";
						$result = $a->queryFree($queryStatus);
						while($linhas = $result->fetch_assoc()){
							echo "
							<option value='0' ".($linhas['status']== 0  ? 'selected' : '').">Novo</option>
							<option value='1' ".($linhas['status']== 1  ? 'selected' : '').">Em atendimento</option>
							<option value='2' ".($linhas['status']== 2  ? 'selected' : '').">Solucionado</option>
							";
						}	
					}				
					?>
					</select>			
				</div>
				<div class="form-group col-sm-6">
					<label for="atendente_responsavel">Atendente responsável</label>
					<select class="form-control" name="atendente_responsavel" >			
					<?php
					$queryAtend	= "SELECT id, nome FROM atendentes WHERE tipo_atendente = '1' AND lixo = 0";
					if(isset($id)){
						$result = $a->queryFree($queryAtend);
						while($linhas = $result->fetch_assoc()){
							echo "<option value='".$linhas['id']."' ".($linhas['id']==$id ? 'selected' : '').">".$linhas['nome']."</option>";
						}	
					}				
					?>
					</select>	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="autor">Autor</label>
					<?php
					$queryAtend	= "SELECT id, nome FROM atendentes WHERE id = $autor";
					if(isset($id)){
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
								<input class="btn btn-success btn_driver" value="Novo" type="button" data-toggle='modal' data-target='#modal-log' style="float: right; margin: 0 15px 15px 0;">
								
  <!---------------------------------------------------------  Timeline  --------------------------------------------->								
						<div class="content">
							<div class="">
								<div class="page-header-title" style="background: #D5FFD5;">
								<h4><span style="color: #000;">Protocolo: <?= $protocol; ?></span></h4>
								</div>
							</div>

							<div class="page-content-wrapper ">

							<div class="container">
								<div class="row">
									<div class="col-sm-12">
										<div class="panel panel-primary">
											<div class="panel-body">
												<div class="row">
													<div class="col-md-12">
														<section id="cd-timeline" class="cd-container">
															
															<section class="section_historico">
				<?php
				$query_movimentos = "
				SELECT pav.id, pav.protocol, pav.data, pav.descricao, pav.solution, atend.nome FROM pav_movimentos AS pav INNER JOIN atendentes AS atend ON atend.id = pav.id_atendente INNER JOIN pav_inscritos ON pav_inscritos.id = pav.id_pav_inscritos WHERE pav.id_pav_inscritos = $id AND pav.lixo = 0 ORDER BY pav.data DESC LIMIT 8";
				$resultado = $a->queryFree($query_movimentos);
				if($resultado){
					while($linhas = $resultado->fetch_assoc()){
						$log->timeline($linhas, $linhas['solution'], 'fa-check');
					}					
				}
				?>
															</section>
																
														</section> <!-- cd-timeline -->
													</div>
												</div><!-- Row -->

											</div>
										</div>
									</div>
								</div><!-- end row -->
								</div><!-- container -->
							</div> <!-- Page content Wrapper -->
						</div> <!-- content -->
<!-------------------------------------------------------  Fim da Timeline  --------------------------------------------->
								</div>
								<div class="panel-footer">
								<input type="button" class="btn btn-default" data-toggle="collapse" data-parent="#accordion-test-1" href="#collapseOne-1" aria-expanded="false" value="Fechar">
								<input class="btn btn-success btn_driver" value="Novo" type="button" data-toggle='modal' data-target='#modal-log'>
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
		<?php 
		if(isset($id)){
			echo "<input type='hidden' name='id' value='$id'/>";
		}
		?>
		<input type="hidden" name="flag" value="<?= $flag;?>" />
		<input type="hidden" name="tbl" value="pav_inscritos" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
		<input type="hidden" name="retorno" value="<?= $retorno;?>" />
		<input type="hidden" name="atendente_responsavel" value="<?= $atendente_responsavel;?>" />
	</section>
	<!-- Fim dos Validadores -->	
	<input class="btn btn-success rtrn-conteudo" id="solucionado" value="Solucionado" type="button" objeto="form-dados">
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
				<?php 
				if(isset($id)){
					echo "<input type='hidden' name='id' value='$id'/>";
				}
				?>
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
					<button type="button" class="btn btn-success waves-effect rtrn-conteudo" data-dismiss="modal" objeto="form-log">Salvar</button>
				  </div>
				</div>
			</section>
		<!------------------- Validadores --------------------->

		</div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal.dialog -->
</form>
</div><!-- /#modal-log -->
<script>
	jQuery(document).ready(function(){
		$('#historico').wysihtml5({
		  locale: 'pt-BR'
		}); 
	});
</script> 