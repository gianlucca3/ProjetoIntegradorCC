<?php
// Conexão com o banco de dados
$config = require 'c:/conn/conn.php'; // Ajuste o caminho de acordo com sua estrutura
$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// Verifica se a requisição é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nomeProduto = $_POST['nomeProduto']; // Nome do produto

    if (isset($_POST['quantidade'])) {
        $quantidade = (int)$_POST['quantidade']; // Converte para inteiro

        // Escapa os dados para prevenir injeção de SQL
        $nomeProduto = mysqli_real_escape_string($conn, $nomeProduto);

        // Verifica o estoque atual
        $sqlVerificaEstoque = "SELECT estoque FROM produtos WHERE nome = '$nomeProduto'";
        $result = $conn->query($sqlVerificaEstoque);

        if ($result && $result->num_rows > 0) {
            $produto = $result->fetch_assoc();
            $estoqueAtual = (int)$produto['estoque'];
            $novoEstoque = $estoqueAtual + $quantidade;

            if ($novoEstoque < 0) {
                echo "Erro: Não é possível reduzir o estoque abaixo de zero.";
            } else {
                // Atualiza o estoque do produto
                $sqlAtualizaEstoque = "UPDATE produtos SET estoque = $novoEstoque WHERE nome = '$nomeProduto'";
                if ($conn->query($sqlAtualizaEstoque)) {
                    echo "Estoque do produto '{$nomeProduto}' atualizado com sucesso! Estoque atual: $novoEstoque.";
                } else {
                    echo "Erro ao atualizar o estoque: " . $conn->error;
                }
            }
        } else {
            echo "Erro: Produto não encontrado.";
        }
    } 
} else {
    echo "Nenhum dado enviado.";
}

// Fecha a conexão
$conn->close();
?>

<!-- Formulário para adicionar ao estoque com AJAX -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
   
<form id="addEstoqueForm" method="POST">
    <input type="hidden" name="nomeProduto" value="<?php echo $nomeProduto; ?>"> <!-- Nome do produto -->
    <label for="quantidade">Quantidade</label>
    <input type="number" name="quantidade" id="quantidade"  placeholder="Digite positivo ou negativo" required>
    <button type="submit">Atualizar Estoque</button>

</form>

<div id="message"></div>

<script>
    // Captura o evento de submit do formulário
    document.getElementById('addEstoqueForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio do formulário da maneira tradicional

        // Cria o FormData com os dados do formulário
        var formData = new FormData(this);

        // Envia os dados via AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true); // Reenvia os dados para a mesma página (ou use o caminho desejado)
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Exibe a resposta no elemento #message
                document.getElementById('message').innerHTML = xhr.responseText;

                // Fecha a janela pop-up
                window.close(); // Fecha a janela pop-up

                // Recarrega a página da janela que chamou o pop-up
                if (window.opener) {
                    window.opener.location.reload(); // Recarrega a página que abriu o pop-up
                }
            }
        };
        xhr.send(formData);
    });
</script>
