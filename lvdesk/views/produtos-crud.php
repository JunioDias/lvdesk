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
	$duracao 		= $edicao['duracao'];
	$valor 			= $edicao['valor'];	
	$id_planos		= $edicao['id_planos'];
	$id_privilegio	= $edicao['id_privilegio'];
	$id_auditoria	= $edicao['id_auditoria'];
	$id_menu		= $edicao['id_menu'];	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$titulo			= NULL;
	$duracao 		= NULL;
	$valor	 		= NULL;
	$id_planos		= NULL;
	$id_privilegio	= NULL;
	$id_auditoria	= NULL;
	$id_menu		= NULL;
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
				<div class="form-group">
					<label for="duracao">Duração (em dias corridos)</label>
					<input type="text" class="form-control" name="duracao" value="<?= $duracao;?>"/>
				</div>
				<div class="form-group">
					<label for="valor">Preço Final</label>
					<input type="text" class="form-control" name="valor" value="<?= $valor;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<label for="id_planos">Planos</label>
				<select class="form-control" name="id_planos">							
					<?php	
					$query = "SELECT * FROM planos WHERE lixo = 0";
					$resultado = $a->queryFree($query);
					if(isset($resultado)){
						while($linhas = $resultado->fetch_assoc()){					
							echo "<option value='".$linhas['id']."' ".($linhas['id'] == $id_planos ? "selected" : '').">".$linhas['nome']."</option>";						
						}
					}else{
						echo "<option>Nenhum registro encontrado</option>";					
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
						while($linhas = $resultado->fetch_assoc()){					
							echo "<option value='".$linhas['id']."' ".($linhas['id'] == $id_privilegio ? "selected" : '').">".$linhas['nome']."</option>";						
						}	
					}else{
						echo "<option>Cadastre um perfil antes de usar</option>";
					}							
					?>
				</select>
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