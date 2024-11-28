// carrega o carrinho do localStorage ou inicializa como array vazio
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

// Função para adicionar um produto ao carrinho
function adicionarAoCarrinho(nomeProduto, quantidade) {
    // Verifica se o produto já existe no carrinho
    const produtoExistente = carrinho.find(produto => produto.nome === nomeProduto);
    
    if (produtoExistente) {
        // Se o produto já existir, apenas aumenta a quantidade
        produtoExistente.quantidade += quantidade;
    } else {
        // Caso o produto não exista, cria um novo objeto de produto e adiciona ao carrinho
        const produto = {
            nome: nomeProduto,
            quantidade: quantidade,
            preco: getPrecoProduto(nomeProduto) // Obtém o preço do produto
        };
        carrinho.push(produto); // Adiciona o produto ao carrinho
    }

    // Atualiza o carrinho no localStorage e a visualização
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarCarrinho(); // Atualiza a visualização do carrinho
}
// Função para obter o preço do produto com base no nome
function getPrecoProduto(nomeProduto) {
    switch (nomeProduto) {
        case 'Pão Francês': return 1.50;
        case 'Croissant': return 3.00;
        case 'Bolo de Chocolate': return 5.00;
        case 'Pão de Queijo': return 2.50;
        case 'Torta de Maçã': return 4.00;
        case 'Biscoito': return 2.00;
        default: return 0;
    }
}

// Função para atualizar a exibição do carrinho
function atualizarCarrinho() {
    const carrinhoDiv = document.getElementById('carrinho');
    const totalSpan = document.getElementById('total');
    const finalizarCompraBtn = document.getElementById('finalizarCompra'); // Botão "Finalizar Compra"
    
    carrinhoDiv.innerHTML = ''; // Limpa o conteúdo do carrinho

    document.getElementById('finalizarCompra').addEventListener('click', function () {
    if (carrinho.length === 0) {
        // Seleciona o elemento da mensagem
        const mensagemDiv = document.getElementById('mensagem');

        // Define a mensagem
        mensagemDiv.innerText = 'O carrinho está vazio! Adicione itens antes de finalizar a compra.';
        mensagemDiv.style.display = 'block';

		
		  // Esconde a mensagem após 3 segundos
        setTimeout(() => {
		
		 
            mensagemDiv.style.display = 'none';
			
			window.location.href = "home.php"; // Link para o site oficial do PIX
		
        }, 3000);
		
		
		
		

      
    }
	
});
		
 
        let total = 0;
        const contadorProdutos = {}; // Objeto para acumular quantidades e calcular valores

        // Soma as quantidades e valores dos itens repetidos
        carrinho.forEach(produto => {
            const quantidade = produto.quantidade || 1; // Garante que a quantidade nunca seja undefined
            const preco = produto.preco || 0; // Garante que o preço nunca seja undefined

            if (contadorProdutos[produto.nome]) {
                contadorProdutos[produto.nome].quantidade += quantidade;
                contadorProdutos[produto.nome].total += preco * quantidade;
            } else {
                contadorProdutos[produto.nome] = {
                    quantidade: quantidade,
                    preco: preco,
                    total: preco * quantidade,
                };
            }
        });

        // Itera sobre os produtos acumulados e os adiciona à interface
        Object.keys(contadorProdutos).forEach((nomeProduto) => {
            const produto = contadorProdutos[nomeProduto];
            const item = document.createElement('div');
            item.innerHTML = `
                <div class="produto">
				<h3>${nomeProduto}</h3>
                    <img src="${getImagePath(nomeProduto)}" alt="${nomeProduto}">
                    <div class="detalhes-produto">
                        
						</div>
                    <div class="botoes-quantidade">
                        
						<button onclick="alterarQuantidade('${nomeProduto}', 'diminuir')">-</button>
                         <span id="quantidade-${nomeProduto}">${produto.quantidade}</span>
						<button onclick="alterarQuantidade('${nomeProduto}', 'aumentar')">+</button>
                    </div>
						
                        <p>Unidade: R$ ${produto.preco.toFixed(2)}</p>
                        <p>Sub-total: R$ ${produto.total.toFixed(2)}</p>
                    
                    <button onclick="removerDoCarrinho('${nomeProduto}')">Remover</button>
                </div>
            `;

            carrinhoDiv.appendChild(item); // Adiciona o item ao carrinho
            total += produto.total; // Soma o preço total de cada item ao total geral
        });

        totalSpan.innerText = total.toFixed(2); // Exibe o total atualizado
        finalizarCompraBtn.disabled = false; // Habilita o botão de finalizar
    
}

// Função para alterar a quantidade de um produto
function alterarQuantidade(nomeProduto, acao) {
    const produtoIndex = carrinho.findIndex(produto => produto.nome === nomeProduto);
    
    if (produtoIndex !== -1) {
        if (acao === 'aumentar') {
            carrinho[produtoIndex].quantidade++;
        } else if (acao === 'diminuir' && carrinho[produtoIndex].quantidade > 1) {
            carrinho[produtoIndex].quantidade--;
        }

        localStorage.setItem('carrinho', JSON.stringify(carrinho)); // Atualiza o localStorage
        atualizarCarrinho(); // Atualiza a exibição do carrinho
    }
}

