<?php session_start(); ?>
<!DOCTYPE html>
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
		<!-- Meus scripts -->
		<link href="assets/css/_astyles.css" rel="stylesheet" type="text/css">
    </head>


    <body>

        <!-- Begin page -->
        <div class="accountbg">
		<video autoplay muted loop class="bg">
		  <source src="media/videos/horizon.mp4" type="video/mp4">
		</video>
		</div>

        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        <a href="index.html" class="logo logo-admin"><img src="assets/images/logo_white_2.png" alt="logo"/></a>
                    </h3>
                    <h4 class="text-default text-center m-t-0"><b>Redefinição de Senha</b></h4>

                    <form class="form-horizontal m-t-20" action="controllers/sys/login.sys.php" method="post">

                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <span class="text-danger">Insira o seu <b>e-mail</b> e as instruções serão enviadas para você!</span>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="usuario" required="" placeholder="e-mail">
                            </div>
                        </div>

                        <?php
                        if (isset($_SESSION['returnLogin']) && $_SESSION['returnLogin'] === 'notEmail') {
                            ?>
                            <div class="alert alert-danger fade in">
                                <h4>Falha no processo.</h4>
                                <p>E-mail não existe na base de dados<br>Clique no botão abaixo para fechar esta mensagem.</p>
                                <!-- <p class="m-t-10">
                                  <a type="button" class="btn btn-default waves-effect" data-dismiss="alert" href="javascript:history.go(-1);">Fechar</a>
                                </p> -->
                            </div>
                            <?php
                        } // close if ($_SESSION['returnLogin'] === 'denied')
                        session_destroy();
                        ?>

                        <div class="form-group text-center m-t-30 m-b-0">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit" >Enviar e-mail</button>
                            </div>
                        </div>
						<input type="hidden" name="flag" value="recupera" />
                    </form>
                </div>

            </div>
        </div>



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

        <script src="assets/js/app.js"></script>

    </body>
</html>