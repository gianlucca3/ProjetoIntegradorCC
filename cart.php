<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['cliente_email']) || $_SESSION['cliente_email'] == null) {
    // Redireciona para o login caso o usuário não esteja logado
    header("Location: login.php?mensagem=por_favor_faca_login");
    exit;
}

// Pega o nome do usuário da sessão
$nomeUsuario = $_SESSION['cliente_email']; 
$primeiraLetra = strtoupper($nomeUsuario[0]);

// Verifica se o nome completo está na sessão para exibir o primeiro nome
if (isset($_SESSION['cliente_nome'])) {
    $nomeCompleto = $_SESSION['cliente_nome'];
    $primeiroNome = explode(' ', $nomeCompleto)[0]; // Pega o primeiro nome
} else {
    $primeiroNome = 'Visitante';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Padaria Flocos de Neve</title>
    <link rel="stylesheet" href="styles.css">
    <script src="carrinho.js" defer></script>
<style>
  .input-quantity {
      display: flex; /* Alinha os elementos na horizontal */
      align-items: center; /* Centraliza verticalmente */
      justify-content: center; /* Centraliza horizontalmente */
      gap: 2px; /* Espaçamento mínimo entre os elementos */
      width: fit-content; /* A largura será somente o necessário para os filhos */
      margin: 0 auto; /* Garante centralização no pai, se necessário */
  }

  .input-text {
      text-align: center;
      width: 5px; /* Reduz largura para manter compacto */
      padding: 2px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
  }
 input[type="number"] {
    width: 30px; /* Largura menor do campo */
    text-align: center; /* Centraliza o valor inserido */
    padding: 5px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    -moz-appearance: textfield; /* Remove setas no Firefox */
    -webkit-appearance: none; /* Remove setas no Chrome/Safari */
    appearance: none; /* Remove setas no Edge */
}

/* Remove as setas nos navegadores baseados no WebKit */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}


  .btn-quantidade {
      width: 30px; /* Tamanho reduzido */
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      background-color:  #f8c471; 
      border: 1px solid #ccc;
      border-radius: 4px;
      cursor: pointer;
  }

  .btn-quantidade:hover {
      background-color: #e0e0e0;
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
        <a href="logout.php">Sair</a> <!-- Opção para logout -->
      <?php else: ?>
        <!-- Opção para usuários não logados -->
        <a href="login.php">Fazer Login</a>
      <?php endif; ?>
    </div>
  </div>
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


    <header>
        <nav>
            <ul>
                <li><a href="home.php">Início</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="cad.php">Cadastro</a></li>
                <li><a href="array.php">Pedidos</a></li>
                <li><a href="about.php">Sobre</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Seu Carrinho de Compras</h2>
        <div class='protutos' id="carrinho">
            <p><center>	Nenhum item no carrinho.<center>
			</p>
        </div>

        <h3>Total: R$ <span id="total">0.00</span></h3>

        <button onclick="esvaziarCarrinho()">Esvaziar Carrinho</button>
		
        <button id="finalizarCompra" >Finalizar Compra</button>
       
        <div id="metodoPagamento" style="display:none;">
            <h3>Escolha o método de pagamento:</h3>
            <button onclick="mostrarFormulario('PIX')">PIX</button>
            <div id="fiscal" style="display:none;">
                <button id="btnLink">Recibo</button>
            </div>
            <button onclick="mostrarFormulario('CARTAO')">Cartão de Crédito/Débito</button>
        </div>

        <div id="formularioPagamento" style="display:none;">
            <h3 id="tituloPagamento"></h3>
            <div id="camposCartao" style="display:none;">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" required>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" required>
                <label for="numeroCartao">Número do Cartão:</label>
                <input type="text" id="numeroCartao" required>
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" required>
                <label for="dataVencimento">Data de Vencimento:</label>
                <input type="text" id="dataVencimento" required>
                <button onclick="finalizarCompra()">Completar Compra</button>
            </div>
        </div>
    </main>
	 <div id="mensagem" style="display: none; position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); background-color: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">

 
     <script>
	 if (carrinho.length === 0) { // Verifica se o carrinho está vazio
        // Exibe mensagem de erro
        const mensagemDiv = document.getElementById('mensagem');
        mensagemDiv.innerText = 'O carrinho está vazio! Por favor, adicione itens antes de finalizar.';
        mensagemDiv.style.display = 'block';

        // Esconde a mensagem após 3 segundos
        setTimeout(() => {
            mensagemDiv.style.display = 'none';
        }, 3000);
      
    }	
	 
    </script>
   
    <footer>
        <p>&copy; 2024 Padaria Flocos de Neve. Página para fins educacionais. NÃO REALIZE UMA COMPRA.</p>
    </footer>
</body>
</html>
