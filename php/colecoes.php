<?php
session_start(); 
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
    <title>Coleções - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if(theme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
        /* --- Regras Gerais --- */
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(255,255,255,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
        
        /* --- Animações --- */
        @keyframes draw-line {
            to { transform: scaleX(1); }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- Estilo da Página --- */
        .collections-page {
            padding: 2rem 2rem 60px;
            background-color: var(--bg-primary);
            background-image: radial-gradient(ellipse at top, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
        }
        
        /* --- Banner Promocional --- */
        .promo-banner-section {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-top: -11px;
            height: 600px; 
            margin-bottom: -84px; /* Sobrepõe o conteúdo principal levemente */
            overflow: hidden;
        }
        .promo-banner-link {
            display: block;
            width: 100%;
            height: 100%;
        }
        .promo-banner-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        /* 
        ================================================================
        SEÇÃO DAS COLEÇÕES - CÓDIGO CORRIGIDO E CENTRALIZADO
        ================================================================
        */

        /* Usamos flexbox para centralizar todo o conteúdo da página */
        main.collections-page .container {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centraliza o header e o grid */
        }
        
        /* Cabeçalho da Seção */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
            width: 100%;
            max-width: 800px; /* Limita a largura do texto */
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 3rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
            /* Animação */
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-purple), var(--secondary-purple));
            transform: scaleX(0);
            transform-origin: center;
            animation: draw-line 1s ease-out 0.8s forwards; /* Atraso para sincronizar */
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.7;
            /* Animação */
            opacity: 0;
            animation: fadeInUp 0.8s ease-out 0.3s forwards;
        }

        /* Grid dos Cards de Coleção */
        .collections-grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 colunas flexíveis */
            gap: 2.5rem;
            width: 120%;
            max-width: 1800px; /* Largura máxima para o grid */
        }

        /* Estilo do Card Individual */
        .collection-card-item {
            position: relative;
            height: 550px;
            /* REMOVIDO: width: 700px; */
            border-radius: 20px;
            overflow: hidden;
            text-decoration: none;
            color: #fff;
            display: block;
            border: 2px solid transparent;
            box-shadow: var(--shadow-soft);
            transition: border-color 0.4s ease, box-shadow 0.4s ease, transform 0.4s ease;
        }

        .collection-card-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), filter 0.5s ease;
        }

        .collection-card-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
        }

        /* Efeitos de Hover no Card */
        .collection-card-item:hover {
            box-shadow: var(--shadow-glow);
            border-color: rgba(139, 92, 246, 0.7);
            transform: translateY(-8px);
        }

        .collection-card-item:hover::before {
            transform: scale(1.1) rotate(1deg);
            filter: brightness(1.1);
        }

        /* Conteúdo do Card */
        .collection-card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            z-index: 2;
            transform: translateY(calc(100% - 120px));
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .collection-card-item:hover .collection-card-content {
            transform: translateY(0);
        }

        .collection-card-title {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #fff;
        }

        .collection-card-desc, .btn-collection {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.4s ease 0.2s, transform 0.4s ease 0.2s;
        }

        .collection-card-item:hover .collection-card-desc,
        .collection-card-item:hover .btn-collection {
            opacity: 1;
            transform: translateY(0);
        }

        .collection-card-desc {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: var(--text-secondary);
        }

        /* Imagens de fundo */
        #colecao-essencial::before { background-image: url('../assets/img/Ban1_recorte.png'); }
        #colecao-sublime::before   { background-image: url('../assets/img/Collection_sublime.png'); }
        #colecao-verao::before     { background-image: url('../assets/img/Ban2_recorte.png'); }
        #colecao-inverno::before   { background-image: url('../assets/img/inverno shibuya.png'); }

        /* Botões */
        .btn-collection { padding: 0.8rem 1.8rem; border-radius: 50px; font-weight: 600; display: inline-block; }
        .btn-outline { background: transparent; color: #fff; border: 2px solid #fff; }
        .btn-outline:hover { background: #fff; color: #000; }
        .btn-primary { background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple)); color: var(--text-primary); border: 2px solid transparent; }
        .btn-secondary-dark { background: var(--dark-purple); color: #c4b5fd; border: 2px solid #c4b5fd; }
        .btn-secondary-dark:hover { background: #c4b5fd; color: var(--dark-purple); }

        /* --- Responsividade --- */
        @media (max-width: 992px) {
            .collections-grid-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .collection-card-item {
                height: 450px; 
            }
            .promo-banner-section {
                height: 350px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
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
                        
                        <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- USUÁRIO DESLOGADO -->
                        <a href="php/login.php" class="nav-icon-link" aria-label="Login">
                        <i class="fas fa-user"></i>
                        </a>


                        <div class="profile-dropdown-menu">
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item">
                                <a href="../php/registro.php"><i class="fas fa-user-plus"></i>Registrar</a>
                                </li>
                                <li class="dropdown-link-item">
                                    <a href="../php/login.php"><i class="fas fa-sign-in-alt"></i>Login</a>
                                </li>
                            </ul>
                        </div>

                    <?php else: ?>
                    <!-- USUÁRIO LOGADO -->
                    <a href="#" class="nav-icon-link" aria-label="Perfil">
                    <img src="<?php echo $_SESSION['foto']; ?>"
                    class="dropdown-avatar"
                    style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
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
<li class="dropdown-link-item"><a href="php/perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
<li class="dropdown-link-item"><a href="php/configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
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

<!-- Banner -->
<section class="promo-banner-section">
    <a href="#" class="promo-banner-link" aria-label="Ver promoção especial">
        <img src="../assets/img/colec.jpg" alt="Banner promocional da nova coleção" class="promo-banner-image">
    </a>
</section>

<!-- Conteúdo Principal -->
<main class="collections-page">
    <div class="container">
        <header class="section-header">
            <h1 class="section-title">Nossas Coleções</h1>
            <p class="section-subtitle">Mergulhe em universos de estilos únicos, criados para cada momento. Cada peça é uma nova forma de expressar seu poder interior.</p>
        </header>

        <div class="collections-grid-container">
            <!-- Card Coleção Essencial -->
            <a href="colecao_essencial.php" id="colecao-essencial" class="collection-card-item">
                <div class="collection-card-content">
                    <h2 class="collection-card-title">Essentials</h2>
                    <p class="collection-card-desc">Peças atemporais e versáteis que formam a base de um guarda-roupa poderoso e elegante.</p>
                    <!-- ALTERADO AQUI -->
                    <span class="btn-collection btn-primary">Explorar a Coleção</span>
                </div>
            </a>

            <!-- Card Coleção Sublime -->
            <a href="colecao_sublime.php" id="colecao-sublime" class="collection-card-item">
                <div class="collection-card-content">
                    <h2 class="collection-card-title">Sublime</h2>
                    <p class="collection-card-desc">Designs etéreos e tecidos nobres que transcendem o comum, criados para momentos especiais.</p>
                    <span class="btn-collection btn-primary">Ver Peças Únicas</span>
                </div>
            </a>

            <!-- Card Coleção Verão -->
            <a href="colecao_verao.php" id="colecao-verao" class="collection-card-item">
                <div class="collection-card-content">
                    <h2 class="collection-card-title">Coleção Verão</h2>
                    <p class="collection-card-desc">Sinta a brisa com peças leves, cores vibrantes e cortes fluidos para os dias ensolarados.</p>
                    <!-- ALTERADO AQUI -->
                    <span class="btn-collection btn-primary">Descobrir a Leveza</span>
                </div>
            </a>

            <!-- Card Coleção Inverno -->
            <a href="colecao_inverno.php" id="colecao-inverno" class="collection-card-item">
                <div class="collection-card-content">
                    <h2 class="collection-card-title">Coleção Inverno</h2>
                    <p class="collection-card-desc">Abrace o frio com texturas ricas, sobreposições inteligentes e uma paleta de cores sofisticada.</p>
                    <span class="btn-collection btn-primary">Enfrente o Frio</span>
                </div>
            </a>
        </div>
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
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script> 
</body>
</html>