<?php
include("../model.inc.php");
if(!empty($_POST)){
	$a = new Model;
	$dados = $_POST;
	switch($dados['flag']){
		case "pesquisa";
			if(!empty($dados)){
				$string = "SELECT pav.*, servicos.id as 'servid', servicos.media as 'servimg', servicos.nome as 'nome', servicos.habilitado as 'habilitado' FROM pav INNER JOIN servicos ON servicos.id = pav.id_presente WHERE pav.lixo = 0";
				$info = $a->queryFree($string);	
				$row = $info->fetch_assoc();
				print_r("
				<table class='listagem'>
				<tr>
					<th>ID</th>
					<th>Presente</th> 
					<th>Validação</th>
					<th>Amostra</th> 
				</tr>
				<tr>
					<td>".$row['id']."</td>
					<td>".$row['nome']."</td>
					<td>".($row['validado'] == 0 ? 'Não' : 'Sim')."</td>
					<td><img class='mini' src='media/imagens/galeria/pav/".(!is_null($row['media']) ? $row['media'] : 'nomedia.jpg')."' /></td>
				</tr>		
				</table>		
				
				");
			}
		break;
		case "habilitar":
			if(!empty($dados)){
				unset($dados['flag']);
				$result = $a->queryFree("SELECT * FROM pav_movimentos WHERE habilitado = '1'");
				if($result!=false){					
					$string['habilitado'] = '0';
					$a->upd("pav_movimentos", $string);
					$string['habilitado'] = '1';
					$retorno = $a->upd("pav_movimentos", $string, $dados['id']);
					echo "
					<div msg_dialog class='confirm' title='Clique para fechar.'>
						PAV habilitado com sucesso.
					</div>";
				}else{
					$a->add("pav_movimentos", $dados);
				}
			}
		break;
		case "desabilitar":
			if(!empty($dados)){
				unset($dados['flag']);
				$string['habilitado'] = '0';
				$a->upd("pav_movimentos", $string, $dados['id']);
				echo "
				<div msg_dialog class='confirm' title='Clique para fechar.'>
					PAV desabilitado com sucesso.
				</div>";
			}
		break;
		case "inscrever":
			unset($dados['flag']);
			$a = new Model();
			$result = $a->queryFree("SELECT * FROM pav_inscritos WHERE lixo = 0 AND email = '".$dados['email']."'");
			if($result!=false){
				#já existe um e-mail igual cadastrado 
				echo ("
				<div msg_dialog class='alerta' title='Clique para fechar.'>
					Este e-mail já foi cadastrado.
				</div>");	
			}else{
				#nada foi encontrado no banco, agora é preciso verificar se esse PAV necessita validação ou não	
				if($dados['validado'] == "1"){
					#Necessita ser validado -> enviar e-mail
					echo("
					<div msg_dialog class='confirm' title='Clique para fechar.'>
						Este e-mail necessita ser verificado.<br>Cheque o seu email!
					</div>");
				}else{
					#Cadastre o e-mail já válido					
					$a->add("pav_inscritos", $dados);
				}				
			}
		break;	
		case "exportar":
			$nome_arquivo = time().rand (5, 15).".csv";
			$a = new Model();
			if(isset($dados['id'])){
				$valor = $dados['id'];
				$sql_query_valores = "";
				$i = sizeof($valor) - 1;
				foreach($valor as $key => $id){
					$sql_query_valores .= " id = '".$id."' ";
					if($key < $i){
						$sql_query_valores .= "OR";
					}
				}
				$query = "SELECT email FROM pav_inscritos WHERE $sql_query_valores";
				$result = $a->queryFree($query);			
				if($result!=false){
					for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row);
					$a->arrayToCsv($set, $nome_arquivo);
					echo("
					<div msg_dialog class='confirm' title='Clique para baixar.'>
						Tudo certo!<br>Arquivo de exportação salvo com <br>sucesso.
					</div>
					<h3>Arquivo liberado para download</h3>
					<a href='media/export/".$nome_arquivo."' download>Baixar Arquivo</a>					
					");
				}else{
					echo("
					<div msg_dialog class='alerta' title='Clique para fechar.'>
						O processo de pesquisa falhou e <br>o arquivo não pode ser baixado.<br>Por favor, entre em contato com o suporte.
					</div>");
				}
			}else{
				echo("
				<div msg_dialog class='erro' title='Clique para fechar.'>
					Você não selecionou nenhum item.<br>Para exportar os registros<br> faça alguma seleção.
				</div>");
			}
		break;
	}
}else{	  
	echo("
		<div msg_dialog class='alerta' title='Clique para fechar.'>
			Isso não deveria ter acontecido.<br>Uma situação inesperada ocorreu.<br>Por favor, entre em contato com o suporte.
		</div>");
}
?>