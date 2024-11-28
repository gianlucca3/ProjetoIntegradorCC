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

/// Recebe os dados enviados pelo formulário
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$nova_senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';
$telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : '';

// Evita SQL Injection
$nome = mysqli_real_escape_string($conn, $nome);
$email = mysqli_real_escape_string($conn, $email);
$telefone = mysqli_real_escape_string($conn, $telefone);
$cpf = mysqli_real_escape_string($conn, $cpf);
$endereco = mysqli_real_escape_string($conn, $endereco);

// Se a senha não estiver vazia, gera o hash
if (!empty($nova_senha)) {
     $nova_senha_hash = md5($nova_senha); // Hasheia a senha com md5
    // Inclui a senha no SQL de atualização
    $sql = "UPDATE clientes 
            SET nome = '$nome',
                email = '$email',
                telefone = '$telefone',
                cpf = '$cpf',
                endereco = '$endereco',
                senha = '$nova_senha_hash' 
            WHERE email = '$email'";
} else {
    // Se a senha estiver vazia, não atualiza a senha
    $sql = "UPDATE clientes 
            SET nome = '$nome',
                email = '$email',
                telefone = '$telefone',
                cpf = '$cpf',
                endereco = '$endereco'
            WHERE email = '$email'";
}

// Executa a consulta
if (mysqli_query($conn, $sql)) {
    // Atualiza os dados na sessão
    $_SESSION['cliente_nome'] = $nome;
    $_SESSION['cliente_email'] = $email;
    $_SESSION['cliente_telefone'] = $telefone;
    $_SESSION['cliente_cpf'] = $cpf;
    $_SESSION['cliente_endereco'] = $endereco;
    if (!empty($nova_senha)) {
        $_SESSION['cliente_senha'] = $nova_senha_hash;
    }

    $_SESSION['mensagemSucesso'] = "Perfil atualizado com sucesso!";
} else {
    $_SESSION['mensagemErro'] = "Erro ao atualizar o perfil: " . mysqli_error($conn);
}

// Fecha a conexão
mysqli_close($conn);

// Redireciona de volta para a página de perfil
header('Location: perfil.php');
exit;
