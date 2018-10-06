<div class="page-header-title">
  <h4 class="page-title">Provedores</h4>
  <p>Controle de cadastros por entidade</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/provedores-crud.php">
<table class="table table-hover" id="tabela">
<thead>
  <tr class="filtro">
	<th>Entidade <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Provedor <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
	<th>Tipo <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
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

$query = "SELECT pav_dados.*, c.nome AS cliente_nome, pav.nome  AS pav_nome FROM `pav_dados` 
JOIN clientes AS c ON id_clientes = c.id 
JOIN pav ON id_pav = pav.id
WHERE pav_dados.lixo = 0";

$nomediv		= ".content-sized";				#nome da div onde o callback vai ocorrer
$tabela  		= "pav_dados";					#tabela principal, alvo da rotina
$cbkedit		= "views/provedores-crud.php";	#callback do botão Editar
$cbkdel 		= "views/provedores.php";  		#callback do botão Excluir
$link			= "controllers/sys/crud.sys.php";
$i = 1;
$botoes = new Acoes();
$a = new Model();
global $select;
$i = 0;
$teste = $a->queryFree($query);
$foo = $teste->fetch_assoc();
if($foo['id'] != ''){
	$resultado = $a->queryFree($query);
	while($linhas = $result->fetch_assoc()){
		echo("
		<tr>
		<td>".$linhas['cliente_nome']."</td>
		<td>".$linhas['pav_nome']."</td>
		<td class='text-success'>".$linhas['tipo']."</td>
		<td>");	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("</td>
		</tr>
		");	
		$i++;
	}
}else{
	echo"<tr><td colspan='4'>Nenhum registro foi encontrado.</td></tr>";
}
?>	
</tbody>
</table>
<form id='form_action'>
	<!--Início do modal de confirmação -->
	<div id='confirma' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>
	  <div class="modal-dialog">
	    <div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Tem certeza?</h4>
		  </div>
		  <div class="modal-body">	
			<p>O registro selecionado será excluído.</p>
		  </div>
		  <div class="modal-footer">
			<input class='btn btn-danger waves-effect remove-inputs' data-dismiss="modal" value='Não'/>
			<input data-objeto='form_action' class='btn btn-success rtrn-conteudo' value='Sim'/>			
		  </div>
		</div>
	  </div>
	</div>
	<section class="input_hidden">
		<input type='hidden' name='tbl' value='<?=$tabela;?>' />
		<input type='hidden' name='retorno' value='<?=$nomediv;?>' />	
	</section>
</form>
</div>
<script>
NProgress.done();
</script>