<?php
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
// Consulta para pegar os registros da tabela de auditoria
$sql = "SELECT * FROM acesso ORDER BY data_hora DESC";
$resultado = $conn->query($sql);

// Verifica se há registros
if ($resultado->num_rows > 0) {
    // Início da tabela HTML para exibir os resultados
	 echo "<link href='padrao.css' rel='stylesheet' type='text/css'>

	 
	 <table border='1' ALIGN='center'>
	
  
   <TR>  <TD><TABLE  BORDER='0' ALIGN='CENTER' cellpadding='1'  cellspacing='5' width='100%'><CENTER>Acessos</CENTER> </td>
		<table  border='1' ALIGN='center'>
	
            <thead>
                <tr>
                    <th>ID</th>
                   
                    <th>Usuário</th>
                    <th>Data/Hora</th>
                   
                </tr>
            </thead>
            <tbody>";

    // Exibe os registros
    while ($row = $resultado->fetch_assoc()) {
	$dia = date('d/m/Y H:i:s', strtotime($row['data_hora']));
        echo "<tr>
                <td>" . $row['id'] . "</td>
                
                <td>" . $row['usuario'] . "</td>
				
				<td>" .$dia. "</td>
				
               
             
              </tr>";
    }

    // Finaliza a tabela HTML
    echo "</tbody></table>";
} else {
    echo "Nenhum registro encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
