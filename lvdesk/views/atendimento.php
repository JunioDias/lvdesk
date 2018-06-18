<div class="page-header-title">
	  <h4 class="page-title">Atendimento</h4>
	  <p>Movimentação dos chamados para atendimento</p>
	</div>
	<div class="content-sized">
<?php
include("../controllers/model.inc.php");
$id = $_SESSION['resultado_pesquisa']['id'];
unset($_SESSION['resultado_pesquisa']['id']);
foreach($_SESSION['resultado_pesquisa'] as $value)
	$array = $value;

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
	// $pppoe			= $array['pppoe'];
	$ip				= $array['ipv4'];
	$script			= $matriz['script'];
	$status			= $array['status'];
	$flag	 		= "update";
	
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
	// $pppoe			= NULL;
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
	<form id="form-dados">
	<div class="form-group">
		<label for="nome">Provedor</label>
		<input type="text" class="form-control" name="nome" value="<?= $provedor ;?>">
	</div>
	<div class="form-group">
		<label for="tipo_bd">Cliente</label>
		<input type="text" class="form-control" name="tipo_bd" value="<?= $nome_cliente ;?>">
	</div>
	
	<!--<div class="row">-->
		
		<div class="form-group">
		<label for="nome_cliente">CPF</label>
		<input type="text" class="form-control" name="nome_cliente" value="<?= $cpf_cnpj; ?>">			
		</div>
		
		<div class="form-group">
		<label for="endereco">Endereço completo</label>
		<input type="text" class="form-control" name="endereco" value="<?= $endereco; ?>">
		</div>
			
		<div class="form-group">
			<label for="telefone">Telefone</label>
			<input type="text" class="form-control" name="telefone" value="<?= $telefone;?>">
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
			<label for="senha_pav">Senha</label>
			<input type="text" class="form-control" name="senha_pav" value="<?= $senha_pppoe;?>">
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
		<textarea class="wysihtml5-textarea form-control" rows="9" id="script" name="script"><?= $script;?></textarea>
	</div>
	<input class="btn btn-default rtrn-conteudo" value="Solucionado" type="button" objeto="form-dados">
	<input class="btn btn-default regular-link" value="CGR" type="button" objeto="form-dados">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="pav" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>	
</div>