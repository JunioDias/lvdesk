<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");
$a = new Model();
$bot = new Acoes();
global $woo;
global $acessos;
global $row;

if(isset($_POST['id'])){
	
	$query = "SELECT * FROM privilegios WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$woo = $a->queryFree($query);
	$edicao = $woo->fetch_assoc();

	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$acessos 		= explode("#", $edicao['acessos']);	
	$acessos_menus	= explode("#", $edicao['acessos_menus']);	
	$flag	 		= "update";
	
}else{ 
	$qry = "SELECT * FROM privilegios WHERE lixo = 0";
	$id 			= NULL;
	$flag	 		= "add";	
	$result = $a->queryFree($qry);
	
	echo '
	<div class="page-header-title">
	  <h4 class="page-title">Papéis</h4>
	  <p>Gerenciador dos papéis do sistema</p>
	</div>
	<div class="content-sized">
	';
}
?>
	<form id="form-modulo">
		<div class="form-group">
			<label for="nome">Nome do módulo</label>			
			<select class="form-control" name="nome">
			<?php			
			if(isset($nome)){
			  	echo "<option value='".$nome."'>".$nome."</option>";
			}else{				
			  while($array = $result->fetch_assoc()){
				echo "<option value='".$array['nome']."'>".$array['nome']."</option>"; 
			  }
			}			  
			?>
			</select>
		</div>
		<div class="row">
			<div class="form-group col-sm-6">
			  <label for="nome">Módulos Disponíveis</label>
			<?php	
			$query = "SELECT * FROM modulos WHERE lixo = 0 ORDER BY id ASC";
			$resultado = $a->queryFree($query);
			if(isset($resultado)){
				while($linhas = $resultado->fetch_assoc()){					
					echo  "
					  <div class='checkbox checkbox-success'>
					  <input type='checkbox' name='acessos[]' id='modulo_".$linhas['id']."' value='".$linhas['id']."' ";
					  
					  if(isset($_POST['id'])){
						  foreach($acessos as $value){
							  if($linhas['id'] == $value)
								  echo "checked";
						  }	
					  }								  
					  
					echo " /><label for='modulo_".$linhas['id']."'> ".$linhas['nome']."</label></div>";
				}
			}else{
				echo "<option>Nenhum registro encontrado</option>";					
			}
			?>
			</div>
			<div class="form-group col-sm-6">
			  <label for="nome">Menus Habilitados</label>
			<?php	
			$query = "SELECT * FROM menus WHERE lixo = 0 ORDER BY id ASC";
			$resultado = $a->queryFree($query);
			if(isset($resultado)){
				while($linhas = $resultado->fetch_assoc()){					
					echo  "
					  <div class='checkbox checkbox-info'>
					  <input type='checkbox' name='acessos_menus[]' id='menu_".$linhas['id']."' value='".$linhas['id']."' ";
					  
					  if(isset($_POST['id'])){
						  foreach($acessos_menus as $value){
							  if($linhas['id'] == $value)
								  echo "checked";
						  }	
					  }								  
					  
					echo " /><label for='menu_".$linhas['id']."'> ".$linhas['nome']."</label></div>";
				}
			}else{
				echo "<option>Nenhum registro encontrado</option>";					
			}
			?>  
			</div>  
		</div>
		<input class="btn btn-default rtrn-conteudo" doZero='1' value="Salvar" type="button" objeto="form-modulo">
	<?=(isset($id) ? "<input type='hidden' name='id' value='$id'/>" : ""); ?>
	<input type="hidden" name="chave_cerquilha" value="on" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="privilegios" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	<input type="hidden" name="retorno" value=".content-sized" />
	</form>
	
</div>