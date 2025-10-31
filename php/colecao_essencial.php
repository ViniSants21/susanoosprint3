<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção essencial</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
</head>
<?php
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>
<body>
<!-- Navbar -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <!-- Pesquisa à esquerda -->
        <div class="nav-search">
            <input type="text" placeholder="Pesquisar...">
        </div>
        </div>

        <!-- Logo central -->
        <div class="nav-logo">
            <img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO">
        </div>

        <!-- Menu à direita -->
        <ul class="nav-menu" id="nav-menu">
            <li><a href="../index.php" class="nav-link <?php echo is_active('../index.php', $current); ?>">Home</a></li>
            <li><a href="produtos.php" class="nav-link <?php echo is_active('../produtos.php', $current); ?>">Produtos</a></li>
            <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
            <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
            <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
        </ul>

        <!-- Menu hambúrguer (mobile) -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Nossos Produtos</h1>
            <p class="page-subtitle">Descubra nossa coleção Essencial</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters">
                <button class="filter-btn active" data-filter="all">Essencial</button>
                
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section">
        <div class="container">
            <div class="products-grid">
                <!-- Vasos -->
                <div class="product-card" data-category="vasos">
                    <div class="card-image">
                        <img src="../assets/img/Camisapreta_essentials (1).png" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Camiseta Essentials Susanoo Preta</h3>
                        <p class="product-desc">Camiseta da coleção Essentials cor preto e branco</p>
                        <p class="price">R$ 109,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="vasos">
                    <div class="card-image">
                        <img src="../assets/img/Camisapreta_essentials (2).png" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Camiseta Essentials Susanoo Branca</h3>
                        <p class="product-desc">Camiseta da coleção Essentials cor branco e preto</p>
                        <p class="price">R$ 109,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <!-- Luminárias -->
                <div class="product-card" data-category="luminarias">
                    <div class="card-image">
                        <img src="../assets/img/Camisapreta_essentials (3).png" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Camiseta Essentials Susanoo Roxa Escura</h3>
                        <p class="product-desc">Camiseta da coleção Essentials cor roxa e branca</p>
                        <p class="price">R$ 109,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="luminarias">
                    <div class="card-image">
                        <img src="../assets/img/Moletom_preto.jpeg" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Moletom Essentials Susanoo Preto</h3>
                        <p class="product-desc">Moletom da coleção Essentials preto e branco</p>
                        <p class="price">R$ 149,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <!-- Conjuntos de Chá -->
                <div class="product-card" data-category="cha">
                    <div class="card-image">
                        <img src="../assets/img/Moletom_branco.jpeg" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Moletom Essentials Susanoo Branco</h3>
                        <p class="product-desc">Moletom da coleção Essentials branco e preto</p>
                        <p class="price">R$ 149,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="cha">
                    <div class="card-image">
                        <img src="../assets/img/Moletom_roxa.jpeg" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Moletom Essentials Susanoo Roxa Escura</h3>
                        <p class="product-desc">Moletom da coleção Essentials roxa escura e branco</p>
                        <p class="price">R$ 150,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <!-- Decoração -->
                <div class="product-card" data-category="decoracao">
                    <div class="card-image">
                        <img src="../assets/img/Camisapreta_essentials (1).png" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Camiseta Essentials Susanoo Preta</h3>
                        <p class="product-desc">Camiseta da coleção Essentials preto e branco</p>
                        <p class="price">R$ 109,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="decoracao">
                    <div class="card-image">
                       <img src="../assets/img/Camisapreta_essentials (2).png" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Camiseta Essentials Susanoo Branca</h3>
                        <p class="product-desc">Camiseta coleção Essentials branca e preta</p>
                        <p class="price">R$ 109,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="decoracao">
                    <div class="card-image">
                        <img src="../assets/img/Camisapreta_essentials (3).png" alt="Camisa Essential">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Camiseta Essentials Susanoo Roxa escura</h3>
                        <p class="product-desc">Camiseta da coleção Essential roxa escura e branco</p>
                        <p class="price">R$ 109,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top">
        <span>↑</span>
    </button>

    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script> <!-- ou ../js/theme.js para páginas internas -->
</body>
</html>