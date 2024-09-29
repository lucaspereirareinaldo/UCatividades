const salvar = document.getElementById('modalbtn');
const Alerta = document.getElementById('alert');
const logar = document.getElementById('logar');

async function Insert() {
    const form = document.getElementById('formmodal');
    const formData = new FormData(form);
    const opt = {
        method: 'POST',
        body: formData
    };
    const response = await fetch('/insert', opt);
    const json = await response.json();
    return json;
}

async function insert() {
    Alerta.className = 'alert alert-info';
    Alerta.innerHTML = 'Salvando, aguarde por favor...'

    const response = await insert();
    if (response.status !== true) {
        Alerta.className = 'alert alert-danger'
        Alerta.innerHTML = response.msg
        setTimeout(() => {
            Alerta.className = 'alert alert-warning'
            Alerta.innerHTML = 'Todos os campos com <span class="text text-danger">*</span> são obrigatórios!';
        }, 2000);
        return
    }
    Alerta.className = 'alert alert-sucess';
    Alerta.innerHTML = response.msg
}
salvar.addEventListener('click', async (event) => {
    event.preventDefault();
    await Insert();
})