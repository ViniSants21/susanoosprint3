<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção de Verão</title>
    <link rel="stylesheet" href="../css/style.css">

    <!-- Fontes e ícones -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Script de tema -->
    <script>
        (function(){
            const theme = localStorage.getItem('theme');
            if(theme === 'light'){ document.documentElement.classList.add('light-mode'); }
        })();
    </script>

    <style>
        .nav-search { display:flex; align-items:center; gap:.5rem; }
        .nav-search input[type="text"] {
            padding:.45rem .75rem; border-radius:24px;
            border:1px solid rgba(0,0,0,.08); background:transparent;
            color:inherit; min-width:160px;
        }
        .nav-search .nav-search-btn {
            border:none; background:transparent;
            padding:.35rem; border-radius:50%; cursor:pointer;
            color:inherit; display:inline-flex; align-items:center; justify-content:center;
        }
        .nav-search .nav-search-btn .fa-search { font-size:0.95rem; }
    </style>
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
                <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
                <button class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
            </div>

            <!-- Logo central -->
            <div class="nav-logo">
                <a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a>
            </div>

            <!-- Menu e ícones à direita -->
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
                    <a href="#" class="nav-icon-link" aria-label="Login" style="pointer-events: none;"><i class="fas fa-user"></i></a>
                    <div class="profile-dropdown-menu">
                        <div class="dropdown-header">
                            <img src="../assets/img/avatar.png" alt="Avatar" class="dropdown-avatar">
                            <div><div class="dropdown-user-name">Seu Nome</div><div class="dropdown-user-email">seu@email.com</div></div>
                        </div>
                        <ul class="dropdown-links">
                            <li class="dropdown-link-item"><a href="php/perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                            <li class="dropdown-link-item"><a href="php/configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                            <li class="dropdown-link-item"><a href="php/login.php"><i class="fas fa-sign-in-alt"></i> Logar</a></li>
                        </ul>
                    </div>
                </div>
                    <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
                </div>
            </div>

            <!-- Menu hambúrguer (mobile) -->
            <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Coleção de Verão</h1>
            <p class="page-subtitle">Leveza, estilo e conforto em cada detalhe</p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section">
        <div class="container">
            <div class="products-grid">
            <!-- data-imgs = FOTOS FRENTE E VERSO -->
                <div class="product-card" data-category="camisas"
                    data-name="Camisa de Linho Bege" data-price="139.90" data-img="../assets/img/CamisaVerao1.png"
                    data-imgs="../assets/img/CamisaVerao1.png|../assets/img/CamisaVerao2.png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa de Linho Bege: Conforto natural, toque leve, perfeita para o verão.">
                    <div class="card-image"><img src="../assets/img/CamisaVerao1.png" alt="Camisa de Linho Bege"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa de Linho Bege</h3><p class="product-desc">Conforto natural com toque leve para o verão.</p><p class="price">R$ 139,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Azul Claro" data-price="129.90" data-img="../assets/img/CamisaVerao2.png"
                    data-imgs="../assets/img/CamisaVerao2.png|../assets/img/CamisaVerao1.png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Azul Claro: Ideal para dias ensolarados, estilo leve e fresco.">
                    <div class="card-image"><img src="../assets/img/CamisaVerao2.png" alt="Camisa Azul Claro"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Azul Claro</h3><p class="product-desc">Ideal para dias ensolarados com estilo leve.</p><p class="price">R$ 129,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Branca Casual" data-price="119.90" data-img="../assets/img/CamisaVerao3.png"
                    data-imgs="../assets/img/CamisaVerao3.png|../assets/img/CamisaVerao2.png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Branca Casual: Simplicidade elegante para o dia a dia, tecido leve e confortável.">
                    <div class="card-image"><img src="../assets/img/CamisaVerao3.png" alt="Camisa Branca Casual"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Branca Casual</h3><p class="product-desc">Simplicidade elegante para o dia a dia.</p><p class="price">R$ 119,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
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
                <p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados por Davi de Assis, Kauã Souza, Lucas Limas e Vinicius Queiroz.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="backToTop" class="back-to-top"><span>↑</span></button>

    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script>
</body>
</html>
