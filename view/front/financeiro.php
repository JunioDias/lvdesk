<h1>Gestor Financeiro</h1>
<section id='section_games'>
<p>Solução de controle de gestão financeira com ferramentas de contas a pagar e receber. <br><br>
</p>
<table class="tabela_listagem">
<tr><th>Nº</th><th>Discriminação</th><th>Valor</th><th>Data Vcto.</th><th>Status</th></th>
<?php
include("../../model.inc.php");
$menu = new Model();
$menu->queryFree('SELECT * FROM financeiro WHERE lixo = 0 ORDER BY id DESC');
while($artigo = $result->fetch_assoc()){
	echo"<tr>";
	
}
?>  
</table>
</section>