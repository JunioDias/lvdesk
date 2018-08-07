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
<!--------------------- Modal de alerta para clientes com pendências contratuais -------------------->
<div id="alerta_cliente_contrato" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalContratoAlerta" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 class="modal-title" id="modalContratoAlerta">Atenção!</h3>
	</div>
	<div class="modal-body">
		<h4>Possíveis pendências contratuais.</h4>
		<p>Esta entidade possui uma observação contratual.<br>
		Confira a validade do contrato ou número de atendimentos máximo.<br>
		Por favor, encaminhe um aviso para o setor responsável.</p>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-success waves-effect" data-dismiss="modal">OK</button>
	</div>
  </div><!-- /.modal-content -->
</div><!-- /.modal.dialog -->
</div><!-- container -->     