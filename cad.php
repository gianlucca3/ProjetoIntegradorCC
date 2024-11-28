<?php
session_start();
// Inicia a sessão

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Login - Padaria Flocos de Neve</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Contêiner do ícone de usuário -->
  <div class="user-container" 
    <?php if (!isset($_SESSION['cliente_email']) || $_SESSION['cliente_email'] == null): ?>
      onclick="irParaLogin()"
    <?php endif; ?>>
    <div class="user-icon">
      <?php
      // Se o usuário estiver logado, exibe a primeira letra do nome
      if (isset($_SESSION['cliente_email']) && $_SESSION['cliente_email'] != null) {
          echo $primeiraLetra; // Exibe a inicial do nome
      } else {
          echo '?'; // Exibe um ícone padrão se o usuário não estiver logado
      }
      ?>
    </div>

    <!-- Menu suspenso para usuários logados -->
    <div class="dropdown-menu">
      <?php if (isset($_SESSION['cliente_email']) && $_SESSION['cliente_email'] != null): ?>
        <?php
    // Verifica se o nome está na sessão e pega o primeiro nome
    if (isset($_SESSION['cliente_nome']) && $_SESSION['cliente_nome'] != null) {
        $nomeCompleto = $_SESSION['cliente_nome'];
        $primeiroNome = explode(' ', $nomeCompleto)[0]; // Pega o primeiro nome
    }
    ?>
    <a href="#">Olá, <?php echo $primeiroNome; ?></a> <!-- Exibe o primeiro nome -->
      <?php else: ?>
        <!-- Opção para usuários não logados -->
        <a href="login.php">Fazer Login</a>
      <?php endif; ?>
    </div>
  </div>




    <header>
        
	<script>
        function abrirPopup(e) {
            e.preventDefault(); // Impede o comportamento padrão do formulário

            // Pega o formulário
            const form = document.getElementById('meuFormulario');

            // Constrói os parâmetros de URL a partir dos dados do formulário
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            // Abre uma nova janela pop-up
            const popup = window.open('', 'popupWindow', 'width=600,height=400');
tmot = setTimeout(function(){myWindow.self.close();}, 5000);
            // Envia os dados do formulário via GET (ou pode-se usar POST)
            popup.location.href = form.action + '?' + params;
        }
		
		
    function irParaLogin() {
      // Redireciona para a página de login
      window.location.href = 'login.php';
    }
		
		
		
    </script>
        <nav>
            <ul>
                <li><a href="home.php">Início</a></li>
                <li><a href="perfil.php">Atualizar</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form id="meuFormulario" action="log7.php" method="POST">
            <table class="tabelaLogin" cellpadding="1" cellspacing="1" align="center" width="385" style="border-collapse:collapse;">
                <tr>
                    <td><h2><center>Cadastro de Usuário</center></h2></td>
                </tr>
                <tr>
                    <td><center>
                        <label for="name">Nome:
                        <input type="text" id="name" name="name"  required class="input-text">
                    </td>
                </tr>
                <tr>
                    <td><center>
                        <label for="email">E-mail:
                        <input type="email" id="email" name="email" required class="input-text">
                    </td>
                </tr>
                <tr>
                    <td><center>
                        <label for="password">Senha:
                        <input type="password" id="password" name="password" required class="input-text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Cadastrar" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Padaria Flocos de Neve</p>
    </footer>
</body>
</html>