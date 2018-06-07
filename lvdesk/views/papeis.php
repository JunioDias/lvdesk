<div class="page-header-title">
  <h4 class="page-title">Papéis</h4>
  <p>Gerenciador dos papéis do sistema</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/papeis-crud.php">
<table class="table table-hover">
<thead>
  <tr>
	<th>Id</th>
	<th>Nome</th>        
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");

$query = "SELECT * FROM privilegios WHERE lixo = 0";
$nomediv		= "content-sized";			#nome da div onde o callback vai ocorrer
$tabela  		= "privilegios";			#tabela principal, alvo da rotina
$cbkedit		= "views/papeis-crud.php";	#callback do botão Editar
$cbkdel 		= "views/papeis.php";  		#callback do botão Excluir
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
  
  <input type='hidden' name='tbl' value='<?=$tabela;?>' />
  <input type='hidden' name='callback' value='<?=$nomediv;?>' />
</form>
</div>