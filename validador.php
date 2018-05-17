<?php
include("model.inc.php");
$sql = new Model();

$id = $_GET['id'];
$emailMd5 = $_GET['email'];
$uidMd5 = $_GET['uid'];
$dataMd5 = $_GET['key'];

$query = "SELECT * FROM usuarios WHERE id = '$id'";
$sql->queryFree($query);
$rs = $result->fetch_assoc();
/*echo $query."<br>";
print_r($result);*/

$valido = true;
if($emailMd5 !== md5($rs['usuario']))
    $valido = false;

if($uidMd5 !== md5($rs['uid']))
    $valido = false;

if($dataMd5 !== md5($rs['data_ts']))
    $valido = false;

if($valido === true) {
    $query = "UPDATE usuarios SET lixo='0' WHERE id = '$id'";
    $sql->queryFree($query);
    echo "<h3>Cadastro ativado com sucesso!</h3>";
}else{
    echo "<h3>Não foi possível ativar o cadastro.</h3>";
}

?>