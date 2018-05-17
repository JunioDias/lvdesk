<h1>Sistemas</h1>
<section class="section_conteudo_menu">
<?php
include("../../model.inc.php");
$menu = new Model();
$menu->queryFree('SELECT * FROM artigos WHERE lixo = 0 AND id_menu = 3 ORDER BY id DESC');
while($artigo = $result->fetch_assoc()){
echo"
	<div class='div_blog_artigos_listagem'>
		<img src='media/imagens/galeria/artigos/".$artigo['imagem']."' alt='".$artigo['imagem']."' class='imagem_artigo'/>
		<div class='titulo_blog_artigo'>
		  <h3>".$artigo['titulo']."</h3><br>
		  <p>".$artigo['chamada']."</p>
		</div><br>
		<a class='leiaMais' link='".$artigo['id']."' href='#menu_principal'>Leia Mais...</a>
	</div>
  ";
}
?>  
</section>