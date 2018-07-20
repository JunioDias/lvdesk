<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$a = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM perfil WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$a->queryFree($qry);	
	$edicao 	= $_POST;
	$edicao 	= $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$titulo			= $edicao['titulo'];
	$data_inicio 	= $edicao['data_inicio'];
	$data_fim 		= $edicao['data_fim'];	
	$id_categoria	= $edicao['id_categoria'];
	$id_privilegio	= $edicao['id_privilegio'];
	$id_menu		= $edicao['id_menu'];	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$titulo			= NULL;
	$data_inicio 	= NULL;
	$data_fim 		= NULL;
	$id_categoria	= NULL;
	$id_privilegio	= NULL;
	$id_menu		= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Perfil</h4>
	  <p>Gerenciador dos perfis de regra</p>
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
				<div class="form-group">
					<label for="data_inicio">Data de início</label>
					<input type="date" class="form-control" name="data_inicio" value="<?= $data_inicio;?>"/>
				</div>
				<div class="form-group">
					<label for="data_fim">Data de finalização</label>
					<input type="date" class="form-control" name="data_fim" value="<?= $data_fim;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<label for="id_categoria">Categoria</label>
				<select class="form-control" name="id_categoria">							
					<?php	
					$query = "SELECT * FROM categorias WHERE lixo = 0";
					$resultado = $a->queryFree($query);
					if(isset($resultado)){
						echo "<option>Nenhum registro encontrado</option>";
					}else{
						while($linhas = $resultado->fetch_assoc()){					
							echo "<option value='".$row['id']."' ".($row['id'] == $linhas['id_categoria'] ? "selected" : '').">".$row['nome']."</option>";						
						}
					}							
					?>
				</select>
			</div>
			<div class="form-group col-sm-6">
				<label for="id_privilegio">Tipo de Privilégio</label>
				<select class="form-control" name="id_privilegio">							
					<?php	
					$query = "SELECT * FROM privilegios WHERE lixo = 0";
					$resultado = $a->queryFree($query);
					if(isset($resultado)){
						echo "<option>Cadastre um perfil antes de usar</option>";
					}else{
						while($linhas = $resultado->fetch_assoc()){					
							echo "<option value='".$row['id']."' ".($row['id'] == $linhas['id_privilegio'] ? "selected" : '').">".$row['nome']."</option>";						
						}
					}							
					?>
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
<input type="hidden" name="tbl" value="perfil" />
<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
</div>
<div class="form-group">
	<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" objeto="form-dados-perfil">
</div>
</form>