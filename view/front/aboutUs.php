<h1>Sobre Nós</h1>
<section id="sectionAbout">
<?php
include("../../model.inc.php");
$a = new Model();
$result = $a->queryFree("SELECT * FROM artigos WHERE lixo = 0 AND id_menu = 15");
if ($result->num_rows > 0) { 
	$artigo = $result->fetch_assoc();
	echo "
	<h3>".$artigo['titulo']."</h3><br>
	<span style='font-style:italic;'>".$artigo['chamada']."</span><br><br>
	<br><a class='botVoltar' href='index.php'>Voltar</a>
	<p>
	  <span style='float:left; padding: 0 10px 0 0;'>
		 <img src='media/imagens/galeria/artigos/".$artigo['imagem']."' alt='".$artigo['imagem']."' class='imagemArtigo'/>
	  </span>
	  ".$artigo['texto']."
	</p><br>
	<a class='botVoltar' href='index.php'>Voltar</a>
	"; 
}else{
	echo "<div msg_dialog class='alerta' title='Clique para fechar.'>
	Ainda não há nada para ser exibido.<br>Nenhum artigo foi encontrado. 
	</div>";
}
?>
</section>