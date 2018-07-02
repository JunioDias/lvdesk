<?php
if(isset($_POST['id'])){
	$qry = "SELECT * FROM pav WHERE lixo = 0 AND id='".$_POST['id']."'";
	include("../controllers/model.inc.php");
	$e = new Model();
	$e->queryFree($qry);	
	#if($result->num_rows > 0){  Indica que um registro foi selecionado para edição
	
	$edicao = $_POST;
	$edicao = $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$tipo_bd		= $edicao['tipo_bd'];
	$nome_bd 	 	= $edicao['nome_bd'];
	$host 			= $edicao['host'];	
	$usuario		= $edicao['usuario'];
	$senha			= $edicao['senha_pav'];
	$porta			= $edicao['porta'];
	$script			= $edicao['script'];
	$validado		= $edicao['validado'];
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$bd				= NULL;
	$tipo_bd		= NULL;
	$nome_bd 	 	= NULL;
	$host 			= NULL;	
	$usuario		= NULL;
	$senha			= NULL;
	$porta			= NULL;
	$script			= NULL;
	$validado		= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Driver</h4>
	  <p>Cadastro dos provedores para acesso</p>
	</div>
	<div class="content-sized">';
}
?>
	<form id="form-dados">
	<div class="form-group">
		<label for="nome">Nome do Provedor</label>
		<input type="text" class="form-control" name="nome" value="<?= $nome;?>">
	</div>
	<div class="form-group">
		<label for="tipo_bd">Tipo do banco de dados</label>
		<input type="text" class="form-control" name="tipo_bd" value="<?= $tipo_bd;?>">
	</div>
	<div class="form-group">
		<label for="nome_bd">Nome do bando de dados</label>
		<input type="text" class="form-control" name="nome_bd" value="<?= $nome_bd;?>">
	</div>
	<div class="form-group">
		<label for="host">Host</label>
		<input type="text" class="form-control" name="host" value="<?= $host;?>">			
	</div>
	<div class="form-group">
		<label for="porta">Porta</label>
		<input type="text" class="form-control" name="porta" value="<?= $porta;?>">
	</div>
	<div class="form-group">
		<label for="usuario">Usuário</label>
		<input type="text" class="form-control" name="usuario" value="<?= $usuario;?>">
	</div>
	<div class="form-group">
		<label for="senha_pav">Senha</label>
		<input type="text" class="form-control" name="senha_pav" value="<?= $senha;?>">
	</div>
	<div class="form-group">
		<label for="script">Script</label>
		<textarea class="wysihtml5-textarea form-control" rows="9" id="script" name="script"><?= $script;?></textarea>
	</div>
	<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" objeto="form-dados">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="retorno" value=".content-sized" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="pav" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>	
</div>
