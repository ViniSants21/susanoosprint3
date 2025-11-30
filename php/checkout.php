<?php
// ==========================================================
// 1. O PHP DEVE FICAR NO TOPO ABSOLUTO (ANTES DO HTML)
// ==========================================================
if (!isset($_SESSION)) {
    session_start();
}

// Lógica para o link ativo do menu
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Susanoo</title>

    <!-- CSS Principal e da Página de Checkout -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/checkout-style.css">
    
    <!-- Ícones e Fontes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Script de Tema (Dark/Light) -->
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>

    <!-- SweetAlert2 (Para alertas bonitos) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}

        /* --- CSS EXTRA: CORREÇÃO VISUAL DO RESUMO --- */
        .summary-item {
            display: flex !important;
            align-items: center !important;
            padding: 15px 0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            gap: 15px !important;
        }
        .summary-item > div:first-child { width: 64px !important; height: 64px !important; flex-shrink: 0; position: relative; }
        .summary-item img { border-radius: 8px !important; border: 1px solid rgba(255, 255, 255, 0.1); width:100%; height:100%; object-fit:cover; }
        .summary-item span[class*="qty"] {
            background: #8B5CF6 !important; color: #fff !important;
            width: 20px !important; height: 20px !important;
            top: -8px !important; right: -8px !important;
            position: absolute; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 11px !important;
        }
        .summary-item h4 { font-size: 0.95rem !important; color: inherit !important; margin: 0; }
        .summary-item p { font-size: 0.85rem !important; color: #a0a0a0 !important; margin: 0; }
        .summary-item > span:last-child { font-size: 0.95rem !important; font-weight: 700 !important; color: #fff !important; white-space: nowrap; margin-left: auto; }
        .summary-items-list { max-height: 350px; overflow-y: auto; padding-right: 5px; }
        
        /* Estilo da Linha de Desconto */
        #summary-discount-row { color: #10B981; font-weight: bold; display: flex; justify-content: space-between; margin-bottom: 10px; }
    </style>
</head>
<body class="checkout-page-body">

<!-- Navbar -->
<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <div class="nav-search">
            <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
            <button type="button" class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
        </div>
        <div class="nav-logo"><a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a></div>
        <div class="nav-right-group">
            <ul class="nav-menu" id="nav-menu">
                <li><a href="../index.php" class="nav-link <?php echo is_active('index.php', $current); ?>">Home</a></li>
                <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
            </ul>
            <div class="nav-icons">
                    <div class="profile-dropdown-wrapper">
                        <?php 
                        if (!isset($_SESSION['user_id'])): 
                        ?>
                        <a href="php/login.php" class="nav-icon-link" aria-label="Login"><i class="fas fa-user"></i></a>
                        <div class="profile-dropdown-menu">
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="../php/registro.php"><i class="fas fa-user-plus"></i> Registrar</a></li>
                                <li class="dropdown-link-item"><a href="../php/login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                    <a href="#" class="nav-icon-link" aria-label="Perfil">
                    <img src="<?php echo $_SESSION['foto']; ?>" class="dropdown-avatar" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                    </a>
                    <div class="profile-dropdown-menu">
                        <div class="dropdown-header">
                        <img src="<?php echo $_SESSION['foto']; ?>" alt="Avatar" class="dropdown-avatar">
                        <div>
                            <div class="dropdown-user-name"><?php echo $_SESSION['nome']; ?></div>
                            <div class="dropdown-user-email"><?php echo $_SESSION['email']; ?></div>
                        </div>
                        </div>
                        <ul class="dropdown-links">
                            <li class="dropdown-link-item"><a href="../php/perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                            <li class="dropdown-link-item"><a href="../php/configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                            <li class="dropdown-link-item"><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>

<!-- Conteúdo Principal do Checkout -->
<main class="checkout-main-content">
    <div class="container">
        <div class="checkout-header">
            <h1 class="checkout-title">Finalizar Compra</h1>
            <a href="carrinho.php" class="back-to-cart"><i class="fas fa-arrow-left"></i> Voltar ao Carrinho</a>
        </div>

        <form id="checkout-form" class="checkout-layout">
            <!-- Coluna Esquerda: Informações de Entrega -->
            <div class="checkout-details">
                <section class="checkout-section">
                    <h2><i class="fas fa-user-circle"></i> Informações de Contato</h2>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="seu@email.com" required value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" id="name" placeholder="Seu nome completo" required value="<?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>">
                    </div>
                </section>

                <section class="checkout-section">
                    <h2><i class="fas fa-map-marker-alt"></i> Endereço de Entrega</h2>
                    <div class="form-group">
                        <label for="zip">CEP</label>
                        <input type="text" id="zip" placeholder="00000-000" required maxlength="9">
                    </div>
                    <div class="form-group">
                        <label for="address">Endereço</label>
                        <input type="text" id="address" placeholder="Rua, Avenida, etc." required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="number">Número</label>
                            <input type="text" id="number" placeholder="Ex: 123" required>
                        </div>
                        <div class="form-group">
                            <label for="complement">Complemento</label>
                            <input type="text" id="complement" placeholder="Apto, Bloco, etc. (Opcional)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">Cidade</label>
                            <input type="text" id="city" placeholder="Sua cidade" required>
                        </div>
                        <div class="form-group">
                            <label for="state">Estado</label>
                            <input type="text" id="state" placeholder="UF" required maxlength="2">
                        </div>
                    </div>
                </section>

                <section class="checkout-section">
                    <h2><i class="fas fa-truck"></i> Método de Envio</h2>
                    <div class="shipping-option">
                        <input type="radio" id="sedex" name="shipping" value="25.00" checked>
                        <label for="sedex"><span>SEDEX</span><span>R$ 25,00</span></label>
                    </div>
                    <div class="shipping-option">
                        <input type="radio" id="pac" name="shipping" value="15.00">
                        <label for="pac"><span>PAC</span><span>R$ 15,00</span></label>
                    </div>
                </section>
            </div>

            <!-- Coluna Direita: Resumo e Pagamento -->
            <div class="order-summary-wrapper">
                <div class="order-summary-card">
                    <h2 class="summary-title">Resumo do Pedido</h2>
                    <div class="summary-items-list">
                        <!-- Itens do carrinho serão inseridos aqui via JS -->
                    </div>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="summary-subtotal">R$ 0,00</span>
                    </div>
                    
                    <!-- LINHA DO CUPOM -->
                    <div class="summary-row" id="summary-discount-row" style="display:none; color: #10B981;">
                        <span>Desconto (Cupom)</span>
                        <span id="summary-discount-val">- R$ 0,00</span>
                    </div>

                    <div class="summary-row">
                        <span>Frete</span>
                        <span id="summary-shipping">R$ 25,00</span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span id="summary-total" class="total-price">R$ 0,00</span>
                    </div>

                    <div class="payment-section">
                        <h2><i class="fas fa-credit-card"></i> Pagamento</h2>
                        <div class="payment-option">
                            <input type="radio" id="credit-card" name="payment" value="card" checked>
                            <label for="credit-card">Cartão de Crédito</label>
                        </div>
                        <div id="credit-card-details" class="payment-details visible">
                            <div class="form-group">
                                <label for="card-number">Número do Cartão</label>
                                <input type="text" id="card-number" placeholder="0000 0000 0000 0000">
                            </div>
                            <div class="form-group">
                                <label for="card-name">Nome no Cartão</label>
                                <input type="text" id="card-name" placeholder="Como está no cartão">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card-expiry">Validade</label>
                                    <input type="text" id="card-expiry" placeholder="MM/AA">
                                </div>
                                <div class="form-group">
                                    <label for="card-cvc">CVC</label>
                                    <input type="text" id="card-cvc" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="pix" name="payment" value="pix">
                            <label for="pix">PIX</label>
                        </div>
                        <div id="pix-details" class="payment-details">
                            <p>O QR Code para pagamento será exibido após a confirmação do pedido.</p>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-checkout">Finalizar e Pagar</button>
                </div>
            </div>
        </form>
    </div>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-logo"><h3>須佐能乎</h3><span>SUSANOO</span></div>
                <p>Desperte seu poder interior com estilo único e elegância oriental.</p>
                <div class="social-links">
                    <a href="#" class="social-link">Instagram</a>
                    <a href="#" class="social-link">Facebook</a>
                    <a href="#" class="social-link">X</a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Navegação</h4>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="colecoes.php">Coleções</a></li>
                    <li><a href="sobre.php">Sobre Nós</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Atendimento</h4>
                <ul>
                    <li><a href="contato.php">Contato</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Trocas e Devoluções</a></li>
                    <li><a href="#">Política de Privacidade</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Newsletter</h4>
                <p>Receba novidades e ofertas exclusivas</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Seu email" required>
                    <button type="submit" class="btn btn-primary">Inscrever</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom"><p>&copy; 2024 Susanoo. Todos os direitos reservados.</p></div>
    </div>
</footer>

<script src="../js/cart.js"></script>
<script src="../js/script.js"></script>
<script src="../js/theme.js"></script>

<!-- SCRIPT DE CHECKOUT + INTEGRAÇÃO COM BACKEND -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log(">>> Checkout Iniciado <<<");

    const summaryItemsList = document.querySelector('.summary-items-list');
    const subtotalEl = document.getElementById('summary-subtotal');
    const shippingEl = document.getElementById('summary-shipping');
    const totalEl = document.getElementById('summary-total');
    const shippingOptions = document.querySelectorAll('input[name="shipping"]');
    const paymentOptions = document.querySelectorAll('input[name="payment"]');
    const checkoutForm = document.getElementById('checkout-form');
    
    const discountRow = document.getElementById('summary-discount-row');
    const discountValEl = document.getElementById('summary-discount-val');

    let subtotal = 0;

    // --- FUNÇÕES AUXILIARES ---
    function getCart() {
        const raw = localStorage.getItem('susanooCart');
        if (!raw) return [];
        try { return JSON.parse(raw); } catch (e) { return []; }
    }

    function formatCurrency(value) {
        return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    function fixImagePath(imagePath) {
        if (!imagePath) return '../assets/img/placeholder.png';
        if (imagePath.startsWith('http') || imagePath.startsWith('../')) return imagePath;
        if (imagePath.startsWith('assets/')) return '../' + imagePath;
        return '../' + imagePath.replace(/^\.\//, '');
    }

    // --- RENDERIZAR ITENS ---
    function renderSummary() {
        const cart = getCart();
        
        if (!summaryItemsList) return;
        summaryItemsList.innerHTML = '';
        subtotal = 0;

        if (cart.length === 0) {
            summaryItemsList.innerHTML = '<div style="padding:1rem; color:#888;">Seu carrinho está vazio.</div>';
            updateTotals();
            return;
        }

        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            const imageSrc = fixImagePath(item.image);

            const itemHTML = `
                <div class="summary-item">
                    <div>
                        <img src="${imageSrc}" alt="${item.name}">
                        <span class="qty">${item.quantity}</span>
                    </div>
                    <div style="flex:1;">
                        <h4>${item.name}</h4>
                        <p>Tam: ${item.size}</p>
                    </div>
                    <span>${formatCurrency(itemTotal)}</span>
                </div>
            `;
            summaryItemsList.insertAdjacentHTML('beforeend', itemHTML);
        });

        updateTotals();
    }

    // --- CÁLCULO TOTAL ---
    function updateTotals() {
        let shippingCost = 0;
        let discountAmount = 0;

        // Frete
        const selectedShipping = document.querySelector('input[name="shipping"]:checked');
        if (selectedShipping) {
            shippingCost = parseFloat(selectedShipping.value);
        }

        // Cupom
        const activeCoupon = localStorage.getItem('susanooDiscount');
        if (activeCoupon === 'SUSANOO30') {
            discountAmount = subtotal * 0.30; // 30%
            if(discountRow) {
                discountRow.style.display = 'flex';
                discountValEl.textContent = `- ${formatCurrency(discountAmount)}`;
            }
        } else {
            if(discountRow) discountRow.style.display = 'none';
        }

        const total = subtotal + shippingCost - discountAmount;

        if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);
        if (shippingEl) shippingEl.textContent = formatCurrency(shippingCost);
        if (totalEl) totalEl.textContent = formatCurrency(total);
        
        return total; // Retorna o valor numérico para uso no envio
    }

    // --- UI PAGAMENTO ---
    function togglePaymentDetails() {
        const selectedOption = document.querySelector('input[name="payment"]:checked');
        if (!selectedOption) return;
        
        document.querySelectorAll('.payment-details').forEach(d => {
            d.classList.remove('visible');
            d.style.display = 'none';
        });

        const targetId = selectedOption.value === 'card' ? 'credit-card-details' : 'pix-details';
        const target = document.getElementById(targetId);
        if (target) {
            target.classList.add('visible');
            target.style.display = 'block';
        }
    }

    // --- ENVIO DO FORMULÁRIO ---
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // 1. Validação de Campos
            const email = document.getElementById('email').value;
            const name = document.getElementById('name').value;
            const address = document.getElementById('address').value;
            const number = document.getElementById('number').value;

            if (!email || !name || !address || !number) {
                Swal.fire('Erro', 'Preencha todos os campos obrigatórios de entrega.', 'error');
                return;
            }

            // 2. Preparar Dados
            const cart = getCart();
            if(cart.length === 0) {
                Swal.fire('Erro', 'Seu carrinho está vazio.', 'error');
                return;
            }

            const finalTotal = updateTotals(); // Recalcula o valor exato
            const selectedPayment = document.querySelector('input[name="payment"]:checked').value;
            
            const orderPayload = {
                cliente: { nome: name, email: email },
                itens: cart,
                total: finalTotal
            };

            // 3. Função para Enviar ao Banco
            const sendOrder = () => {
                Swal.fire({
                    title: 'Processando Pedido...',
                    text: 'Aguarde um momento.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                // Envia para o arquivo PHP que cria o pedido no banco
                fetch('processar_pedido.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(orderPayload)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Pedido Confirmado!',
                            text: 'Seu pedido foi salvo e processado com sucesso!',
                            icon: 'success',
                            confirmButtonColor: '#8B5CF6'
                        }).then(() => {
                            localStorage.removeItem('susanooCart'); // Limpa carrinho
                            localStorage.removeItem('susanooDiscount'); // Limpa cupom
                            window.location.href = '../index.php';
                        });
                    } else {
                        Swal.fire('Erro', data.message || 'Erro ao salvar pedido.', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Erro', 'Não foi possível conectar ao servidor.', 'error');
                });
            };

            // 4. Fluxo de Pagamento
            if (selectedPayment === 'pix') {
                const fakePixKey = '00020126360014BR.GOV.BCB.PIX0114...SUSANOO...'; 
                Swal.fire({
                    title: "Pagamento via PIX",
                    html: `
                        <p style="margin-bottom:10px;">Escaneie o QR Code ou copie a chave:</p>
                        <div style="background:#f3f3f3; padding:15px; border-radius:8px; margin-bottom:10px;">
                            <i class="fas fa-qrcode" style="font-size:3rem; color:#333;"></i>
                        </div>
                        <input type="text" value="${fakePixKey}" readonly style="width:100%; padding:8px; text-align:center; border:1px solid #ddd; border-radius:4px;">
                        <p style="font-size:0.85rem; color:#666; margin-top:10px;">O pedido será processado após a confirmação.</p>
                    `,
                    confirmButtonText: "Já realizei o pagamento",
                    confirmButtonColor: '#10B981',
                    showCancelButton: true,
                    cancelButtonText: "Cancelar"
                }).then((r) => { 
                    if(r.isConfirmed) sendOrder(); 
                });
            } else {
                // Simulação de cartão (envia direto)
                sendOrder();
            }
        });
    }

    // --- CEP (ViaCEP) ---
    const cepInput = document.getElementById('zip');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            if(val.length > 5) val = val.slice(0,5)+'-'+val.slice(5,8);
            e.target.value = val;
            if(val.replace(/\D/g,'').length === 8) {
                fetch(`https://viacep.com.br/ws/${val.replace(/\D/g,'')}/json/`)
                    .then(r=>r.json())
                    .then(d => {
                        if(!d.erro) {
                            document.getElementById('address').value = d.logradouro;
                            document.getElementById('city').value = d.localidade;
                            document.getElementById('state').value = d.uf;
                            document.getElementById('number').focus();
                        }
                    });
            }
        });
    }

    // --- INIT ---
    renderSummary();
    shippingOptions.forEach(opt => opt.addEventListener('change', updateTotals));
    paymentOptions.forEach(opt => opt.addEventListener('change', togglePaymentDetails));
    togglePaymentDetails();
});
</script>
</body>
</html>