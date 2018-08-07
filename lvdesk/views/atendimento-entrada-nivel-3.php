<?php
include("../controllers/model.inc.php");
$a = new Model;
$queryAtend	= "SELECT id, nome FROM atendentes WHERE tipo_atendente = '1' AND lixo = 0";		
$result = $a->queryFree($queryAtend);

if(!empty($_SESSION["datalogin"])){
	$datalogin 					= $_SESSION["datalogin"];
	$atendente_responsavel		= $datalogin['id'];
}
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
							<input type="text" class="form-control" value="<?= date("d/m/Y");?>">
						</div>
						<div class="form-group col-sm-6">
							<label for="grupo_responsavel">Grupo responsável</label>
							<input type="text" class="form-control" name="grupo_responsavel" value="">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="status">Status</label>
							<select class="form-control" name="status" >		
								<option value='0' >Novo</option>
								<option value='1' ></option>>Em atendimento</option>
								<option value='2' >Solucionado</option>
							</select>			
						</div>
						<div class="form-group col-sm-6">
							<label for="atendente_responsavel">Atendente responsável</label>
							<select class="form-control" name="atendente_responsavel" >			
							<?php
							if(isset($atendente_responsavel)){								
								while($linhas = $result->fetch_assoc()){
									echo "<option value='".$linhas['id']."' ".($atendente_responsavel == $linhas['id'] ? 'selected' : '' )." >".$linhas['nome']."</option>";
								}
							}						
							?>
							</select>	
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="autor">Autor</label>
							<input type="text" class="form-control"  
							<?php 
							while($linhas = $autory->fetch_assoc()){
								if($atendente_responsavel == $linhas['id']){
									echo "value='".$linhas['nome']."'";
								}								
							}							
							?> name="autor" />
						</div>	
						
						<div class="form-group col-sm-6">
							<label for="protocolo">Protocolo</label>
							<input type="text" class="form-control" >
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
							<label for="endereco_cliente">Endereço completo</label>
							<input type="text" class="form-control" name="endereco_cliente" >
						</div>
							
						<div class="form-group">
							<label for="telefone_cliente">Telefone</label>
							<input type="text" class="form-control" name="telefone_cliente" >
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
		<!-- Validadores -->
		<section class="input_hidden">
			<input type="hidden" name="flag" value="add" />
			<input type="hidden" name="tbl" value="pav_inscritos" />
			<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
			<input type="hidden" name="retorno" value="" />			
		</section>
		<!-- Fim dos Validadores -->	
		<input class="btn btn-info rtrn-conteudo" id="" value="Atribuir" type="button" objeto="form-dados">
	</form>
</div>
<script>
jQuery(document).ready(function(){
	$('#historico').wysihtml5({
		locale: 'pt-BR'
	});
});
</script>