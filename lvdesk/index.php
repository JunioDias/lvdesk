<!DOCTYPE html>
<?php
include ("controllers/model.inc.php");
if(!empty($_SESSION["datalogin"])){
	$dadoslogin = $_SESSION["datalogin"];
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>LV Desk - Conecte-se e evolua.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="Angra Soluções" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="assets/plugins/morris/morris.css">
		<!--bootstrap-wysihtml5-->
		<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css">
		
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
		
    </head>


    <body class="fixed-left">

        <!-- Início da página -->
        <div id="wrapper">

            <!-- Top Bar -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="index.html" class="logo"><img src="assets/images/logo_white_2.png" alt="logo"/></a>
                        <a href="index.html" class="logo-sm"><img src="assets/images/logo_sm.png" alt="logo"/></a>
                        <!--<a href="index.html" class="logo"><img src="assets/images/logo_white_2.png" height="28"></a>-->
                        <!--<a href="index.html" class="logo-sm"><img src="assets/images/logo_sm.png" height="36"></a>-->
                    </div>
                </div>
                <!-- Aparência botão mobile para menu sidebar colapsado -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>
                            <form class="navbar-form pull-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control search-bar" placeholder="Busca...">
                                </div>
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </form>

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="dropdown hidden-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="text-center notifi-title">Notificação <span class="badge badge-xs badge-success">3</span></li>
                                        <li class="list-group">
                                           <!-- list item-->
                                           <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="media-heading">Atendimento em curso</div>
                                                 <p class="m-0">
                                                   <small>Texto genérico...</small>
                                                 </p>
                                              </div>
                                           </a>
                                           <!-- list item-->
                                            <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="media-body clearfix">
                                                    <div class="media-heading">Nova mensagem recebida</div>
                                                    <p class="m-0">
                                                       <small>Mensagens não lidas</small>
                                                    </p>
                                                 </div>
                                              </div>
                                            </a>
                                            <!-- list item-->
                                            <a href="javascript:void(0);" class="list-group-item">
                                              <div class="media">
                                                 <div class="media-body clearfix">
                                                    <div class="media-heading">Seu atendimento foi finalizado.</div>
                                                    <p class="m-0">
                                                       <small>Texto genérico...</small>
                                                    </p>
                                                 </div>
                                              </div>
                                            </a>
                                           <!-- last list item -->
                                            <a href="javascript:void(0);" class="list-group-item">
                                              <small class="text-primary">Ver todas notificações</small>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="mdi mdi-fullscreen"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <img src="assets/images/users/<?= $dadoslogin['foto'];?>" alt="user-img" class="img-circle">
                                        <span class="profile-username">
                                            <?= $dadoslogin["nome"]; ?><br/>
                                            <small><?= $dadoslogin['nomep'];?></small>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0)"> Perfil</a></li>
                                        <li><a href="javascript:void(0)"> Configurações </a></li>
                                        <li><a class="regular-link" link="views/documentacao.html"> Documentação</a></li>
                                        <li class="divider"></li>
                                        <li><a class="rtrn-conteudo" objeto="form_objeto"> Logout</a></li>
										<form id="form_objeto">
										  <input type="hidden" name="flag" value="logout"/>
										  <input type="hidden" name="caminho" value="controllers/sys/login.sys.php"/>
										</form>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar Fim -->


            <!-- ========== Sidebar Esq. ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <div class="user-details">
                        <div class="text-center">
                            <img src="assets/images/users/<?= $dadoslogin['foto'];?>" alt="" class="img-circle">
                        </div>
                        <div class="user-info">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <?= $dadoslogin["nome"]; ?></a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)"> Perfil</a></li>
                                    <li><a href="javascript:void(0)"> Configurações</a></li>
                                    <li><a class="regular-link" link="views/documentacao.html"> Documentação</a></li>
                                    <li class="divider"></li>
                                    <li><a class="rtrn-conteudo" objeto="form_objeto"> Logout</a></li>
                                </ul>
                            </div>

                            <p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i> Online</p>
                        </div>
                    </div>
                    <!--- Divider -->

					<div id="sidebar-menu">
                        <ul>						
                            <li>
                                <a href="index.php" class="waves-effect"><i class="mdi mdi-home"></i><span> Dashboard </span></a>
                            </li>							
							<?php
							$acesso = new Model();
							$priv = $acesso->libPriv($dadoslogin['id_privilegio']);
							?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- Fim sidebarinner -->
            </div>
            <!-- Sidebar Esq Fim -->

            <!-- Conteúdo Dir. -->

            <div class="content-page">
                <!-- Conteúdo -->
                <div class="content">

                    <div class="">
                        <div class="page-header-title">
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>

                    <div class="page-content-wrapper ">

                        <div class="container">

                        <?php
                        include("controllers/logs.inc.php");
						$foo = new Logs;
						if($dadoslogin['id_privilegio']==1){
							$foo->dashboard();
						}else{
							$foo->dashboard('on');
						}
						?>
                        </div><!-- container -->


                    </div> <!-- Conteúdo do Page Wrapper -->

                </div> <!-- fim do conteúdo -->

                <footer class="footer">
                     © 2018 LV Network - Todos os direitos reservados.
                </footer>

            </div>
            <!-- Fim do Conteúdo Dir -->

        </div>
        <!-- Fim wrapper -->

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
		<script src="assets/js/jquery.mask.min.js"></script>
		<!-- Wysihtml js -->
		<script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
		<script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
		<script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/src/locales/bootstrap-wysihtml5.pt-BR.js"></script>		
		<!--Morris Chart-->
        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>
        <script src="assets/pages/dashborad.js"></script>
		<script src="assets/js/validator.min.js"></script>
		<script src="assets/js/app.js"></script>
		
    </body>
</html>
<?php
}
else
{
header("Location: pages-login.php");
}
?>