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
}
?>