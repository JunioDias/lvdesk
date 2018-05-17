<section id="sectionLogin">
	<h1>Login</h1>
	<center>
        <h3>Recuperar Senhas</h3>
        <br>
        <p>Informe seu e-mail abaixo. Caso ele esteja cadastrado, o sistema enviará sua senha para que você possa anotá-la.<br><br>
        <a class='regular-link' link="view/front/instrucoes.php" title="Não entre em pânico. Clique aqui para mais informações.">Mas eu não lembro o meu e-mail de cadastro!</a></p><br>
        <form action="sys/login.sys.php" method="post">
            <table cellpadding="5px" cellspacing="5px">
            <tr>
            <td width="50px">E-mail</td>
            <td width="100px"><input type="text" title="Digite o e-mail cadastrado no sistema." name="usuario" maxlength="50" /></td>
            <td><input type="submit" value="Recuperar Senha"></td>
            </tr>
            </table><br>
            <a class='regular-link' link="view/front/login.php">Voltar</a>
            <input type="hidden" name="flag" value="recupera" />
            
        </form>
        </div>
        <span class="progresso"></span>
    </center>
</section>
