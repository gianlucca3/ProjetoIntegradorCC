<?php
session_start();
// Verifica se o usuário está logado
if (isset($_SESSION['ger_email']) && $_SESSION['ger_email'] != null) {
    // Pega o nome do usuário da sessão
    $nomeUsuario = $_SESSION['ger_email']; // Aqui você pode ter o nome do usuário armazenado
    // Extrai a primeira letra do nome
    $primeiraLetra = strtoupper($nomeUsuario[0]);
} else {
    // Usuário não logado
    $primeiraLetra = '?'; // Ícone genérico para usuários não logados
}
// Inclui o arquivo de configuração do banco de dados
$config = require 'c:/conn/conn.php';

// Conectar ao banco de dados
$conn = new mysqli(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database']
);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Obtém a data e hora atual
$hoje = date('d/m/Y H:i:s');

// Configura o charset UTF-8
header('Content-Type: text/html; charset=utf-8');
$nomeUsuario;
// Verifica se o formulário foi enviado corretamente

// Função para registrar consultas na tabela de auditoria
function registrarAuditoria($usuario, $consulta, $tabela)
{global $conn;

$sql = "INSERT INTO acesso (usuario, consulta, data_hora, tabela_acessada) 
        VALUES ('$usuario', '$consulta', NOW(), '$tabela')";

if ($conn->query($sql) === TRUE) {
    //echo "Registro de acesso inserido com sucesso.";
} else {
    echo "Erro ao registrar o acesso: " . $conn->error;
}
}

        // Salvar informações na sessão
        //Sucesso no login, armazena as informações na sessão
    
        // Pega o redirecionamento passado como parâmetro
        $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'default_page.php';
        

        // Registro de auditoria
        
        // Consulta para buscar produtos
        $sqlProdutos = "SELECT * FROM produtos ORDER BY estoque DESC";
      

        $resultadoProdutos = $conn->query($sqlProdutos);

        // Gera a tabela de produtos
        echo "<table border='1' align='center'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Estoque</th><th>Opção</th></tr>";
ECHO "
<title>Gerência</title>
    <link rel='stylesheet' href='styles.css'>
  
 <script>
  function irParaLogin() {
      // Redireciona para a página de login
      window.location.href = 'ger.php';
    }
  </script>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>

   
		<header>
     
      <nav>
	  <ul>
           
         <h2> <li><a href='gere.php'>Gerência</h2></a>
     
           
        </ul>
        <ul>
            <li><a href='home.php'>Loja</a></li>
            <li><a href='#estoque'>Estoque</a></li>
            <li><a href='cadprod.php.php'>Reposição</a></li>
          
        </ul>
    </nav>
  </header>
	";

        while ($row = $resultadoProdutos->fetch_assoc()) {
            $idProduto = $row["id"];
            $nomeProduto = htmlspecialchars($row["nome"]); // Nome do produto
            $estoque = $row["estoque"]; // Estoque atual

                     echo "<td>{$idProduto}</td>";
           // echo "<td>{$nomeProduto}</td>";
					
			echo "<td>
        <input type='button' 
               value='{$nomeProduto}' 
               onClick=\"abrirPopupPost('processa_produto.php', {nomeProduto: '{$nomeProduto}'})\">
      </td>";
	
			echo "<script>
        function abrirPopupPost(url, data) {
            const largura = 300; // Largura da popup
            const altura = 200; // Altura da popup
            const esquerda = (window.screen.width / 2) - (largura / 2); // Centraliza horizontalmente
            const topo = (window.screen.height / 2) - (altura / 2); // Centraliza verticalmente
            
            // Parâmetros para abertura da popup com as dimensões corretas
            const parametros = 'width=' + largura + ',height=' + altura + ',top=' + topo + ',left=' + esquerda + ',scrollbars=yes,resizable=yes';

            // Abre a popup com o nome definido
            const popupName = 'popupProduto';
            const popup = window.open('', popupName, parametros);

            if (!popup) {
                alert('Por favor, permita popups para este site.');
                return;
            }

            // Cria um formulário para envio POST
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.target = popupName;

            // Adiciona os dados ao formulário
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = data[key];
                    form.appendChild(input);
                }
            }

            // Adiciona o formulário ao corpo, envia e remove
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            // Foco na popup
            popup.focus();
        }
      </script>";
	      echo "<td>{$estoque}</td>";
            echo "<td>
                <input type='radio' name='opcao_{$idProduto}' value='Sim' 
                onChange='hex(\"Sim\", \"" . addslashes($nomeProduto) . "\")'> Sim
                
            </td>";
            echo "</tr>";
        }
			 echo "
			 <tr>
			
               
     <TABLE  ALIGN='CENTER' cellpadding='1'  cellspacing='5' width='100%'>  <td>   <input type='button' value='cadastrar produto'
               onClick=\'abrirPopupPost('cadprod.php', {nomeProduto: '{$nomeProduto}'})\'>
    </td>
	
            
                
          
			 
			 ";
			 
			 
        echo "</table>";


// Fecha a conexão com o banco de dados
$conn->close();
?>
<script>
function hex(valor, nomeProduto) {
    // Cria um formulário oculto para enviar os dados
    const form = document.createElement("form");
    form.method = "POST";
    form.target = "popup"; // Define o alvo como a janela popup
    form.action = "processa_produto.php"; // Substitua pelo arquivo de destino

    // Adiciona o valor do rádio ao formulário
    const inputValor = document.createElement("input");
    inputValor.type = "hidden";
    inputValor.name = "valor";
    inputValor.value = valor;
    form.appendChild(inputValor);

    // Adiciona o nome do produto ao formulário
    const inputNome = document.createElement("input");
    inputNome.type = "hidden";
    inputNome.name = "nomeProduto";
    inputNome.value = nomeProduto;
    form.appendChild(inputNome);

    // Adiciona o formulário ao corpo temporariamente
    document.body.appendChild(form);
// Detecta dispositivos móveis
const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

    // Abre a janela popup
	// Define dimensões diferentes para desktop e dispositivos móveis
const largura = isMobile ? 300 : 300; // 300px para móveis, 600px para desktop
const altura = isMobile ? 150 : 130; // 150px para móveis, 200px para desktop

	
    //const largura = 600; // Largura da popup
    //const altura = 200; // Altura da popup
    const esquerda = (screen.width - largura) / 2; // Centraliza horizontalmente
    const topo = (screen.height - altura) / 2; // Centraliza verticalmente
    //const popup = window.open('', 'popup', `width=${largura},height=${altura},top=${topo},left=${esquerda}`);
const popup = window.open('', 'popup', `width=${largura},height=${altura},top=${topo},left=${esquerda}`);

    // Envia o formulário para a popup
    form.submit();

    // Remove o formulário do DOM após o envio
    document.body.removeChild(form);

    // Define um evento para recarregar a página principal quando a popup for fechada
    const timer = setInterval(() => {
        if (popup.closed) {
            clearInterval(timer); // Para o timer
            location.reload(); // Recarrega a página principal
        }
    }, 500); // Verifica a cada 500ms
}
</script>
