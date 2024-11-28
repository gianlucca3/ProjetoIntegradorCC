<?php
######################################################################
//GPT#https://chatgpt.com/share/6736bfb6-041c-800f-8121-6b1c3f2d8b45
// Inicia a sessão
session_start();

// Destrói todas as variáveis de sessão
session_unset();

// Destroi a sessão
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script src="carrinho.js" defer></script> <!-- Inclui o script do carrinho -->
</head>
<body>
    <script>
        // Aguarda o carregamento completo da página antes de chamar a função
        window.onload = function() {
            try {
                // Chama a função esvaziarCarrinho antes de redirecionar
                esvaziarCarrinho(); // Função definida em carrinho.js

                // Certifique-se de que a função foi chamada (opcional para depuração)
                console.log("Carrinho esvaziado com sucesso.");

                // Redireciona para a página index.php
                window.location.href = 'home.php';
            } catch (error) {
                // Se houver erro, exibe no console
                console.error("Erro ao esvaziar o carrinho ou redirecionar:", error);
                // Redireciona mesmo assim
                window.location.href = 'home.php';
            }
        }
    </script>
</body>
</html>
