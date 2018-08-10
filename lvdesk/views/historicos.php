<?php
session_start();
if(!empty($_SESSION["datalogin"])){
	$datalogin 					= $_SESSION["datalogin"];
	$atendente_responsavel		= $datalogin['id'];
}
?>

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
	<tbody id="table_servicos" >
	
	</tbody>
</table>

</div>
<form id='form_action'>
	<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title" id="myModalLabel">Pesquisar chamados por</h4>
		</div>
		<div class="modal-body">
		<form >
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
			  echo "
			  <input type='hidden' name='id_provedor' value='".$search['id']."'/>			  
			  ";
			}
			echo "<input type='hidden' name='autor' value='".$atendente_responsavel."'/>";
			?>
			
			<input type="hidden" name="retorno" value="#table_servicos" />
		</form>	  
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
		  <a id="primario" class='btn btn-success rtrn-conteudo-listagem' objeto='form_action' flag='pesquisaHistoricos' caminho='controllers/sys/crud.sys.php' data-dismiss="modal">Pesquisar</a>
		</div>
	  </div><!-- /.modal-content -->
	</div><!-- /.m-->
	</div>
</form>
<form id="form_view">
<input type='hidden' name='flag' value="visualizar" />
<input type='hidden' name='caminho' value="controllers/sys/crud.sys.php" />
</form>
<script>
NProgress.done();
</script>