<?php
include("../model.inc.php");
if(!empty($_POST)){
	$a = new Model;
	$dados = $_POST;
	switch($dados['flag']){
		case "PostgreSQL":
			if($dados['id']){
				$qry = "SELECT * FROM pav WHERE id='".$dados['id']."'";
				$result = $a->queryFree($qry);
				$array = $result->fetch_array(MYSQLI_ASSOC);
				if(isset($array)){
					$_SESSION['con_string'] = $con_string = "
						  host='".$array['host']."' 
						  port='".$array['porta']."' 
						  dbname='".$array['nome_bd']."'
						  user='".$array['usuario']."' 
						  password='".$array['senha_pav']."'";
					  
					$connect = pg_connect($con_string);			  
					
					if($connect){
						if(isset($dados['listagem'])){
							unset($dados['listagem']);
							$_SESSION["datalogin"]["id_contrato"] = $dados['contrato'];	
						}else{
							echo "<td><a data-toggle='modal' data-target='#myModal' >Pesquisar</a></td>";
						}
					}else{
						echo "<td class='text-danger' id='target-status".$dados['id']."'>Não foi possível conectar.</td>";  
					}
				}else{ 
					$con_string = $_SESSION['con_string']; 
					$connect = pg_connect($con_string);
					$query = $a->selecionaQueryPostgreSQL($dados['nome'], 'nome_cliente', $dados['cpf'], 'cpf_cnpj', $dados['endereco'], 'endereco', 'privado.cliente_view');		
					$result = pg_query($connect, $query);
					$info = pg_fetch_all($result);
					if($info === false){
						echo '<div class="alert alert-warning fade in">
						<h4>Nenhum registro encontrado.</h4>
						<p>Clique no botão abaixo para retornar.</p>
						<p class="m-t-10">
						  <button type="button" class="btn btn-default waves-effect regular-link" link="views/listagem.php">Fechar</button>
						</p>
						</div>';
					}else{
						if(isset($dados['id_provedor'])){
							$info['id'] = $dados['id_provedor'];							
						}
						$_SESSION['resultado_pesquisa']	= $info;
						//print_r($_SESSION['resultado_pesquisa']);
						include("../../views/resultado-pesquisa-provedor.php");
					}
				}		  
			}else{
				echo(
				'<div class="alert alert-danger fade in">
				<h4>Falha de processo.</h4>
				<p>O array não está configurado.<br>Houve um erro no retorno do banco de dados.<br>Por favor, entre em contato com o suporte.</p>
				<p class="m-t-10">
				  <button type="button" class="btn btn-default waves-effect rtrn-conteudo" >Fechar</button>
				</p>
				</div>'
				);  
			}
		break;
	}
}else{	  
	echo(
	'<div class="alert alert-warning fade in">
		<h4>Isso não deveria ter acontecido.</h4>
		<p>Uma situação inesperada ocorreu. <br>Por favor, entre em contato com o suporte.</p>
		<p class="m-t-10">
		  <button type="button" class="btn btn-default waves-effect rtrn-conteudo" >Fechar</button>
		</p>
	</div>'
	);
}
?>