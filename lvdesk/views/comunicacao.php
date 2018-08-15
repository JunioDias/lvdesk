<div class="page-header-title">
  <h4 class="page-title">Comunicação Interna</h4>
  <p>Lista de serviços atribuídos internamente</p>
</div>
<div class="content-sized">
	
	<table class="table table-hover" id="tabela">
	<thead>
	  <tr class="filtro">
		<th>Data <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
		<th>Autor <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
		<th>Resumo <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
		<th>Ações</th>
	  </tr>
	  <tr class="input-filtro" style="display:none;">
		<th><input type="text" class="form-control" id="txtColuna1"/></th>
		<th><input type="text" class="form-control" id="txtColuna2"/></th>
		<th><input type="text" class="form-control" id="txtColuna3"/></th>
		<th></th>
	  </tr> 
	</thead>
	<tbody id="table_servicos" >
	<?php
	include("../controllers/model.inc.php"); 
	include("../controllers/actions.inc.php");
	$i = 0;
	$botoes = new Acoes();
	$a = new Model();
	if(!empty($_SESSION["datalogin"]))
		$dadoslogin = $_SESSION["datalogin"];
		
	$tabela  	= "comunicacao_interna";		#tabela principal, alvo da rotina
	$cbkedit	= "views/comunicacao-crud.php";	#callback do botão Editar
	$cbkdel 	= "views/comunicacao.php";  	#callback do botão Excluir
	$link		= "controllers/sys/crud.sys.php";
	$flag		= "visualizar";
	
	$query 	= "SELECT c.*, u.nome AS nome_user FROM comunicacao_interna AS c
	INNER JOIN usuarios AS u ON c.autor = u.id 
	WHERE c.lixo = 0 AND c.id_contatos = '".$dadoslogin['id']."'";
	$result = $a->queryFree($query);
	if(!$result){
		echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";
	}
	else{
		while($linhas = $result->fetch_assoc()){
			echo("
			<tr>
			<td>".date("d/m/Y", strtotime($linhas['data_abertura']))."</td>
			<td>".$linhas['nome_user']."</td>
			<td>".substr($linhas['historico'], 0, 30)."[...]</td>
			<td>");	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("</td>
			</tr>
			");	
			$i++;
		}
	}
	?>
	</tbody>
	</table>
	<!--<div class="clear"></div>
	 <ul class="pagination pagination-sm">
		<li> <a href="#"> <i class="fa fa-angle-left"></i> </a> </li>
		<li> <a href="#">1</a> </li>
		<li class="active"> <a href="#">2</a> </li>
		<li> <a href="#">3</a> </li>
		<li class="disabled"> <a href="#">4</a> </li>
		<li> <a href="#">5</a> </li>
		<li> <a href="#">6</a> </li>
		<li> <a href="#"> <i class="fa fa-angle-right"></i> </a> </li>
	</ul>-->
</div>
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
	<input type='hidden' name='allow' value='on'/>
	<input type='hidden' name='tbl' value='<?=$tabela;?>' />
	<input type='hidden' name='retorno' value='.content-sized' />
</form>
<script>
NProgress.done();
</script>