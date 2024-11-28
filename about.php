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
    <title>Sobre - Padaria Flocos de Neve</title>
    <link rel="stylesheet" href="styles.css">
</head>
<script>
    // A função será ativada quando pressionar a tecla F7
    document.addEventListener('keydown', function(event) {
        if (event.key === "F7") { // Se a tecla pressionada for F1
            window.location.href = "gerencia.php"; // Redireciona para a página de gerência da loja
        }
    });
</script>

 <script>
  function irParaLogin() {
      // Redireciona para a página de login
      window.location.href = 'login.php';
    }
  </script>
<body>
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
       
        <nav>
            <ul>
                <li><a href="home.php">Início</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="cad.php">Cadastro</a></li>
                <li><a href="about.php">Sobre</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Sobre Este Projeto</h2>
       
        <h3>
        <p><strong> Diomar Duarte de Moraes</p>
		<p><strong> Gabriel Martins Barbosa</p>
		<p><strong> Gian Lucca Gonçalves Viana</p>
		<p><strong> Habib André Machado do Nascimento</p>
		<p><strong> Kayo Henrique</p>
		<p><strong> Renata Dantas </p>
		
        <p><strong>Ciência da Computação</strong></p>
		<p><strong>Universidade Cruzeiro do Sul</strong></p> </h3>
		
    </main>

	
	
    <footer>
        <p>&copy; 2024 Padaria Flocos de Neve</p>
    </footer>
</body>
</html>
