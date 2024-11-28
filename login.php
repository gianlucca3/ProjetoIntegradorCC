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



// Captura a URL da página de onde o login foi solicitado
$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home.php';


// Salva a URL para redirecionar após o login
//$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  	<title>Login - Padaria Flocos de Neve</title>
    <link rel="stylesheet" href="styles.css">
	
</head>
<body>
    <header>
         <nav>
            <ul>
                <li><a href="home.php">Início</a></li>
                <li><a href="cad.php">Cadastro</a></li>
				<li><a href="about.php">Sobre</a></li>
            </ul>
        </nav>
    </header>

</head>
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
	
    <main> 
	<TABLE CLASS="tabelaLogin" cellpadding="1"  cellspacing="1" ALIGN="center"  width="385"  style="border-collapse:collapse;">
       <td> <h2><CENTER>Login do Cliente</CENTER></h2>
       
		 <form method="post" action="log9.php">
		 <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
      
            <label for="email">E-mail:
			
            <input type="email" id="email" name="email" required style="
           display: inline-block;
           width: 100%; /* Usa toda a largura disponível no contêiner */
           max-width: 300px; /* Limita o tamanho máximo do botão */
           padding: 10px; /* Espaçamento interno */
           font-size: 12px; /* Tamanho do texto ajustado */
           text-align: center; /* Centraliza o texto */
           box-sizing: border-box; /* Inclui padding na largura total */
           margin: 5px auto; /* Centraliza o botão horizontalmente */
           overflow: hidden; /* Impede estouro do conteúdo */
           white-space: nowrap; /* Impede quebra de linha dentro do botão */
           word-wrap: normal; /* Mantém o texto em uma linha */
       ">
            </label>
            <label for="password">Senha:
            <input type="password" id="password" name="password"  required style="
           display: inline-block;
           width: 100%; /* Usa toda a largura disponível no contêiner */
           max-width: 300px; /* Limita o tamanho máximo do botão */
           padding: 10px; /* Espaçamento interno */
           font-size: 12px; /* Tamanho do texto ajustado */
           text-align: center; /* Centraliza o texto */
           box-sizing: border-box; /* Inclui padding na largura total */
           margin: 5px auto; /* Centraliza o botão horizontalmente */
           overflow: hidden; /* Impede estouro do conteúdo */
           white-space: nowrap; /* Impede quebra de linha dentro do botão */
           word-wrap: normal; /* Mantém o texto em uma linha */
       "></label></td>
            
         <tr>
    <td>
        <div style="text-align: center;">
            <input type="submit" value="Entrar" class="btn-primary" style="display: inline-block; margin-right: 10px;">
            <input type="button" value="Logout" class="btn-primary" onClick='window.location.href="out.php"' style="display: inline-block;">
        </div>
    </td>
	    
         <tr>
    <td>
        <div style="text-align: center;">
			<div style="text-align: center;">
    <a href="#" onclick="window.location.href='cads.php?email=' + document.getElementById('email').value;">Esqueci a senha</a>
</div>

    </td>
	
	
	
</tr> </table>
		  </table>
		 
		 
        </form>
		<div id="mensagem" style="display: none; position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); background-color: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);"><?= htmlspecialchars($_GET['erro'] ?? '') ?></div>

    </main>

    <footer>
        <p>&copy; 2024 Padaria Flocos de Neve</p>
    </footer>
	
	<script>
        // Exibe a mensagem de erro se existir
        const mensagemDiv = document.getElementById('mensagem');
        if (mensagemDiv.innerText.trim() !== '') {
            mensagemDiv.style.display = 'block';

            // Oculta a mensagem após 1.3 segundos
            setTimeout(() => {
                mensagemDiv.style.display = 'none';
            }, 1500);
        }
    </script>
</body>
</html>
