<?php
$querySelect = "SELECT * FROM modulos WHERE lixo = 0 AND id_pai = 0";
include("../controllers/model.inc.php");
$e = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM modulos WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$e->queryFree($qry);	
	#if($result->num_rows > 0){  Indica que um registro foi selecionado para edição
	
	$edicao = $_POST;
	$edicao = $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$valor 	 		= $edicao['value'];
	$descritivo 	= $edicao['descricao'];	
	$media			= $edicao['media'];
	$id_pai			= $edicao['id_pai'];
	$admin			= $edicao['admin'];
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$valor 	 		= NULL;
	$descritivo 	= NULL;	
	$media			= NULL;
	$id_pai			= NULL;
	$admin			= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Módulos</h4>
	  <p>Gerenciador dos módulos do sistema</p>
	</div>
	<div class="content-sized">';
}
?>
	<form id="form-modulo">
		<div class="form-group">
			<label for="nome">Nome do módulo</label>
			<input type="text" class="form-control" name="nome" value="<?= $nome;?>"/>
		</div>
		<div class="form-group">
			<label for="value">Página a ser inicializada</label>
			<input type="text" class="form-control" name="value" value="<?= $valor;?>"/>
		</div>
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<input type="text" class="form-control" name="descricao" value="<?= $descritivo;?>" maxlength="50"/>			
		</div>
		<div class="form-group">
			<label for="media">Ícone</label>
			<input type="text" class="form-control" name="media"  value="<?= $media;?>"/>			
		</div>
		<div class="form-group">
			<label for="id_pai">Módulo Pai</label>
			<select class="form-control" name="id_pai">
			<?php			
			if(isset($id_pai)){
			  	echo "
				<option value='0' ".($id_pai == 0 ? 'selected' : '').">Não</option>
				<option value='1' ".($id_pai == 1 ? 'selected' : '').">Sim</option>
				";
			}else{	
				echo "
				<option value='0'>Não</option>
				<option value='1'>Sim</option>
				"; 
			}			  
			?>
			</select>		
		</div>
		<div class="form-group">
			<label for="admin">Ambiente</label>
			<input type="text" class="form-control" class="admin" name="admin" value="<?= $admin;?>"/>
		</div>
		<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" objeto="form-modulo">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="modulos" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>
	
</div>