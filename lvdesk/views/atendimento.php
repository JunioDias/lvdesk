<div class="page-header-title">
  <h4 class="page-title">Atendimento</h4>
  <p>Movimentação dos chamados para atendimento</p>
</div>
<div class="content-sized"> 
<?php
$a 		= new Model;
$log 	= new Logs;
if(!empty($_SESSION["datalogin"])){
	$datalogin 					= $_SESSION["datalogin"];
	$atendente_responsavel		= $datalogin['id'];
	if($datalogin['id_contrato'] != 0){ #zero representa nenhum contrato, isso é um erro
		$query_contrato = "SELECT * FROM contratos WHERE id = '".$datalogin['id_contrato']."' AND lixo = 0";
		$resultado = $a->queryFree($query_contrato);
		$permissao = $resultado->fetch_assoc();
		$query_cliente = "SELECT * FROM clientes WHERE id = '".$permissao['id_cliente']."' AND lixo = 0";
		$foo = $a->queryFree($query_cliente);
		$arr_cliente = $foo->fetch_assoc();
	}else{
		echo "Erro código #61 em  pav.sys.php. <br>Entre em contato com o surporte.";
		die();
	}
}
if($id_provedor){//Existe um provedor
		
	$query = "SELECT * FROM pav WHERE id = '".$id_provedor."' AND lixo = 0";
	$result = $a->queryFree($query);
	if($result){
		$matriz = $result->fetch_assoc();
	}
	switch($id_provedor){
	case "2":
		include("layouts/atendimento-hubsoft.php");
	break;	
	}
}else{
	echo "O provedor cadastrado retornou um erro de registro.<br>
		Verifique se o ID cadastrado no banco de dados sofreu modificação <br>
		ou se houve inconsistência na lógica de processamento do módulo PAV.<br>";
}