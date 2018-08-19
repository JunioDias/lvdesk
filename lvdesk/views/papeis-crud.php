<?php
if(isset($_POST['id'])){
	$qry = "SELECT * FROM privilegios WHERE lixo = 0 AND id='".$_POST['id']."'";
	include("../controllers/model.inc.php");
	$e = new Model();
	$e->queryFree($qry);	
	
	#if($result->num_rows > 0){  Indica que um registro foi selecionado para edição
	
	$edicao = $_POST;
	$edicao = $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;

	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Papéis</h4>
	  <p>Gerenciador dos papéis do sistema</p>
	</div>
	<div class="content-sized">';
}
?>
	<form id="form-modulo">
		<div class="form-group">
			<label for="nome">Nome</label>
			<input type="text" class="form-control" class="nome" name="nome" value="<?= $nome;?>"/>
		</div>
		<div class="form-group">		
		<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" data-objeto="form-modulo">
		</div>
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="retorno" value=".content-sized" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="privilegios" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>
	
</div>