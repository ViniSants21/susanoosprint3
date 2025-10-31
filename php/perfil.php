<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/configuracoes-style.css"> <!-- Reutilizando o CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
</head>
<body class="settings-page-body">

<?php
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>

<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <div class="nav-search"><input type="text" placeholder="Pesquisar..."></div>
        <div class="nav-logo"><a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a></div>
        <div class="nav-right-group">
            <ul class="nav-menu" id="nav-menu">
                <li><a href="../index.php" class="nav-link">Home</a></li>
                <li><a href="produtos.php" class="nav-link">Produtos</a></li>
                <li><a href="colecoes.php" class="nav-link">Coleções</a></li>
                <li><a href="sobre.php" class="nav-link">Sobre</a></li>
                <li><a href="contato.php" class="nav-link">Contato</a></li>
            </ul>
            <div class="nav-icons">
                <div class="profile-dropdown-wrapper">
                    <a href="login.php" class="nav-icon-link" aria-label="Login"><i class="fas fa-user"></i></a>
                    <div class="profile-dropdown-menu">
                        <div class="dropdown-header">
                            <img src="../assets/img/avatar.png" alt="Avatar" class="dropdown-avatar">
                            <div><div class="dropdown-user-name">Seu Nome</div><div class="dropdown-user-email">seu@email.com</div></div>
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

    <main class="settings-main-content">
        <div class="container">
            <div class="settings-header"><h1>Minha Conta</h1></div>
            <div class="settings-layout">
                <aside class="settings-nav">
                    <ul>
                        <!-- Marcamos o link de Perfil como ativo -->
                        <li><a href="perfil.php" class="active"><i class="fas fa-user-circle"></i> Meu Perfil</a></li>
                        <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                    </ul>
                </aside>
                <div class="settings-content">
                    
                    <!-- Painel de Perfil -->
                    <section class="settings-panel active">
                        <!-- Card com informações do usuário -->
                        <div class="profile-info-card">
                            <img src="../assets/img/avatar.png" alt="Avatar do Usuário" class="profile-info-avatar">
                            <div class="profile-info-details">
                                <h3>Seu Nome</h3>
                                <p>seu@email.com</p>
                            </div>
                        </div>

                        <h2>Histórico de Pedidos</h2>
                        <div class="order-history-list">
                            <!-- Pedido Exemplo 1 -->
                            <div class="order-item-card">
                                <div class="order-item-header">
                                    <h4>Pedido <span>#SUSANOO-12345</span></h4>
                                    <span class="order-status">Entregue</span>
                                </div>
                                <div class="order-item-body">
                                    <div class="order-products-preview">
                                        <img src="../assets/img/costafoto.png" alt="Produto 1" class="order-product-img">
                                        <img src="../assets/img/calca.png" alt="Produto 2" class="order-product-img">
                                    </div>
                                    <span>Total: R$ 499,80</span>
                                    <a href="#" class="order-details-link">Ver Detalhes</a>
                                </div>
                            </div>
                            <!-- Pedido Exemplo 2 -->
                            <div class="order-item-card">
                                <div class="order-item-header">
                                    <h4>Pedido <span>#SUSANOO-12333</span></h4>
                                    <span class="order-status pending">Pendente</span>
                                </div>
                                <div class="order-item-body">
                                    <div class="order-products-preview">
                                        <img src="../assets/img/bone.png" alt="Produto 1" class="order-product-img">
                                    </div>
                                    <span>Total: R$ 459,90</span>
                                    <a href="#" class="order-details-link">Ver Detalhes</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

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
    
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script>
</body>
</html>