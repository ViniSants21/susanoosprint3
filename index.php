<?php
// ==========================================
// 1. PHP NO INÍCIO DO ARQUIVO
// ==========================================
session_start();

// Lógica para corrigir o caminho da foto na Index
$foto_perfil = 'assets/img/placeholder-user.png'; // Foto padrão

if (isset($_SESSION['foto']) && !empty($_SESSION['foto'])) {
    $foto_perfil = $_SESSION['foto'];
    
    // CORREÇÃO CRUCIAL:
    // Se a foto foi salva como "../assets/...", removemos o "../" para funcionar na index
    if (substr($foto_perfil, 0, 3) == '../') {
        $foto_perfil = substr($foto_perfil, 3);
    }
}

// Função para classe 'active' no menu
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
    <title>Susanoo - Estilo Oriental Moderno</title>

    <!-- Folha de Estilo Principal -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Fontes e Ícones Externos -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Script para Carregamento do Tema -->
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
    
    <style>
		.nav-search{display:flex;align-items:center;gap:.5rem;}
		.nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
		.nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
		.nav-search .nav-search-btn .fa-search{font-size:0.95rem}
        
        /* --- CSS ADICIONAL --- */
    
    /* Seção de Avaliações */
    .testimonials-section {
        padding: 5rem 0;
        background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.8));
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .testimonial-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 2rem;
        border-radius: 12px;
        transition: transform 0.3s ease, border-color 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        border-color: rgba(138, 43, 226, 0.4); 
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .testimonial-stars {
        color: #FFD700;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .testimonial-text {
        font-family: 'Noto Sans JP', sans-serif;
        font-style: italic;
        color: rgba(255,255,255,0.8);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 1rem;
    }

    .author-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(45deg, #333, #555);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #fff;
    }

    .author-info h4 {
        font-size: 1rem;
        margin: 0;
        color: #fff;
    }

    .author-info span {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.5);
    }

    /* Seção de Benefícios */
    .benefits-section {
        padding: 4rem 0;
        border-top: 1px solid rgba(255,255,255,0.05);
        background-color: #0a0a0a;
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 2rem;
        text-align: center;
    }

    .benefit-item {
        padding: 1.5rem;
    }

    .benefit-icon {
        font-size: 2rem;
        color: #fff;
        margin-bottom: 1rem;
        text-shadow: 0 0 15px rgba(138, 43, 226, 0.6); 
    }

    .benefit-item h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    .benefit-item p {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.6);
        line-height: 1.5;
    }

    /* === BOTÃO FLUTUANTE DO ADMIN === */
    .admin-float-btn {
        position: fixed;
        bottom: 30px;
        left: 30px; /* Esquerda para não sobrepor o 'Voltar ao topo' */
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
        z-index: 9999;
        transition: all 0.3s ease;
        font-size: 1.4rem;
        border: 2px solid rgba(255,255,255,0.1);
    }
    .admin-float-btn:hover {
        transform: scale(1.1) rotate(90deg);
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.6);
    }
    .admin-tooltip {
        position: absolute;
        left: 65px;
        background: rgba(0,0,0,0.8);
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.8rem;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
        white-space: nowrap;
    }
    .admin-float-btn:hover .admin-tooltip {
        opacity: 1;
    }

    @media (max-width: 768px) {
        .testimonials-grid, .benefits-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        .admin-float-btn {
            bottom: 20px;
            left: 20px;
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
    }
	</style>
</head> 

<body class="home">

    <nav class="navbar" id="navbar">
    <div class="nav-container">
        <!-- IMPLEMENTAÇÃO DA PESQUISA FUNCIONAL -->
        <form action="php/produtos.php" method="GET" class="nav-search">
            <input type="text" name="busca" placeholder="Pesquisar..." aria-label="Pesquisar">
            <button type="submit" class="nav-search-btn" aria-label="Pesquisar">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="nav-logo">
            <a href="index.php"><img src="assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a>
        </div>

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
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <!-- USUÁRIO DESLOGADO -->
                        <a href="php/login.php" class="nav-icon-link" aria-label="Login">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="profile-dropdown-menu">
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item">
                                    <a href="php/registro.php"><i class="fas fa-user-plus"></i> Registrar</a>
                                </li>
                                <li class="dropdown-link-item">
                                    <a href="php/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- USUÁRIO LOGADO -->
                        <a href="#" class="nav-icon-link" aria-label="Perfil">
                            <img src="<?php echo $foto_perfil; ?>" class="dropdown-avatar" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                        </a>
                        <div class="profile-dropdown-menu">
                            <div class="dropdown-header">
                                <img src="<?php echo $foto_perfil; ?>" alt="Avatar" class="dropdown-avatar">
                                <div>
                                    <div class="dropdown-user-name"><?php echo $_SESSION['nome']; ?></div>
                                    <div class="dropdown-user-email"><?php echo $_SESSION['email']; ?></div>
                                </div>
                            </div>
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="php/perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                                <li class="dropdown-link-item"><a href="php/configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                                <li class="dropdown-link-item"><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="php/carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>

    <!-- BANNER DE LANÇAMENTOS -->
    <section class="new-arrival-banner">
        <div class="banner-image-placeholder img-1"></div>
        <div class="banner-image-placeholder img-2"></div>
        
        <div class="banner-center-content">
            <div class="decorative-crosses crosses-left">
                <div class="icon-carousel">
                    <div class="carousel-track">
                        <div class="carousel-icon" data-icon="kanji">桜</div>
                        <div class="carousel-icon" data-icon="kanji">和</div>
                        <div class="carousel-icon" data-icon="kanji">〶</div>
                        <div class="carousel-icon" data-icon="kanji">美</div>
                        <div class="carousel-icon" data-icon="kanji">㋶</div>
                        <div class="carousel-icon" data-icon="kanji">光</div>
                        <div class="carousel-icon" data-icon="kanji">水</div>
                        <!-- Duplicata -->
                        <div class="carousel-icon" data-icon="kanji">丧</div>
                        <div class="carousel-icon" data-icon="kanji">㋭</div>
                        <div class="carousel-icon" data-icon="kanji">夢</div>
                        <div class="carousel-icon" data-icon="kanji">⿕</div>
                        <div class="carousel-icon" data-icon="kanji">愛</div>
                        <div class="carousel-icon" data-icon="kanji">光</div>
                        <div class="carousel-icon" data-icon="kanji">⽗</div>
                    </div>
                </div>
            </div>
            <h2>Susanoo</h2>
            <a href="php/produtos.php" class="btn-shop">Compre Agora</a>
            <div class="banner-social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/xz.assis" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
            <div class="decorative-crosses crosses-right">
                <div class="icon-carousel">
                    <div class="carousel-track">
                        <div class="carousel-icon" data-icon="kanji">桜</div>
                        <div class="carousel-icon" data-icon="kanji">和</div>
                        <div class="carousel-icon" data-icon="kanji">㋶</div>
                        <div class="carousel-icon" data-icon="kanji">美</div>
                        <div class="carousel-icon" data-icon="kanji">㋶</div>
                        <div class="carousel-icon" data-icon="kanji">光</div>
                        <div class="carousel-icon" data-icon="kanji">水</div>
                        <!-- Duplicata -->
                        <div class="carousel-icon" data-icon="kanji">丧</div>
                        <div class="carousel-icon" data-icon="kanji">㋭</div>
                        <div class="carousel-icon" data-icon="kanji">夢</div>
                        <div class="carousel-icon" data-icon="kanji">⿕</div>
                        <div class="carousel-icon" data-icon="kanji">愛</div>
                        <div class="carousel-icon" data-icon="kanji">光</div>
                        <div class="carousel-icon" data-icon="kanji">⽗</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="banner-image-placeholder img-3"></div>
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
                <div class="product-showcase"><div class="floating-product"><img src="assets/img/index.png" alt="Produto Susanoo" class="hero-product-img"></div></div>
            </div>
        </div>
        <div class="scroll-indicator"><span>Descubra Mais</span><div class="scroll-arrow"></div></div>
    </section>

    <!-- Produtos em Destaque -->
    <section class="featured-products">
        <div class="sakura-container">
            <div class="petal"></div><div class="petal"></div><div class="petal"></div><div class="petal"></div>
            <div class="petal"></div><div class="petal"></div><div class="petal"></div><div class="petal"></div>
            <div class="petal"></div><div class="petal"></div><div class="petal"></div><div class="petal"></div>
        </div>
        <section class="benefits-section">
        <div class="container">
            <div class="benefits-grid">
                <!-- Benefício 1 -->
                <div class="benefit-item">
                    <div class="benefit-icon"><i class="fas fa-shipping-fast"></i></div>
                    <h3>Envio Rápido</h3>
                    <p>Entrega agilizada para todo o Brasil com rastreamento em tempo real.</p>
                </div>
                <!-- Benefício 2 -->
                <div class="benefit-item">
                    <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Compra Segura</h3>
                    <p>Seus dados protegidos com criptografia de ponta a ponta.</p>
                </div>
                <!-- Benefício 3 -->
                <div class="benefit-item">
                    <div class="benefit-icon"><i class="fas fa-gem"></i></div>
                    <h3>Qualidade Premium</h3>
                    <p>Tecidos selecionados e acabamento de alta costura.</p>
                </div>
                <!-- Benefício 4 -->
                <div class="benefit-item">
                    <div class="benefit-icon"><i class="fas fa-undo-alt"></i></div>
                    <h3>Troca Fácil</h3>
                    <p>Primeira troca grátis em até 7 dias após o recebimento.</p>
                </div>
            </div>
        </div>
    </section>
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Produtos em Destaque</h2>
                <p class="section-subtitle">Peças selecionadas que capturam a essência oriental</p>
            </div>
            <div class="products-grid">
                
                <!-- PRODUTO 1 -->
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Susanoo - Preta" data-price="109.99" data-img="assets/img/camisajpnsred.png"
                    data-imgs="../assets/img/vermelhoroupa.png|../assets/img/camisajpnsredback.png|../assets/img/camisajpnsreddetailbeside.png|../assets/img/camisajpnsreddetail.png" data-sizes="P|M|G|GG"
                    data-longdesc="Camisa Susanoo Preta: Estilo e cultura japonesa, algodão premium, modelagem confortável.">
                    <div class="card-image"><img src="assets/img/costafoto.png" alt="Camisa Preta"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Susanoo - Preta</h3><p class="product-desc">Estilo e cultura japonesa</p><p class="price">R$ 109,99</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>

                <!-- PRODUTO 2 -->
                <div class="product-card" data-category="calcas"
                    data-name="Calça Baggy Susanoo Cinza" data-price="67.99" data-img="assets/img/calca.png"
                    data-imgs="../assets/img/calca.png|../assets/img/calcadetail.png|../assets/img/calcadetail2.png" data-sizes="P|M|G|GG"
                    data-longdesc="Calça Baggy Susanoo Cinza: Cor discreta, estilo que destaca, tecido leve e resistente.">
                    <div class="card-image"><img src="assets/img/calca.png" alt="Calça Cinza"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Calça Baggy Susanoo Cinza</h3><p class="product-desc">Cor discreta, estilo que destaca</p><p class="price">R$ 67,99</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>

                <!-- PRODUTO 3 -->
                <div class="product-card" data-category="acessorios"
                    data-name="Boné Amaterasu" data-price="39.90" data-img="assets/img/bone.png"
                    data-imgs="../assets/img/boneoldschool.png|../assets/img/boneoldschool2.png" data-sizes="Único"
                    data-longdesc="Boné Old School: Aba curva, bordado exclusivo, ajuste confortável, inspiração japonesa.">
                    <div class="card-image"><img src="assets/img/bone.png" alt="Boné Amaterasu"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Boné Old School</h3><p class="product-desc">Aba curva, bordado exclusivo, ajuste confortável</p><p class="price">R$ 39,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>

                <!-- Botão "Ver Todos" -->
                <div class="cta-section">
                    <a href="php/produtos.php" class="btn btn-outline">Ver Todos os Produtos</a>
                </div>
            </div>
        </div>
    </section>

    <!-- AVALIAÇÕES -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">O Que Dizem Nossos Clientes</h2>
                <p class="section-subtitle">A experiência de quem já veste a essência Susanoo</p>
            </div>
            
            <div class="testimonials-grid">
                <!-- Avaliação 1 -->
                <div class="testimonial-card">
                    <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p class="testimonial-text">"A qualidade do tecido é surreal. O caimento da Camisa Susanoo Preta ficou perfeito, exatamente o estilo oversized que eu procurava. Chegou super rápido!"</p>
                    <div class="testimonial-author"><div class="author-avatar"><span>G</span></div><div class="author-info"><h4>Gabriel M.</h4><span>Comprou: Camisa Susanoo</span></div></div>
                </div>

                <!-- Avaliação 2 -->
                <div class="testimonial-card">
                    <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p class="testimonial-text">"Estava com receio sobre o tamanho, mas a tabela de medidas ajudou muito. O bordado do boné é muito detalhado. Com certeza comprarei a coleção de inverno."</p>
                    <div class="testimonial-author"><div class="author-avatar"><span>L</span></div><div class="author-info"><h4>Lucas S.</h4><span>Comprou: Boné Amaterasu</span></div></div>
                </div>

                <!-- Avaliação 3 -->
                <div class="testimonial-card">
                    <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                    <p class="testimonial-text">"Peças com identidade única. É difícil achar streetwear com essa pegada oriental no Brasil. O atendimento foi excelente quando tive dúvidas."</p>
                    <div class="testimonial-author"><div class="author-avatar"><span>B</span></div><div class="author-info"><h4>Beatriz K.</h4><span>Comprou: Calça Baggy</span></div></div>
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
                <div class="collection-card"><img src="assets/img/susanoo inverno.png" alt="Coleção Tempestade"><div class="collection-overlay"><div class="collection-content"><h3>Linha de Inverno</h3><p>Esquente-se com estilo</p><a href="php/colecao_inverno.php" class="btn btn-outline">Explorar</a></div></div></div>
                <div class="collection-card"><img src="assets/img/inverno shibuya (1).png" alt="Linha Dragão"><div class="collection-overlay"><div class="collection-content"><h3>Linha de Verão</h3><p>Força e elegância</p><a href="php/colecao_verao.php" class="btn btn-outline">Ver Mais</a></div></div></div>
                <div class="collection-card"><img src="assets/img/sublime.png" alt="Sakura"><div class="collection-overlay"><div class="collection-content"><h3>Coleção Sublime</h3><p>Delicadeza oriental</p><a href="php/colecao_sublime.php" class="btn btn-outline">Descobrir</a></div></div></div>
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

    <!-- ============================================= -->
    <!-- BOTÃO FLUTUANTE PARA VOLTAR AO ADMIN          -->
    <!-- Só aparece se o usuário for admin@susanoo.com -->
    <!-- ============================================= -->
    <?php if (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@susanoo.com'): ?>
        <a href="php/admin.php" class="admin-float-btn" title="Voltar ao Painel Admin">
            <i class="fas fa-cogs"></i>
            <span class="admin-tooltip">Painel Admin</span>
        </a>
    <?php endif; ?>

    <!-- Scripts JavaScript -->
    <script src="js/cart.js"></script>
    <script src="js/script.js"></script>
    <script src="js/theme.js"></script> 
</body>
</html>