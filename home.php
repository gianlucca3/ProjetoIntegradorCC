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

  <!-- JavaScript -->
  <script>
    function irParaLogin() {
      window.location.href = 'login.php'; // Redireciona para a página de login
    }

    function irParaPerfil() {
      window.location.href = 'perfil.php'; // Redireciona para a página de perfil
    }
  </script>


  <!-- JavaScript -->
  <script>
    function irParaLogin() {
      window.location.href = 'login.php'; // Redireciona para a página de login
    }

    function irParaPerfil() {
      window.location.href = 'perfil.php'; // Redireciona para a página de perfil
    }
  </script>


<script>
    // A função será ativada quando pressionar a tecla F7
    document.addEventListener('keydown', function(event) {
        if (event.key === "F7") { // Se a tecla pressionada for F1
            window.location.href = "gerencia.php"; // Redireciona para a página de gerência da loja
        }
    });
</script>

  <header>
      <nav>
        <ul>
            <li><a href="#catalogo">Catálogo</a></li>
            <li><a href="cad.php">Cadastro</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="cart.php">Carrinho</a></li>
            <li><a href="about.php">Sobre</a></li>
        </ul>
    </nav>
  </header>

  <main>
    <section id="catalogo">
        <h2>Nosso Catálogo de Produtos</h2>
<div class="produtos"> 		
 <div class="produto">      
    <img src="pao.jpg" alt="Pão Francês">
    <h3>Pão Francês</h3>
    <p>R$ 0,50</p>
    <div class="input-quantity">
    <!-- Botão para diminuir a quantidade -->
    <button 
        class="btn-quantidade" 
        onclick="alterarQuantidade('Pão Francês', 0.50, -1, 'quantidade-pao-frances')"
    >-</button>
    
    <!-- Campo de texto para mostrar a quantidade -->
    <input 
        type="text" 
        id="quantidade-pao-frances" 
        class="input-text" 
        value="1" 
        readonly
    >
	
        <!-- Botão para aumentar a quantidade -->
    <button 
        class="btn-quantidade" 
        onclick="alterarQuantidade('Pão Francês', 0.50, 1, 'quantidade-pao-frances')"
    >+</button>
	
	</div></div>
	



<!-- Croissant -->
        <div class="produto">
    <img src="croissant.jpg" alt="Croissant">
    <h3>Croissant</h3>
    <p>R$ 3,00</p>
    <div class="input-quantity">
        <button class="btn-quantidade" onclick="alterarQuantidade('Croissant', 3.00, -1, 'quantidade-croissant')">-</button>
        <input type="text" id="quantidade-croissant" class="input-text" value="1" readonly>
        <button class="btn-quantidade" onclick="alterarQuantidade('Croissant', 3.00, 1, 'quantidade-croissant')">+</button>
    </div>
</div>

<!-- Bolo de Chocolate -->
        <div class="produto">
    <img src="bolo.jpg" alt="Bolo de Chocolate">
    <h3>Bolo de Chocolate</h3>
    <p>R$ 20,00</p>
    <div class="input-quantity">
        <button class="btn-quantidade" onclick="alterarQuantidade('Bolo de Chocolate', 20.00, -1, 'quantidade-bolo-chocolate')">-</button>
        <input type="text" id="quantidade-bolo-chocolate" class="input-text" value="1" readonly>
        <button class="btn-quantidade" onclick="alterarQuantidade('Bolo de Chocolate', 20.00, 1, 'quantidade-bolo-chocolate')">+</button>
    </div>
</div>

<!-- Pão de Queijo -->
<div class="produto">
    <img src="pao_de_queijo.jpg" alt="Pão de Queijo">
    <h3>Pão de Queijo</h3>
    <p>R$ 1,50</p>
    <div class="input-quantity">
        <button class="btn-quantidade" onclick="alterarQuantidade('Pão de Queijo', 1.50, -1, 'quantidade-pao-queijo')">-</button>
        <input type="text" id="quantidade-pao-queijo" class="input-text" value="1" readonly>
        <button class="btn-quantidade" onclick="alterarQuantidade('Pão de Queijo', 1.50, 1, 'quantidade-pao-queijo')">+</button>
    </div>
</div>

<!-- Torta de Maçã -->
<div class="produto">
    <img src="torta.jpg" alt="Torta de Maçã">
    <h3>Torta de Maçã</h3>
    <p>R$ 15,00</p>
    <div class="input-quantity">
        <button class="btn-quantidade" onclick="alterarQuantidade('Torta de Maçã', 15.00, -1, 'quantidade-torta-maca')">-</button>
        <input type="text" id="quantidade-torta-maca" class="input-text" value="1" readonly>
        <button class="btn-quantidade" onclick="alterarQuantidade('Torta de Maçã', 15.00, 1, 'quantidade-torta-maca')">+</button>
    </div>
