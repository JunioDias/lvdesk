<?php
/*Classes de uso para frontend. Criação de rotinas comuns ao UX.
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
  public function crudButtons($id, $callbackdelete, $callbackedit){
	echo "	
	<a class='btn btn-warning rtrn-conteudo-listagem' item=".$id." flag='edt' objeto='form_action' title='Editar registro'>Editar</a>
	<a class='btn btn-danger rtrn-conteudo-listagem botao' item=".$id." flag='exc' objeto='form_action' title='Excluir registro'>Excluir</a>		
	";
  }
}
?>