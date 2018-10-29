<?php
include("../model.inc.php");
if(!empty($_POST)){
	$a = new Model;
	global $dados;
	$dados = $_POST;
	#print_r($_SESSION);
	switch($dados['flag']){
		case "OAuth":
			function requisicao($url, $method, $body = [], $token = null){
				$req = curl_init($url);
				$header = array();
				$header[] = 'Accept: application/json';
				if(!is_null($token)){
					$header[] = 'Authorization: ' . $token;
				}

				curl_setopt($req, CURLOPT_HTTPHEADER, $header);
				curl_setopt($req, CURLOPT_RETURNTRANSFER, true);

				if($method == "POST"){
					curl_setopt($req, CURLOPT_POST, true );
					curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($body));
				}

				$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
				$resp = json_decode(curl_exec($req), true);
				curl_close($req);

				return $resp;
			}
			if(isset($dados['id_dados'])){	
				$query 			= "SELECT * FROM pav_dados WHERE id = ".$dados['id_dados']." AND lixo = 0";
				$foo 			= $a->queryFree($query);
				$set_dados 		= $foo->fetch_assoc();
				$clientId 		= $set_dados['client_id'];
				$clientSecret 	= $set_dados['client_secret'];
				$username 		= $set_dados['client_user'];
				$password 		= $set_dados['client_pass'];
				$url 			= $set_dados['client_url']; # Caminho específico para requisição do cliente
				$urlOauth 		= $url . "/oauth/token";	# Caminho específico da autenticação	
				# Body da requisição do oauth
				$requestBody = [
					"client_id"=>$clientId,
					"client_secret"=>$clientSecret,
					"username"=>$username,
					"password"=>$password,
					"grant_type"=>"password"
				];		
			
				if(isset($dados['listagem'])){//Código #61
					unset($dados['listagem']);
					$_SESSION["datalogin"]["id_contrato"] = $dados['contrato'];	
				}			
				if(isset($_POST['nome']) || isset($_POST['cpf'])){
					$nome 	= htmlentities(urlencode($_POST['nome']));
					$cpf	= htmlentities(urlencode($_POST['cpf']));
					$query = $a->termosPesquisa($nome, 'nome_razaosocial', $cpf, 'cpf_cnpj');
					$authToken = $_SESSION['authorizationToken'];
					
					if(isset($query)){					
						$urlCliente = $url . "/api/v1/integracao/cliente?".$query;				
						//Faz requisição do cliente
						$reqCliente = requisicao($urlCliente, 'GET', [], $authToken);
						if(isset($dados['id_provedor'])){ //Código #55
							$_SESSION['resultado_pesquisa'] = $reqCliente;
							$_SESSION['resultado_pesquisa']['id'] = $dados['id_provedor'];
						}else{
							$_SESSION['resultado_pesquisa'] = $reqCliente;
						}
						#print_r($_SESSION['resultado_pesquisa']);
						include("../../views/resultado-pesquisa-provedor.php");
					}
				}else{
					//Faz autorização do oauth
					$reqOauth = requisicao($urlOauth, 'POST', $requestBody);
					//Monta o token Authorization 	
					if(isset($reqOauth['token_type'])){
						$tokenType = $reqOauth['token_type'];
						$accessToken = $reqOauth['access_token'];
						$_SESSION['authorizationToken'] = $tokenType . " " . $accessToken;
					}else{
						echo '
						<div class="alert alert-danger">
							<h4>Tivemos um problema...</h4>
							<p>Verifique se o contrato do cliente ainda é válido junto ao provedor.</p>
						</div>';
					}
				}
			}			
		break;
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