<?php
header('Content-Type: application/json');

require_once('tcpdf/tcpdf.php');
header('Content-Type: application/json');
session_start();
header('Content-Type: application/json'); // Retorna JSON

// Verifica se o usuário está logado
if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não autenticado']);
    exit();
}
$email = $_SESSION['cliente_email']  ;




		
// Define o fuso horário (opcional)
date_default_timezone_set('America/Sao_Paulo'); // Altere para o seu fuso horário

// Obtém a data e hora atual
$data_hora_atual = date('d/m/Y H:i:s');
// Conectar ao banco de dados
    //$conn = new mysqli("host", "usuario", "senha", "nome_do_banco");
$conn = new mysqli("localhost", "root", "", "pit");
  $cupomPath = "cupom_fiscal_" . time() . ".pdf";   
	
	//file_put_contents('log.txt', "conectou ao Banco de  dados\n", FILE_APPEND);

    // Verificar a conexão
    if ($conn->connect_error) {
        die(json_encode(['sucesso' => false, 'erro' => 'Erro na conexão com o banco']));
    }

	
// Recebe os dados JSON enviados do JavaScript
$inputData = file_get_contents("php://input");
file_put_contents('log.txt', "Recebendo dados JSON php1 ...\n", FILE_APPEND);
file_put_contents('log.txt', $inputData . "\n", FILE_APPEND);

$data = json_decode($inputData, true);

