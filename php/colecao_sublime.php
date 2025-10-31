<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção sublime</title>
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
            <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
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
            <p class="page-subtitle">Descubra nossa coleção completa de decoração oriental</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="vasos">Vasos</button>
                <button class="filter-btn" data-filter="luminarias">Luminárias</button>
                <button class="filter-btn" data-filter="cha">Conjuntos de Chá</button>
                <button class="filter-btn" data-filter="decoracao">Decoração</button>
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
                        <img src="../assets/img/Sublimecamisa1.png" alt="Vaso Zen">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Vaso Zen</h3>
                        <p class="product-desc">Cerâmica artesanal japonesa com acabamento fosco</p>
                        <p class="price">R$ 299,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="vasos">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa2.png" alt="Vaso Dragão">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Vaso Dragão</h3>
                        <p class="product-desc">Design inspirado em escamas de dragão</p>
                        <p class="price">R$ 399,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <!-- Luminárias -->
                <div class="product-card" data-category="luminarias">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa3.png" alt="Luminária Sakura">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Luminária Sakura</h3>
                        <p class="product-desc">Papel de arroz com estampas de cerejeiras</p>
                        <p class="price">R$ 199,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="luminarias">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa4.png" alt="Lanterna Oriental">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Lanterna Susanoo</h3>
                        <p class="product-desc">Lanterna tradicional de bambu e papel</p>
                        <p class="price">R$ 149,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <!-- Conjuntos de Chá -->
                <div class="product-card" data-category="cha">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa1.png" alt="Conjunto Chá Tradicional">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Conjunto de Chá Tradicional</h3>
                        <p class="product-desc">5 peças em porcelana japonesa autêntica</p>
                        <p class="price">R$ 459,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="cha">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa2.png" alt="Bule Zen">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Bule Zen</h3>
                        <p class="product-desc">Ferro fundido com design minimalista</p>
                        <p class="price">R$ 329,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <!-- Decoração -->
                <div class="product-card" data-category="decoracao">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa3.png" alt="Espelho Oriental">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Espelho Feng Shui</h3>
                        <p class="product-desc">Moldura em madeira com entalhes orientais</p>
                        <p class="price">R$ 249,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="decoracao">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa4.png" alt="Biombo Oriental">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Biombo Dragão</h3>
                        <p class="product-desc">3 painéis com pinturas tradicionais</p>
                        <p class="price">R$ 599,90</p>
                        <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                    </div>
                </div>

                <div class="product-card" data-category="decoracao">
                    <div class="card-image">
                        <img src="../assets/img/Sublimecamisa1.png" alt="Incensário">
                        <div class="card-overlay">
                            <button class="btn-quick-view">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3>Incensário Templo</h3>
                        <p class="product-desc">Bronze artesanal com detalhes em ouro</p>
                        <p class="price">R$ 179,90</p>
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