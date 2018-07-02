<div class="page-header-title">
  <h4 class="page-title">Históricos de Serviços</h4>
  <p>Listagem de clientes de atendimentos finalizados</p>
</div>
<div class="content-sized">
<section class="menu_acao">
	<form id="pesquisar">
	<input class="btn btn-success btn_driver" value="Pesquisar" type="button" data-toggle='modal' data-target='#myModal'>
	</form>
	<form id="salvarFiltros">
	<input class="btn btn-warning btn_driver" value="Salvar Filtros" type="button" >
	</form>
</section>
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
<tbody id="table_servicos" >
<?php
include("../controllers/model.inc.php"); 
include("../controllers/actions.inc.php");
$i = 0;
$botoes = new Acoes();
$a = new Model();

$query		= "SELECT * FROM pav_inscritos WHERE lixo = 0 AND validado = 1 ORDER BY data_abertura ASC";
$result 	= $a->queryFree($query);

$tabela  	= "pav_inscritos";				#tabela principal, alvo da rotina
$cbkedit	= "views/atendimento-crud.php";	#callback do botão Editar
$cbkdel 	= "views/atendimento.php";  	#callback do botão Excluir
$link		= "controllers/sys/crud.sys.php";
$flag		= "entrada";
?>	
</tbody>
</table>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title" id="myModalLabel">Pesquisar chamados por</h4>
	</div>
	<div class="modal-body">
	<form id='form_search'>
		<div class="form-group">
		  <label for="nome_cliente">Nome do cliente</label>
		  <input type="text" class="form-control" name="nome_cliente" />
		</div>
		<div class="form-group">
		  <label for="cpf">CPF</label>
		  <input type="text" class="form-control" name="cpf" />
		</div>
		<div class="form-group">
		  <label for="nome_provedor">Entidade</label>
		  <input type="text" class="form-control" name="nome_provedor" />
		</div>
<?php 
if(isset($search['id'])){
  echo "<input type='hidden' name='id_provedor' value='".$search['id']."'/>";
}
?>
		<input type="hidden" name="retorno" value="#table_servicos" />
	</form>	  
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
	  <a class='btn btn-success rtrn-conteudo-listagem' objeto='form_search' flag='pesquisaHistoricos' caminho='controllers/sys/crud.sys.php' data-dismiss="modal">Pesquisar</a>
	</div>
  </div><!-- /.modal-content -->
</div><!-- /.m