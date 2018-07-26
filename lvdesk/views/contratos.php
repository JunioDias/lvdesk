<div class="page-header-title">
  <h4 class="page-title">Contratos</h4>
  <p>Gerenciador dos contratos</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/contratos-crud.php">
<table class="table table-hover">
<thead>
  <tr>
	<th>Id</th>
	<th>Cliente</th>        
	<th>Data</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/actions.inc.php"); 
include("../controllers/model.inc.php");
	
$query 			= "SELECT * FROM contratos AS c INNER JOIN clientes AS cli ON id_cliente = cli.id WHERE c.lixo = 0 ";

$nomediv		= ".content-sized";				#nome da div onde o callback vai ocorrer
$tabela  		= "contratos";					#tabela principal, alvo da rotina
$cbkedit		= "views/contratos-crud.php";	#callback do botão Editar
$cbkdel 		= "views/contratos.php";  		#callback do botão Excluir
$link			= "controllers/sys/crud.sys.php";

$botoes = new Acoes();
$a = new Model();
$result = $a->queryFree($query);
$foo = $result->fetch_assoc();
if(is_null($foo['id'])){
	echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";
}
else{	
	foreach($foo as $linhas => $value){
		echo("
		<tr>
		<td>".$linhas['id']."</td>
		<td>".$linhas['id_cliente']."</td>
		<td>".$linhas['criado_em']."</td>
		<td>");	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("</td>
		</tr>
		");	
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
			<input id="primario" class='btn btn-success waves-effect' data-dismiss="modal" value='Não'/>
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