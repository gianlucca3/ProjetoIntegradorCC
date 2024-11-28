<?php
session_start();
$config = require 'c:/conn/conn.php';
$config = require 'c:/conn/conn.php';

$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);

// Verifica se o usuário está logado
if (!isset($_SESSION['cliente_email']) || $_SESSION['cliente_email'] == null) {
    header('Location: login.php');
    exit;
}

// Recupera os dados do usuário da sessão
$nome = $_SESSION['cliente_nome'];
$email = $_SESSION['cliente_email'];
$senha = $_SESSION['cliente_senha']; // Isso pode ser mascarado para exibição
$tel = isset($_SESSION['cliente_tel']) ? $_SESSION['cliente_tel'] : '';
$cpf = isset($_SESSION['cliente_cpf']) ? $_SESSION['cliente_cpf'] : '';
$end = isset($_SESSION['cliente_end']) ? $_SESSION['cliente_end'] : '';




/*
$query = "SELECT * FROM clientes WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$cliente = mysqli_fetch_assoc($result);
$_SESSION['cliente_end'] = $cliente['endereço'];
$_SESSION['cliente_email'] = $cliente['email'];
$_SESSION['cliente_cpf'] = $cliente['cpf'];
$_SESSION['cliente_tel'] = $cliente['telefone'];
$_SESSION['cliente_end'] = $cliente['endereco'];

*/



?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .perfil-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .perfil-container h1 {
            text-align: center;
        }
        .perfil-info {
            margin-bottom: 15px;
        }
        .perfil-info label {
            font-weight: bold;
        }
        .mensagem {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
			position: fixed;
			top: 10%; 
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: #f8d7da;
			border-radius: 5px; 
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="cpf"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .adicionar-campos {
            margin-top: 20px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        .adicionar-campos:hover {
            background-color: #0056b3;
        }
        .novo-campo {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f0f8ff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<!-- Contêiner do ícone de usuário -->
  <div class="user-container"
    <?php if (isset($_SESSION['cliente_email']) && $_SESSION['cliente_email'] != null): ?>
      onclick="irParaPerfil()" <!-- Redireciona para o perfil se logado -->
    <?php else: ?>
      onclick="irParaLogin()" <!-- Redireciona para login se não logado -->
    <?php endif; ?>
    <!-- Fechar o atributo da tag acima corretamente -->
    
    <div class="user-icon">
      <?php
      // Se o usuário estiver logado, exibe a primeira letra do nome
      if (isset($_SESSION['cliente_email']) && $_SESSION['cliente_email'] != null) {
          echo strtoupper(substr($_SESSION['cliente_nome'], 0, 1)); // Exibe a inicial do nome em maiúscula
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
        <a href="perfil.php">Olá, <?php echo htmlspecialchars($primeiroNome); ?></a> <!-- Exibe o primeiro nome -->
       
      <?php else: ?>
        <!-- Opção para usuários não logados -->
        <a href="login.php">Fazer Login</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    function irParaLogin() {
      window.location.href = 'login.php'; // Redireciona para a página de login
    }

    function irParaPerfil() {
      window.location.href = 'perfil.php'; // Redireciona para a página de perfil
    }
  </script>



<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="styles.css">
    <!-- Exibe a mensagem de erro ou sucesso, se existir -->
    <div id="mensagem" style="display: none;">
        <?php if (isset($_SESSION['mensagemSucesso'])): ?>
            <div class="mensagem" style="background-color: #f8d7da; color: #721c24;">
                <?php echo $_SESSION['mensagemSucesso']; ?>
            </div>
            <?php unset($_SESSION['mensagemSucesso']); ?>
        <?php elseif (isset($_SESSION['mensagemErro'])): ?>
            <div class="mensagem" style="background-color: #f8d7da; color: #721c24;">
                <?php echo $_SESSION['mensagemErro']; ?>
            </div>
            <?php unset($_SESSION['mensagemErro']); ?>
        <?php endif; ?>
    </div>

    <div class="perfil-container">
        <h1>Seu Perfil</h1>

        
        <!-- Formulário para Atualização -->
        <form action="atualizar_perfil.php" method="post">
            <div class="perfil-info">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            <div class="perfil-info">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="perfil-info">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" value="" placeholder="Nova senha (opcional)">
            </div>
			<div class="perfil-info">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($tel); ?>" placeholder="(XX) XXXXX-XXXX" maxlength="15">
                </div>
				<div class="perfil-info">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" placeholder="XXX.XXX.XXX-XX" maxlength="14">
                </div>
               

            <!-- Campos Adicionais -->
            <div class="adicionar-campos" onclick="mostrarCampos()">Adicionar Dados</div>
            <div class="novo-campo" id="novoCampo">
                <div class="perfil-info">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($tel); ?>" placeholder="(XX) XXXXX-XXXX" maxlength="15">
                </div>
                <div class="perfil-info">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" placeholder="XXX.XXX.XXX-XX" maxlength="14">
                </div>
                <div class="perfil-info">
                    <label for="endereco">Endereço:</label>
                    <textarea id="endereco" name="endereco" placeholder="Digite seu endereço"><?php echo htmlspecialchars($end) ?></textarea>
                </div>
            </div>

            <!-- Botão para Atualizar os dados -->
            <button type="submit">Atualizar</button>
        </form>

        <br>
        <a href="home.php">Sair</a>
    </div>

    <script>
        const mensagemDiv = document.getElementById('mensagem');
        if (mensagemDiv) {
            mensagemDiv.style.display = 'block';
            setTimeout(() => {
                mensagemDiv.style.display = 'none';
            }, 1500);
        }

        function mostrarCampos() {
            const novoCampo = document.getElementById('novoCampo');
            novoCampo.style.display = novoCampo.style.display === 'none' || novoCampo.style.display === '' ? 'block' : 'none';
        }
    </script>
</body>
</html>
