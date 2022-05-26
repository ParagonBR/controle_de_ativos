<?php


require_once("../FactoryConnection.php");

$query = New FactoryConnection();

$consulta = "SELECT * from tb_motivos_baixa_registro";
$resultado = $query->executQueryDML($consulta);
if ($resultado){
    echo json_encode($query->executQueryDML($consulta));
}
else{
    header("HTTP/1.1 404 Nao Encontrado");
}