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

	
	$useremail = $_GET['email'];
    
	
	//echo "<pre>";
   // print_r($username);
   // echo "</pre>";
	//echo "<pre>";
   // print_r($useremail);
		
	
	
	
	
	
// Verifica se o nome já existe
$sql = "SELECT * FROM clientes WHERE email = '$useremail'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
				
				
				$sql = "DELETE FROM clientes WHERE email = '$useremail'";

// Executar a consulta
if (mysqli_query($conn, $sql)) {
    echo "Registro deletado com sucesso.";
	
	
	echo "<script>
	
	
	
	
    window.alert('Cadastre nova senha');
    window.location.href = 'cad2.php?email=$useremail';
</script>";
	
} else {
    echo "Erro ao deletar o registro: " . mysqli_error($conn);
}
				
				
	  
}
	echo "<script>
    window.alert('email não cadastrado');
    window.location.href = 'cad.php?email=$useremail';
</script>";

	
?>

