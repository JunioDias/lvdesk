<?php
if(isset($_POST['id'])){
	$qry = "SELECT * FROM index_manage WHERE contato = 1 AND lixo = 0 AND id='".$_POST['id']."'";
	$e = new Model();
	$e->queryFree($qry);	
	#if($result->num_rows > 0){  Indica que um registro foi selecionado para edição
	# Indica que um registro foi selecionado para edição
	$edicao = $_POST;
	$cabecalho = "
	<h3>Contatos</h3>
	<p>Altere os dados nos campos abaixo para atualizar os contatos.<br /></p>
	";
	$edicao = $result->fetch_assoc();
	
	$id		   = $edicao['id'];
	$valor 	 	= $edicao['valor_nominal'];
	$descritivo   = $edicao['descritivo'];	
	$flag	 	 = "update";
}else{
	$cabecalho = "
	<h3>Adicionar Novo Contato</h3>
	<p>Cadastre os dados no campo abaixo.<br />
	*Campo obrigatório (não deixe em branco).</p>
	";
	$id		 = NULL;
	$valor	 = NULL;
	$descritivo   = NULL;
	$flag	 = "add";
}
echo $cabecalho;
?>

<form id="form_upload" method="post"> 
    <table>
    <tr><td>
    <label>Cód. Área</label><br>
    <input type="text" name="descritivo" value="<?= $descritivo;?>" maxlength="2" title="Somente números" class="codarea"/>
    </td><td>
    <label>Contato* (somente números)</label><br>
    <input type="text" name="valor_nominal" maxlength="9" value="<?= $valor;?>"/> 
    </td></tr>
    </table>
    <?php 
		if(isset($id)){
			echo "<input type='hidden' name='id' value='$id'/>";
		}
	?>
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="index_manage" />
    <input type="hidden" name="contato" value="1" />
    <input type="hidden" class="caminho" value="sys/crud.sys.php" />
    <p><a but class="submeteZ" id="btn_enviar">Salvar</a></p>
</form>
<span class="progresso"></span>
<div class="page-header-title">
	<h4 class="page-title">Módulos</h4>
	<p>Cadastro dos módulos do sistema</p>
</div>
<div class="content-sized">

	<form>
		<div class="form-group">
			<label for="nome">Nome do módulo</label>
			<input type="text" class="form-control" class="nome" name="nome">
		</div>
		<div class="form-group">
			<label for="email">Controlador do sistema</label>
			<input type="text" class="form-control" class="email" name="email">
		</div>
		<div class="form-group">
			<label for="senha">Action do Controller</label>
			<input type="password" class="form-control" class="senha" name="senha">			
		</div>
		<div class="form-group">
			<label for="confsenha">Ambiente</label>
			<input type="password" class="form-control" class="confsenha" name="confsenha">
		</div>
		<input class="btn btn-default" value="Salvar" type="button" link="dashboard.html">
	</form>
	
</div>