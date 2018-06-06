<?php
class Correios{ 

	public function calc($freteArray, $valorNominalProduto){
		$totalParcial = $valor = $freteArray['Valor'];
		$prazoEntrega = $freteArray['PrazoEntrega'];
		$l = $valorNominalProduto + $totalParcial;
		$total = number_format($l, 2, ',', '.');
		$retorno = "
		<fieldset id='retorno_frete'>
		<h3>&nbsp;<img src='media/imagens/sys/icons/currency_usd.png' />&nbsp;<b class='titulo_frete'>Frete e Prazo</b></h3>
		<table class='listagem_calculo_frete'>
			<tr>
			  <th>Valor do Frete</th>
			  <th>Prazo de Entrega</th>
			  <th>Total</th>
			</tr>
			<tr>
			  <td>R$&nbsp;$valor</td>
			  <td>$prazoEntrega&nbsp;dia(s)</td>
			  <td>R$&nbsp;$total</td>
			</tr>			
			</table>
			<br>
			<input type='button' value='Fechar' id='botFechar' />
		</fieldset>	
		";
		return $retorno;
	}
	
	public function retornaXML($array){
		$busca = new Model();
		$parametros = $array;
		#Consulta direta no banco 
		$sentencaSQL = "SELECT * FROM produtos WHERE lixo = 0 AND id = '".$parametros['id_produto']."'";
		$result = $busca->queryFree($sentencaSQL);		
		$produtosParametros = $result->fetch_assoc();
		#Construção dos parâmetros de entrada
		$parametros['sCepOrigem'] = "30100089";
		$parametros['StrRetorno'] = 'xml';
		$parametros['nCdEmpresa'] = '';
		$parametros['sDsSenha'] = '';	
		$parametros['nCdFormato'] = 1;
		$parametros['nVlPeso'] = $produtosParametros['peso'];
		$parametros['nVlComprimento'] = $produtosParametros['comprimento'];
		$parametros['nVlAltura'] = $produtosParametros['altura'];
		$parametros['nVlLargura'] = $produtosParametros['largura'];
		$parametros['nVlDiametro'] = $produtosParametros['diametro'];
		$parametros['sCdMaoPropria'] = 'S';
		$parametros['sCdAvisoRecebimento'] = 'N';
		#Construção da frase de post	
		$param = http_build_query($parametros);
		$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?'.$param;
		$ch = curl_init();
		#echo $url.'?'.$param."<br>";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');	
		$dados = curl_exec($ch);	
		curl_close($ch);
		return $dados;
	}
}	
?>