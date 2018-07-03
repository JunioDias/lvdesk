<?php
include("../model.inc.php");
include("../actions.inc.php");
if(!empty($_POST)){
	switch($_POST['flag']){
		case "existeUser":
			$dados = $_POST;
			$tabela = $dados["tbl"];
			$a = new Model();
			$a->queryFree("SELECT * FROM $tabela WHERE lixo = 0 AND usuario = '".$dados['usuario']."'");
			#print_r($result);
			if ($result->num_rows > 0) { 
				echo "<span style='color:red;'>E-mail já cadastrado!</span>"; 
			}
		break;
		case "add":		#Código de Inclusão
			$dados = $_POST;
			$tabela = $dados["tbl"];
			$a = new Model();
			if(isset($dados["senha"])){
				if($dados["senha"]!=""){
					$dados['senha'] = md5($dados['senha']);	
				}	
			}
			if(isset($_FILES)){
				$pic = $_FILES;
				if(!empty($pic["file"])){
					$nomeFile = $pic["file"]["name"];
					$vetor = "file";
				}
				else if(!empty($pic["foto"])){
					$nomeFile = $pic['foto']["name"];
					$vetor = "foto";
				}
				else if(!empty($pic['media'])){
					$nomeFile = $pic['media']["name"];
					$vetor = "media";
				}
				else if(!empty($pic['imagem'])){
					$nomeFile = $pic['imagem']["name"];
					$vetor = "imagem";
				}
				if(isset($nomeFile)){
					$media = $a->addFoto($nomeFile, $vetor, $tabela);
					if(isset($media)){
						$dados[$vetor] = $media['name'];
					}
				}
			}			
			/* if(isset($dados["valor"])){
				$dados["valor"] = str_replace(',','.',str_replace('.','',$dados["valor"]));
			} */
			
			if(isset($dados["hora_add"])){
				unset($dados['hora_add']);
				$dados["data_abertura"] = date("Y-m-d H:i:s");
				$dados["protocol"] = $a->protocolo();
			}			
			
			if(isset($dados["idd"])){
				if($dados["idd"] == "solucionado")	{			
					$dados["id_pav"] 	= '0';
					$dados["validado"] 	= '1';
				}
				unset($dados['idd']);
			}	
			
			unset($dados["confirmasenha"], $dados["flag"], $dados["tbl"], $dados["file"], $dados["caminho"], $dados["retorno"] );
			
			if(in_array(true, array_map('is_array', $dados), true) == ''){
				unset($dados['chave_cerquilha']);
				$a->add($tabela, $dados);
			}else{
				$i 	= 1; 				
				$valor = NULL;
				$array = NULL;
				if($dados['chave_cerquilha']){
					unset($dados['chave_cerquilha']);
					
					foreach($dados as $key=>$value){
						if(is_array($value)){
							foreach($value as $vlr){
							  $valor .= $vlr;
							  if($i < sizeof($value)){
								$valor .= "#";
								$i++;
							  }
							}
							if(isset($array[$key])){
								$array[$key] .= $valor;
							} else{
								$array[$key] = $valor;
							}
						}else{							
							if(isset($array[$key])){
								$array[$key] .= $value;
							} else{
								$array[$key] = $value;
							}
						}
					}
					$a->add($tabela, $array);
				}else{
					echo "00034 - Falha de função para arrays multifuncionais genérica";
				}
			}				
		break;
		case "addUser":
			require_once("../parametros.inc.php");
			$parametros_server = new Param();
			$email_settings = $parametros_server->emailConfig();
			$dados = $_POST;
			$tabela = $dados["tbl"];
			
			$dados['uid'] = uniqid( rand(), true );
			$dados['data_ts'] = time();
			
			$a = new Model();
			if(isset($dados["senha"])){
				if($dados["senha"]!=""){
					$dados['senha'] = md5($dados['senha']);	
				}	
			}					
			unset($dados["flag"], $dados["tbl"]);					
			$result = $a->addUser($tabela, $dados);
			if($result->num_rows == '1'){
				$resultado = $result->fetch_assoc();
				
				$url = sprintf( 'id=%s&email=%s&uid=%s&key=%s', $resultado['id'], md5($resultado['usuario']), md5($resultado['uid']), md5($resultado['data_ts']));
				$mensagem = 'Para confirmar seu cadastro acesse o link:<br>'."\n";
				$mensagem .= sprintf('http://www.'.$email_settings['dominio'].'/validador.php?%s',$url);
		
				// enviar o email
				$a->envia($resultado, 'Registro de cadastro - '.$parametros_server->title(), $mensagem);
				echo '
				<div class="alert alert-success fade in">
				<h4>Operação executada com sucesso.</h4>
				<p>Verifique o seu e-mail.<br>Clique no botão abaixo para fechar esta mensagem.</p>
				<p class="m-t-10">
				  <button type="button" class="btn btn-default waves-effect" data-dismiss="alert" >Fechar</button>
				</p>
				</div>
				';
			}else{
				echo '
				<div class="alert alert-danger fade in">
				<h4>Falha no processo.</h4>
				<p>Houve um erro de causa desconhecida. Contacte o suporte.<br>Clique no botão abaixo para fechar esta mensagem.</p>
				<p class="m-t-10">
				  <button type="button" class="btn btn-default waves-effect" data-dismiss="alert" >Fechar</button>
				</p>
				</div>
				';
			}
		break;
		case "addGaleria":
			$a = new Model();
			$dadosPost = $_POST;
			$tabela = $dadosPost["tbl"];
			unset($dadosPost['flag'], $dadosPost['tbl']);			
			$arr = $_FILES['file'];			
			if($dadosPost['tipo']=='galeria'){
				$path = "../media/imagens/galeria/albuns/fotos_galeria/";
			}else if($dadosPost['tipo']=='album'){				
				$path = "../media/imagens/galeria/albuns/".$dadosPost['id_contato']."/";
				if (!file_exists($path)) {
					mkdir("../media/imagens/galeria/albuns/".$dadosPost['id_contato']."/", 0700);
				}
			}
			$goose = array();
			foreach($arr as $key => $dados){
				for($z=0; $z<count($dados); $z++){
					$goose[$z][$key] = $dados[$z];						
				}
			}	
			
			foreach($goose as $indice){
				$extfile  = strtolower(substr($indice['name'], strripos($indice['name'], '.', -1)));
				$indice['name'] = time().mt_rand(1000, 9000).$extfile;
				move_uploaded_file($indice['tmp_name'],$path.$indice['name']);					
				$dadosPost['midia'] = $indice['name'];
				$a->addGallery($tabela, $dadosPost);
			}
			
			if ($mysqli->affected_rows > 0) { 
				echo "<div msg_dialog class='confirm' title='Clique para fechar.'>Operação executada com sucesso.</div>"; 
			}else{
				echo "<div msg_dialog class='alerta' title='Clique para fechar.'>Falha na operação.</div>";
			}
		break;
		case "addVideo":
			$data = $_POST;		
			$arr = $_FILES['media'];
			$tabela = $data['tbl'];
			$path = "../media/video/videoteca/";
			$a = new Model();
			unset($data["flag"], $data["tbl"]);	
			$retorno = $a->ajeitaFoto($arr, $tbl);
			
			if ($retorno != -1) { 
				echo "<div msg_dialog class='confirm' title='Clique para fechar.'>Operação executada com sucesso.</div>"; 
			}else{
				echo "<div msg_dialog class='alerta' title='Clique para fechar.'>Falha na operação.</div>";
			}
		break;
		case "exc":		#Código de Exclusão
			$dados = $_POST;
			$tabela = $dados["tbl"];
			if(isset($dados['arquivo'])){
				unlink("../".$dados['arquivo']);	
			}
			unset($dados["flag"], $dados["tbl"], $dados['arquivo']);
			$a = new Model();
			$a->exc($tabela, $dados["id"]);
			
		break;
		case "edt":		#Código de Edição
			$dados = $_POST;
			$tabela = $dados["tbl"];
			$path = "'Location: ".$dados['callback']."'";
			$filtro = "id = '".$dados['id']."'";
			unset($dados["flag"], $dados["tbl"]);
			$a = new Model();
			$a -> busca("*", $tabela, $filtro);
			$resultado = $result->fetch_assoc();
			echo json_encode($resultado);
			//header($path);
		break;
		case "update":		#Código de Atualização da Edição			
			$dados = $_POST;
			$tabela = $dados["tbl"];
			$a = $b = new Model();
			if(isset($dados["senha"])){
				if($dados["senha"]!=""){
					$dados['senha'] = md5($dados['senha']);	
				}else{
					unset($dados["senha"]);
				}
			}
			if(isset($_FILES)){			
				$pic = $_FILES;
				if(!empty($pic["file"])){
					$nomeFile = $pic["file"]["name"];
					$vetor = "file";
				}
				else if(!empty($pic["foto"])){
					$nomeFile = $pic['foto']["name"];
					$vetor = "foto";
				}
				else if(!empty($pic['media'])){
					$nomeFile = $pic['media']["name"];
					$vetor = "media";
				}
				else if(!empty($pic['imagem'])){
					$nomeFile = $pic['imagem']["name"];
					$vetor = "imagem";
				}
				/* 
				if(isset($nomeFile)){
					$media = $a->addFoto($nomeFile, $vetor, $tabela);
					if(isset($media)){
						$dados[$vetor] = $media['name'];
					}
				}else{
					unset($dados['media']); # só é possível a partir de addProdutos.php, pois o submit é personalizado
					echo "<strong>Unset media<br></strong>";
				} */	
			}
			# Tratamento para campos tipo DATE no perfil do usuário
			if(isset($dados["data_nascimento"])){
				if(empty($dados['data_nascimento'])){
					$dados["data_nascimento"] = date('Y-m-d');
				}
			}
			
			#####################Fim de Sessão#####################
			/* if(isset($dados["valor"])){
				$dados["valor"] = str_replace(',','.',str_replace('.','',$dados["valor"]));
			} */
			unset($dados["confirmasenha"], $dados["flag"], $dados["tbl"], $dados["caminho"], $dados["retorno"] );
			
			if(isset($dados['id'])){
				if(in_array(true, array_map('is_array', $dados), true) == ''){
					unset($dados['chave_cerquilha']);
					$a->upd($tabela, $dados, $dados['id']);
				}else{
					$i 	= 1; 				
					$valor = NULL;
					$array = NULL;
					if($dados['chave_cerquilha']){
						unset($dados['chave_cerquilha']);
						
						foreach($dados as $key=>$value){
							if(is_array($value)){
								foreach($value as $vlr){
								  $valor .= $vlr;
								  if($i < sizeof($value)){
									$valor .= "#";
									$i++;
								  }
								}
								if(isset($array[$key])){
									$array[$key] .= $valor;
								} else{
									$array[$key] = $valor;
								}
							}else{							
								if(isset($array[$key])){
									$array[$key] .= $value;
								} else{
									$array[$key] = $value;
								}
							}
						}
						$a->upd($tabela, $array, $dados['id']);
					}else{
						echo "00034 - Falha de função para arrays multifuncionais genérica";
					}
				}
			}else{
				$a->upd($tabela, $dados);
			}
			
			if($mysqli->affected_rows != '-1'){
				echo '
				<div class="alert alert-success fade in">
				<h4>Operação executada com sucesso.</h4>
				<p>Clique no botão abaixo para fechar esta mensagem.</p>
				<p class="m-t-10">
				  <button type="button" class="btn btn-default waves-effect" data-dismiss="alert" >Fechar</button>
				</p>
				</div>
				';
				die();
			}else{
				echo '
				<div class="alert alert-danger fade in">
				<h4>Falha no processo.</h4>
				<p>Houve um erro de causa desconhecida. Contacte o suporte.<br>Clique no botão abaixo para fechar esta mensagem.</p>
				<p class="m-t-10">
				  <button type="button" class="btn btn-default waves-effect" data-dismiss="alert" >Fechar</button>
				</p>
				</div>
				';
				die();
			}
		break;
		case "abreArtigoBlog":
			$dados = $_POST;
			$a = new Model();
			$a->queryFree("SELECT * FROM artigos WHERE lixo = 0 AND id = '".$dados['id']."'");
			if ($result->num_rows > 0) { 
				$artigo = $result->fetch_assoc();
				echo "
				<h3>".$artigo['titulo']."</h3><br>
				<span style='font-style:italic;'>".$artigo['chamada']."</span><br><br>
				<p><b>Por ".$artigo['autor']."</b></p>
				<br><a class='botVoltar' href='index.php'>Voltar</a>
				<p>
				  <span style='float:left; padding: 10px 10px 0 0;'>
				     <img src='media/imagens/galeria/artigos/".$artigo['imagem']."' alt='".$artigo['imagem']."' class='imagem_artigo'/>
				  </span>
				  ".$artigo['texto']."
				</p><br>
				<a class='botVoltar' href='index.php'>Voltar</a>
				"; 
			}else{
				echo "<div msg_dialog class='alerta' title='Clique para fechar.'>
				Isso não deveria acontecer...<br>Problemas no processo! <br>Nenhum artigo foi encontrado. 
				</div>";
			}
		break;
		case "entrada": // Entrada de dados selecionados para atendimento 1º nível
			global $array;
			global $id;
			$dados = $_POST; 
			
			if(isset($_SESSION['resultado_pesquisa']['id'])){
				$id	= $_SESSION['resultado_pesquisa']['id'];
				unset($_SESSION['resultado_pesquisa']['id']);
			}else{
				echo "ATENÇÃO: ID do resultado da pesquisa retornou vazio!<br>";
				print_r($_SESSION['resultado_pesquisa']);
			}
			
			/* print_r($dados);
			echo"<br><br>";
			print_r($_SESSION['resultado_pesquisa']); */ 
			
			$indice = $dados["idd"];			
			foreach($_SESSION['resultado_pesquisa'][$indice] as $key=>$value)
				$array[$key] = $value;
				
			include("../../views/atendimento.php");	
		break;
		
		case "entrada2Nivel": // Entrada de dados selecionados para atendimento 2º nível			
			global $id;
			$dados = $_POST;			
			$id = $dados["idd"];			
			include("../../views/atendimento-entrada-nivel-2.php");	 
		break;
		
		case "emabertos":
		$dados = $_POST;
		$a = new Model;
		$e = new Acoes;
		$query	= "SELECT * FROM pav_inscritos WHERE lixo = 0 AND validado = 0 AND id_pav = 1 ORDER BY data_abertura ASC";
		$return	= $a->queryFree($query);
		while($linhas = $return->fetch_assoc()){
			$e->conteudoTabelaCGR($linhas, $dados['caminho'], "entrada2Nivel");
		}
		break;
		
		case "pesquisaCGR":
		$dados = $_POST;
		$a = new Model;
		$e = new Acoes;
		$query = $a->selecionaQueryMySQL($dados['nome_cliente'], 'nome_cliente', $dados['cpf'], 'cpf_cnpj', $dados['nome_provedor'], 'nome_provedor', 'pav_inscritos');
		$return = $a->queryFree($query);
		if($return === false){
			echo '<tr><td>Nenhum registro encontrado.</td></tr>';
		}else{
			while($linhas = $return->fetch_assoc()){
				$e->conteudoTabelaCGR($linhas, $dados['caminho'], $dados['flag']);
			}
		}
		break;
		
		case "pesquisaHistoricos":
		$dados = $_POST;
		$a = new Model;
		$e = new Acoes;
		
		$query		= $a->selecionaQueryMySQL($dados['nome_cliente'], 'nome_cliente', $dados['cpf'], 'cpf_cnpj_cliente', $dados['nome_provedor'], 'nome_provedor', 'pav_inscritos');
		if($query == 'SELECT * FROM pav_inscritos '){
			$query 	   .= "WHERE validado = 1 ORDER BY data_abertura ASC";
		}else{
			$query 	   .= " AND validado = 1 ORDER BY data_abertura ASC";
		}
		$return = $a->queryFree($query);
		if($return === false){
			echo '<tr><td>Nenhum registro encontrado.</td></tr>';
		}else{
			while($linhas = $return->fetch_assoc()){
				$e->conteudoTabelaCGR($linhas, $dados['caminho'], $dados['flag'], 'On');
			}
		}		
		break;
		
		case "pesquisaListagem":
		$dados = $_POST;
		$a = new Model;
		$e = new Acoes;
		
		$query		= $a->selecionaQueryMySQL($dados['nome_cliente'], 'nome_cliente', $dados['cpf'], 'cpf_cnpj_cliente', $dados['nome_provedor'], 'nome_provedor', 'pav_inscritos');
		if($query == 'SELECT * FROM pav_inscritos '){
			$query 	   .= "WHERE finalizado = 1 ORDER BY data_abertura ASC";
		}else{
			$query 	   .= " AND validado = 1 AND finalizado = 0 ORDER BY data_abertura ASC";
		}
		$return = $a->queryFree($query);
		if($return === false){
			echo '<tr><td>Nenhum registro encontrado.</td></tr>';
		}else{
			while($linhas = $return->fetch_assoc()){
				$e->conteudoTabelaCGR($linhas, $dados['caminho'], $dados['flag']);
			}
		}		
		break;
	}
  }	
else{
	echo "<h1>O post está vazio. <br> Procure por erros de configuração no servidor.</h1>";
}
?>