<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$e = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM atendentes WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$e->queryFree($qry);	
	$edicao 	= $_POST;
	$edicao 	= $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$usuario 	 	= $edicao['usuario'];
	$data_nasc	 	= $edicao['data_nascimento'];	
	$cpf			= $edicao['cpf'];
	$estado_civil	= $edicao['estado_civil'];
	$profissao		= $edicao['profissao'];
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
	$tipo_atendente	= $edicao['tipo_atendente'];	
	$foto			= $edicao['foto'];
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$usuario 	 	= NULL;
	$data_nasc	 	= NULL;	
	$cpf			= NULL;
	$estado_civil	= NULL;
	$profissao		= NULL;
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
	$tipo_atendente	= NULL;
	$foto			= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Atendentes</h4>
	  <p>Gerenciador dos atendentes do sistema</p>
	</div>
	<div class="content-sized">';
}
?>
	<form id="form-modulo">
		<div class="form-group">
			<label for="nome">Usuário</label>
			<select class="form-control" name="nome" id="atendentes-select-user">
			<option user=''>Selecione um usuário...</option>
			<?php
			$query 	= "SELECT id, nome, usuario FROM usuarios WHERE lixo = 0";
			if(is_null($id)){
				$result = $e->queryFree($query);
				while($linhas = $result->fetch_assoc()){
					echo "<option value='".$linhas['nome']."' user='".$linhas['usuario']."'>".$linhas['nome']."</option>";
				}		
			}else{	
				$result = $e->queryFree($query);
				while($linhas = $result->fetch_assoc()){
					echo "<option value='".$linhas['nome']."' user='".$linhas['usuario']."' ".($linhas['id']==$id ? 'selected' : '').">".$linhas['nome']."</option>";
				}
			}						
			?>
			</select>
		</div>
		<div class="form-group">
			<label for="usuario">Nome de usuário (e-mail)</label>
			<input type="text" class="form-control" name="usuario" />
		</div>
		<div class="form-group">
			<label for="data_nasc">Data de nascimento</label>
			<input type="date" class="form-control" name="data_nascimento" value="<?= $data_nasc;?>"/>
		</div>
		<div class="form-group">
			<label for="cpf">CPF</label>
			<input type="text" class="form-control" name="cpf" value="<?= $cpf;?>"/>
		</div>
		<div class="form-group">
			<label for="estado_civil">Estado Civil</label>
			<input type="text" class="form-control" name="estado_civil" value="<?= $estado_civil;?>"/>
		</div>
		<div class="form-group">
			<label for="profissao">Profissão</label>
			<input type="text" class="form-control" name="profissao" value="<?= $profissao;?>"/>
		</div>
		<div class="form-group">
			<label for="codareatelefone">Cód. Área</label>
			<input type="text" class="form-control" name="codareatelefone" value="<?= $codarea;?>"/>
		</div>
		<div class="form-group">
			<label for="telefones">Telefone</label>
			<input type="text" class="form-control" name="telefones" value="<?= $telefones;?>"/>
		</div>
		<div class="form-group">
			<label for="codareacelular">Cód. Área</label>
			<input type="text" class="form-control" name="codareacelular" value="<?= $codareacel;?>"/>
		</div>
		<div class="form-group">
			<label for="celular">Celular</label>
			<input type="text" class="form-control" name="celular" value="<?= $celular;?>"/>
		</div>
		<div class="form-group">
			<label for="endereco">Endereço</label>
			<input type="text" class="form-control" name="endereco" value="<?= $endereco;?>"/>
		</div>
		<div class="form-group">
			<label for="numero">Número</label>
			<input type="text" class="form-control" name="numero" value="<?= $numero;?>"/>
		</div>
		<div class="form-group">
			<label for="complemento">Complemento</label>
			<input type="text" class="form-control" name="complemento" value="<?= $complemento;?>"/>
		</div>
		<div class="form-group">
			<label for="bairro">Bairro</label>
			<input type="text" class="form-control" name="bairro" value="<?= $bairro;?>"/>
		</div>
		<div class="form-group">
			<label for="cep">CEP</label>
			<input type="text" class="form-control" name="cep" value="<?= $cep;?>"/>
		</div>
		<div class="form-group">
			<label for="cidade">Cidade</label>
			<input type="text" class="form-control" name="cidade" value="<?= $cidade;?>"/>
		</div>
		<div class="form-group">
			<label for="uf">UF</label>
			<input type="text" class="form-control" name="uf" value="<?= $uf;?>"/>
		</div>
		<div class="form-group">
			<label for="tipo_atendente">Tipo de atendente</label>
			<select class="form-control" name="tipo_atendente">
			<?php
			$query 	= "SELECT id, nome FROM tipo_atendentes WHERE lixo = 0";
			if(isset($id)){
				$result = $e->queryFree($query);
				while($linhas = $result->fetch_assoc()){
					echo "<option value='".$linhas['id']."' ".($linhas['id'] == $tipo_atendente ? 'selected' : '').">".$linhas['nome']."</option>";
				}		
			}else{	
				$result = $e->queryFree($query);
				while($linhas = $result->fetch_assoc()){
					echo "<option value='".$linhas['id']."'>".$linhas['nome']."</option>";
				} 
			}			  
			?>
			</select>
		</div>
		<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" objeto="form-modulo">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="retorno" value="<?= $retorno;?>" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="atendentes" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>
	
</div>