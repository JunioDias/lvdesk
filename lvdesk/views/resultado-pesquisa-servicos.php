<div class="page-header-title">
  <h4 class="page-title">Serviços do CGR</h4>
  <p>Listagem de clientes de atendimento de 2º nível</p>
</div>
<div class="content-sized">

<table class="table table-hover">
<thead>
  <tr>
	<th>Data</th>
	<th>Protocolo</th>
	<th>Nome do Cliente</th>        
	<th>Entidade</th>
	<th>Telefone</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/model.inc.php"); 
include("../controllers/actions.inc.php");
$i = 0;
$botoes = new Acoes();
$a = new Model();

$query		= "SELECT * FROM pav_inscritos WHERE lixo = 0 AND validado = 0 ORDER BY data_abertura ASC";
$result 	= $a->queryFree($query);

$nomediv	= ".content";					#nome da div onde o callback vai ocorrer
$tabela  	= "pav_inscritos";				#tabela principal, alvo da rotina
$cbkedit	= "views/atendimento-crud.php";	#callback do botão Editar
$cbkdel 	= "views/atendimento.php";  	#callback do botão Excluir
$link		= "controllers/sys/crud.sys.php";
$flag		= "entrada2Nivel";

if($result){
	while($linhas 	= $result->fetch_assoc()){
		echo("
		<tr>
		<td><time datetime='".date('c')."'>".date('d/m/Y', strtotime($linhas['data_abertura']))."</time></td>
		<td>".$linhas['protocol']."</td>
		<td>".$linhas['nome_cliente']."</td>
		<td>".$linhas['nome_provedor']."</td>
		<td>".$linhas['telefone_cliente']."</td>
		<td>");	$botoes->darEntrada($i, $linhas['id'], $link, $flag); echo("</td>
		</tr>
		");	
		$i++;
	}	
}
else{
	echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";	
}
?>	
</tbody>
</table>
<form id='form_action'>  
  <input type='hidden' name='retorno' value='<?=$nomediv;?>' />
</form>
</div>