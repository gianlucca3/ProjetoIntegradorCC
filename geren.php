<?php

session_start();
// Verifica se o usuário está logado
if (isset($_SESSION['ger_email']) && $_SESSION['ger_email'] != null) {
    // Pega o nome do usuário da sessão
    $nomeUsuario = $_SESSION['ger_email']; // Aqui você pode ter o nome do usuário armazenado
    // Extrai a primeira letra do nome
    $primeiraLetra = strtoupper($nomeUsuario[0]);
} else {
    // Usuário não logado
    $primeiraLetra = '?'; // Ícone genérico para usuários não logados
}
// Inclui o arquivo de configuração do banco de dados
$config = require 'c:/conn/conn.php';

// Conectar ao banco de dados
$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Obtém a data e hora atual
$hoje = date('d/m/Y H:i:s');

// Configura o charset UTF-8
header('Content-Type: text/html; charset=utf-8');

// Verifica se o formulário foi enviado corretamente
if (empty($_POST['email']) || empty($_POST['senha'])) {
    echo "<script>
            alert('Por favor, preencha o e-mail e a senha!');
            window.location.href = 'estoque.php';
          </script>";
    exit;
}

// Função para registrar consultas na tabela de auditoria
function registrarAuditoria($usuario, $consulta, $tabela)
{global $conn;

$sql = "INSERT INTO acesso (usuario, consulta, data_hora, tabela_acessada) 
        VALUES ('$usuario', '$consulta', NOW(), '$tabela')";

if ($conn->query($sql) === TRUE) {
    //echo "Registro de acesso inserido com sucesso.";
} else {
    echo "Erro ao registrar o acesso: " . $conn->error;
}
}
// Captura os valores do formulário
$gerente = $_POST['email'];
$password = md5($_POST['senha']); // Senha criptografada com MD5

// Consulta para verificar o login do gerente
// Escapando as entradas para evitar SQL Injection
$gerente = $conn->real_escape_string($gerente);
$password = $conn->real_escape_string($password);

// Consulta direta
$sql = "SELECT * FROM gerencia WHERE email = '$gerente'";
$resultado = $conn->query($sql);




// Verifica se o usuário existe
if ($resultado && $resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $dbuser = $row['email'];
    $dbpassword = $row['senha'];

    // Valida o e-mail e a senha
    if ($gerente === $dbuser && $password === $dbpassword) {
        $_SESSION['autorizado'] = true;
        $_SESSION['ger_id'] = $row['id'];
        $_SESSION['ger_email'] = $row['email'];
        //echo "Login realizado com sucesso.";
    } else {
        echo "
		<script>
            alert('E-mail ou senha inválidos.!');
            window.location.href = 'ger.php';
          </script>";
		
		
		
		
		
		
    }
} else {
    echo "Usuário não encontrado.";
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
  <!-- Contêiner do ícone de usuário -->
  <div class="user-container" 
    <?php if (!isset($_SESSION['ger_email']) || $_SESSION['ger_email'] == null): ?>
      onclick="irParaLogin()"
    <?php endif; ?>>
    <div class="user-icon">
      <?php
      // Se o usuário estiver logado, exibe a primeira letra do nome
      if (isset($_SESSION['ger_email']) && $_SESSION['ger_email'] != null) {
          echo $primeiraLetra; // Exibe a inicial do nome
      } else {
          echo '?'; // Exibe um ícone padrão se o usuário não estiver logado
      }
      ?>
    </div>

    <!-- Menu suspenso para usuários logados -->
    <div class="dropdown-menu">
      <?php if (isset($_SESSION['ger_email']) && $_SESSION['ger_email'] != null): ?>
        <?php
    // Verifica se o nome está na sessão e pega o primeiro nome
    if (isset($_SESSION['ger_email']) && $_SESSION['ger_email'] != null) {
        $nomeCompleto = $_SESSION['ger_email'];
        $primeiroNome = explode(' ', $nomeCompleto)[0]; // Pega o primeiro nome
    }
    ?>
    <a href="#">Olá, <?php echo $primeiroNome; ?></a> <!-- Exibe o primeiro nome -->
      <?php else: ?>
        <!-- Opção para usuários não logados -->
        <a href="estoque.php">Fazer Login</a>
      <?php endif; ?>
    </div>
  </div>
<script>
    // A função será ativada quando pressionar a tecla F7
    document.addEventListener('keydown', function(event) {
        if (event.key === "F7") { // Se a tecla pressionada for F1
            window.location.href = "gerencia.php"; // Redireciona para a página de gerência da loja
        }
    });
</script>
<script>
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    function adicionarAoCarrinho(nome, preco) {
        const produto = { nome, preco };
        carrinho.push(produto);
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        alert(`${nome} foi adicionado ao carrinho!`);
    }

    function irParaLogin() {
      // Redireciona para a página de login
      window.location.href = 'ger.php';
    }
  </script>

  <header>
     <h2>Gerência</h2>
      <nav>
	    <ul>
            <li><a href="home.php">Loja</a></li>
            <li><a href="stok.php">Estoque</a></li>
           	<li><a href="visita.php">Acesso</a></li>
            </ul>
    </nav>
  </header>
  <main>
    <section id="catalogo">
        
        <div class="produtos">
            <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
            <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
                <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
                <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
            <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
                <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
			<div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div><div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
            <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
                <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
            <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
                <div >
                <img src="FlocoDeNeveLogo.jpg" alt="">
                
            </div>
               
            </div>
        </section>
    </main>

  <footer>
      <p>&copy; 2024 Padaria Flocos de Neve. Página para fins acadêmicos. NÃO REALIZE UMA COMPRA.</p>
  </footer>
  
  

  <script>
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

    function adicionarAoCarrinho(nome, preco) {
        const produto = { nome, preco };
        carrinho.push(produto);
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        alert(`${nome} foi adicionado ao carrinho!`);
    }

    function irParaLogin() {
      // Redireciona para a página de login
      window.location.href = 'estoque.php';
    }
  </script>
</body>
</html>
