<?php
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
        /* --- Regras existentes --- */
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(255,255,255,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
        
        @keyframes draw-line {
            to { transform: scaleX(1); }
        }

        .collections-page {
            /* AJUSTE DE ESPAÇAMENTO: Reduzido o padding superior */
            padding: 2rem 2rem 60px;
            background-color: var(--bg-primary);
            background-image: radial-gradient(ellipse at top, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
        }

        .section-header {
            text-align: center;
            /* AJUSTE DE ESPAÇAMENTO: Reduzido de 5rem para 3rem */
            margin-bottom: 3rem;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 3rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
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
            animation: draw-line 1s ease-out forwards;
            animation-delay: 0.3s;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* --- SEÇÃO DO BANNER MODIFICADA --- */
        .promo-banner-section {
            /* AJUSTE: Largura total da tela */
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            
            /* AJUSTE: Altura fixa menor para ficar mais panorâmico */
            height: 350px; 
            
            /* AJUSTE: Reduzido o espaço abaixo do banner */
            margin-bottom: 2rem;
            overflow: hidden;
            margin-top: 80px; /* Espaço para a navbar fixa */
        }

        .promo-banner-link {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 0; /* Remove borda arredondada para banner full-width */
            box-shadow: var(--shadow-soft);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .promo-banner-link:hover {
            transform: scale(1.01); /* Zoom muito leve no hover */
            box-shadow: var(--shadow-glow);
        }

        .promo-banner-image {
            width: 100%;
            height: 100%;
            display: block;
            /* CRUCIAL: Faz a imagem cobrir a área sem distorcer */
            object-fit: cover;
            object-position: center; /* Centraliza a imagem */
        }
        /* --- Fim da Seção do Banner --- */

        /* Grid para os Cards de Coleção - 2x2 */
        .collections-grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .collection-card-item {
            position: relative;
            height: 550px;
            border-radius: 20px;
            overflow: hidden;
            text-decoration: none;
            color: #fff;
            display: block;
            border: 2px solid transparent;
            box-shadow: var(--shadow-soft);
            transition: border-color 0.4s ease, box-shadow 0.4s ease;
        }

        .collection-card-item:hover {
            box-shadow: var(--shadow-glow);
            border-color: var(--primary-purple);
        }

        .collection-card-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .collection-card-item:hover::before {
            transform: scale(1.1);
        }
        
        .collection-card-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
        }

        #colecao-essencial::before { background-image: url('../assets/img/ban1.png'); }
        #colecao-sublime::before   { background-image: url('../assets/img/ban2.png'); }
        #colecao-verao::before     { background-image: url('../assets/img/ban3.png'); }
        #colecao-inverno::before   { background-image: url('../assets/img/ban4.png'); }

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
            transition: opacity 0.4s ease 0.1s;
        }

        .collection-card-item:hover .collection-card-desc,
        .collection-card-item:hover .btn-collection {
            opacity: 1;
        }

        .collection-card-desc {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: var(--text-secondary);
        }

        .btn-collection { padding: 0.8rem 1.8rem; border-radius: 50px; font-weight: 600; display: inline-block; }
        .btn-outline { background: transparent; color: #fff; border: 2px solid #fff; }
        .btn-outline:hover { background: #fff; color: #000; }
        .btn-primary { background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple)); color: var(--text-primary); border: 2px solid transparent; }
        .btn-secondary-dark { background: var(--dark-purple); color: #c4b5fd; border: 2px solid #c4b5fd; }
        .btn-secondary-dark:hover { background: #c4b5fd; color: var(--dark-purple); }

        @media (max-width: 992px) {
            .collections-grid-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .collection-card-item {
                height: 450px; 
            }
            .promo-banner-section {
                height: 250px; /* Altura menor para celulares */
            }
        }
    </style>
</head>
<body>

<!-- Navbar Correta -->
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

<!-- Banner fora do Main para ocupar largura total -->
<section class="promo-banner-section">
    <a href="sua-pagina-de-destino.php" class="promo-banner-link" aria-label="Ver promoção especial">
        <img src="../assets/img/Colecoesss.png" alt="Banner promocional da nova coleção" class="promo-banner-image">
    </a>
</section>

<!-- Main Content -->
<main class="collections-page">
    <div class="container">
        <header class="section-header">
            <h1 class="section-title">Nossas Coleções</h1>
            <p class="section-subtitle">Mergulhe em universos de estilo únicos, criados para cada momento. Cada peça é uma nova forma de expressar seu poder interior.</p>
        </header>

        <div class="collections-grid-container">
            <!-- Card Coleção Essencial -->
            <a href="colecao_essencial.php" id="colecao-essencial" class="collection-card-item">
                <div class="collection-card-content">
                    <h2 class="collection-card-title">Essencial</h2>
                    <p class="collection-card-desc">Peças atemporais e versáteis que formam a base de um guarda-roupa poderoso e elegante.</p>
                    <span class="btn-collection btn-outline">Explorar a Coleção</span>
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
                    <span class="btn-collection btn-secondary-dark">Descobrir a Leveza</span>
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

<!-- Footer (mantido igual, mas inclua o seu código de footer aqui) -->
<footer class="footer">
    <!-- ... seu código do footer ... -->
</footer>

<button id="backToTop" class="back-to-top"><span>↑</span></button>

<script src="../js/script.js"></script>
</body>
</html>