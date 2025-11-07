<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção Sublime</title>

    <!-- Folha de Estilo -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Fontes e Ícones -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Script para carregar tema salvo -->
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
            <!-- Barra de busca -->
            <div class="nav-search">
                <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
                <button class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
            </div>

            <!-- Logo central -->
            <div class="nav-logo">
                <a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a>
            </div>

            <!-- Menu e ícones -->
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

            <!-- Menu hambúrguer -->
            <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
        </div>
    </nav>

    <!-- Cabeçalho -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Coleção Sublime</h1>
            <p class="page-subtitle">Delicadeza e minimalismo com essência oriental</p>
        </div>
    </section>

    <!-- Produtos -->
    <section class="products-section">
        <div class="container">
            <!-- data-imgs = FOTOS FRENTE E VERSO -->
            <div class="products-grid">
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Polo Susanoo Preta" data-price="149.90" data-img="../assets/img/Camisa Polo Susanoo (1).png"
                    data-imgs="../assets/img/Camisa Polo Susanoo (1).png|../assets/img/Camisa Polo Susanoo(Preta).png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Polo Susanoo Preta: Feita em algodão egípcio premium. Elegância japonesa moderna.">
                    <div class="card-image"><img src="../assets/img/Camisa Polo Susanoo (1).png" alt="Camisa Polo Susanoo Preta"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Polo - COLLECTION SUBLIME</h3><p class="product-desc">Feita em algodão egípcio premium. Elegância japonesa moderna.</p><p class="price">R$ 149,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Polo Preta" data-price="159.90" data-img="../assets/img/Camisa Polo Susanoo(Preta).png"
                    data-imgs="../assets/img/Camisa Polo Susanoo(Preta).png|../assets/img/Camisa Polo Susanoo (1).png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Polo Preta: Design minimalista e corte preciso, com inspiração japonesa.">
                    <div class="card-image"><img src="../assets/img/Camisa Polo Susanoo(Preta).png" alt="Camisa Polo Preta"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Polo Preta - COLLECTION SUBLIME</h3><p class="product-desc">Design minimalista e corte preciso, com inspiração japonesa.</p><p class="price">R$ 159,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Polo Off-White" data-price="149.90" data-img="../assets/img/Camisa Off-White SUBLIME.png"
                    data-imgs="../assets/img/Camisa Off-White SUBLIME.png|../assets/img/Camisa Branca SUBLIME.png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Polo Off-White: Tecido leve, toque suave e visual sofisticado.">
                    <div class="card-image"><img src="../assets/img/Camisa Off-White SUBLIME.png" alt="Camisa Polo Off-White"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Polo Off-White - COLLECTION SUBLIME</h3><p class="product-desc">Tecido leve, toque suave e visual sofisticado.</p><p class="price">R$ 149,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Polo Branca" data-price="129.90" data-img="../assets/img/Camisa Branca SUBLIME.png"
                    data-imgs="../assets/img/Camisa Branca SUBLIME.png|../assets/img/Camisa Off-White SUBLIME.png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Polo Branca: Elegância pura com inspiração oriental clássica.">
                    <div class="card-image"><img src="../assets/img/Camisa Branca SUBLIME.png" alt="Camisa Branca Sublime"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Polo Branca - COLLECTION SUBLIME</h3><p class="product-desc">Elegância pura com inspiração oriental clássica.</p><p class="price">R$ 129,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Polo Marrom" data-price="149.90" data-img="../assets/img/Camisa Marrom SUBLIME.png"
                    data-imgs="../assets/img/Camisa Marrom SUBLIME.png|../assets/img/Camisa Rosa SUBLIME.png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Polo Marrom: Inspirada nas nuances da terra e tradição oriental.">
                    <div class="card-image"><img src="../assets/img/Camisa Marrom SUBLIME.png" alt="Camisa Polo Marrom"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Polo Marrom - COLLECTION SUBLIME</h3><p class="product-desc">Inspirada nas nuances da terra e tradição oriental.</p><p class="price">R$ 149,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
                <div class="product-card" data-category="camisas"
                    data-name="Camisa Polo Rosa" data-price="129.90" data-img="../assets/img/Camisa Rosa SUBLIME.png"
                    data-imgs="../assets/img/Camisa Rosa SUBLIME.png|../assets/img/Camisa Marrom SUBLIME.png" data-sizes="P|M|G|GG|XG"
                    data-longdesc="Camisa Polo Rosa: Delicada e expressiva, perfeita para momentos sutis.">
                    <div class="card-image"><img src="../assets/img/Camisa Rosa SUBLIME.png" alt="Camisa Polo Rosa"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                    <div class="card-content"><h3>Camisa Polo Rosa - COLLECTION SUBLIME</h3><p class="product-desc">Delicada e expressiva, perfeita para momentos sutis.</p><p class="price">R$ 129,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
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

    <!-- Botão Voltar ao Topo -->
    <button id="backToTop" class="back-to-top"><span>↑</span></button>

    <!-- Scripts -->
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script>
</body>
</html>
