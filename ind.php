<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['cliente_email']) && $_SESSION['cliente_email'] != null) {
    // Pega o nome do usuário da sessão
    $nomeUsuario = $_SESSION['cliente_email']; // Aqui você pode ter o nome do usuário armazenado
    // Extrai a primeira letra do nome
    $primeiraLetra = strtoupper($nomeUsuario[0]);
} else {
    // Usuário não logado
    $primeiraLetra = '?'; // Ícone genérico para usuários não logados
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padaria Flocos de Neve</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    
  </style>
</head>
<body>
  

  <header>
    <h2>Padaria Flocos de Neve</h2>
    
  </header>

  

</body>
</html>
