<?php
include("../model.inc.php");
if(!empty($_POST)){
	$a = new Model;
	$array = $_POST;
	switch($array['flag']){
	  case "PostgreSQL":
	  $con_string = "
		  host='".$array['host']."' 
		  port='".$array['porta']."' 
		  dbname='".$array['software']."'
		  user='".$array['usuario']."' 
		  password='".$array['senha']."'";
      $conn = pg_connect($con_string);
	  $result = pg_query($conn, "select * from privado.cliente_view");
	  var_dump(pg_fetch_all($result));
	break;
	}
}else{	  
	echo(
	'<div class="alert alert-warning fade in">
		<h4>Isso não deveria ter acontecido.</h4>
		<p>Uma situação inesperada ocorreu. <br>Por favor, entre em contato com o suporte.</p>
		<p class="m-t-10">
		  <button type="button" class="btn btn-default waves-effect rtrn-conteudo" >Fechar</button>
		</p>
	</div>'
	);
}
?>