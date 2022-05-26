document.getElementById('form').addEventListener('submit', async (e) => {
    e.preventDefault()
    let formulario = Object.fromEntries(new FormData(e.target))
    formulario.nome = formulario.nome.toUpperCase()
    console.log(formulario)
    let erros = validacao(formulario)

    if (erros.length > 0) {
        let alerta = erros.join('\n')
        alert(alerta)
    } else {
        try {
            let form = getFormData(formulario)
            let resposta = await fetch('../baixa_ativos/controllers/insert.php', {
                method: "POST",
                body: form
            })
            if (resposta.status == 200) {
                let resultado = await resposta.json()
                alert(resultado)
                e.target.reset()
            } else {
                throw resposta.statusText
            }
        } catch (error) {
            alert(error)
        }

    }
})


document.getElementById('matricula').addEventListener('blur', async (e) => {
    let erros = []
    if (e.target.value == '') {
        erros.push("Matricula é um campo Obrigatório")
    } else if (/^[0-9]*$/.test(e.target.value) != true) {
        erros.push("Matricula deve conter apenas numeros")
    }
    if (erros.length > 0) {
        let alerta = erros.join('\n')
        alert(alerta)
    } else {

        try {
            let matricula = new FormData()
            matricula.append('matricula', e.target.value)
            let resposta = await fetch('../baixa_ativos/controllers/checkMatricula.php', {
                method: "POST",
                body: matricula
            })
            console.log(resposta)
            if (resposta.status == 200) {
                let resultado = await resposta.json()
                if (resultado.nome) {
                    document.getElementById('nome').value = resultado.nome
                }
            } else {
                throw resposta.statusText
            }
        } catch (error) {
            alert(error)
        }
    }
})




fetch('../baixa_ativos/controllers/getDadosUsuario.php')
    .then(resposta => resposta.text())
    .then(resultado => {
        if (resultado) {
            document.getElementById('tabela').insertAdjacentHTML('beforeend', resultado)
            let table = new DataTable('#table-baixas', {
                dom: 'Bfrtip',
                buttons: ['copy', 'excel'],
                "language": {
                    "url": "https://raw.githubusercontent.com/DataTables/Plugins/master/i18n/pt-BR.json"
                }
            })
        }

    })


document.addEventListener('click', (e) => {

    console.log(e.target)
})


fetch('../baixa_ativos/controllers/getMotivos.php')
    .then(resposta => resposta.json())
    .then(resultado => {
        document.getElementById('motivo')
            .insertAdjacentHTML('beforeend',
                resultado.map(motivo => `<option value="${motivo.id}">${motivo.motivo}</option>`).join(''))
    })


function validacao(formulario) {
    let erros = []
    if (formulario.matricula == '') {
        erros.push("Matricula é um campo Obrigatório")
    } else if (/^[0-9]*$/.test(formulario.matricula) != true) {
        erros.push("Matricula deve conter apenas numeros")
    }
    if (formulario.nome == '') {
        erros.push("Nome é um campo Obrigatório")
    }
    if (formulario.motivo == '') {
        erros.push("Motivo é um campo Obrigatório")
    }
    if (formulario.pa == '') {
        erros.push("Localização é um campo Obrigatório")
    }
    if (formulario.data == '') {
        erros.push("Data é um campo Obrigatório")
    }
    if (formulario.andar == '') {
        erros.push("Andar é um campo Obrigatório")
    }
    return erros
}

const getFormData = object => Object.keys(object).reduce((formData, chave) => {
    formData.append(chave, object[chave]);
    return formData;
}, new FormData());