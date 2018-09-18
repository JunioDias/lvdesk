<?php
/*Classes de uso para frontend. Criação de controles para rotinas comuns ao UX.
* Autor: Adan Ribeiro
* Template: LV Desk
* Data: 06/06/2018
*
*/
class Acoes{
/*
* SUMÁRIO
* $id 				= Código do registro.
* $tabela 			= Nome da tabela.
* $callbackdelete 	= Página que vai retornar após a exclusão do registro.
* $callbackedit 	= Página que vai retornar após a edição do registro. Esse link coincide com outras ações de POST.
* $link 			= Destino do POST.
*/
  public function crudButtons($id, $callbackdelete, $callbackedit, $link){
	echo "	
	<a class='btn btn-warning rtrn-conteudo-listagem' item=".$id." flag='edt' data-objeto='form_action' caminho=".$callbackedit." title='Editar registro'>Editar</a>
	<a class='btn btn-danger rtrn-conteudo-listagem botao' item=".$id." flag='exc' data-objeto='form_action' caminho=".$link." title='Excluir registro' data-toggle='modal' data-target='#confirma'>Excluir</a>	
	";
  }

  public function darEntrada($id, $cpf, $link, $flag){
	echo '
	<input data-objeto="form_action" class="btn btn-success btn_driver rtrn-conteudo-listagem" value="Dar entrada" type="button" flag="'.$flag.'" caminho="'.$link.'" item="'.$cpf.'" idd="'.$id.'">	
	';
  }
  
  public function visualizar($id){
	echo '
	<input data-objeto="form_view" class="btn btn-success btn_driver rtrn-conteudo-listagem" value="Visualizar" type="button" idd="'.$id.'">	
	';
  }

