<?php
session_start();
include("conexao.inc.php");
class Model{

	public function delDir($dir){
		$dir_content = scandir($dir);
		if($dir_content !== FALSE){
			foreach ($dir_content as $entry) {
				if(!in_array($entry, array('.','..'))){
					$entry = $dir . '/' . $entry;
					if(!is_dir($entry)){
		 				unlink($entry);
					}
					else{
						delDir($entry);
					}
				}
			}
		}
		rmdir($dir);
	}

	function login($user, $senha){
		#by Adan, 24 de junho de 2015. Atualizado em 19 de julho de 2018 para acesso a ambiente de cliente.
		global $mysqli;
		global $result;
		$query = "SELECT u.*, p.nome AS 'nomep' FROM usuarios AS u INNER JOIN privilegios AS p ON id_privilegio = p.id WHERE usuario = '$user' AND senha = '$senha' AND u.lixo = 0";
		$mysql_result = $mysqli->query($query);
		$result = $mysql_result->fetch_assoc();
		if($result){
			if($result['id_contrato']==0){
				$_SESSION["datalogin"] = $result;
				return header("Location: ../../index.php");
			}else{ //caso haja usuários cadastrados pelo cliente
				$_SESSION["datalogin"] = $result;
				return header("Location: ../../index-cliente.php"); 
			}
		}else{
			$_SESSION['returnLogin'] = 'denied';
			return header('Location: ../../pages-login.php');
		} 
	}	
	
	function loginCliente($user, $senha){
		#by Adan em 19 de julho de 2018 para acesso a ambiente de cliente.
		global $mysqli;
		global $result;
		$query = "SELECT c.*, p.nome AS 'nomep' FROM clientes AS c 
		INNER JOIN privilegios AS p ON id_privilegio = p.id 
		WHERE usuario = '$user' AND senha = '$senha' AND c.lixo = 0";
		$mysql_result = $mysqli->query($query);
		$result = $mysql_result->fetch_assoc();
		if(!empty($result['id'])){
			$result['ambiente_privilegio'] = 'on';
			$_SESSION["datalogin"] = $result;
			return header("Location: ../../index-cliente.php");			
		}else{
			$_SESSION['returnLogin'] = 'denied';
			return header('Location: ../../pages-login.php');
		} 
	}	

	public function queryFree($query){
		#by Adan, 04 de junho de 2015.
		global $mysqli;
		global $result;

		if(!isset($query)){
			echo("Segue abaixo o valor da query enviada:<br>".$query);
		}else{
			$result = $mysqli->query($query);
		}
		if(!is_null($result)){
			return $result;
		}
	}

	public function ajeitaFoto($img, $tbl){
		if($tbl == 'usuarios'){
			global $img;
		}
		if(!empty($img['name'])){#para o caso de nenhuma imagem seja carregada, mas outro item qualquer seja editado
			if($img['type']=="image/png" || $img['type']=="image/jpg" || $img['type']=="image/jpeg" ||  $img['type']=="image/gif"){
				if($img['size']<5242880){
					$extfile  = strtolower(substr($img['name'], strripos($img['name'], '.', -1)));
					if($extfile == ".jpg" || $extfile == ".png" || $extfile == ".gif" || $extfile == ".jpeg"){
						if($tbl == 'usuarios'){
							$path = "../../assets/images/users/";
						}
						$img['name'] = time().rand (5, 15).$extfile;
						move_uploaded_file($img['tmp_name'], $path.$img['name']);
						$media = $img;
						return $media;
					}else{
						echo '
						<div class="alert alert-danger">
							<h4>Tivemos um problema...</h4>
							Extensão inválida para fotos! <a href="." class="alert-link">Clique aqui</a> para atualizar os status do sistema.
						</div>';
						die();
					}
				}else{
					echo '
					<div class="alert alert-danger">
					<h4>Tivemos um problema...</h4>
					Tamanho do arquivo não pode<br> ser maior que 5 Mb! <a href="." class="alert-link">Clique aqui</a> para atualizar os status do sistema.
					</div>';
					die();
				}
			}else{# upload de arquivos tipo 'media'
				if($img['size']<15242880){
					$extfile  = strtolower(substr($img['name'], strripos($img['name'], '.', -1)));
					if($img['type']=="audio/mp3" || $img['type']=="audio/wav"){
						$path = "../media/audio/lista/";
						$img['name'] = time().mt_rand(1000, 9000).$extfile;
						move_uploaded_file($img['tmp_name'], $path.$img['name']);
						$media = $img;
						return $media;
					}else if($img['type']=="video/mpeg" || $img['type']=="video/x-mpeg" || $img['type']=="video/mp4"){
						$path = "../media/video/videoteca/";
						$img['name'] = time().mt_rand(1000, 9000).$extfile;
						move_uploaded_file($img['tmp_name'], $path.$img['name']);
						$media = $this->queryFree("INSERT INTO ".$tbl."(midia, tipo) VALUES('".$img['name']."', 'video')");
						return $media;
					}else{
						echo '						
							<div class="alert alert-danger">
							<h4>Tivemos um problema...</h4>
							Extensão inválida para áudio/vídeo.  <a href="." class="alert-link">Clique aqui</a> para atualizar os status do sistema.
							</div>	
						';
						die();
					}
				}else{
					echo '
					<div class="alert alert-danger">
					<h4>Tivemos um problema...</h4>
					Tamanho do arquivo não pode<br> ser maior que 15 Mb! <br>Edição não permitida.
					</div>';
					die();
				}#if($img['size']<5242880)
			}#if($img['type']=="image/png" || etc...
		}#if(!empty($img['name'])
	}

