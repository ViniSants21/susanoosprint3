document.addEventListener('DOMContentLoaded', function() {
    // ===================================================================
    // SELETORES E VARIÁVEIS GLOBAIS
    // ===================================================================
    const summaryItemsList = document.querySelector('.summary-items-list');
    const subtotalEl = document.getElementById('summary-subtotal');
    const shippingEl = document.getElementById('summary-shipping');
    const totalEl = document.getElementById('summary-total');
    const shippingOptions = document.querySelectorAll('input[name="shipping"]');
    const paymentOptions = document.querySelectorAll('input[name="payment"]');
    const checkoutForm = document.getElementById('checkout-form');

    let subtotal = 0;

    // ===================================================================
    // LÓGICA DO CARRINHO E RESUMO DO PEDIDO
    // ===================================================================
    function getCart() {
        return JSON.parse(localStorage.getItem('cart')) || [];
    }

    function formatCurrency(value) {
        return `R$ ${value.toFixed(2).replace('.', ',')}`;
    }

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

    function updateTotals() {
        const selectedShipping = document.querySelector('input[name="shipping"]:checked');
        const shippingCost = selectedShipping ? parseFloat(selectedShipping.value) : 0;
        const total = subtotal + shippingCost;
        subtotalEl.textContent = formatCurrency(subtotal);
        shippingEl.textContent = formatCurrency(shippingCost);
        totalEl.textContent = formatCurrency(total);
    }

    // ===================================================================
    // LÓGICA DO PAGAMENTO E FORMULÁRIO
    // ===================================================================
    function togglePaymentDetails() {
        const selectedPayment = document.querySelector('input[name="payment"]:checked').value;
        document.querySelectorAll('.payment-details').forEach(detail => detail.classList.remove('visible'));
        if (selectedPayment === 'card') {
            document.getElementById('credit-card-details').classList.add('visible');
        } else if (selectedPayment === 'pix') {
            document.getElementById('pix-details').classList.add('visible');
        }
    }

    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const address = document.getElementById('address').value;
        const number = document.getElementById('number').value;

        if (!email || !name || !address || !number) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, preencha todos os campos obrigatórios.',
                icon: 'error',
                confirmButtonColor: '#7C3AED'
            });
            return;
        }

        const selectedPayment = document.querySelector('input[name="payment"]:checked').value;

        if (selectedPayment === 'pix') {
            const fakePixKey = '00020126580014br.gov.bcb.pix0136123e4567-e12b-12d1-a456-4266554400005204000053039865802BR5913SUSANOO_LOJA6008BRASILIA62070503***6304E2A4';
            Swal.fire({
                title: "Pedido realizado! Pague com PIX",
                html: `
                    <p>Aponte a câmera do seu celular para o QR Code abaixo ou copie o código.</p>
                    <input type="text" value="${fakePixKey}" readonly style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; text-align: center; cursor: pointer;" onclick="this.select(); document.execCommand('copy');">
                `,
                imageUrl: `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(fakePixKey)}`,
                imageAlt: 'QR Code para pagamento PIX',
                confirmButtonText: "Pagamento Concluído",
                confirmButtonColor: '#8B5CF6'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('cart');
                    window.location.href = "../index.php";
                }
            });
        } else {
            Swal.fire({
                title: "Pedido realizado!",
                text: "Obrigado por comprar na Susanoo! Você receberá os detalhes no seu email.",
                icon: "success",
                confirmButtonText: "Voltar para o Início",
                confirmButtonColor: '#8B5CF6'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('cart');
                    window.location.href = "../index.php";
                }
            });
        }
    });

    // ===================================================================
    // LÓGICA DO CEP (BUSCA AUTOMÁTICA E MÁSCARA)
    // ===================================================================
    const cepInput = document.getElementById('zip');
    const addressInput = document.getElementById('address');
    const numberInput = document.getElementById('number'); // NOVO
    const cityInput = document.getElementById('city');
    const stateInput = document.getElementById('state');

    const fetchAddress = async () => {
        const cep = cepInput.value.replace(/\D/g, '');
        if (cep.length !== 8) return;
        
        addressInput.value = 'Buscando...';
        cityInput.value = 'Buscando...';
        stateInput.value = '...';

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            if (data.erro) throw new Error('CEP não localizado.');
            
            // Preenche os campos de endereço, cidade e estado
            addressInput.value = data.logradouro ? `${data.logradouro}, ${data.bairro}` : '';
            cityInput.value = data.localidade || '';
            stateInput.value = data.uf || '';
            
            // ATUALIZADO: Move o foco para o campo NÚMERO
            numberInput.focus(); 
        } catch (error) {
            console.error('Erro ao buscar o CEP:', error);
            addressInput.value = '';
            cityInput.value = '';
            stateInput.value = '';
            Swal.fire({
                icon: 'error',
                title: 'CEP não encontrado',
                text: 'Por favor, verifique o CEP digitado e tente novamente.',
                confirmButtonColor: '#333'
            });
        }
    };

    cepInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    cepInput.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 5) {
            value = value.slice(0, 5) + '-' + value.slice(5, 8);
        }
        e.target.value = value;
        
        if (value.replace(/\D/g, '').length === 8) {
            fetchAddress();
        }
    });

    // ===================================================================
    // INICIALIZAÇÃO DAS FUNÇÕES
    // ===================================================================
    renderSummary();
    togglePaymentDetails();
    shippingOptions.forEach(option => option.addEventListener('change', updateTotals));
    paymentOptions.forEach(option => option.addEventListener('change', togglePaymentDetails));
});