<div class="page-header-title">
  <h4 class="page-title">Menus</h4>
  <p>Gerenciador dos submenus para módulos do sistema</p>
</div>
<div class="content-sized">
<?php
$retorno = ".content-sized";
include("../controllers/model.inc.php");
$e = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM menus WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$result = $e->queryFree($qry);
	$edicao = $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$valor			= $edicao['valor'];
	$descricao 	 	= $edicao['descricao'];
	$media 			= $edicao['media'];	
	$id_pai			= $edicao['id_pai'];
	$admin			= $edicao['admin'];	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$valor			= NULL;
	$descricao 	 	= NULL;
	$media 			= NULL;	
	$id_pai			= NULL;
	$admin			= NULL;
	$flag	 		= "add";
}
?>
<form id="form-dados">
	<div class="form-group">
		<label for="nome">Nome do menu</label>
		<input type="text" class="form-control" name="nome" value="<?= $nome;?>">
	</div>
	<div class="form-group">
		<label for="valor">Caminho da página acessada</label>
		<input type="text" class="form-control" name="valor" value="<?= $valor;?>">
	</div>
	<div class="form-group">
		<label for="descricao">Descrição</label>
		<input type="text" class="form-control" name="descricao" value="<?= $descricao;?>">
	</div>
	<div class="form-group">
		<label for="media">Ícone</label>
		<input type="text" class="form-control" name="media" value="<?= $media;?>">			
	</div>
	<div class="form-group">
		<label for="id_pai">Módulo Pai</label>
		<select class="form-control" name="id_pai">
		<?php
		$query 	= "SELECT id, nome FROM modulos WHERE id_pai = 1 AND lixo = 0";
		if(isset($id_pai)){
			$result = $e->queryFree($query);
			while($linhas = $result->fetch_assoc()){
				echo "<option value='".$linhas['id']."' ".($linhas['id']==$id_pai ? 'selected' : '').">".$linhas['nome']."</option>";
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
	<div class="form-group">
		<label for="admin">Ambiente</label>
		<input type="text" class="form-control" name="admin" value="<?= $admin;?>">
	</div>
	
	<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" objeto="form-dados">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="retorno" value=".content-sized" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="menus" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
</form>	
</div>
