<?php
include("../controllers/model.inc.php");
include("../controllers/actions.inc.php");
$foe = new Model();
$bot = new Acoes();
global $woo;
global $modulos;
global $acessos;
global $row;
$retorno = ".content-sized";
$view = "SELECT id, nome FROM modulos WHERE lixo = 0 AND admin = 0";
$modulos = $foe->queryFree($view);
if(isset($_POST['id'])){
	
	$query = "SELECT * FROM privilegios WHERE lixo = 0 AND id='".$_POST['id']."'";	
	$woo = $foe->queryFree($query);
	$edicao = $woo->fetch_assoc();

	$id		   		= $edicao['id'];
	$nome			= $edicao['nome'];
	$acessos 		= explode("#", $edicao['acessos']);	
	$flag	 		= "update";
	
}else{ 
	$qry = "SELECT * FROM privilegios WHERE lixo = 0";
	$id 			= NULL;
	$flag	 		= "add";	
	$result = $foe->queryFree($qry);
	
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
		<div class="form-group">
		  <label for="nome">Módulos Disponíveis</label>
		<?php	
		$row = NULL;
		if($modulos){
			while($rowd = $modulos->fetch_assoc()){			 
				foreach($rowd as $key => $value){				
					if(isset($row[$key])){
						$row[$key] = $value;
					}else{
						$row[$key] = $value;
					}
				}
				if(isset($acessos)){
					#print_r($acessos);
					$i = 0;
					echo  ("
					  <div class='checkbox checkbox-primary'>
						<input id='checkbox".$row['id']."' type='checkbox' data-parsley-multiple='group1' name='acessos[]' value='".$row['id']."' ");
						
						foreach($acessos as $value){
							if($row['id'] == $value)
								echo 'checked';
						}
						
						echo " >
						<label for='checkbox".$row['id']."'>".$row['nome']."</label>
					  </div>
					";
					$i++;
				}else{ 		
					$i = 0;
					echo  ("
					  <div class='checkbox checkbox-primary'>
						<input id='checkbox".$row['id']."' type='checkbox' data-parsley-multiple='group1' name='acessos[]' value='".$row['id']."' >
						<label for='checkbox".$row['id']."'>".$row['nome']."</label>
					  </div>
					");
					$i++;
				}
			}
		}else{
			while($row = $modulos->fetch_assoc()){
				echo  ("
				  <div class='checkbox checkbox-primary'>
					<input id='checkbox".$row['id']."' type='checkbox' data-parsley-multiple='group1' name='acessos[]' value='".$row['id']."' >
					<label for='checkbox".$row['id']."'>".$row['nome']."</label>
				  </div>
				");
			}
		}			
	   
		?>
		</div>
		<input class="btn btn-default rtrn-conteudo" doZero='1' value="Salvar" type="button" objeto="form-modulo">
	<?php 
	if(isset($id)){
		echo "<input type='hidden' name='id' value='$id'/>";
	}
	?>
	<input type="hidden" name="chave_cerquilha" value="on" />
	<input type="hidden" name="flag" value="<?= $flag;?>" />
    <input type="hidden" name="tbl" value="privilegios" />
    <input type="hidden" name="caminho" value="controllers/sys/crud.sys.php" />
	<input type="hidden" name="retorno" value="<?= $retorno;?>" />
	</form>
	
</div>