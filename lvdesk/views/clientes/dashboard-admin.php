<?php
$a = new Model;
$dadoslogin = $_SESSION['datalogin'];
$query = "SELECT * FROM planos_movimentos WHERE id_cliente = '".$dadoslogin['id']."' AND data_limite >= now() AND lixo = 0 ORDER BY qntd_atendimentos LIMIT 1"; 
$foo 		= $a->queryFree($query);
$mov_planos = $foo->fetch_assoc();

$query_plano = "SELECT * FROM planos WHERE id = '".$mov_planos['id_planos']."' AND lixo = 0"; 
$foo 	= $a->queryFree($query_plano);
$planos = $foo->fetch_assoc();
?>
<div class="container">
<div class="row">
	<div class="col-sm-6 col-lg-3">
		<a href="#">
		<div class="panel text-center panel-atendimento">
			<div class="panel-heading">
				<h4 class="panel-title text-muted font-light">Atendimentos</h4>
			</div>
			<div class="panel-body p-t-10">
				<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-down-bold-circle-outline text-danger m-r-10"></i><b><?= $mov_planos['atendimentos_atuais'];?></b></h2>
				<p class="text-muted m-b-0 m-t-20">Plano <?= $planos['nome'];?></p>
			</div>
		</div>
		</a>
	</div>

	<div class="col-sm-6 col-lg-3">
	<a href="#">
		<div class="panel text-center panel-atendimento">
			<div class="panel-heading">
				<h4 class="panel-title text-muted font-light">Retornos</h4>
			</div>
			<div class="panel-body p-t-10">
				<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-up-bold-circle-outline text-success m-r-10"></i><b>6521</b></h2>
				<p class="text-muted m-b-0 m-t-20"><b>42%</b> Nos últimos 10 meses</p>
			</div>
		</div>
	</a>
	</div>

	<div class="col-sm-6 col-lg-3">
	<a href="#">
		<div class="panel text-center panel-atendimento">
			<div class="panel-heading">
				<h4 class="panel-title text-muted font-light">Total</h4>
			</div>
			<div class="panel-body p-t-10">
				<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-up-bold-circle-outline text-success m-r-10"></i><b>452</b></h2>
				<p class="text-muted m-b-0 m-t-20"><b>22%</b> Nas últimas 24 horas</p>
			</div>
		</div>
	</a>
	</div>

	<div class="col-sm-6 col-lg-3">
	<a href="#">
		<div class="panel text-center panel-atendimento">
			<div class="panel-heading">
				<h4 class="panel-title text-muted font-light">Excedente</h4>
			</div>
			<div class="panel-body p-t-10">
				<h2 class="m-t-0 m-b-15"><i class="mdi mdi-arrow-down-bold-circle-outline text-danger m-r-10"></i><b>8,7 min</b></h2>
				<p class="text-muted m-b-0 m-t-20"><b>2%</b> Em relação ao mês passado</p>
			</div>
		</div>
	</a>
	</div>
</div>

</div><!-- container -->     