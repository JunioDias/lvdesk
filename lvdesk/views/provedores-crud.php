<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$a = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM clientes WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$resultado = $a->queryFree($qry);
	$edicao 	= $resultado->fetch_assoc();
	
	$query_contatos = "SELECT contatos FROM agenda_contatos WHERE lixo = 0 AND id_cliente = ".$_POST['id'];						
	$foo = $a->queryFree($query_contatos);	
	$woo = $foo->num_rows;
	$string_contato = NULL;
	$i = 1;
	while($contatos_agenda = $foo->fetch_assoc()){
		$string_contato .= $contatos_agenda['contatos'];		
		if($i < $woo){
			$string_contato .= ', ';
		}
		$i++;
	}
		
	$id		   		= $edicao['id'];
	$id_clientes	= $edicao['id_clientes'];
	$id_pav 	 	= $edicao['id_pav'];
	$client_secret 	= $edicao['client_secret'];
	$client_id 		= $edicao['client_id'];	
	$client_user	= $edicao['client_user'];
	$client_pass	= $edicao['client_pass'];
	$client_url		= $edicao['client_url'];
	$tipo			= $edicao['tipo'];		
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$id_clientes	= NULL;
	$id_pav 	 	= NULL;
	$client_secret 	= NULL;
	$client_id 		= NULL;
	$client_user	= NULL;
	$client_pass	= NULL;
	$client_url		= NULL;
	$tipo			= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Provedores</h4>
	  <p>Gerenciador dos provedores cadastrados no sistema</p>
	</div>
	<div class="content-sized">';
}
?>
<form id="form-dados-clientes">
<div class="panel panel-color panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Dados dos Provedores</h3>
	</div>
	<div class="panel-body">	
		<div class="row">
			<div class="form-group col-sm-8">
				<div class="form-group">
					<label for="provedor">Cliente</label>
					<select class="form-control" name="id_clientes">							
						<?php	
						$query = "SELECT * FROM clientes WHERE lixo = 0";
						$resultado = $a->queryFree($query);
						if(isset($resultado)){
							while($linhas = $resultado->fetch_assoc()){					
								echo "<option value='".$linhas['id']."' ".($linhas['id'] == $provedor ? "selected" : '').">".$linhas['nome']."</option>";						
							}
						}else{
							echo "<option>Cadastre um software de provedor antes de usar</option>";
						}							
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-sm-8">
				<div class="form-group">
					<label for="provedor">Software de Gestão</label>
					<select class="form-control" name="id_provedor" id="addSoftware">							
						<?php	
						$query = "SELECT * FROM pav WHERE lixo = 0";
						$resultado = $a->queryFree($query);
						if(isset($resultado)){
							while($linhas = $resultado->fetch_assoc()){					
								echo "<option value='".$linhas['id']."' ".($linhas['id'] == $provedor ? "selected" : '').">".$linhas['nome']."</option>";						
							}
						}else{
							echo "<option>Cadastre um software de provedor antes de usar</option>";
						}							
						?>
					</select>
				</div>
			</div>
			<div class="form-group col-sm-2">
				<label >Software não listado</label>
				<div class="form-group">
					<input class="form-control btn-info" data-toggle='modal' data-target='#modalAddSoftware' value='Adicionar'  type="button" title="Clique se o software a ser adicionado não estiver na lista ao lado"/>
				</div>					
			</div>
			<div class="form-group col-sm-2">
				<label >Vincular provedor</label>
				<div class="form-group">
					<input class="form-control btn-success vincular" value='Inserir'  type="button" title="Vincular software selecionado ao cliente"/>
				</div>
			</div>
		</div>
		<div class="row" id="vinculos">
			<!--<form>
				<div class="form-group col-sm-3">
					<label for="client_url">URL do Cliente</label>
					<input type="text" class="form-control" name="client_url" value="<?= $client_url;?>"/>
				</div>
				<div class="form-group col-sm-3">
					<label for="client_secret">Segredo</label>
					<input type="text" class="form-control" name="client_secret" value="<?= $client_secret;?>"/>
				</div>
				<div class="form-group col-sm-3">
					<label for="client_user">Usuário do Cliente</label>
					<input type="text" class="form-control" name="client_user" value="<?= $client_user;?>"/>
				</div>
				<div class="form-group col-sm-3">
					<label for="client_pass">Password do Cliente</label>
					<input type="text" class="form-control" name="client_pass" value="<?= $client_pass;?>"/>
				</div>
			</form>-->
		</div>
	</div>
</div>

<?= ((isset($id)) ? "<input type='hidden' name='id' value='$id'/>" : '');?>
<input type="hidden" name="retorno" value="<?= $retorno;?>" />
	<input type="hidden" name="flag" value="processaProvedores" />
	<input type="hidden" name="tbl" value="pav_dados" />
	<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
<div class="form-group">
	<input class="btn btn-success run-provedores-magnify" value="Salvar" type="button" data-objeto="form-dados-clientes">
</div>
</form>
<!--------------------- Modal de Inserção de Logs -------------------->
<div id="modalAddSoftware" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalAddSoftware" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title" id="modalAddSoftware">Cadastrar Software</h3>
		</div>
		<div class="modal-body">
			<section class="modal-body-add">
			<form id="form-dados">				
			<div class="panel panel-color panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title">Identificação</h3>
				</div>
				<div class="panel-body">	
				
					<div class="form-group">
						<label for="nome">Nome do Provedor</label>
						<input type="text" class="form-control" name="nome" >
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							<div class="form-group">
								<label for="tipo_bd">Tipo do banco de dados</label>
								<select class="form-control" name="tipo_bd">							
									<option >Selecione uma opção...</option>
									<option value='OAuth' >OAuth</option>
									<option value='PostgreSQL'>PostgreSQL</option>
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<div class="form-group">
								<label for="nome_bd">Nome do bando de dados</label>
								<input type="text" class="form-control" name="nome_bd" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
						<div class="form-group">
							<label for="host">Host</label>
							<input type="text" class="form-control" name="host" >			
						</div>
						</div>
						<div class="form-group col-sm-6">
							<div class="form-group">
								<label for="porta">Porta</label>
								<input type="text" class="form-control" name="porta" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">	
							<div class="form-group">
								<label for="usuario">Usuário</label>
								<input type="text" class="form-control" name="usuario" >
							</div>
						</div>
						<div class="form-group col-sm-6">
							<div class="form-group">
								<label for="senha_pav">Senha</label>
								<input type="text" class="form-control" name="senha_pav" >
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="script">Script</label>
						<textarea class="wysihtml5-textarea form-control" rows="9" id="script" name="script"></textarea>
					</div>				
				</div>
				<section id="input_hidden">								
					<input type="hidden" name="retorno" value=".modal-body-add" />
					<input type="hidden" name="flag" value="add" />
					<input type="hidden" name="tbl" value="pav_dados" />
					<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
				</section>
			</div>
			</form>	
			</section>
		</div>
		<div class="modal-footer">		
			<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
			<button type="button" class="btn btn-success waves-effect rtrn-conteudo" data-objeto="form-dados">Incluir</button>
		</div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal.dialog -->
</div><!-- /#modal-log -->
<script>
	jQuery(document).ready(function(){
		$('#script').wysihtml5({
		  locale: 'pt-BR'
		}); 
		$('#contatos').wysihtml5({
		  locale: 'pt-BR'
		}); 
	});
	NProgress.done();
</script>