<div class="page-header-title">
  <h4 class="page-title">Listagem de Chamados</h4>
  <p>Chamados de Call Center Nível 1</p>
</div>
<div class="content-sized">
<section class="menu_acao">
	<form id="pesquisar">
	<input class="btn btn-success btn_driver" value="Provedores" type="button" data-toggle='modal' data-target='#myModal'>
	</form>
	<form id="salvarFiltros">
	<input class="btn btn-warning btn_driver" value="Salvar Filtros" type="button" >
	</form>
</section>
<table class="table table-hover">
<thead>
  <tr>
	<th>Data</th>
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
$query 	= "SELECT * FROM pav WHERE lixo = 0";
$result = $a->queryFree($query);
if(isset($result)){
	$connect = $result->fetch_assoc();
}
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
		<h4 class="modal-title" id="myModalLabel">Selecionar Provedores</h4>
	</div>
	<div class="modal-body">
	<form id='form_search'>
		<div class="form-group">
		  <label for="nome_provedor">Entidade</label>
		  <select class="form-control" name="id" id="select_provedor">
			<option>Selecione um provedor...</option>
			<?php		
			$resultB = $a->queryFree($query);
			if(isset($resultB)){				
				while($linhas = $resultB->fetch_assoc()){
					echo "<option value='".$linhas['id']."' tipo='".$linhas['tipo_bd']."' >".$linhas['nome']."</option>";
				}		
			}		  
			?>
			</select>	
		</div>
		<section class="input_hidden">
			<input type="hidden" name="retorno" value=".content-sized" />
			<input type="hidden" name="flag"  /> 
			<input type="hidden" name="caminho" value="controllers/sys/pav.sys.php" />
			<input type="hidden" name="listagem" value="on" />
		</section>
	</form>	  
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
	  <a class='btn btn-success rtrn-conteudo' objeto='form_search' data-toggle='modal' data-target='#pesquisaConexao'>Conectar</a>
	</div>
  </div><!-- /.modal-content -->
</div><!-- /.modal.dialog -->

	<div id="pesquisaConexao" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Buscar clientes</h4>
		</div>
		<div class="modal-body">
		<form id='form_search_clientes'>
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
			<section class="input_hidden">
				<input type="hidden" name='id_provedor'   />
			</section>
		</form>	  
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
		  <a class='btn btn-success rtrn-conteudo-listagem' objeto='form_search_clientes' flag='<?= $connect['tipo_bd']; ?>' caminho='controllers/sys/pav.sys.php' data-dismiss="modal">Pesquisar</a>
		</div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->

</div>