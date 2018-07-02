<?php
include("../model.inc.php");
$meusDados = $_POST;
switch($meusDados['flag']){
	case "carrinho":
		$dadosPessoais = $_SESSION['datalogin'];
		$a = new Model();
		unset($meusDados['flag']);
		$meusDados['data_pedido'] = date('Y-m-d');
		$a->addGallery("pedidos", $meusDados);
		if ($mysqli->affected_rows > 0) { 
			$query = "SELECT count(id) AS 'qdt' FROM pedidos WHERE lixo = 0 AND data_compra IS NULL AND id_user = '".$meusDados['id_user']."'";
			$resultado = $a->queryFree($query);			
			$qtde = $resultado->fetch_assoc();
			print_r($qtde['qdt']);
		}else{
			echo "Faiô! Erro: ". $mysqli->affected_rows;	
		}
	break;
	case "requisicaoPagamento":		
		$email = 'tatitmam@gmail.com';#'tatitmam@gmail.com'; #'c45947262100201683004@sandbox.pagseguro.com.br'; 
		$dadosPessoais = $_SESSION['datalogin'];
		$pedido = $_POST;
		unset($pedido['flag']);
		
		$pag = new Model();
		$requisitosPagSeguro = "&";
		$requisitosPagSeguro .= http_build_query($pedido);
		$requisitosPagSeguro .= $pag->setSender($dadosPessoais);
		print_r($requisitosPagSeguro);echo "<br>";
		try {  
			$retornoDados = $pag->requisitaPagSeguro($requisitosPagSeguro, $email); 
			echo $retornoDados;
			return $retornoDados;
		}catch (PagSeguroServiceException $e){  
			die($e->getMessage());  
		}  
	break;
	case "requisicaoPagSeguro":
		require_once '../plugins/PagSeguroLibrary/PagSeguroLibrary.php';
		$paymentrequest = new PagSeguroPaymentRequest();
		 
		$data = Array(
		 'id' => '01', // identificador
		 'description' => 'Mouse', // descrição
		 'quantity' => 1, // quantidade
		 'amount' => 2.00, // valor unitário
		 'weight' => 10 // peso em gramas
		);
		$item = new PagSeguroItem($data);
		/* $paymentRequest deve ser um objeto do tipo PagSeguroPaymentRequest */
		 
		$paymentrequest->addItem($item);
		//Definindo moeda
		$paymentrequest->setCurrency('BRL');
		
		$paymentrequest->setShipping(3);
		//Url de redirecionamento
		//$paymentrequest->setRedirectURL($redirectURL);// Url de retorno
		 
		$credentials = PagSeguroConfig::getAccountCredentials();//credenciais do vendedor
		 
		//$compra_id = App_Lib_Compras::insert($produto);
		//$paymentrequest->setReference($compra_id);//Referencia;
		 
		$url = $paymentrequest->register($credentials);
		 
		header("Location: $url");

	break;
}