<?php
include("parametros.inc.php");
$a = new Param();
?>
<!DOCTYPE html>
<html>

<head>
	<title><?= $a->title(); ?></title>   
	<?php
		if(isset($index)){
			echo '<link type="text/css" rel="stylesheet" href="css/front.css" />';
		}else{
			echo '<link type="text/css" rel="stylesheet" href="css/back.css" />';
		}
	?>
  <link rel="apple-touch-icon" sizes="57x57" href="media/imagens/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="media/imagens/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="media/imagens/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="media/imagens/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="media/imagens/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="media/imagens/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="media/imagens/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="media/imagens/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="media/imagens/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="media/imagens/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="media/imagens/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="media/imagens/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="media/imagens/favicon/favicon-16x16.png">
	<link rel="manifest" href="media/imagens/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<meta charset="UTF-8">
	<meta author="<?= $a->autor(); ?>" />
	<meta name="description" content="<?= $a->descricao(); ?>" />
	<meta name="keywords" content="<?= $a->palavrachave(); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<!-- Compilação mais atual das bibliotecas padrões minified -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>		
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<!-- Fim -->
	<script src="plugins/fileUpload/js/vendor/jquery.ui.widget.js"></script>
	<script src="plugins/fileUpload/js/jquery.iframe-transport.js"></script>
	<script src="plugins/fileUpload/js/jquery.fileupload.js"></script>
	<script src="js/jquery.form.js"></script>
	<script src="js/jquery.maskMoney.js" ></script>
	<script src="js/scripts.js" ></script>	
</head>

<body>