<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susanoo - Estilo Oriental Moderno</title>

    <!-- Folha de Estilo Principal -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Fontes e Ícones Externos -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Script para Carregamento do Tema -->
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
</head> 

<body class="home">
    <?php
    // Bloco PHP para definir a classe 'active' no link de navegação atual
    $current = basename($_SERVER['PHP_SELF']);
    if (!function_exists('is_active')) {
        function is_active($href, $current) {
            $base = basename(parse_url($href, PHP_URL_PATH));
            return $base === $current ? 'active' : '';
        }
    }
    ?>
<style>
		.nav-search{display:flex;align-items:center;gap:.5rem;}
		.nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
		.nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
		.nav-search .nav-search-btn .fa-search{font-size:0.95rem}
	</style>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-search">
                <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
                <button class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
            </div>
            <div class="nav-logo"><a href="index.php"><img src="assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a></div>
            <div class="nav-right-group">
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="index.php" class="nav-link <?php echo is_active('index.php', $current); ?>">Home</a></li>
                    <li><a href="php/produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                    <li><a href="php/colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                    <li><a href="php/sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                    <li><a href="php/contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
                </ul>
                <div class="nav-icons">
                    <div class="profile-dropdown-wrapper">
                        <a href="php/login.php" class="nav-icon-link" aria-label="Login"><i class="fas fa-user"></i></a>
                        <div class="profile-dropdown-menu">
                            <div class="dropdown-header">
                                <img src="assets/img/avatar.png" alt="Avatar" class="dropdown-avatar">
                                <div><div class="dropdown-user-name">Seu Nome</div><div class="dropdown-user-email">seu@email.com</div></div>
                            </div>
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="php/perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                                <li class="dropdown-link-item"><a href="php/configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="php/carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
                </div>
            </div>
            <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
        </div>
    </nav>

    <!-- NOVO BANNER DE LANÇAMENTOS -->
    <section class="new-arrival-banner">
        <!-- Coluna de Imagem 1 -->
        <div class="banner-image-placeholder img-1">
            <!-- As imagens são definidas como background no seu arquivo style.css -->
        </div>
        <!-- Coluna de Imagem 2 -->
        <div class="banner-image-placeholder img-2"></div>
        
        <!-- Coluna de Conteúdo Central -->
        <div class="banner-center-content">
            <div class="decorative-crosses crosses-left">
                <span>✕</span><span>✕</span><span>✕</span><span>✕</span>
            </div>
            <h2>Susanoo</h2>
            <p>Esilo que domina</p>
            <a href="php/produtos.php" class="btn-shop">Compre Agora</a>
            <div class="banner-social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
            <div class="decorative-crosses crosses-right">
                <span>✕</span><span>✕</span><span>✕</span><span>✕</span>
            </div>
        </div>
        
        <!-- Coluna de Imagem 3 -->
        <div class="banner-image-placeholder img-3"></div>
        <!-- Coluna de Imagem 4 -->
        <div class="banner-image-placeholder img-4"></div>
    </section>

    <!-- Seção Hero Principal -->
    <section class="hero">
        <div class="hero-background"><div class="wave-animation"></div></div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title"><span class="title-main">Desperte Seu</span><span class="title-highlight">Poder Interior</span><span class="title-sub">須佐能乎</span></h1>
                <p class="hero-description">Descubra a perfeita harmonia entre tradição oriental e inovação moderna. Cada peça é uma jornada de autodescoberta.</p>
                <div class="hero-buttons">
                    <a href="php/colecoes.php" class="btn btn-primary">Explorar Coleção</a>
                    <a href="php/sobre.php" class="btn btn-secondary">Ver História</a>
                </div>
            </div>
            <div class="hero-image">
                <div class="product-showcase"><div class="floating-product"><img src="assets/img/capa.png" alt="Produto Susanoo" class="hero-product-img"></div></div>
            </div>
        </div>
        <div class="scroll-indicator"><span>Descubra Mais</span><div class="scroll-arrow"></div></div>
    </section>

    <!-- Produtos em Destaque -->
    <section class="featured-products">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Produtos em Destaque</h2>
                <p class="section-subtitle">Peças selecionadas que capturam a essência oriental</p>
            </div>
            <div class="products-grid">
                
                <!-- PRODUTO 1 -->
                <div class="product-card">
                    <div class="card-image"><img src="assets/img/costafoto.png" alt="Camisa Preta"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Susanoo - Preta</h3><p class="product-desc">Estilo e cultura japonesa</p><p class="price">R$ 109,99</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>

                <!-- PRODUTO 2 -->
                <div class="product-card">
                    <div class="card-image"><img src="assets/img/calca.png" alt="Calça Cinza"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Calça Baggy Susanoo Cinza</h3><p class="product-desc">Cor discreta, estilo que destaca</p><p class="price">R$ 67,99</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>

                <!-- PRODUTO 3 -->
                <div class="product-card">
                    <div class="card-image"><img src="assets/img/bone.png" alt="Boné"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Acessórios</h3><p class="product-desc">Faça seus detalhes uma cerimônia tradicional japonesa</p><p class="price">R$ 39,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>

                <!-- Botão "Ver Todos" -->
                <div class="cta-section">
                    <a href="php/produtos.php" class="btn btn-outline">Ver Todos os Produtos</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Coleções Especiais -->
    <section class="collections-preview">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Coleções Especiais</h2>
                <p class="section-subtitle">Linhas exclusivas inspiradas na cultura japonesa</p>
            </div>
            <div class="collections-grid">
                <div class="collection-card"><img src="assets/img/susanoo inverno.png" alt="Coleção Tempestade"><div class="collection-overlay"><div class="collection-content"><h3>Linha de Inverno</h3><p>Esquente-se com estilo</p><a href="php/colecoes.php" class="btn btn-outline">Explorar</a></div></div></div>
                <div class="collection-card"><img src="assets/img/inverno shibuya (1).png" alt="Linha Dragão"><div class="collection-overlay"><div class="collection-content"><h3>Linha de Verão</h3><p>Força e elegância</p><a href="php/colecoes.php" class="btn btn-outline">Ver Mais</a></div></div></div>
                <div class="collection-card"><img src="assets/img/sublime.png" alt="Sakura"><div class="collection-overlay"><div class="collection-content"><h3>Coleção Sublime</h3><p>Delicadeza oriental</p><a href="php/colecoes.php" class="btn btn-outline">Descobrir</a></div></div></div>
            </div>
        </div>
    </section>

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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="php/produtos.php">Produtos</a></li>
                        <li><a href="php/colecoes.php">Coleções</a></li>
                        <li><a href="php/sobre.php">Sobre Nós</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Atendimento</h4>
                    <ul>
                        <li><a href="php/contato.php">Contato</a></li>
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
                <p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados por Davi de Assis, Kauã souza, Lucas Limas e Vinicius Queiroz.</p>
            </div>
        </div>
    </footer>
    
    <!-- Botão Voltar ao Topo -->
    <button id="backToTop" class="back-to-top"><span>↑</span></button>

    <!-- Scripts JavaScript -->
    <script src="js/cart.js"></script>
    <script src="js/script.js"></script>
    <script src="js/theme.js"></script> 
</body>
</html>