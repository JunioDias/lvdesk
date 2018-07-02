<div class="page-header-title">
	  <h4 class="page-title">Atendimento</h4>
	  <p>Movimentação dos chamados para atendimento</p>
	</div>
	<div class="content-sized">
<?php
$a = new Model;
if($id){
	$query = "SELECT * FROM pav WHERE id = '".$id."' AND lixo = 0";
	$result = $a->queryFree($query);
	if($result){
		$matriz = $result->fetch_assoc();
	}
	
	$nome_cliente	= $array['nome_cliente'];
	$cpf_cnpj		= $array['cpf_cnpj'];
	$provedor 	 	= $matriz['nome'];
	$endereco 		= $array['endereco'];
	$telefone		= $array['telefone_principal'];
	$usuario		= $array['usuario_autenticacao'];
	$senha_pppoe	= $array['senha_autenticacao'];
	// $nas			= $array['nas'];
	// $pppoe		= $array['pppoe'];
	$ip				= $array['ipv4'];
	$script			= $matriz['script'];
	$status			= $array['status'];
	$flag	 		= "add";
	$retorno		= ".content-sized";
	
}else{
	$id		   		= NULL;
	$nome_cliente	= NULL;
	$cpf_cnpj		= NULL;
	$provedor 	 	= NULL;
	$endereco 		= NULL;
	$telefone		= NULL;
	$usuario		= NULL;
	$senha_pppoe	= NULL;
	// $nas			= NULL;
	// $pppoe		= NULL;
	$ip				= NULL;
	$script			= NULL;
	$status			= NULL;
	$flag	 		= "";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Atendimento</h4>
	  <p>Movimentação dos chamados para atendimento</p>
	</div>
	<div class="content-sized">';
}	
?>
	<form id="form-dados-cgr">
	<div class="form-group">
		<label for="nome_provedor">Provedor</label>
		<input type="text" class="form-control" name="nome_provedor" value="<?= $provedor ;?>">
	</div>
	<div class="form-group">
		<label for="nome_cliente">Cliente</label>
		<input type="text" class="form-control" name="nome_cliente" value="<?= $nome_cliente ;?>">
	</div>
	
	<!--<div class="row">-->
		
		<div class="form-group">
		<label for="cpf_cnpj_cliente">CPF</label>
		<input type="text" class="form-control" name="cpf_cnpj_cliente" value="<?= $cpf_cnpj; ?>">			
		</div>
		
		<div class="form-group">
		<label for="endereco_cliente">Endereço completo</label>
		<input type="text" class="form-control" name="endereco_cliente" value="<?= $endereco; ?>">
		</div>
			
		<div class="form-group">
			<label for="telefone_cliente">Telefone</label>
			<input type="text" class="form-control" name="telefone_cliente" value="<?= $telefone;?>">
		</div>
		<div class="form-group">
			<label for="situacao">Situação</label>
			<input type="text" class="form-control" name="situacao" value="<?= $status;?>">
		</div>
		<!--<div class="form-group">
			<label for="nas">NAS IP</label>
			<input type="text" class="form-control" name="nas" value="">			
		</div>
		<div class="form-group">
			<label for="pppoe">PPPoE</label>
			<input type="text" class="form-control" name="pppoe" value="?>">
		</div>-->
		<div class="form-group">
			<label for="senha_pppoe">Senha</label>
			<input type="text" class="form-control" name="senha_pppoe" value="<?= $senha_pppoe;?>">
		</div>
		<div class="form-group">
			<label for="ip">IP</label>
			<input type="text" class="form-control" name="ip" value="<?= $ip;?>">
		</div>
	<!--</div>-->
	<div class="form-group">
		<label for="usuario">Usuário</label>
		<input type="text" class="form-control" name="usuario" value="<?= $usuario;?>">
	</div>
	
	<div class="form-group">
		<label for="script">Script</label>
		<textarea class="wysihtml5-textarea form-control" rows="9" id="script" ><?= $script;?></textarea>
	</div>
	<div class="form-group">
		<label for="historico">Histórico</label>
		<textarea class="wysihtml5-textarea form-control" rows="9" id="historico" name="historico"></textarea>
	</div>
	<div class="form-group">
	<hr><label for="resumo">Resumo</label><br>
	<input class="btn btn-success rtrn-conteudo" value="Solucionado" type="button" objeto="form-dados-solucionado">
	<input class="btn btn-warning rtrn-conteudo" value="CGR" type="button" objeto="form-dados-cgr">
	</div>
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id_pav' value='$id'/>";
	}
	?>
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="pav_inscritos" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	<input type="hidden" name="retorno" value="<?= $retorno;?>" />
	<input type="hidden" name="hora_add" value="on" />
	</form>	
	<form id="form-dados-solucionado">
	
	</form>
</div>