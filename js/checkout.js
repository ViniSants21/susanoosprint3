document.addEventListener('DOMContentLoaded', function() {
    // ===================================================================
    // 1. SELETORES E VARIÁVEIS GLOBAIS
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
    // 2. LÓGICA DO CARRINHO (Recuperar e Renderizar)
    // ===================================================================
    
    // Função segura para pegar o carrinho com o nome CORRETO
    function getCart() {
        try {
            // AQUI ESTAVA O ERRO: Mudamos de 'cart' para 'susanooCart'
            const storedCart = localStorage.getItem('susanooCart');
            return storedCart ? JSON.parse(storedCart) : [];
        } catch (e) {
            console.error("Erro ao ler o carrinho:", e);
            return [];
        }
    }

    function formatCurrency(value) {
        return `R$ ${value.toFixed(2).replace('.', ',')}`;
    }

    // Função para corrigir o caminho da imagem
    function fixImagePath(imagePath) {
        if (!imagePath) return '../assets/img/placeholder.png';
        
        // Se já for link completo ou já tiver subido nível, mantém
        if (imagePath.startsWith('http') || imagePath.startsWith('../')) {
            return imagePath;
        }
        
        // Se estiver na pasta assets/..., adiciona o ../ na frente
        if (imagePath.startsWith('assets/')) {
            return '../' + imagePath;
        }

        // Remove ./ do início se houver
        return '../' + imagePath.replace(/^\.\//, '');
    }

    function renderSummary() {
        const cart = getCart();
        
        // Debug para você ver no console se pegou os itens
        console.log("Itens carregados no checkout:", cart);

        summaryItemsList.innerHTML = '';
        subtotal = 0;

        if (cart.length === 0) {
            summaryItemsList.innerHTML = '<div class="empty-cart-alert"><p>Seu carrinho está vazio.</p><a href="produtos.php" style="color:var(--primary-color);">Voltar às compras</a></div>';
            updateTotals();
            return;
        }

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            
            const imageSrc = fixImagePath(item.image);

            const itemHTML = `
                <div class="summary-item">
                    <div class="summary-item-img-wrapper">
                        <img src="${imageSrc}" alt="${item.name}" class="summary-item-image" onerror="this.src='../assets/img/placeholder.png'">
                        <span class="summary-item-qty">${item.quantity}</span>
                    </div>
                    <div class="summary-item-details">
                        <h4 class="summary-item-name">${item.name}</h4>
                        <p class="summary-item-info">Tam: ${item.size}</p>
                    </div>
                    <span class="summary-item-price">${formatCurrency(itemTotal)}</span>
                </div>
            `;
            summaryItemsList.insertAdjacentHTML('beforeend', itemHTML);
        });

        updateTotals();
    }

    function updateTotals() {
        let shippingCost = 0;
        const selectedShipping = document.querySelector('input[name="shipping"]:checked');
        
        if (selectedShipping) {
            shippingCost = parseFloat(selectedShipping.value);
        }

        const total = subtotal + shippingCost;

        if(subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);
        if(shippingEl) shippingEl.textContent = formatCurrency(shippingCost);
        if(totalEl) totalEl.textContent = formatCurrency(total);
    }

    // ===================================================================
    // 3. LÓGICA DO PAGAMENTO E FORMULÁRIO
    // ===================================================================
    function togglePaymentDetails() {
        const selectedOption = document.querySelector('input[name="payment"]:checked');
        if(!selectedOption) return;

        const selectedPayment = selectedOption.value;
        
        document.querySelectorAll('.payment-details').forEach(detail => {
            detail.classList.remove('visible');
            detail.style.display = 'none';
        });

        if (selectedPayment === 'card') {
            const cardDetails = document.getElementById('credit-card-details');
            if(cardDetails) {
                cardDetails.classList.add('visible');
                cardDetails.style.display = 'block';
            }
        } else if (selectedPayment === 'pix') {
            const pixDetails = document.getElementById('pix-details');
            if(pixDetails) {
                pixDetails.classList.add('visible');
                pixDetails.style.display = 'block';
            }
        }
    }

    if(checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const name = document.getElementById('name').value;
            const address = document.getElementById('address').value;
            const number = document.getElementById('number').value;
            const cart = getCart();

            if (cart.length === 0) {
                Swal.fire({
                    title: 'Carrinho Vazio',
                    text: 'Adicione produtos antes de finalizar.',
                    icon: 'warning',
                    confirmButtonColor: '#7C3AED'
                });
                return;
            }

            if (!email || !name || !address || !number) {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'Por favor, preencha todos os campos de entrega.',
                    icon: 'error',
                    confirmButtonColor: '#7C3AED'
                });
                return;
            }

            const selectedPayment = document.querySelector('input[name="payment"]:checked').value;

            if (selectedPayment === 'pix') {
                const fakePixKey = '00020126360014BR.GOV.BCB.PIX0114+5512999999999...';
                Swal.fire({
                    title: "Pagamento via PIX",
                    html: `
                        <p style="margin-bottom:15px;">Escaneie o QR Code ou copie a chave abaixo:</p>
                        <div style="background:#f3f3f3; padding:10px; border-radius:8px; margin-bottom:10px;">
                            <i class="fas fa-qrcode" style="font-size:3rem; color:#333;"></i>
                        </div>
                        <input type="text" value="${fakePixKey}" readonly style="width: 100%; padding: 10px; border-radius:5px; border: 1px solid #ddd; text-align: center; font-size: 0.85rem;" onclick="this.select(); document.execCommand('copy');">
                    `,
                    confirmButtonText: "Já fiz o pagamento",
                    confirmButtonColor: '#10B981',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        finalizeOrder();
                    }
                });
            } else {
                let timerInterval;
                Swal.fire({
                    title: 'Processando pagamento...',
                    html: 'Aguarde um momento.',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then((result) => {
                    finalizeOrder();
                });
            }
        });
    }

    function finalizeOrder() {
        Swal.fire({
            title: "Pedido Confirmado!",
            text: "Sua jornada Susanoo começou. Verifique seu e-mail.",
            icon: "success",
            confirmButtonText: "Voltar para Home",
            confirmButtonColor: '#7C3AED'
        }).then(() => {
            // AQUI TAMBÉM: Limpa o carrinho com o nome correto
            localStorage.removeItem('susanooCart'); 
            window.location.href = "../index.php";
        });
    }

    // ===================================================================
    // 4. LÓGICA DE CEP (ViaCEP)
    // ===================================================================
    const cepInput = document.getElementById('zip');
    
    if (cepInput) {
        cepInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.slice(0, 5) + '-' + value.slice(5, 8);
            }
            e.target.value = value;
            
            if (value.replace(/\D/g, '').length === 8) {
                fetchAddress(value.replace(/\D/g, ''));
            }
        });
    }

    async function fetchAddress(cep) {
        const addressInput = document.getElementById('address');
        const cityInput = document.getElementById('city');
        const stateInput = document.getElementById('state');
        const numberInput = document.getElementById('number');

        try {
            addressInput.value = '...';
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            
            if (data.erro) throw new Error('CEP inválido');
            
            addressInput.value = data.logradouro;
            cityInput.value = data.localidade;
            stateInput.value = data.uf;
            numberInput.focus();
            
        } catch (error) {
            addressInput.value = '';
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'CEP não encontrado',
                showConfirmButton: false,
                timer: 3000
            });
        }
    }

    // INICIALIZAÇÃO
    renderSummary();
    shippingOptions.forEach(opt => opt.addEventListener('change', updateTotals));
    paymentOptions.forEach(opt => opt.addEventListener('change', togglePaymentDetails));
    togglePaymentDetails();
});