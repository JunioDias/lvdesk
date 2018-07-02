<?php
$retorno	= ".content-sized";

if(isset($_POST['id'])){
	$qry = "SELECT * FROM usuarios WHERE lixo = 0 AND id='".$_POST['id']."'";
	include("../controllers/model.inc.php");
	$e = new Model();
	$e->queryFree($qry);	
	#if($result->num_rows > 0){  Indica que um registro foi selecionado para edição
	
	$edicao 	= $_POST;
	$edicao 	= $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$usuario 	 	= $edicao['usuario'];
	$password	 	= $edicao['senha'];	
	
	$foto			= $edicao['foto'];
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$usuario 	 	= NULL;
	$password	 	= NULL;	
		
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
	<form id="form-modulo" data-toggle="validator">
		<div class="form-group">
			<label for="nome">Nome completo do usuário</label>
			<input type="text" class="form-control" name="nome" value="<?= $nome;?>"/>
		</div>
		<div class="form-group">
			<label for="usuario">Nome de usuário (e-mail)</label>
			<input type="text" class="form-control" name="usuario" value="<?= $usuario;?>"/>
		</div>
		<div class="form-group">
			<label for="senha" class="control-label">Password</label>
			<input type="password" class="form-control" id="inputPassword" name="senha" value="<?= $password;?>"/>
		</div>
		<div class="form-group">
			<label for="c_password" class="control-label">Confirma Password</label>
			<input type="password" class="form-control" id="inputConfirm" data-match="#inputPassword" data-match-error="Atenção! As senhas não estão iguais." required />
			<div class="help-block with-errors"></div>

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
				<input class="filestyle" data-input="false" id="filestyle-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1" type="file" name="foto" title="Extensões válidas .jpg, .jpeg, .gif e .png"><div class="bootstrap-filestyle input-group"><span class="group-span-filestyle " tabindex="0"><label for="filestyle-1" class="btn btn-default "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> <span class="buttonText">Selecionar</span></label></span></div>
			</div>
		</div>
		<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" objeto="form-modulo">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="retorno" value="<?= $retorno;?>" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="usuarios" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>
	
</div>