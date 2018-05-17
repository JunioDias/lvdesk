<?php
include("../../model.inc.php");
if(!empty($_SESSION)){
	$dadoslogin = $_SESSION["datalogin"];
	echo "<section id='sectionLogin'>
	<h1>Login</h1>
	<center>
	<h3>Área do Cliente</h3><br>
	<p>Você está logado como ".$dadoslogin['nome'].".</p>
	<p>Use o menu de navegação para acessar sua área de trabalho.</p>
	</center>
</section>";
}else{
?>
<section id="sectionLogin">
	<h1>Login</h1>
	<center>
	<h3>Área do Cliente</h3>
	<br><span class="progresso"></span>
	<form action="sys/login.sys.php" method="post">
        <table cellpadding="5px" cellspacing="5px">
            <tr><td width="50px">Usuário</td><td width="140px"><input type="text" name="usuario"></td></tr>
            <tr><td>Senha</td><td><input type="password" name="senha"></td></tr>
            <tr>
            	<td colspan="2" align="right"><!--<input class="logon" type="button" value="Entrar" />-->
            	<input type="submit" value="Entrar" />
                </td>
            </tr>
            <tr><td colspan="2"><a class='regular-link' link="view/front/registro.php">Registre-se</a></td></tr>
            <tr><td colspan="2"><a class='regular-link' link="view/front/recupsenha.php">Esqueci a minha senha</a></td></tr>
        </table>
        <input type="hidden" name="flag" value="login" />
	</form>
</div>
	</form>
	</center>
</section>
<?php
}
?>