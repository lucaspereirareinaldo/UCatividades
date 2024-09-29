const login = document.getElementById('salvarbtn');

async function Login() {
    try {
        const form = document.getElementById('form');
        const formData = new FormData(form);

        // Log para verificar o conteúdo do FormData
        console.log('Dados do formulário:', ...formData.entries());

        const opt = {
            method: 'POST',
            body: formData
        };

        // Verificando a configuração do fetch
        console.log('Opções da requisição:', opt);

        // Iniciando o fetch e capturando erros
        const response = await fetch('/autenticacao', opt);

        // Verificando a resposta antes de converter para JSON
        console.log('Resposta da requisição:', response);

        if (!response.ok) {
            // Se a resposta não for bem-sucedida (status code >= 400), lance um erro
            throw new Error(`Erro de rede: ${response.status} - ${response.statusText}`);
        }

        const json = await response.json();

        // Verificando o conteúdo do JSON recebido
        console.log('Resposta JSON:', json);

        if (!json.status) {
            alert(json.msg);  // Mostra a mensagem de erro
            return;
        }

        alert('Usuário logado com sucesso!');
    } catch (error) {
        // Captura e exibe qualquer erro que ocorrer durante a requisição
        console.error('Erro durante a requisição:', error);
        alert('Ocorreu um erro durante a requisição. Verifique o console para mais detalhes.');
    }
}

login.addEventListener('click', async (event) => {
    event.preventDefault(); // Impede o comportamento padrão do botão
    await Login();
});
