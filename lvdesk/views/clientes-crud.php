<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$a = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM clientes WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$a->queryFree($qry);	
	$edicao 	= $_POST;
	$edicao 	= $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$usuario 	 	= $edicao['usuario'];
	$data_contrato 	= $edicao['data_contrato'];	
	$cpf_cnpj		= $edicao['cpf_cnpj'];
	$contato		= $edicao['contato'];
	$provedor		= $edicao['provedor'];
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
		</div>
	</div>
</div>
<div class="panel panel-color panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Detalhes Contratuais</h3>
	</div>
	<div class="panel-body">			
		<div class="row">	
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="data_contrato">Início do Contrato</label>
					<input type="date" class="form-control" name="data_contrato" value="<?= $data_contrato;?>"/>
				</div>
				<div class="form-group">
					<label for="cpf_cnpj">CPF/CNPJ</label>
					<input type="text" class="form-control" name="cpf_cnpj" value="<?= $cpf_cnpj;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="contato">Contato Legal</label>
					<input type="text" class="form-control" name="contato" value="<?= $contato;?>"/>
				</div>
				<div class="form-group">
					<label for="provedor">Software de Gestão</label>
					<input type="text" class="form-control" name="provedor" value="<?= $provedor;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="codareatelefone">Cód. Área</label>
					<input type="text" class="form-control" name="codareatelefone" value="<?= $codarea;?>"/>
				</div>
				<div class="form-group">
					<label for="telefones">Telefone</label>
					<input type="text" class="form-control" name="telefones" value="<?= $telefones;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="codareacelular">Cód. Área</label>
					<input type="text" class="form-control" name="codareacelular" value="<?= $codareacel;?>"/>
				</div>
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
	</div>
</div>
<div class="panel panel-color panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Detalhes Técnicos</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="form-group">
				<label for="tipo_perfil">Tipo de Perfil</label>
				<select class="form-control" name="tipo_perfil">							
					<?php	
					$query = "SELECT * FROM perfil WHERE id = $tipo_perfil AND lixo = 0";
					$resultado = $a->queryFree($query);
					if(isset($resultado)){
						echo "<option>Cadastre um perfil antes de usar</option>";
					}else{
						while($linhas = $resultado->fetch_assoc()){					
							echo "<option value='".$row['id']."' ".($row['id'] == $linhas['tipo_perfil'] ? "selected" : '').">".$row['nome']."</option>";						
						}
					}							
					?>
				</select>	
			</div>
		</div>
		
		<?php 
		if(isset($id)){
			echo "<input type='hidden' name='id' value='$id'/>";
		}
		?>
		<input type="hidden" name="retorno" value="<?= $retorno;?>" />
		<input type="hidden" name="flag" value="<?= $flag;?>" />
		<input type="hidden" name="tbl" value="clientes" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</div>
</div>
<div class="form-group">
	<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" objeto="form-dados-clientes">
</div>
</form>