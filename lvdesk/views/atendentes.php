<div class="page-header-title">
  <h4 class="page-title">Atendentes</h4>
  <p>Gerenciador dos atendentes do sistema</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/atendentes-crud.php">
<table class="table table-hover" id="tabela">
<thead>
  <tr class="filtro">
	<th>Id <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Nome <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
	<th>e-mail <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Ações</th>
  </tr>
  <tr class="input-filtro" style="display:none;">
	<th><input type="text" class="form-control" id="txtColuna1"/></th>
	<th><input type="text" class="form-control" id="txtColuna2"/></th>
	<th><input type="text" class="form-control" id="txtColuna3"/></th>
	<th></th>
  </tr> 
</thead>
<tbody>
<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");

$query = "SELECT * FROM atendentes WHERE lixo = 0";
$nomediv		= ".content-sized";				#nome da div onde o callback vai ocorrer
$tabela  		= "atendentes";					#tabela principal, alvo da rotina
$cbkedit		= "views/atendentes-crud.php";	#callback do botão Editar
$cbkdel 		= "views/atendentes.php";  		#callback do botão Excluir
$link			= "controllers/sys/crud.sys.php";
$i = 1;
$botoes = new Acoes();
$a = new Model();
$a->queryFree($query);
if(!$result){
	echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";
}
else{
	while($linhas = $result->fetch_assoc()){
		echo("
		<tr>
		<td>".$linhas['id']."</td>
		<td>".$linhas['nome']."</td>
		<td class='text-success'>".$linhas['usuario']."</td>
		<td>");	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("</td>
		</tr>
		");	
		$i++;
	}
}
?>	
</tbody>
</table>
<form id='form_action'>
	<!--Início do modal de confirmação -->
	<div id='confirma' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>
	  <div class='modal-dialog'>
	    <div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Tem certeza?</h4>
		  </div>
		  <div class="modal-body">	
			<p>O registro selecionado será excluído.</p>
		  </div>
		  <div class="modal-footer">
			<input class='btn btn-success waves-effect' data-dismiss="modal" value='Não'/>
			<input objeto='form_action' class='btn btn-danger botao rtrn-conteudo' value='Sim'/>
		  </div>
		</div>
	  </div>
	</div>
	<!--Fim do modal de confirmação -->
	<input type='hidden' name='tbl' value='<?=$tabela;?>' />
	<input type='hidden' name='retorno' value='<?=$nomediv;?>' />
</form>
</div>
<script>
NProgress.done();
</script>