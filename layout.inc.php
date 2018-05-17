<!-- #================================================  SESSÃO DE TOPO ================================================# -->
<!-- #================================================  SESSÃO DE CONTEUDO ================================================# -->
<main>
	<div class="container-fluid">
    <div class="title">
      <h1>LV Desk</h1>
			<p>Informe seu login <br>para acessar o sistema</p>
    </div>

    <div class="login">
      <form action="#" method="post">
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
          <label for="pwd">Senha:</label>
          <input type="password" class="form-control" id="pwd" name="pwd">
        </div>
				<div class="form-group" id="esqueci">
					<a class="regular-link" link="reset.php" >Esqueci a minha senha</a>
				</div>
        <input class="btn btn-default" name="entrar" value="Entrar" type="submit">
      </form>
    </div>
	</div>
</main>
<!-- #==============================================  FIM DA SESSÃO DE CONTEÚDO ==============================================# -->
<footer>
<?php 
include_once("parametros.inc.php");
$copy = new Param();
$copyright = $copy->copyright();
echo "<center><p id='direto_copia'>$copyright</p></center>";
?>
</footer>