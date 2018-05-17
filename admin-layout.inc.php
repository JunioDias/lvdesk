<?php
#SESSION iniciada na função login (model.inc)
$dadoslogin = $_SESSION["datalogin"];
if(!isset($dadoslogin["id"])){ # Teste de Session - Início
	header("Location: index.php");
}
else
{
?>
<div class="topo">
    <div id="logo"></div>
    <div class="cabecalho">
    	<div class="avatar" style="background-image:url('media/imagens/avatar/<?= $dadoslogin['foto'];?>')"></div>
        <p>
            <b><em><?= $dadoslogin['nome'];?></em></b><br/>
            Privilégio: <em><?= $dadoslogin['nomep'];?></em><br/>
            Usuário: <em><?= $dadoslogin['usuario'];?></em><br/>
            <hr />
            <form class="menuAction" action="sys/login.sys.php" method="post">
            <input type="button" value="Perfil" class='menu-control' link="view/perfil.php" /> ::
            <a href="index.php" target="_blank" title="Visualizar alterações no site." >Ver Site</a> ::
            <input type="submit" value="Sair"  />
            <input type="hidden" value="logout" name="flag" />
            </form>
        </p>
    </div>
</div>
<div id="limite" >
    <div id="menu">
    	<h3>Painel Administrativo - Menu de Controle</h3>
        <?php
		$menu = $acesso = new Model();
		$priv = $acesso->libPriv($dadoslogin['id_privilegio']);
		?>
    </div>
    <div id="conteudo" class="conteudo">
    	<?php
		if($dadoslogin['id_privilegio']!= '1'){
		  if(isset($_GET['choice'])){
			$choice = $_GET['choice'];
			switch($choice){
				case "1":
					include('view/perfil.php');
				break;
				case "2":
					include('view/adminPedidos.php');
				break;
				case "3":
					include('view/adminServicos.php');
				break;
			}
		  }else{
		?>
        <h3>Conteúdo</h3>
        <h3>Bem vindo!</h3>
        <p><?php include("plugins/frases.php"); }}?></p>
    </div>
    <br class="clear" />
</div>
<?php
}# Teste de Session - Fim
?>
<center><p class="copy"><?php (isset($_GET['choice']) ?  $a = new Param() : ""); $a->copyright(); ?></p></center>
</body>
</html>