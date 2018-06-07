<?php
if(isset($_POST['id'])){
	$qry = "SELECT * FROM usuarios WHERE lixo = 0 AND id='".$_POST['id']."'";
	include("../controllers/model.inc.php");
	$e = new Model();
	$e->queryFree($qry);	
	#if($result->num_rows > 0){  Indica que um registro foi selecionado para edição
	
	$edicao = $_POST;
	$edicao = $result->fetch_assoc();
	
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
	$qtd_filhos		= $edicao['quantidade_filhos'];
	$id_privilegio	= $edicao['id_privilegio'];
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
	$qtd_filhos		= NULL;
	$id_privilegio	= NULL;
	$foto			= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Usuários</h4>
	  <p>Gerenciador dos usuários do sistema</p>
	</div>
	<div class="content-sized">';
}
?>
	<form id="form-modulo">
		<div class="form-group">
			<label for="nome">Nome completo do usuário</label>
			<input type="text" class="form-control" name="nome" value="<?= $nome;?>"/>
		</div>
		<div class="form-group">
			<label for="usuario">Nome de usuário (e-mail)</label>
			<input type="text" class="form-control" name="usuario" value="<?= $usuario;?>"/>
		</div>
		<div class="form-group">
			<label for="data_nasc">Data de nascimento</label>
			<input type="text" class="form-control" name="data_nascimento" value="<?= $data_nasc;?>"/>
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
			<label for="quantidade_filhos">Quantidade de filhos</label>
			<input type="text" class="form-control" name="quantidade_filhos" value="<?= $qtd_filhos;?>"/>
		</div>
		<div class="form-group">
			<label for="id_privilegio">Privilégio</label>
			<input type="text" class="form-control" name="id_privilegio" value="<?= $id_privilegio;?>"/>
		</div>
		<div class="row">
			<div class="col-sm-6">
			  <div class="form-group">
				<label for="foto">Imagem</label>
				<input type="text" class="form-control" name="foto" value="<?= $foto;?>"/>
			  </div>
			</div>
			<div class="col-sm-6">
				<label >Enviar nova imagem</label >
				<input class="filestyle" data-input="false" id="filestyle-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1" type="file"><div class="bootstrap-filestyle input-group"><span class="group-span-filestyle " tabindex="0"><label for="filestyle-1" class="btn btn-default "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> <span class="buttonText">Selecionar</span></label></span></div>
			</div>
		</div>
		<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" objeto="form-modulo">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="usuarios" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>
	
</div>