  public function chbxModulo($modulos = NULL, $acessos = NULL){
	$retorno = NULL;
	if($modulos){
		if(isset($acessos)){
		  $i = 0;			 
		  while($row = $modulos->fetch_assoc()){
			$retorno .= ("
			  <div class='checkbox checkbox-primary'>
				<input id='checkbox".$row['id']."' type='checkbox' data-parsley-multiple='group1' name='acessos[]' value='".$row['id']."' ".($row['id'] == $acessos[$i] ? 'checked' : '').">
				<label for='checkbox".$row['id']."'>".$row['nome']."</label>
			  </div>
			");
			$i++;
		  }
		}else{ 		
		  while($row = $modulos->fetch_assoc()){
			$retorno .= ("
			  <div class='checkbox checkbox-primary'>
				<input id='checkbox".$row['id']."' type='checkbox' data-parsley-multiple='group1' name='acessos[]' value='".$row['id']."' >
				<label for='checkbox".$row['id']."'>".$row['nome']."</label>
			  </div>
			");
		  }
		}
	}else{
		$retorno .= "<p>Os Módulos não estão habilitados.</p>";
	}	
	return $retorno;	
  } 
  
  public function conteudoTabelaCGR($array, $link, $flag, $pave = NULL){
	echo "
	<tr>
	<td>".date('d/m/Y', strtotime($array['data_abertura']))."</td>
	<td>$array[protocol]</td>
	<td>$array[nome_cliente]</td>
	<td>$array[nome_provedor]</td>
	<td>$array[origem]</td>
	<td>$array[telefone_cliente]</td>
	<td>
	";  
	if(is_null($pave)){
		$this->darEntrada($array['id'], $array['cpf_cnpj_cliente'], $link, $flag); 
	}else{
		$this->visualizar($array['id']); 
	}
	echo "</td></tr>";
  }
  
  public function atribuiGrupo($id_grupo){
	switch($id_grupo){
		case "1":
		//comunicação interna
			$foo = "<div class='form-group'>
			  <label>Selecione os contatos</label>
			 ";
			$query = "SELECT * FROM `usuarios` WHERE id_contrato = 0 AND lixo = 0 ORDER BY nome ASC";
			$a = new Model;
			$resultado = $a->queryFree($query);
			if(isset($resultado)){
				while($linhas = $resultado->fetch_assoc()){					
					$foo .=  "
					  <div class='checkbox checkbox-success'>
					  <input type='checkbox' name='id_contatos[]' id='contato".$linhas['id']."' value='".$linhas['id']."'/><label for='contato".$linhas['id']."'> ".$linhas['nome']."</label></div>
					  ";
				}
			}
			$foo .= "
			</div>
			";
			echo $foo;
		break;
		case "2":
		//auditoria
		echo "<h4>Em desenvolvimento</h4>";
		break;
		case "3":
		//despachar a cliente
		echo "<h4>Em desenvolvimento</h4>";
		break;
	}
  }
  
  public function notifyComm($bind){
	
	while($array = $bind->fetch_assoc()){
		echo "
		<form id='form_link_".$array['id']."'>
		<a class='list-group-item regular-link-msg' data-item=".$array['id']."  title='Ver mensagem' data-objeto='form_link_".$array['id']."'>	
		  <div class='media'>
			 <div class='media-heading'>".$array['nome_autor']."</div>
			 <p class='m-0'>
			   <small>".$array['descricao']."</small>
			 </p>
		  </div>
		</a>
		<input id='input_flag_".$array['id']."' type='hidden' name='retorno' value='.content-sized'>
		<input id='input_id_".$array['id']."' type='hidden' name='id' value='".$array['id']."'>
		<input id='input_link_".$array['id']."' type='hidden' name='caminho' value='views/comunicacao-crud.php' >
		</form>
		";
	}
  }
  
  public function gradeEmail($array){
		
		#Montagem do layout			
		echo "
		<tr>			
			<td style='max-width:210px;'>
				<a class='regular-link-msg' data-objeto='action_email_$array[id]'  ".($array['unseen']==0 ? 'style=color:#009933;' : 'style=color:#999999;').">".iconv_mime_decode($array['fromaddress'])."</a>
			</td>
			<td style='max-width:400px;'>
				<a class='regular-link-msg' data-objeto='action_email_$array[id]' ".($array['unseen']==0 ? 'style=color:#009933;' : 'style=color:#999999;').">".iconv_mime_decode($array['subject'])."</a>
			</td>
			<td>
				<a class='regular-link-msg' data-objeto='action_email_$array[id]' ".($array['unseen']==0 ? 'style=color:#009933;' : 'style=color:#999999;').">".date('d/m/Y H:i:s', strtotime($array['date']))."</a>
				<form id='action_email_$array[id]'>
					<input type='hidden' name='caminho' value='controllers/sys/crud.sys.php' />
					<input type='hidden' name='flag' value='lerEmail' />
					<input type='hidden' name='id' value='$array[id]' />
					<input type='hidden' name='retorno' value='.content' />
				</form>
			</td>		
		</tr>
		";			
  }
  
  function detect_encoding($string){
	////w3.org/International/questions/qa-forms-utf-8.html
	if (preg_match('%^(?: [\x09\x0A\x0D\x20-\x7E] | [\xC2-\xDF][\x80-\xBF] | \xE0[\xA0-\xBF][\x80-\xBF] | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} | \xED[\x80-\x9F][\x80-\xBF] | \xF0[\x90-\xBF][\x80-\xBF]{2} | [\xF1-\xF3][\x80-\xBF]{3} | \xF4[\x80-\x8F][\x80-\xBF]{2} )*$%xs', $string))
		return 'UTF-8';

	return mb_detect_encoding($string, array('UTF-8', 'ASCII', 'ISO-8859-1', 'JIS', 'EUC-JP', 'SJIS'));
  }

  function convert_encoding($string, $to_encoding, $from_encoding = '')	{
	if ($from_encoding == '')
		$from_encoding = $this->detect_encoding($string);

	if ($from_encoding == $to_encoding)
		return $string;

	return mb_convert_encoding($string, $to_encoding, $from_encoding);
  }

}
?>