	public function addFoto($nomeFile, $vetor, $tbl){
		#by Adan, 12 de julho de 2015.
		if (isset($_FILES)){
			global $img;
			if(is_array($_FILES)){
				# é um array simples
				$img   = $_FILES[$vetor];
				$media = $this->ajeitaFoto($img, $tbl);
				return $media;
			}else{
				# é uma matriz	: Script por Felipe Goose - 23/09/2015
				$arr = $_FILES[$nomeFile];
				$goose = $imgArray = array();
				foreach($arr as $key => $dados){
					for($z=0; $z<count($dados); $z++){
						$goose[$z][$key] = $dados[$z];
					} 
				} 

				foreach($goose as $indice){
					$media = $this->ajeitaFoto($indice, $tbl);
					return $media;
				}
			}#if(testArray($_FILES))
		}else{
			echo '
			<div class="alert alert-danger">
			<h4>Tivemos um problema...</h4>
			Ambiente de upload não configurado!<br>Contate o suporte.
			</div>';
			die();
		}#if (isset($_FILES))
	}

	function add($tabela, $array){
		#by Adan, 05 de junho de 2015.
		global $mysqli;
		$count 	= 1;
		$coluna = NULL;
		$valor 	= NULL;
		foreach($array as $key=>$value){
			$coluna .= $key;
			$valor  .= "'".$value."'";
			if($count < sizeof($array)){
				$coluna .= ", ";
				$valor  .= ", ";
			}
			$count++;
		}
		#echo "INSERT INTO $tabela ($coluna) VALUES($valor)";
		$mysqli->query("INSERT INTO $tabela ($coluna) VALUES($valor)");
		if ($mysqli->affected_rows > 0) {
			$_SESSION['ult_id'] = $mysqli->insert_id;
			return true;
		}
		else{
			return false;
		}
	}
	function addUser($tabela, $array){
		#by Adan, 27 de novembro de 2015.
		global $mysqli;
		$count 	= 1;
		$coluna = NULL;
		$valor 	= NULL;
		foreach($array as $key=>$value){
			$coluna .= $key;
			$valor  .= "'".$value."'";
			if($count < sizeof($array)){
				$coluna .= ", ";
				$valor  .= ", ";
			}
			$count++;
		}
		#echo "INSERT INTO $tabela ($coluna) VALUES($valor)";
		$mysqli->query("INSERT INTO $tabela ($coluna) VALUES($valor)");
		$id = $mysqli->insert_id;
		if ($mysqli->affected_rows > 0) {
			$resultado = $this->queryFree("SELECT * FROM usuarios WHERE id = '".$id."'");
			return $resultado;
		}
	}
	public function processaCerquilhas($dados){
		#by Adan, 01 de agosto de 2018.
		$i 	= 1; 				
		$valor = NULL;
		$array = NULL;
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
		return $array;
	}

