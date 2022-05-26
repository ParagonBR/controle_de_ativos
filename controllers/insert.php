<?php
require_once('../Usuario.php');
$usuario = getUser();

$matricula = filter_input(INPUT_POST,'matricula',FILTER_VALIDATE_INT);
$nome = filter_input(INPUT_POST,'nome');
$motivo = filter_input(INPUT_POST,'motivo',FILTER_VALIDATE_INT);
$pa = filter_input(INPUT_POST,'pa');
$andar = filter_input(INPUT_POST,'andar');
$data = filter_input(INPUT_POST,'data');




$sql = "INSERT INTO	tb_baixa_ativos (responsavel,matricula,nome,motivo,andar,pa,data) 
values('$usuario','$matricula','$nome','$motivo','$andar','$pa','$data')";
$con = new FactoryConnection();

if($matricula && $usuario && $nome && $motivo && $pa && $data){
    $check = $con->execut($sql);
    if(!$check)
        header('HTTP/1.1 500 Erro em inserir, favor revisar dados');
    else
        echo json_encode("Dados inseridos");    
}
else{
    header('HTTP/1.1 500  Favor revisar dados');
}



// ?>