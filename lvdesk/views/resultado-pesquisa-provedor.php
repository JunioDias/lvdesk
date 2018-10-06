<div class="content-sized">
<table class="table table-hover" id="tabela">
<thead>
  <tr class="filtro">
	<th>CPF/CNPJ <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Nome <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>        
	<th>Endereço <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Telefone <a><i class="mdi mdi-filter-variant icone-filtro"></i></a></th>
	<th>Ações</th>
  </tr>
  <tr class="input-filtro" style="display:none;">
	<th><input type="text" class="form-control" id="txtColuna1"/></th>
	<th><input type="text" class="form-control" id="txtColuna2"/></th>
	<th><input type="text" class="form-control" id="txtColuna3"/></th>
	<th><input type="text" class="form-control" id="txtColuna4"/></th>
	<th></th>
  </tr> 
</thead>
<tbody>
<?php
include("../../controllers/actions.inc.php");
if(isset($_SESSION['resultado_pesquisa'])){	
	$flag			= "entrada";
	$linhas 		= $_SESSION['resultado_pesquisa']['clientes']; unset($linhas['id']);
	$nomediv		= ".content";					#nome da div onde o callback vai ocorrer
	$tabela  		= "usuarios";					#tabela principal, alvo da rotina
	$cbkedit		= "views/atendimento-crud.php";	#callback do botão Editar
	$cbkdel 		= "views/atendimento.php";  	#callback do botão Excluir
	$link			= "controllers/sys/crud.sys.php";
	$i = 0;
	$botoes = new Acoes();
	$a = new Model();
	if(!$linhas){
		echo"<tr><td>Nenhum registro foi encontrado.</td></tr>";
	}
	else{		
		while($i < count($linhas)){
			echo("
			<tr>
				<td>".$linhas[$i]['cpf_cnpj']."</td>
				<td>".$linhas[$i]['nome_razaosocial']."</td>
				<td>".(isset($linhas[$i]['servicos'][0]['endereco_cobranca']['completo']) ? $linhas[$i]['servicos'][0]['endereco_cobranca']['completo'] : '<span style=color:red;> Não cadastrado</span>')."</td>
				<td>".$linhas[$i]['telefone_primario']."</td>
				<td>");	$botoes->darEntrada($i, $linhas[$i]['cpf_cnpj'], $link, $flag); echo("</td>
			</tr>
			");	
			$i++;
		}
	}
?>	
</tbody>
</table>
<form id='form_action'>  
  <input type='hidden' name='retorno' value='<?=$nomediv;?>' />
  <input type='hidden' name='id_contratos' value='<?= $_SESSION['datalogin']['id_contrato'];?>' />
</form>
</div>
<script>
NProgress.done();
</script>
<?php 
} //Fim do if(isset($_SESSION['resultado_pesquisa'])
else{
	$flag			= "entrada";
	$linhas 		= $_SESSION['resultado_pesquisa']; unset($linhas['id']);
	$nomediv		= ".content";					#nome da div onde o callback vai ocorrer
	$tabela  		= "usuarios";					#tabela principal, alvo da rotina
	$cbkedit		= "views/atendimento-crud.php";	#callback do botão Editar
	$cbkdel 		= "views/atendimento.php";  	#callback do botão Excluir
	$link			= "controllers/sys/crud.sys.php";
}
?>