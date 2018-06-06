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
                                        <li><a href="javascript:void(0)"><span class="badge badge-success pull-right">5</span> Configurações </a></li>
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
                                <a href="index.html" class="waves-effect"><i class="mdi mdi-home"></i><span> Dashboard <span class="badge badge-primary pull-right">1</span></span></a>
                            </li>

                            <li class="has_sub">
                                <a href="views/driver.html" class="waves-effect"><i class="ion-briefcase"></i> <span> Contratos </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>                                
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ion-ios7-telephone"></i> <span> Atendimento </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a class="regular-link" link="#">Listagem</a></li>
                                    <li><a class="regular-link" link="views/servicos.html">Serviços</a></li>
                                    <li><a class="regular-link" link="#">Histórico</a></li>
                                    <li><a class="regular-link" link="#">Leitura de e-mails</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ion-cash"></i><span> Financeiro </span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    
                                    <li><a link="#">Contas Bancárias</a></li>
                                    <li><a link="#">Contas a Pagar</a></li>
                                    <li><a link="#">Contas a Receber</a></li>
									<li><a link="#">Faturamento</a></li>
									<li><a link="#">Relatórios</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="typography.html" class="waves-effect"><i class="ion-clock"></i><span> Gestão de Horário </span></a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ion-gear-b"></i><span> Sistema </span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a class="regular-link" link="views/usuarios.html">Usuários</a></li>
                                    <li><a class="regular-link" link="views/permissoes.html">Permissões</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ion-link"></i><span> Driver </span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a class="regular-link" link="views/driver-conexoes.html">Conexões</a></li>
                                </ul>
                            </li>
							<!--<li class="has_sub">-->
                                <!--<a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-share-variant"></i><span>Multi Menu </span><span class="pull-right"><i class="mdi mdi-plus"></i></span></a>-->
                                <!--<ul>-->
                                    <!--<li class="has_sub">-->
                                        <!--<a href="javascript:void(0);" class="waves-effect"><span>Menu Item 1.1</span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>-->
                                        <!--<ul style="">-->
                                            <!--<li><a href="javascript:void(0);"><span>Menu Item 2.1</span></a></li>-->
                                            <!--<li><a href="javascript:void(0);"><span>Menu Item 2.2</span></a></li>-->
                                        <!--</ul>-->
                                    <!--</li>-->
                                    <!--<li>-->
                                        <!--<a href="javascript:void(0);"><span>Menu Item 1.2</span></a>-->
                                    <!--</li>-->
                                <!--</ul>-->
                            <!--</li>-->
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

        <!--Morris Chart-->
        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>
        <script src="assets/pages/dashborad.js"></script>
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