<?php


require_once("../FactoryConnection.php");

$query = New FactoryConnection();

$matricula = filter_input(INPUT_POST,'matricula');

$consulta = "SELECT nome from tb_base_funcionarios where Matricula = '$matricula'";
$resultado = $query->executQueryDML($consulta);
if ($resultado){
    echo json_encode($query->executQueryDML($consulta)[0]);
}
else{
    header("HTTP/1.1 404 Nao Encontrado");
}