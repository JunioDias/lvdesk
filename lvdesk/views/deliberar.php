<div class="page-header-title">
  <h4 class="page-title">Deliberar</h4>
  <p>Controle de permissões por usuário</p>
</div>
<div class="content-sized">
<table class="table table-hover">
<thead>
  <tr>	
	<th>Nome</th>        
	<th>Privilégio</th>
	<th>Ações</th>
  </tr>
</thead>
<tbody>
<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");

$query = "SELECT u.*, p.nome as nome_priv, p.id as id_priv FROM usuarios AS u INNER JOIN privilegios AS p ON id_privilegio = p.id WHERE u.lixo = 0";
$query_priv = "SELECT * FROM privilegios WHERE lixo = 0";
$nomediv		= ".content-sized";				#nome da div onde o callback vai ocorrer
$tabela  		= "usuarios";					#tabela principal, alvo da rotina
$cbkedit		= "views/permissoes-crud.php";	#callback do botão Editar
$cbkdel 		= "views/permissoes.php";  		#callback do botão Excluir
$link			= "controllers/sys/crud.sys.php";
$i = 1;
$botoes = new Acoes();
$a = new Model();
global $select;
$i = 0;
$resultado = $a->queryFree($query);
if($resultado){	
	while($linhas_priv = $resultado->fetch_assoc()){
		echo("
		<tr>
		<td>".$linhas_priv['nome']."</td>
		<td><form id='privilegio".$i."'>		
			<select name='id_privilegio' class='form-control id_privilegio'>
			");
			if($select = $a->queryFree($query_priv)){
				while($row = $select->fetch_assoc()){
					echo "<option value='".$row['id']."' ".($row['id'] == $linhas_priv['id_privilegio'] ? "selected" : '').">".$row['nome']."</option>";
				}
			}
			echo ("
			</select>	
			<input type='hidden' name='id' value='".$linhas_priv['id']."'/>
		</form>
		</td>
		<td><input class='btn btn-success envia-listagem-deliberar' data-toggle='modal' data-target='#confirma' value='Salvar'  objeto='form_action' linha='privilegio".$i."'/></td>
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
	<!--Início do modal de confirmação -->
	<div id='confirma' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>
	  <div class="modal-dialog">
	    <div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Tem certeza?</h4>
		  </div>
		  <div class="modal-body">	
			<p>O registro selecionado será modificado.</p>
		  </div>
		  <div class="modal-footer">
			<input class='btn btn-danger waves-effect remove-inputs' data-dismiss="modal" value='Não'/>
			<input objeto='form_action' class='btn btn-success rtrn-conteudo' value='Sim'/>			
		  </div>
		</div>
	  </div>
	</div>
	<section class="input_hidden">
		<input type='hidden' name='tbl' value='<?=$tabela;?>' />
		<input type='hidden' name='retorno' value='<?=$nomediv;?>' />
		<input type='hidden' name='caminho' value='<?=$link;?>' /> 
		<input type='hidden' name='flag' value='update' />		
	</section>
</form>
</div>