<div class="page-header-title">
  <h4 class="page-title">Usuários</h4>
  <p>Gerenciador dos usuários do sistema</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/usuarios-crud.php">
<table class="table table-hover">
<thead>
  <tr>
	<th>Id</th>
	<th>Nome</th>        
	<th>e-mail</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");

$query = "SELECT * FROM usuarios WHERE lixo = 0";
$nomediv		= ".content-sized";				#nome da div onde o callback vai ocorrer
$tabela  		= "usuarios";					#tabela principal, alvo da rotina
$cbkedit		= "views/usuarios-crud.php";	#callback do botão Editar
$cbkdel 		= "views/usuarios.php";  		#callback do botão Excluir
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