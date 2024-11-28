<?php


// Conexão ao banco de dados
$config = require 'c:/conn/conn.php';

$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);
    

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Nome que você deseja buscar
	

//Dados do cliente a ser cadastrado

	$username = $_POST['name'];
	$useremail = $_POST['email'];
    $password = $_POST['password'];
	$password = md5($password);
	
	
	
	
	
	
	
// Verifica se o nome já existe
$sql = "SELECT * FROM clientes WHERE email = '$useremail'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
				echo "<script>window.alert('Nome já cadastrado!');
				history.back();</script>";
    
} else {
    // Insere novo cliente no banco de dados
    $sql = "INSERT INTO clientes (nome, email,senha) VALUES ('$username', '$useremail','$password')";
    
    if ($conn->query($sql) === TRUE) {
		echo "<script>window.alert('Cadastro efetivado com sucesso!');
		window.location.href = 'home.php';</script>";
        
    } else {
        echo "Erro ao cadastrar o cliente: " . $conn->error;
    }
}



	
?>

