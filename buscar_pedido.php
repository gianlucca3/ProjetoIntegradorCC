<?php

session_start();
// Conectar ao banco de dados
// Incluir as configurações do banco de dados
if (!isset($_SESSION['cliente_email'])) {
    // Salva o URL atual para redirecionar após login
    $urlAtual = urlencode($_SERVER['REQUEST_URI']); // Codifica o URL atual
    header("Location: login.php?redirect=$urlAtual");
    exit();
}

$config = require 'c:/conn/conn.php';

$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Define o fuso horário (opcional)
date_default_timezone_set('America/Sao_Paulo'); // Altere para o seu fuso horário

// Obter o e-mail do cliente (enviado via query string ou outro método)
$emailCliente = $_GET['email'] ?? null;
$data = $_GET['email'] ?? null;
$dia = date('d/m/Y H:i:s', strtotime($data));

if (!$emailCliente) {
    die("E-mail do cliente não especificado.");
}

try {

$sql = ("SELECT carrinho FROM meus_pedidos WHERE data_pedido = '$emailCliente'");


			$resultado = mysqli_query($conn, $sql);
			
		$numrows = mysqli_num_rows($resultado);
    /*
	// Consultar os dados do pedido, incluindo o carrinho (JSON)
	 echo "<pre>";
    print_r($dia);
    echo "</pre>";
		
	*/
	//$stmt = $pdo->prepare("SELECT carrinho FROM meus_pedidos WHERE email_cliente = :email AND data_pedido = :data");
    //$stmt = $pdo->prepare("SELECT carrinho FROM meus_pedidos WHERE email_cliente = :email AND metodo_pagamento = :metodo_pagamento");
    //$stmt = $pdo->prepare("SELECT carrinho FROM meus_pedidos WHERE email_cliente = :email");
 // Verificar se o pedido foi encontrado
if ($resultado->num_rows == 0) {
    die("Pedido não encontrado.");
}

// Obter o conteúdo do carrinho (JSON)
$row = $resultado->fetch_assoc();
$carrinhoJson = $row['carrinho'];
$total = 0;
    // Decodificar o JSON para um array PHP
    $carrinho = json_decode($carrinhoJson, true);

    // Verificar se a decodificação foi bem-sucedida
    if ($carrinho === null) {
        die("Erro ao decodificar o JSON.");
    }

    // Exibir o conteúdo do carrinho
	/*
	
	<input type="button" value=" <?php echo $dia; ?> " onClick='window.location.href="buscar_pedido.php?email=<?php echo $diabd; ?>"'style="width: 100%; padding: 10px; font-size: 16px; text-align: center;">

	foreach ($carrinho as $item) {
    echo "Nome: " . htmlspecialchars($item['nome']) . "<br>";
    echo "Preço: R$ " . htmlspecialchars(number_format($item['preco'], 2, ',', '.')) . "<br><br>";
}
*/
ECHO "
<html>

<head>
<title>Estoque</title>
 <link rel='stylesheet' href='styles.css'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
  

<header>
       
        <nav>
            <ul>
                <li><a href='home.php'>Início</a></li>
                <li><a href=array.php>Pedidos</a></li>
                
                <li><a href='about.php'>Sobre</a></li>
            </ul>        </nav>
    </header>
";

echo "<table border='1'  class='tabelaLogin' cellpadding='1' cellspacing='1' align='center' width='250' style='border-collapse:collapse;'>
	
	<center>$dia<center>"; // Cabeçalho da tabela
	echo '<tr><th><center>Nome</th><th>Preço</th></tr>'; // Cabeçalho da tabela

foreach ($carrinho as $item) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($item['nome']) . '</td>';
    echo '<td>R$ ' . htmlspecialchars(number_format($item['preco'], 2, ',', '.')) . '</td>';
    echo '</tr>';
}

echo '</table>';
	
	
	

} catch (PDOException $e) {
    die("Erro ao buscar o pedido: " . $e->getMessage());
}
?>


 