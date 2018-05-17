<section id="sectionLogin">
	<h1>Registro de Usuário</h1>
	<center>
	<h3>Cadastro</h3><br><p>*Campos obrigatórios. Não deixe em branco.</p>
	<br><span class="progresso"></span>
	<form class="registroUser">
        <table>
            <tr>
              <td>Nome*</td><td><input type="text" name="nome" maxlength="100" flag="0"></td></tr>
              <tr>
              	<td>E-mail*</td>
              	<td><input type="text" name="usuario" id="email" maxlength="100" flag="0"></td>  
                <td><div class="cnfuser"></div></td>            
            </tr>
            <tr>
              <td>Confirme E-mail</td>
              <td><input type="text" id="confirmaemail" maxlength="100" flag="0"></td>
              <td><div class="cnfemail"></div></td>
            </tr>                       
            <tr><td>Senha*</td><td><input type="password" name="senha" id="senha" maxlength="12" flag="0"></td></tr>
            <tr>
              <td>Confirme Senha</td>
              <td><input type="password" id="confirmasenha" maxlength="12" flag="0"></td>
              <td><div class="cnfsenha"></div></td>
            </tr>
            <tr><td colspan="2" align="right"><input class="submeteX" type="button" id="salvar" value="Salvar" style="display:none;" /></td></tr>            
        </table>
        <input type="hidden" name="tbl" value="usuarios" />
        <input type="hidden" name="flag" value="addUser" />
        <input type="hidden" class="caminho" value="sys/crud.sys.php" />
        
	</form>
    <br><br><a class='regular-link' link="view/front/login.php">Voltar</a>
	</center>
</section>