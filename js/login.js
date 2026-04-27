// AQUI ESTÁ A LISTA FIXA DE USUÁRIOS
const USUARIOS_PERMITIDOS = [
    { email: 'vitor@empresa.com', senha: '123456', nome: 'Vitor' },
    { email: 'bia@empresa.com', senha: '123456', nome: 'Bia' },
    { email: 'gideao@empresa.com', senha: '123456', nome: 'Gideao' }
];

// --- Configurações e Variáveis ---
const FORMULARIO = document.getElementById('formulario-login');
const MENSAGEM_ERRO = document.getElementById('mensagem-erro');

// --- Função que executa a regra de negócio de ERRO ---
function lidarComFalha(motivoDaFalha) {
    // 1. Informar ao usuário o motivo da falha
    alert(`FALHA DE AUTENTICAÇÃO: ${motivoDaFalha}`);
    
    if(MENSAGEM_ERRO) {
        MENSAGEM_ERRO.textContent = motivoDaFalha;
        MENSAGEM_ERRO.style.display = 'block'; // Torna a mensagem visível
    }
}

// --- Função Principal: Tratamento do Envio do Formulário ---
if (FORMULARIO) {
    FORMULARIO.addEventListener('submit', function(evento) {
        evento.preventDefault(); 
        
        const emailInput = document.getElementById('email-input');
        const senhaInput = document.getElementById('senha-input');

        if (!emailInput || !senhaInput) {
            console.error("Campos de email/senha não encontrados no DOM.");
            return;
        }
        
        const emailDigitado = emailInput.value;
        const senhaDigitada = senhaInput.value;

        // VERIFICAÇÃO COM A LISTA:
        const usuarioEncontrado = USUARIOS_PERMITIDOS.find(usuario => 
            usuario.email === emailDigitado && usuario.senha === senhaDigitada
        );

        if (usuarioEncontrado) {
            // 1. Caso de Sucesso:
            localStorage.setItem('usuarioLogado', JSON.stringify(usuarioEncontrado));
            alert(`Bem-vindo(a), ${usuarioEncontrado.nome}! Redirecionando...`);
            
            // ---> AQUI ESTÁ A MAGIA: Redireciona para a página menu.php <---
            window.location.href = 'menu.php';
            
        } else {
            // 2. Caso de Falha:
            const motivo = "Credenciais inválidas. Verifique seu e-mail e senha."; 
            lidarComFalha(motivo);
        }

        // Reseta os campos após tentativa
        emailInput.value = '';
        senhaInput.value = '';
    });
}

// ESTILIZACAO DO PERFIL DO USUARIO (Revisado para buscar do localStorage)
document.addEventListener('DOMContentLoaded', (event) => {
    // 1. Elementos do DOM
    const iconeUsuario = document.getElementById('icone-usuario');
    const infoPainel = document.getElementById('info-usuario');
    const displayNome = document.getElementById('display-nome');
    const displayEmail = document.getElementById('display-email');

    // Verifica se os elementos cruciais existem
    if (!iconeUsuario || !infoPainel || !displayNome || !displayEmail) {
        return;
    }

    // 2. Função para carregar os dados e alternar a exibição
    function atualizarEExibirInfo() {
        const usuarioJson = localStorage.getItem('usuarioLogado');
        let usuarioLogado = null;

        if (usuarioJson) {
            try {
                usuarioLogado = JSON.parse(usuarioJson);
            } catch (e) {
                console.error("Erro ao fazer parse do usuário no localStorage", e);
            }
        }

        const nome = usuarioLogado ? usuarioLogado.nome : "Usuário Desconhecido (Faça Login)";
        const email = usuarioLogado ? usuarioLogado.email : "N/A";

        displayNome.textContent = nome;
        displayEmail.textContent = email;

        // 3. Alterna a visibilidade do painel (como um "toggle")
        const isVisible = infoPainel.style.display === 'block';
        
        if (isVisible) {
            infoPainel.style.display = 'none'; // Esconde
        } else {
            infoPainel.style.display = 'block'; // Mostra
        }
    }

    // 4. Adiciona o evento de clique ao ícone
    iconeUsuario.addEventListener('click', atualizarEExibirInfo);
});