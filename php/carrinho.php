<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Susanoo</title>

    <!-- CSS Principal e da Página de Carrinho -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/carrinho-style.css">
    
    <!-- Ícones e Fontes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>

    <!-- Estilos locais para o ícone de pesquisa -->
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
    </style>
</head>
<body class="cart-page-body">

<?php
// Bloco PHP para a lógica da navbar
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>

<!-- Navbar Padrão de Páginas Internas com Dropdown -->
<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <!-- Substitua/inserir aqui o campo de pesquisa -->
        <div class="nav-search">
            <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
            <button class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
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
                    <a href="login.php" class="nav-icon-link" aria-label="Login"><i class="fas fa-user"></i></a>
                    <div class="profile-dropdown-menu">
                        <div class="dropdown-header">
                            <img src="../assets/img/avatar.png" alt="Avatar" class="dropdown-avatar">
                            <div>
                                <div class="dropdown-user-name">Seu Nome</div>
                                <div class="dropdown-user-email">seu@email.com</div>
                            </div>
                        </div>
                        <ul class="dropdown-links">
                            <li class="dropdown-link-item"><a href="perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                            <li class="dropdown-link-item"><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                        </ul>
                    </div>
                </div>
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>

    <!-- Conteúdo Principal do Carrinho -->
    <main class="cart-main-content">
        <div class="container">
            <div class="cart-header">
                <h1 class="cart-title">Seu Carrinho</h1>
                <a href="produtos.php" class="continue-shopping">Continuar Comprando <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="cart-layout">
                <!-- Coluna Esquerda: Itens do Carrinho -->
                <div class="cart-items-wrapper">
                    
                   

                </div>

                <!-- Coluna Direita: Resumo do Pedido -->
                <div class="order-summary-wrapper">
                    <div class="order-summary-card">
                        <h2 class="summary-title">Resumo do Pedido</h2>
                        <div class="summary-row">
                            <span>Subtotal (2 itens)</span>
                            <span class="summary-value">R$ 499,80</span>
                        </div>
                        <div class="summary-row">
                            <span>Frete</span>
                            <span class="summary-value">A calcular</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span class="summary-value total-price">R$ 499,80</span>
                        </div>
                        <div class="coupon-section">
                            <label for="coupon">Cupom de Desconto</label>
                            <div class="coupon-input-group">
                                <input type="text" id="coupon" placeholder="Insira o código">
                                <button class="btn btn-secondary">Aplicar</button>
                            </div>
                        </div>
                        <a href="../php/checkout.php"><button class="btn btn-primary btn-checkout">Ir para Checkout</button></a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    
        <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <h3>須佐能乎</h3>
                        <span>SUSANOO</span>
                    </div>
                    <p>Desperte seu poder interior com estilo único e elegância oriental.</p>
                    <div class="social-links">
                        <a href="#" class="social-link">Instagram</a>
                        <a href="#" class="social-link">Facebook</a>
                        <a href="#" class="social-link">Twitter</a>
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
            
            <div class="footer-bottom">
                <p>&copy; 2024 Susanoo. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
<!-- ... seu footer ... -->

    <script src="../js/cart.js"></script> <!-- <<< ADICIONE O SCRIPT DO CARRINHO -->
    
    <!-- Novo script para popular a página do carrinho -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartWrapper = document.querySelector('.cart-items-wrapper');
            const summarySubtotal = document.querySelector('.summary-row .summary-value');
            const summaryTotal = document.querySelector('.summary-total .total-price');
            const summaryItemCount = document.querySelector('.summary-row span:first-child');

            function renderCart() {
                const cart = getCart();
                cartWrapper.innerHTML = ''; // Limpa a lista antes de renderizar

                if (cart.length === 0) {
                    cartWrapper.innerHTML = '<p class="empty-cart-message">Seu carrinho está vazio.</p>';
                    summarySubtotal.textContent = 'R$ 0,00';
                    summaryTotal.textContent = 'R$ 0,00';
                    summaryItemCount.textContent = 'Subtotal (0 itens)';
                    return;
                }
                
                let subtotal = 0;

                cart.forEach(item => {
                    subtotal += item.price * item.quantity;
                    const itemHTML = `
                        <div class="cart-item" data-item-id="${item.id}">
                            <img src="${item.image}" alt="${item.name}" class="item-image">
                            <div class="item-details">
                                <h3 class="item-name">${item.name}</h3>
                                <p class="item-category">Tamanho: ${item.size}</p>
                                <div class="quantity-control">
                                    <button class="quantity-btn minus">-</button>
                                    <input type="number" class="quantity-input" value="${item.quantity}" min="1">
                                    <button class="quantity-btn plus">+</button>
                                </div>
                            </div>
                            <div class="item-price-remove">
                                <p class="item-price">R$ ${(item.price * item.quantity).toFixed(2).replace('.', ',')}</p>
                                <button class="remove-item"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    `;
                    cartWrapper.insertAdjacentHTML('beforeend', itemHTML);
                });

                // Atualiza o resumo do pedido
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                summarySubtotal.textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
                summaryTotal.textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
                summaryItemCount.textContent = `Subtotal (${totalItems} itens)`;
            }

            // Lógica para os botões de quantidade e remoção
            cartWrapper.addEventListener('click', function(e) {
                const target = e.target;
                const cartItem = target.closest('.cart-item');
                if (!cartItem) return;

                const itemId = cartItem.dataset.itemId;
                let cart = getCart();
                const itemIndex = cart.findIndex(item => item.id === itemId);
                if (itemIndex === -1) return;

                if (target.classList.contains('plus')) {
                    cart[itemIndex].quantity++;
                } else if (target.classList.contains('minus')) {
                    if (cart[itemIndex].quantity > 1) {
                        cart[itemIndex].quantity--;
                    } else {
                        // Se a quantidade for 1 e clicar em menos, remove o item
                        cart.splice(itemIndex, 1);
                    }
                } else if (target.closest('.remove-item')) {
                    cart.splice(itemIndex, 1);
                }

                saveCart(cart);
                renderCart(); // Re-renderiza o carrinho com os novos dados
                updateCartIcon(); // Atualiza o ícone na navbar
            });
            
            // Renderiza o carrinho assim que a página carrega
            renderCart();
        });
    </script>
</body>
</html>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script> <!-- ou ../js/theme.js para páginas internas -->
</body>
</html>