<?php
class Logs{
	public function timeline($linhas, $icone = NULL){
		echo "
		<div class='cd-timeline-block'>
			<div class='cd-timeline-img cd-success'>
				<i class='fa ". $icone ."'></i>
			</div> <!-- cd-timeline-img -->
			<div class='cd-timeline-content'>
					<h3>".$linhas['atendente_nome']."</h3>
					<p>".$linhas['descricao']."</p>
					<span class='cd-date'>".date('d/m/Y h:i', strtotime($linhas['data']))."</span>					
			</div> 
		</div>
		";
	}
}
?>