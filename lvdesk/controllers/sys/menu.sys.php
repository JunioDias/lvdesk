<?php
include("../model.inc.php");
$dadoslogin = $_SESSION["datalogin"];
if(!empty($_POST)){
	switch($_POST['flag']){
		case "parametros":

			if(!empty($_POST['nome'])){
				unset($_POST["flag"],$_POST["caminho"]);
				$inserir =  new Model();
				$inserir -> add("parametros",$_POST);
			}
			else{
				echo '<div msg_dialog class="alerta" title="Clique para fechar.">O preenchimento do campo "Nome" é obrigatório.</div>';
			}			

		break;
		case "perfil":
			unset($_POST["flag"],$_POST["caminho"],$_POST["confirmasenha"]);
			if(!empty($_POST['nome'])){
				$arr = $_POST;
				if(isset($arr["senha"])){
					if($arr["senha"]!=""){
						$arr['senha'] = md5($arr['senha']);	
					}
				}
				$vetor = array();
				$nomeFile = "foto";
				foreach($arr as $key => $valor){
					if(empty($arr[$key])){
						unset($arr[$key]);
					}else{
						$vetor[$key] = $valor;	
					}
				}
				/*Script de carregamento de foto aqui*/
				$editar = new Model;
				$editar->addFoto($nomeFile, 'usuarios');
				if(empty($img['name'])){
					$editar -> upd("usuarios", $vetor, $dadoslogin['id']);
				}else{
					$vetor[$nomeFile] = $img['name']; #Inserir o nome do file no vetor
					$editar -> upd("usuarios", $vetor, $dadoslogin['id']);
				}
				echo "
				<div msg_dialog class='confirm' title='Clique para fechar.'>
				Tudo certo!<br>Atualização confirmada. 
				</div>";
			}
			else{
				echo '
				<div msg_dialog class="alerta" title="Clique para fechar.">
				O preenchimento do campo "Nome" é obrigatório.
				</div>';
			}

		break;
		case "blog":

			echo '<div msg_dialog class="alerta" title="Clique para fechar."><p>Rotina associada a esta opção não encontrada.</p></div>';

		break;
		case "games":

			echo '<div msg_dialog class="alerta" title="Clique para fechar."><p>Rotina associada a esta opção não encontrada.</p></div>';

		break;
		case "leitura":

			echo '<div msg_dialog class="alerta" title="Clique para fechar."><p>Rotina associada a esta opção não encontrada.</p></div>';

		break;
	}
}
?>