<?php
# Configuração principal -> 60096756691
$botoes = new Acoes();
if(isset($array['nome_razaosocial'])){
	$nome_cliente	= $array['nome_razaosocial'];
}
if(isset($array['cpf_cnpj'])){
	$cpf_cnpj		= $array['cpf_cnpj'];
}
$provedor 	 	= $arr_cliente['nome'];
$flag	 		= "selecionar";
$link			= "controllers/sys/crud.sys.php";
$retorno		= ".content";
if(isset($array['servicos'])){
	if(sizeof($array['servicos']) > 1){
		$_SESSION['servicos_hub'] = $array['servicos']; # Será necessário para dividir os serviços comuns do cliente daqueles contratados juntos a HubSoft. Essa SESSION será chamada mais tarde no layout do provedor.
		echo '
		<div class="page-header-title">
		  <h4 class="page-title">Atendimento</h4>
		  <p>Movimentação dos chamados para atendimento</p>
		</div>
		<div class="content-sized">
		<div class="form-group">
			<div class="panel panel-color panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title">Serviços Contratados</h3>
				</div>
				<div class="panel-body">';
		for($i = 0; $i < sizeof($array['servicos']); $i++){
			echo
			"
			<div class='grade' style='float: left; padding: 1%;'>
				<form id='form_".$i."'>
					<h4>".$array['servicos'][$i]['nome']."</h4><br>
				";
			foreach($array['servicos'][$i] as $key=>$value){
				if(!is_array($value)){
					echo "
					<b>$key</b>: $value<br>
					<input type='hidden' name='$key' value='$value'>
					";
				}else{
					foreach($value as $indice=>$valor){
						echo "<input type='hidden' name='$indice' value='$valor'>";
					}
				}
			}
			echo
			"
					".$botoes->selecionar("form_$i", $cpf_cnpj, $link, $flag)."	
					<input type='hidden' name='idd' value='$i'>					
				</form>
			</div>
			";
		}
		echo "
				</div>
			</div>
		</div>
		";
	}else{				
		include("atendimento-hubsoft.php");
	}
}else{
	include("atendimento-hubsoft.php");
}
?>	