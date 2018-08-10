<?php
include('../controllers/model.inc.php');
$a = new Model;
$acesso = ($_SESSION['datalogin']);

?>
<div class="page-header-title">
  <h4 class="page-title">Permissões</h4>
  <p>Gerenciador do módulo de acessos e papéis do sistema</p>
</div>
<div class="content-sized">
<div class="page-content-wrapper ">

	<div class="container">
	  <div class="row">
	  <?php if(isset($acesso['id_ambiente'])){ ?>
		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/modulos.php">
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Módulos</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="ion-grid text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Rotinas básicas de processo</p>
				</div>
			</div>
			</a>
		</div>
	  <?php } ?>

		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/papeis.php">
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Papéis</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="ion-document text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Tipos de usuários com acesso</p>
				</div>
			</div>
			</a>
		</div>

		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/permissoes.php">
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Permissões</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="ion-unlocked text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Ações que cada papel possui</p>
				</div>
			</div>
			</a>
		</div>

		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/deliberar.php">
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Deliberar</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="ion-scissors text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Conceder/Negar permissões</p>
				</div>
			</div>
			</a>
		</div>
	  </div>
	  
	</div>
	</div>
	
	<!--Segunda linha-->
	
	<div class="container">

	  <div class="row">
		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/menus.php">
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Menus</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="mdi mdi-library text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Submenus para módulos</p>
				</div>
			</div>
			</a>
		</div>

		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/atendentes.php">
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Atendentes</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="mdi mdi-phone-in-talk text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Acesso aos níveis 1 e 2</p>
				</div>
			</div>
			</a>
		</div>

		<!-- <div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/permissoes.php">
			<div class="panel text-center panel-atendimento">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Permissões</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="ion-unlocked text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Ações que cada papel possui</p>
				</div>
			</div>
			</a>
		</div>

		<div class="col-sm-6 col-lg-3">
			<a class="regular-link" link="views/deliberar.php">
			<div class="panel text-center">
				<div class="panel-heading">
					<h4 class="panel-title text-muted font-light">Deliberar</h4>
				</div>
				<div class="panel-body p-t-10">
					<h2 class="m-t-0 m-b-15"><i class="ion-scissors text-danger m-r-10"></i></h2>
					<p class="text-muted m-b-0 m-t-20">Conceder/Negar permissões</p>
				</div>
			</div>
			</a>
		</div> -->
	  </div>
	  
	</div>
	</div>	
</div>
</div>
<script>
NProgress.done();
</script>