<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Loja de Eletrônicos</title>
</head>
<body>
    <h1>Login Loja de Eletrônicos</h1>
    
    <form id="formulario-login">

        <label for="email-input">Email</label>
        <input type="text" id="email-input" name="email" required>
        
        <label for="senha-input">Senha</label>
        <input type="password" id="senha-input" name="senha" required>
        
        <input type="submit" value="Login">
        
    </form>
    
    <div id="mensagem-erro" style="display: none; color: red; margin-top: 10px;"></div>

    <script src="../js/login.js"></script>
</body>
</html>