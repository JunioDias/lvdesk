<?php
#Sistema de validação de login by Adan 24/06/2015.
include("../model.inc.php");
include("../parametros.inc.php");
if(!empty($_POST)){
	switch($_POST['flag']){
		case "login":
			unset($_POST["flag"], $_POST["caminho"]);
			$dados = $_POST;
			$a = new Model();
			/*Teste para identificar o ambiente de clientes para contratos vigentes*/
			$query = "
			SELECT cont.id AS id, usuario FROM contratos AS cont
			INNER JOIN clientes AS cli ON cont.id_cliente = cli.id 
			WHERE cont.email = '".$dados["usuario"]."' AND cont.lixo = 0";
			$retorna_query = $a->queryFree($query);
			$teste = $retorna_query->fetch_assoc();
			if(empty($teste['id'])){ #caso nada seja encontrado procede o login normalmente
				$resultado = $a->login($dados["usuario"], md5($dados["senha"]));
				return $resultado; 
			}else{
				$resultado = $a->loginCliente($teste["usuario"], md5($dados["senha"]));
				return $resultado;
			}	 	
			#echo $resultado; 
		break;
		case "logout":
			session_destroy();
			header("Location: ../../pages-login.php");
			exit();
		break;
		case "recupera":
			$dados = $_POST;
			$a = new Model();
			$parametros = new Param();
			$dados_email = $parametros->emailConfig();
			$query = "SELECT * FROM usuarios WHERE lixo = 0 AND usuario = '".$dados['usuario']."'";
			$a->queryFree($query);
			/*echo $query."<br>";
			print_r($result);*/
			if($result->num_rows == '1'){
				$resultado = $result->fetch_assoc();

				$url = sprintf('id=%s&email=%s&uid=%s&key=%s', $resultado['id'], md5($resultado['usuario']), md5($resultado['uid']), md5($resultado['data_ts']));
				$mensagem = 'Para confirmar a recuperação de sua senha clique no link:<br>';
				$mensagem .= sprintf("http://".$dados_email['dominio']."/lvdesk/controllers/access.php?%s",$url);

				// enviar o email
				$a->envia($resultado, 'Recuperador de senhas - '.$parametros->title(), $mensagem);

			}else{
				// echo '
				// <div class="alert alert-danger fade in">
				// <h4>Falha no processo.</h4>
				// <p>E-mail não existe na base de dados<br>Clique no botão abaixo para fechar esta mensagem.</p>
				// <p class="m-t-10">
				//   <a type="button" class="btn btn-default waves-effect" data-dismiss="alert" href="javascript:history.go(-1);">Fechar</a>
				// </p>
				// </div>
				// ';
				$_SESSION['returnLogin'] = 'notEmail';
				header('Location: ../../pages-recoverpw.php');
				// echo '<script type="text/javascript"> window.history.go(-1); </script>';
			}
		break;
		case "instrucoes":
			$a = new Model();
			$parametros = new Param();
			$dados = $_POST;

		break;
	}
}else{
	echo '
	<div class="alert alert-danger fade in">
	<h4>Falha no processo.</h4>
	<p>Falha no envio das informações. Contacte o suporte.<br>Clique no botão abaixo para fechar esta mensagem.</p>
	<p class="m-t-10">
	  <button type="button" class="btn btn-default waves-effect" data-dismiss="alert" >Fechar</button>
	</p>
	</div>
	';
}
?>