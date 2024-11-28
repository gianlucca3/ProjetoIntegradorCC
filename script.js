// Seleciona os elementos do DOM
const catalogo = document.getElementById('catalogo');
const carrinho = document.getElementById('carrinho');
const totalDisplay = document.getElementById('total');
const finalizarCompraButton = document.getElementById('finalizarCompra');
const pagamentoSelect = document.getElementById('pagamento');

let total = 0;
let itensCarrinho = [];

// Função para atualizar o total
function atualizarTotal() {
    totalDisplay.textContent = total.toFixed(2);
}

// Função para remover um item do carrinho
function removerDoCarrinho(index) {
    const itemRemovido = itensCarrinho.splice(index, 1)[0];
    total -= itemRemovido.preco;
    atualizarTotal();
    exibirCarrinho();
}

// Função para exibir os itens do carrinho
function exibirCarrinho() {
    carrinho.innerHTML = '';
    itensCarrinho.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `${item.nome} - R$ ${item.preco.toFixed(2)} <button onclick="removerDoCarrinho(${index})">Remover</button>`;
        carrinho.appendChild(li);
    });
}




// Função para adicionar um item ao carrinho
function adicionarAoCarrinho(nome, preco) {
    itensCarrinho.push({ nome, preco });
    total += preco;
    atualizarTotal();
    exibirCarrinho();
}

// Adiciona eventos para os botões de adicionar do catálogo
catalogo.addEventListener('click', (e) => {
    if (e.target.classList.contains('add')) {
        const item = e.target.parentElement;
        const nome = item.firstChild.textContent.trim();
        const preco = parseFloat(item.querySelector('.preco').textContent);

        adicionarAoCarrinho(nome, preco);
    }
});

// Função para finalizar a compra e enviar os dados para gerar o PDF
finalizarCompraButton.addEventListener('click', () => {
    const formaPagamento = pagamentoSelect.value;

    const dados = {
        itens: itensCarrinho,
        total: total,
        formaPagamento: formaPagamento
    };

    // Envia os dados para o servidor PHP usando Fetch
    fetch('gerar_pdf.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na resposta da rede');
        }
        return response.blob(); // Recebe o PDF como blob
    })
    .then(blob => {
        // Cria uma URL para o PDF e faz o download
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'compra.pdf';
        document.body.appendChild(a);
        a.click();
        a.remove();
    })
    .catch(error => {
        console.error('Erro ao gerar o PDF:', error);
        alert('Ocorreu um erro ao gerar o PDF.');
    });
});
