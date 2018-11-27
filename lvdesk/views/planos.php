<div class="page-header-title">
  <h4 class="page-title">Planos</h4>
  <p>Gerenciador dos planos de regras</p>
</div>
<div class="content-sized">
<input class="btn btn-success btn_driver regular-link" value="Incluir" type="button" link="views/planos-crud.php">
<table class="table table-hover" id="tabela">
<thead>
  <tr class="filtro">
	<th>Id <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Título <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
	<th>Limite <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Preço <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Status <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
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
include("../controllers/actions.inc.php"); 
include("../controllers/model.inc.php");
	
$query 			= "SELECT * FROM planos WHERE lixo = 0 ORDER BY id DESC";

$nomediv		= ".content-sized";			#nome da div onde o callback vai ocorrer
$tabela  		= "planos";					#tabela principal, alvo da rotina
$cbkedit		= "views/planos-crud.php";	#callback do botão Editar
$cbkdel 		= "views/planos.php";  		#callback do botão Excluir
$link			= "controllers/sys/crud.sys.php";
$i = 0;
$botoes = new Acoes();
$limite = 10;
$offset = 0;
$total_de_registros = $botoes->pagination($limite, $offset, "planos");

$a = new Model();
$result = $a->queryFree($query);
if($result){
	while($linhas = $result->fetch_assoc()){
		echo("
		<tr>
		<td>".$linhas['id']."</td>
		<td>".$linhas['nome']."</td>
		<td>".$linhas['limite']."</td>
		<td>".$a->moneyFormatReal($linhas['valor_unit'])."</td>
		<td>".($linhas['ativo'] == 1 ? '<span style=color:red;>Inativo</span>' : '<span style=color:green;>Ativo</span>')."</td>
		<td>");	$botoes->crudButtons($linhas['id'], $cbkdel, $cbkedit, $link); echo("<input type='hidden' id='plano_verifica' value='1' ></td>
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
<ul class="pagination pagination-sm">
	<li> <a href="#"> <i class="fa fa-angle-left"></i> </a> </li>
	<li> <a href="">1</a> </li>
	<li class="active"> <a href="<?php echo $pagina+1; ?>">2</a> </li>
	<li> <a href="#">3</a> </li>
	<li class="disabled"> <a href="#">4</a> </li>
	<li> <a href="#">5</a> </li>
	<li> <a href="#">6</a> </li>
	<li> <a href="#"> <i class="fa fa-angle-right"></i> </a> </li>
</ul>
</div>
<form id='form_action'>
<!--------------------- Início do modal de confirmação --------------------->
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
			<input data-objeto='form_action' class='btn btn-danger botao rtrn-conteudo' data-dismiss="modal" value='Sim'/>
		  </div>
		</div>
	  </div>
	</div>
	<!--Fim do modal de confirmação -->
	<input type='hidden' name='tbl' value='<?=$tabela;?>' />
	<input type='hidden' name='retorno' value='<?=$nomediv;?>' />
</form>
<!--------------------- Modal de alerta para Planos vinculados -------------------->
<div id="alerta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 class="modal-title" id="myModalLabel">Atenção!</h3>
	</div>
	<div class="modal-body">
		<h4>Vínculo detectado</h4>
		<p>
		Este plano já possui um vínculo contratual.<br>
		Para fins de auditoria essa ação foi interrompida. Clique OK para sair.
		</p>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-success waves-effect regular-link" link="views/planos.php" data-dismiss="modal">OK</button>
	</div>
  </div><!-- /.modal-content -->
</div><!-- /.modal.dialog -->
</div>
<script>
NProgress.done();
</script>