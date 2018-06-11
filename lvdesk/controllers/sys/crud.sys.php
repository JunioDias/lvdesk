<?php
include("../model.inc.php");
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
			if(isset($dados["valor"])){
				$dados["valor"] = str_replace(',','.',str_replace('.','',$dados["valor"]));
			}
			unset($dados["confirmasenha"], $dados["flag"], $dados["tbl"], $dados["file"], $dados["caminho"]);
			$a->add($tabela, $dados);
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
				echo "<div msg_dialog class='confirm' title='Clique para fechar.'>Operação executada com sucesso.<br>Verifique o seu e-mail.</div>";
			}else{
				echo "<div msg_dialog class='erro' title='Clique para fechar.'>Falha na operação.</div>";
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
			if(isset($dados["valor"])){
				$dados["valor"] = str_replace(',','.',str_replace('.','',$dados["valor"]));
			}
			unset($dados["confirmasenha"], $dados["flag"], $dados["tbl"], $dados["caminho"]);
			if(isset($dados['id'])){
				$a->upd($tabela, $dados, $dados['id']);
			}else{
				$a->upd($tabela, $dados);
			}
			
			if($mysqli->affected_rows != '-1'){
				echo "
				<h1>
				Tudo certo!<br>Atualização confirmada. 
				</h1>
				";
				die();
			}else{
				echo "
				<h1>
				Isso não deveria acontecer...<br>Problemas no processo! <br>Atualização não confirmada. 
				</h1>";
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
	}
  }	
}
else{
	echo "<h1>O post está vazio. <br> Procure por erros de configuração no servidor.</h1>";
}
?>