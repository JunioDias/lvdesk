<?php
include("../controllers/model.inc.php");	
$retorno	= ".content-sized";
$a = new Model();
if(isset($_POST['id'])){
	$qry = "SELECT c.*, cli.nome FROM contratos AS c INNER JOIN clientes AS cli ON id_cliente = cli.id WHERE c.lixo = 0 ";	
	$a->queryFree($qry);	
	$edicao 	= $_POST;
	$edicao 	= $result->fetch_assoc();
	
	$id		   		= $edicao['id'];
	$email			= $edicao['email'];
	$duracao 		= $edicao['social_name'];
	$social_name 	= $edicao['telefone'];
	$dominio		= $edicao['dominio'];
	$criado_em		= $edicao['criado_em'];
	$finaliza_em	= $edicao['finaliza_em'];
	$id_planos_mov	= explode("#", $edicao['id_planos_mov']);
	$id_produtos	= $edicao['id_produtos'];
	$id_cliente		= $edicao['id_cliente'];	
	$flag	 		= "update";
}else{
	$id		   		= NULL;
	$email			= NULL;
	$duracao 		= NULL;
	$social_name 	= NULL;
	$dominio		= NULL;
	$criado_em		= NULL;
	$finaliza_em	= NULL;
	$id_planos_mov	= NULL;
	$id_produtos	= NULL;
	$id_cliente		= NULL;
	$flag	 		= "add";
	
	echo $head = '
	<div class="page-header-title">
	  <h4 class="page-title">Contratos</h4>
	  <p>Gerenciador dos contratos</p>
	</div>
	<div class="content-sized">';
}
?>
<form id="form-dados-perfil">
	<div class="panel panel-color panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">Identificação</h3>
		</div>
		<div class="panel-body">			
			<div class="row">
				<div class="form-group col-sm-12">
					<div class="form-group">
					<label for="name">Cliente</label>
						<select class="form-control" name="id_cliente" id="id_cliente">		
						<option>Selecione um cliente...</option>
						<?php	
						$query = "SELECT * FROM clientes WHERE lixo = 0";
						$resultado = $a->queryFree($query);
						if(isset($resultado)){
							while($linhas = $resultado->fetch_assoc()){					
								echo "<option email='".$linhas['usuario']."' value='".$linhas['id']."' ".($linhas['id'] == $id_cliente ? "selected" : '').">".$linhas['nome']."</option>";						
							}
						}else{
							echo "<option>Nenhum registro encontrado</option>";					
						}
						?>
					</select>
					</div>
				</div>	
			</div>
				
			<div class="row">	
				<div class="form-group col-sm-6">
					<div class="form-group">
						<label for="criado_em">Data de início</label>
						<input type="date" class="form-control" name="criado_em" value="<?= $criado_em;?>"/>
					</div>
					<div class="form-group">
						<label for="finaliza_em">Data Final</label>
						<input type="date" class="form-control" name="finaliza_em" value="<?= $finaliza_em;?>"/>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="id_produtos">Produto</label>
					<select class="form-control" name="id_produtos">							
						<?php	
						$query = "SELECT * FROM produtos WHERE lixo = 0";
						$resultado = $a->queryFree($query);
						if(isset($resultado)){
							while($linhas = $resultado->fetch_assoc()){					
								echo "<option value='".$linhas['id']."' ".($linhas['id'] == $id_produtos ? "selected" : '').">".$linhas['titulo']."</option>";						
							}	
						}else{
							echo "<option>Cadastre um perfil antes de usar</option>";
						}							
						?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-12">
					<div class="form-group col-sm-6">
					<label for="id_planos_mov">Planos</label>
						<br>					
						<?php	
						$query = "SELECT * FROM planos WHERE lixo = 0 ORDER BY nome ASC";
						$resultado = $a->queryFree($query);
						if(isset($resultado)){
							while($linhas = $resultado->fetch_assoc()){					
								echo  "
								  <div class='checkbox checkbox-success'>
								  <input type='checkbox' name='id_planos_mov[]' id='check".$linhas['id']."' value='".$linhas['id']."' ";
								  
								  if(isset($_POST['id'])){
									  foreach($id_planos_mov as $value){
										  if($linhas['id'] == $value)
											  echo "checked";
									  }	
								  }								  
								  
							    echo " /><label for='check".$linhas['id']."'> ".$linhas['nome']."</label></div>";
							}
						}else{
							echo "<option>Nenhum registro encontrado</option>";					
						}
						?>
					
				</div>
				</div>
			</div>
		</div>
	</div>

	<section class="input_hidden">		
		<?= ((isset($id)) ? "<input type='hidden' name='id' value='$id'/>" : ''); ?>
		<input type="hidden" name="retorno" value="<?= $retorno;?>" />
		<input type="hidden" name="flag" value="<?= $flag;?>" />
		<input type="hidden" name="tbl" value="contratos" />
		<input type="hidden" name="subTabela" value="planos_movimentos" />
		<input type="hidden" name="chave_cerquilha" value="on" />
		<input type="hidden" name="email" />
		<input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</section>
	<div class="form-group">
		<input class="btn btn-success rtrn-conteudo" value="Salvar" type="button" data-objeto="form-dados-perfil">
	</div>
</form>