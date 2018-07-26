<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$a = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM produtos WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$a->queryFree($qry);	
	$edicao 	= $_POST;
	$edicao 	= $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$titulo			= $edicao['titulo'];
	$id_auditoria	= $edicao['id_auditoria'];	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$titulo			= NULL;
	$id_auditoria	= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Produtos</h4>
	  <p>Gerenciador dos produtos</p>
	</div>
	<div class="content-sized">';
}
?>
<form id="form-dados-perfil">
<div class="panel panel-color panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Identificação</h3>
	</div>
	<div class="panel-body">			
		<div class="row">
			<div class="form-group">
			<label for="titulo">Título</label>
				<input type="text" class="form-control" name="titulo" value="<?= $titulo;?>"/>
			</div>
		</div>			
		
		<div class="row">
			<div class="form-group col-sm-6">
					<label for="id_auditoria">Auditoria</label>
				<select class="form-control" name="id_auditoria">							
					<option value='1' <?=($id_auditoria == 1 ? "selected" : '')?>>Sim</option>
					<option value='0' <?=($id_auditoria == 0 ? "selected" : '')?>>Não</option>					
				</select>
			</div>
		</div>
	</div>
</div>

<div>		
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="retorno" value="<?= $retorno;?>" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
	<input type="hidden" name="tbl" value="produtos" />
	<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
</div>
<div class="form-group">
	<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" objeto="form-dados-perfil">
</div>
</form>