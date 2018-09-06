<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$a = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM planos WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$a->queryFree($qry);	
	$edicao 	= $_POST;
	$edicao 	= $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$limite 		= $edicao['limite'];
	$valor_unit 	= $edicao['valor_unit'];	
	$valor_total	= $edicao['valor_total'];
	$criado_em		= $edicao['criado_em'];
	$atualizado_em	= $edicao['atualizado_em'];
	$ativo			= $edicao['ativo'];	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$nome			= NULL;
	$limite 		= NULL;
	$valor_unit 	= NULL;
	$valor_total	= NULL;
	$criado_em		= NULL;
	$atualizado_em	= NULL;
	$ativo			= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Planos</h4>
	  <p>Gerenciador dos planos</p>
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
			<label for="nome">Título</label>
				<input type="text" class="form-control" name="nome" value="<?= $nome;?>"/>
			</div>
		</div>	
			
		<div class="row">	
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="limite">Limite de atendimentos</label>
					<input type="text" class="form-control" name="limite" value="<?= $limite;?>"/>
				</div>
			</div>
			<div class="form-group col-sm-6">
				<div class="form-group">
					<label for="valor_unit">Preço Unitário</label>
					<input type="text" class="form-control dinheiro" name="valor_unit" value="<?= $valor_unit;?>"/>
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="form-group col-sm-6">
				<label for="ativo">Ativar plano?</label>
				<select class="form-control" name="ativo">							
					<?php					
					if(isset($id)){
						$queryAtivo	= "SELECT ativo FROM planos WHERE id = $id";
						$result = $a->queryFree($queryAtivo);
						while($linhas = $result->fetch_assoc()){
							echo "
							<option value='0' ".($linhas['status']== 0  ? 'selected' : '').">Sim</option>
							<option value='1' ".($linhas['status']== 1  ? 'selected' : '').">Não</option>
							";
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
<input type="hidden" name="tbl" value="planos" />
<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
</div>
<div class="form-group">
	<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" data-objeto="form-dados-perfil">
</div>
</form>