	#Montagem do filtro composto para rotina de Atendimento do PostgreSQL - Adan 25/06/2018
	public function selecionaQueryPostgreSQL($nome = NULL, $campo_nome = NULL, $cpf = NULL, $campo_cpf = NULL, $endereco = NULL, $campo_endereco = NULL, $tabela = NULL){
		$query = "SELECT * FROM ".$tabela." ";
		if($nome){
			$query .= "WHERE ".$campo_nome." ILIKE '%".$nome."%'";
		}
		if($nome && $cpf){
			$query .= " AND ".$campo_cpf." = '".$cpf."'";
		}else if($cpf){
			$query .= " WHERE ".$campo_cpf." = '".$cpf."'";
		}
		if($nome && $cpf && $endereco || $nome && $endereco || $cpf && $endereco){
			$query .= " AND ".$campo_endereco." ILIKE '%".$endereco."%'";
		}else if($endereco){
			$query .= " WHERE ".$campo_endereco." ILIKE '%".$endereco."%'";
		}
		return $query;
	}

	#Montagem do filtro composto para rotina de Atendimento e CGR do MySQL - Adan 25/06/2018
	public function selecionaQueryMySQL($itemA = NULL, $itemA_campo = NULL, $itemB = NULL, $itemB_campo = NULL, $itemC = NULL, $itemC_campo = NULL, $tabela = NULL){
		$query = "SELECT * FROM ".$tabela." ";
		if($itemA){
			$query .= "WHERE ".$itemA_campo." LIKE '%".$itemA."%'";
		}
		if($itemA && $itemB){
			$query .= " AND ".$itemB_campo." = '".$itemB."'";
		}else if($itemB){
			$query .= " WHERE ".$itemB_campo." = '".$itemB."'";
		}
		if($itemA && $itemB && $itemC || $itemA && $itemC || $itemB && $itemC){
			$query .= " AND ".$itemC_campo." LIKE '%".$itemC."%'";
		}else if($itemC){
			$query .= " WHERE ".$itemC_campo." LIKE '%".$itemC."%'";
		}
		return $query;
	}
	
	public function termosPesquisa($itemA = NULL, $itemA_campo = NULL, $itemB = NULL, $itemB_campo = NULL){
		$query = "busca=";
		if($itemA){
			$query .= $itemA_campo."&termo_busca=".$itemA;
		}
		if($itemA && $itemB){
			$query .= "&".$itemB_campo."&termo_busca=".$itemB;
		}else if($itemB){
			$query .= $itemB_campo."&termo_busca=".$itemB;
		}
		return $query;		
	}

	function upd($tabela, $array, $id = NULL){
		global $mysqli;
		$count 	= 1;
		$coluna  = NULL;
		$valor 	 = NULL;
		$setting = NULL;
		foreach($array as $key=>$value){
			$coluna = $key;
			$valor  = " = '".$value."'";
			if($count < sizeof($array)){
				$valor  .= ", ";
			}
			$setting .= $coluna . $valor;
			$count++;
		}
		if(is_null($id)){
			#echo "UPDATE $tabela SET $setting<br>";
			$mysqli->query("UPDATE $tabela SET $setting");
			return $mysqli;
		}else{
			#echo "UPDATE $tabela SET $setting WHERE id = '$id'";
			$mysqli->query("UPDATE $tabela SET $setting WHERE id = '$id'");
			return $mysqli;
		}
	}

	public function exc($tabela, $id){
		global $mysqli;
		#echo "UPDATE $tabela SET lixo = '1' WHERE id = '$id'";
		$mysqli->query("UPDATE $tabela SET lixo = '1' WHERE id = '$id'");
		return true;
	}

	public function edt($tabela, $id){
		global $mysqli;
		$mysqli->query("UPDATE $tabela SET lixo = '1' WHERE id = '$id'");
		return true;
	}

	public function criaAlbum($id){
		#by Adan, 22 de setembro de 2015.
		global $mysqli;
		$mysqli->query("SELECT id FROM albuns WHERE id_contato = '$id' AND lixo = 0");
		if($mysqli->affected_rows == 0){
			$data = date('Y-m-d');
			$mysqli->query("INSERT INTO albuns (data, caminho, id_contato) VALUES($data, $id, $id)");
		}
	}

	# Funções para gerenciamento de privilégios e acessos no sistema - by Adan 07/06/2018
	public function libPriv($id){
	  $query = "SELECT acessos, acessos_menus FROM privilegios WHERE lixo = 0 AND id = $id ";
	  $foo = $this->queryFree($query);
	  $val = $foo->fetch_assoc();
	  $modulos = explode("#", $val['acessos']);
	  $menus = explode("#", $val['acessos_menus']);
	  $this->libMenuAdmin($modulos, $menus);
	}

