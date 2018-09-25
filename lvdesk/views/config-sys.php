<?php
include("../controllers/model.inc.php");	
$retorno = ".content-sized";
$a = new Model();
$qry = "SELECT * FROM config WHERE lixo = 0";	
$result = $a->queryFree($qry);	
$i = 0;
$flag = "update";
?>
<div class="page-header-title">
	  <h4 class="page-title">Configurações</h4>
	  <p>Parametrização do sistema</p>
	</div>
	<div class="content-sized">
<form id="form-dados-perfil">
	<div class="panel panel-color panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">Geral</h3>
		</div>
		<div class="panel-body">			
			<div class="row">
				<div class="form-group col-sm-12">				
					<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/atendentes-crud.php">
					<table class="table table-hover">
					<thead>
					  <tr >
						<th>Id <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
						<th>Nome do parâmetro <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
						<th>Valor <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
						<th>Descrição<a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
					  </tr>
					  
					</thead>
					<tbody>
					<?php	
					while($linhas = $result->fetch_assoc()){
						echo("
						<tr>
						<td>".$linhas['id']."</td>
						<td>".$linhas['nome']."</td>
						<td><input class='form-control' type='text' value='".$linhas['valor']."' ></td>
						<td><input class='form-control' type='text' value='".$linhas['obs']."' ></td>
						</tr>
						");	
					}									
					?>			
					</tbody>
					</table>
				</div>					
			</div>
		</div>	
	</div>

	<section class="input_hidden">		
		<?= ((isset($id)) ? "<input type='hidden' name='id' value='$id'/>" : ''); ?>
		<input type="hidden" name="retorno" value="<?= $retorno;?>" />
		<input type="hidden" name="flag" value="<?= $flag;?>" />
		<input type="hidden" name="tbl" value="config" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</section>
	<div class="form-group">
		<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" data-objeto="form-dados-perfil">
	</div>
</form>
<script type="text/javascript">
NProgress.done();
</script>