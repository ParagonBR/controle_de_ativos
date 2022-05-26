<?php


require_once("../FactoryConnection.php");

$query = New FactoryConnection();

$consulta = "SELECT quantidade, data as data_controle from controle_ativos";
$resultado = $query->executQueryDML($consulta);
if ($resultado){
    echo json_encode($query->executQueryDML($consulta));
}
else{
    header("HTTP/1.1 404 Nao Encontrado");
}