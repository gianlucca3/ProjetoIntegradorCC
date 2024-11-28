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
$sql = "SELECT * FROM visita ORDER BY data_hora DESC";
$resultado = $conn->query($sql);

// Verifica se há registros
if ($resultado->num_rows > 0) {
    // Início da tabela HTML para exibir os resultados
	 echo "
	 <l<meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Padaria Flocos de Neve</title>
    <link rel='stylesheet' href='styles.css'>
   
	 
	 
			<header>
     <h2>Gerência</h2>
      <nav>
	    <ul>
            <li><a href='home.php'>Loja</a></li>
            <li><a href='estoque.php'>Estoque</a></li>
           	<li><a href='visita.php'>Acesso</a></li>
             <li><a href='about.php'>Sobre</a></li>
        </ul>
    </nav>
  </header>
	 
	 <table border='1' ALIGN='center'>
	
  
   <TR>  <TD><TABLE  BORDER='0' ALIGN='CENTER' cellpadding='1'  cellspacing='5' width='100%'><CENTER>Acessos à loja</CENTER> </td>
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