	public function libMenuAdmin($arrayAcessos, $idSubMenu){
		foreach($arrayAcessos as $value){
			$woo = $this->queryFree("SELECT * FROM modulos WHERE lixo = 0 AND id = $value");
			$row = $woo->fetch_assoc();
		  
			if($row['id']!= 0){
				echo "
				  <li class='has_sub'>
				  <a title='".$row["descricao"]."' class='waves-effect' href_link link='views/".$row["value"]."'>
				  <i class='".$row["media"]."'></i><span>".$row["nome"]."</span>
				  <span class='pull-right'><i class='mdi mdi-plus'></i></span>
				  </a>
				  <ul class='list-unstyled'>
				";
					
				foreach($idSubMenu as $value){					
					$woo = $this->queryFree("SELECT * FROM menus WHERE lixo = 0 AND id = $value AND id_pai = '".$row['id']."'");
					$subMenu = $woo->fetch_assoc();	
					if($subMenu['id']){
						echo "<li><a class='regular-link' link='".$subMenu['valor']."' lv>";
						if($subMenu['nome'] == 'Serviços'){
							$this->notification();
						}else if($subMenu['nome'] == 'Leitura de e-mails'){
							$this->notification('1');
						}
						echo $subMenu['nome']."</a></li>";
					}
				}				
				echo "
				  </ul>
				  </li>
				";
			}
		}
	}

