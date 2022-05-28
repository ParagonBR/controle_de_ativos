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
                await mostraTabela()
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


async function mostraTabela() {

    fetch('../baixa_ativos/controllers/getDadosUsuario.php')
        .then(resposta => resposta.text())
        .then(resultado => {
            if (resultado) {
                document.getElementById('tabela').innerHTML = resultado
                let table = new DataTable('#table-baixas', {
                    dom: 'Bfrtip',
                    buttons: ['copy', 'excel'],
                    "language": {
                        "url": "https://raw.githubusercontent.com/DataTables/Plugins/master/i18n/pt-BR.json"
                    }
                })
            }

        })

}
mostraTabela()

document.addEventListener('click', async (e) => {
    if (e.target.getAttribute('id') == 'editar_ativos') {
        console.log(e.target)
        jQuery.confirm({
            title: 'Editar Ativos',
            content: 'Simple confirm!',
            buttons: {
                confirm: function () {
                    jQuery.alert('Confirmed!');
                },
                cancel: function () {
                    jQuery.alert('Canceled!');
                },
            }
        });

    }

    if (e.target.getAttribute('id') == 'extrair') {
        e.preventDefault()
        let json = parseHTMLTableElem(document.getElementById('table-baixas'))
        let {
            data: resposta
        } = await axios.post('http://10.0.150.39:8000/api/json_to_xlsx', json, {
            responseType: 'blob'
        })
        console.log(resposta)
        downloadBlob(resposta)


    }
})


function downloadBlob(blob, nome_arquivo = 'Extração.xlsx') {
    // Convert your blob into a Blob URL (a special url that points to an object in the browser's memory)
    const blobUrl = URL.createObjectURL(blob);

    // Create a link element
    const link = document.createElement("a");

    // Set link's href to point to the Blob URL
    link.href = blobUrl;
    link.download = nome_arquivo;

    // Append link to the body
    document.body.appendChild(link);

    // Dispatch click event on the link
    // This is necessary as link.click() does not work on the latest firefox
    link.dispatchEvent(
        new MouseEvent('click', {
            bubbles: true,
            cancelable: true,
            view: window
        })
    );

    // Remove link from body
    document.body.removeChild(link);
}


function parseHTMLTableElem(tableEl) {
    const columns = Array.from(tableEl.querySelectorAll('th')).map(it => it.textContent)
    const rows = tableEl.querySelectorAll('tbody > tr')
    return Array.from(rows).map(row => {
        const cells = Array.from(row.querySelectorAll('td'))
        return columns.reduce((obj, col, idx) => {
            obj[col] = cells[idx].textContent
            return obj
        }, {})
    })
}


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

const getFormData = object => Object.keys(object).reduce((formData, key) => {
    formData.append(key, object[key]);
    return formData;
}, new FormData());