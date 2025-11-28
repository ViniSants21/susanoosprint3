<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção Inverno - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
         /* --- Banner Promocional --- */
        .promo-banner-section {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-top: -11px;
            height: 500px; 
            margin-bottom: -180px; /* Sobrepõe o conteúdo principal levemente */
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
    </style>
</head>

<body>
<?php
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>

<!-- NAVBAR IGUAL À DA INDEX -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <div class="nav-search">
            <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
            <button class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
        </div>

        <div class="nav-logo">
            <a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a>
        </div>

        <div class="nav-right-group">
            <ul class="nav-menu" id="nav-menu">
                <li><a href="../index.php" class="nav-link <?php echo is_active('../index.php', $current); ?>">Home</a></li>
                <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
            </ul>

            <div class="nav-icons">
                    <div class="profile-dropdown-wrapper">
                        <?php if (!isset($_SESSION)) { session_start(); } ?>
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
        <img src="../assets/img/colecaoinverno.png" alt="Banner promocional da nova coleção" class="promo-banner-image">
    </a>
</section>

<!-- CABEÇALHO -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Coleção de Inverno</h1>
        <p class="page-subtitle">Descubra a elegância e o aconchego da estação</p>
    </div>
</section>

<!-- PRODUTOS -->
<section class="products-section">
    <div class="container">
        <div class="products-grid">
            <!-- data-imgs = FOTOS FRENTE E VERSO -->
            <div class="product-card" data-category="casacos"
                data-name="Casaco Yukimura" data-price="499.90" data-img="../assets/img/inverno.png"
                data-imgs="../assets/img/inverno.png" data-sizes="P|M|G|GG|XG"
                data-longdesc="Casaco Yukimura: Lã premium, corte japonês contemporâneo, forro térmico, ideal para o inverno.">
                <div class="card-image"><img src="../assets/img/inverno.png" alt="Casaco Yukimura"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                <div class="card-content"><h3>Casaco Yukimura</h3><p class="product-desc">Lã premium com corte japonês contemporâneo.</p><p class="price">R$ 499,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
            </div>
            <!-- data-imgs = FOTOS FRENTE E VERSO -->
            <div class="product-card" data-category="casacos"
                data-name="Sobretudo Hokkaido" data-price="599.90" data-img="../assets/img/inverno.png"
                data-imgs="../assets/img/inverno.png" data-sizes="P|M|G|GG|XG"
                data-longdesc="Sobretudo Hokkaido: Design minimalista, proteção térmica elegante, tecido impermeável, perfeito para dias frios.">
                <div class="card-image"><img src="../assets/img/inverno.png" alt="Sobretudo Hokkaido"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                <div class="card-content"><h3>Sobretudo Hokkaido</h3><p class="product-desc">Design minimalista e proteção térmica elegante.</p><p class="price">R$ 599,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
            </div>
            <div class="product-card" data-category="acessorios"
                data-name="Gorro Shinobi" data-price="89.90" data-img="../assets/img/inverno.png"
                data-imgs="../assets/img/inverno.png" data-sizes="Único"
                data-longdesc="Gorro Shinobi: Aqueça-se com estilo, leveza ninja, tecido macio e confortável.">
                <div class="card-image"><img src="../assets/img/inverno.png" alt="Gorro Shinobi"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                <div class="card-content"><h3>Gorro Shinobi</h3><p class="product-desc">Aqueça-se com estilo e leveza ninja.</p><p class="price">R$ 89,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
            </div>
        </div>
    </div>
</section>

<!-- RODAPÉ -->
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
            <p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados por Davi de Assis, Kauã Souza, Lucas Limas e Vinicius Queiroz.</p>
        </div>
    </div>
</footer>

<button id="backToTop" class="back-to-top"><span>↑</span></button>

<script src="../js/cart.js"></script>
<script src="../js/script.js"></script>
<script src="../js/theme.js"></script>
</body>
</html>
