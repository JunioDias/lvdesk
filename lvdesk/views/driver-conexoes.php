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
    <th>Nome do banco</th>        
	<th>Status</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");

$query 			= "SELECT * FROM pav WHERE lixo = 0";
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
		<tr>	
		<td >".$linhas['id']."</td>
		<td >".$linhas['nome']."</td>
		<td >".$linhas['nome_bd']."</td>
		<td class='text-danger' id='target-status".$linhas['id']."'>
		<div id='progress' style='width: 100%;'>
			<div id='barra".$linhas['id']."' style='width: 0%; height: 7px; background-color: green;'>
				<span id='rotulo".$linhas['id']."' style='float: left;'>Desconectado</span>
			</div>
		</div>
		</td>
		");
		
		echo"<td>";	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("
		<a class='btn btn-success rtrn-conteudo-listagem2' objeto='form_action' flag='". $linhas['tipo_bd'] ."' item='". $linhas['id'] ."' caminho='controllers/sys/pav.sys.php'>Conectar</a>
		</td>
		</tr>
		");	
		$i++;
	}
	$a->queryFree($query);
	$search = $result->fetch_assoc();
}
?>	
</tbody>
</table>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title" id="myModalLabel">Buscar clientes</h4>
	</div>
	<div class="modal-body">
	<form id='form_search'>
		<div class="form-group">
		  <label for="nome">Nome do cliente</label>
		  <input type="text" class="form-control" name="nome" />
		</div>
		<div class="form-group">
		  <label for="cpf">CPF</label>
		  <input type="text" class="form-control" name="cpf" />
		</div>
		<div class="form-group">
		  <label for="endereco">Endereço</label>
		  <input type="text" class="form-control" name="endereco" />
		</div>
<?php 
if(isset($search['id'])){
  echo "<input type='hidden' name='id_provedor' value='".$search['id']."'/>";
}
?>
	</form>	  
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
	  <a class='btn btn-success rtrn-conteudo-listagem' objeto='form_search' flag='<?= $search['tipo_bd']; ?>' caminho='controllers/sys/pav.sys.php' data-dismiss="modal">Pesquisar</a>
	</div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<form id='form_action'>
  <input type='hidden' name='tbl' value='<?=$tabela;?>' />
  <input type='hidden' name='callback' value='<?=$nomediv;?>' />
</form>
</div>