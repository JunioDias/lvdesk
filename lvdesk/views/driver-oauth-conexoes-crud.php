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
	$url			= $edicao['url'];
	$grant_type 	= $edicao['grant_type'];
	$client_id	 	= $edicao['client_id'];	
	$client_secret	= $edicao['client_secret'];
	$username		= $edicao['username'];
	$password		= $edicao['password'];
	$script			= $edicao['script'];
	$validado		= $edicao['validado'];
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$url			= NULL;
	$grant_type		= NULL;
	$client_id 	 	= NULL;
	$client_secret	= NULL;	
	$username		= NULL;
	$password		= NULL;
	$porta			= NULL;
	$script			= NULL;
	$validado		= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Driver OAuth</h4>
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
		<label for="url">Endereço de conexão</label>
		<input type="text" class="form-control" name="url" value="<?= $url;?>">
	</div>
	<div class="form-group">
		<label for="grant_type">Tipo de segurança</label>
		<input type="text" class="form-control" name="grant_type" value="<?= $grant_type;?>">
	</div>
	<div class="form-group">
		<label for="client_id">Id de identificação como cliente</label>
		<input type="text" class="form-control" name="client_id" value="<?= $client_id;?>">			
	</div>
	<div class="form-group">
		<label for="client_secret">Segredo do cliente</label>
		<input type="text" class="form-control" name="client_secret" value="<?= $client_secret;?>">
	</div>
	<div class="form-group">
		<label for="username">Usuário</label>
		<input type="text" class="form-control" name="username" value="<?= $username;?>">
	</div>
	<div class="form-group">
		<label for="password">Senha</label>
		<input type="text" class="form-control" name="password" value="<?= $password;?>">
	</div>
	<div class="form-group">
		<label for="script">Script</label>
		<textarea class="wysihtml5-textarea form-control" rows="9" id="script" name="script"><?= $script;?></textarea>
	</div>
	<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" data-objeto="form-dados">
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
<script>
	jQuery(document).ready(function(){
		$('#script').wysihtml5({
		  locale: 'pt-BR'
		}); 
	});
</script>