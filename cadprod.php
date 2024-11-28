<?php
// Conexão com o banco de dados
$config = require 'c:/conn/conn.php'; // Ajuste o caminho de acordo com sua estrutura
$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Verifica se a requisição é um POST e os parâmetros necessários foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nomeProduto'], $_POST['quantidade'])) {
    // Recebe os dados do formulário
    $nomeProduto = $_POST['nomeProduto'];
    $quantidade = (int)$_POST['quantidade']; // Converte a quantidade para inteiro

    // Escapa os dados para prevenir injeção de SQL
    $nomeProduto = $conn->real_escape_string($nomeProduto);

    // Inicia a transação para garantir consistência
    $conn->begin_transaction();

    try {
        // Consulta para verificar se o produto já existe
        $sql_check = "SELECT id FROM produtos WHERE nome = '$nomeProduto'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            throw new Exception("Produto já existe no estoque.");
        
		
		
		
		
		}

        // Inserção na tabela `produtos` se não houver duplicidade
        $sql = "INSERT INTO produtos (nome, estoque) VALUES ('$nomeProduto', $quantidade)";
        if (!$conn->query($sql)) {
            throw new Exception("Erro ao inserir produto: " . $conn->error);
        }

        // Confirma a transação
        $conn->commit();
        echo "Produto inserido com sucesso!";
    } catch (Exception $e) {
        // Desfaz a transação em caso de erro
        $conn->rollback();
        echo "Erro: " . $e->getMessage();
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
<!-- Formulário HTML -->
<form id="addEstoqueForm" method="POST">
    <label for="nomeProduto">Produto:</label>
    <input type="text" name="nomeProduto" required>
  
    <label for="quantidade">Quantidade:</label>
    <input type="number" name="quantidade" id="quantidade" min="1" required>
  
    <button type="submit">Adicionar ao Estoque</button>
</form>

<div id="message"></div>

<script>
    // Captura o evento de submit do formulário
    document.getElementById('addEstoqueForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio do formulário da maneira tradicional

        var formData = new FormData(this); // Cria o FormData com os dados do formulário

        // Desabilita o botão para evitar múltiplos envios
        var submitButton = document.querySelector('button[type="submit"]');
        submitButton.disabled = true; 

        // Envia os dados via AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true); // Reenvia os dados para a mesma página
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Exibe a resposta no elemento #message
                document.getElementById('message').innerHTML = xhr.responseText;

                // Reabilita o botão após a resposta ser recebida
                submitButton.disabled = false; 

                // Fecha a janela pop-up após um pequeno atraso
                setTimeout(function() {
                    window.close(); // Fecha a janela pop-up após 3 segundos
                }, 1500); // Atraso para dar tempo de exibir a mensagem

                // Recarrega a página da janela que chamou o pop-up
                if (window.opener) {
                    window.opener.location.reload(); // Recarrega a página que abriu o pop-up
                }
            }
        };
        xhr.send(formData); // Envia os dados do formulário via AJAX
    });
</script>
