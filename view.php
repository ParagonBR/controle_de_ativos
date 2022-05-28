<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.2/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.2/xlsx.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alasql@1.7.3/dist/alasql.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="../baixa_ativos/estilo.css">
</head>
<div class="conteudo">
    <form class="formulario" id="form">
        <div><label for="number">Matricula</label>
            <input class="campo form-control" type="text" name="matricula" id="matricula">
        </div>
        <div><label for="nome">Nome Completo</label>
            <input class="campo form-control" type="text" name="nome" id="nome">
        </div>
        <div><label for="motivo">Motivo</label>
            <select class="campo form-control" name="motivo" id="motivo">
                <option value=""></option>
            </select>
        </div>

        <div class="andar" >
        <label>Andar</label>
            <div class="radio">
               
                <div class="form-check">
                    <input class="form-check-input" type="radio" checked  name="andar" id="terreo" value="terreo">
                    <label class="form-check-label" for="terreo">
                        Térreo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="andar" id="1andar" value="1" >
                    <label class="form-check-label" for="1andar">
                        1º andar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="andar" id="2andar" value="2" >
                    <label class="form-check-label" for="2andar">
                        2º andar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="andar" id="3andar" value="3" >
                    <label class="form-check-label" for="3andar">
                        3º andar
                    </label>
                </div>
            </div>
        </div>
        <div><label for="pa">Localização</label>
            <input class="campo form-control" type="text" name="pa" maxlength="40" id="pa">
        </div>
        <div><label for="data">Data Incidente</label>
            <input class="campo form-control" type="date" name="data" id="data">
        </div>
        <div class="confirmar">
            <button  type="submit" id="registrar" class="btn btn-primary">Registrar</button>
        </div>
    </form>

</div>
<div class="conteudo">
    <h3 class="text-center" id="data_visu">Visualização</h3>
    <div id="tabela" class="text-center"></div>
</div>
<script src="../baixa_ativos/script.js"></script>