	public function habilitaModulos($query){
	  $foo = $this->queryFree($query);
	  $val = $foo->fetch_assoc();
	  $retorno = explode("#", $val['acessos']);

	  foreach($retorno as $value){
		$woo = $this->queryFree("SELECT * FROM modulos WHERE lixo = 0 AND id = $value");
		$row = $woo->fetch_assoc();
	    print_r(
		  '<div class="checkbox checkbox-primary">
			<input id="checkbox1" type="checkbox" data-parsley-multiple="group1">
			<label for="checkbox1">'.$row["nome"].'</label>
		  </div>
	    ');
	  }
	}

	public function notification($flag = NULL, $panel = NULL){
		if(is_null($flag)){
			$query = "SELECT COUNT(id) as qnt_id FROM pav_inscritos WHERE validado = 0 AND lixo = 0";
			$foo = $this->queryFree($query);
			$val = $foo->fetch_assoc();
			if($val['qnt_id'] > 0){
				if(is_null($panel)){
					echo '<span style="vertical-align: top;" id="notificador" class="badge badge-primary pull-right">'.$val['qnt_id'].'</span>';
					return true;
				}else{
					#echo $val['qnt_id'];
					return true;
				}
			}else{
				return false;
			}
		}else{
			if (isset($_SESSION['mail_box'])) {
				$total_de_mensagens = imap_num_msg($_SESSION['mail_box']);
				if($total_de_mensagens > 0){
					echo '<span style="vertical-align: top;" id="notificador" class="badge badge-primary pull-right">'.$total_de_mensagens.'</span>';
					return true;
				}else{
					return false;
				}
			}
		}
	}

	public function envia($array, $assunto = NULL, $mensagem = NULL){
		// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
		require("plugins/PHPMailer-master/PHPMailerAutoload.php");
		require_once("parametros.inc.php");
		$parametros_server = new Param();
		$email_settings = $parametros_server->emailConfig();
		$dados = $array;
		$enviaFormularioParaNome = $dados['nome'];
		$enviaFormularioParaEmail = $dados['usuario'];
		$remetenteNome  = $email_settings['remetenteNome'];
		$remetenteEmail = $email_settings['username'];
		if(!isset($assunto)){
			$assunto  = "Recuperador de Senhas";
		}
		if(!isset($mensagem)){
			$mensagem = 'mensagem';
		}
		$mensagemConcatenada = 'Formulário gerado via website'.'<br/>';
		$mensagemConcatenada .= '-------------------------------<br/><br/>';
		$mensagemConcatenada .= 'Nome: '.$remetenteNome.'<br/>';
		$mensagemConcatenada .= 'E-mail: '.$remetenteEmail.'<br/>';
		$mensagemConcatenada .= 'Assunto: '.$assunto.'<br/>';
		$mensagemConcatenada .= '-------------------------------<br/><br/>';
		$mensagemConcatenada .= $mensagem.'"<br/>';
		// Inicia a classe PHPMailer
		$mail = new PHPMailer();

		// Define os dados do servidor e tipo de conexão
		#$mail->SMTPDebug = 2; // Debug para erros de conexão com PHPMailler
		$mail->IsSMTP(); // Define que a mensagem será SMTP
		$mail->Host = $email_settings['serverhost'];
		$mail->SMTPAuth = $email_settings['varSMTPAuth']; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
		$mail->Username = $email_settings['username']; // Usuário do servidor SMTP (endereço de email)
		$mail->Password = $email_settings['password']; // Senha do servidor SMTP (senha do email usado)

		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->From = $remetenteEmail; // Seu e-mail
		$mail->Sender = $remetenteEmail; // Seu e-mail
		$mail->FromName = $remetenteNome; // Seu nome

		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->AddAddress($enviaFormularioParaEmail,utf8_decode($enviaFormularioParaNome));
		//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
		//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

		// Define os dados técnicos da Mensagem
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->CharSet = $email_settings['charSet']; // Charset da mensagem (opcional)
		$mail->Post = $email_settings['port'];
		$mail->SMTPAutoTLS = false;
		// Define a mensagem (Texto e Assunto)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->Subject  = $assunto; // Assunto da mensagem
		$mail->Body = $mensagemConcatenada;

		// Define os anexos (opcional)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAttachment("/home/login/documento.pdf", "novo_nome.pdf");  // Insere um anexo

		// Envia o e-mail
		$enviado = $mail->Send();

		// Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		// Exibe uma mensagem de resultado
		if ($enviado) {
			echo '
				<div class="alert alert-success fade in">
				<h4>Operação executada com sucesso.</h4>
				<p>Verifique o seu e-mail.<br>Clique no botão abaixo para fechar esta mensagem.</p>
				<p class="m-t-10">
				  <a type="button" class="btn btn-default waves-effect" data-dismiss="alert" href="javascript:history.go(-2);">Fechar</a>
				</p>
				</div>
				';
			return true;
		} else {
			echo '
				<div class="alert alert-danger fade in">
				<h4>Falha no processo.</h4>
				<p>Não foi possível enviar o e-mail.<br>
				';echo (extension_loaded('openssl')?'SSL está funcionando.':'SSL não foi carregado...')."<br>";
				echo "Informações do erro: " . $mail->ErrorInfo;
				echo '<br><br>Clique no botão abaixo para fechar esta mensagem.</p>
				<p class="m-t-10">
				  <a type="button" class="btn btn-default waves-effect" data-dismiss="alert" href="javascript:history.go(-2);">Fechar</a>
				</p>
				</div>
				';
			return false;
		}
	}

	public function requisitaPagSeguro($parametros, $email){

		define("PAGSEGURO_TOKEN_PRODUCTION", "D9CCCD5E422641EA91F786FC6A536646");
		define("PAGSEGURO_APP_ID_PRODUCTION", "");
		define("PAGSEGURO_APP_KEY_PRODUCTION", "");
        define("PAGSEGURO_TOKEN_SANDBOX", "1BBC0C0AB15340B5AFAAFDDDAE2114F7");
		define("PAGSEGURO_APP_ID_SANDBOX", "app3685102155");
		define("PAGSEGURO_APP_KEY_SANDBOX", "471B95F68B8BBC388460FFA16E6B9866");
		define("MOEDA", "BRL");

		$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout -d\\ email=".$email."&token=".PAGSEGURO_TOKEN_SANDBOX."&currency=".MOEDA;
		$url .= $parametros;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		#curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); //O PagSeguro só irá aceitar a versão 1.1 do HTTP
		#curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
		$dados = curl_exec($ch);
		curl_close($ch);
		if($dados == 'Unauthorized'){
			header('Location: ../view/pagFinaliza.php?tipo=autenticacao');
			#echo htmlentities($url, null, "UTF-8")."<br><br>";
			exit;
		}else if(count($dados -> error) > 0){

			header('Location: ../view/pagFinaliza.php?tipo=invalido&erro='.count($dados->error));
			exit;
		}else{
			$dados = simplexml_load_string($dados);
			header('Location: https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $dados->code);
		}
	}

	public function setSender($dadosPessoais){
		$arrayRequisito[] = NULL;
		$arrayRequisito['senderName'] = $dadosPessoais['nome'];
		$arrayRequisito['senderAreaCode'] = $dadosPessoais['codareatelefone'];
		$arrayRequisito['senderPhone'] = $dadosPessoais['telefones'];
		$arrayRequisito['senderEmail'] = $dadosPessoais['usuario'];
		$arrayRequisito['shippingType'] = '1';
		$arrayRequisito['shippingAddressStreet'] = $dadosPessoais['endereco'];
		$arrayRequisito['shippingAddressNumber'] =   $dadosPessoais['numero'];
		$arrayRequisito['shippingAddressComplement'] =   $dadosPessoais['complemento'];
		$arrayRequisito['shippingAddressDistrict'] =   $dadosPessoais['bairro'];
		$arrayRequisito['shippingAddressCity'] =   $dadosPessoais['cidade'];
		$arrayRequisito['shippingAddressState'] =   $dadosPessoais['uf'];
		$arrayRequisito['shippingAddressPostalCode'] = $dadosPessoais['cep'];
		$arrayRequisito['shippingAddressCountry']= 'BRA';
		$arrayRequisito['redirectURL']= 'http://www.paisespeciais.com.br/view/pagFinaliza.php';
		$sender = "&";
		$sender .= http_build_query($arrayRequisito);
		return $sender;
	}

	public function arrayToCsv($input_array, $output_file_name){
		$f = fopen('../media/export/'.$output_file_name, 'w');
		foreach ($input_array as $line) {
			fputcsv($f, $line, ",", '"', " ");
		}
		fseek($f, 0);
		header('Content-Type: application/csv');
		header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
		fpassthru($f);
	}

	public function protocolo($numero = NULL){
		if(is_null($numero)){
			$alfa = date('Ymdhis');
		}else{
			$alfa = $numero;
		}
		return $alfa;
	}
	
	public function moneyFormatReal($valor){
		$numero = "R$ ";
		$numero .= number_format($valor, 2 , ',' , '.' );	
		return $numero;
	}
	
	public function gravaAtendimento($dados){
		$query_entrada = "SELECT qntd_atendimentos FROM planos_movimentos WHERE id_contratos = '".$dados['id_contratos']."' AND data_limite >= now() AND lixo = 0";
		$woo = $this->queryFree($query_entrada);
		$entrada = $woo->fetch_assoc();
		if(empty($entrada['qntd_atendimentos'])){
			echo ("
			<script type='text/javascript'>
			$(document).ready(function () {
				$('#alerta_cliente_contrato').modal('toggle');	
			});
			</script>
			");
		}else{//aqui será necessário incrementar o contador de atendimentos do cliente
			$query_movimentos = "SELECT * FROM planos_movimentos WHERE id_contratos = '".$dados['id_contratos']."' AND data_limite >= now() AND lixo = 0 ORDER BY qntd_atendimentos LIMIT 1"; 
			$woo = $this->queryFree($query_movimentos);
			$atend = $woo->fetch_assoc();
			$atual 	= intval($atend['atendimentos_atuais']); 
			$limite = intval($atend['qntd_atendimentos']);
			$valor 	= floatval($atend['vlr_nominal']);
			if($atual < $limite){
				$soma['atendimentos_atuais'] = $atual + 1;
				$this->upd("planos_movimentos", $soma, $atend['id']);
			}else{
				$query_movimentos = "SELECT * FROM planos_movimentos WHERE qntd_atendimentos > '".$atend['qntd_atendimentos']."' AND id_contratos = '".$dados['id_contratos']."' AND data_limite >= now() AND lixo = 0 ORDER BY qntd_atendimentos LIMIT 1"; 
				$woo = $this->queryFree($query_movimentos);
				$exced = $woo->fetch_assoc();
				if(empty($exced['id'])){
					$soma['atendimentos_atuais'] = $atual + 1;
					$a->upd("planos_movimentos", $soma, $atend['id']);
				}else{
					$atual 	= intval($exced['atendimentos_atuais']); 
					$limite = intval($exced['qntd_atendimentos']);
					$valor 	= floatval($exced['vlr_nominal']);
					if($atual < $limite){						
						$soma['atendimentos_atuais'] = $atual + 1;
						$this->upd("planos_movimentos", $soma, $exced['id']);
					}
				}					
			}
		}		
	}
}