// Verificação de dados
if ($data === null || !isset($data['carrinho']) || !isset($data['metodoPagamento'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos ou incompletos.']);
    exit;
}
$carrinho = $data['carrinho'] ?? [];

// Verifica se o carrinho está vazio
// Verifica se o carrinho está vazio


$metodoPagamento = $data['metodoPagamento'];
$carrinhoJson = json_encode($carrinho, JSON_UNESCAPED_UNICODE);

// Calcula o total

$total = 0;



foreach ($carrinho as $produto) {
    $total += $produto['preco'];
}


// Contar cada nome de produto no carrinho

/*
foreach ($carrinho as $item) {
    $nomeProduto = $item['nome'];
    if (isset($contagemProdutos[$nomeProduto])) {
        $contagemProdutos[$nomeProduto]++;
    } else {
        $contagemProdutos[$nomeProduto] = 1;
    }
}
*/
// Diagnóstico antes do loop
file_put_contents('log.txt', "Início da atualização de estoque para os produtos no carrinho.\n", FILE_APPEND);
// Teste se a variável $contagemProdutos tem dados


file_put_contents('log.txt', "exibir1...\n", FILE_APPEND);




// Array para armazenar a contagem de cada produto



/*

$contagemProdutos = [];

foreach ($carrinho as $item) {
    $nomeProduto = $item['nome'];
    if (isset($contagemProdutos[$nomeProduto])) {
        $contagemProdutos[$nomeProduto]++;
    } else {
        $contagemProdutos[$nomeProduto] = 1;
    }
	
	
}





$carrinhoJson = json_encode($carrinho, JSON_UNESCAPED_UNICODE);
		
 $sql = "INSERT INTO meus_pedidos (carrinho, metodo_pagamento, cupom_path,email_cliente) VALUES ('$carrinhoJson', '$metodoPagamento', '$cupomPath','$email')";
         
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => 'Erro ao salvar no banco']);
        }

 echo "<script>alert('Compra finalizada com sucesso!'); window.location.href = 'pagina_de_confirmacao.php';</script>";

*/

// Verifica status de pagamento (simulação)
$pagamentoStatus = ($metodoPagamento === 'PIX' || $metodoPagamento === 'Cartão');

// Se pagamento aprovado, gera PDF
if ($pagamentoStatus) {







    try {
        
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(105, 170), true, 'UTF-8', false);

// Configurações padrão do TCPDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nome da Loja');
$pdf->SetTitle('Cupom Fiscal');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(5, 5, 5); // Define margens menores para aproveitar mais espaço

// Adiciona uma página
$pdf->AddPage();

		
		$pdf->SetAutoPageBreak(true,15); 
		$pdf->SetTopMargin(6);
		$pdf->SetFooterMargin(20);
		$pdf->SetLeftMargin(5);
        $pdf->SetFont('Times', 'B', 13);
     $pdf->Image("FlocoDeNeveLogo.jpg", 40,2,23,19);
	$pdf->Image("cid.jpg", 200,10,37,20);   
     //   $pdf->SetFontSize(10);
      //  $pdf->Write(7, $text1); 
	 // $pdf->SetXy(148,10);	  
		 // $pdf->Write(5, 'I');
		  $pdf->SetXy(23,20);	  
		  $pdf->Write(5, 'Padaria Flocos de Neve Ltda.');
		  
		  $pdf->SetFont('Times', '', 9);
		  $pdf->SetXy(8,19);	
		  $pdf->Write(7, '
RUA Pamplona, 957 - Jardim Paulista - São Paulo- SP
CNPJ: 86.755.217/001-03
');
		 
		
		$pdf->Line(4, 33, 95, 33) ;
		$pdf->Line(4, 39, 95, 39) ;
																																																																																																																																																																																																																									
																																																																																																																																																																																																																								
																																																																																																																																																																																																																								
																																																																																																																																																																																																																								
																																																																																																																																																																																																																								
																																																																																																																																																																																																																								
$pdf->Cell(0, 6, $data_hora_atual, 0, 1, 'L'); // Altura menor para as células
																																																																																																																																																																																																																								
		
// Define uma fonte menor
$pdf->SetFont('helvetica', 'B', 10);
// data_hora_atual


// Cabeçalho do cupom
$pdf->Cell(0, 6, 'Cupom Fiscal', 0, 1, 'C'); // Altura menor para as células
//$pdf->SetFont('helvetica', '', 8);
//$pdf->Cell(0, 6, 'Metodo de Pagamento: ' . $metodoPagamento, 0, 1, 'C');
//$pdf->Ln(5); // Espaço entre as seções

/// Cabeçalho da tabela
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(50, 6, 'Produto', 1, 0, 'C');  // Ajusta a largura da coluna
$pdf->Cell(15, 6, 'Qtd', 1, 0, 'C');      // Nova coluna para a quantidade
$pdf->Cell(20, 6, 'Preço (R$)', 1, 1, 'C'); // Coluna para o preço

// Listagem dos itens do carrinho
$pdf->SetFont('helvetica', '', 8);

    $precoUnitario = 0;

    // Obtém o preço unitário do carrinho original
    foreach ($carrinho as $item) {
        $nome = $item['nome'];
    $quantidade = $item['quantidade'];
    $precoTotal = $item['preco'] * $quantidade;
    $totalGeral += $precoTotal;
           
       
   

   

    // Exibe os dados na tabela
    $pdf->Cell(50, 6, $nome, 1, 0, 'L');
    $pdf->Cell(15, 6, $quantidade, 1, 0, 'C');
    $pdf->Cell(20, 6, number_format($precoTotal, 2, ',', '.'), 1, 1, 'R');
 }

// Total geral
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(65, 6, 'Total Geral', 1, 0, 'L');
$pdf->Cell(20, 6, number_format($totalGeral, 2, ',', '.'), 1,2, 'R');
$pdf->Ln(5); // Espaço entre o total e a mensagem final
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 6, 'Metodo de Pagamento: ' . $metodoPagamento, 0, 1, 'L');
// Mensagem de agradecimento
$pdf->SetFont('helvetica', 'I', 8);
$pdf->Cell(0, 6, 'Obrigado pela sua compra!', 0, 1, 'C');
 //file_put_contents('log.txt', "PDF em andamento: $pdfFilePath\n", FILE_APPEND);
     
        // Caminho do PDF
		
		 $arquivo= __DIR__ . DIRECTORY_SEPARATOR .$email.$data_hora_atual;
        $pdfFilePath = __DIR__ . DIRECTORY_SEPARATOR .  'cupom_fiscal.pdf';
       
		$data = $resultado['email_cliente']."&data=".$resultado['data_pedido'];
        // Verifica se é possível escrever no diretório
        if (!file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'teste.txt', 'Teste de escrita no diretório')) {
            file_put_contents('log.txt', "Erro: sem permissão para salvar PDF\n", FILE_APPEND);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro de permissão ao salvar o PDF.']);
            exit;
        }
       
        $pdf->Output($pdfFilePath, 'F'); 
          echo json_encode(['sucesso' => true, 'mensagem' => 'Compra realizada com sucesso!', 'pdf' => $pdfFilePath]);
     $hoje = date('d/m/Y H:i:s');
	 $cupomPath = "cupom_fiscal_" . date('d-m-Y#H-i-s') . ".pdf";
 
 copy("cupom_fiscal.pdf", $cupomPath) ;
        // Insere o pedido na tabela meus_pedidos
		

		file_put_contents('log.txt', "salvar PDF\n", FILE_APPEND);
         
$carrinhoJson = json_encode($carrinho, JSON_UNESCAPED_UNICODE);
		
 $sql = "INSERT INTO meus_pedidos (carrinho, metodo_pagamento, cupom_path,email_cliente) VALUES ('$carrinhoJson', '$metodoPagamento', '$cupomPath','$email')";
         
		 
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => 'Erro ao salvar no banco']);
        }
		
		
	
    } catch (Exception $e) {
        file_put_contents('log.txt', "Erro ao gerar PDF: " . $e->getMessage() . "\n", FILE_APPEND);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao salvar o PDF.']);
    }
	
		
	if (file_exists($cupomPath)) {
    // Lê o conteúdo do arquivo temporário
    $conteudo = file_get_contents($cupomPath);
    $nome_arquivo = $cupomPath; // Nome final para o banco
    $tipo_arquivo = 'application/pdf';

    // Conecta ao banco de dados
    


    // Prepara a consulta SQL para inserir o PDF no banco
    $sql = "INSERT INTO arquivos_pdf (nome_arquivo, conteudo, tipo_arquivo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome_arquivo, $conteudo, $tipo_arquivo);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "PDF salvo no banco de dados com sucesso!";
    } else {
        echo "Erro ao salvar o PDF no banco de dados: " . $stmt->error;
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();

    // 3. Deleta o arquivo temporário
    unlink($cupomPath);
    echo "\nArquivo temporário deletado do servidor.";
} else {
    echo "Erro: O arquivo PDF não foi gerado corretamente.";
}		
	header("Content-Disposition: inline; filename=\"" . $cupomPath . "\"");
	
}		
	
 
	   
    $cupomBinario = file_get_contents($pdfFilePath);
   
$carrinhoJson = json_encode($carrinho, JSON_UNESCAPED_UNICODE);

   
   





 
	
// Array para armazenar a contagem de cada produto

		


	
/*



*/

?>
