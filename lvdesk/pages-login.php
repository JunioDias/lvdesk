<?php
include("controllers/model.inc.php");
$a = new Model();
?>
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
        <div <!-- class="accountbg" -->>
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
                    <h4 class="text-default text-center m-t-0"><b>LV Desk</b></h4>

                    <form class="form-horizontal m-t-20" action="controllers/sys/login.sys.php" method="post">

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input name="usuario" class="form-control" type="text" required="" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input name="senha" class="form-control" type="password" required="" placeholder="Senha">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Lembrar meus dados
                                    </label>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_SESSION['returnLogin'])) {
                            switch ($_SESSION['returnLogin']) {
                                case 'denied':
                                    ?>
                                    <div class="alert alert-danger fade in">
                                        <h4>Falha na operação.</h4>
                                        <p>Usuário ou senha não correspodem.</p>
                                        <!-- <p class="m-t-10">
                                            <a type="button" class="btn btn-default waves-effect regular-link" href="../../pages-login.php">Fechar</a>
                                        </p> -->
                                    </div>
                                    <?php
                                break;
                            } // close switch ($_SESSION['returnLogin'])
                        } // close if ($_SESSION['returnLogin'] === 'denied')
                        session_destroy();
                        ?>
                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-warning btn-block btn-lg waves-effect waves-light" type="submit" >Log In</button>
								<input type="hidden" name="flag" value="login" />
                            </div>
                        </div>
						</form>
						<div class="form-group m-t-30 m-b-0">

                        <form method="post" action="pages-recoverpw.php">
						<div class="col-sm-7">
							<button class="btn btn-block btn-lg waves-effect waves-light esqueceu" type="submit" >Esqueceu sua senha?</button>
							<!--<a href="pages-recoverpw.html" class="text-default"><i class="fa fa-lock m-r-5"></i> Esqueceu sua senha?</a>-->
						</div>
						</form>

						<form class="form-horizontal m-t-20" action="pages-register.html">
                            <div class="col-sm-5 text-right">
								<!--<button class="btn btn-danger btn-block btn-lg waves-effect waves-light" type="submit">Contrate um plano</button>
                                <a href="pages-register.html" class="text-default">Contrate um plano</a>-->
                            </div>
						</form>
                        </div>
                    <!--</form>-->
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