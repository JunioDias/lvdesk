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
* $callbackedit 	= Páginas que vai retornar após a edição do registro. Esse link coincide com outras ações de POST.
* $link 			= Destino do POST.
*/
  public function crudButtons($id, $callbackdelete, $callbackedit, $link){
	echo "	
	<a class='btn btn-warning rtrn-conteudo-listagem' item=".$id." flag='edt' objeto='form_action' caminho=".$callbackedit." title='Editar registro'>Editar</a>
	<a class='btn btn-danger rtrn-conteudo-listagem botao' item=".$id." flag='exc' objeto='form_action' caminho=".$link." title='Excluir registro' data-toggle='modal' data-target='#confirma'>Excluir</a>	
	";
  }

  public function darEntrada($id, $cpf, $link, $flag){
	echo '
	<input objeto="form_action" class="btn btn-success btn_driver rtrn-conteudo-listagem" value="Dar entrada" type="button" flag="'.$flag.'" caminho="'.$link.'" item="'.$cpf.'" idd="'.$id.'">	
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
  
  public function conteudoTabelaCGR($array, $link, $flag){
	echo "
	<tr>
	<td>".date('d/m/Y', strtotime($array['data_abertura']))."</td>
	<td>$array[nome_cliente]</td>
	<td>$array[nome_provedor]</td>
	<td>$array[telefone_cliente]</td>
	<td>
	";  
	$this->darEntrada($array['id'], $array['cpf_cnpj_cliente'], $link, $flag); 
	echo "</td></tr>";
  }
}
?>