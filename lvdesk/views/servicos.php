<div class="page-header-title">
  <h4 class="page-title">Serviços do CGR</h4>
  <p>Listagem de clientes de atendimento de 2º nível</p>
</div>
<div class="content-sized">
<section class="menu_acao">
	<form id="emAbertos">
		<input type="hidden" name="flag" value="emabertos" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
		<input type="hidden" name="retorno" value="#table_servicos_cgr" />
		<input class="btn btn-danger btn_driver rtrn-conteudo" value="Em abertos" objeto='emAbertos' type="button" >
	</form>
	<form id="pesquisar">
	<input class="btn btn-success btn_driver" value="Pesquisar" type="button" data-toggle='modal' data-target='#pesquisa'>
	</form>
	<form id="salvarFiltros">
	<input class="btn btn-warning btn_driver" value="Salvar Filtros" type="button" >
	</form>
	<form id="incluirAtendimento">
	<input class="btn btn-info btn_driver regular-link" value="Incluir" type="button" link="views/atendimento-entrada-nivel-3.php">
	</form>
</section>
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
<tbody id="table_servicos_cgr" >
<?php
include("../controllers/model.inc.php"); 
include("../controllers/actions.inc.php");
$i = 0;
$botoes = new Acoes();
$a = new Model();

$query		= "SELECT * FROM pav_inscritos WHERE lixo = 0 AND validado = 0 ORDER BY data_abertura ASC";
$result 	= $a->queryFree($query);

$tabela  	= "pav_inscritos";				#tabela principal, alvo da rotina
$cbkedit	= "views/atendimento-crud.php";	#callback do botão Editar
$cbkdel 	= "views/atendimento.php";  	#callback do botão Excluir
$link		= "controllers/sys/crud.sys.php";
$flag		= "entrada2Nivel";
?>	
</tbody>
</table>
</div>
<!------------------------------------------------- Modal Pesquisa ------------------------------------------------------>
<div id="pesquisa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
				<input type="hidden" name="retorno" value="#table_servicos_cgr" />
			</form>	  
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
			<a id="primario" class='btn btn-success rtrn-conteudo-listagem' objeto='form_search' flag='pesquisaCGR' caminho='controllers/sys/crud.sys.php' data-dismiss="modal">Pesquisar</a>
		</div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal dialog -->
</div>
<!------------------------------------------------ Fim Modal Pesquisa ---------------------------------------------------->
<form id="form_action">
	<input type='hidden' name='allow' value='on'/>
</form>
<script>
NProgress.done();
</script>