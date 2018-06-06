<?php
#Sistema de validação de login by Adan 24/06/2015.
include("../model.inc.php");
include("../parametros.inc.php");
if(!empty($_POST)){
	switch($_POST['flag']){
		case "login":			
			unset($_POST["flag"],$_POST["caminho"]);
			$acesso = new Model();
			$resultado = $acesso->login($_POST["usuario"],md5($_POST["senha"]));
			echo $resultado;
		break;
		case "logout":
			session_destroy();
			header("Location: ../../pages-login.php");
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
				echo "<h1>E-mail inválido.</h1>";
			}
		break;
		case "instrucoes":
			$a = new Model();			
			$parametros = new Param();
			$dados = $_POST;
			
		break;
	}
}else{
	echo '<h1>Código 0A. Erro no envio dos dados. <br>Recorra ao suporte!</h1>';
}
?>