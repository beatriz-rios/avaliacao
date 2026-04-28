// logout.js
document.addEventListener('DOMContentLoaded', () => {
    // 1. Pega o "texto" que salvamos no login
    const dadosSalvos = localStorage.getItem('usuarioLogado');

    if (dadosSalvos) {
        // 2. Transforma o texto de volta em objeto
        const usuario = JSON.parse(dadosSalvos);
        
        // 3. Coloca o nome dentro do <span> do HTML
        document.getElementById('nome-usuario').textContent = usuario.nome;
    } else {
        // 4. Se não tiver nada salvo, expulsa para o login
        window.location.href = 'login.php';
    }
});

// Função para o botão Sair
function sair() {
    localStorage.removeItem('usuarioLogado'); // Apaga a memória
    window.location.href = 'login.php';       // Volta ao início
}