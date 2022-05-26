<?php
require_once('../Usuario.php');
$usuario = getUser();

$query = New FactoryConnection();
if($usuario == 'a' || $usuario == 'b' || $usuario == 'c'){
$consulta_baixas="SELECT (SELECT display_name from wp_users wp where responsavel =wp.user_login limit 1) as RESPONSAVEL,
MATRICULA,
NOME,(SELECT MOTIVO FROM tb_motivos_baixa_registro tm WHERE tm.id =tb.motivo ) AS motivo,
tb.pa AS localização,tb.`data` AS data_incidente,tb.andar,date(tb.data_registro)   as data_registro
FROM tb_baixa_ativos tb";
$consulta = "SELECT andar,(quantidade - (select count(*) from tb_baixa_ativos ta where tc.andar = ta.andar)) as quantidade, data as data_controle  from controle_ativos tc";
$resultado = $query->executQueryDML($consulta);
if ($resultado){



?>
<div class="gerencial">
<table id="tab_gerencial" class="table table-sm">
    <thead>
        <tr>
            <th style="font-size:1.1rem">Andar</th>
            <th style="font-size:1.1rem">Quantidade</th>
            <th style="font-size:1.1rem">Data Referência</th>
        </tr>
    </thead>
    <tbody>
            <?php
                foreach($resultado as $resultado){
                echo '
                <tr>
                    <td style="font-size:1.1rem" scope="row">'.$resultado['andar'].'</td>
                    <td style="font-size:1.1rem">'.$resultado['quantidade'].'</td>
                    <td style="font-size:1.1rem">'.$resultado['data_controle'].'</td>
                </tr>';
                }
       
        ?>
    </tbody>
</table>
<button type="button" id="editar_ativos" class="btn btn-primary">Editar</button>
</div>
<h4>Baixas</h4>
<?php
        }
        
    }
    else{
        $consulta_baixas="SELECT RESPONSAVEL,
        MATRICULA,
        NOME,(SELECT MOTIVO FROM tb_motivos_baixa_registro tm WHERE tm.id =tb.motivo ) AS motivo,
        tb.pa AS localização,tb.`data` AS data_incidente,tb.andar,date(tb.data_registro) as data_registro
        FROM tb_baixa_ativos tb where RESPONSAVEL = '$usuario'";
    }
       ?> 
<table id= "table-baixas"class="table table-sm">
    <thead>
        <tr>
            <th>RESPONSAVEL PELO REGISTRO</th>
            <th>MATRICULA</th>
            <th>NOME COMPLETO</th>
            <th>MOTIVO</th>
            <th>ANDAR</th>
            <th>LOCALIZAÇÃO</th>
            <th>DATA INCIDENTE</th>
            <th>DATA DO REGISTRO</th>
        </tr>
    </thead>
    <tbody>
     
    <?php
   
        $resultado = $query->executQueryDML($consulta_baixas);     

        foreach($resultado as $resultado){
                echo '
                <tr>
                    <td style="font-size:16px">'.$resultado['RESPONSAVEL'].'</td>
                    <td style="font-size:16px">'.$resultado['MATRICULA'].'</td>
                    <td style="font-size:16px">'.$resultado['NOME'].'</td>
                    <td style="font-size:16px">'.$resultado['motivo'].'</td>
                    <td style="font-size:16px">'.$resultado['andar'].'</td>
                    <td style="font-size:16px">'.$resultado['localização'].'</td>
                    <td style="font-size:16px">'.$resultado['data_incidente'].'</td>
                    <td style="font-size:16px">'.$resultado['data_registro'].'</td>
                </tr>';
                }
        ?>
    </tbody>
</table>
