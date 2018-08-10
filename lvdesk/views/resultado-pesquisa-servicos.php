<div class="page-header-title">
  <h4 class="page-title">Serviços do CGR</h4>
  <p>Listagem de clientes de atendimento de 2º nível</p>
</div>
<div class="content-sized">

<table class="table table-hover" id="tabela">
<thead>
  <tr class="filtro">
	<th>Data <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Protocolo <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Nome do Cliente <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
	<th>Entidade <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Telefone <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Ações</th>
  </tr>
  <tr class="input-filtro" style="display:none;">
	<th><input type="text" class="form-control" id="txtColuna1"/></th>
	<th><input type="text" class="form-control" id="txtColuna2"/></th>
	<th><input type="text" class="form-control" id="txtColuna3"/></th>
	<th><input type="text" class="form-control" id="txtColuna4"/></th>
	<th><input type="text" class="form-control" id="txtColuna5"/></th>
	<th></th>
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
<script>
NProgress.done();
</script>