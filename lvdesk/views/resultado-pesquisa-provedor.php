<!--<div class="page-header-title">
  <h4 class="page-title">Resultado da Pesquisa</h4>
  <p>Listagem de clientes</p>
</div>-->
<div class="content-sized">

<table class="table table-hover">
<thead>
  <tr>
	<th>CPF/CNPJ</th>
	<th>Nome</th>        
	<th>Endereço</th>
	<th>Telefone</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
/* include("../../controllers/model.inc.php"); */
include("../../controllers/actions.inc.php");
$flag			= "entrada";
$linhas 		= $_SESSION['resultado_pesquisa']; unset($linhas['id']);
$nomediv		= ".content";					#nome da div onde o callback vai ocorrer
$tabela  		= "usuarios";					#tabela principal, alvo da rotina
$cbkedit		= "views/atendimento-crud.php";	#callback do botão Editar
$cbkdel 		= "views/atendimento.php";  	#callback do botão Excluir
$link			= "controllers/sys/crud.sys.php";
$i = 0;
$botoes = new Acoes();
$a = new Model();
if(!$linhas){
	echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";
}
else{
	
	while($i < count($linhas)){
		echo("
		<tr>
		<td>".$linhas[$i]['cpf_cnpj']."</td>
		<td>".$linhas[$i]['nome_cliente']."</td>
		<td>".$linhas[$i]['endereco']."</td>
		<td>".$linhas[$i]['telefone_principal']."</td>
		<td>");	$botoes->darEntrada($i, $linhas[$i]['cpf_cnpj'], $link, $flag); echo("</td>
		</tr>
		");	
		$i++;
	}
}
?>	
</tbody>
</table>
<form id='form_action'>  
  <input type='hidden' name='retorno' value='<?=$nomediv;?>' />
  <input type='hidden' name='id_contratos' value='<?= $_SESSION['datalogin']['id_contrato'];?>' />
</form>
</div>