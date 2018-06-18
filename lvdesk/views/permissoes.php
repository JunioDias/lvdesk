<div class="page-header-title">
  <h4 class="page-title">Permissões</h4>
  <p>Gerenciador das permissões de ações do sistema</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/permissoes-crud.php">
<table class="table table-hover">
<thead>
  <tr>
	<th>Id</th>
	<th>Papel</th>        
	<th>Acessos</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");

$query = "SELECT * FROM permission_role";
$nomediv		= "content-sized";				#nome da div onde o callback vai ocorrer
$tabela  		= "permission_role";			#tabela principal, alvo da rotina
$cbkedit		= "views/permissoes-crud.php";	#callback do botão Editar
$cbkdel 		= "views/permissoes.php";  		#callback do botão Excluir
$link			= "controllers/sys/crud.sys.php";
$i = 1;
$botoes = new Acoes();
$a = new Model();
$a->queryFree($query);
$resultado = $result->fetch_assoc();
if($resultado){	
	while($linhas = $resultado){
		echo("
		<tr>
		<td>".$linhas['id']."</td>
		<td>".$linhas['nome']."</td>
		<td class='text-success'>".$linhas['value']."</td>
		<td>");	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("</td>
		</tr>
		");	
		$i++;
	}
}else{
	echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";
}
?>	
</tbody>
</table>
<form id='form_action'>
  
  <input type='hidden' name='tbl' value='<?=$tabela;?>' />
  <input type='hidden' name='callback' value='<?=$nomediv;?>' />
</form>
</div>