</div>

<!-- Biscoito -->
<div class="produto">
    <img src="biscoito.jpg" alt="Biscoito">
    <h3>Biscoito</h3>
    <p>R$ 2,00</p>
    <div class="input-quantity">
        <button class="btn-quantidade" onclick="alterarQuantidade('Biscoito', 2.00, -1, 'quantidade-biscoito')">-</button>
        <input type="text" id="quantidade-biscoito" class="input-text" value="1" readonly>
        <button class="btn-quantidade" onclick="alterarQuantidade('Biscoito', 2.00, 1, 'quantidade-biscoito')">+</button>
    </div>
</div>
</div>	
	
</div>
	
	
<script>
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

// Atualiza a quantidade e sincroniza com o carrinho
function alterarQuantidade(nome, preco, valor, inputId) {
    // Busca o campo de quantidade pelo ID fornecido
    const inputQuantidade = document.getElementById(inputId);
    let quantidadeAtual = parseInt(inputQuantidade.value);

    // Ajusta a quantidade com base no valor passado (+1 ou -1)
    quantidadeAtual += valor;

    // Garante que a quantidade seja no mínimo 1
    if (quantidadeAtual < 1) {
        quantidadeAtual = 1;
    }

    // Atualiza o campo de entrada
    inputQuantidade.value = quantidadeAtual;

    // Atualiza o carrinho
    adicionarAoCarrinho(nome, preco, valor > 0 ? "+" : "-");
}

// Adiciona ou remove itens do carrinho
function adicionarAoCarrinho(nome, preco, operacao) {
    // Verifica se o produto já existe no carrinho
    let produtoExistente = carrinho.find(item => item.nome === nome);

    if (produtoExistente) {
        if (operacao === "+") {
            produtoExistente.quantidade += 1;
        } else if (operacao === "-" && produtoExistente.quantidade > 1) {
            produtoExistente.quantidade -= 1;
        } else if (operacao === "-" && produtoExistente.quantidade === 1) {
            // Remove o item do carrinho se a quantidade for 1 e o comando for "-"
            carrinho = carrinho.filter(item => item.nome !== nome);
        }
    } else if (operacao === "+") {
        // Se o produto não existir no carrinho, adiciona-o
        carrinho.push({ nome, preco, quantidade: 1 });
    }

    // Atualiza o localStorage com o estado atual do carrinho
    localStorage.setItem('carrinho', JSON.stringify(carrinho));

    // Exibe uma mensagem de feedback
    mostrarMensagem(`${nome} foi ${operacao === "+" ? "adicionado" : "removido"} ao carrinho!`);
}

// Exibe mensagem temporária
function mostrarMensagem(texto) {
    const mensagemDiv = document.getElementById('mensagem');
    mensagemDiv.innerText = texto;
    mensagemDiv.style.display = 'block';

    // Esconde a mensagem após 1,3 segundos
    setTimeout(() => {
        mensagemDiv.style.display = 'none';
    }, 1300);
}

</script>
<div id="mensagem" style="display: none; position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); background-color: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">


        </section>
    </main>
</div>

  <footer>
      <p>&copy; 2024 Padaria Flocos de Neve. Página para fins acadêmicos. NÃO REALIZE UMA COMPRA.</p>
  </footer>

  
  <script>
    let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
function adicionarAoCarrinho(nome, preco, operacao = "+") {
    let produtoExistente = carrinho.find(item => item.nome === nome);

    if (produtoExistente) {
        if (operacao === "+") {
            produtoExistente.quantidade += 1;
        } else if (operacao === "-" && produtoExistente.quantidade > 1) {
            produtoExistente.quantidade -= 1;
        } else if (operacao === "-" && produtoExistente.quantidade === 1) {
            // Remove o item se a quantidade for 1 e o comando for "-"
            carrinho = carrinho.filter(item => item.nome !== nome);
        }
    } else if (operacao === "+") {
        // Se o produto ainda não está no carrinho, adiciona-o
        carrinho.push({ nome, preco, quantidade: 1 });
    }

    // Atualiza o localStorage
    localStorage.setItem('carrinho', JSON.stringify(carrinho));

    // Exibe mensagem
    const mensagemDiv = document.getElementById('mensagem');
    mensagemDiv.innerText = operacao === "+" 
        ? `${nome} foi adicionado ao carrinho!` 
        : `${nome} foi removido do carrinho!`;
    mensagemDiv.style.display = 'block';

    // Fecha a mensagem após 1.3 segundos
    setTimeout(() => {
        mensagemDiv.style.display = 'none';
    }, 1300);
}


	
	
	
	
    function irParaLogin() {
      // Redireciona para a página de login
      window.location.href = 'login.php';
    }
  </script>
   
  
</body>
</html>
