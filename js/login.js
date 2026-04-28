// login.js
const USUARIOS = [{ email: 'bia@empresa.com', senha: '123', nome: 'Bia' }];

document.getElementById('formulario-login').addEventListener('submit', (e) => {
    e.preventDefault(); // 1. Para o envio padrão
    
    const email = document.getElementById('email-input').value;
    const senha = document.getElementById('senha-input').value;

    // 2. Procura o usuário na lista
    const achou = USUARIOS.find(u => u.email === email && u.senha === senha);

    if (achou) {
        // 3. Salva os dados (incluindo o nome) no navegador
        localStorage.setItem('usuarioLogado', JSON.stringify(achou));
        window.location.href = 'menu.php'; // 4. Vai para o menu
    } else {
        alert("Erro!");
    }
});