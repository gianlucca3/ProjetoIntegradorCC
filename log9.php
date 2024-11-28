<?php
session_start();

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
   $email = $_POST['email'];
    $password = $_POST['password'];
	$password = md5($password);
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'home.php';

	
	// Função para registrar consultas na tabela de auditoria
function registrarvisita($usuario, $consulta, $tabela)
{

	 global $conn;
    $sql = "INSERT INTO visita (usuario, consulta, data_hora, tabela_acessada) 
            VALUES ('$usuario', '$consulta', NOW(), '$tabela')";
    if ($conn->query($sql) === TRUE) {
        echo "Visita registrada com sucesso.";
    } else {
        echo "Erro ao registrar visita: " . $conn->error;
    }
}



    // Consulta para verificar o email e a senha
    $query = "SELECT * FROM clientes WHERE email = '$email' AND senha = '$password'";
$result = mysqli_query($conn, $query);
$cliente = mysqli_fetch_assoc($result);

			
if ($cliente) {
		
        // Registro de auditoria
        registrarvisita($email, "Login realizado com sucesso", "Login");
	$email=$cliente['email'];
        // Salvar informações na sessão
        //Sucesso no login, armazena as informações na sessão
    
    $_SESSION['cliente_id'] = $cliente['id'];
    $_SESSION['cliente_nome'] = $cliente['nome'];
    $_SESSION['cliente_email'] = $cliente['email'];
     // Certifique-se de armazenar de forma segura
	 
$_SESSION['cliente_end'] = $cliente['endereço'];
$_SESSION['cliente_email'] = $cliente['email'];
$_SESSION['cliente_senha'] = $cliente['senha'];

$_SESSION['cliente_cpf'] = $cliente['cpf'];
$_SESSION['cliente_tel'] = $cliente['telefone'];
$_SESSION['cliente_end'] = $cliente['endereco'];

	
	 
	 
    header("Location: home.php");
    exit;
	

	
	
	
	
	
	
        
        // Pega o redirecionamento passado como parâmetro
        $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'home.php';
        
	
	if (basename($redirect) === 'login.php') {
    $redirect = 'home.php';
	}
        // Redireciona para a página de onde o login foi solicitado
        header("Location: $redirect");
        exit;
    } else {
        // Redireciona de volta para a página de login com mensagem de erro
    	$mensagemErro = 'Usuário ou senha inválidos!';
		
		
		header('Location: login.php?erro=' . urlencode($mensagemErro));
		exit();
    }

?>