// Função para retornar o caminho da imagem com base no nome do produto
function getImagePath(nome) {
    switch (nome) {
        case 'Pão Francês': return 'pao.jpg';
        case 'Croissant': return 'croissant.jpg';
        case 'Bolo de Chocolate': return 'bolo.jpg';
        case 'Pão de Queijo': return 'pao_de_queijo.jpg';
        case 'Torta de Maçã': return 'torta.jpg';
        case 'Biscoito': return 'biscoito.jpg';
        default: return ''; // Imagem padrão
    }
}

// Função para remover um item do carrinho
function removerDoCarrinho(nomeProduto) {
    carrinho = carrinho.filter(produto => produto.nome !== nomeProduto); // Filtra o produto a ser removido
    localStorage.setItem('carrinho', JSON.stringify(carrinho)); // Atualiza o localStorage
    atualizarCarrinho(); // Atualiza a exibição do carrinho
}

// Chama a função de atualização do carrinho ao carregar a página
atualizarCarrinho();

// mostra opções de pagamento ao clicar em "finalizar compra"
document.getElementById('finalizarCompra').addEventListener('click', function() {
    document.getElementById('metodoPagamento').style.display = 'block';
});

// exibe o formulário de pagamento conforme o método selecionado
function mostrarFormulario(metodo) {
    const formulario = document.getElementById('formularioPagamento');
    const titulo = document.getElementById('tituloPagamento');
    const camposCartao = document.getElementById('camposCartao');
    
    formulario.style.display = 'block';
    camposCartao.style.display = 'none';
	
	if (carrinho.length === 0) { // Verifica se o carrinho está vazio
        // Exibe mensagem de erro
        const mensagemDiv = document.getElementById('mensagem');
        mensagemDiv.innerText = 'O carrinho está vazio! Por favor, adicione itens antes de finalizar.';
        mensagemDiv.style.display = 'block';

        // Esconde a mensagem após 3 segundos
        setTimeout(() => {
            mensagemDiv.style.display = 'none';
        }, 3000);
        return; // Não prossegue com a lógica
    }		
    if (metodo === 'PIX') {
		setTimeout(() => {
			window.location.href = "./cupom_fiscal.pdf"; // Link para o site oficial do PIX
			
			
			
			esvaziarCarrinho();
		}, 3000);
		  
		setTimeout(() => {
            enviarParaPHP('PIX'); // envia dados para o PHP
			
        }, 1000);
    } else if (metodo === 'CARTAO') {
        titulo.innerText = 'Preencha os dados do Cartão de Crédito/Débito';
        camposCartao.style.display = 'block';
    }
}

// Função para esvaziar o carrinho
function esvaziarCarrinho() {
    carrinho = []; // Limpa a array do carrinho
    localStorage.setItem('carrinho', JSON.stringify(carrinho)); // Atualiza o localStorage
    atualizarCarrinho(); // Atualiza a interface
}



document.getElementById('finalizarCompra').addEventListener('click', function() {
    document.getElementById('metodoPagamento').style.display = 'block';
});



//finalizar compra
function finalizarCompra() {
    const nome = document.getElementById('nome').value;
    const cpf = document.getElementById('cpf').value;
    const numeroCartao = document.getElementById('numeroCartao').value;
    const cvv = document.getElementById('cvv').value;
    const dataVencimento = document.getElementById('dataVencimento').value;
    
    const mensagemDiv = document.getElementById('mensagem');
    mensagemDiv.innerText = '';

    if (!nome || !cpf || !numeroCartao || !cvv || !dataVencimento) {
        mensagemDiv.innerText = 'Preencha todos os dados.';
        return;
    }
	  
		setTimeout(() => {
           
			
      
	
		enviarParaPHP('Cartão');
		
	alert('Compra finalizada, cartão!');
		esvaziarCarrinho();
        window.location.href = 'cupom_fiscal.pdf';
	  }, 2000);
/*
    if (nome === 'teste') {
        
    } else {
        mensagemDiv.innerText = 'Dados inválidos. Tente novamente.';
    }
	*/
}

// função para enviar os dados para o PHP

function enviarParaPHP(metodoPagamento) {
    const dados = {
        carrinho: carrinho,
        metodoPagamento: metodoPagamento
		
    };

    console.log("Enviando dados para o PHP:", dados); // Log para verificar os dados

	
	
	
	
	

    fetch('processar_compra.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
		
		
    })
    .then(response => {
        console.log("Resposta recebida do PHP:", response); // Log da resposta
        return response.json();
	
		
		
		//esvaziarCarrinho();
    })
    .then(data => {
        console.log("Dados convertidos para JSON:", data); // Log dos dados convertidos
        if (data.sucesso) {
			
            window.location.href = 'cupom_fiscal.pdf';
        } else {
            alert('Erro ao finalizar a compra.');
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
    });
	// Função para esvaziar o carrinho e atualizar o localStorage


}

