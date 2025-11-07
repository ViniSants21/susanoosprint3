<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
    <!-- Estilos locais para o ícone de pesquisa -->
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
    </style>
</head>
<body>

<?php
// Bloco PHP movido para dentro do Body para evitar erros de renderização
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
                <!-- NOVO: Dropdown do Perfil -->
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
                <!-- Fim do Dropdown -->
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container"><h1 class="page-title">Nossos Produtos</h1><p class="page-subtitle">Descubra algum dos nossos produtos destaque</p></div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="camisas">Camisas</button>
                <button class="filter-btn" data-filter="moletons">Moletons</button>
                <button class="filter-btn" data-filter="calcas">Calças</button>
                <button class="filter-btn" data-filter="acessorios">Acessórios</button>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section">
        <section class="featured-products">
        <div class="sakura-container">
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
    </div>
        <div class="container">
            <div class="products-grid">
                
                <!-- Camisas -->
                <div class="product-card" data-category="camisas"
                     data-name="Camisa Brazil" data-price="99.90" data-img="../assets/img/camisabr.png"
                     data-imgs="../assets/img/camisabrazil.png|../assets/img/camisabrazilback.png|../assets/img/camisabrazildetail.png|../assets/img/camisabrazilupdetail.png|../assets/img/camisabrazilbackdetail.png" data-sizes="P|M|G|GG|XG"
                     data-longdesc="Camisa Brazil: Confeccionada em algodão premium, acabamento reforçado nas costuras, modelagem regular que se adapta ao corpo. Ideal para uso diário, possui estampas inspiradas na cultura oriental e tratamento anti-pilling.">
                    <div class="card-image"><img src="../assets/img/camisabr.png" alt="Camisa Tradicional"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Brazil</h3><p class="product-desc">Algodão leve, Historia pesada</p><p class="price">R$ 99,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                     data-name="Camisa Sopro" data-price="99.90" data-img="../assets/img/sopro.png"
                     data-imgs="../assets/img/sopros.png|../assets/img/sopro2.png" data-sizes="P|M|G|GG|XG"
                     data-longdesc="Camisa Sopro: Tecido leve com toque seco, estampa serigráfica resistente, gola reforçada. Inspirada no vento, design minimalista com caimento fluido.">
                    <div class="card-image"><img src="../assets/img/sopro.png" alt="Camisa Kimono"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Sopro</h3><p class="product-desc">Rápido como vento, impactante como uma rocha</p><p class="price">R$ 99,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <!-- Moletons -->
                <div class="product-card" data-category="moletons"
                     data-name="Moletom Sakura" data-price="249.90" data-img="../assets/img/moletommarrom.png"
                     data-imgs="../assets/img/moletomsakurafront.png|../assets/img/moletomsakuraback.png" data-sizes="P|M|G|GG|XG"
                     data-longdesc="Moletom Sakura: Interior felpado, capuz com ajuste, bolsos canguru. Estampa temática de cerejeira com tintas ecológicas, ideal para baixas temperaturas.">
                    <div class="card-image"><img src="../assets/img/moletommarrom.png" alt="Moletom Sakura"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Moletom Sakura</h3><p class="product-desc">Forro macio com estampa de cerejeira</p><p class="price">R$ 129,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="moletons"
                     data-name="Moletom Susanoo" data-price="279.90" data-img="../assets/img/moletomroxo.png"
                     data-imgs="../assets/img/moletomroxo.png|../assets/img/moletomroxoback.png" data-sizes="P|M|G|GG|XG"
                     data-longdesc="Moletom Susanoo: Corte urbano, logo bordado, material durável e resistente a lavagens. Perfeito para compor looks casuais.">
                    <div class="card-image"><img src="../assets/img/moletomroxo.png" alt="Moletom Susanoo"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Moletom Susanoo</h3><p class="product-desc">Moletom com capuz e logo bordado</p><p class="price">R$ 139,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <!-- Calças -->
                <div class="product-card" data-category="calcas"
                     data-name="Jorts Hakama" data-price="199.90" data-img="../assets/img/jortscinza.png"
                     data-imgs="../assets/img/jortscinza.png|../assets/img/jortscinza_back.png" data-sizes="P|M|G|GG|XG"
                     data-longdesc="Jorts Hakama: Calça com corte inspirado em hakama, bolsos reforçados, tecido com elasticidade leve para conforto. Ideal para looks modernos.">
                    <div class="card-image"><img src="../assets/img/jortscinza.png" alt="Calça Hakama"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Jorts Hakama</h3><p class="product-desc">Design ousado em trajes unicos</p><p class="price">R$ 119,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="calcas"
                     data-name="Calça Cargo" data-price="169.90" data-img="../assets/img/calcamodelofem.png"
                     data-imgs="../assets/img/calcamodelofem.png|../assets/img/calcamodelofem_2.png" data-sizes="P|M|G|GG|XG"
                     data-longdesc="Calça Cargo: Vários bolsos utilitários, cordão interno na cintura, acabamento resistente. Perfeita para uso urbano e funcional.">
                    <div class="card-image"><img src="../assets/img/calcamodelofem.png" alt="Calça Jogger"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Calça Cargo</h3><p class="product-desc">Conforto urbano com acabamento elástico</p><p class="price">R$ 149,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <!-- Acessórios (tamanho Único) -->
                <div class="product-card" data-category="acessorios"
                     data-name="Boné AMATERASU" data-price="69.90" data-img="../assets/img/bonebarra.png"
                     data-imgs="../assets/img/boneamaterasucompleto.png|../assets/img/boneamaterasuback.png" data-sizes="Único"
                     data-longdesc="Boné AMATERASU: Tecido respirável com aba estruturada e bordado exclusivo. Ajuste traseiro e detalhe interno antissuor.">
                    <div class="card-image"><img src="../assets/img/bonebarra.png" alt="Boné Amaterasu"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Boné AMATERASU</h3><p class="product-desc">Chama negra que nunca para</p><p class="price">R$ 69,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="acessorios"
                     data-name="Bandana Oriental" data-price="39.90" data-img="../assets/img/chaveiro.png"
                     data-imgs="../assets/img/chaveiro.png|../assets/img/yeah.png" data-sizes="Único"
                     data-longdesc="Chaveiro/Acc: Material metálico com banho resistente, detalhe temático e embalagem presenteável.">
                    <div class="card-image"><img src="../assets/img/chaveiro.png" alt="Bandana Oriental"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Pente Oriental</h3><p class="product-desc">Arrume seu cabelo com tradição</p><p class="price">R$ 39,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
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
                <p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top"><span>↑</span></button>

    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script> <!-- ou ../js/theme.js para páginas internas -->
</body>
</html>