document.addEventListener('DOMContentLoaded', function() {
    // Seletores de elementos
    const summaryItemsList = document.querySelector('.summary-items-list');
    const subtotalEl = document.getElementById('summary-subtotal');
    const shippingEl = document.getElementById('summary-shipping');
    const totalEl = document.getElementById('summary-total');
    const shippingOptions = document.querySelectorAll('input[name="shipping"]');
    const paymentOptions = document.querySelectorAll('input[name="payment"]');
    const checkoutForm = document.getElementById('checkout-form');

    let subtotal = 0;

    /**
     * Pega o carrinho do localStorage.
     * Assume que você já tem uma função getCart() em cart.js
     * Se não tiver, descomente a função abaixo.
     */
    /*
    function getCart() {
        return JSON.parse(localStorage.getItem('cart')) || [];
    }
    */

    /**
     * Formata um número para o formato de moeda BRL.
     */
    function formatCurrency(value) {
        return `R$ ${value.toFixed(2).replace('.', ',')}`;
    }

    /**
     * Renderiza os itens do carrinho no resumo do pedido.
     */
    function renderSummary() {
        const cart = getCart();
        summaryItemsList.innerHTML = '';
        subtotal = 0;

        if (cart.length === 0) {
            summaryItemsList.innerHTML = '<p>Seu carrinho está vazio.</p>';
            updateTotals();
            return;
        }

        cart.forEach(item => {
            subtotal += item.price * item.quantity;
            const itemHTML = `
                <div class="summary-item">
                    <img src="${item.image}" alt="${item.name}" class="summary-item-image">
                    <div class="summary-item-details">
                        <h4 class="summary-item-name">${item.name}</h4>
                        <p class="summary-item-info">Tam: ${item.size} | Qtd: ${item.quantity}</p>
                    </div>
                    <span class="summary-item-price">${formatCurrency(item.price * item.quantity)}</span>
                </div>
            `;
            summaryItemsList.insertAdjacentHTML('beforeend', itemHTML);
        });

        updateTotals();
    }

    /**
     * Atualiza os valores de subtotal, frete e total.
     */
    function updateTotals() {
        const selectedShipping = document.querySelector('input[name="shipping"]:checked');
        const shippingCost = selectedShipping ? parseFloat(selectedShipping.value) : 0;
        const total = subtotal + shippingCost;

        subtotalEl.textContent = formatCurrency(subtotal);
        shippingEl.textContent = formatCurrency(shippingCost);
        totalEl.textContent = formatCurrency(total);
    }

    /**
     * Alterna a visibilidade dos detalhes de pagamento.
     */
    function togglePaymentDetails() {
        const selectedPayment = document.querySelector('input[name="payment"]:checked').value;
        document.querySelectorAll('.payment-details').forEach(detail => {
            detail.classList.remove('visible');
        });

        if (selectedPayment === 'card') {
            document.getElementById('credit-card-details').classList.add('visible');
        } else if (selectedPayment === 'pix') {
            document.getElementById('pix-details').classList.add('visible');
        }
    }

    // --- Event Listeners ---

    // Atualiza o total quando o frete muda
    shippingOptions.forEach(option => {
        option.addEventListener('change', updateTotals);
    });

    // Alterna os detalhes de pagamento quando a opção muda
    paymentOptions.forEach(option => {
        option.addEventListener('change', togglePaymentDetails);
    });

    // Lida com o envio do formulário
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Impede o envio real do formulário

        // Simples validação para o exemplo
        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const address = document.getElementById('address').value;

        if (!email || !name || !address) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, preencha todos os campos de contato e endereço.',
                icon: 'error',
                confirmButtonColor: '#7C3AED'
            });
            return;
        }

        // Se tudo estiver OK, mostra o SweetAlert de sucesso
        Swal.fire({
            title: "Pedido realizado!",
            text: "Obrigado por comprar na Susanoo! Você receberá os detalhes no seu email.",
            icon: "success",
            confirmButtonText: "Voltar para o Início",
            confirmButtonColor: '#8B5CF6'
        }).then((result) => {
            if (result.isConfirmed) {
                // Limpa o carrinho e redireciona
                localStorage.removeItem('cart'); 
                window.location.href = "../index.php";
            }
        });
    });

    // --- Inicialização ---
    renderSummary();
    togglePaymentDetails();
});