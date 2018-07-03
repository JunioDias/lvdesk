<?php
if(isset($id)){
	$query = "
	SELECT pav.*, atend.nome 
	FROM pav_inscritos AS pav 
	INNER JOIN atendentes AS atend ON atend.id = pav.atendente_responsavel 
	WHERE pav.id = '$id'";
	$a = new Model;
	$result = $a->queryFree($query);
	if(isset($result)){
		$matriz = $result->fetch_assoc(); 
	}
}
$data_abertura	= $matriz['data_abertura'];
$grupo		 	= $matriz['grupo_responsavel'];
$nome_cliente	= $matriz['nome_cliente'];
$cpf_cnpj		= $matriz['cpf_cnpj_cliente'];
$autor	 	 	= $matriz['nome'];
$endereco 		= $matriz['endereco_cliente'];
$telefone		= $matriz['telefone_cliente'];
$usuario		= $matriz['usuario'];
$senha_pppoe	= $matriz['senha_pppoe'];
// $nas			= $matriz['nas'];
// $pppoe		= $matriz['pppoe'];
$ip				= $matriz['ip'];
$protocol		= $matriz['protocol'];
$status			= $matriz['status'];
$historico		= $matriz['historico'];
$nome_provedor  = $matriz['nome_provedor'];
$flag	 		= "add";
$retorno		= ".content-sized";
?>

<form id="form-dados">
	<div class="form-group">
		<div class="panel panel-color panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Detalhes do Chamado</h3>
			</div>
			<div class="panel-body">
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="data_abertura">Data de abertura</label>
					<input type="text" class="form-control" name="data_abertura" value="<?= date("d/m/Y", strtotime($data_abertura)) ;?>">
				</div>
				<div class="form-group col-sm-6">
					<label for="grupo_responsavel">Grupo responsável</label>
					<input type="text" class="form-control" name="grupo_responsavel" value="<?= $grupo ;?>">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="status">Status</label>
					<input type="text" class="form-control" name="status" value="<?= $status ;?>">			
				</div>
				<div class="form-group col-sm-6">
					<label for="atendente_responsavel">Atendente responsável</label>
					<select class="form-control" name="atendente_responsavel" >			
					<?php
					$queryAtend	= "SELECT id, nome FROM atendentes WHERE tipo_atendente = '1' AND lixo = 0";
					if(isset($id)){
						$result = $a->queryFree($queryAtend);
						while($linhas = $result->fetch_assoc()){
							echo "<option value='".$linhas['id']."' ".($linhas['id']==$id ? 'selected' : '').">".$linhas['nome']."</option>";
						}	
					}				
					?>
					</select>	
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="autor">Autor</label>
					<input type="text" class="form-control" name="autor" value="<?= $autor ;?>">
				</div>	
				
				<div class="form-group col-sm-6">
					<label for="protocolo">Protocolo</label>
					<input type="text" class="form-control" value="<?= $protocol ;?>">
				</div>	
			</div>
		</div>
	</div>	
	
	<div class="form-group">
		<div class="panel panel-color panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Provedor: <?= $nome_provedor ;?></h3>
			</div>
			<div class="panel-body">
			<div class="row">
			  <div class="form-group col-sm-6">
				
				<div class="form-group">
					<label for="nome_cliente">Cliente</label>
					<input type="text" class="form-control" name="nome_cliente" value="<?= $nome_cliente ;?>">
				</div>
				
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
			  </div>
			  <div class="form-group col-sm-6">
				
				<div class="form-group">
					<label for="nas">NAS IP</label>
					<input type="text" class="form-control" name="nas" value="">			
				</div>
				<div class="form-group">
					<label for="pppoe">PPPoE</label>
					<input type="text" class="form-control" name="pppoe" value="">
				</div>
				<div class="form-group">
					<label for="senha_pppoe">Senha</label>
					<input type="text" class="form-control" name="senha_pppoe" value="<?= $senha_pppoe;?>">
				</div>
				<div class="form-group">
					<label for="ip">IP</label>
					<input type="text" class="form-control" name="ip" value="<?= $ip;?>">
				</div>
				
			  </div>
			</div>
			<div class="form-group">
				<label for="historico">Descrição do Histórico</label>
				<!-- Barra de Ferramentas -->
				<div id="wysihtml5-toolbar" style="display: none;"> 
				  <a data-wysihtml5-command="bold">Negrito</a>
				  <a data-wysihtml5-command="italic">Itálico</a>				  
				  
				  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red">Vermelho</a>
				  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green">Verde</a>
				  <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue">Azul</a>
				  <a data-wysihtml5-command="createLink">Link</a>
				  <div data-wysihtml5-dialog="createLink" style="display: none;">
					<label>
					  Link:
					  <input data-wysihtml5-dialog-field="href" value="http://" class="text">
					</label>
					<a data-wysihtml5-dialog-action="save">OK</a> <a data-wysihtml5-dialog-action="cancel">Cancelar</a>
				  </div>
				</div>
				<!-- Fim Barra de Ferramentas -->
				<textarea class="form-control " name="historico" id="historico"><?= $historico;?></textarea>
				
			</div>
			</div>
		</div>
	</div>	
		
	</div><!-- Fim Painel -->
	
	<!--</div>-->
	<input class="btn btn-success" value="Solucionado" type="button" >
</form>
	<script>
	var editor = new wysihtml5.Editor("historico", { // id of textarea element
	  toolbar:      "wysihtml5-toolbar", // id of toolbar element
	  parserRules:  wysihtml5ParserRules // defined in parser rules set 
	});
	</script>