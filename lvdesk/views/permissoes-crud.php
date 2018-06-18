<?php
if(isset($_POST['id'])){
	//$sentenca = "SELECT * FROM privilegios WHERE lixo = 0 AND id='".$_POST['id']."'";	
	
	$edicao = $_POST;
	
	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$acessos 		= $edicao['acessos'];	
	$flag	 		= "update";
	
}else{ 
include("../controllers/model.inc.php");
$id 			= NULL;
$flag	 		= "add";
$foe = new Model;
$view = "SELECT * FROM modulos WHERE lixo = 0 AND admin = 0";
$qry = "SELECT * FROM privilegios WHERE lixo = 0";
$result = $foe->queryFree($qry);
}
?>
<div class="page-header-title">
	  <h4 class="page-title">Permissões</h4>
	  <p>Gerenciador das permissões de ações do sistema</p>
	</div>
	<div class="content-sized">
	<form id="form-modulo">
		<div class="form-group">
			<label for="nome">Nome do módulo</label>			
			<select class="form-control">
			<?php			
			while($array = $result->fetch_assoc()){
				echo "<option value='".$array['id']."'>".$array['nome']."</option>";
			}			
			?>
			</select>
		</div>
		<div class="form-group">
		  <label for="nome">Módulos Disponíveis</label>
		<?php
		$acessos = $foe->queryFree($view);
		if(isset($acessos)){
		  while($row = $acessos->fetch_assoc()){
			print_r(
			  '<div class="checkbox checkbox-primary">
				<input id="checkbox1" type="checkbox" data-parsley-multiple="group1" value="'.$row["id"].'">
				<label for="checkbox1">'.$row["nome"].'</label>
			  </div>
			');
		  }
		}else{  
		  echo "<br><h4><i class='ion-alert-circled'></i> Favor habilitar módulos</h4>";
		}
		?>
		</div>
		<input class="btn btn-default rtrn-conteudo" value="Salvar" type="button" objeto="form-modulo">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="permission_role" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	</form>
	
</div>