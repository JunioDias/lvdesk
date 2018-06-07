<?php
include("model.inc.php");
$sql = new Model();

$id = $_GET['id'];
$emailMd5 = $_GET['email'];
$uidMd5 = $_GET['uid'];
$dataMd5 = $_GET['key'];

$query = "SELECT * FROM usuarios WHERE id = '$id' AND lixo='0'";
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
    $query = "SELECT senha FROM usuarios WHERE lixo='0' AND id = '$id'";
    $sql->queryFree($query);
	$senha = $result->fetch_assoc();
    include("reset.inc.php");
}else{
    echo "<h1>Um erro inesperado aconteceu.<br>Por favor entre em contato com o suporte.</h1>";
}
?>