<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção Essencial</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
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
        <h1 class="page-title">Coleção Essencial</h1>
        <p class="page-subtitle">Descubra nossa coleção mais básica e versátil</p>
    </div>
</section>

<!-- Produtos -->
<section class="products-section">
    <div class="container">
        <!-- data-imgs = FOTOS FRENTE E VERSO -->
        <div class="products-grid">
            <div class="product-card" data-category="camisas"
                data-name="Camiseta Boxy Susanoo Preta" data-price="109.90" data-img="../assets/img/Camisa Boxy Susanoo.jpg"
                data-imgs="../assets/img/Camisa Boxy Susanoo.jpg|../assets/img/camisasusanoo.png" data-sizes="P|M|G|GG|XG"
                data-longdesc="Camiseta Boxy Susanoo Preta: Modelagem boxy, algodão premium, estampa minimalista, perfeita para o dia a dia.">
                <div class="card-image"><img src="../assets/img/Camisa Boxy Susanoo.jpg" alt="Camisa Boxy"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                <div class="card-content"><h3>Camiseta Boxy Susanoo Preta</h3><p class="product-desc">Camiseta da coleção Essentials cor preto e branco</p><p class="price">R$ 109,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
            </div>
            <!-- data-imgs = FOTOS FRENTE E VERSO -->
            <div class="product-card" data-category="camisas"
                data-name="Camiseta Regular Susanoo Branca" data-price="109.90" data-img="../assets/img/camisasusanoo.png"
                data-imgs="../assets/img/camisasusanoo.png|../assets/img/Camisa Boxy Susanoo.jpg" data-sizes="P|M|G|GG|XG"
                data-longdesc="Camiseta Regular Susanoo Branca: Algodão macio, caimento tradicional, detalhes exclusivos Susanoo.">
                <div class="card-image"><img src="../assets/img/camisasusanoo.png" alt="Camisa Essential"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                <div class="card-content"><h3>Camiseta Regular Susanoo Branca</h3><p class="product-desc">Camiseta da coleção Essentials cor branco e preto</p><p class="price">R$ 109,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
            </div>
            <div class="product-card" data-category="moletons"
                data-name="Moletom Essentials Susanoo Preto" data-price="149.90" data-img="../assets/img/Moletom_preto.jpeg"
                data-imgs="../assets/img/Moletom_preto.jpeg" data-sizes="P|M|G|GG|XG"
                data-longdesc="Moletom Essentials Susanoo Preto: Moletom felpado, capuz ajustável, conforto e estilo para o inverno.">
                <div class="card-image"><img src="../assets/img/Moletom_preto.jpeg" alt="Moletom Essential"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                <div class="card-content"><h3>Moletom Essentials Susanoo Preto</h3><p class="product-desc">Moletom da coleção Essentials preto e branco</p><p class="price">R$ 149,90</p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
            </div>
        </div>
    </div>
</section>

<!-- Rodapé -->
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
                    <a href="#">Instagram</a>
                    <a href="#">Facebook</a>
                    <a href="#">X</a>
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

<!-- Botão Voltar ao Topo -->
<button id="backToTop" class="back-to-top"><span>↑</span></button>

<script src="../js/script.js"></script>
<script src="../js/theme.js"></script>

</body>
</html>
