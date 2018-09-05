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
	$nome			= $edicao['nome'];
	$usuario 	 	= $edicao['usuario'];
	$senha 	 		= $edicao['senha'];
	$data_contrato 	= $edicao['data_contrato'];	
	$cpf_cnpj		= $edicao['cpf_cnpj'];
	$contato		= $edicao['contato'];
	$provedor		= $edicao['id_provedor'];
	$codarea		= $edicao['codareatelefone'];
	$telefones		= $edicao['telefones'];
	$codareacel		= $edicao['codareacelular'];
	$celular		= $edicao['celular'];
	$endereco		= $edicao['endereco'];
	$numero			= $edicao['numero'];
	$complemento	= $edicao['complemento'];
	$bairro			= $edicao['bairro'];
	$cep			= $edicao['cep'];
	$cidade			= $edicao['cidade'];
	$uf				= $edicao['uf'];
	$tipo_perfil	= $edicao['tipo_perfil'];	
	$foto			= $edicao['foto'];
	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$usuario 	 	= NULL;
	$senha			= NULL;
	$data_contrato 	= NULL;	
	$cpf_cnpj		= NULL;
	$contato		= NULL;
	$provedor		= NULL;
	$codarea		= NULL;
	$telefones		= NULL;
	$codareacel		= NULL;
	$celular		= NULL;
	$endereco		= NULL;
	$numero			= NULL;
	$complemento	= NULL;
	$bairro			= NULL;
	$cep			= NULL;
	$cidade			= NULL;
	$uf				= NULL;
	$tipo_perfil	= NULL;
	$foto			= NULL;
	$string_contato = NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Clientes</h4>
	  <p>Gerenciador dos clientes cadastrados no sistema</p>
	</div>
	<div class="content-sized">';
}
?>
<form id="form-dados-clientes">
<div class="panel panel-color panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Identificação</h3>
	</div>
	<div class="panel-body">			
		<div class="row">
			<div class="form-group">
			<label for="nome">Nome</label>
				<input type="text" class="form-control" name="nome" value="<?= $nome;?>"/>
			</div>
			<div class="form-group">
				<label for="usuario">Nome de usuário (e-mail)</label>
				<input type="text" class="form-control" name="usuario" value="<?= $usuario;?>"/>
			</div>
			<div class="form-group">
				<label for="senha">Senha</label>
				<input type="password" class="form-control" name="senha" value="<?= $senha;?>"/>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-color panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Detalhes Cadastrais</h3>
	</div>
	<div class="panel-body">			
		<div class="row">	
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="data_contrato">Data de Cadastro</label>
					<input type="date" class="form-control" name="data_contrato" value="<?= $data_contrato;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="cpf_cnpj">CPF/CNPJ</label>
					<input type="text" class="form-control" name="cpf_cnpj" value="<?= $cpf_cnpj;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-4">
				<div class="form-group">
					<label for="contato">Contato Legal</label>
					<input type="text" class="form-control" name="contato" value="<?= $contato;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
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
				<label for="add">Novo Software</label>
				<div class="form-group">
				<input class="form-control btn-success" data-toggle='modal' data-target='#modalAddSoftware' value='Adicionar'  type="button"/>
				</div>
			</div>
			<div class="form-group col-sm-2">
				<div class="form-group">
					<label for="codareatelefone">Cód. Área</label>
					<input type="text" class="form-control" name="codareatelefone" value="<?= $codarea;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-4">
				<div class="form-group">
					<label for="telefones">Telefone</label>
					<input type="text" class="form-control" name="telefones" value="<?= $telefones;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-2">
				<div class="form-group">
					<label for="codareacelular">Cód. Área</label>
					<input type="text" class="form-control" name="codareacelular" value="<?= $codareacel;?>"/>
				</div>
			</div>	
			<div class="form-group col-sm-4">	
				<div class="form-group">
					<label for="celular">Celular</label>
					<input type="text" class="form-control" name="celular" value="<?= $celular;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="endereco">Endereço</label>
					<input type="text" class="form-control" name="endereco" value="<?= $endereco;?>"/>
				</div>
				<div class="form-group">
					<label for="numero">Número</label>
					<input type="text" class="form-control" name="numero" value="<?= $numero;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="complemento">Complemento</label>
					<input type="text" class="form-control" name="complemento" value="<?= $complemento;?>"/>
				</div>
				<div class="form-group">
					<label for="bairro">Bairro</label>
					<input type="text" class="form-control" name="bairro" value="<?= $bairro;?>"/>
				</div>
			</div>
			
			<div class="form-group col-sm-4">
				<div class="form-group">
				<label for="cep">CEP</label>
				<input type="text" class="form-control" name="cep" value="<?= $cep;?>"/>
				</div>
			</div>
		
			<div class="form-group col-sm-4">				
				<div class="form-group">
					<label for="cidade">Cidade</label>
					<input type="text" class="form-control" name="cidade" value="<?= $cidade;?>"/>
				</div>
			</div>
			
			<div class="form-group col-sm-4">
				<div class="form-group">
					<label for="uf">UF</label>
					<input type="text" class="form-control" name="uf" value="<?= $uf;?>"/>
				</div>
			</div>
		</div>	
		
		<div class="col-sm-12">
			<div class="panel-group" id="accordion-test-2">
				<div class="panel panel-success panel-color">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
								Adicionar e-mails
							</a>
						</h4>
					</div>
					<div id="collapseOne-2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
						<div class="panel-body">
						<p>Separe os itens por vírgula (,)</p>
						<textarea class="wysihtml5-textarea form-control" name="contatos" id="contatos" rows="9" ><?=$string_contato;?></textarea>
						</div>
					</div>
				</div>
			</div>	
		</div>	
		
	</div>
</div>
<?= ((isset($id)) ? "<input type='hidden' name='id' value='$id'/>" : '');?>
<input type="hidden" name="retorno" value="<?= $retorno;?>" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
	<input type="hidden" name="tbl" value="clientes" />
	<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
<div class="form-group">
	<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" data-objeto="form-dados-clientes">
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
					<h3 class="panel-title">Indentificação</h3>
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
								<input type="text" class="form-control" name="tipo_bd" >
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
					<input type="hidden" name="tbl" value="pav" />
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
</script>