<?php
include("../model.inc.php");
include("../actions.inc.php");
include("../logs.inc.php");
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
				$vetor = NULL;
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
				if(isset($_FILES[$vetor])){
					if($_FILES[$vetor]['error']!=0){
						unset($_FILES);
					}else{				
						if(isset($nomeFile)){
							$media = $a->addFoto($nomeFile, $vetor, $tabela);
							if(isset($media)){
								$dados[$vetor] = $media['name'];
							}
						}
					}	
				}	
			}			
			if(isset($dados["valor_unit"])){
				$dados["valor_unit"] = str_replace(',','.',str_replace('.','',$dados["valor_unit"]));
			}
			
			if(isset($dados["hora_add"])){
				unset($dados['hora_add']);
				$dados["data_abertura"] = date("Y-m-d H:i:s");
				$dados["protocol"] = $a->protocolo();
				$dados["autor"] = $dados['atendente_responsavel'];
			}			
			
			if(isset($dados["_wysihtml5_mode"])){
				unset($dados["_wysihtml5_mode"]);
			}
			
			if(isset($dados['contatos'])){//campo de clientes que permite inserção dos contatos de e-mail
				$contatos = $dados['contatos'];
				unset($dados['contatos']);
				/* $contatos = trim($contatos);
				$contatos = str_replace(array("\s", "\n", "\r", "&nbsp;", "/\r|\n/", "<br>", "<div>", "</div>"), "", $contatos);
				$contatos = preg_replace( "/\r|\n/", "", $contatos); */				
				$array_contatos = explode(",", $contatos);
			}
			
			if(isset($dados['id_contratos'])){
				if($dados['id_contratos']==0){//inclusão de comunicado interno sem atribuição de clientes
					//nenhum atendimento é computado: tratar posteriormente com retorno de erro
				}else{
					if(isset($dados["idd"])){
						if($dados["idd"] == "solucionado")	{
							$dados["validado"] 	= '1';
							$dados["status"]	= '2';
						}
						unset($dados['idd']);
						$a->gravaAtendimento($dados);
						#unset($dados['id_contratos']);
					}else{
						$a->gravaAtendimento($dados);
						#unset($dados['id_contratos']);
					}
				}
			}
			
			if(isset($dados['id_contatos'])){
				if(is_array($dados['id_contatos'])){
					foreach($dados['id_contatos'] as $value_id_contato ){
						if(isset($dados['grupo_responsavel'])){
							foreach($dados['grupo_responsavel'] as $id_atendente_responsavel){
								$query_comunica = "INSERT INTO comunicacao_interna_movimentos (protocol, descricao, id_autor, id_destinatario, nome_provedor, data, id_contratos, atendente_responsavel) VALUES('".$dados['protocol']."', '".$dados['historico']."', '".$dados['autor']."', '".$value_id_contato."', '".$dados['nome_provedor']."', '".$dados['data_abertura']."', '".$dados['id_contratos']."', '".$id_atendente_responsavel."')";
								$a->queryFree($query_comunica);
							}
						}else{
							$query_comunica = "INSERT INTO comunicacao_interna_movimentos (protocol, descricao, id_autor, id_destinatario, nome_provedor, data, id_contratos, atendente_responsavel) VALUES('".$dados['protocol']."', '".$dados['historico']."', '".$dados['autor']."', '".$value_id_contato."', '".$dados['nome_provedor']."', '".$dados['data_abertura']."', '".$dados['id_contratos']."', '".$dados['atendente_responsavel']."')";
							$a->queryFree($query_comunica);
						}
					}
				}
				unset($dados['id_contatos']);
			}
			
			if(isset($dados['subTabela'])){ 
				if($dados['subTabela']=="planos_movimentos"){# cadastro auxiliar dos contratos na tabela planos_movimentos
					$newlog['tabela'] = $dados['subTabela'];
					# instancia variável para foreach tratar os planos selecionados
					$trata_planos = $dados['id_planos_mov'];
					$id_planos = NULL;
					if($dados['chave_cerquilha']){
						$cerq = $dados;
						unset($cerq['chave_cerquilha']);
						$id_planos = $a->processaCerquilhas($cerq);						
					}
					# previne que o fluxo entre pelo IF errado
					$dados['id_planos_mov'] = $id_planos['id_planos_mov']; 					
				}else{			
					if(isset($dados['id'])){ # caso seja uma inserção de logs para o CGR
						$newlog['protocol'] 		= $dados['protocol'];
						$newlog['descricao']		= $dados['historico'];
						$newlog['files']			= NULL;
						$newlog['id_atendente']		= $dados['atendente_responsavel'];
						$newlog['id_pav_inscritos']	= $dados['id'];
						$newlog['data']				= date('Y-m-d H:i:s');
						
						$grab = $a->add($dados['subTabela'], $newlog);
						
					}else{ # caso seja a primeira inserção de log (nível 1)
						if(isset($dados["status"])){
							if($dados["status"]	== '2'){
								$newlog['solution'] 	= 1;
							}
						}
						$newlog['protocol'] 		= $dados['protocol'];
						$newlog['descricao']		= $dados['historico'];
						$newlog['files']			= NULL;
						$newlog['id_atendente']		= $dados['atendente_responsavel'];
						$newlog['data']				= date('Y-m-d H:i:s');
						$newlog['tabela']			= $dados['subTabela'];						
					}
				}	
				unset($dados['id_atendente'], $dados['subTabela'], $dados['id']);
			}
			
			if($dados["retorno"]==".modal-body-add"){
				$select_retorno = $dados["retorno"];
			}
			
			unset(
			$dados["confirmasenha"], 
			$dados["flag"], 
			$dados["tbl"], 
			$dados["file"], 
			$dados["caminho"], 
			$dados["retorno"],
			$dados["id_grupo"]
			);
			
			if(in_array(true, array_map('is_array', $dados), true) == ''){
				unset($dados['chave_cerquilha']);
				$grab = $a->add($tabela, $dados);
				if($grab == true){
					if(isset($array_contatos)){//agenda de contatos válidos para clientes que usam e-mail
						$ult_id = $_SESSION['ult_id'];
						foreach($array_contatos as $value){
							$value = str_replace(array("\n", "\r", "&nbsp;", "/\r|\n/", "<br>", "<div>", "</div>", "<span>", "</span>"), "", $value);
							$newcontato['contatos'] 	= trim($value);
							$newcontato['id_cliente'] 	= $ult_id;
							$a->add("agenda_contatos", $newcontato);
						}
					}
					if(isset($newlog['tabela'])){//tabelas auxiliares de movimentação
						
						if($newlog['tabela']=="pav_movimentos"){
							$newlog['id_pav_inscritos'] = $_SESSION['ult_id'];
							$tabela = $newlog['tabela'];
							unset($newlog['tabela']);
							$a->add($tabela, $newlog);
							
						}else if($newlog['tabela']=="planos_movimentos"){
							$newlog['id_contratos'] = $_SESSION['ult_id'];	
							#configura novo array para tabela auxiliar
							$newlog['id_cliente'] 	= $dados['id_cliente'];
							#$newlog['id_planos'] 	= $id_planos['id_planos_mov'];
							$newlog['data_limite'] 	= $dados['finaliza_em'];							
							$tabela = $newlog['tabela'];
							unset($newlog['tabela']);
							#tratar quantidade e limite dos planos 							
							foreach($trata_planos as $value){
								$query_contrato = "SELECT id, valor_unit, limite FROM planos WHERE id = '".$value."' AND lixo = 0";
								$foo = $a->queryFree($query_contrato);
								if($dados_contrato = $foo->fetch_assoc()){							
									$newlog['id_planos'] 			= $dados_contrato['id'];
									$newlog['qntd_atendimentos'] 	= $dados_contrato['limite'];
									$newlog['vlr_nominal'] 			= $dados_contrato['valor_unit'];							
									$a->add($tabela, $newlog);
								}
							}
						}			
					}
					if(isset($select_retorno)){
						$foo = $a->queryFree("SELECT id, nome FROM pav");
						$retorno = $foo->fetch_assoc();
						return $retorno;
					}else{
						echo '
						<div class="alert alert-success">
						<h4>Muito bom!</h4>
						A operação foi realizada com sucesso. <a href="." class="alert-link">Clique aqui</a> para atualizar os status do sistema.
						</div>';
					}
				}
			}else{
				//Para os checkboxes da rotina de módulos etc.
				if(isset($dados['chave_cerquilha'])){
					unset($dados['chave_cerquilha']);					
					$array = $a->processaCerquilhas($dados);
					$a->add($tabela, $array);
				}else{
					echo "Código #18237 - Existe um array não tratado na sessão.";
				}
			}				
		break;
		
		case "addLog":		
			$array 	= $_POST; 
			$a = new Model();
			$dados['protocol'] 			= $array['protocol'];
			$dados['descricao']			= $array['historico'];
			$dados['files']				= NULL;
			$dados['id_atendente']		= $array['id_atendente'];
			$dados['id_pav_inscritos']	= $array['id'];
			$dados['data']				= date('Y-m-d H:i:s');
			isset($array['solution']) ? $dados['solution'] = $array['solution'] : $dados['solution'] = 0;
			
			$captura = $a->add('pav_movimentos', $dados);
			
			if($array["retorno"] == ".section_historico_log"){
				if($captura == true){
					$log = new Logs;
					$query = "SELECT cpf_cnpj_cliente FROM pav_inscritos WHERE id = '".$array['id']."'";
					$ok = $a->queryFree($query);
					if($arr = $ok->fetch_assoc()){
						$log->ultimosAtendimentos($arr['cpf_cnpj_cliente']);	
					}
				}
			}else{	
				if($captura == true){
					$log = new Logs;						
					$query_movimentos = "SELECT pav.id, pav.protocol, pav.data, pav.descricao, pav.solution, atend.nome FROM pav_movimentos AS pav INNER JOIN atendentes AS atend ON atend.id = pav.id_atendente INNER JOIN pav_inscritos ON pav_inscritos.id = pav.id_pav_inscritos WHERE pav.id_pav_inscritos = '".$array['id']."'  AND pav.lixo = 0 ORDER BY pav.data DESC ";
					$result = $a->queryFree($query_movimentos);
					if($result){
						while($linhas = $result->fetch_assoc()){
							$log->timeline($linhas, $linhas['solution'], 'fa-check');
						}									
					}
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
		case "verifica_exc_plano":		#Verifica se o plano está vinculado a um contrato antes de ser excluído
			$dados = $_POST;
			$query_teste = "SELECT id_contratos FROM planos_movimentos WHERE lixo = 0 AND id_planos = '".$dados['id']."'";
			$a = new Model;
			$retorno = $a->queryFree($query_teste);
			if(isset($retorno)){
				$foo = $retorno->fetch_assoc();
				if($foo['id_contratos'] != ''){				
					echo ("
						<script type='text/javascript'>
						$(document).ready(function () {
							$('#alerta').modal('toggle');	
						});
						</script>
						");
				}else{
					$a->exc('planos', $dados["id"]);					
				}
			}
		break;
		case "mensagens":
			$dados = $_POST;
			include("../../views/comunicacao-crud.php");
		break;
		
		case "update":		#Código de Atualização da Edição			
			$dados = $_POST;
			$tabela = $dados["tbl"];
			$a = $b = new Model();
			if(isset($dados["senha"])){
				if($dados["senha"]!=""){
					$query_teste = "SELECT senha FROM $tabela WHERE id = '".$dados['id']."'";
					$foo = $a->queryFree($query_teste);
					$testa_senha = $foo->fetch_assoc();
					if($testa_senha['senha'] == $dados['senha']){
						unset($dados["senha"]);
					}else{
						$dados['senha'] = md5($dados['senha']);	
					}
				}else{
					unset($dados["senha"]);
				}
			}
			if(isset($_FILES)){			
				$pic = $_FILES;
				$vetor = NULL;
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
				if(isset($_FILES[$vetor])){
					if($_FILES[$vetor]['error']!=0){
						unset($_FILES);
					}else{				
						if(isset($nomeFile)){
							$media = $a->addFoto($nomeFile, $vetor, $tabela);
							if(isset($media)){
								$dados[$vetor] = $media['name'];
							}
						}
					}	
				}					
			}
			# Tratamento para campos tipo DATE no perfil do usuário
			if(isset($dados["data_nascimento"])){
				if(empty($dados['data_nascimento'])){
					$dados["data_nascimento"] = date('Y-m-d');
				}
			}
			
			if(isset($dados["valor_unit"])){
				$dados["valor_unit"] = str_replace(',','.',str_replace('.','',$dados["valor_unit"]));
			}
			
			if(isset($dados["hora_add"])){
				unset($dados['hora_add']);
				/* $dados["data_abertura"] = date("Y-m-d H:i:s");
				$dados["protocol"] = $a->protocolo(); */
			}			
			
			if(isset($dados["_wysihtml5_mode"])){
				unset($dados["_wysihtml5_mode"]);
			}
			
			if(isset($dados["idd"])){
				if($dados["idd"] == "solucionado")	{			
					$dados["id_pav"] 	= '0';
					$dados["validado"] 	= '1';
					$dados["status"]	= '2';					
				}
				unset($dados['idd']);
			}
			
			if(isset($dados['contatos'])){//campo de clientes que permite inserção dos contatos de e-mail
				$contatos = $dados['contatos'];
				unset($dados['contatos']);				
				/* $contatos = trim($contatos);
				$contatos = str_replace(array("\s", "\n", "\r", "&nbsp;", "/\r|\n/", "<br>"), "", $contatos);
				$contatos = preg_replace( "/\r|\n/", "", $contatos); */								
				$array_contatos = explode(",", $contatos);
			}
			
			unset($dados["confirmasenha"], $dados["flag"], $dados["tbl"], $dados["caminho"], $dados["retorno"], $dados['subTabela'] );
			
			if(isset($dados['id'])){
				if(in_array(true, array_map('is_array', $dados), true) == ''){
					unset($dados['chave_cerquilha']);
					$a->upd($tabela, $dados, $dados['id']);
					
					if(isset($array_contatos)){
						$query_delete = "DELETE FROM agenda_contatos WHERE id_cliente = ".$dados['id'];
						$a->queryFree($query_delete);
						$atualiza_contatos['id_cliente'] = $dados['id'];
						foreach($array_contatos as $value){
							$value = str_replace(array("\n", "\r", "&nbsp;", "/\r|\n/", "<br>", "<div>", "</div>", "<span>", "</span>"), "", $value);
							$atualiza_contatos['contatos'] = trim($value);
							$a->add("agenda_contatos", $atualiza_contatos);
						}
					}
				}else{
					/* $i 	= 1; 				
					$valor = NULL; */
					$array = NULL;
					if($dados['chave_cerquilha']){
						unset($dados['chave_cerquilha']);
						
						foreach($dados as $key=>$value){
							if(is_array($value)){
								$valor = NULL;
								$i = 1;
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
					<div class="alert alert-success">
                    <h4>Muito bom!</h4>
					A operação foi realizada com sucesso. <a href="." class="alert-link">Clique aqui</a> para atualizar os status do sistema.
					</div>	
				';
				die();
			}else{
				echo '
				<div class="alert alert-danger fade in">
				<h4>Falha no processo.</h4>
				<p>Houve um erro de causa desconhecida. Contacte o suporte.<br>Será necessário reiniar a rotina.</p>
				<a href="." class="alert-link">Clique aqui</a> para atualizar o navegador.
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
			global $id_provedor;
			$dados = $_POST; 
			$a = new Model();
			if(isset($_SESSION['resultado_pesquisa']['id'])){
				$id_provedor = $_SESSION['resultado_pesquisa']['id'];
				unset($_SESSION['resultado_pesquisa']['id']);
			}else{
				echo "ATENÇÃO: ID do resultado da pesquisa retornou vazio!<br> Consulte pav.sys.php -> Código #55";
			}
			#print_r($_SESSION['resultado_pesquisa']['clientes']);die();
			$indice = $dados["idd"];			
			foreach($_SESSION['resultado_pesquisa']['clientes'][$indice] as $key=>$value)
				$array[$key] = $value;
				
			include("../../views/atendimento.php");	
		break;
		
		case "entrada2Nivel": // Entrada de dados selecionados para atendimento 2º nível			
			global $id;
			$dados = $_POST;			
			$id = $dados["idd"];
			include("../../views/atendimento-entrada-nivel-2.php");	 
		break;
		
		case "ultimosAtendimentos":
		$log = new Logs;
		$a = new Model;
		$dados = $_POST;
		$query_movimentos = "
		SELECT pav.id, pav.protocol, pav.data, pav.descricao, pav.solution, atend.nome FROM pav_movimentos AS pav INNER JOIN atendentes AS atend ON atend.id = pav.id_atendente INNER JOIN pav_inscritos ON pav_inscritos.id = pav.id_pav_inscritos WHERE pav.id_pav_inscritos = '".$dados['id']."' AND pav.lixo = 0 ORDER BY pav.data DESC";
		$resultado = $a->queryFree($query_movimentos);
		if($resultado){
			while($linhas = $resultado->fetch_assoc()){
				$log->timeline($linhas, $linhas['solution'], 'fa-check');
			}					
		}
		break;
		
		case "emabertos":
		$dados = $_POST;
		$a = new Model;
		$e = new Acoes;
		$query	= "SELECT * FROM pav_inscritos WHERE lixo = 0 AND validado = 0 ORDER BY data_abertura ASC";
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
			$query 	   .= "WHERE validado = 1 AND autor = ".$dados['autor']." ORDER BY data_abertura ASC";
		}else{
			$query 	   .= " AND validado = 1 AND autor = ".$dados['autor']." ORDER BY data_abertura ASC";
		}
		$retorno = $a->queryFree($query);
		$t = $a->queryFree($query);
		$teste = $t->fetch_assoc();
		if(empty($teste['id'])){
			echo '<tr><td>Nenhum registro encontrado.</td></tr>';
		}else{
			while($linhas = $retorno->fetch_assoc()){
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
		
		case "visualizar":
			global $id;			
			$id = $_POST["idd"];
			include("../../views/historicos-visualizar.php");
		break;
		
		case "planosMovimentos":
			$dados = $_POST;
			$valor = NULL;
			$i = 0;
			//salvar em planos_movimentos	
			foreach($dados as $key=>$value){
				if(is_array($value)){
					foreach($value as $vlr){
					  $array['id_planos'] = $vlr;
					  echo '<br>'; print_r ($array);
					 /*  if(is_null($dados['id'])){
						$a->add('planos_movimentos', $array);  
					  }else{
						echo "editar";
					  } */
					}
				}else{							
					if(strpos($key, "id_") === 0){
						if(isset($array[$key])){
							$array[$key] .= $value;
						} else{
							$array[$key] = $value;
						}
					}					
				}
			} 
		break;
		
		case "selecionaGrupoAtribuicao":
			$act = new Acoes;
			$dados = $_POST;
			$retorno = $act->atribuiGrupo($dados['id_grupo']);	
			return $retorno;	
		break;
		
		case "addComunicacao":
			$a = new Model;
			$array = $_POST;
			$tabela = $array['tbl'];
			unset($array['_wysihtml5_mode'], $array['flag'], $array['tbl'], $array['caminho'], $array['retorno'], $array['chave_cerquilha']);
			if(isset($array['id_contatos'])){
				foreach($array['id_contatos'] as $value_id_contato ){
					$count 	= 1;
					$coluna = NULL;
					$valor 	= NULL;
					foreach($array as $key=>$value){
						if($key == "id_contatos"){
							$coluna .= $key;
							$valor  .= "'".$value_id_contato."'";
						}else{
							$coluna .= $key;
							$valor  .= "'".$value."'";
							if($count < sizeof($array)){
								$coluna .= ", ";
								$valor  .= ", ";
							}
						}
						$count++;
					}
					$a->queryFree("INSERT INTO $tabela ($coluna) VALUES($valor)");
				}
			}
			echo '
				<div class="alert alert-success">
				<h4>Serviço comunicado!</h4>
				A operação foi realizada com sucesso. <a href="." class="alert-link">Clique aqui</a> para atualizar os status do sistema.
				</div>';
		break;

		case "pesquisaDestinatario":			
			$a = new Model;
			$array = $_POST;
			$query = "SELECT id, nome FROM usuarios WHERE nome LIKE '".$array['nome']."%'";
			$select = $a->queryFree($query);
			$ret = $select->fetch_assoc();
			if(!is_null($ret['id'])){
				echo "<span id='span_nome_".$ret['id']."' class='label label-danger'><input type='hidden' id='input_responsavel_".$ret['id']."' value='".$ret['id']."' >".$ret['nome']."</span>
				<script>NProgress.start();</script>
				";
			}			
		break;
		
		case "lerEmail":
			global $dados;			
			$dados = $_POST;
			include("../../views/mail-viewer-NOC.php");			
		break;
		
		case "processaProvedores":
			$a = new Model;
			$dados = $_POST;
			$tabela = $dados["tbl"];
			unset($dados["retorno"], $dados["flag"], $dados["tbl"], $dados["caminho"] );
			global $newArray; 
			global $dados_provedores; 
			
			foreach($dados as $key=>$value){
				if(is_array($value)){					
					foreach($value as $foo=>$valor){
						$arr = json_decode($valor);
						foreach($arr as $indice=>$item){
							$dados_provedores[$indice] = $item;
						} 	
						$a->add($tabela, $dados_provedores);	
						if(isset($_SESSION["ult_id"])){
							$a->upd($tabela, $newArray, $_SESSION["ult_id"]);
						}else{
							echo "SESSION não iniciada";
						}
					}
				}else{
					$newArray[$key] = $value;
				}	
			}		
			
		break;
	}
  }	
else{
	echo "<h1>O post está vazio. <br> Procure por erros de configuração no servidor.</h1>";
}
?>