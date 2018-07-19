<?php
class Logs {
	public function timeline($linhas, $solution, $icone = NULL ){		
		echo "<div class='cd-timeline-block'>";
		if($solution == '1'){
			echo "
			<div class='cd-timeline-img cd-success'>
				<i class='fa ". $icone ."'></i>
			</div> <!-- cd-timeline-img -->";
		}
		echo "			
			<div class='cd-timeline-content'>
				<h3>".$linhas['nome']."</h3>
				<p>".$linhas['descricao']."</p>
				<span class='cd-date'>".date('d/m/Y h:i', strtotime($linhas['data']))."
				<p style='font-size: 9px;'><i>Protocolo: ".$linhas['protocol']."</i></p>
				</span>					
			</div> 
		</div>
		";		
	}
	
	public function ultimosAtendimentos($identificador){
		$a = new Model;
		$cgr_query = "SELECT * FROM pav_inscritos WHERE cpf_cnpj_cliente = '".$identificador."' AND lixo = 0 ORDER BY data_abertura DESC LIMIT 7";
		$result = $a->queryFree($cgr_query);		
		if(isset($result)){
			while($linhas = $result->fetch_assoc()){
				echo "
				<div class='form-group'>
				<button type='button' class='btn ";
				if($linhas['status'] == '0'){
					echo "btn-warning"; 
				}else if($linhas['status'] == '1'){
					echo "btn-danger";
				}else{
					echo "btn-success";
				}
				echo " waves-effect waves-light envia-modal' data-toggle='modal' data-target='#modalLastLog' cliente_id=".$linhas['id']." item=".$linhas['protocol']." objeto='form_ultimos_atendimentos'>";
				if($linhas['status'] == '0'){
					echo "Na fila desde "; 
				}else if($linhas['status'] == '1'){
					echo "Em atendimento desde ";
				}else{
					echo "Finalizado em ";
				}							
				echo date('d/m/Y', strtotime($linhas['data_abertura']))."</button>									   
				</div>
				";									
			}
		}else{
			echo "
			<div class='form-group' style='text-align: center;'>
			  <div title='Nenhum atendimento aberto recentemente.' class='cd-timeline-img cd-success' style='margin-top: 35%;'>
				<i class='fa fa-hand-peace-o' ></i>									
			  </div>							  
			</div>";
		} 
	}
	
	/* public function ultimosAtendimentos($identificador){
		$a = new Model;
		$cgr_query = "SELECT id FROM pav_inscritos WHERE cpf_cnpj_cliente = '".$identificador."' AND validado = 0 AND lixo = 0";
		$teste_id = $a->queryFree($cgr_query);
		if(isset($teste_id)){
			$cgr_teste = $teste_id->fetch_assoc();
			if(count($cgr_teste)){							
				$queryAtend	= "
				SELECT pav.id, pav.protocol, pav.data, pav.descricao, pav_inscritos.status, atend.nome FROM pav_movimentos AS pav INNER JOIN atendentes AS atend ON atend.id = pav.id_atendente INNER JOIN pav_inscritos ON pav_inscritos.id = pav.id_pav_inscritos WHERE pav.id_pav_inscritos = ".$cgr_teste['id']." AND pav.lixo = 0 ORDER BY pav.data DESC LIMIT 8
				";							
				$result = $a->queryFree($queryAtend);
				if(isset($result)){
					while($linhas = $result->fetch_assoc()){
						echo "
						<div class='form-group' title='".$linhas['descricao']."'>
						<button type='button' class='btn ";
						if($linhas['status'] == '0'){
							echo "btn-warning"; 
						}else if($linhas['status'] == '1'){
							echo "btn-danger";
						}else{
							echo "btn-success";
						}
						echo " waves-effect waves-light envia-modal' data-toggle='modal' data-target='#modalLastLog' cliente_id=".$cgr_teste['id']." item_id=".$linhas['id']." item=".$linhas['protocol']." desc='".$linhas['descricao']."'>".$linhas['protocol']." em ".date('d/m/Y', strtotime($linhas['data']))."</button>									   
						</div>
						";									
					}
				}
			}else{
				echo "
				<div class='form-group' style='text-align: center;'>
				  <div title='Nenhum atendimento aberto recentemente.' class='cd-timeline-img cd-success' style='margin-top: 35%;'>
					<i class='fa fa-hand-peace-o' ></i>									
				  </div>							  
				</div>";
			}	
		}else{
			echo  "<div class='form-group'>Nenhum atendimento em aberto.</div>"; 
		}	 
	} */
}
?>