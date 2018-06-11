<div class="page-header-title">
  <h4 class="page-title">Driver</h4>
  <p>Conexões dos provedores disponíveis para acesso</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/driver-conexoes-crud.php">
<table class="table table-hover">
<thead>
  <tr>
	<th>Id</th>
	<th>Provedor</th>
    <th>Software</th>        
	<th>Status</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");

$query = "SELECT * FROM pav WHERE lixo = 0";
$nomediv		= "content-sized";					#nome da div onde o callback vai ocorrer
$tabela  		= "pav";							#tabela principal, alvo da rotina
$cbkedit		= "views/driver-conexoes-crud.php";	#callback do botão Editar
$cbkdel 		= "views/driver-conexoes.php";  	#callback do botão Excluir
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
		<tr class='objLnk'>
		<td>".$linhas['id']."</td>
		<td>".$linhas['nome']."</td>
		<td>".$linhas['software']."</td>");
		if($linhas['validado'] = 0){
		  echo"<td class='text-success'>Conectado</td>";
		}else{		  
		  echo"<td class='text-danger'>Desconectado</td>";
		}
		echo"<td>";	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("
		<a class='btn btn-success rtrn-conteudo-conexao' flag='".$linhas['bd']."' caminho='controllers/sys/pav.sys.php'>Conectar</a></td>
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