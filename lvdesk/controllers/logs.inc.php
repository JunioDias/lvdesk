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
	
	public function dashboard($identificador = NULL){
		if(is_null($identificador)){
			echo '
			<div class="row">
				<div class="col-sm-6 col-lg-3">
					<div class="panel text-center">
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Total de Clientes</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-down-bold-circle-outline text-danger m-r-10"></i><b>8952</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>48%</b> Nas últimas 24 horas</p>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3">
					<div class="panel text-center">
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Status de Atendimentos</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-up-bold-circle-outline text-success m-r-10"></i><b>6521</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>42%</b> Nos últimos 10 meses</p>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3">
					<div class="panel text-center">
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Retornos</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-up-bold-circle-outline text-success m-r-10"></i><b>452</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>22%</b> Nas últimas 24 horas</p>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3">
					<div class="panel text-center">
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Tempo médio</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-down-bold-circle-outline text-danger m-r-10"></i><b>8,7 min</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>2%</b> Em relação ao mês passado</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-primary">
						<div class="panel-body">
							<h4 class="m-t-0">Revenue</h4>

							<ul class="list-inline widget-chart m-t-20 text-center">
								<li>
									<i class="mdi mdi-arrow-up-bold-circle-outline text-success"></i>
									<h4 class=""><b>5248</b></h4>
									<p class="text-muted m-b-0">WiMax</p>
								</li>
								<li>
									<i class="mdi mdi-arrow-down-bold-circle-outline text-danger"></i>
									<h4 class=""><b>321</b></h4>
									<p class="text-muted m-b-0">Next</p>
								</li>
								<li>
									<i class="mdi mdi-arrow-down-bold-circle-outline text-danger"></i>
									<h4 class=""><b>964</b></h4>
									<p class="text-muted m-b-0">Isimples</p>
								</li>
							</ul>

							<div id="morris-bar-example" style="height: 300px"></div>
						</div>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="panel panel-primary">
						<div class="panel-body">
							<h4 class="m-t-0">E-mails Recebidos</h4>

							<ul class="list-inline widget-chart m-t-20 text-center">
								<li>
									<i class="mdi mdi-arrow-up-bold-circle-outline text-success"></i>
									<h4 class=""><b>3654</b></h4>
									<p class="text-muted m-b-0">WiMax</p>
								</li>
								<li>
									<i class="mdi mdi-arrow-down-bold-circle-outline text-danger"></i>
									<h4 class=""><b>954</b></h4>
									<p class="text-muted m-b-0">Next</p>
								</li>
								<li>
									<i class="mdi mdi-arrow-up-bold-circle-outline text-success"></i>
									<h4 class=""><b>8462</b></h4>
									<p class="text-muted m-b-0">Isimples</p>
								</li>
							</ul>

							<div id="morris-area-example" style="height: 300px"></div>
						</div>
					</div>
				</div>

			</div>
			<!-- end row -->

			<div class="row">
				<div class="col-md-4">
					<div class="panel">
						<div class="panel-body">
							<h4 class="m-b-30 m-t-0">Metas</h4>

							<p class="font-600 m-b-5">1º Nível<span class="text-primary pull-right"><b>80%</b></span></p>
							<div class="progress  m-b-20">
								<div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
								</div><!-- /.progress-bar .progress-bar-danger -->
							</div><!-- /.progress .no-rounded -->

							<p class="font-600 m-b-5">2º Nível <span class="text-primary pull-right"><b>50%</b></span></p>
							<div class="progress  m-b-20">
								<div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
								</div><!-- /.progress-bar .progress-bar-pink -->
							</div><!-- /.progress .no-rounded -->

							<p class="font-600 m-b-5">Outros <span class="text-primary pull-right"><b>70%</b></span></p>
							<div class="progress  m-b-20">
								<div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
								</div><!-- /.progress-bar .progress-bar-info -->
							</div><!-- /.progress .no-rounded -->

							<p class="font-600 m-b-5">Estatística <i>Chore</i> <span class="text-primary pull-right"><b>65%</b></span></p>
							<div class="progress  m-b-20">
								<div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%;">
								</div><!-- /.progress-bar .progress-bar-warning -->
							</div><!-- /.progress .no-rounded -->

							<p class="font-600 m-b-5">Retornos <span class="text-primary pull-right"><b>25%</b></span></p>
							<div class="progress  m-b-20">
								<div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
								</div><!-- /.progress-bar .progress-bar-warning -->
							</div><!-- /.progress .no-rounded -->

							<p class="font-600 m-b-5"> Cancelamentos<span class="text-primary pull-right"><b>40%</b></span></p>
							<div class="progress  m-b-0">
								<div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
								</div><!-- /.progress-bar .progress-bar-success -->
							</div><!-- /.progress .no-rounded -->
						</div>
					</div>
				</div> <!-- col Fim -->

				<div class="col-md-8">
					<div class="panel">
						<div class="panel-body">
							<h4 class="m-b-30 m-t-0">Novos Contatos</h4>
							<div class="row">
								<div class="col-xs-12">
									<div class="table-responsive">
										<table class="table table-hover m-b-0">
											<thead>
											<tr>
												<th>Nome</th>
												<th>Entidade</th>
												<th>Cidade</th>
												<th>Idade</th>
												<th>Início</th>
												<th>Valor</th>
											</tr>

											</thead>
											<tbody>
											<tr>
												<td>Tiger Nixon</td>
												<td>System Architect</td>
												<td>Edinburgh</td>
												<td>61</td>
												<td>2011/04/25</td>
												<td>$320,800</td>
											</tr>
											<tr>
												<td>Garrett Winters</td>
												<td>Accountant</td>
												<td>Tokyo</td>
												<td>63</td>
												<td>2011/07/25</td>
												<td>$170,750</td>
											</tr>
											<tr>
												<td>Ashton Cox</td>
												<td>Junior Technical Author</td>
												<td>San Francisco</td>
												<td>66</td>
												<td>2009/01/12</td>
												<td>$86,000</td>
											</tr>
											<tr>
												<td>Cedric Kelly</td>
												<td>Senior Javascript Developer</td>
												<td>Edinburgh</td>
												<td>22</td>
												<td>2012/03/29</td>
												<td>$433,060</td>
											</tr>
											<tr>
												<td>Airi Satou</td>
												<td>Accountant</td>
												<td>Tokyo</td>
												<td>33</td>
												<td>2008/11/28</td>
												<td>$162,700</td>
											</tr>
											<tr>
												<td>Brielle Williamson</td>
												<td>Integration Specialist</td>
												<td>New York</td>
												<td>61</td>
												<td>2012/12/02</td>
												<td>$372,000</td>
											</tr>
											<tr>
												<td>Herrod Chandler</td>
												<td>Sales Assistant</td>
												<td>San Francisco</td>
												<td>59</td>
												<td>2012/08/06</td>
												<td>$137,500</td>
											</tr>

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- fim col -->
			</div>
			<!-- fim row -->
			';
		}else{
			$a = new Model;
			echo '
			<div class="row">
				<div class="col-sm-6 col-lg-3">
				<a class="regular-link" link="views/listagem.php">
					<div class="panel text-center panel-atendimento">
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Chamados</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-down-bold-circle-outline text-danger m-r-10"></i><b>8952</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>48%</b> Nas últimas 24 horas</p>
						</div>
					</div>
				</a>
				</div>

				<div class="col-sm-6 col-lg-3">
				<a class="regular-link" link="views/servicos.php">
					<div class="panel text-center  panel-atendimento">
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Serviços</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-up-bold-circle-outline text-success m-r-10"></i><b>'.$a->notification(NULL, 'on').'</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>42%</b> Nos últimos 10 meses</p>
						</div>
					</div>
				</a>
				</div>

				<div class="col-sm-6 col-lg-3">
				<a class="regular-link" link="views/historicos.php">
					<div class="panel text-center panel-atendimento">
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Históricos</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-up-bold-circle-outline text-success m-r-10"></i><b>452</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>22%</b> Nas últimas 24 horas</p>
						</div>
					</div>
				</a>
				</div>

				<div class="col-sm-6 col-lg-3">
				<a class="regular-link" link="views/_manut.php" >
					<div class="panel text-center panel-atendimento" >
						<div class="panel-heading">
							<h4 class="panel-title text-muted font-light">Auditorias</h4>
						</div>
						<div class="panel-body p-t-10">
							<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-down-bold-circle-outline text-danger m-r-10"></i><b>8,7 min</b></h2>
							<p class="text-muted m-b-0 m-t-20"><b>2%</b> Em relação ao mês passado</p>
						</div>
					</div>
				</a>
				</div>
			</div>
			' ;
		}
	}
}
?>