<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$a = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT * FROM groups WHERE lixo = 0 AND id = ".$_POST['id'];	
	$a->queryFree($qry);	
	$edicao 	= $result->fetch_assoc();
	
	$id		   				= $edicao['id'];
	$name					= $edicao['name'];
	$tipo	 				= $edicao['tipo'];
	$finalidade_especial 	= $edicao['finalidade_especial'];		
	$flag	 		= "update";
}else{
	
	$id		   				= NULL;
	$name					= NULL;
	$tipo	 				= NULL;
	$finalidade_especial 	= NULL;	
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Grupos</h4>
	  <p>Gerenciador dos grupos</p>
	</div>
	<div class="content-sized">';
}
?>
<form id="form-dados-perfil">
	<div class="panel panel-color panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">Adicionar Grupos de Atendimento</h3>
		</div>
		<div class="panel-body">			
			<div class="row">	
				<div class="form-group col-sm-6">
					<div class="form-group">
						<label for="criado_em">Nome</label>
						<input type="text" class="form-control" name="name" value="<?= $name;?>"/>
					</div>
					<div class="form-group">
						<label for="finaliza_em">Tipo</label>
						<select class="form-control" name="tipo" title="Tipos pre-definidos para finalidades especiais">
							<option>Não especifcado</option>
							<option value='Auditoria' <?=($edicao['tipo'] == 'Auditoria' ? "selected" : ''); ?> >Auditoria</option>
							<option value='Vendas' <?=($edicao['tipo'] == 'Vendas' ? "selected" : ''); ?> >Vendas</option>
						</select>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="finalidade_especial">Finalidade Especial</label>
					<select class="form-control" name="finalidade_especial" title="A finalidade especial identifica os grupos que recebem chamados via e-mail de destinatários sem contrato assinado">	
						<?php
						if(!is_null($edicao['finalidade_especial'])){
							echo "
						<option value='0' ".($edicao['finalidade_especial'] == 0 ? "selected" : '')." >Não </option>
						<option value='1' ".($edicao['finalidade_especial'] == 1 ? "selected" : '')." >Sim </option>";
						}else{
							echo "
						<option value='0' >Não </option>
						<option value='1' >Sim </option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>	
	</div>

	<section class="input_hidden">		
		<?= ((isset($id)) ? "<input type='hidden' name='id' value='$id'/>" : ''); ?>
		<input type="hidden" name="retorno" value="<?= $retorno;?>" />
		<input type="hidden" name="flag" value="<?= $flag;?>" />
		<input type="hidden" name="tbl" value="groups" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</section>
	<div class="form-group">
		<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" data-objeto="form-dados-perfil">
	</div>
</form>
<script type="text/javascript">
NProgress.done();
</script>