
    
    
    // Verificamos se a lista tem algum produto (se for maior que zero)
    if (produtosAcabando.length > 0) {
        
        // Montamos a mensagem inicial do alerta
        var mensagemFinal = "⚠️ ATENÇÃO: ESTOQUE BAIXO! ⚠️\n\nOs seguintes produtos estão acabando:\n";
        
        // Fazemos um loop simples para adicionar cada produto na mensagem
        for (var i = 0; i < produtosAcabando.length; i++) {
            mensagemFinal = mensagemFinal + "- " + produtosAcabando[i] + "\n";
        }
        
        // Dispara o alerta na tela do usuário!
        alert(mensagemFinal);
    }