<?php
$indice = $_POST['indice'][0];
if(isset($_POST['flag'])){
	$pasta_fotos = "../media/imagens/galeria/albuns/".$_POST['id'];
	$pagina = "view/front/album.php";
}else{
	$pasta_fotos = "../media/imagens/galeria/albuns/fotos_galeria";		
	$pagina = "view/front/galeria.php";
}
$fotos = array();
foreach(glob($pasta_fotos.'/{*.jpg,*.png,*.jpeg,*.gif}', GLOB_BRACE) as $image) {		
	$fotos[] = $image;		
}
#print_r($fotos);
if ( $indice == 0 ) { $anterior = "0"; } else { $anterior = $indice - 1; }	
if ( $indice == count($fotos)-1 ) { $proxima = $indice; } else { $proxima = $indice + 1; }
echo "
<section>
<a galeria-nav-mov link='" . substr($fotos[$proxima], 3) . "' data-description='".$proxima."'>
	<img class='foto_grande' src='" . $_POST["image"]. "'>
</a>
<nav class='galeria-nav-menu'>
	<a class='galeria-nav' ";
	if(isset($_POST['flag'])){
		echo "flag id='".$_POST['id']."' ";
	}
	echo "galeria-nav-mov link='" . substr($fotos[$anterior], 3). "' data-description='".$anterior."'>Foto anterior</a> | 
	
	<a name='galeria_nav_volta' class='galeria-nav' ";
	if(isset($_POST['flag'])){
		echo "flag='album' id='".$_POST['id']."' ";
	}
	echo " link='".$pagina."' >Voltar para a galeria</a> | 
	
	<a class='galeria-nav' ";
	if(isset($_POST['flag'])){
		echo "flag id='".$_POST['id']."' ";
	}
	echo "galeria-nav-mov link='" . substr($fotos[$proxima], 3) . "' data-description='".$proxima."'>Próxima foto</a>
</nav>	
</section>";
?>